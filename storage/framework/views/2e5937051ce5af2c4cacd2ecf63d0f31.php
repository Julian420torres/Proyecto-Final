

<?php $__env->startSection('title', 'Crear cliente'); ?>

<?php $__env->startPush('css'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        #box-razon-social {
            display: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Cliente</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo e(route('panel')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('clientes.index')); ?>">Clientes</a></li>
            <li class="breadcrumb-item active">Crear cliente</li>
        </ol>

        <div class="card">
            <form action="<?php echo e(route('clientes.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="card-body text-bg-light">

                    <div class="row g-3">

                        <!----Tipo de persona----->
                        <div class="col-md-6">
                            <label for="tipo_persona" class="form-label">Tipo de cliente:</label>
                            <select class="form-select" name="tipo_persona" id="tipo_persona">
                                <option value="" selected disabled>Seleccione una opción</option>
                                <option value="natural" <?php echo e(old('tipo_persona') == 'natural' ? 'selected' : ''); ?>>Persona
                                    natural</option>
                                <option value="juridica" <?php echo e(old('tipo_persona') == 'juridica' ? 'selected' : ''); ?>>Persona
                                    jurídica</option>
                            </select>
                            <?php $__errorArgs = ['tipo_persona'];
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

                        <!-------Razón social------->
                        <div class="col-12" id="box-razon-social">
                            <label id="label-natural" for="razon_social" class="form-label">Nombres y apellidos:</label>
                            <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa:</label>

                            <input required type="text" name="razon_social" id="razon_social" class="form-control"
                                value="<?php echo e(old('razon_social')); ?>">

                            <?php $__errorArgs = ['razon_social'];
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

                        <!------Dirección---->
                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input required type="text" name="direccion" id="direccion" class="form-control"
                                value="<?php echo e(old('direccion')); ?>">
                            <?php $__errorArgs = ['direccion'];
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

                        <!--------------Documento------->
                        <div class="col-md-6">
                            <label for="documento_id" class="form-label">Tipo de documento:</label>
                            <select class="form-select" name="documento_id" id="documento_id">
                                <option value="" selected disabled>Seleccione una opción</option>
                                <?php $__currentLoopData = $documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"
                                        <?php echo e(old('documento_id') == $item->id ? 'selected' : ''); ?>>
                                        <?php echo e($item->tipo_documento); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['documento_id'];
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
                            <label for="numero_documento" class="form-label">Numero de documento:</label>
                            <input required type="text" name="numero_documento" id="numero_documento"
                                class="form-control" value="<?php echo e(old('numero_documento')); ?>">
                            <?php $__errorArgs = ['numero_documento'];
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
    <script>
        $(document).ready(function() {
            $('#tipo_persona').on('change', function() {
                let selectValue = $(this).val();
                //natural //juridica
                if (selectValue == 'natural') {
                    $('#label-juridica').hide();
                    $('#label-natural').show();
                } else {
                    $('#label-natural').hide();
                    $('#label-juridica').show();
                }

                $('#box-razon-social').show();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/cliente/create.blade.php ENDPATH**/ ?>