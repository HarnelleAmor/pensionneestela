<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        dd(Storage::allDirectories());
        // $files = Storage::disk('local')->files('')
    }
}
