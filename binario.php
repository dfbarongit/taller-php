<?php
$numOriginal = empty($_GET["numero"]) ? null : $_GET["numero"];

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
    <nav class="navbar">
        <div class="navbar-logo">
            <a href="index.php">Taller PHP</a>
        </div>
        <ul class="navbar-links">
            <li><a href="acronimos.php">Acrónimos</a></li>
            <li><a href="sucesiones.php">Suceciones</a></li>
            <li><a href="promedio.php">Promedio</a></li>
            <li><a href="conjuntos.php">Conjuntos</a></li>
            <li><a href="binario.php" class="active">Binario</a></li>
            <li><a href="arbol.php">Árbol binario</a></li>
            <li><a href="calculadora.php">Calculadora</a></li>
        </ul>
    </nav>
    <h1>Calculadora de número binario</h1>
    <form action="" method="get">
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