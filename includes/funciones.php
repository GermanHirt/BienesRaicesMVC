<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '../public/imagenes/');


function incluirTemplate( $nombre, $inicio = false) {
    include TEMPLATES_URL . "/{$nombre}.php";

}

function estaAutenticado()  {
  session_start();

  if(!$_SESSION['login']) {
     header('Location: /');
  }
  return true;

}


function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa del HTML
function sanitizar($html) {
  $sanitizar = htmlspecialchars($html);
  return $sanitizar;
}

// Validar tipo de Contenido
function validarTipoContenido($tipo) {
  $tipos = ['vendedor', 'propiedad'];

  return in_array($tipo, $tipos);
}


// Muestra los Mensajes
function mostrarNotificacion($codigo){
  $mensaje = '';

  switch($codigo){
    case 1: 
      $mensaje = 'Creado Correctamente';
      break;
    case 2: 
      $mensaje = 'Actualizado Correctamente';
      break;
    case 3: 
      $mensaje = 'Eliminado Correctamente';
      break;
    default:
      $mensaje = false;
      break;
  }

  return $mensaje;
}


function validarORediccionar(string $url){
    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: {$url}");
    }

    return $id;
}