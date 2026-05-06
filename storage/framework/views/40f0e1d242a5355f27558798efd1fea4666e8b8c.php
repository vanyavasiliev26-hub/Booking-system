

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Добавить столик</div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.tables.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Количество мест</label>
                            <input type="number" name="seats" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Список столиков</div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Мест</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($table->name); ?></td>
                                <td><?php echo e($table->seats); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($table->is_active ? 'success' : 'danger'); ?>">
                                        <?php echo e($table->is_active ? 'Активен' : 'Неактивен'); ?>

                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTable<?php echo e($table->id); ?>">Редактировать</button>
                                    <form action="<?php echo e(route('admin.tables.delete', $table)); ?>" method="POST" style="display: inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editTable<?php echo e($table->id); ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="<?php echo e(route('admin.tables.update', $table)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="modal-header">
                                                <h5>Редактировать столик</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Название</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo e($table->name); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Количество мест</label>
                                                    <input type="number" name="seats" class="form-control" value="<?php echo e($table->seats); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Статус</label>
                                                    <select name="is_active" class="form-control">
                                                        <option value="1" <?php echo e($table->is_active ? 'selected' : ''); ?>>Активен</option>
                                                        <option value="0" <?php echo e(!$table->is_active ? 'selected' : ''); ?>>Неактивен</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\localhost\resources\views/admin/tables.blade.php ENDPATH**/ ?>