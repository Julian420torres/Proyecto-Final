@extends('layouts.app')

@section('title', 'Panel')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let message = "{{ session('success') }}";
                Swal.fire(message);

            });
        </script>
    @endif



    <div class="container-fluid px-4">
        <h1 class="mt-4">Panel</h1>
        <ol class="breadcrumb mb-4">
        </ol>
        <div class="row">

            @can('ver-cliente')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <i class="fa-solid fa-user-group"></i><span class="m-1">Clientes</span>
                                </div>
                                <div class="col-4">
                                    <p class="text-center fw-bold fs-4">{{ \App\Models\Cliente::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('clientes.index') }}">Ver más</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('ver-categoria')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <i class="fa-solid fa-layer-group"></i><span class="m-1">Categorías</span>
                                </div>
                                <div class="col-4">
                                    <p class="text-center fw-bold fs-4">{{ \App\Models\Categoria::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('categorias.index') }}">Ver más</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('ver-compra')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <i class="fa-solid fa-cart-shopping"></i><span class="m-1">Compras</span>
                                </div>
                                <div class="col-4">
                                    <p class="text-center fw-bold fs-4">{{ \App\Models\Compra::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('compras.index') }}">Ver más</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('ver-venta')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <i class="fa-solid fa-cash-register"></i><span class="m-1">Ventas</span>
                                </div>
                                <div class="col-4">
                                    <p class="text-center fw-bold fs-4">{{ \App\Models\Venta::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('ventas.index') }}">Ver más</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('ver-menu')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <i class="fa-solid fa-utensils"></i><span class="m-1">Menús</span>
                                </div>
                                <div class="col-4">
                                    <p class="text-center fw-bold fs-4">{{ \App\Models\Menu::count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('menus.index') }}">Ver más</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('ver-producto')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <i class="fa-solid fa-box-open"></i><span class="m-1">Productos</span>
                                </div>
                                <div class="col-4">
                                    @php
                                        $productos = \App\Models\Producto::count();
                                    @endphp
                                    <p class="text-center fw-bold fs-4">{{ $productos }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('productos.index') }}">Ver más</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <!-- Gráficos de estadísticas -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        5 Productos con el stock más bajo
                    </div>
                    <div class="card-body"><canvas id="productosChart" width="100%" height="30"></canvas></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Ventas en los últimos 7 días
                    </div>
                    <div class="card-body"><canvas id="ventasChart" width="100%" height="30"></canvas></div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    <script>
        let datosVenta = @json($totalVentasPorDia);

        const fechas = datosVenta.map(venta => {
            const [year, month, day] = venta.fecha.split('-');
            return `${day}/${month}/${year}`;
        });
        const montos = datosVenta.map(venta => parseFloat(venta.total));

        const ventasChart = document.getElementById('ventasChart');

        new Chart(ventasChart, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: "Ventas",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: montos,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            //maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            //max: 40000,
                            // maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        let datosProductos = @json($productosStockBajo);

        const nombres = datosProductos.map(obj => obj.nombre);
        const stock = datosProductos.map(i => i.stock);

        const productosChart = document.getElementById('productosChart');

        new Chart(productosChart, {
            type: 'horizontalBar',
            data: {
                labels: nombres,
                datasets: [{
                    label: 'stock',
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "#fff",
                    data: stock,
                    borderWidth: 2,
                    hoverBorderColor: '#aaa',
                    base: 0
                }]
            },
            options: {
                legend: {
                    display: false
                },
            }
        });
    </script>
@endpush
