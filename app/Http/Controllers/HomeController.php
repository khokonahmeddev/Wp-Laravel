<?php

namespace App\Http\Controllers;

use App\Models\Entry\Entry;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        $search = $request->input('search');
        $position = $request->input('position');
        $entries = Entry::query()->filters($search, $position)->get();

        return view('home', compact('entries'));
    }
}
