<?php

use Libro;
use Usuario;
use Estudiante;

class gestorBiblioteca{

    public function __construct(){

    }

    public function registrar_prestamo(Libro $libro, Usuario $usuario){
     if (!$libro->disponible) {
            throw new Exception("El libro '{$libro->titulo}' no está disponible para préstamo.");
        }

        if (!$usuario->puede_tomar_prestado()) {
            throw new Exception("El usuario '{$usuario->get_datos()['nombre']}' ha alcanzado su límite de préstamos.");
        }
        $libro->prestar($usuario);

        if (method_exists($usuario, 'get_prestamos') && method_exists($usuario, 'agregar_prestamo')) {
    // evitar duplicados
    foreach ($usuario->get_prestamos() as $l) {
        if ($l->equals($libro)) { 
          $ya = true; 
          break; 
        }
    }
    if (!$ya) 
      $usuario->agregar_prestamo($libro);
} else {
    $libro->devolver(); // revertir
    throw new Exception("No se pudo registrar el préstamo: el usuario no permite registrar préstamos.");
}
  }

 public static function registrar_devolucion(Libro $libro): void{
        // 1) Verificar que el libro esté prestado
        if ($libro->disponible) {
            throw new Exception("El libro '{$libro->titulo}' no está en préstamo (no se puede devolver).");
        }

        // 2) Obtener el usuario que tiene el libro (Libro::prestar() debe haberlo dejado asignado)
        $usuario = $libro->usuario_prestamo;

        // 3) Si hay usuario, pedirle que quite el préstamo de su lista usando el método público correspondiente
        if ($usuario !== null) {
            if (!method_exists($usuario, 'eliminar_prestamo')) {
                // No podemos actualizar al usuario: dejamos todo como estaba y lanzamos excepción
                throw new Exception("No se puede actualizar el usuario: falta el método público 'eliminar_prestamo'.");
            }

            // ejecutar eliminación en el usuario *antes* de llamar a $libro->devolver()
            // (porque devolver limpia $libro->usuario_prestamo)
            $usuario->eliminar_prestamo($libro);
        }

        // 4) Finalmente, devolver el libro (actualiza disponible, usuario_prestamo y contador estático)
        $libro->devolver();
    }

}
