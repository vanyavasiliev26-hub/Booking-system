

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Админ-панель</h1>
            <hr>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Всего бронирований</h5>
                    <h2><?php echo e($stats['total_bookings']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Бронирований сегодня</h5>
                    <h2><?php echo e($stats['today_bookings']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Активных столиков</h5>
                    <h2><?php echo e($stats['active_tables']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Блюд в меню</h5>
                    <h2><?php echo e($stats['total_menu_items']); ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Последние бронирования</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Клиент</th>
                                    <th>Столик</th>
                                    <th>Дата</th>
                                    <th>Время</th>
                                    <th>Гостей</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($booking->user->name); ?></td>
                                    <td><?php echo e($booking->table->name); ?></td>
                                    <td><?php echo e($booking->booking_date); ?></td>
                                    <td><?php echo e($booking->booking_time); ?></td>
                                    <td><?php echo e($booking->guests_count); ?></td>
                                    <td><?php echo e($booking->status); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\localhost\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>