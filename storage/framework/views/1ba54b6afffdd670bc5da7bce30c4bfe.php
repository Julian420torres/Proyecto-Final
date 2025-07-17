<?php $__env->startSection('title', 'compras'); ?>
<?php $__env->startPush('css-datatable'); ?>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .row-not-space {
            width: 110px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Compras</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo e(route('panel')); ?>">Inicio</a></li>
            <li class="breadcrumb-item active">Compras</li>
        </ol>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-compra')): ?>
            <div class="mb-4">
                <a href="<?php echo e(route('compras.create')); ?>">
                    <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
                </a>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla compras
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Comprobante</th>

                            <th>Fecha y hora</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $compras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <p class="fw-semibold mb-1"><?php echo e($item->comprobante->tipo_comprobante); ?></p>
                                    <p class="text-muted mb-0"><?php echo e($item->numero_comprobante); ?></p>
                                </td>

                                <td>
                                    <div class="row-not-space">
                                        <p class="fw-semibold mb-1"><span class="m-1"><i
                                                    class="fa-solid fa-calendar-days"></i></span><?php echo e(\Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y')); ?>

                                        </p>
                                        <p class="fw-semibold mb-0"><span class="m-1"><i
                                                    class="fa-solid fa-clock"></i></span><?php echo e(\Carbon\Carbon::parse($item->fecha_hora)->format('H:i')); ?>

                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <?php echo e($item->total); ?>

                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('mostrar-compra')): ?>
                                            <form action="<?php echo e(route('compras.show', ['compra' => $item])); ?>" method="get">
                                                <button type="submit" class="btn btn-success">
                                                    Ver
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar-compra')): ?>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-<?php echo e($item->id); ?>">Eliminar</button>
                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>

                            <!-- Modal de confirmación-->
                            <div class="modal fade" id="confirmModal-<?php echo e($item->id); ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro que quieres eliminar el registro?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <form action="<?php echo e(route('compras.destroy', ['compra' => $item->id])); ?>"
                                                method="post">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/datatables-simple-demo.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/compra/index.blade.php ENDPATH**/ ?>