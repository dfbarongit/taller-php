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
        <h2>holi</h2>

    </div>
    <div class="tablero-botones">
        <button class="btn-div">/</button>
        <button class="btn-multi">*</button>
        <button class="btn-menos">-</button>
        <button class="btn-suma">+</button>
        <button class="btn-igual">=</button>

        <?php
        for ($i=0; $i < 10; $i++) { 
            echo '<button class="btn-'.$i.'">'.$i.'</button>';
        }
        ?>
        <button class="btn-punto">.</button>
    </div>
    </body>
</html>