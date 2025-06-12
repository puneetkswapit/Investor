<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use App\Models\Property;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\InvestorProperty;
use App\Models\PartnerProperty;
use App\Models\UserPersonalReport;
use App\Mail\UserRegisterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Helpers\UserHelper;
use App\Exports\Summary;
use App\Models\Permission;
use App\Models\PermissionUser;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function add_user()
    {
        $properties = Property::join('categories', 'categories.id', 'properties.category')
            ->where('properties.status', '1')
            ->orderBy('properties.order', 'asc')
            ->select('properties.*', 'categories.category as category_name')
            ->get();
        return view('admin.add_user', compact('properties'));
    }

    public function save_user(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'useremail' => 'required',
            'usertype' => 'required'
        ]);
        $randomPassword = Str::random(8);
        $password = Hash::make($randomPassword);
        $investor = false;
        $partner = false;
        $tags = implode(',', $request->tags);
        $subscriber = implode(',', $request->subscriber);
        $usertype = $request->usertype;
        $mail = $request->mail;
        $user = User::create([
            'name' => $request->username,
            'email' => $request->useremail,
            'password' => $password,
            'role' => '2',
            'status' => '1',
            'mobile' => $request->phonenumber
        ]);
        if (in_array('1', $usertype)) {
            $investor = true;
            $investorids = $request->investorproperty;
            if (!empty($investorids)) {
                foreach ($investorids as $propid) {
                    InvestorProperty::create([
                        'user_id' => $user->id,
                        'property_id' => $propid,
                        'status' => '1'
                    ]);
                }
            }
        }
        if (in_array('2', $usertype)) {
            $partner = true;
            $partnerids = $request->partnerproperty;
            if (!empty($partnerids)) {
                foreach ($partnerids as $investid) {
                    PartnerProperty::create([
                        'user_id' => $user->id,
                        'property_id' => $investid,
                        'status' => '1'
                    ]);
                }
            }
        }
        $user_details = UserDetail::create([
            'user_id' => $user->id,
            'alt_phone' => $request->altphonenumber,
            'mailing_address' => $request->mailingaddress,
            'city' => $request->usercity,
            'state' => $request->userstate,
            'zip_code' => $request->zipcode,
            'investor' => $investor,
            'partner' => $partner,
            'tags' => $tags,
            'subscriber' => $subscriber,
        ]);

        if ($mail == 1) {
            $email = $request->useremail;
            $data = [
                'email' => $email,
                'name' => $request->username,
                'password' => $randomPassword
            ];
            Mail::to('puneetk.swapit@gmail.com')->send(new UserRegisterMail($data));
        }
        return redirect()->back()->with('status', 'User added successfully');
    }

    public function user_list()
    {
        $partnerusers = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.status', '1')
            ->where('role', '2')
            ->where('partner', '1')
            ->get();
        $invsetorusers = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.status', '1')
            ->where('role', '2')
            ->where('investor', '1')
            ->get();
        return view('admin.user_list', compact('partnerusers', 'invsetorusers'));
    }

    public function user_search(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.status', '1')
            ->where('role', '2')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->get();
        return view('admin.user_search', compact('users'));
    }

    public function delete_user($uid)
    {
        $update = User::where('id', $uid)->update([
            'status' => '0'
        ]);
        if ($update) {
            return redirect()->back()->with('status', 'User successfully deleted');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }

    public function edit_user($uid)
    {
        $uid = base64_decode($uid);
        $user = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.id', $uid)
            ->first();
        $properties = Property::join('categories', 'categories.id', 'properties.category')
            ->where('properties.status', '1')
            ->orderBy('properties.order', 'asc')
            ->select('properties.*', 'categories.category as category_name')
            ->get();
        $investorprop = InvestorProperty::where('user_id', $uid)->get();
        $partnerprop = PartnerProperty::where('user_id', $uid)->get();
        return view('admin.edit_user', ['user' => $user, 'investorprop' => $investorprop, 'partnerprop' => $partnerprop, 'properties' => $properties]);
    }

    public function update_user(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'useremail' => 'required',
            'usertype' => 'required'
        ]);
        $uid = base64_decode($request->uid);
        $investor = false;
        $partner = false;
        $tags = implode(',', array_filter($request->tags));
        $subscriber = implode(',', array_filter($request->subscriber));

        $usertype = $request->usertype;
        $user = User::where('id', $uid)
            ->update([
                'name' => $request->username,
                'email' => $request->useremail,
                'mobile' => $request->phonenumber
            ]);
        if (in_array('1', $usertype)) {
            $investor = true;
            $investorids = $request->investorproperty;
            InvestorProperty::where('user_id', $uid)->delete();
            if (!empty($investorids)) {
                foreach ($investorids as $propid) {
                    InvestorProperty::create([
                        'user_id' => $uid,
                        'property_id' => $propid,
                        'status' => '1'
                    ]);
                }
            }
        }
        if (in_array('2', $usertype)) {
            $partner = true;
            $partnerids = $request->partnerproperty;
            PartnerProperty::where('user_id', $uid)->delete();
            if (!empty($partnerids)) {
                foreach ($partnerids as $investid) {
                    PartnerProperty::create([
                        'user_id' => $uid,
                        'property_id' => $investid,
                        'status' => '1'
                    ]);
                }
            }
        }

        $user_details = UserDetail::where('user_id', $uid)
            ->update([
                'alt_phone' => $request->altphonenumber,
                'mailing_address' => $request->mailingaddress,
                'city' => $request->usercity,
                'state' => $request->userstate,
                'zip_code' => $request->zipcode,
                'investor' => $investor,
                'partner' => $partner,
                'tags' => $tags,
                'subscriber' => $subscriber,
            ]);
        return redirect()->back()->with('status', 'User updated successfully');
    }

    public function user_summary_report(Request $request)
    {
        $allusers = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.status', '1')
            ->where('users.role', '2')
            ->where('user_details.investor', '1')
            ->get();
        $properties = Property::where('status', 1)->get();

        if ($request->isMethod('post')) {
            $name = $request->name;
            $prop = $request->property;
            $users = User::join('user_details', 'user_details.user_id', '=', 'users.id')
                ->where('users.status', '1')
                ->where('role', '2');
            if ($name != 'all') {
                $users->where('users.id', $name);
            }
            $users = $users->get();

            session(['filtered_users' => $users]);
            return view('admin.user_summary_report', ['allusers' => $allusers, 'properties' => $properties, 'users' => $users,]);
        }
        if ($request->isMethod('get')) {
            return view('admin.user_summary_report', compact('allusers', 'properties'));
        }
    }

    public function add_user_personal_report()
    {
        $allusers = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.status', '1')
            ->where('users.role', '2')
            ->get();

        return view('admin.add_user_personal_report', compact('allusers'));
    }

    public function get_user_properties(Request $request)
    {
        $props = UserHelper::user_property($request->uid);
        echo '<option value="">Choice Property</option>';
        foreach ($props as $prop) {
            echo '<option value="' . $prop->property_id . '">' . $prop->name . '</option>';
        }
    }

    public function save_user_personal_report(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'property' => 'required', // Adjust table/column as needed
            'propertytitle' => 'required|string|max:255',
            'reporttype' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480', // max 20MB
            'date' => 'required',
        ]);
        $path = $request->file('file')->store('personal_reports', 'public');

        $create = UserPersonalReport::create([
            'user_id' => $request->name,
            'property_id' => $request->property,
            'title' => $request->propertytitle,
            'type' => $request->reporttype,
            'report_date' => $request->date,
            'file' => $path,
        ]);

        if ($create) {
            return redirect()->back()->with('status', 'Report added successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }

    public function view_user_personal_report(Request $request)
    {
        $allusers = User::join('user_details', 'user_details.user_id', 'users.id')
            ->where('users.status', '1')
            ->where('users.role', '2')
            ->where('user_details.investor', '1')
            ->get();

        if ($request->isMethod('post')) {
            $request->validate([
                'uid' => 'required'
            ]);
            $reports = UserPersonalReport::join('properties', 'properties.property_id', 'user_personal_reports.property_id')
                ->where('user_personal_reports.user_id', $request->uid)
                ->where('user_personal_reports.status', '1')
                ->get();
            $userdata = User::find($request->uid);
            return view('admin.user_personal_reports', ['allusers' => $allusers, 'uid' => $request->uid, 'userdata' => $userdata, 'reports' => $reports]);
        } else {
            return view('admin.user_personal_reports', compact('allusers'));
        }
    }

    public function delete_user_personal_report($rid)
    {
        $rid = base64_decode($rid);
        $delete = UserPersonalReport::where('id', $rid)->update([
            'status' => 0
        ]);
        if ($delete) {
            return redirect()->back()->with('status', 'Report deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }
    }

    public function user_summary_export()
    {
        $filtered = session('filtered_users');

        if (!$filtered || count($filtered) == 0) {
            return redirect()->back()->with('error', 'No data to export.');
        }
        return Excel::download(new Summary($filtered), 'user_summary.xlsx');
    }

    public function change_password()
    {
        return view('admin.change_password');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'currentpassword' => ['required'],
            'newpassword' => ['required', 'min:6', 'different:currentpassword'],
            'confirmpassword' => ['required', 'same:newpassword'],
        ]);
        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->currentpassword, $user->password)) {
            return back()->withErrors(['currentpassword' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->newpassword);
        $user->save();
        return back()->with('status', 'Password updated successfully.');
    }

    public function user_permission($uid)
    {
        $uid = base64_decode($uid);
        $permissions = PermissionCategory::get();
        $userpermissions = PermissionUser::where('user_id', $uid)->get();
        return view('admin.user_permission', ['permissions' => $permissions, 'userpermissions' => $userpermissions]);
    }

    public function user_permission_update(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $uid = base64_decode($request->user_id);
        $selectedPermissions = $request->input('permissions', []);
        PermissionUser::where('user_id', $uid)->delete();
        foreach ($selectedPermissions as $permission_id) {
            PermissionUser::create([
                'user_id' => $uid,
                'permission_id' => $permission_id,
            ]);
        }
        return redirect()->back()->with('status', 'Permissions updated successfully.');
    }

}
