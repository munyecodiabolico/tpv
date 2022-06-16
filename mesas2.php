<?php

	require_once 'app/Controllers/TableController.php';

	use app\Controllers\TableController;

	$mesa = new TableController();
	$mesas = $mesa->index();

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
</head>
<style>
    .activo, .inactivo {
        background-color:green;
        margin:3rem;
        padding:3rem;
        display:inline-block;
        border-radius:1rem;
        font-size:2rem;
        color:white;
    }
    .inactivo {
        background-color:red;
    }
</style>
<body>

    <ul style ="list-style-type: none">
    <?php foreach($mesas as $mesa): ?>
        <?php if ($mesa["estado"] == 1): ?>
            <li class="activo"><?= $mesa['numero']; ?></<li>
        <?php else: ?>
            <li class="inactivo"><?= $mesa['numero']; ?></<li>
        <?php endif; ?>
        
    <?php endforeach; ?>

    </ul>

</body>

</html>
