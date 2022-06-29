<?php

require_once 'app/Controllers/VentaController.php';

use app\Controllers\VentaController;

$venta = new VentaController();
$ventas = $venta->index();
if (isset($_GET['ticket'])) {
	$ventas_activas = $venta->venta_activa($_GET['ticket']);
	$articulos_venta = $venta->articulos_venta($_GET['ticket']);
}

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
	<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
	<?php include('menu.php') ?>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1 class="text-center mt-3 border titular">TPV</h1>
			</div>
			<div class="col-12 col-lg-7 col-xl-8 order-1 mt-5">
				<section>
					<?php if (empty($_GET['ticket'])) : ?>
						<h2 class="text-center">NO HAY NINGUN TICKET SELECCIONADO</h2>
					<?php else : ?>
						<h2 class="text-center">VENTA <?= $_GET['ticket'] ?></h2>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										<div class="card-title bg-light p-2 border">
											<h5 class="fs-4 mb-0">Datos de la venta</h5>
										</div>
										<div class="datos d-flex justify-content-between">
											<p class="card-text">
												<strong>Mesa:</strong> <?= $ventas_activas['numero_mesa'] ?><br>
												<strong>Método de pago:</strong> <?= $ventas_activas['metodo_pago'] ?><br>
											</p>
											<p class="card-text">
												<strong>Total base:</strong> <?= $ventas_activas['total_base'] ?><br>
												<strong>Total IVA:</strong> <?= $ventas_activas['iva'] ?><br>
												<strong>Total:</strong> <?= $ventas_activas['total'] ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col mt-5">
								<div class="d-flex justify-content-between bg-secondary text-white mb-2">
									<h5 class="px-4 mb-0">Artículo</h5>
									<h5 class="text-end px-3 mb-0">Precio</h5>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col">
								<ul class="list-group shadow rounded-0">
									<?php foreach ($articulos_venta as $articulo) : ?>
										<li class="list-group-item d-flex align-items-center">
											<img class="img-ticket" src="<?= $articulo['IMAGEN'] ?>">
											<div class="flex-grow-1">
												<span class="categoria-prod"><?= $articulo['CATEGORIA'] ?></span>
												<h4 class="nombre-prod mb-0"><?= $articulo['PRODUCTO'] ?>
											</div>
											<p class="precio-prod"><?= $articulo['BASE_IMPONIBLE'] ?></p>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>
				</section>
			</div>

			<div class="col-12 col-lg-5 col-xl-4 mt-5">
				<aside>
					<h2 class="text-center">VENTAS</h2>

					<div class="list-group">
						<?php foreach ($ventas as $venta) : ?>
							<?php if (isset($_GET['ticket']) && $venta["ticket"] == $_GET["ticket"]) : ?>
								<a class="sale-item list-group-item list-group-item-action d-flex justify-content-between active" href="ventas.php?
								ticket=<?php echo $venta['ticket'] ?>" aria-current="true">
								<?php else : ?>
									<a class="sale-item list-group-item list-group-item-action d-flex justify-content-between" href="ventas.php?
								ticket=<?php echo $venta['ticket'] ?>" aria-current="true">
									<?php endif; ?>
										<div class="d-flex w-100 flex-column">
											<h5 class="mb-1">Nº: <?= $venta['ticket'] ?></h5>
											<p class="mb-0">Mesa: <?= $venta['numero_mesa'] ?> - <small>Hora: <?= $venta['hora'] ?></small></p>
											
										</div>
										<p class="mb-1 d-flex align-items-center fs-4 fw-bold flex-shrink-0"><?= $venta['total'] ?> €</p>
									</a>
								<?php endforeach; ?>
					</div>

				</aside>
			</div>

		</div>
	</div>

	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>