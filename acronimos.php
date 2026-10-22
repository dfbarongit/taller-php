<?php
$frase = !empty($_POST["frase"]) ? $_POST["frase"] : "";
$resultado = "";

if (!empty($frase)) {
    $fraseAdaptada = "";
    for ($i = 0; $i < strLen($frase); $i++) {
        if (!preg_match('/[^\p{L}\p{N}]/u', $frase[$i])) {
            //VERIFICAR SI SON ESPECIALES
            $fraseAdaptada .= $frase[$i];
        }
        if ($frase[$i] == " " || $frase[$i] == "-" || $frase[$i] == "_") {
            $fraseAdaptada .= "_";
        }
    }
    $fraseAdaptada = quitarDuplicados($fraseAdaptada, "_");
    for ($i = 0; $i < strLen($fraseAdaptada); $i++) {
        if ($i == 0 || $fraseAdaptada[$i - 1] == "_") {
            $resultado .= strtoupper($fraseAdaptada[$i]);
        }
    }

    $resultado = "Frase: $frase <br> Resultado: $resultado";
}

function quitarDuplicados($texto, $caracter)
{
    $resultado = "";

    for ($i = 0; $i < strLen($texto); $i++) {
        $letraActual = $texto[$i];

        if ($letraActual !== $caracter) {
            $resultado .= $letraActual;
        } else {
            if ($i === 0 || $texto[$i - 1] !== $caracter) {
                $resultado .= $letraActual;
            }
        }
    }

    return $resultado;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Acrónimo</title>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-logo">
            <a href="index.php">Taller PHP</a>
        </div>
        <ul class="navbar-links">
            <li><a href="acronimos.php" class="active">Acrónimos</a></li>
            <li><a href="sucesiones.php">Suceciones</a></li>
            <li><a href="promedio.php">Promedio</a></li>
            <li><a href="conjuntos.php">Conjuntos</a></li>
            <li><a href="binario.php">Binario</a></li>
            <li><a href="arbol.php">Árbol binario</a></li>
            <li><a href="calculadora.php">Calculadora</a></li>
        </ul>
    </nav>
    <h1>Generador de acrónimos</h1>
    <div class="instrucciones">
        <h2>¿Cómo usar?</h2>
        <ol>
            <li>Ingrese la frase con las palabras separadas por espacio " ", guiones "-" o barra baja "_"</li>
        </ol>
        <ul>
            <li>
                Los caracteres especiales (todo lo que no sean letras o números) serán omitidos
            </li>
        </ul>
    </div>
    <form action="#resultado" method="post">
        <div>
            <label class="subtitulo">Ingrese la frase</label>
            <input type="text" name="frase" id="" required>
        </div>
        <button type="submit">Enviar</button>
        <label class="subtitulo">
            <?php if (empty($frase)) {
                echo "Ingrese una frase para continuar";
            } ?>
        </label>
    </form>
    <div class="resultado" id="resultado">
        <h2 class="subtitulo"> <?php echo $resultado ?> </h2>
    </div>
</body>

</html>