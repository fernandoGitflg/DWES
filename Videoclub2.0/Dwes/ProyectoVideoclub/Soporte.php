<?php
namespace Dwes\ProyectoVideoclub;

class Soporte {
    protected string $titulo;
    protected int $numero;
    private float $precio;

    // Nueva propiedad
    public bool $alquilado = false;

    public const IVA = 0.21;

    public function __construct(string $titulo, int $numero, float $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
        $this->alquilado = false; // inicializado
    }

    public function getTitulo(): string { return $this->titulo; }
    public function getNumero(): int { return $this->numero; }
    public function getPrecio(): float { return $this->precio; }
    public function getPrecioConIva(): float { return $this->precio * (1 + self::IVA); }

    public function muestraResumen(): void {
        echo "Soporte #{$this->numero}: {$this->titulo} - Precio base: {$this->precio}€";
        echo $this->alquilado ? " (ALQUILADO)<br>" : " (DISPONIBLE)<br>";
    }
}
