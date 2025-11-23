Proyecto: Hundir la flota

Contenido del README:
----------------------

1. Requisitos:
   - Servidor web con soporte PHP 
   - Navegador moderno (Chrome, Firefox, Edge)
   - Archivos del proyecto: index.php, juego.php, funciones.php, estilo.css
   - Opcional: archivo de barcos en formato .txt para carga manual

2. Cómo ejecutar:
   - Coloca todos los archivos en la carpeta raíz del servidor (por ejemplo, htdocs/)
   - Accede a `http://localhost/HundirLaFlota` desde el navegador
   - Selecciona número de intentos y modo de generación (aleatorio o desde fichero)
   - Pulsa "Empezar partida" para iniciar el juego

3. Flujo del juego:
   - Inicio → selección de intentos y modo → carga del tablero
   - Disparos → el jugador hace clic en las casillas para intentar hundir barcos
   - Fin → el juego termina cuando se hunden todos los barcos o se agotan los intentos
   - Reinicio → se puede volver al inicio desde el panel lateral

4. Preferencias visuales:
   - El usuario puede seleccionar tema claro u oscuro desde index.php
   - La preferencia se guarda en una cookie y se aplica también en juego.php

5. Notas adicionales:
   - El tablero es de 10x10 casillas
   - Cada barco ocupa 4 casillas consecutivas
   - Se muestran mensajes de "Agua", "Tocado" o "Hundido" según el resultado
