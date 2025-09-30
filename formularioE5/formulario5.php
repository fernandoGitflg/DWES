<?php
// Array asociativo de productos: nombre => precio
$productos = [
    "Camiseta" => 15.99,
    "Sudadera" => 29.95,
    "Pantalón" => 24.50,
    "Zapatillas" => 49.99,
    "Gorra" => 12.00
];

$total = 0;
$detalleCompra = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['articulos'])) {
    foreach ($_POST['articulos'] as $articulo) {
        if (isset($productos[$articulo])) {
            $precio = $productos[$articulo];
            $detalleCompra[] = "$articulo - €" . number_format($precio, 2, ',', '.');
            $total += $precio;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Online</title>
    <style>
        .error { color: red; }
        .producto { margin-bottom: 8px; }
    </style>
</head>
<body>
    <h1>Selecciona tus artículos</h1>

    <form method="post" action="">
        <?php foreach ($productos as $nombre => $precio): ?>
            <div class="producto">
                <label>
                    <input type="checkbox" name="articulos[]" value="<?= $nombre ?>">
                    <?= $nombre ?> - €<?= number_format($precio, 2, ',', '.') ?>
                </label>
            </div>
        <?php endforeach; ?>
        <br>
        <input type="submit" value="Comprar">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <h2>Detalle de la compra</h2>
        <?php if (empty($detalleCompra)): ?>
            <p class="error">No has seleccionado ningún artículo.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($detalleCompra as $linea): ?>
                    <li><?= $linea ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total: €<?= number_format($total, 2, ',', '.') ?></strong></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
