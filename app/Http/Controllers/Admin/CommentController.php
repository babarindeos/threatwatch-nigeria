<?php
// ====================================================================
// FILE: app/Http/Controllers/Admin/CommentController.php
// ====================================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Comment::with(['user', 'incident'])->latest();

        if ($request->filled('status')) $query->where('status', $request->status);

        $comments = $query->paginate(25)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Comment approved.');
    }

    public function reject(Comment $comment): RedirectResponse
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'Comment rejected.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
