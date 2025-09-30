<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border =1px>
        <tr>
            <?php
            $i = 1;
            while ($i <= 10) {
                echo "<td>" . $i . "</td>";
                $i++;
            }
            ?>
        </tr>

    </table>
</body>

</html>