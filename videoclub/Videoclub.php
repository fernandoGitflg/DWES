<?php
declare(strict_types=1);
require_once 'CintaVideo.php';
require_once 'Dvd.php';
require_once 'Juego.php';
require_once 'Cliente.php';

class Videoclub {
    private string $nombre;
    private array $productos = [];
    private array $socios = [];

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
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
        echo "Productos en {$this->nombre}:\n";
        foreach ($this->productos as $s) {
            $s->muestraResumen();
        }
    }

    public function listarSocios(): void {
        echo "Socios de {$this->nombre}:\n";
        foreach ($this->socios as $c) {
            $c->muestraResumen();
        }
    }

    public function alquilarSocioProducto(int $numeroCliente, int $numeroSoporte): void {
        $cliente = $this->socios[$numeroCliente - 1];
        $soporte = $this->productos[$numeroSoporte - 1];
        $cliente->alquilar($soporte);
    }

    public function getSocios(): array {
        return $this->socios;
    }
}
