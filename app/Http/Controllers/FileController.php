<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload()
    {
        return view('library.index');
    }

    public function download()
    {
        return view('library.index');
    }
}
