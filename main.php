<?php

use Libro;
use Usuario;
use Estudiante;
use gestorBiblioteca;

$libro1 = new Libro("Los cien", "232819BNJD", "Maria Gutierrez", 287);
$libro2 = new Libro("Bosque negro", "232819BUJD", "Alfonso Gutierrez", 215);
$libro3 = new Libro("El laberinto", "232819FGHD", "Alberto Gonzalez", 180);
print_r($libro1->getInfo());
print_r($libro2->getInfo());
print_r($libro3->getInfo());


$libro1->getInfo();
$libro2->getInfo();
$libro3->getInfo();

$estudiante = new Estudiante("Adrian","adrian@gmail.com", "segundo");
echo $estudiante->get_datos();
echo $estudiante->get_tipo_usuario();

$gestor = new gestorBiblioteca();

$gestor->registrar_prestamo($libro1, $estudiante);
$gestor->registrar_prestamo($libro2, $estudiante);
$gestor->registrar_prestamo($libro3, $estudiante);

//deberia imprimir false ya que ya tiene 3 libros prestados
echo $estudiante->puede_tomar_prestado();

//deberia de imprimir un array con los 3 libros añadidos
print_r($estudiante->get_prestamos());

$gestor->registrar_devolucion($libro2);
//deberia imprimir un array con el libro 1 y 3
print_r($estudiante->get_prestamos());





