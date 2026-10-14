<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RoleManagementController extends Controller
{
    public function index(): View
    {
        return view('pages.internal.role.index');
    }
}
