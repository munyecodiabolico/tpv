<?php

	require_once 'app/Controllers/VentaController.php';

	use app\Controllers\VentaController;

	$venta = new VentaController();
	$ventas = $venta->index();
	if(isset( $_GET['ticket'])){
		$ventas_activas = $venta->venta_activa($_GET['ticket']);
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
	<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1 class="text-center mt-3 border titular">TPV</h1>
			</div>
			<div class="col-12 col-lg-7 col-xl-8 order-lg-1 mt-5">
				<section>
					<?php if (empty($_GET['ticket'])): ?>
						<h2 class="text-center">NO HAY NINGUN TICKET SELECCIONADO</h2>
						<?php else: ?>
							<h2 class="text-center">VENTA <?= $_GET['ticket'] ?></h2>
							<div class="row">
								<div class="col-12">
									<div class="card">
										<div class="card-body">
											<h5 class="card-title">Datos de la venta</h5>
											<p class="card-text">
												<strong>Mesa:</strong> <?= $ventas_activas['numero_mesa'] ?><br>
												<strong>Método de pago:</strong> <?= $ventas_activas['metodo_pago'] ?><br>
												<strong>Total base:</strong> <?= $ventas_activas['total_base'] ?><br>
												<strong>Total IVA:</strong> <?= $ventas_activas['iva'] ?><br>
												<strong>Total:</strong> <?= $ventas_activas['total'] ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
				</section>
			</div>

			<div class="col-12 col-lg-5 col-xl-4 mt-5">
				<aside>
					<h2 class="text-center">VENTAS</h2>

					<div class="list-group">
						<?php foreach($ventas as $venta): ?>
							<?php if( isset($_GET['ticket']) && $venta["ticket"] == $_GET["ticket"]): ?>
								<a class="sale-item list-group-item list-group-item-action active" href="ventas.php?
								ticket=<?php echo $venta['ticket'] ?>" aria-current="true">
								<?php else: ?>
									<a class="sale-item list-group-item list-group-item-action" href="ventas.php?
								ticket=<?php echo $venta['ticket'] ?>" aria-current="true">
								<?php endif; ?>
									<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1"><?= $venta['ticket'] ?></h5>
										<small>Hora: <?= $venta['hora'] ?></small>
										<small>Mesa: <?= $venta['numero_mesa'] ?></small>
									</div>
									<p class="mb-1"><?= $venta['total'] ?></p>
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