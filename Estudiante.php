<?php 
use Libro;
use Usuario;

class Estudiante extends Usuario{
protected string $grado;
protected int $limite_prestamos = 3;
protected int $prestamos_actuales = 0;
protected array $libros_prestados = [];

public function __construct(string $nombre, string $email, string $grado){
parent::__construct( $nombre,  $email);
$this->grado = $grado;
}

public function get_tipo_usuario(){
    return "Estudiante";
}

public function get_prestamos(){
   return $this->libros_prestados;
}

public function puede_tomar_prestado(): bool{
return $this->prestamos_actuales < $this->limite_prestamos;

}

public function agregar_prestamo(Libro $libro): void
    {
        $this->libros_prestados[] = $libro;
        $this->prestamos_actuales++;
    }

public function eliminar_prestamo(Libro $libro): void{
        foreach ($this->libros_prestados as $i => $prestado) {
            if ($prestado->equals($libro)) {
                unset($this->libros_prestados[$i]);
                $this->libros_prestados = array_values($this->libros_prestados); // reindexar
                $this->prestamos_actuales--;
                break;
            }
        }
   }

    public function get_info(): array
    {
        return array_merge($this->get_datos(), [
            'grado' => $this->grado,
            'prestamos_actuales' => $this->prestamos_actuales,
            'limite_prestamos' => $this->limite_prestamos
        ]);
    }

}