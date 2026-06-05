<?php
// ============================================================
// FILE: app/Http/Controllers/CommentController.php
// ============================================================

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Incident;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Incident $incident): RedirectResponse
    {
        $request->validate([
            'comment'   => ['required', 'string', 'min:3', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        Comment::create([
            'user_id'     => auth()->id(),
            'incident_id' => $incident->id,
            'parent_id'   => $request->parent_id,
            'comment'     => $request->comment,
            'status'      => 'approved', // Auto-approve; admin can moderate
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        // Only owner or moderator can delete
        if (auth()->id() !== $comment->user_id && ! auth()->user()->isModerator()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
