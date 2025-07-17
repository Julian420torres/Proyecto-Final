<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="<?php echo e(route('panel')); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Panel
                </a>

                <!---div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layouts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Static Navigation</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.html">Login</a>
                                <a class="nav-link" href="register.html">Register</a>
                                <a class="nav-link" href="password.html">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div--->

                <div class="sb-sidenav-menu-heading">Modulos</div>

                <!----Compras---->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-compra')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompras"
                        aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                        Compras
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCompras" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-compra')): ?>
                                <a class="nav-link" href="<?php echo e(route('compras.index')); ?>">Ver</a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-compra')): ?>
                                <a class="nav-link" href="<?php echo e(route('compras.create')); ?>">Crear</a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>

                <!----Ventas---->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-venta')): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseVentas" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cash-register"></i></div>
                        Ventas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseVentas" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-venta')): ?>
                                <a class="nav-link" href="<?php echo e(route('ventas.index')); ?>">Ver</a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-compra')): ?>
                                <a class="nav-link" href="<?php echo e(route('ventas.create')); ?>">Crear</a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-categoria')): ?>
                    <a class="nav-link" href="<?php echo e(route('categorias.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-layer-group"></i></div>
                        Categorías
                    </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-menu')): ?>
                    <a class="nav-link" href="<?php echo e(route('menus.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-utensils"></i></div>
                        Menús
                    </a>
                <?php endif; ?>





                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-producto')): ?>
                    <a class="nav-link" href="<?php echo e(route('productos.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
                        Productos
                    </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-cliente')): ?>
                    <a class="nav-link" href="<?php echo e(route('clientes.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-group"></i></div>
                        Clientes
                    </a>
                <?php endif; ?>




                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'administrador')): ?>
                    <div class="sb-sidenav-menu-heading">OTROS</div>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-user')): ?>
                    <a class="nav-link" href="<?php echo e(route('users.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                        Usuarios
                    </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver-role')): ?>
                    <a class="nav-link" href="<?php echo e(route('roles.index')); ?>">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-person-circle-plus"></i></div>
                        Roles
                    </a>
                <?php endif; ?>


            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
            <?php echo e(auth()->user()->name); ?>

        </div>
    </nav>
</div>
<?php /**PATH C:\Users\julia\OneDrive\Escritorio\ProyectoFinal\resources\views/components/navigation-menu.blade.php ENDPATH**/ ?>