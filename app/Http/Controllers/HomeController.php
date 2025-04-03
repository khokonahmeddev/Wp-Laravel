<?php

namespace App\Http\Controllers;

use App\Models\Comment\Comment;
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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $position = $request->input('position');
        $formDate = $request->input('form_date');
        $toDate = $request->input('to_date');


        $entries = Entry::query()
            ->filters($search, $position, $formDate, $toDate)
            ->get();


        return view('home', compact('entries'));
    }

    public function comment($id)
    {
        $comments = Comment::query()
            ->with('user')
            ->where('entry_id', $id)
            ->get();

        return view('comment.index', compact('id', 'comments'));
    }

    public function commentStore(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comment::query()->create([
            'entry_id' => $id,
            'user_id' => auth()->id(),
            'body' => $request->comment
        ]);
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
