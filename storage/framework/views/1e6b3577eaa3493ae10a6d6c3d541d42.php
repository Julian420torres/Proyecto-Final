<?php $__env->startSection('title', 'Crear Menú'); ?>

<?php $__env->startPush('css'); ?>
    <style>
        #descripcion {
            resize: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>



    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Menú</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo e(route('panel')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('menus.index')); ?>">Menús</a></li>
            <li class="breadcrumb-item active">Crear Menú</li>
        </ol>

        <div class="card">
            <div class="card-header">Registrar Nuevo Menú</div>
            <div class="card-body">
                <form action="<?php echo e(route('menus.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="nombre" class="form-label">Nombre del Menú</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="<?php echo e(old('nombre')); ?>" required>
                            <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e('*' . $message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo e(old('descripcion')); ?></textarea>
                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e('*' . $message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" name="precio" id="precio" class="form-control" step="0.01"
                                value="<?php echo e(old('precio')); ?>" required>
                            <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e('*' . $message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label for="imagen" class="form-label">Imagen del Menú</label>
                            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*"
                                required>
                            <?php $__errorArgs = ['imagen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e('*' . $message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="card-footer text-center mt-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="<?php echo e(route('menus.index')); ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/menus/create.blade.php ENDPATH**/ ?>