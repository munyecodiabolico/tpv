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
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.css">
    <!-- <link rel="stylesheet" href="assets/css/general.css"> -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/Abel.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>
    
    <!-- <?php include('menu.php') ?> -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="cabecera">TPV</h1>
            </div>
            <div class="col-12 col-lg-7 order-lg-1 mt-5">
                <section class="mesas">
                    <h2 class="subcabecera">MESAS</h2>
                    <div class="row mb-5">
                        <?php foreach($mesas as $mesa): ?>
                            <?php if( isset($_GET['mesa']) && $mesa["id"] == $_GET["mesa"]): ?>
                                <div class="col-4 gy-4">
                                    <div class="square">
                                        <a class="panel panel-color1 content" role="button" href="categorias.php?mesa=<?php echo $mesa['id'] ?>"><?= $mesa['numero']; ?></a>
                                    </div>
                                </div
                            <?php elseif ($mesa["estado"] == 1): ?>
                                <div class="col-4 gy-4">
                                    <div class="square">
                                        <a class="panel panel-color4 content" role="button" href="categorias.php?mesa=<?php echo $mesa['id'] ?>"><?= $mesa['numero']; ?></a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-4 gy-4">
                                    <div class="square">
                                        <a class="panel panel-color2 content" role="button" href="categorias.php?mesa=<?php echo $mesa['id'] ?>"><?= $mesa['numero']; ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
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