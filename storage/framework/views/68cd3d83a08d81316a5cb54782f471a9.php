<?php $__env->startSection('title', $incident->title . ' — ThreatWatch Nigeria'); ?>
<?php $__env->startSection('meta_description', $incident->short_description); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-ng-green transition-colors">Home</a>
        <span>/</span>
        <a href="<?php echo e(route('incidents.index')); ?>" class="hover:text-ng-green transition-colors">Incidents</a>
        <span>/</span>
        <span class="text-gray-600 truncate max-w-xs"><?php echo e(Str::limit($incident->title, 50)); ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        
        <div class="lg:col-span-2 space-y-6">

            
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex text-xs font-bold px-3 py-1.5 rounded-lg severity-<?php echo e($incident->severity); ?>">
                    ⚡ <?php echo e(strtoupper($incident->severity)); ?>

                </span>
                <span class="inline-flex text-xs font-bold px-3 py-1.5 rounded-lg status-<?php echo e($incident->status); ?>">
                    <?php echo e(strtoupper($incident->status)); ?>

                </span>
                <span class="inline-flex text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600">
                    <?php echo e($incident->attack_type_label); ?>

                </span>
                <?php if($incident->is_featured): ?>
                <span class="inline-flex text-xs font-bold px-3 py-1.5 rounded-lg bg-yellow-100 text-yellow-700">
                    ⭐ Featured
                </span>
                <?php endif; ?>
            </div>

            
            <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-gray-900 leading-tight">
                <?php echo e($incident->title); ?>

            </h1>

            
            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 pb-5 border-b border-gray-100">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-ng-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Reported by <strong class="text-gray-700 ml-1"><?php echo e($incident->reporter_name); ?></strong>
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-ng-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <?php echo e($incident->formatted_date); ?>

                    <?php if($incident->incident_time): ?> at <?php echo e(\Carbon\Carbon::parse($incident->incident_time)->format('H:i')); ?> <?php endif; ?>
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-ng-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <?php echo e(number_format($incident->views)); ?> views
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-ng-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <?php echo e($incident->allComments->count()); ?> comments
                </span>
            </div>

            
            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                <?php echo nl2br(e($incident->description)); ?>

            </div>

            
            <?php if($incident->casualties > 0 || $incident->kidnapped_count > 0): ?>
            <div class="grid grid-cols-2 gap-4">
                <?php if($incident->casualties > 0): ?>
                <div class="bg-red-50 border border-red-100 rounded-2xl p-5 text-center">
                    <div class="font-display font-extrabold text-3xl text-red-600 mb-1">
                        <?php echo e(number_format($incident->casualties)); ?>

                    </div>
                    <div class="text-xs font-bold text-red-500 uppercase tracking-wider">Fatalities Reported</div>
                </div>
                <?php endif; ?>
                <?php if($incident->kidnapped_count > 0): ?>
                <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5 text-center">
                    <div class="font-display font-extrabold text-3xl text-orange-600 mb-1">
                        <?php echo e(number_format($incident->kidnapped_count)); ?>

                    </div>
                    <div class="text-xs font-bold text-orange-500 uppercase tracking-wider">Kidnap Victims</div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <?php if($incident->source_url): ?>
            <div class="flex items-center gap-2 text-sm bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <span class="text-gray-600">Source:</span>
                <a href="<?php echo e($incident->source_url); ?>" target="_blank" rel="noopener noreferrer"
                   class="text-blue-600 hover:text-blue-800 font-medium truncate transition-colors">
                    <?php echo e(parse_url($incident->source_url, PHP_URL_HOST)); ?>

                </a>
                <svg class="w-3 h-3 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </div>
            <?php endif; ?>

            
            <?php if($incident->images && count($incident->images) > 0): ?>
            <div>
                <h3 class="font-display font-semibold text-gray-900 mb-3">Evidence / Media</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <?php $__currentLoopData = $incident->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/' . $img)); ?>" target="_blank"
                       class="block rounded-xl overflow-hidden border border-gray-100 aspect-video
                              bg-gray-50 hover:border-ng-green transition-colors">
                        <?php if(str_ends_with(strtolower($img), '.pdf')): ?>
                        <div class="w-full h-full flex flex-col items-center justify-center">
                            <svg class="w-8 h-8 text-red-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span class="text-xs text-gray-500">PDF Document</span>
                        </div>
                        <?php else: ?>
                        <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="Evidence"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        <?php endif; ?>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($incident->approved_at): ?>
            <div class="bg-ng-muted border border-ng-green/20 rounded-xl px-4 py-3 flex gap-3 items-start">
                <svg class="w-4 h-4 text-ng-green mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <p class="text-xs text-ng-dark font-medium">
                    Verified by <strong><?php echo e($incident->approver?->full_name ?? 'ThreatWatch Moderators'); ?></strong>
                    on <?php echo e($incident->approved_at->format('d M Y')); ?>.
                </p>
            </div>
            <?php endif; ?>

            
            <div class="pt-2">
                <h2 class="font-display font-bold text-xl text-gray-900 mb-5">
                    Comments
                    <span class="text-sm font-normal text-gray-400 ml-1">(<?php echo e($incident->allComments->count()); ?>)</span>
                </h2>

                
                <?php if(auth()->guard()->check()): ?>
                <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-6 shadow-sm">
                    <form method="POST" action="<?php echo e(route('comments.store', $incident->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="flex gap-3">
                            <img src="<?php echo e(auth()->user()->avatar_url); ?>"
                                 class="w-9 h-9 rounded-full border border-ng-100 flex-shrink-0 mt-0.5 object-cover"
                                 alt="<?php echo e(auth()->user()->full_name); ?>">
                            <div class="flex-1">
                                <textarea name="comment" rows="3"
                                          placeholder="Share an update, tip, or question about this incident..."
                                          class="form-input resize-none text-sm mb-3"><?php echo e(old('comment')); ?></textarea>
                                <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-500 mb-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn-primary">Post Comment</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php else: ?>
                <div class="bg-ng-muted border border-ng-green/20 rounded-xl px-5 py-4 mb-6 text-sm text-center">
                    <a href="<?php echo e(route('login')); ?>" class="font-bold text-ng-green hover:text-ng-dark transition-colors">Sign in</a>
                    <span class="text-gray-600"> to join the discussion about this incident.</span>
                </div>
                <?php endif; ?>

                
                <?php $__empty_1 = true; $__currentLoopData = $incident->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex gap-3 mb-5" id="comment-<?php echo e($comment->id); ?>">
                    <img src="<?php echo e($comment->user->avatar_url); ?>"
                         class="w-9 h-9 rounded-full border border-gray-100 flex-shrink-0 mt-0.5 object-cover"
                         alt="<?php echo e($comment->user->full_name); ?>">
                    <div class="flex-1">
                        <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-sm p-4 shadow-sm">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-sm text-gray-900">
                                        <?php echo e($comment->user->full_name); ?>

                                    </span>
                                    <?php if($comment->user->isModerator()): ?>
                                    <span class="text-[10px] bg-ng-muted text-ng-dark px-2 py-0.5 rounded-full font-bold">MOD</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                                    <?php if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isModerator())): ?>
                                    <form method="POST" action="<?php echo e(route('comments.destroy', $comment->id)); ?>"
                                          onsubmit="return confirm('Delete this comment?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="text-xs text-red-400 hover:text-red-600 transition-colors">Delete</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed"><?php echo e($comment->comment); ?></p>
                        </div>

                        
                        <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex gap-2.5 mt-3 ml-4">
                            <img src="<?php echo e($reply->user->avatar_url); ?>"
                                 class="w-7 h-7 rounded-full border border-gray-100 flex-shrink-0 mt-0.5 object-cover"
                                 alt="<?php echo e($reply->user->full_name); ?>">
                            <div class="flex-1 bg-gray-50 border border-gray-100 rounded-xl rounded-tl-sm p-3">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="font-semibold text-xs text-gray-900"><?php echo e($reply->user->full_name); ?></span>
                                    <span class="text-xs text-gray-400"><?php echo e($reply->created_at->diffForHumans()); ?></span>
                                </div>
                                <p class="text-xs text-gray-700 leading-relaxed"><?php echo e($reply->comment); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <?php if(auth()->guard()->check()): ?>
                        <div class="mt-2 ml-1" x-data="{ replyOpen: false }">
                            <button @click="replyOpen = !replyOpen"
                                    class="text-xs text-gray-400 hover:text-ng-green transition-colors font-medium">
                                ↩ Reply
                            </button>
                            <div x-show="replyOpen" x-collapse class="mt-2">
                                <form method="POST" action="<?php echo e(route('comments.store', $incident->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="parent_id" value="<?php echo e($comment->id); ?>">
                                    <textarea name="comment" rows="2"
                                              placeholder="Write a reply..."
                                              class="form-input text-xs resize-none mb-2"></textarea>
                                    <button type="submit" class="btn-primary text-xs py-1.5 px-3">Reply</button>
                                </form>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <p class="text-sm font-medium">No comments yet. Be the first.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="space-y-5">

            
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <h3 class="font-display font-semibold text-sm text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-ng-green" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Location
                </h3>
                <dl class="space-y-2.5 text-sm">
                    <div class="flex justify-between items-start gap-2">
                        <dt class="text-gray-500 flex-shrink-0">State</dt>
                        <dd class="font-semibold text-gray-900 text-right"><?php echo e($incident->state->name); ?></dd>
                    </div>
                    <?php if($incident->lga): ?>
                    <div class="flex justify-between items-start gap-2">
                        <dt class="text-gray-500 flex-shrink-0">LGA</dt>
                        <dd class="font-semibold text-gray-900 text-right"><?php echo e($incident->lga->name); ?></dd>
                    </div>
                    <?php endif; ?>
                    <?php if($incident->town): ?>
                    <div class="flex justify-between items-start gap-2">
                        <dt class="text-gray-500 flex-shrink-0">Town</dt>
                        <dd class="font-semibold text-gray-900 text-right"><?php echo e($incident->town); ?></dd>
                    </div>
                    <?php endif; ?>
                    <?php if($incident->latitude && $incident->longitude): ?>
                    <div class="flex justify-between items-start gap-2 pt-1 border-t border-gray-50">
                        <dt class="text-gray-400 text-xs">Coordinates</dt>
                        <dd class="text-xs text-gray-400 font-mono text-right">
                            <?php echo e(number_format($incident->latitude, 4)); ?>,
                            <?php echo e(number_format($incident->longitude, 4)); ?>

                        </dd>
                    </div>
                    <?php endif; ?>
                </dl>

                
                <?php if($incident->latitude && $incident->longitude): ?>
                <div id="incident-mini-map" class="mt-4 h-44 rounded-xl overflow-hidden border border-gray-100"></div>
                <?php endif; ?>
            </div>

            
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Incident Details</h3>
                <dl class="space-y-2.5 text-sm">
                    <div class="flex justify-between items-center gap-2">
                        <dt class="text-gray-500">Type</dt>
                        <dd class="font-semibold text-gray-900"><?php echo e($incident->attack_type_label); ?></dd>
                    </div>
                    <div class="flex justify-between items-center gap-2">
                        <dt class="text-gray-500">Severity</dt>
                        <dd><span class="text-xs font-bold px-2 py-0.5 rounded-lg severity-<?php echo e($incident->severity); ?>">
                            <?php echo e(ucfirst($incident->severity)); ?>

                        </span></dd>
                    </div>
                    <div class="flex justify-between items-center gap-2">
                        <dt class="text-gray-500">Date</dt>
                        <dd class="font-semibold text-gray-900"><?php echo e($incident->formatted_date); ?></dd>
                    </div>
                    <?php if($incident->incident_time): ?>
                    <div class="flex justify-between items-center gap-2">
                        <dt class="text-gray-500">Time</dt>
                        <dd class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($incident->incident_time)->format('H:i')); ?></dd>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between items-center gap-2">
                        <dt class="text-gray-500">Status</dt>
                        <dd><span class="text-xs font-bold px-2 py-0.5 rounded-lg status-<?php echo e($incident->status); ?>">
                            <?php echo e(ucfirst($incident->status)); ?>

                        </span></dd>
                    </div>
                </dl>
            </div>

            
            <?php if($related->isNotEmpty()): ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <h3 class="font-display font-semibold text-sm text-gray-900 mb-4">Related Incidents</h3>
                <div class="space-y-3">
                    <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('incidents.show', $rel->slug)); ?>" class="flex items-start gap-2.5 group">
                        <span class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0
                            <?php echo e($rel->severity === 'critical' ? 'bg-red-500' : ($rel->severity === 'high' ? 'bg-orange-500' : ($rel->severity === 'medium' ? 'bg-amber-400' : 'bg-emerald-400'))); ?>">
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-800 group-hover:text-ng-green transition-colors line-clamp-2 leading-snug">
                                <?php echo e($rel->title); ?>

                            </p>
                            <p class="text-[10px] text-gray-400 mt-1">
                                <?php echo e($rel->state->name); ?> · <?php echo e($rel->incident_date?->format('d M Y')); ?>

                            </p>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <div class="bg-red-50 border border-red-100 rounded-2xl p-5">
                <h3 class="font-display font-semibold text-sm text-red-800 mb-3">🚨 Emergency Contacts</h3>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-gray-600">Police</span><strong class="text-gray-900 font-mono">199 / 112</strong></div>
                    <div class="flex justify-between"><span class="text-gray-600">DSS</span><strong class="text-gray-900 font-mono">08057000001</strong></div>
                    <div class="flex justify-between"><span class="text-gray-600">Army</span><strong class="text-gray-900 font-mono">193</strong></div>
                </div>
                <a href="<?php echo e(route('helplines')); ?>" class="block text-center mt-3 text-xs font-bold text-red-600 hover:text-red-800 transition-colors">
                    All Helplines →
                </a>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head_styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<?php if($incident->latitude && $incident->longitude): ?>
<script>
(function() {
    const map = L.map('incident-mini-map', {
        zoomControl: true, scrollWheelZoom: false
    }).setView([<?php echo e($incident->latitude); ?>, <?php echo e($incident->longitude); ?>], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const colors = { critical: '#ef4444', high: '#f97316', medium: '#f59e0b', low: '#22c55e' };
    const color  = colors['<?php echo e($incident->severity); ?>'] || '#009A44';

    L.circleMarker([<?php echo e($incident->latitude); ?>, <?php echo e($incident->longitude); ?>], {
        radius: 10, fillColor: color, color: 'white',
        weight: 2, opacity: 1, fillOpacity: 0.85
    }).addTo(map).bindPopup('<strong><?php echo e(addslashes($incident->title)); ?></strong>').openPopup();
})();
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\threatwatch-nigeria\resources\views/incidents/show.blade.php ENDPATH**/ ?>