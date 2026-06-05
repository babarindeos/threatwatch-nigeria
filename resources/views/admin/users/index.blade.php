{{-- ================================================================
     resources/views/admin/users/index.blade.php
     ================================================================ --}}
@extends('layouts.admin')
@section('title', 'Manage Users')
@section('page_title', 'Users')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    {{-- Filter bar --}}
    <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap items-center gap-3">
        <form method="GET" class="flex flex-wrap gap-3 flex-1">
            <select name="role" class="form-input text-xs py-1.5 w-36" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach(['super_admin'=>'Super Admin','moderator'=>'Moderator','user'=>'User'] as $val => $label)
                <option value="{{ $val }}" {{ request('role') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Name or email..." class="form-input text-xs py-1.5 flex-1 min-w-40">
            <button type="submit" class="btn-primary text-xs py-1.5 px-3">Search</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">User</th>
                    <th class="text-left px-3 py-3 hidden sm:table-cell">Role</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">Reports</th>
                    <th class="text-left px-3 py-3 hidden md:table-cell">Comments</th>
                    <th class="text-left px-3 py-3">Status</th>
                    <th class="text-left px-3 py-3 hidden lg:table-cell">Joined</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full border border-gray-100 object-cover flex-shrink-0"
                                 alt="{{ $user->full_name }}">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->full_name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3.5 hidden sm:table-cell">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full
                            {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-700' :
                               ($user->role === 'moderator' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600">{{ $user->incidents_count }}</span>
                    </td>
                    <td class="px-3 py-3.5 hidden md:table-cell">
                        <span class="text-xs text-gray-600">{{ $user->comments_count }}</span>
                    </td>
                    <td class="px-3 py-3.5">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full
                            {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->is_active ? 'Active' : 'Suspended' }}
                        </span>
                    </td>
                    <td class="px-3 py-3.5 hidden lg:table-cell">
                        <span class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2" x-data="{ open: false }">
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="text-xs font-bold text-ng-green hover:text-ng-dark transition-colors">View</a>
                            <div class="relative">
                                <button @click="open = !open" @click.outside="open = false"
                                        class="text-xs text-gray-400 hover:text-gray-600 transition-colors">⋯</button>
                                <div x-show="open"
                                     class="absolute right-0 mt-1 w-40 bg-white rounded-xl border border-gray-100 shadow-lg py-1 z-10">
                                    {{-- Toggle Status --}}
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                        @csrf @method('PATCH')
                                        <button class="w-full text-left text-xs px-3 py-2 hover:bg-gray-50 transition-colors
                                                       {{ $user->is_active ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $user->is_active ? 'Suspend User' : 'Activate User' }}
                                        </button>
                                    </form>
                                    {{-- Change Role --}}
                                    @foreach(['user'=>'Set as User','moderator'=>'Set as Moderator'] as $role => $label)
                                    @if($user->role !== $role)
                                    <form method="POST" action="{{ route('admin.users.change-role', $user) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="role" value="{{ $role }}">
                                        <button class="w-full text-left text-xs px-3 py-2 text-gray-600 hover:bg-gray-50 transition-colors">
                                            {{ $label }}
                                        </button>
                                    </form>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400 text-sm">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $users->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
