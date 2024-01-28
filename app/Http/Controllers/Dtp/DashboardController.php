<?php

namespace App\Http\Controllers\Dtp;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
		return view('dtp.dashboard');
    }
}
