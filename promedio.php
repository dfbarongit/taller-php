<?php
$numList = empty($_POST["listNum"]) ? null : $_POST["listNum"];

function media(array $numList)
{
    $sum = 0;
    foreach ($numList as $num) {
        $sum += $num;
    }
    return $sum / count($numList);
}
function mediana(array $numList)
{
    sort($numList);
    $mediana = "";
    $mitad = floor(count($numList) / 2);
    if (count($numList) % 2 == 0) {
        $mediana = ($numList[$mitad - 1] + $numList[$mitad]) / 2;
    } else {
        $mediana = $numList[$mitad];
    }
    return $mediana;
}
function moda(array $numList)
{
    $modaMax = 0;
    $valoresModa = [];
    foreach ($numList as $num) {
        $repeticiones = 0;
        foreach ($numList as $num1) {
            if ($num == $num1) {
                $repeticiones++;
            }
        }
        if ($repeticiones > $modaMax) {
            $modaMax = $repeticiones;
            $valoresModa = [$num];
        } else if ($repeticiones == $modaMax && !in_array($num, $valoresModa, true)) {
            array_push($valoresModa, $num);
        }
    }
    $valoresModaStr = $valoresModa[0];
    for ($i = 1; $i < count($valoresModa); $i++) {
        $valoresModaStr .= ", " . $valoresModa[$i];
    }
    return "$valoresModaStr ($modaMax veces)";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Calculadora de Promedio</title>
</head>

<body>

    <h1>Calculadora de Promedio</h1>
    <form method="post" action="">
        <label class="subtitulo">Cuántos números deseas calcular:</label>
        <input type="number" name="numeros" min="0" required>
        <button type="submit">Guardar</button>
    </form>
    <form method="post" action="">
        <?php
        $cantidadNum = empty($_POST["numeros"]) ? null : $_POST["numeros"];

        for ($i = 0; $i < $cantidadNum; $i++) {
            echo '<label class="subtitulo">N.' . ($i + 1) . ':</label>
            <input type="number" name="listNum[]" required>
            <br>';
        }
        ?>
        <button type="submit">Calcular</button>
    </form>
    <div class="resultado">

        <?php

        if (!empty($numList)) {
            echo '<h2 class=subtitulo>Lista: </h2>';
            foreach ($numList as $num) {
                echo "$num <br> ";
            }
            echo '<h2 class=subtitulo>Cantidad de números: ' . $cantidadNum . "</h2><br>";
            echo '<h2 class=subtitulo>Media: ' . media($numList) . "</h2><br>";
            echo '<h2 class=subtitulo>Moda: ' . moda($numList) . "</h2><br>";
            echo '<h2 class=subtitulo>Mediana: ' . mediana($numList) . "</h2><br>";
        }

        ?>
    </div>

</body>

</html>