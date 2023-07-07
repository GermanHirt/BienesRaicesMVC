<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $auth = $_SESSION['login'] ?? null;

    if(!isset($inicio)) {
        $inicio = false;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/public/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/public/index">
                    <img src="/public/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/public/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/public/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/public/nosotros">Nosotros</a>
                        <a href="/public/propiedades">Anuncios</a>
                        <a href="/public/blog">Blog</a>
                        <a href="/public/contacto">Contacto</a>
                        <?php if($auth): ?>
                            <a href="/public/logout">Cerrar Sesión</a>
                        <?php endif ?>    
                    </nav>
                </div>
   
                
            </div> <!--.barra-->

            <?php if($inicio) { ?>
                <h1>Venta de Casas y Departamentos  Exclusivos de Lujo</h1>
            <?php } ?>;
        </div>
    </header>

    <?php echo $contenido; ?>


    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.php">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>

        <p class="copyright">Todos los derechos Reservados <?php echo Date('Y');?> &copy;</p>
    </footer>

    <script src="/public/build/js/bundle.min.js"></script>
</body>
</html>