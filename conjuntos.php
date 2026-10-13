<?php
$conjuntoAText = empty($_GET["numerosA"]) ? null : $_GET["numerosA"];
$conjuntoBText = empty($_GET["numerosB"]) ? null : $_GET["numerosB"];

if (!empty($conjuntoAText) && !empty($conjuntoBText)) {

    $numerosA = normalizarConjunto($conjuntoAText);
    $numerosB = normalizarConjunto($conjuntoBText);

    if (!preg_match('/^[0-9, ]+$/', $conjuntoAText)) {
        echo "Error: La cadena contiene letras u otros caracteres no permitidos.";
    }
}

function normalizarConjunto(string $conjuntoText)
{
    $conjuntoNum = [];
    for ($i = 0; $i < strlen($conjuntoText); $i++) {
        if (is_numeric($conjuntoText[$i])) {
            $numActual = "";
            while (is_numeric($conjuntoText[$i])) {
                $numActual .= $conjuntoText[$i];
                $i++;
                if ($i >= strlen($conjuntoText))
                    break;
            }
            array_push($conjuntoNum, $numActual);
        }
    }
    #eliminar repetidos
    $conjuntoNum = array_values(array_unique($conjuntoNum));
    return $conjuntoNum;
}

function imprimirConjunto(array $conjunto, string $nomConjunto)
{
    echo "<h2>Conjunto $nomConjunto: {";
    if (count($conjunto) > 0) {
        echo $conjunto[0];
    }
    for ($i = 1; $i < count($conjunto); $i++) {
        echo "," . $conjunto[$i];
    }
    echo "}</h2>";
}
function union(array $conjA, array $conjB)
{
    $resultado = [];
    foreach ($conjA as $elemA) {
        array_push($resultado, $elemA);
    }
    foreach ($conjB as $elemB) {
        array_push($resultado, $elemB);
    }
    $resultado = array_values(array_unique($resultado));
    return $resultado;
}
function interseccion(array $conjA, array $conjB)
{
    $resultado = [];
    foreach ($conjA as $elemA) {
        if (in_array($elemA, $conjB)) {
            array_push($resultado, $elemA);
        }
    }
    return $resultado;
}
function diferencia(array $conjA, array $conjB)
{
    $resultado = $conjA;
    foreach ($conjA as $elemA) {
        if (in_array($elemA, $conjB)) {
            $indice = array_search($elemA, $resultado);
            if ($indice !== false) {
                unset($resultado[$indice]);
            }
        }
    }
    $resultado = array_values($resultado);
    return $resultado;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Promedio</title>
</head>

<body>

    <div class="container">
        <h2>Calculadora de Conjuntos</h2>
        <form method="get" action="">
            <label>Cuántos números contiene el conjunto A:</label>
            <input type="text" name="numerosA" min="0" required>
            <label>Cuántos números contiene el conjunto B:</label>
            <input type="text" name="numerosB" min="0">
            <button type="submit">Calcular</button>
        </form>
        <?php
        if (!empty($numerosA) && !empty($numerosB)) {
            imprimirConjunto($numerosA, "A");
            imprimirConjunto($numerosB, "B");
            $union = union($numerosA, $numerosB);
            $inter = interseccion($numerosA, $numerosB);
            $difab = diferencia($numerosA, $numerosB);
            $difba = diferencia($numerosB, $numerosA);
            imprimirConjunto($union, "A u B");
            imprimirConjunto($inter, "A n B");
            imprimirConjunto($difab, "A - B");
            imprimirConjunto($difba, "B - A");
        }
        ?>
    </div>

</body>

</html>