<?php

namespace App\Http\Controllers\User;
use App\Models\Category;
use App\Models\Property;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\PropertyMonthlyReport;
use App\Helpers\UserHelper;
class PartnerPropertyController extends Controller
{
    public function add_property()
    {
        $categories = Category::where('status', '1')->where('parent', '0')->get();
        return view('user.add_property', compact('categories'));
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
        return view('user.property_list', ['properties' => $properties]);
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

        return view('user.edit_property', ['property' => $property, 'categories' => $categories]);
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
    public function get_user_properties(Request $request)
    {
        $props = UserHelper::user_property($request->uid);
        echo '<option value="">Choice Property</option>';
        foreach ($props as $prop) {
            echo '<option value="' . $prop->property_id . '">' . $prop->name . '</option>';
        }
    }
    public function add_property_monthly_report()
    {
        $properties = Property::where('status', '1')
            ->orderBy('order', 'asc')
            ->get();

        return view('user.property_monthly_report', compact('properties'));
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
        $user = Auth::user();
        $properties = UserHelper::user_property($user->id);
        if ($request->isMethod('post')) {
            $request->validate([
                'property' => 'required'
            ]);
            $reports = PropertyMonthlyReport::where('property_id', $request->property)
                ->where('status', '1')
                ->get();
            return view('user.property_monthly_report_list', compact('properties', 'reports'));
        } else {
            return view('user.property_monthly_report_list', compact('properties'));
        }
    }
}
