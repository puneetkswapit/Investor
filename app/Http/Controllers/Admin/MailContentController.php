<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MailContent;
use Illuminate\Http\Request;

class MailContentController extends Controller
{
    public function mail_content()
    {
        $data = MailContent::first();
        return view('admin.mail_content', ['data' => $data]);
    }

    public function save_mail_content(Request $request)
    {
        $update = MailContent::updateOrCreate(
            ['id' => 1], // Find by ID
            [
                'content_1' => $request->header_note,
                'content_2' => $request->footer_note
            ] // Update or create with these values
        );

        if ($update) {
            return redirect()->back()->with('status', 'Mail content updated successfully');
        } else {
            return redirect()->back()->with('status', 'Something went wrong!');
        }

    }
}
