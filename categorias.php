<?php

require_once 'app/Controllers/ProductCategoryController.php';

use app\Controllers\ProductCategoryController;

$categoria = new ProductCategoryController();
$categorias = $categoria->filter();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Abel.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/estilos.css">

</head>

<body>
    <!-- <?php include('menu.php') ?> -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-3 border cabecera">TPV</h1>
            </div>
            <div class="col-12 col-lg-7 col-xl-8 order-lg-1 mt-5">
                <section>
                    <h2 class="text-center">CATEGORÍAS</h2>
                    <div class="row">
                        <div class="col">
                            <ol class="breadcrumb mb-0 mt-3">
                                <li class="breadcrumb-item">
                                    <a href="mesas.php?mesa=<?php echo $_GET['mesa'] ?>">
                                        <span><i class="icon ion-android-home me-2"></i>INICIO</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span><i class="icon ion-social-buffer-outline me-2"></i>Categorías</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <?php foreach ($categorias as $categoria) : ?>
                            <div class="col-6 col-md-4 col-xl-3 gy-4">
                                <a class="cat-prod option-section square" role="button" href="productos.php?categoria=<?php echo $categoria['id'] ?>&mesa=<?php echo $_GET['mesa'] ?>">
                                    <div class="content shadow">
                                        <img src=<?= $categoria['imagen_url'] ?>>
                                    </div>
                                </a>
                                <h5 class="text-center mb-0"><?= $categoria['nombre'] ?></h5>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>

            <?php include('tickets.php') ?>

        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>