{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')
@section('title', 'Create Account — ThreatWatch Nigeria')
@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">

        {{-- Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 bg-ng-green rounded-2xl items-center justify-center shadow-lg mb-4">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="font-display font-bold text-2xl text-gray-900">Join ThreatWatch Nigeria</h1>
            <p class="text-sm text-gray-500 mt-1">Help keep communities safe by reporting threats</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name row --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="firstname" value="{{ old('firstname') }}"
                               required placeholder="Chukwuemeka"
                               class="form-input @error('firstname') border-red-400 @enderror border border-gray-800 rounded-lg py-2 px-2">
                        @error('firstname') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Surname <span class="text-red-500">*</span></label>
                        <input type="text" name="surname" value="{{ old('surname') }}"
                               required placeholder="Okafor"
                               class="form-input @error('surname') border-red-400 @enderror border border-gray-800 rounded-lg py-2 px-2">
                        @error('surname') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required placeholder="you@example.com"
                           class="form-input @error('email') border-red-400 @enderror border border-gray-800 rounded-lg w-full px-2 py-2 focus-ring:border-green-700">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="form-label">Phone Number <span class="text-gray-400 text-xs font-normal">(optional)</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           placeholder="+234 800 000 0000"
                           class="form-input @error('phone') border-red-400 @enderror">
                    @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="form-label">Password <span class="text-red-500">*</span></label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password"
                               required placeholder="Min. 8 characters with uppercase and numbers"
                               class="form-input pr-10 @error('password') border-red-400 @enderror w-full border border-gray-800">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="form-label">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation"
                           required placeholder="Repeat password"
                           class="form-input">
                </div>

                {{-- Terms --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-800">
                    ⚠️ By registering, you agree to report only genuine security incidents. False reports are a criminal offense under Nigerian law.
                </div>

                <button type="submit"
                        class="btn-primary w-full text-sm py-2.5 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Create Account
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-5">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-ng-green hover:text-ng-dark transition-colors">
                Sign in →
            </a>
        </p>
    </div>
</div>
@endsection
