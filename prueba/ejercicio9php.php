<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
        <?php
        $num = rand(1, 10);
        for ($i = 1; $i <= $num; $i++) {
            echo "<td>".$i * $num."</td>";
        }
        ?>
        </tr>
    </table>
</body>

</html>