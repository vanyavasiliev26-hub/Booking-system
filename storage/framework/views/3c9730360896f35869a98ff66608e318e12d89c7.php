

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Добавить блюдо</div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.menu.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Цена (руб.)</label>
                            <input type="number" name="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category" class="form-control">
                                <option value="appetizer">Закуски</option>
                                <option value="soup">Супы</option>
                                <option value="main">Основные блюда</option>
                                <option value="dessert">Десерты</option>
                                <option value="drink">Напитки</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Меню</div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Цена</th>
                                <th>Категория</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->name); ?></td>
                                <td><?php echo e(Str::limit($item->description, 50)); ?></td>
                                <td><?php echo e(number_format($item->price, 2)); ?> руб.</td>
                                <td><?php echo e($item->category); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItem<?php echo e($item->id); ?>">Ред.</button>
                                    <form action="<?php echo e(route('admin.menu.delete', $item)); ?>" method="POST" style="display: inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editItem<?php echo e($item->id); ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="<?php echo e(route('admin.menu.update', $item)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="modal-header">
                                                <h5>Редактировать блюдо</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Название</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo e($item->name); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Описание</label>
                                                    <textarea name="description" class="form-control" rows="2"><?php echo e($item->description); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Цена</label>
                                                    <input type="number" name="price" class="form-control" step="0.01" value="<?php echo e($item->price); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Категория</label>
                                                    <select name="category" class="form-control">
                                                        <option value="appetizer" <?php echo e($item->category == 'appetizer' ? 'selected' : ''); ?>>Закуски</option>
                                                        <option value="soup" <?php echo e($item->category == 'soup' ? 'selected' : ''); ?>>Супы</option>
                                                        <option value="main" <?php echo e($item->category == 'main' ? 'selected' : ''); ?>>Основные</option>
                                                        <option value="dessert" <?php echo e($item->category == 'dessert' ? 'selected' : ''); ?>>Десерты</option>
                                                        <option value="drink" <?php echo e($item->category == 'drink' ? 'selected' : ''); ?>>Напитки</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Доступно</label>
                                                    <select name="is_available" class="form-control">
                                                        <option value="1" <?php echo e($item->is_available ? 'selected' : ''); ?>>Да</option>
                                                        <option value="0" <?php echo e(!$item->is_available ? 'selected' : ''); ?>>Нет</option>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\localhost\resources\views/admin/menu.blade.php ENDPATH**/ ?>