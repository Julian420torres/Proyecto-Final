<?php $__env->startSection('title', 'Crear Producto'); ?>

<?php $__env->startPush('css'); ?>
    <style>
        #descripcion {
            resize: none;
        }
    </style>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Producto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo e(route('panel')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('productos.index')); ?>">Productos</a></li>
            <li class="breadcrumb-item active">Crear producto</li>
        </ol>

        <div class="card">
            <form action="<?php echo e(route('productos.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-body text-bg-light">

                    <div class="row g-4">

                        <!----Codigo---->
                        <div class="col-md-6">
                            <label for="codigo" class="form-label">Código:</label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                value="<?php echo e(old('codigo')); ?>">
                            <?php $__errorArgs = ['codigo'];
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

                        <!---Nombre---->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="<?php echo e(old('nombre')); ?>">
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

                        <!---Descripción---->
                        <div class="col-12">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" rows="3" class="form-control"><?php echo e(old('descripcion')); ?></textarea>
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

                        <!---Fecha de vencimiento---->
                        <div class="col-md-6">
                            <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
                                value="<?php echo e(old('fecha_vencimiento')); ?>">
                            <?php $__errorArgs = ['fecha_vencimiento'];
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

                        <!---Imagen---->
                        <div class="col-md-6">
                            <label for="img_path" class="form-label">Imagen:</label>
                            <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
                            <?php $__errorArgs = ['img_path'];
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





                        <!---Categorías---->
                        <div class="col-md-6">
                            <label for="categorias" class="form-label">Categorías:</label>
                            <select data-size="4" title="Seleccione las categorías" data-live-search="true"
                                name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"
                                        <?php echo e(in_array($item->id, old('categorias', [])) ? 'selected' : ''); ?>>
                                        <?php echo e($item->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['categorias'];
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
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/producto/create.blade.php ENDPATH**/ ?>