<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('ckeditor', $filename, 'public');

            $url = asset('storage/ckeditor/' . $filename);

            $funcNum = $request->input('CKEditorFuncNum');

            $message = 'Image uploaded successfully';

            return response("
                <script>
                    window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');
                </script>
            ");
        }
    }
}
