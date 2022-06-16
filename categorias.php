<?php

	require_once 'app/Controllers/ProductCategoryController.php';

	use app\Controllers\ProductCategoryController;

	$categoria = new ProductCategoryController();
	$categorias = $categoria->index();

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Categorias tpv</title>
</head>
<style>
    .activo, .inactivo {
        background-color:green;
        margin:1rem;
        padding:3rem;
        display:inline-block;
        border-radius:.5rem;
        font-size:2rem;
        color:white;
    }
</style>
<body>

    <ul style ="list-style-type: none">
    <?php foreach($categorias as $categoria): ?>
            <li class="activo"><?= $categoria['nombre']; ?></<li>
    <?php endforeach; ?>

    </ul>

</body>

</html>
