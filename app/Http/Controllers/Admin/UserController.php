<?php
// ====================================================================
// FILE: app/Http/Controllers/Admin/UserController.php
// ====================================================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::latest();

        if ($request->filled('role'))   $query->where('role', $request->role);
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($q) =>
                $q->where('firstname', 'like', "%{$term}%")
                  ->orWhere('surname', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
            );
        }

        $users = $query->withCount(['incidents', 'reports', 'comments'])->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['incidents' => fn ($q) => $q->latest()->limit(10), 'reports' => fn ($q) => $q->latest()->limit(10)]);

        return view('admin.users.show', compact('user'));
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin() && auth()->id() !== $user->id) {
            return back()->with('error', 'Cannot deactivate another Super Admin.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->is_active
            ? "User {$user->full_name} activated."
            : "User {$user->full_name} suspended.");
    }

    public function changeRole(Request $request, User $user): RedirectResponse
    {
        $request->validate(['role' => ['required', 'in:super_admin,moderator,user']]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role updated to {$user->role_label}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted.');
    }
}
