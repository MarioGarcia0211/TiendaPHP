<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
?>

<style>
    .active {
        background: #f4f5f8;
        width: 100%;
        border-radius: 5px;
        padding-left: 10px;
    }
</style>

<nav class="navbar sticky-top navbar-expand-lg shadow" style="background-color: white;">
    <div class="container-fluid">
        <!-- Titulo del navbar -->
        <a class="navbar-brand mb-0 h1 titulo-navbar" href="index.php">Sistema</a>
        <!-- Final titulo del navbar -->

        <!-- Boton del menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Final boton del menu -->

        <!-- Menu offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

            <!-- Encabezado del offcanvas -->
            <div class="offcanvas-header shadow">
                <!-- Titulo del menu -->
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <!-- Final titulo del menu -->

                <!-- Boton salir del menu -->
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                <!-- Final boton salir del menu -->
            </div>
            <!-- Final encabezado del offcanvas -->

            <!-- Cuerpo del offcanvas -->
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <!-- inicio -->

                    <li class="nav-item centrar">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" aria-current="page" href="index.php"><i class="bi bi-house-fill"></i> Inicio</a>
                    </li>
                    <!-- Final inicio -->

                    <!-- Perfil -->
                    <li class="nav-item centrar">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'perfil.php' || basename($_SERVER['PHP_SELF']) == 'editar_datos.php'? 'active' : ''; ?>" aria-current="page" href="perfil.php"><i class="bi bi-file-person"></i> Perfil</a>
                    </li>
                    <!-- Final perfil -->

                    <?php
                    if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '2') {

                    ?>
                        <!-- Trazabilidad -->
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'trazabilidad.php' ? 'active' : ''; ?>" aria-current="page" href="trazabilidad.php"><i class="bi bi-activity"></i> Trazabilidad</a>
                        </li>
                        <!-- Final Trazabilidad -->

                        <!-- Graficas -->
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'graficas.php' ? 'active' : ''; ?>" aria-current="page" href="graficas.php"><i class="bi bi-bar-chart-line-fill"></i> Gráficas</a>
                        </li>
                        <!-- Final graficas -->

                        <!-- Usuario -->
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_usuario.php' || basename($_SERVER['PHP_SELF']) == 'editar_usuario.php' || basename($_SERVER['PHP_SELF']) == 'registrar_usuario.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_usuario.php' || basename($_SERVER['PHP_SELF']) == 'buscar_usuario.php' ? 'active' : ''; ?>" aria-current="page" href="lista_usuario.php"><i class="bi bi-people-fill"></i> Usuarios</a>
                        </li>
                        <!-- Final usuario -->

                    <?php } ?>

                    <!-- Clientes -->
                    <li class="nav-item centrar">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_cliente.php' || basename($_SERVER['PHP_SELF']) == 'editar_cliente.php' || basename($_SERVER['PHP_SELF']) == 'registrar_cliente.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_cliente.php' || basename($_SERVER['PHP_SELF']) == 'buscar_cliente.php' ? 'active' : ''; ?>" aria-current="page" href="lista_cliente.php"><i class="bi bi-people-fill"></i> Clientes</a>
                    </li>
                    <!-- Final clientes -->

                    <!-- Proveedores -->
                    <?php
                    if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '2') {
                    ?>
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_proveedor.php' || basename($_SERVER['PHP_SELF']) == 'editar_proveedor.php' || basename($_SERVER['PHP_SELF']) == 'registrar_proveedor.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_proveedor.php' || basename($_SERVER['PHP_SELF']) == 'buscar_proveedor.php' ? 'active' : ''; ?>" aria-current="page" href="lista_proveedor.php"><i class="bi bi-people-fill"></i> Proveedores</a>
                        </li>
                    <?php
                    }
                    ?>
                    <!-- Final Proveedores -->

                    <!-- Productos -->
                    <li class="nav-item centrar">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_producto.php' || basename($_SERVER['PHP_SELF']) == 'editar_producto.php' || basename($_SERVER['PHP_SELF']) == 'registrar_producto.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_producto.php' || basename($_SERVER['PHP_SELF']) == 'buscar_producto.php' ? 'active' : ''; ?>" aria-current="page" href="lista_producto.php"><i class="bi bi-bag-fill"></i> Productos</a>
                    </li>
                    <!-- Final Productos -->

                    <!-- Facturas -->
                    <li class="nav-item centrar">
                        <a class="nav-link" aria-current="page" href="lista_venta.php"><i class="bi bi-receipt"></i> Ventas</a>
                    </li>
                    <!-- Final Facturas -->

                    <!-- Boton cerrar sesion -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="cerrarSesion.php"><button class="btn btn-primary">Cerrar sesión</button></a>
                    </li>
                    <!-- Final boton cerrar sesion -->

                </ul>

            </div>
            <!-- Final cuerpo del offcanvas -->
        </div>
        <!-- Final menu offcanvas -->
    </div>
</nav>