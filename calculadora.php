<?php
$valor1 = "";
$valor2 = "";
$valorActual = empty($_GET["valorActual"]) ? "" : $_GET["valorActual"];

$valorSalida = "";
$operacion = "";

$historialOperaciones = empty($_GET["historial"]) ? [] : $_GET["historial"];

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
        //$valorActual = substr($valorActual, 0, -1);
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
    if ($presentarResultado) {
        //quitar el simbolo de igual del valor2
        $valor2 = substr($valor2, 0, -1);

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
            foreach ($historialOperaciones as $hist) {
                $strHist = "historial[]=$hist&";
            }
            $valorActual = "";
        } catch (\Throwable $th) {
            $valorSalida = "Asegúrese de escribir la operacion correctamente: valor1, operacion, valor2, igual (=)";
        }
    }
}

function getValores(string $valorActual): array
{
    for ($i = 0; $i < strlen($valorActual); $i++) {
        if (esOperacion($valorActual[$i])) {
            $index = $i;
            break;
        }
    }
    $valor1 = substr($valorActual, 0, $index);
    $valor2 = substr($valorActual, $index + 1);
    $operacion = $valorActual[$index];
    return [
        "valor1" => $valor1,
        "valor2" => $valor2,
        "operacion" => $operacion,
    ];
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
    return $caract;
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
function ruta(string $valorActual, string $valorEnviado, array $historialOperaciones)
{
    // 1. Concatenamos los dos strings en uno solo antes de armar la URL
    $valorAcumulado = $valorActual . $valorEnviado;

    // 2. Preparamos los datos para la URL
    $datos = [
        'valorActual' => $valorAcumulado,
        'historial' => $historialOperaciones // PHP añade los corchetes [] automáticamente
    ];

    // 3. Retornamos la URL armada de forma segura
    return "calculadora.php?" . http_build_query($datos);
}
function mostrarHistorial(array $historialOperaciones)
{
    foreach ($historialOperaciones as $elem) {
        $valores = getValores($elem);
        $valor1 = $valores["valor1"];
        $valores["valor2"] = substr($valores["valor2"], 0, -1);
        $valor2 = $valores["valor2"];
        $operacion = toSimbolo($valores["operacion"]);
        echo $valor1 . $operacion . $valor2 . "=" . operar($valor1, $valor2, $operacion) . "<br>";
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
    <nav class="navbar">
        <div class="navbar-logo">
            <a href="index.php">Taller PHP</a>
        </div>
        <ul class="navbar-links">
            <li><a href="acronimos.php">Acrónimos</a></li>
            <li><a href="sucesiones.php">Suceciones</a></li>
            <li><a href="promedio.php">Promedio</a></li>
            <li><a href="conjuntos.php">Conjuntos</a></li>
            <li><a href="binario.php">Binario</a></li>
            <li><a href="arbol.php">Árbol binario</a></li>
            <li><a href="calculadora.php" class="active">Calculadora</a></li>
        </ul>
    </nav>
    <div>

        <div class="pantalla">
            <h2 class="digito-pantalla"><?php echo $valorMostrado; ?></h2>

        </div>

        <div class="tablero-botones">
            <a href=<?php echo ruta($valorActual, "/", $historialOperaciones); ?>
                class="a-calc a-calc-ope a-calc-div">/</a>
            <a href=<?php echo ruta($valorActual, "*", $historialOperaciones); ?>
                class="a-calc a-calc-ope a-calc-multi">*</a>
            <a href=<?php echo ruta($valorActual, "-", $historialOperaciones); ?>
                class="a-calc a-calc-ope a-calc-menos">-</a>
            <a href=<?php echo ruta($valorActual, "s", $historialOperaciones); ?>
                class="a-calc a-calc-ope a-calc-suma">+</a>
            <a href=<?php echo ruta($valorActual, "r", $historialOperaciones); ?>
                class="a-calc a-calc-ope a-calc-resid">%</a>
            <a href=<?php echo ruta($valorActual, "i", $historialOperaciones); ?>
                class="a-calc a-calc-ope a-calc-igual">=</a>
            <?php
            for ($i = 0; $i < 10; $i++) {
                echo '<a href=' . ruta($valorActual, $i, $historialOperaciones) . ' class="a-calc a-calc-' . $i . '">' . $i . '</a>';
            }
            ?>
            <a href=<?php echo ruta($valorActual, ".", $historialOperaciones);?> class="a-calc a-calc-punto">.</a>
        </div>
    </div>
    <div class="resultado">
        <h2><?php echo $valorSalida; ?></h2>
        <br>
        <h2><?php if (count($historialOperaciones) > 0) {
            echo "Historial:";
        } ?></h2>
        <br>
        <h2><?php mostrarHistorial($historialOperaciones); ?></h2>
        <?php if (count($historialOperaciones) > 0) {
            echo '<a href=calculadora.php class="a-calc">Borrar historial</a>';
        } ?>

    </div>
</body>

</html>