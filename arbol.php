<?php
require("clases/nodo.php");
$preordenText = empty($_POST["preorden"]) ? null : $_POST["preorden"];
$inordenText = empty($_POST["inorden"]) ? null : $_POST["inorden"];
$postordenText = empty($_POST["postorden"]) ? null : $_POST["postorden"];

echo "<h2>$preordenText</h2>";
echo "<h2>$inordenText</h2>";
echo "<h2>$postordenText</h2>";

$preorden = [];
$inorden = [];
$postorden = [];

$escrito = 0;
if (!empty($preordenText)) {
    $escrito++;
    $preorden = normalizarConjunto($preordenText);
}
if (!empty($inordenText)) {
    $escrito++;
    $inorden = normalizarConjunto($inordenText);
}
if (!empty($postordenText)) {
    $escrito++;
    $postorden = normalizarConjunto($postordenText);
}
$arbol = null;
if (!empty($preordenText) && !empty($inordenText) && !empty($postordenText)) {
    $arbol = preIn($preorden, $inorden);
} elseif (!empty($preordenText) && !empty($inordenText)){
    $arbol = preIn($preorden, $inorden);
} elseif (!empty($postodenText) && !empty($inordenText)){
    $arbol = postIn($inorden, $postorden);
} elseif (!empty($preordenText) && !empty($postodenText)){
    $arbol = prePost($preorden, $postorden);
} else {
    echo "No especificó suficientes parámetros";
}
$arbol->inorden();

mostrarArbol($arbol);
function normalizarConjunto(string $conjuntoText)
{
    $conjuntoNum = [];
    for ($i = 0; $i < strlen($conjuntoText); $i++) {
        if (!preg_match('/[^\p{L}\p{N}]/u', $conjuntoText[$i])) {
            $numActual = "";
            while ($conjuntoText[$i] != ",") {
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
function preIn(array $preorden, array $inorden): ?Nodo
{
    if (empty($preorden) || empty($inorden)) {
        return null;
    }

    $valorRaiz = $preorden[0];
    $raiz = new Nodo($valorRaiz);

    $indiceRaizInorden = array_search($valorRaiz, $inorden);

    $inordenIzq = array_slice($inorden, 0, $indiceRaizInorden);
    $inordenDer = array_slice($inorden, $indiceRaizInorden + 1);

    $tamanoIzquierda = count($inordenIzq);

    $preordenIzq = array_slice($preorden, 1, $tamanoIzquierda);
    $preordenDer = array_slice($preorden, 1 + $tamanoIzquierda);

    $raiz->setIzquierda(preIn($preordenIzq, $inordenIzq));
    $raiz->setDerecha(preIn($preordenDer, $inordenDer));
    return $raiz;
}
function postIn(array $inorden, array $postorden): ?Nodo
{
    if (empty($inorden) || empty($postorden)) {
        return null;
    }

    $valorRaiz = array_pop($postorden);
    $raiz = new Nodo($valorRaiz);

    $indiceRaizInorden = array_search($valorRaiz, $inorden);

    $inordenIzq = array_slice($inorden, 0, $indiceRaizInorden);
    $inordenDer = array_slice($inorden, $indiceRaizInorden + 1);

    $tamanoIzquierda = count($inordenIzq);

    $postordenIzq = array_slice($postorden, 0, $tamanoIzquierda);
    $postordenDer = array_slice($postorden, $tamanoIzquierda);

    $raiz->setIzquierda(postIn($inordenIzq, $postordenIzq));
    $raiz->setDerecha(postIn($inordenDer, $postordenDer));
    return $raiz;
}
function prePost(array $preorden, array $postorden): ?Nodo
{
    if (empty($preorden) || empty($postorden)) {
        return null;
    }

    $valorRaiz = $preorden[0];
    $raiz = new Nodo($valorRaiz);

    if (count($preorden) === 1) {
        return $raiz;
    }

    $raizIzquierda = $preorden[1];

    $indiceRaizIzqPost = array_search($raizIzquierda, $postorden);

    $tamanoIzquierda = $indiceRaizIzqPost + 1;

    $preordenIzq = array_slice($preorden, 1, $tamanoIzquierda);
    $preordenDer = array_slice($preorden, 1 + $tamanoIzquierda);

    $postordenIzq = array_slice($postorden, 0, $tamanoIzquierda);
    $postordenDer = array_slice($postorden, $tamanoIzquierda, -1); // El -1 quita la raíz actual del final

    $raiz->setIzquierda(prePost($preordenIzq, $postordenIzq));
    $raiz->setDerecha(prePost($preordenDer, $postordenDer));
    return $raiz;
}
function mostrarArbol(?Nodo $raiz): void
{
    if ($raiz === null) {
        return;
    }
    echo '<pre class="formatoArbol">';

    // Almacenamos los niveles del árbol en un array
    $niveles = [];
    $cola = [["nodo" => $raiz, "nivel" => 0, "pos" => 0]];

    // Recorrido por niveles (BFS) para agrupar los nodos
    while (!empty($cola)) {
        $actual = array_shift($cola);
        $currNodo = $actual["nodo"];
        $nivel = $actual["nivel"];

        if ($currNodo !== null) {
            $niveles[$nivel][] = [
                "valor" => $currNodo->getValor(),
                "padre_pos" => $actual["pos"]
            ];

            // Registramos la posición estimada de los hijos
            $cola[] = ["nodo" => $currNodo->getIzquierda(), "nivel" => $nivel + 1, "pos" => $actual["pos"] * 2];
            $cola[] = ["nodo" => $currNodo->getDerecha(), "nivel" => $nivel + 1, "pos" => $actual["pos"] * 2 + 1];
        }
    }

    // Dibujar los niveles calculando los espacios correspondientes
    $maxNivel = max(array_keys($niveles));

    for ($i = 0; $i <= $maxNivel; $i++) {
        // 1. Imprimir los valores de los nodos del nivel actual
        $espacioInicial = pow(2, $maxNivel - $i + 1) - 2;
        $espacioEntre = pow(2, $maxNivel - $i + 2) - 1;

        echo str_repeat(" ", $espacioInicial);
        foreach ($niveles[$i] as $nodoData) {
            echo $nodoData["valor"] . str_repeat(" ", $espacioEntre);
        }
        echo "\n";

        // 2. Imprimir las líneas conectoras / \ (si no es el último nivel)
        if ($i < $maxNivel && isset($niveles[$i + 1])) {
            echo str_repeat(" ", $espacioInicial - 1);

            // Contamos cuántos nodos reales tienen hijos en el siguiente nivel
            for ($j = 0; $j < count($niveles[$i]); $j++) {
                echo "/ \\" . str_repeat(" ", $espacioEntre - 2);
            }
            echo "\n";
        }
    }
    echo "</pre>";
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
    <h1>Generador de árboles binarios</h1>
    <form action="" method="post">
        <div>
            <label class="subtitulo">Escriba el árbol en preorden:</label>
            <input type="text" name="preorden"
                value="<?php echo empty($_POST["preorden"]) ? null : $_POST["preorden"] ?>">
        </div>
        <div>
            <label class="subtitulo">Escriba el árbol en inorden</label>
            <input type="text" name="inorden"
                value="<?php echo empty($_POST["inorden"]) ? null : $_POST["inorden"] ?>">
        </div>
        <div>
            <label class="subtitulo">Escriba el árbol en postorden</label>
            <input type="text" name="postorden"
                value="<?php echo empty($_POST["postorden"]) ? null : $_POST["postorden"] ?>">
        </div>

        <button type="submit">Calcular</button>
    </form>
    <div class="resultado">

        <?php
        echo '<h2>' . "holi" . '</h2>';
        ?>
    </div>
</body>

</html>