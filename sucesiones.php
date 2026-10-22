<?php
$valor = !empty($_POST["valor"]) ? $_POST["valor"] : "";
$operacion = !empty($_POST["operacion"]) ? $_POST["operacion"] : "";
$resultado = "";

if (!empty($valor) && !empty($operacion)) {
    if ($operacion == "fibo") {
        $a = 0;
        $b = 1;
        $c = 0;
        $resultado = "0-1";
        while ($c <= $valor) {
            $c = $a + $b;
            $a = $b;
            $b = $c;
            if ($c > $valor) {
                break;
            }
            $resultado .= "-" . $c;
        }
    } elseif ($operacion == "fact") {
        $resultado = $valor;
        $resTotal = $valor;
        for ($i = $valor - 1; $i > 0; $i--) {
            $resTotal *= $i;
            $resultado .= " * " . $i;
        }
        $resultado .= " = " . $resTotal;
    }
    $resultado = "Resultado: $resultado";

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
            <li><a href="sucesiones.php" class="active">Suceciones</a></li>
            <li><a href="promedio.php">Promedio</a></li>
            <li><a href="conjuntos.php">Conjuntos</a></li>
            <li><a href="binario.php">Binario</a></li>
            <li><a href="arbol.php">Árbol binario</a></li>
            <li><a href="calculadora.php">Calculadora</a></li>
        </ul>
    </nav>
    <h1>Generador de secuencias</h1>
    <div class="instrucciones">
        <h2>¿Cómo usar?</h2>
        <ol>
            <li>Ingrese un número entero</li>
            <li>Seleccione la operación solicitada (serie de fibonacci o factorial)</li>
        </ol>
        <ul>
            <li>
                Si selecciona la serie de fibonacci, el valor introducido trabajará como el límite del que no pasará la secuencia.
            </li>
            <li>
                Si selecciona factorial, se mostrará toda la sucesión de números de la operación y se mostrará el
                resultado.
            </li>
        </ul>
    </div>
    <form action="#resultado" method="post">
        <div>
            <label class="subtitulo">Ingrese el valor</label>
            <input type="number" name="valor" id="" value=<?php echo $valor; ?> required min="0">
        </div>
        <div>
            <label class="subtitulo">Seleccione la operación</label>
            <select id="" name="operacion">
                <option value="fibo">Fibonacci</option>
                <option value="fact">Factorial</option>
            </select>
        </div>

        <button type="submit">Enviar</button>
    </form>
    <div class="resultado" id="resultado">
        <h2 class=subtitulo><?php echo "$resultado"; ?></h2>
    </div>
</body>

</html>