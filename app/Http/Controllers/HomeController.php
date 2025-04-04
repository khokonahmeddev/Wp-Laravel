<?php

namespace App\Http\Controllers;

use App\Models\Comment\Comment;
use App\Models\Submission\Submission;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $filters = [
            'search' => $request->input('search'),
            'position' => $request->input('position'),
            'form_date' => $request->input('form_date'),
            'to_date' => $request->input('to_date')
        ];

        $submissions = Submission::query()
            ->withCount('comments as total_comments')
            ->with(['values'])
            ->where('form_name', 'Career')
            ->when($filters['search'], fn($query) => $query->whereHas('values', fn($subQuery) => $subQuery->where('value', 'like', "%{$filters['search']}%")
            )
            )
            ->when($filters['position'], fn($query) => $query->whereHas('values', fn($subQuery) => $subQuery->where('value', $filters['position'])
            )
            )
            ->when($filters['form_date'] && $filters['to_date'], fn($query) => $query->whereBetween('created_at', [$filters['form_date'], $filters['to_date']])
            )
            ->orderByDesc('id')
            ->paginate(20);

        return view('home', compact('submissions'));
    }

    public function comment($id)
    {
        $comments = Comment::query()
            ->with('user')
            ->where('submission_id', $id)
            ->orderByDesc('id')
            ->get();

        return view('comment.index', compact('id', 'comments'));
    }

    public function commentStore(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comment::query()->create([
            'submission_id' => $id,
            'user_id' => auth()->id(),
            'body' => $request->comment
        ]);
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function changePassword()
    {
        return view('profile.change_password');
    }

    public function confirmPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password'
        ]);

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully!');
    }
}
