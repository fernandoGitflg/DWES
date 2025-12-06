<?php
declare(strict_types=1);
namespace Dwes\ProyectoVideoclub;

include_once 'Soporte.php';

class Juego extends Soporte {
    private string $consola;
    private int $minNumJugadores;
    private int $maxNumJugadores;

    public function __construct(string $titulo, int $numero, float $precio, string $consola, int $minJ, int $maxJ) {
        parent::__construct($titulo, $numero, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minJ;
        $this->maxNumJugadores = $maxJ;
    }

    public function muestraJugadoresPosibles(): void {
        echo "Jugadores: de {$this->minNumJugadores} a {$this->maxNumJugadores}\n";
    }

    public function muestraResumen(): void {
        parent::muestraResumen();
        echo "Consola: {$this->consola} Jugadores: de {$this->minNumJugadores} a {$this->maxNumJugadores}<br>";
    }

}
