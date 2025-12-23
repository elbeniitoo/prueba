<?php 

abstract class Usuario{
protected string $nombre;
protected string $email;
protected string $fecha_registro;
protected static int $total_usuarios = 0;

public function __construct(string $nombre, string $email, ?string $fecha_registro=null){
    $this->nombre = $nombre;
    $this->email = $email;  
    $this->fecha_registro = $fecha_registro ?? date('Y-m-d');

     self::$total_usuarios++;
}

public function get_datos(){
    return[
    'nombre' => $this->nombre,
    'email' => $this->email,
    'fecha_registro' => $this->fecha_registro,
    ];
}

public abstract function get_tipo_usuario();
 abstract public function puede_tomar_prestado(): bool;

public static function get_total_usuarios() : int {
    return self::$total_usuarios;
}
}