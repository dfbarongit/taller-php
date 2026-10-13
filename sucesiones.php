<?php
$valor = !empty($_GET["valor"]) ? $_GET["valor"] : "";
$operacion = !empty($_GET["operacion"]) ? $_GET["operacion"] : "";
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
            $resultado .= "-".$c;
        }
    } elseif ($operacion == "fact") {
        $resultado = $valor;
        for ($i = $valor - 1; $i > 0; $i--) { 
            $resultado .= "*".$i;
        }
    }
    $resultado = "Resultado: $resultado";

} else {

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Generador de secuencias</h1>
    <form action="#" method="get">
        <div>
            <label>Ingrese el valor</label>
            <input type="number" name="valor" id="" value=<?php echo $valor;?> required>
        </div>
        <div>
            <label>Seleccione la operación</label>
            <select id="" name="operacion">
                <option value="fibo">Fibonacci</option>
                <option value="fact">Factorial</option>
            </select>
        </div>

        <button type="submit">Enviar</button>
    </form>
    <div>
        <h2> <?php echo $resultado ?> </h2>
    </div>
</body>

</html>