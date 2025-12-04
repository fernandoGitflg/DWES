<?php
declare(strict_types=1);
require_once 'Soporte.php';

class Dvd extends Soporte {
    private string $idiomas;
    private string $formatoPantalla;

    public function __construct(string $titulo, int $numero, float $precio, string $idiomas, string $formatoPantalla) {
        parent::__construct($titulo, $numero, $precio);
        $this->idiomas = $idiomas;
        $this->formatoPantalla = $formatoPantalla;
    }

    public function muestraResumen(): void {
        parent::muestraResumen();
        echo "Idiomas: {$this->idiomas} | Pantalla: {$this->formatoPantalla}\n";
    }
}
