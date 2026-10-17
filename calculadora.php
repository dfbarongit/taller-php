<?php
$valor1 = "";
$valor2 = "";
$valorActual = empty($_GET["valorActual"]) ? null : $_GET["valorActual"];


$valorSalida = "";
$operacion = "";

$historialOperaciones = [];

$presentarResultado = false;
//asegurar que el primer digito no es directamente la operacion
if (!empty($valorActual)) {
    if (esOperacion($valorActual[0]) || $valorActual[0] == "i") {
        $valorActual = "";
        $valorSalida = "Asegúrese de ingresar primero un número y luego la operación";
    }
}
$valorMostrado = $valorActual;


if (!empty($valorActual)) {
    //caso cuando ya se presionó el botón de igual
    if ($valorActual[-1] == "i") {
        $valorActual = substr($valorActual, 0, -1);
        $presentarResultado = true;
    }

    $operacionAnadida = false;
    for ($i = 0; $i < strlen($valorActual); $i++) {
        if (esOperacion($valorActual[$i])) {
            $operacionAnadida = true;
            $index = $i;
            break;
        }
    }
    if ($operacionAnadida) {
        if (esOperacion(($valorActual[-1]))) {
            //asegurar que no se ingrese más de una operación
            $valorActual = substr_replace($valorActual, $valorActual[-1], $index);
        }
        $valor1 .= substr($valorActual, 0, $index);
        $valor2 .= substr($valorActual, $index + 1);
        $operacion = $valorActual[$index];
        if (toSimbolo($operacion) != null) {
            $operacion = toSimbolo($operacion);
        }
        if (esOperacion($valorActual[-1])) {
            $valorMostrado = $operacion;
        }
    }
    $valorSalida = "Salida: " . $valor1 . $operacion . $valor2;
    if (!empty($valor2)) {
        $valorMostrado = $valor2;
    }
    if ($presentarResultado) {
        try {
            $valorMostrado = " = " . operar($valor1, $valor2, $operacion);
            $valorSalida .= $valorMostrado;
            array_push($historialOperaciones, $valorActual);
            //$valorActual = "";
            //$query_string = http_build_query($historialOperaciones);
            //header("Location: calculadora.php?valorMostrado=$valorMostrado&valorSalida=$valorSalida&". $query_string);
        } catch (\Throwable $th) {
            $valorSalida = "Asegúrese de escribir la operacion correctamente: valor1, operacion, valor2, igual (=)";
        }
    }
}

function esOperacion(string $caract): bool
{
    if ($caract == "s" || $caract == "-" || $caract == "*" || $caract == "/" || $caract == "r") {
        return true;
    }
    return false;
}
function toSimbolo(string $caract): string|null
{
    if ($caract == "s") {
        return "+";
    } else if ($caract == "r") {
        return "%";
    }
    return false;
}
function operar(int|float $n1, int|float $n2, string $op)
{
    switch ($op) {
        case '+':
            return $n1 + $n2;
            break;
        case '-':
            return $n1 - $n2;
            break;
        case '*':
            return $n1 * $n2;
            break;
        case '/':
            return $n1 / $n2;
            break;
        case '%':
            return $n1 % $n2;
            break;

        default:
            return "error en la operacion";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Document</title>
</head>

<body>
    <div class="pantalla">
        <div>
        </div>
        <h2 class="digito-pantalla"><?php echo $valorMostrado; ?></h2>

    </div>

    <div class="tablero-botones">
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "%2F"; ?>" class="a-calc a-calc-div">/</a>
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "*"; ?>" class="a-calc a-calc-multi">*</a>
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "-"; ?>" class="a-calc a-calc-menos">-</a>
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "s"; ?>" class="a-calc a-calc-suma">+</a>
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "r"; ?>" class="a-calc a-calc-resid">%</a>
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "i"; ?>" class="a-calc a-calc-igual">=</a>

        <?php
        for ($i = 0; $i < 10; $i++) {
            echo '<a href="calculadora.php?valorActual=' . $valorActual . $i . '" class="a-calc a-calc-' . $i . '">' . $i . '</a>';
        }
        ?>
        <a href="calculadora.php?valorActual=<?php echo $valorActual . "."; ?>" class="a-calc a-calc-punto">.</a>
    </div>
    <div class="resultado">
        <h2><?php echo $valorSalida; ?></h2>
    </div>
</body>

</html>