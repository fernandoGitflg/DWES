<?php
namespace Dwes\ProyectoVideoclub;

include_once 'CintaVideo.php';
include_once 'Dvd.php';
include_once 'Juego.php';
include_once 'Cliente.php';
include_once 'Util/ClienteNoEncontradoException.php';
include_once 'Util/SoporteNoEncontradoException.php';
include_once 'Util/VideoclubException.php';

use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\VideoclubException;

class Videoclub {
    private string $nombre;
    private array $productos = [];
    private array $socios = [];

    private int $numProductosAlquilados = 0;
    private int $numTotalAlquileres = 0;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    public function getNumProductosAlquilados(): int {
        return $this->numProductosAlquilados;
    }

    public function getNumTotalAlquileres(): int {
        return $this->numTotalAlquileres;
    }
    public function alquilarSocioProductos(int $numSocio, array $numerosProductos): void {
        try {
            if (!isset($this->socios[$numSocio - 1])) {
                throw new ClienteNoEncontradoException("Cliente #{$numSocio} no encontrado.");
            }
            $cliente = $this->socios[$numSocio - 1];

            $soportes = [];
            foreach ($numerosProductos as $numSoporte) {
                if (!isset($this->productos[$numSoporte - 1])) {
                    throw new SoporteNoEncontradoException("Soporte #{$numSoporte} no encontrado.");
                }
                $soportes[] = $this->productos[$numSoporte - 1];
            }

            foreach ($soportes as $s) {
                if ($s->alquilado) {
                    throw new \Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException(
                        "El soporte '{$s->getTitulo()}' ya está alquilado."
                    );
                }
            }

            foreach ($soportes as $s) {
                $cliente->alquilar($s);
                $this->numProductosAlquilados++;
                $this->numTotalAlquileres++;
            }

            echo "Cliente {$numSocio} ha alquilado varios productos correctamente.<br>";

        } catch (VideoclubException $e) {
            echo "Error en alquiler múltiple: " . $e->getMessage() . "<br>";
        }
    }

    public function devolverSocioProducto(int $numSocio, int $numeroProducto): void {
        try {
            if (!isset($this->socios[$numSocio - 1])) {
                throw new ClienteNoEncontradoException("Cliente #{$numSocio} no encontrado.");
            }
            $cliente = $this->socios[$numSocio - 1];
            $cliente->devolver($numeroProducto);

            $this->numProductosAlquilados--;

            echo "Cliente {$numSocio} ha devuelto el soporte #{$numeroProducto}<br>";
        } catch (VideoclubException $e) {
            echo "Error en devolución: " . $e->getMessage() . "<br>";
        }
    }

    public function devolverSocioProductos(int $numSocio, array $numerosProductos): void {
        try {
            if (!isset($this->socios[$numSocio - 1])) {
                throw new ClienteNoEncontradoException("Cliente #{$numSocio} no encontrado.");
            }
            $cliente = $this->socios[$numSocio - 1];

            foreach ($numerosProductos as $numSoporte) {
                $cliente->devolver($numSoporte);
                $this->numProductosAlquilados--;
            }

            echo "Cliente {$numSocio} ha devuelto varios productos correctamente.<br>";
        } catch (VideoclubException $e) {
            echo "Error en devolución múltiple: " . $e->getMessage() . "<br>";
        }
    }

    public function incluirProducto(Soporte $producto): void {
        $this->productos[] = $producto;
    }

    public function incluirCintaVideo(string $titulo, float $precio, int $duracion): void {
        $this->incluirProducto(new CintaVideo($titulo, count($this->productos) + 1, $precio, $duracion));
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): void {
        $this->incluirProducto(new Dvd($titulo, count($this->productos) + 1, $precio, $idiomas, $pantalla));
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): void {
        $this->incluirProducto(new Juego($titulo, count($this->productos) + 1, $precio, $consola, $minJ, $maxJ));
    }

    public function incluirSocio(string $nombre, int $maxAlquileresConcurrentes = 3): void {
        $this->socios[] = new Cliente($nombre, count($this->socios) + 1, $maxAlquileresConcurrentes);
    }

    public function listarProductos(): void {
        echo "Productos en {$this->nombre}:<br>";
        foreach ($this->productos as $s) {
            $s->muestraResumen();
        }
    }

    public function listarSocios(): void {
        echo "Socios de {$this->nombre}:<br>";
        foreach ($this->socios as $c) {
            $c->muestraResumen();
        }
    }

    public function getSocios(): array {
        return $this->socios;
    }
}
