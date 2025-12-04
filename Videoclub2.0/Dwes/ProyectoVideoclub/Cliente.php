<?php
namespace Dwes\ProyectoVideoclub;

include_once 'Soporte.php';
include_once 'Util/SoporteYaAlquiladoException.php';
include_once 'Util/CupoSuperadoException.php';
include_once 'Util/SoporteNoEncontradoException.php';

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

class Cliente {
    private string $nombre;
    private int $numero;
    private array $soportesAlquilados = [];
    private int $maxAlquilerConcurrente;

    public function __construct(string $nombre, int $numero, int $maxAlquilerConcurrente = 3) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }

    public function alquilar(Soporte $soporte): bool {
        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("El cliente {$this->nombre} ha alcanzado el cupo máximo de alquileres.");
        }
        if ($this->tieneAlquilado($soporte)) {
            throw new SoporteYaAlquiladoException("El soporte '{$soporte->getTitulo()}' ya está alquilado por {$this->nombre}.");
        }
        $this->soportesAlquilados[] = $soporte;
        $soporte->alquilado = true; // marcar como alquilado
        return true;
    }

    public function devolver(int $numSoporte): bool {
        foreach ($this->soportesAlquilados as $key => $s) {
            if ($s->getNumero() === $numSoporte) {
                unset($this->soportesAlquilados[$key]);
                $s->alquilado = false; 
                return true;
            }
        }
        throw new SoporteNoEncontradoException("El soporte #{$numSoporte} no está alquilado por {$this->nombre}.");
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        return in_array($soporte, $this->soportesAlquilados, true);
    }

    public function listaAlquileres(): void {
        echo "<ul>";
        foreach ($this->soportesAlquilados as $s) {
            echo "<li>";
            $s->muestraResumen();
            echo "</li>";
        }
        echo "</ul>";
    }

    public function muestraResumen(): void {
        echo "Cliente #{$this->numero}: {$this->nombre} | Máx alquileres: {$this->maxAlquilerConcurrente}<br>";
    }
}
