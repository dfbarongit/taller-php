<?php
$numOriginal = empty($_POST["numero"]) ? null : $_POST["numero"];

$cociente = floor($numOriginal / 2);
$residuos = $numOriginal % 2;
while ($cociente > 0) {
    $residuoActual = $cociente % 2;
    $cociente = floor($cociente / 2);
    $residuos .= $residuoActual;
}
$binario = strrev($residuos);


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
    <h1>Calculadora de número binario</h1>
    <form action="" method="post">
        <label class="subtitulo">Escriba el número para pasar a binario:</label>
        <input type="number" name="numero" min="0" required
            value="<?php echo empty($_POST["numero"]) ? null : $_POST["numero"] ?>">
        <button type="submit">Calcular</button>
    </form>
    <div class="resultado">

        <?php
        echo '<h2 class=subtitulo>'.$binario.'</h2>';

        ?>
    </div>
</body>

</html>