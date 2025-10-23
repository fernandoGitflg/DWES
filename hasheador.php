<?php
$clave = '1111';
$hash = password_hash($clave, PASSWORD_DEFAULT);
echo $hash;

//$hash = '$2y$10$rn5BTva2jKac4asgw3qCXem0v0lZ1YB/virqorzgnJu8e/8p2NZzK';
$input = '1111';

if (password_verify($input, $hash)) {
    echo "✅ Coincide";
} else {
    echo "❌ No coincide";
}
?>