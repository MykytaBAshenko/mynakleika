<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

/**
 * Class PayerController
 * @package App\Http\Controllers\Backend
 */
class PayerController extends Controller
{
    public function index()
    {
        return view('backend.payers.index');
    }
}
