<?php $__env->startSection('title', 'Menús'); ?>

<?php $__env->startPush('css-datatable'); ?>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('css'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>



    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Menús</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo e(route('panel')); ?>">Inicio</a></li>
            <li class="breadcrumb-item active">Menús</li>
        </ol>

        <div class="mb-4">
            <a href="<?php echo e(route('menus.create')); ?>">
                <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Menús
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped fs-6">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($menu->id); ?></td>
                                <td><?php echo e($menu->nombre); ?></td>
                                <td>$<?php echo e(number_format($menu->precio, 2)); ?></td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <div>
                                            <button title="Opciones"
                                                class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#verModal-<?php echo e($menu->id); ?>">Ver</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('menus.edit', $menu->id)); ?>">Editar</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <div class="vr"></div>
                                        </div>
                                        <div>
                                            <button title="Eliminar" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-<?php echo e($menu->id); ?>"
                                                class="btn btn-datatable btn-icon btn-transparent-dark">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Ver -->
                            <div class="modal fade" id="verModal-<?php echo e($menu->id); ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Menú</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <img src="<?php echo e(asset('storage/' . $menu->imagen)); ?>"
                                                    alt="<?php echo e($menu->nombre); ?>"
                                                    class="img-fluid img-thumbnail border border-4 rounded"
                                                    style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Código: </span><?php echo e($menu->id); ?></p>
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Nombre: </span><?php echo e($menu->nombre); ?></p>
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Descripción: </span><?php echo e($menu->descripcion); ?></p>
                                            </div>
                                            <div class="col-12">
                                                <p><span class="fw-bolder">Precio:
                                                    </span>$<?php echo e(number_format($menu->precio, 2)); ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Confirmación Eliminar -->
                            <div class="modal fade" id="confirmModal-<?php echo e($menu->id); ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro que deseas eliminar el menú?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form action="<?php echo e(route('menus.destroy', $menu->id)); ?>" method="post">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/menus/index.blade.php ENDPATH**/ ?>