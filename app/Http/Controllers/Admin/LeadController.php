<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Models\LeadNote;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function add_lead()
    {
        return view('admin.lead.add_lead');
    }

    public function save_lead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'country' => 'nullable|string',
            'status' => 'required|string',
            'source' => 'nullable|string',
            'industry' => 'nullable|string',
            'tags' => 'nullable|string',
            // 'notes' => 'nullable|string',
            'attachments.*' => 'nullable|file',
        ]);

        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'country' => $validated['country'] ?? null,
            'status' => $validated['status'],
            'source' => $validated['source'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'tags' => $request->tags ? json_encode(explode(',', $request->tags)) : null,
            // 'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->notes != null) {
            $lead->lead_note()->create([
                'note' => $request->notes
            ]);
        }
        // Save attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lead_attachments', 'public');
                $lead->attachments()->create(['file_path' => $path]);
            }
        }
        return redirect()->route('Admin.LeadList')->with('status', 'Lead added successfully');
    }

    public function lead_list(Request $request)
    {
        $sort_by = $request->get('sort_by', 'id'); // default column
        $order = $request->get('order', 'desc');   // default order

        $leads = Lead::where('is_delete', '0');

        // Keyword filtering
        if (!empty($request->keyword)) {
            $leads->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                    ->orWhere('city', 'like', '%' . $request->keyword . '%');
            });
        }

        // Status filtering
        if (!empty($request->status)) {
            $leads->where('status', 'like', '%' . $request->status . '%');
        }

        // Sorting
        $leads = $leads->orderBy($sort_by, $order);

        // Pagination
        $leads = $leads->paginate(50)->appends($request->query());

        return view('admin.lead.lead_list', compact('leads', 'sort_by', 'order'));
    }


    public function view_lead($lid)
    {
        $lid = base64_decode($lid);
        $lead = Lead::where('id', $lid)->first();
        return view('admin.lead.view_lead', ['lead' => $lead]);
    }
    public function delete_lead($lid)
    {
        $lid = base64_decode($lid);
        $delete = Lead::where('id', $lid)->update([
            'is_delete' => 1
        ]);
        if ($delete) {
            return redirect()->back()->with('status', 'Lead deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }

    public function edit_lead($lid)
    {
        $lid = base64_decode($lid);
        $lead = Lead::where('id', $lid)->first();
        return view('admin.lead.edit_lead', ['lead' => $lead]);
    }
    public function delete_lead_image($iid)
    {
        $iid = base64_decode($iid);
        $get = LeadAttachment::find($iid);
        $filePath = public_path('storage/' . $get->file_path);
        if ($get && $filePath) {
            unlink($filePath);
            $delete = $get->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }
    public function update_lead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'country' => 'nullable|string',
            'status' => 'required|string',
            'source' => 'nullable|string',
            'industry' => 'nullable|string',
            'tags' => 'nullable|string',
            'lid' => 'required',
        ]);
        $lid = base64_decode($request->lid);
        $lead = Lead::findOrFail($lid); // Get the actual model instance

        $lead->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zip_code' => $validated['zip_code'] ?? null,
            'country' => $validated['country'] ?? null,
            'status' => $validated['status'],
            'source' => $validated['source'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'tags' => $request->tags ? json_encode(explode(',', $request->tags)) : null,
        ]);

        // Save attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lead_attachments', 'public');
                $lead->attachments()->create(['file_path' => $path]);
            }
        }
        return redirect()->back()->with('status', 'Lead updated successfully');
    }

    public function add_new_note(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'note' => 'required|string',
            'file_path' => 'nullable|file',
            'lead_id' => 'required'
        ]);

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('lead_attachments', 'public');
            $validate['file_path'] = $path;
        }

        $create = LeadNote::create($validate);
        if ($create) {
            return redirect()->back()->with('status', 'Note added successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }

}
