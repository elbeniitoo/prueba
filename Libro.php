<?php
use Usuario;

class Libro{
   
    public static int $total_libros = 0;
    public static int $total_prestados = 0;
    public bool $disponible = true;
    public string $titulo;
    public string $isbn;
    public string $autor;
    public int $num_paginas;
    public ?Usuario $usuario_prestamo;


    public function __construct(string $titulo, string $isbn, string $autor, int $num_paginas){
    self::$total_libros++;

    $this->titulo = $titulo;
    $this->isbn = $isbn;
    $this->autor = $autor;
    $this->num_paginas = $num_paginas;
    $this->disponible = true;
    $this->usuario_prestamo = null;
    }

    public function prestar(Usuario $usuario){
        if (!$this->disponible) {
            throw new Exception("El libro $this->titulo con ISBN: $this->isbn ya está prestado.");
        }

        $this->disponible = false;
        self::$total_prestados++;
        //asigno el usuario que tiene el prestamo
        $this->usuario_prestamo = $usuario;
       
    }

    public function devolver(){
        if ($this->disponible) {
            throw new Exception("El libro $this->titulo ISBN: $this->isbn no está prestado.");
        }

        $this->disponible = true;
        self::$total_prestados--;
        
    }

    public function getInfo(){
        return  [
            'disponible' => $this->disponible,
            'titulo' => $this->titulo,
            'isbn' => $this->isbn,
            'autor' => $this->autor,
            'num_paginas' => $this->num_paginas
        ];
        }


    public static function get_total_libros(){
        return "El total de libros es ". self::$total_libros;
    }

    public static function get_total_libros_prestados(){
        return "El total de libros prestados es de " . self::$total_prestados;
    }

    public function equals(Libro $otro){
        return $this->isbn === $otro->isbn;
    }
    
}