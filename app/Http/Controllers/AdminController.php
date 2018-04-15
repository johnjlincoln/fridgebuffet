<?php

/**
 * Admin Controller
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the Admin home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin/admin');
    }
}
