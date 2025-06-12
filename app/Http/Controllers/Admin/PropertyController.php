<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\RehabReasonList;
use App\Models\Property;
use App\Models\PropertyRehab;
use App\Models\RehabImage;
use App\Models\PropertyRehabStep;
use Illuminate\Support\Str;
use App\Models\PropertyMonthlyReport;
use Illuminate\Support\Facades\Storage;
class PropertyController extends Controller
{
    public function add_property()
    {
        $categories = Category::where('status', '1')->where('parent', '0')->get();
        return view('admin.add_property', compact('categories'));
    }

    public function get_subcategories(Request $request)
    {
        $categories = Category::where('status', '1')->where('parent', $request->catgid)->get();
        foreach ($categories as $category) {
            echo ' <option value="' . $category->id . '">' . $category->category . '</option>';
        }
    }

    public function save_property(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'closedate' => 'nullable',
            'yearbuilt' => 'nullable',
            'location' => 'required|string|max:255',
            'equityraise' => 'nullable|string|max:255',
            'minimuminvestment' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'occupancy' => 'nullable|string|max:255',
            'rehabrepairs' => 'nullable|string|max:255',
            'description' => 'nullable|string',

            'generalpartnershare' => 'nullable|numeric',
            'investorshare' => 'nullable|numeric',
            'website_url' => 'nullable|url',

            'purchaseprice' => 'required|string|max:255',
            'valueasrenovated' => 'nullable|string|max:255',
            'noiamount' => 'nullable|string|max:255',
            'noidescription' => 'nullable|string|max:255',

            'lender' => 'nullable|string|max:255',
            'loanamount' => 'nullable|string|max:255',
            'typeofloan' => 'nullable|string|max:255',
            'loanterm' => 'nullable|string|max:255',
            'interestrate' => 'nullable|string|max:255',
            'interestonly' => 'nullable|string|max:255',
            'interestonlyexpires' => 'nullable|string|max:255',
            'annualdebtservices1' => 'nullable|string|max:255',
            'interestonlyamount' => 'nullable|string|max:255',
            'annualdebtservices2' => 'nullable|string|max:255',
            'amortizedamount' => 'nullable|string|max:255',

            'asset_manager_line1' => 'nullable|string|max:255',
            'asset_manager_line2' => 'nullable|string|max:255',
            'asset_manager_line3' => 'nullable|string|max:255',

            'ownership_entity_line1' => 'nullable|string|max:255',
            'ownership_entity_line2' => 'nullable|string|max:255',
            'ownership_entity_line3' => 'nullable|string|max:255',

            'property_note' => 'nullable|string',
            'property_iframe' => 'nullable|string',

            'category' => 'required',

            'property_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('property_image')) {
            $imagePath = $request->file('property_image')->store('images/property_images', 'public');
            $validated['property_image'] = $imagePath;
        }
        $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name));
        $slug = trim($slug, '-');
        $old = Property::where('slug', $slug)->where('status', '1')->count();
        if ($old > 0) {
            return redirect()->back()->with('status', 'This slug is already in use');
        }
        $validated['status'] = 1;
        $validated['slug'] = $slug;

        if (!empty($request->subcategory)) {
            $subcatg = implode(',', $request->subcategory);
            $validated['sub_category'] = $subcatg;
        }
        $pid = Str::lower(Str::random(15));
        $validated['property_id'] = $pid;
        $property = Property::create($validated);
        if ($property) {
            return redirect()->back()->with('status', 'Property added successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }

    public function property_list()
    {
        $properties = Property::join('categories', 'categories.id', 'properties.category')
            ->where('properties.status', '1')
            ->orderBy('properties.order', 'asc')
            ->select('properties.*', 'categories.category as category_name')
            ->get();
        return view('admin.property_list', ['properties' => $properties]);
    }

    public function delete_property($pid)
    {
        $update = Property::where('property_id ', $pid)->update([
            'status' => 0
        ]);
        if ($update) {
            return redirect()->back()->with('status', 'Property deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }

    public function edit_property($pid)
    {
        $property = Property::where('property_id', $pid)->first();
        $categories = Category::where('status', '1')->where('parent', '0')->get();

        return view('admin.edit_property', ['property' => $property, 'categories' => $categories]);
    }

    public function update_property(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'closedate' => 'nullable',
            'yearbuilt' => 'nullable',
            'location' => 'required|string|max:255',
            'equityraise' => 'nullable|string|max:255',
            'minimuminvestment' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'occupancy' => 'nullable|string|max:255',
            'rehabrepairs' => 'nullable|string|max:255',
            'description' => 'nullable|string',

            'generalpartnershare' => 'nullable|numeric',
            'investorshare' => 'nullable|numeric',
            'website_url' => 'nullable|url',

            'purchaseprice' => 'required|string|max:255',
            'valueasrenovated' => 'nullable|string|max:255',
            'noiamount' => 'nullable|string|max:255',
            'noidescription' => 'nullable|string|max:255',

            'lender' => 'nullable|string|max:255',
            'loanamount' => 'nullable|string|max:255',
            'typeofloan' => 'nullable|string|max:255',
            'loanterm' => 'nullable|string|max:255',
            'interestrate' => 'nullable|string|max:255',
            'interestonly' => 'nullable|string|max:255',
            'interestonlyexpires' => 'nullable|string|max:255',
            'annualdebtservices1' => 'nullable|string|max:255',
            'interestonlyamount' => 'nullable|string|max:255',
            'annualdebtservices2' => 'nullable|string|max:255',
            'amortizedamount' => 'nullable|string|max:255',

            'asset_manager_line1' => 'nullable|string|max:255',
            'asset_manager_line2' => 'nullable|string|max:255',
            'asset_manager_line3' => 'nullable|string|max:255',

            'ownership_entity_line1' => 'nullable|string|max:255',
            'ownership_entity_line2' => 'nullable|string|max:255',
            'ownership_entity_line3' => 'nullable|string|max:255',

            'property_note' => 'nullable|string',
            'property_iframe' => 'nullable|string',

            'category' => 'required',

            'property_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('property_image')) {
            $imagePath = $request->file('property_image')->store('images/property_images', 'public');
            $validated['property_image'] = $imagePath;
        }

        if (!empty($request->subcategory)) {
            $subcatg = implode(',', $request->subcategory);
            $validated['sub_category'] = $subcatg;
        }

        $property = Property::where('property_id', $request->pp)->update($validated);
        if ($property) {
            return redirect()->back()->with('status', 'Property Updated successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }

    public function set_property_order()
    {
        $properties = Property::join('categories', 'categories.id', 'properties.category')
            ->where('properties.status', '1')
            ->orderBy('properties.order', 'asc')
            ->select('properties.*', 'categories.category as category_name')
            ->get();
        return view('admin.set_property_order', compact('properties'));
    }

    public function update_property_order(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Property::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
    }

    public function add_property_monthly_report()
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();

        return view('admin.property_monthly_report', compact('properties'));
    }

    public function save_property_monthly_report(Request $request)
    {
        $request->validate([
            'property' => 'required', // Adjust table/column as needed
            'propertytitle' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480', // max 20MB
            'date' => 'required',
        ]);
        $path = $request->file('file')->store('monthly_reports', 'public');
        $create = PropertyMonthlyReport::create([
            'property_id' => $request->property,
            'title' => $request->propertytitle,
            'file' => $path,
            'date' => $request->date,
        ]);
        if ($create) {
            return redirect()->back()->with('status', 'Report added successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }

    public function property_monthly_report_list(Request $request)
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        if ($request->isMethod('post')) {
            $request->validate([
                'property' => 'required'
            ]);
            $reports = PropertyMonthlyReport::where('property_id', $request->property)
                ->where('status', '1')
                ->get();
            return view('admin.property_monthly_report_list', compact('properties', 'reports'));
        } else {
            return view('admin.property_monthly_report_list', compact('properties'));
        }
    }

    public function delete_property_monthly_report($pid)
    {
        $pid = base64_decode($pid);
        $delete = PropertyMonthlyReport::where('id', $pid)->update([
            'status' => 0
        ]);
        if ($delete) {
            return redirect()->back()->with('status', 'Report deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }

    /////////////////////// Rehab Progress Code ////////////////////////////////////////

    public function add_property_rehab_progress()
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $reasons = RehabReasonList::get();
        return view('admin.add_property_rehab_progress', compact('properties', 'reasons'));
    }

    public function save_property_rehab_progress(Request $request)
    {
        $validate = $request->validate([
            'property_id' => 'required',
            'reason' => 'required'
        ]);

        if ($request->reason == 'Other') {
            $request->validate([
                'other_reason' => 'required',

            ]);
            session()->put('R_OReason', $request->other_reason);
            $validate['other_reason'] = $request->other_reason;
        }
        $rid = Str::lower(Str::random(10));
        $validate['rehab_id'] = $rid;
        session()->put('R_Pid', $request->property_id);
        session()->put('R_Reason', $request->reason);

        $check = PropertyRehab::where('property_id', $request->property_id)
            ->where('status', '1')
            ->where('percentage', '<', '100')
            ->count();
        if ($check > 0) {
            session()->put('RehabStatus', '1');
            session()->forget('RehabId');
            return 1;
        } else {
            $create = PropertyRehab::create($validate);
            session()->put('RehabStatus', '2');
            session()->put('RehabId', $create->id);
            return 2;
        }
    }

    public function new_rehab_progress()
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $reasons = RehabReasonList::get();

        if (session()->has('RehabStatus') && !session()->has('RehabId')) {
            $rid = Str::lower(Str::random(10));
            $create = PropertyRehab::create([
                'rehab_id' => $rid,
                'property_id' => session('R_Pid'),
                'reason' => session('R_Reason'),
                'other_reason' => session('R_OReason')
            ]);
            session()->put('RehabId', $create->id);
            session()->put('RehabStatus', '2');

            return view('admin.property_rehab_steps', compact('properties', 'reasons'));
        } elseif (session()->has('RehabStatus') && session('RehabStatus') == '2') {
            return view('admin.property_rehab_steps', compact('properties', 'reasons'));

        } else {
            return redirect()->route('AdminDashboard');
        }
    }

    public function save_rehab_progress(Request $request)
    {
        $request->validate([
            'progress_percent' => 'required|array',
            'progress_percent.*' => 'required|integer|min:0|max:100',

            'progress_title' => 'required|array',
            'progress_title.*' => 'required|string|max:255',

            'budgeted_amount' => 'required|array',
            'budgeted_amount.*' => 'required|string|max:255',

            'deadline' => 'required|array',
            'deadline.*' => 'required|date',

            'summary' => 'required|array',
            'summary.*' => 'required|string',

            // You can validate images like this:
            // 'images_file_0' => 'required|array',
            // 'images_file_0.*' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $rehab_id = session('RehabId');
        $count = count($request->progress_percent);
        $rehab_data = PropertyRehab::where('id', $rehab_id)->first();

        $progressPercent = $request->input('progress_percent'); // or $request->all()['progress_percent']
        $totalsum = end($progressPercent);

        $up = PropertyRehab::where('id', $rehab_id)->update([
            'percentage' => $totalsum
        ]);
        for ($x = 0; $x < $count; $x++) {
            $step = PropertyRehabStep::create([
                'rehab_id' => $rehab_id,
                'percentage' => $request->progress_percent[$x],
                'title' => $request->progress_title[$x],
                'amount' => $request->budgeted_amount[$x],
                'deadline' => $request->deadline[$x],
                'summary' => $request->summary[$x],
            ]);
            // 2. Save related images
            $imagesKey = 'images_file_' . $x;

            if ($request->hasFile($imagesKey)) {
                foreach ($request->file($imagesKey) as $file) {
                    $filename = $file->store('rehab_images', 'public');

                    RehabImage::create([
                        'rehab_id' => $rehab_id,
                        'step_id' => $step->id,
                        'image' => $filename,
                    ]);
                }
            }
        }
        session()->forget('RehabId');
        session()->forget('RehabStatus');
        session()->forget('R_OReason');
        session()->forget('R_Pid');
        session()->forget('R_Reason');
        return redirect()->route('Admin.RehabProgressList')->with('status', "Rehab progress added");
    }

    public function rehab_progress_list(Request $request)
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        if ($request->isMethod('post')) {
            $validate = $request->validate([
                'property' => 'required'
            ]);
            $rehabs = PropertyRehab::where('property_id', $request->property)->orderBy('id', 'desc')->where('status', '1')->get();
            return view('admin.rehab_progress_list', compact('properties', 'rehabs'));
        } else {
            return view('admin.rehab_progress_list', compact('properties'));
        }
    }

    public function edit_rehab_progress($rid)
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();
        $reasons = RehabReasonList::get();

        $rehab = PropertyRehab::where('rehab_id', $rid)->first();
        $steps = PropertyRehabStep::where('rehab_id', $rehab->id)->where('status', '1')->get();
        return view('admin.edit_rehab_progress', ['rehab' => $rehab, 'steps' => $steps, 'properties' => $properties, 'reasons' => $reasons]);
    }

    public function delete_rehab_progress_image($iid)
    {
        $get = RehabImage::find($iid);
        $filePath = public_path('storage/' . $get->image);
        if ($get && $filePath) {
            unlink($filePath);
            $delete = $get->delete();
            return redirect()->back()->with('status', '');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }

    }

    public function update_rehab_progress(Request $request)
    {
        $request->validate([
            'progress_percent' => 'required|array',
            'progress_percent.*' => 'required|integer|min:0|max:100',

            'progress_title' => 'required|array',
            'progress_title.*' => 'required|string|max:255',

            'budgeted_amount' => 'required|array',
            'budgeted_amount.*' => 'required|string|max:255',

            'deadline' => 'required|array',
            'deadline.*' => 'required|date',

            'summary' => 'required|array',
            'summary.*' => 'required|string',

            'rehab_id' => 'required',

        ]);

        $rehab_id = $request->rehab_id;

        $count = count($request->progress_percent);

        $rehab_data = PropertyRehab::where('id', $rehab_id)->first();
        $progressPercent = $request->input('progress_percent'); // or $request->all()['progress_percent']
        $totalsum = end($progressPercent);

        $up = PropertyRehab::where('id', $rehab_id)->update([
            'percentage' => $totalsum
        ]);

        // Track IDs received from request
        $incomingStepIds = [];

        // Save or update steps
        for ($x = 0; $x < $count; $x++) {
            $stepId = $request->step_id[$x]; // null if it's a new step
            $step = PropertyRehabStep::updateOrCreate(
                [
                    'id' => $stepId,
                ],
                [
                    'rehab_id' => $rehab_id,
                    'percentage' => $request->progress_percent[$x],
                    'title' => $request->progress_title[$x],
                    'amount' => $request->budgeted_amount[$x],
                    'deadline' => $request->deadline[$x],
                    'summary' => $request->summary[$x],
                ]
            );

            if ($step) {
                $incomingStepIds[] = $step->id;
            }

            // 2. Save related images
            $imagesKey = 'images_file_' . $x;

            if ($request->hasFile($imagesKey)) {
                foreach ($request->file($imagesKey) as $file) {
                    $filename = $file->store('rehab_images', 'public');

                    RehabImage::create([
                        'rehab_id' => $rehab_id,
                        'step_id' => $step->id,
                        'image' => $filename,
                    ]);
                }
            }
        }
        // Delete steps that are no longer in the request
        PropertyRehabStep::where('rehab_id', $rehab_id)
            ->whereNotIn('id', $incomingStepIds)
            ->delete();

        $images = RehabImage::where('rehab_id', $rehab_id)
            ->whereNotIn('step_id', $incomingStepIds)
            ->get();

        foreach ($images as $image) {
            $imagePath = public_path('storage/' . $image->image);

            // Delete the image file if it exists
            if ($imagePath ) {
                unlink($imagePath);
            }

            $image->delete();
        }

        return redirect()->back()->with('status', "Rehab progress successfully updated");
    }
    public function delete_rehab_progress($rid)
    {

        $delete = PropertyRehab::where('rehab_id', $rid)->update([
            'status' => 0
        ]);
        if ($delete) {
            return redirect()->back()->with('status', 'Report deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }
}





