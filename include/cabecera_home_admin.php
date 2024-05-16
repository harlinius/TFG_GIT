<!doctype html>
<html>
<!-- cabecera del login -->

<head>
    <!-- Metas requeridos -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" href="../css/estilo_home.css">
    <link rel="icon" href="../css/imagenes/icono_tab.png">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-collapse-sm" style="background-color: rgb(252, 241, 227)">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="../css/imagenes/icono_tab.png" alt="" width="40" height="40" class="d-inline-block align-text-top">
            </a>
            <a class="navbar-brand" href="home.php">
                Read&Meet
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu1">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu1">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= $activoHome ?>" href="home.php" title="Home">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-house-heart-fill" viewBox="0 0 20 20">
                                <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.707L8 2.207 1.354 8.853a.5.5 0 1 1-.708-.707z" />
                                <path d="m14 9.293-6-6-6 6V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5zm-6-.811c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.691 0-5.018" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activoSeguidos ?>" href="seguidos.php" title="Seguidos">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4m13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z" />
                            </svg>
                            Seguidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activoBiblioteca ?>" href="biblioteca.php" title="Biblioteca">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-bookshelf" viewBox="0 0 20 20">
                                <path d="M2.5 0a.5.5 0 0 1 .5.5V2h10V.5a.5.5 0 0 1 1 0v15a.5.5 0 0 1-1 0V15H3v.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5M3 14h10v-3H3zm0-4h10V7H3zm0-4h10V3H3z" />
                            </svg>
                            Biblioteca
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activoEspacioLectura ?>" href="lectura.php" title="Espacio de lectura">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-book-half" viewBox="0 0 20 20">
                                <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                            </svg>
                            Lectura privada
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activoAdmin ?>" href="administracion.php" title="Administración">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 20 20">
                                <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4m2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A2 2 0 0 0 8 6c-.532 0-1.016.208-1.375.547M14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0" />
                            </svg>
                            Administración
                        </a>
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown  ">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?= e($usuario->nombre_completo) ?></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            <!--para alinear a la izquierda me-auto-->
                            <li class="nav-item">
                                <a class="dropdown-item" href="editarMiCuenta.php" target="_blank">Editar mi cuenta</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="../gestion_cuentas/logout.php">Cerrar sesión</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">