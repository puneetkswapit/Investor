<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    /* ====================== Category Functions Start ========================== */

    public function add_category()
    {
        $categories = Category::where('status', '1')->where('parent', '0')->get();
        return view('admin.add_category', compact('categories'));
    }

    public function save_category(Request $request)
    {
        $validate = $request->validate([
            'category' => 'required|string'
        ]);
        $insert = Category::create([
            'category' => $request->category,
            'status' => 1,
        ]);
        if ($insert) {
            return redirect()->back()->with('status', 'Category added successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }

    public function save_subcategory(Request $request)
    {
        $validate = $request->validate([
            'subcategory' => 'required|string',
            'parentcategory' => 'required'
        ]);
        $insert = Category::create([
            'category' => $request->subcategory,
            'parent' => $request->parentcategory,
            'status' => 1,
        ]);
        if ($insert) {
            return redirect()->back()->with('status', 'Subcategory added successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }

    public function all_category()
    {
        $categories = Category::where('status', '1')->where('parent', '0')->get();
        return view('admin.all_category', compact('categories'));
    }

    public function edit_category(Request $request)
    {
        $validate = $request->validate([
            'category' => 'required|string',
            'category_id' => 'required'
        ]);

        $update = Category::where('id', $request->category_id)->update([
            'category' => $request->category
        ]);
        if ($update) {
            return redirect()->back()->with('status', 'Category updated successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }

    }

    public function delete_category($cid)
    {
        $delete = Category::where('id', $cid)->delete();
        if ($delete) {
            return redirect()->back()->with('status', 'Category deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong');
        }
    }
    /* ====================== Category Functions End ========================== */
}
