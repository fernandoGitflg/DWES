<?php
function generarBarcosAleatorios() {
    $tablero = array_fill(0, 10, array_fill(0, 10, 0));
    $barcos_colocados = 0;

    while ($barcos_colocados < 4) {
        $orientacion = rand(0, 1); //0 HORIZONTAL 1 VERTICAL
        $x = rand(0, 9);
        $y = rand(0, 9);

        $coordenadas = [];

        for ($i = 0; $i < 4; $i++) {
            $nuevaX = $orientacion === 0 ? $x : $x + $i;
            $nuevaY = $orientacion === 0 ? $y + $i : $y;

            if ($nuevaX > 9 || $nuevaY > 9 || $tablero[$nuevaX][$nuevaY] === 1) {
                $coordenadas = [];
                break;
            }

            $coordenadas[] = [$nuevaX, $nuevaY];
        }

        if (count($coordenadas) === 4) {
            foreach ($coordenadas as [$filaBarco, $columnaBarco]) {
                $tablero[$filaBarco][$columnaBarco] = 1;
            }
            $barcos_colocados++;
        }
    }

    return $tablero;
}
function contarBarcosHundidos($tablero, $casillasDisparadas) {
    $casillasExploradas = array_fill(0, 10, array_fill(0, 10, false));
    $barcosHundidos = 0;

    for ($fila = 0; $fila < 10; $fila++) {
        for ($columna = 0; $columna < 10; $columna++) {
            if ($tablero[$fila][$columna] === 1 && !$casillasExploradas[$fila][$columna]) {
                $casillasDelBarco = explorarBarco($tablero, $fila, $columna, $casillasExploradas);
                $barcoHundido = true;

                foreach ($casillasDelBarco as [$filaBarco, $columnaBarco]) {
                    if (!in_array("$filaBarco,$columnaBarco", $casillasDisparadas)) {
                        $barcoHundido = false;
                        break;
                    }
                }

                if ($barcoHundido) {
                    $barcosHundidos++;
                }
            }
        }
    }

    return $barcosHundidos;
}

function explorarBarco($tablero, $filaInicial, $columnaInicial, &$casillasExploradas) {
    $direccionesFila = [0, 1];// horizontal y vertical
    $direccionesColumna = [1, 0];

    foreach ($direccionesFila as $indice => $incrementoFila) {
        $incrementoColumna = $direccionesColumna[$indice];
        $casillasCandidatas = [];

        for ($i = 0; $i < 4; $i++) {
            $filaActual = $filaInicial + $i * $incrementoFila;
            $columnaActual = $columnaInicial + $i * $incrementoColumna;

            if (
                $filaActual > 9 || $columnaActual > 9 ||
                $tablero[$filaActual][$columnaActual] !== 1 ||
                $casillasExploradas[$filaActual][$columnaActual]
            ) {
                $casillasCandidatas = [];
                break;
            }

            $casillasCandidatas[] = [$filaActual, $columnaActual];
        }

        if (count($casillasCandidatas) === 4) {
            foreach ($casillasCandidatas as [$filaBarco, $columnaBarco]) {
                $casillasExploradas[$filaBarco][$columnaBarco] = true;
            }
            return $casillasCandidatas;
        }
    }

    return [[$filaInicial, $columnaInicial]]; // fallback si no se detecta barco completo
}
function validarFicheroBarcos($rutaFichero) {
    $lineas = file($rutaFichero, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        $casillas = explode(';', $linea);
        if (count($casillas) !== 4) return false;

        $coordenadas = [];
        foreach ($casillas as $casilla) {
            if (!preg_match('/^\d+,\d+$/', $casilla)) return false;
            [$fila, $columna] = explode(',', $casilla);
            $fila = intval($fila);
            $columna = intval($columna);
            if ($fila < 0 || $fila > 9 || $columna < 0 || $columna > 9) return false;
            $coordenadas[] = [$fila, $columna];
        }

        // Verifica que las 4 casillas sean contiguas y lineales (no en L)
        if (!esBarcoValido($coordenadas)) return false;
    }

    return true;
}
function esBarcoValido($coordenadas) {
    $filas = array_column($coordenadas, 0);
    $columnas = array_column($coordenadas, 1);

    // Horizontal: misma fila, columnas consecutivas
    if (count(array_unique($filas)) === 1) {
        sort($columnas);
        return $columnas === range($columnas[0], $columnas[0] + 3);
    }

    // Vertical: misma columna, filas consecutivas
    if (count(array_unique($columnas)) === 1) {
        sort($filas);
        return $filas === range($filas[0], $filas[0] + 3);
    }

    return false; // Forma inválida (en L o disperso)
}
function cargarBarcosDesdeFichero($rutaFichero) {
    $tablero = array_fill(0, 10, array_fill(0, 10, 0));
    if (!file_exists($rutaFichero)) {
        return generarBarcosAleatorios();
    }
    $lineasBarcos = file($rutaFichero, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lineasBarcos as $lineaBarco) {
        $casillasBarco = explode(';', $lineaBarco);
        foreach ($casillasBarco as $casilla) {
            [$fila, $columna] = explode(',', $casilla);
            $tablero[intval($fila)][intval($columna)] = 1;
        }
    }
    return $tablero;
}

