<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBackupController extends Controller
{
    public function index()
    {
        $data = [];
        return view('admin.backup.index', compact('data'));
    }
}
