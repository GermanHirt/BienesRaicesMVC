<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;
        
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio

        ]);

    }

    public static function nosotros(Router $router) {

        $router->render('paginas/nosotros');
        
    }

    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades

        ] );     
    }

    public static function propiedad(Router $router) {
       
        $id = validarORediccionar('/propiedades');

        // Buscar la propiedad por su ID
        $propiedad = Propiedad::find($id);
         
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
            
            
        ]);

    }

    public static function blog(Router $router) {

        $router->render('paginas/blog');
        
    }

    public static function entrada(Router $router) {
        $router->render('paginas/entrada');



    }

    public static function contacto(Router $router) {

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           
            $respuestas = $_POST['contacto'];

         

            // Crear una instancia de PhpMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '33cfacb13338a7';
            $mail->Password = '74886523af5af7';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';
            
            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';


            // Definir el Contenido
            $contenido ='<html>';
            $contenido .='<p><b>Tienes un nuevo mensaje</b><p>';
            $contenido .='<p><b>Nombre: </b>' . $respuestas['nombre'] . '</p>';
            

            // Enviar de forma condicional algunos campos de Email o Telefono
            if($respuestas['contacto'] === 'telefono') {
                $contenido .='<p><b>Eligio ser contactado por Telefono</b><p>';
                $contenido .='<p><b>Telefono: </b>' . $respuestas['telefono'] . '</p>';
                $contenido .='<p><b>Fecha de Contacto: </b>' . $respuestas['fecha'] . '</p>';
                $contenido .='<p><b>Hora: </b>' . $respuestas['hora'] . '</p>';
            } else {
                // Es Email entonces agregamos campo de email
                $contenido .='<p><b>Eligio ser contactado por Email</b><p>';
                $contenido .='<p><b>Email: </b>' . $respuestas['email'] . '</p>';
            }
                   
            $contenido .='<p><b>Mensaje: </b>' . $respuestas['mensaje'] . '</p>';
            $contenido .='<p><b>Vende o Compra: </b>' . $respuestas['tipo'] . '</p>';
            $contenido .='<p><b>Precio o Presupuesto: </b>$ ' . $respuestas['precio'] . '</p>';
            $contenido .='<p><b>Prefiere ser contctado por: </b>' . $respuestas['contacto'] . '</p>';
            $contenido .='</html>';

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es texto alternativo sin HTML";

            // Enviar el Email

            if($mail->send()) {
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar...";
            }


        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);

    }


}