

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white border-0">
                    <h5 class="mb-0 fw-bold">МОЙ ПРОФИЛЬ</h5>
                </div>
                <div class="card-body bg-white">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Имя</label>
                        <p class="form-control-plaintext text-dark border-bottom pb-2"><?php echo e($user->name); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Email адрес</label>
                        <p class="form-control-plaintext text-dark border-bottom pb-2"><?php echo e($user->email); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Телефон</label>
                        <p class="form-control-plaintext text-dark border-bottom pb-2"><?php echo e($user->phone ?: 'Не указан'); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Роль</label>
                        <p class="form-control-plaintext">
                            <?php if($user->role === 'admin'): ?>
                                <span class="badge bg-dark">АДМИНИСТРАТОР</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">ПОЛЬЗОВАТЕЛЬ</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Дата регистрации</label>
                        <p class="form-control-plaintext text-secondary"><?php echo e($user->created_at->format('d.m.Y H:i')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}
.btn-close {
    filter: invert(0);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\localhost\resources\views/auth/profile.blade.php ENDPATH**/ ?>