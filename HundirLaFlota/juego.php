<?php
session_start();
require_once 'funciones.php';

$temaVisual = $_COOKIE['tema_usuario'] ?? 'claro';

if (!isset($_SESSION['board']) || !isset($_SESSION['intentos'])) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['fila'], $_GET['columna'])) {
    $fila = intval($_GET['fila']);
    $columna = intval($_GET['columna']);
    $casilla = "$fila,$columna";

    if (!in_array($casilla, $_SESSION['tiradas']) && $_SESSION['intentos'] > 0 && $_SESSION['aciertos'] < 16) {
        $_SESSION['tiradas'][] = $casilla;
        $_SESSION['intentos']--;

        if ($_SESSION['board'][$fila][$columna] === 1) {
            $_SESSION['aciertos']++;
            $mensaje = "¡Tocado!";

            // Comprobación de si el barco ha sido hundido
            $direccionPosible = [[0, 1], [1, 0]]; // horizontal y vertical
            foreach ($direccionPosible as [$incrementoFila, $incrementoColumna]) {
                $filaInicio = $fila;
                $columnaInicio = $columna;

                // Retrocede hasta el inicio del barco en esta dirección
                while (
                    $filaInicio - $incrementoFila >= 0 &&
                    $columnaInicio - $incrementoColumna >= 0 &&
                    $_SESSION['board'][$filaInicio - $incrementoFila][$columnaInicio - $incrementoColumna] === 1
                ) {
                    $filaInicio -= $incrementoFila;
                    $columnaInicio -= $incrementoColumna;
                }

                // Recorre hasta 4 casillas en esa dirección
                $casillasDelBarco = [];
                for ($i = 0; $i < 4; $i++) {
                    $filaActual = $filaInicio + $i * $incrementoFila;
                    $columnaActual = $columnaInicio + $i * $incrementoColumna;

                    if (
                        $filaActual > 9 || $columnaActual > 9 ||
                        $_SESSION['board'][$filaActual][$columnaActual] !== 1
                    ) {
                        break;
                    }

                    $casillasDelBarco[] = "$filaActual,$columnaActual";
                }

                // Si se han detectado 4 casillas de barco, comprobar si todas han sido disparadas
                if (count($casillasDelBarco) === 4) {
                    $barcoHundido = true;
                    foreach ($casillasDelBarco as $casillaBarco) {
                        if (!in_array($casillaBarco, $_SESSION['tiradas'])) {
                            $barcoHundido = false;
                            break;
                        }
                    }

                    if ($barcoHundido) {
                        $mensaje = "¡Hundido!";
                    }

                    break;
                }
            }
        } else {
            $mensaje = "Agua...";
        }
    } else {
        $mensaje = "Casilla ya utilizada.";
    }
}


$total = 4 * 4;
$hundidos = contarBarcosHundidos($_SESSION['board'], $_SESSION['tiradas']);
$final = ($_SESSION['intentos'] <= 0 || $_SESSION['aciertos'] >= $total);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Hundir la flota</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body class="<?= htmlspecialchars($temaVisual) ?>">
    <h1 class="titulo-tablero">Hundir la flota</h1>

    <div class="contenedor-juego">
        <div class="bloque-tablero">
            <table>
                <?php for ($fila = 0; $fila < 10; $fila++): ?>
                    <tr>
                        <?php for ($columna = 0; $columna < 10; $columna++):
                            $casilla = "$fila,$columna";
                            $barco = $_SESSION['board'][$fila][$columna] === 1;
                            $tirada = in_array($casilla, $_SESSION['tiradas']);

                            if ($tirada) {
                                echo $barco ? "<td class='tocado'>X</td>" : "<td class='agua'></td>";
                            } else {
                                if ($final && $barco) {
                                    echo "<td class='barco'>B</td>";
                                } else {
                                    echo "<td><a href='juego.php?fila=$fila&columna=$columna'>?</a></td>";
                                }
                            }
                        endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>

        <div class="panel">
            <p><strong>Intentos:</strong> <?= $_SESSION['intentos'] ?></p>
            <p><strong>Por acertar:</strong> <?= $total - $_SESSION['aciertos'] ?></p>
            <p><strong>Hundidos:</strong> <?= $hundidos ?></p>

            <?php if (isset($mensaje)): ?>
                <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

            <?php if ($final): ?>
                <p><strong>Fin del juego.</strong></p>
            <?php endif; ?>

            <form action="reset.php" method="post">
                <button type="submit">Nueva partida</button>
            </form>
        </div>
    </div>
</body>

</html>