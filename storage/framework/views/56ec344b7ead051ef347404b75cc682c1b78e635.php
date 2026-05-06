

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-calendar-check"></i> МОИ БРОНИРОВАНИЯ
                </h5>
                <a href="<?php echo e(route('bookings.create')); ?>" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-plus-circle"></i> НОВОЕ БРОНИРОВАНИЕ
                </a>
            </div>
        </div>
        <div class="card-body bg-white">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($bookings->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x display-1 text-black-50"></i>
                    <h4 class="text-dark mt-3">У вас пока нет бронирований</h4>
                    <p class="text-secondary">Создайте новое бронирование, чтобы забронировать столик</p>
                    <a href="<?php echo e(route('bookings.create')); ?>" class="btn btn-dark mt-2">
                        <i class="bi bi-plus-circle"></i> ЗАБРОНИРОВАТЬ СТОЛИК
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 border booking-card">
                            <div class="card-header bg-white border-0 pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill px-3 py-2 
                                        <?php if($booking->status == 'pending'): ?> bg-secondary text-white
                                        <?php elseif($booking->status == 'confirmed'): ?> bg-dark text-white
                                        <?php else: ?> bg-light text-dark border
                                        <?php endif; ?>">
                                        <?php if($booking->status == 'pending'): ?>
                                            <i class="bi bi-clock-history"></i> ОЖИДАЕТ
                                        <?php elseif($booking->status == 'confirmed'): ?>
                                            <i class="bi bi-check-circle"></i> ПОДТВЕРЖДЕНО
                                        <?php else: ?>
                                            <i class="bi bi-x-circle"></i> ОТМЕНЕНО
                                        <?php endif; ?>
                                    </span>
                                    <small class="text-secondary">#<?php echo e($booking->id); ?></small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-calendar3 text-dark me-2"></i>
                                        <span class="fw-semibold text-dark"><?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y')); ?></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-clock text-dark me-2"></i>
                                        <span class="text-dark"><?php echo e(\Carbon\Carbon::parse($booking->booking_time)->format('H:i')); ?></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-person text-dark me-2"></i>
                                        <span class="text-dark"><?php echo e($booking->guests_count); ?> гостей</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-table text-dark me-2"></i>
                                        <span class="text-dark"><?php echo e($booking->table->name); ?> (<?php echo e($booking->table->seats); ?> мест)</span>
                                    </div>
                                </div>
                                
                                <?php if($booking->menuItems->count() > 0): ?>
                                <div class="border-top pt-2 mt-2">
                                    <small class="text-secondary">
                                        <i class="bi bi-cup-straw"></i> Заказано блюд: <?php echo e($booking->menuItems->count()); ?>

                                    </small>
                                    <div class="fw-bold text-dark mt-1">
                                        <?php echo e(number_format($booking->total_price, 2)); ?> руб.
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                <?php if($booking->status != 'cancelled' && $booking->status != 'confirmed'): ?>
                                <form action="<?php echo e(route('bookings.destroy', $booking)); ?>" method="POST" onsubmit="return confirm('Отменить бронирование?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-dark btn-sm w-100">
                                        <i class="bi bi-x-circle"></i> ОТМЕНИТЬ
                                    </button>
                                </form>
                                <?php elseif($booking->status == 'confirmed'): ?>
                                <button class="btn btn-dark btn-sm w-100" disabled>
                                    <i class="bi bi-check-circle"></i> ПОДТВЕРЖДЕНО
                                </button>
                                <?php else: ?>
                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                    <i class="bi bi-x-circle"></i> ОТМЕНЕНО
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.booking-card {
    border: 1px solid #dee2e6 !important;
    transition: box-shadow 0.2s ease;
}
.booking-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}
.btn-outline-dark {
    border: 1px solid #000000;
    color: #000000;
    background: transparent;
}
.btn-outline-dark:hover {
    background: #000000;
    color: #ffffff;
}
.btn-dark {
    background: #000000;
    border: 1px solid #000000;
    color: #ffffff;
}
.btn-dark:hover {
    background: #333333;
    border-color: #333333;
}
.btn-outline-light {
    border: 1px solid #ffffff;
    color: #ffffff;
}
.btn-outline-light:hover {
    background: #ffffff;
    color: #000000;
}
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}
.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
.text-black-50 {
    color: rgba(0,0,0,0.5) !important;
}
.bg-secondary {
    background-color: #6c757d !important;
}
.bg-dark {
    background-color: #000000 !important;
}
.bg-light {
    background-color: #f8f9fa !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\localhost\resources\views/bookings/index.blade.php ENDPATH**/ ?>