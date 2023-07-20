<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema Médico</title>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper container">
                <a href="dashboard.php" class="brand-logo">Sistema Médico</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><?php echo $_SESSION['elusuario']; ?></li>
                    <li><span class="new "><a href="salir.php">Cerrar sesión</a></span></li>
                </ul>
            </div>
        </nav>
        <div class="container" style="padding-bottom:50px">