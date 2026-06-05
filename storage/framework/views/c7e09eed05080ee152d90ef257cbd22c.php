<?php $__env->startSection('title', 'ThreatWatch Nigeria — Real-Time Security Incident Tracking'); ?>
<?php $__env->startSection('meta_description', 'Monitor and report security incidents across all 36 states of Nigeria. Real-time banditry, terrorism, kidnapping and armed robbery tracking.'); ?>

<?php $__env->startSection('content'); ?>


<section class="relative bg-gradient-to-br from-gray-950 via-gray-900 to-ng-dark overflow-hidden">

    
    <div class="absolute inset-0 opacity-[0.07]">
        <svg width="100%" height="100%"><defs><pattern id="grid" width="32" height="32" patternUnits="userSpaceOnUse"><path d="M 32 0 L 0 0 0 32" fill="none" stroke="#009A44" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
    </div>

    
    <div class="absolute right-0 top-0 h-full w-1 bg-ng-green opacity-60"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-28">
        <div class="max-w-3xl">

            
            <div class="inline-flex items-center gap-2 bg-ng-green/15 border border-ng-green/30
                        text-ng-light text-xs font-semibold px-4 py-2 rounded-full mb-6">
                <span class="w-2 h-2 bg-ng-light rounded-full pulse-live inline-block"></span>
                Live Monitoring — 36 States + FCT
            </div>

            <h1 class="font-display font-extrabold text-white text-4xl sm:text-5xl lg:text-6xl leading-[1.08] mb-5">
                Track Security Threats.<br>
                <span class="text-ng-green">Protect Nigeria.</span>
            </h1>

            <p class="text-gray-300 text-base sm:text-lg leading-relaxed mb-8 max-w-2xl">
                A civic-tech platform for real-time security incident reporting across Nigeria.
                Banditry, terrorism, kidnapping, armed robbery — document it, map it, act on it.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 mb-12">
                <a href="<?php echo e(route('reports.create')); ?>"
                   class="inline-flex items-center justify-center gap-2.5 bg-ng-green hover:bg-ng-light
                          text-white font-bold px-7 py-3.5 rounded-xl transition-colors
                          shadow-lg shadow-ng-green/30 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Report a Threat
                </a>
                <a href="<?php echo e(route('heatmap')); ?>"
                   class="inline-flex items-center justify-center gap-2.5 bg-white/10 hover:bg-white/[.15]
                          border border-white/20 text-white font-semibold px-7 py-3.5 rounded-xl
                          transition-colors text-sm backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    View Heatmap
                </a>
                <a href="<?php echo e(route('incidents.index')); ?>"
                   class="inline-flex items-center justify-center gap-2.5 bg-white/10 hover:bg-white/[.15]
                          border border-white/20 text-white font-semibold px-7 py-3.5 rounded-xl
                          transition-colors text-sm backdrop-blur-sm">
                    Browse Incidents
                </a>
            </div>

            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <?php $__currentLoopData = [
                    ['label' => 'Total Incidents',   'value' => number_format($stats['total_incidents']),      'icon' => '⚠️'],
                    ['label' => 'Total Casualties',   'value' => number_format($stats['total_casualties']),    'icon' => '💔'],
                    ['label' => 'Kidnap Victims',     'value' => number_format($stats['total_kidnapped']),     'icon' => '🚨'],
                    ['label' => 'This Month',         'value' => number_format($stats['incidents_this_month']),'icon' => '📅'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white/[.06] border border-white/10 rounded-xl px-4 py-3 backdrop-blur-sm">
                    <div class="text-lg font-display font-bold text-white"><?php echo e($s['icon']); ?> <?php echo e($s['value']); ?></div>
                    <div class="text-xs text-gray-400 mt-0.5"><?php echo e($s['label']); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>


<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    <div class="flex items-center justify-between mb-7">
        <div>
            <h2 class="font-display font-bold text-2xl text-gray-900">Latest Incidents</h2>
            <p class="text-sm text-gray-500 mt-1">Most recent verified security reports from across Nigeria</p>
        </div>
        <a href="<?php echo e(route('incidents.index')); ?>"
           class="hidden sm:flex items-center gap-1.5 text-sm font-semibold text-ng-green
                  hover:text-ng-dark transition-colors">
            View all
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <?php if($latestIncidents->isEmpty()): ?>
        <div class="text-center py-16 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p class="font-medium">No incidents reported yet.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php $__currentLoopData = $latestIncidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.incident-card', ['incident' => $incident], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-8 sm:hidden">
            <a href="<?php echo e(route('incidents.index')); ?>"
               class="inline-flex items-center gap-2 text-sm font-semibold text-ng-green hover:text-ng-dark transition-colors">
                View all incidents →
            </a>
        </div>
    <?php endif; ?>
</section>


<section class="bg-ng-muted py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-9">
            <h2 class="font-display font-bold text-2xl text-gray-900 mb-2">Browse by Threat Type</h2>
            <p class="text-sm text-gray-500">Filter incidents by category across Nigeria</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <?php $__currentLoopData = [
                ['type' => 'banditry',        'icon' => '🏴', 'label' => 'Banditry'],
                ['type' => 'terrorism',       'icon' => '💥', 'label' => 'Terrorism'],
                ['type' => 'kidnapping',      'icon' => '🚨', 'label' => 'Kidnapping'],
                ['type' => 'armed_robbery',   'icon' => '🔫', 'label' => 'Armed Robbery'],
                ['type' => 'communal_clash',  'icon' => '⚔️', 'label' => 'Communal Clash'],
                ['type' => 'herdsmen_attack', 'icon' => '🐄', 'label' => 'Herdsmen Attack'],
                ['type' => 'cult_clash',      'icon' => '🗡️', 'label' => 'Cult Clash'],
                ['type' => 'cybercrime',      'icon' => '💻', 'label' => 'Cybercrime'],
                ['type' => 'police_brutality','icon' => '🪖', 'label' => 'Police Brutality'],
                ['type' => 'missing_person',  'icon' => '🧍', 'label' => 'Missing Person'],
                ['type' => 'fire_outbreak',   'icon' => '🔥', 'label' => 'Fire Outbreak'],
                ['type' => 'other',           'icon' => '⚠️', 'label' => 'Other'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('incidents.index')); ?>?attack_type=<?php echo e($cat['type']); ?>"
               class="bg-white rounded-xl p-4 text-center border border-gray-100 hover:border-ng-green/40
                      hover:shadow-sm transition-all group">
                <div class="text-2xl mb-2"><?php echo e($cat['icon']); ?></div>
                <p class="text-xs font-semibold text-gray-600 group-hover:text-ng-green transition-colors leading-snug">
                    <?php echo e($cat['label']); ?>

                </p>
                <?php if(isset($attackTypeStats[$cat['type']])): ?>
                <p class="text-[10px] text-gray-400 mt-1"><?php echo e($attackTypeStats[$cat['type']]->total); ?> cases</p>
                <?php endif; ?>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

        <div>
            <h2 class="font-display font-bold text-2xl text-gray-900 mb-2">Most Affected States</h2>
            <p class="text-sm text-gray-500 mb-7">States with the highest number of recorded security incidents</p>

            <div class="space-y-3">
                <?php $__currentLoopData = $topStates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $maxCount = $topStates->first()->incident_count ?: 1; ?>
                <div class="flex items-center gap-4">
                    <span class="w-6 text-sm font-bold text-gray-400 text-right flex-shrink-0"><?php echo e($index + 1); ?></span>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1.5">
                            <a href="<?php echo e(route('incidents.index')); ?>?state_id=<?php echo e($state->id); ?>"
                               class="text-sm font-semibold text-gray-800 hover:text-ng-green transition-colors">
                                <?php echo e($state->name); ?>

                            </a>
                            <span class="text-xs font-bold text-gray-500"><?php echo e($state->incident_count); ?></span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-ng-green rounded-full transition-all duration-700"
                                 style="width: <?php echo e(($state->incident_count / $maxCount) * 100); ?>%"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <a href="<?php echo e(route('heatmap')); ?>"
               class="inline-flex items-center gap-2 mt-7 text-sm font-semibold text-ng-green
                      hover:text-ng-dark transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                View full heatmap →
            </a>
        </div>

        
        <div class="bg-gray-900 rounded-2xl overflow-hidden h-72 sm:h-80 relative">
            <div id="home-mini-map" class="w-full h-full"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent pointer-events-none"></div>
            <a href="<?php echo e(route('heatmap')); ?>"
               class="absolute bottom-4 right-4 bg-ng-green hover:bg-ng-dark text-white text-xs
                      font-bold px-4 py-2 rounded-lg transition-colors shadow-lg">
                Open Full Heatmap →
            </a>
        </div>
    </div>
</section>


<section class="bg-gray-900 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-display font-bold text-2xl text-white mb-2">How ThreatWatch Works</h2>
            <p class="text-sm text-gray-400">Simple, anonymous, and impactful</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <?php $__currentLoopData = [
                ['step'=>'01','icon'=>'📝','title'=>'Submit Your Report',
                 'desc'=>'Fill in incident details: location, type, severity, and attach evidence. You can remain completely anonymous.'],
                ['step'=>'02','icon'=>'🔍','title'=>'Admin Verification',
                 'desc'=>'Our moderation team reviews your report for accuracy and credibility before it goes live.'],
                ['step'=>'03','icon'=>'🗺️','title'=>'Live on the Map',
                 'desc'=>'Verified incidents appear on the national heatmap, alerting communities and security agencies.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="text-center">
                <div class="inline-flex w-14 h-14 items-center justify-center bg-ng-green/20
                            border border-ng-green/30 rounded-2xl text-2xl mb-4">
                    <?php echo e($step['icon']); ?>

                </div>
                <div class="inline-block bg-ng-green text-white text-xs font-bold px-2.5 py-0.5 rounded-full mb-3">
                    STEP <?php echo e($step['step']); ?>

                </div>
                <h3 class="font-display font-bold text-white text-base mb-2"><?php echo e($step['title']); ?></h3>
                <p class="text-sm text-gray-400 leading-relaxed"><?php echo e($step['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="bg-gradient-to-r from-ng-dark to-ng-green py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="font-display font-bold text-white text-xl mb-1">🚨 Emergency? Call Now</h2>
                <p class="text-ng-100 text-sm">If you are in immediate danger, contact emergency services immediately.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <?php $__currentLoopData = ['🚔 Police: 199','🔥 Fire: 01-272-0892','🚑 Ambulance: 0700-2625226','🛡️ DSS: 08057000001']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white/20 border border-white/30 backdrop-blur-sm text-white
                            text-xs font-bold px-4 py-2.5 rounded-xl"><?php echo e($line); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <a href="<?php echo e(route('helplines')); ?>"
               class="flex-shrink-0 bg-white text-ng-dark font-bold text-sm px-5 py-2.5
                      rounded-xl hover:bg-ng-100 transition-colors">
                All Helplines →
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('head_styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Mini home map
(function () {
    const map = L.map('home-mini-map', {
        zoomControl: false,
        scrollWheelZoom: false,
        dragging: false,
        doubleClickZoom: false,
        attributionControl: false,
    }).setView([9.0820, 8.6753], 5);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 18,
    }).addTo(map);

    // Fetch and plot approved incidents with coords
    fetch('<?php echo e(route("api.heatmap.data")); ?>')
        .then(r => r.json())
        .then(data => {
            data.forEach(function(inc) {
                const colors = { critical: '#ef4444', high: '#f97316', medium: '#f59e0b', low: '#22c55e' };
                const color  = colors[inc.severity] || '#009A44';

                L.circleMarker([inc.lat, inc.lng], {
                    radius: inc.severity === 'critical' ? 8 : inc.severity === 'high' ? 6 : 4,
                    fillColor: color,
                    color: 'white',
                    weight: 1,
                    opacity: 0.9,
                    fillOpacity: 0.8,
                }).addTo(map);
            });
        })
        .catch(() => {}); // silent fail on no data
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/home.blade.php ENDPATH**/ ?>