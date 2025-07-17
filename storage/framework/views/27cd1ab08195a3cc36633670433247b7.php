<?php $__env->startSection('title', 'Ver venta'); ?>

<?php $__env->startPush('css'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        @media (max-width:575px) {
            #hide-group {
                display: none;
            }
        }

        @media (min-width:576px) {
            #icon-form {
                display: none;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver Venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo e(route('panel')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('ventas.index')); ?>">Ventas</a></li>
            <li class="breadcrumb-item active">Ver Venta</li>
        </ol>
    </div>

    <div class="container-fluid">

        <div class="card mb-4">

            <div class="card-header">
                Datos generales de la venta
            </div>

            <div class="card-body">

                <!---Tipo comprobante--->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                            <input disabled type="text" class="form-control" value="Tipo de comprobante: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Tipo de comprobante" id="icon-form" class="input-group-text"><i
                                    class="fa-solid fa-file"></i></span>
                            <input disabled type="text" class="form-control"
                                value="<?php echo e($venta->comprobante->tipo_comprobante); ?>">
                        </div>
                    </div>
                </div>

                <!---Numero comprobante--->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                            <input disabled type="text" class="form-control" value="Número de comprobante: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Número de comprobante" id="icon-form" class="input-group-text"><i
                                    class="fa-solid fa-hashtag"></i></span>
                            <input disabled type="text" class="form-control" value="<?php echo e($venta->numero_comprobante); ?>">
                        </div>
                    </div>
                </div>

                <!---Cliente--->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                            <input disabled type="text" class="form-control" value="Cliente: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Cliente" class="input-group-text" id="icon-form"><i
                                    class="fa-solid fa-user-tie"></i></span>
                            <input disabled type="text" class="form-control"
                                value="<?php echo e($venta->cliente->persona->razon_social); ?>">
                        </div>
                    </div>
                </div>

                <!---Usuario-->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input disabled type="text" class="form-control" value="Vendedor: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Vendedor" class="input-group-text" id="icon-form"><i
                                    class="fa-solid fa-user"></i></span>
                            <input disabled type="text" class="form-control" value="<?php echo e($venta->user->name); ?>">
                        </div>
                    </div>
                </div>

                <!---Fecha--->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input disabled type="text" class="form-control" value="Fecha: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Fecha" class="input-group-text" id="icon-form"><i
                                    class="fa-solid fa-calendar-days"></i></span>
                            <input disabled type="text" class="form-control"
                                value="<?php echo e(\Carbon\Carbon::parse($venta->fecha_hora)->format('d-m-Y')); ?>">
                        </div>
                    </div>
                </div>

                <!---Hora-->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                            <input disabled type="text" class="form-control" value="Hora: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Hora" class="input-group-text" id="icon-form"><i
                                    class="fa-solid fa-clock"></i></span>
                            <input disabled type="text" class="form-control"
                                value="<?php echo e(\Carbon\Carbon::parse($venta->fecha_hora)->format('H:i')); ?>">
                        </div>

                    </div>
                </div>

                <!---Impuesto--->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                            <input disabled type="text" class="form-control" value="Impuesto: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Impuesto" class="input-group-text" id="icon-form"><i
                                    class="fa-solid fa-percent"></i></span>
                            <input id="input-impuesto" disabled type="text" class="form-control"
                                value="<?php echo e($venta->impuesto); ?>">
                        </div>

                    </div>
                </div>
            </div>


        </div>


        <!---Tabla--->
        <div class="card mb-2">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de detalle de la venta
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr class="align-top">
                            <th class="text-white">#</th>
                            <th class="text-white">Producto</th>
                            <th class="text-white">Menu</th>
                            <th class="text-white">Cantidad_Producto</th>
                            <th class="text-white">Cantidad_Menu</th>
                            <th class="text-white">Precio_Venta</th>
                            <th class="text-white">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>

                        <?php $__currentLoopData = $venta->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($contador); ?></td>
                                <td><?php echo e($producto->nombre); ?></td>
                                <td>-</td> <!-- No es un menú, así que dejamos vacío -->
                                <td><?php echo e($producto->pivot->cantidad); ?></td>
                                <td>-</td> <!-- No aplica cantidad de menú -->
                                <td><?php echo e($producto->pivot->precio_venta); ?></td>
                                <td><?php echo e($producto->pivot->cantidad * $producto->pivot->precio_venta); ?></td>
                            </tr>
                            <?php $contador++; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $venta->menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($contador); ?></td>
                                <td>-</td> <!-- No es un producto, así que dejamos vacío -->
                                <td><?php echo e($menu->nombre); ?></td>
                                <td>-</td> <!-- No aplica cantidad de producto -->
                                <td><?php echo e($menu->pivot->cantidad); ?></td>
                                <td><?php echo e($menu->pivot->precio_unitario); ?></td>
                                <td><?php echo e($menu->pivot->cantidad * $menu->pivot->precio_unitario); ?></td>
                            </tr>
                            <?php $contador++; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Sumas:</th>
                            <th><?php echo e($venta->productos->sum(fn($p) => $p->pivot->cantidad * $p->pivot->precio_venta) + $venta->menus->sum(fn($m) => $m->pivot->cantidad * $m->pivot->precio_unitario)); ?>

                            </th>
                        </tr>
                        <tr>
                            <th colspan="6">INC %:</th>
                            <th><?php echo e($venta->impuesto); ?></th>
                        </tr>
                        <tr>
                            <th colspan="6">Total:</th>
                            <th><?php echo e($venta->total); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('js'); ?>
        <script>
            //Variables
            let filasSubtotal = document.getElementsByClassName('td-subtotal');
            let cont = 0;
            let impuesto = $('#input-impuesto').val();

            $(document).ready(function() {
                calcularValores();
            });

            function calcularValores() {
                for (let i = 0; i < filasSubtotal.length; i++) {
                    cont += parseFloat(filasSubtotal[i].innerHTML);
                }

                $('#th-suma').html(cont);
                $('#th-inc').html(impuesto);
                $('#th-total').html(round(cont + parseFloat(impuesto)));
            }

            function round(num, decimales = 2) {
                var signo = (num >= 0 ? 1 : -1);
                num = num * signo;
                if (decimales === 0) //con 0 decimales
                    return signo * Math.round(num);
                // round(x * 10 ^ decimales)
                num = num.toString().split('e');
                num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
                // x * 10 ^ (-decimales)
                num = num.toString().split('e');
                return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
            }
            //Fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/venta/show.blade.php ENDPATH**/ ?>