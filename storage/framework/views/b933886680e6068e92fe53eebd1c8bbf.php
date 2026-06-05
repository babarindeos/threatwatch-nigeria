
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> — ThreatWatch Nigeria</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ng: { green: '#009A44', dark: '#006B2F', light: '#00C453', muted: '#E8F7EE', 50: '#f0fdf6', 100: '#dcfce9' }
                    },
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body:    ['"Inter"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1,h2,h3,h4,h5,.font-display { font-family: 'Space Grotesk', sans-serif; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #009A44; border-radius: 4px; }

        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 12px;
            font-size: 0.8125rem; font-weight: 500; color: #6b7280;
            transition: all .15s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: #E8F7EE; color: #009A44;
        }
        .sidebar-link.active { font-weight: 600; }
        .sidebar-link svg { width: 16px; height: 16px; flex-shrink: 0; }

        .severity-low      { background:#dcfce7; color:#166534; border: 1px solid #bbf7d0; }
        .severity-medium   { background:#fef9c3; color:#854d0e; border: 1px solid #fef08a; }
        .severity-high     { background:#ffedd5; color:#9a3412; border: 1px solid #fed7aa; }
        .severity-critical { background:#fee2e2; color:#991b1b; border: 1px solid #fecaca; }

        .status-pending  { background:#fef9c3; color:#854d0e; border: 1px solid #fef08a; }
        .status-approved { background:#dcfce7; color:#166534; border: 1px solid #bbf7d0; }
        .status-rejected { background:#fee2e2; color:#991b1b; border: 1px solid #fecaca; }
        .status-reviewed { background:#dbeafe; color:#1e40af; border: 1px solid #bfdbfe; }

        .stat-card { background:white; border-radius:16px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); }
        .btn-primary { background:#009A44; color:white; font-weight:600; font-size:.8125rem; padding: 8px 16px; border-radius:10px; transition:background .15s; }
        .btn-primary:hover { background:#006B2F; }
        .btn-danger { background:#ef4444; color:white; font-weight:600; font-size:.8125rem; padding: 8px 16px; border-radius:10px; transition:background .15s; }
        .btn-danger:hover { background:#b91c1c; }
        .form-input {
            width:100%; border:1px solid #e5e7eb; border-radius:10px;
            padding: 9px 13px; font-size:.875rem; color:#111827;
            outline:none; transition: border-color .15s, box-shadow .15s;
        }
        .form-input:focus { border-color:#009A44; box-shadow: 0 0 0 3px rgba(0,154,68,.1); }
        .form-label { display:block; font-size:.8125rem; font-weight:600; color:#374151; margin-bottom:6px; }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 antialiased" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">

    
    <aside id="sidebar"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 w-60 bg-white border-r border-gray-100
                  flex flex-col transition-transform duration-200 ease-in-out lg:relative lg:flex">

        
        <div class="flex items-center gap-2.5 px-4 h-16 border-b border-gray-100 flex-shrink-0">
            <div class="w-8 h-8 bg-ng-green rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="font-display font-bold text-gray-900 text-sm leading-none truncate">ThreatWatch NG</p>
                <p class="text-[10px] text-ng-green font-semibold tracking-wider uppercase mt-0.5">Admin Panel</p>
            </div>
        </div>

        
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 mb-2">Overview</p>

            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pt-4 pb-1.5">Content</p>

            <a href="<?php echo e(route('admin.incidents.index')); ?>"
               class="sidebar-link <?php echo e(request()->routeIs('admin.incidents.*') ? 'active' : ''); ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Incidents
                <?php $pendingCount = \App\Models\Incident::pending()->count(); ?>
                <?php if($pendingCount): ?>
                <span class="ml-auto text-[10px] bg-red-500 text-white rounded-full px-1.5 py-0.5 font-bold leading-none">
                    <?php echo e($pendingCount > 99 ? '99+' : $pendingCount); ?>

                </span>
                <?php endif; ?>
            </a>

            <a href="<?php echo e(route('admin.reports.index')); ?>"
               class="sidebar-link <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                User Reports
                <?php $pendingReports = \App\Models\Report::pending()->count(); ?>
                <?php if($pendingReports): ?>
                <span class="ml-auto text-[10px] bg-amber-500 text-white rounded-full px-1.5 py-0.5 font-bold leading-none">
                    <?php echo e($pendingReports > 99 ? '99+' : $pendingReports); ?>

                </span>
                <?php endif; ?>
            </a>

            <a href="<?php echo e(route('admin.comments.index')); ?>"
               class="sidebar-link <?php echo e(request()->routeIs('admin.comments.*') ? 'active' : ''); ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Comments
            </a>

            <a href="<?php echo e(route('admin.helplines.index')); ?>"
               class="sidebar-link <?php echo e(request()->routeIs('admin.helplines.*') ? 'active' : ''); ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Helplines
            </a>

            <?php if(auth()->user()->isSuperAdmin()): ?>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pt-4 pb-1.5">Administration</p>

            <a href="<?php echo e(route('admin.users.index')); ?>"
               class="sidebar-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            <?php endif; ?>

            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 pt-4 pb-1.5">Public</p>

            <a href="<?php echo e(route('home')); ?>" target="_blank" class="sidebar-link">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Public Site
            </a>
        </nav>

        
        <div class="px-3 py-3 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <img src="<?php echo e(auth()->user()->avatar_url); ?>"
                     class="w-8 h-8 rounded-full border border-ng-100 flex-shrink-0 object-cover"
                     alt="<?php echo e(auth()->user()->full_name); ?>">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-gray-900 truncate"><?php echo e(auth()->user()->full_name); ?></p>
                    <p class="text-[10px] text-gray-400 capitalize"><?php echo e(auth()->user()->role_label); ?></p>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button title="Sign out" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

    
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        
        <header class="h-16 bg-white border-b border-gray-100 flex items-center px-4 sm:px-6 gap-4 flex-shrink-0 z-10">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="flex-1 min-w-0">
                <h1 class="font-display font-bold text-gray-900 text-base sm:text-lg truncate">
                    <?php echo $__env->yieldContent('page_title', 'Dashboard'); ?>
                </h1>
                <?php if (! empty(trim($__env->yieldContent('page_breadcrumb')))): ?>
                <p class="text-xs text-gray-400 mt-0.5"><?php echo $__env->yieldContent('page_breadcrumb'); ?></p>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-3">
                
                <span class="hidden sm:block text-xs text-gray-400"><?php echo e(now()->format('D, d M Y')); ?></span>

                
                <?php $newPending = \App\Models\Incident::pending()->count() + \App\Models\Report::pending()->count(); ?>
                <?php if($newPending > 0): ?>
                <div class="relative">
                    <a href="<?php echo e(route('admin.incidents.index')); ?>?status=pending"
                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </a>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px]
                                 font-bold rounded-full flex items-center justify-center">
                        <?php echo e(min($newPending, 9)); ?><?php echo e($newPending > 9 ? '+' : ''); ?>

                    </span>
                </div>
                <?php endif; ?>
            </div>
        </header>

        
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">

            
            <?php if(session('success')): ?>
            <div class="mb-4 bg-ng-muted border border-ng-green/30 text-ng-dark rounded-xl px-4 py-3
                        flex items-center gap-3 text-sm font-medium">
                <svg class="w-4 h-4 text-ng-green flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3
                        flex items-center gap-3 text-sm font-medium">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/layouts/admin.blade.php ENDPATH**/ ?>