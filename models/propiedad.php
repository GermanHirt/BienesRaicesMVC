<?php

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitacion', 'wc', 'estacionamiento', 'creado', 'vendedor'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitacion;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedor;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitacion = $args['habitacion'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor = $args['vendedor'] ?? '';

    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "Debe añadir un titulo";
        }
        
        if(!$this->precio) {
            self::$errores[] = "El Precio es Obligatorio";
        }

        if(!$this->descripcion) {
            self::$errores[] = "La Descripción es obligatoria y debe tener al menos 50 caracteres";
        }

        if(!$this->habitacion) {
            self::$errores[] = "El Numero de habitaciones es obligatorio";
        }

        if(!$this->wc) {
            self::$errores[] = "El Numero de baños es obligatorio";
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "El Numero de lugares de estacionamiento es obligatorio";
        }

        if(!$this->vendedor) {
            self::$errores[] = "Elige un vendedor";
        }

        if(!$this->imagen ) {
            self::$errores[] = "La Imagen es Obligatoria";
        }

        return self::$errores;
    }

}