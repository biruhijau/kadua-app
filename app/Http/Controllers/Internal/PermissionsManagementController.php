<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PermissionsManagementController extends Controller
{
    public function index(): View
    {
        return view('pages.internal.permissions.index');
    }
}
