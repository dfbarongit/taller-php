<?php
$frase = !empty($_POST["frase"]) ? $_POST["frase"] : "";
$resultado = "";

if (!empty($frase)) {
    $fraseAdaptada = "";
    for ($i = 0; $i < strLen($frase); $i++) {
        if (!preg_match('/[^\p{L}\p{N}]/u', $frase[$i]) || $frase[$i] == " " || $frase[$i] == "-" || $frase[$i] == "_") {
            #VERIFICAR SI SON ESPECIALES
            $fraseAdaptada .= $frase[$i];

        }
    }
    $fraseAdaptada = quitarDuplicados($fraseAdaptada, " ");
    $fraseAdaptada = quitarDuplicados($fraseAdaptada, "_");
    for ($i = 0; $i < strLen($fraseAdaptada); $i++) {
        if ($i == 0 || $fraseAdaptada[$i - 1] == " " || $fraseAdaptada[$i - 1] == "-" || $fraseAdaptada[$i - 1] == "_") {
            $resultado .= strtoupper($fraseAdaptada[$i]);
        }
    }

    $resultado = "Frase: $frase <br> Resultado: $resultado";
} else {
    echo "Ingrese una frase para continuar";
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
    <title>Acrónimo</title>
</head>

<body>
    <h1>Generador de acrónimos</h1>
    <form action="#" method="post">
        <label>Ingrese la frase</label>
        <input type="text" name="frase" id="" required>
        <button type="submit">Enviar</button>
    </form>
    <div>
        <h2> <?php echo $resultado ?> </h2>
    </div>
</body>

</html>