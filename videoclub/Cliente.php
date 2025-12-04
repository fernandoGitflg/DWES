<?php
declare(strict_types=1);
require_once 'Soporte.php';

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
            echo "No puede alquilar más soportes.\n";
            return false;
        }
        if ($this->tieneAlquilado($soporte)) {
            echo "Ya tiene alquilado este soporte.\n";
            return false;
        }
        $this->soportesAlquilados[] = $soporte;
        echo "{$this->nombre} ha alquilado: {$soporte->getNumero()} - {$soporte->getTitulo()}\n";
        return true;
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        return in_array($soporte, $this->soportesAlquilados, true);
    }

    public function devolver(int $numSoporte): bool {
        foreach ($this->soportesAlquilados as $key => $s) {
            if ($s->getNumero() === $numSoporte) {
                unset($this->soportesAlquilados[$key]);
                echo "{$this->nombre} ha devuelto el soporte #{$numSoporte}\n";
                return true;
            }
        }
        echo "No se encontró el soporte.\n";
        return false;
    }

    public function listaAlquileres(): void {
        echo "Soportes alquilados por {$this->nombre}:\n";
        foreach ($this->soportesAlquilados as $s) {
            $s->muestraResumen();
        }
    }

    public function muestraResumen(): void {
        echo "Cliente #{$this->numero}: {$this->nombre} | Máx alquileres: {$this->maxAlquilerConcurrente}\n";
    }
}
