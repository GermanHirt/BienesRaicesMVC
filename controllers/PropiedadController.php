<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image; 



class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();


        //Muestra un mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

         
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores

        ]);
    }
    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
                /** CREA UNA NUEVA INSTANCIA */
            $propiedad = new Propiedad($_POST['propiedad']);

            //** SUBIDA DE ARCHIVOS */
            //Crear Archivo
            $carpetaImagenes = '/public/imagenes/';
            if (!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes);
            }

            //Generar nombre unico
            $nombreImagen = md5( uniqid( rand(), true)) . ".jpg";

            // Setear la Imagen
            // Realiza un resize a la imagen con Intervention
            if($_FILES['propiedad'] ['tmp_name']['imagen']) {             
                $image = Image::make($_FILES['propiedad'] ['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

          
            
            // Validar
            $errores = $propiedad->validar();

            if (empty($errores)) {
                
                // Crear carpeta para subir Imagenes
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                                        
                // Guardar imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen); 

                // Guarda en la Base de Datos
                $propiedad->guardar();  

            }         
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router) {
    
            $id = validarORediccionar('/public/admin');
            $propiedad = Propiedad::find($id);

            $vendedores = Vendedor::all();

            $errores = Propiedad::getErrores();

               //Metodo POST para Actualizar
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
                // Asignar los atributos
                $args = $_POST['propiedad'];

                $propiedad->sincronizar($args); 

                // Validacion
                $errores = $propiedad->validar();

                
                // Subida de Archivos
                //Generar nombre unico
                $nombreImagen = md5( uniqid( rand(), true)) . ".jpg";

                if($_FILES['propiedad'] ['tmp_name']['imagen']) {
                    $image = Image::make($_FILES['propiedad'] ['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);
                }


                if (empty($errores)) {
                    if($_FILES['propiedad'] ['tmp_name']['imagen']) {
                        // Almacenar Imagen
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                    }

                    $propiedad->guardar();
                }      
            }

            $router->render('propiedades/actualizar', [ 
                'propiedad' => $propiedad,
                'errores' => $errores,
                'vendedores' => $vendedores
            ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
                // Validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                } 
            }
        }

    }

}