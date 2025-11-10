<?php
session_start();
require_once 'funciones.php';

// Verifica si hay una partida activa
if (!isset($_SESSION['board']) || !isset($_SESSION['intentos'])) {
    header('Location: index.php');
    exit;
}

// Procesar disparo si la partida sigue activa
if (isset($_GET['fila']) && isset($_GET['columna'])) {
    $filaDisparo = intval($_GET['fila']);
    $columnaDisparo = intval($_GET['columna']);
    $casillaDisparada = "$filaDisparo,$columnaDisparo";

    // Solo procesar si no ha terminado y no se ha disparado ya
    if (!in_array($casillaDisparada, $_SESSION['tiradas']) && $_SESSION['intentos'] > 0 && $_SESSION['aciertos'] < 16) {
        $_SESSION['tiradas'][] = $casillaDisparada;
        $_SESSION['intentos']--;

        if ($_SESSION['board'][$filaDisparo][$columnaDisparo] === 1) {
            $_SESSION['aciertos']++;
            $mensaje = "¡Tocado!";
        } else {
            $mensaje = "Agua...";
        }
    } else {
        $mensaje = "Casilla ya utilizada.";
    }
}

// Recalcular estado de la partida después del disparo
$totalCasillasDeBarco = 4 * 4; // 4 barcos de 4 casillas
$barcosHundidos = contarBarcosHundidos($_SESSION['board'], $_SESSION['tiradas']);
$partidaFinalizada = ($_SESSION['intentos'] <= 0 || $_SESSION['aciertos'] >= $totalCasillasDeBarco);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hundir la flota</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Hundir la flota</h1>

    <?php if (isset($mensaje)): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>

    <table>
        <?php for ($fila = 0; $fila < 10; $fila++): ?>
            <tr>
                <?php for ($columna = 0; $columna < 10; $columna++): 
                    $casilla = "$fila,$columna";
                    $hayBarco = $_SESSION['board'][$fila][$columna] === 1;
                    $fueDisparada = in_array($casilla, $_SESSION['tiradas']);

                    if ($fueDisparada) {
                        echo $hayBarco
                            ? "<td class='tocado'>X</td>"
                            : "<td class='agua'></td>";
                    } else {
                        if ($partidaFinalizada && $hayBarco) {
                            echo "<td class='barco'>B</td>"; // Revela barco al final
                        } else {
                            echo "<td><a href='juego.php?fila=$fila&columna=$columna'>?</a></td>";
                        }
                    }
                endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <div class="panel">
        <p>Intentos restantes: <?= $_SESSION['intentos'] ?></p>
        <p>Casillas por acertar: <?= $totalCasillasDeBarco - $_SESSION['aciertos'] ?></p>
        <p>Barcos hundidos: <?= $barcosHundidos ?></p>
    </div>

    <?php if ($partidaFinalizada): ?>
        <p><strong>Fin del juego.</strong></p>
    <?php endif; ?>

    <form action="reset.php" method="post">
        <button type="submit">Nueva partida</button>
    </form>
</body>
</html>
