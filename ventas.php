<?php

	require_once 'app/Controllers/VentaController.php';
	require_once 'app/Controllers/TableController.php';

	use app\Controllers\VentaController;
	use app\Controllers\TableController;

	$venta = new VentaController();
	$mesas = new TableController();
	
	$fecha = !empty($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
	$mesa = !empty($_GET['mesa']) ? $_GET['mesa'] : null;

	$numeros_mesas = $mesas->index();
	$ventas = $venta->filtrar($fecha, $mesa);

	$total_media = $venta->total_media($fecha, $mesa);

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
									<div class="card-header">
                                        <div class="excel-button export-sale-to-excel" data-sale="<?= $ventas_activas['id'] ?>">
                                            <svg viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M21.17 3.25Q21.5 3.25 21.76 3.5 22 3.74 22 4.08V19.92Q22 20.26 21.76 20.5 21.5 20.75 21.17 20.75H7.83Q7.5 20.75 7.24 20.5 7 20.26 7 19.92V17H2.83Q2.5 17 2.24 16.76 2 16.5 2 16.17V7.83Q2 7.5 2.24 7.24 2.5 7 2.83 7H7V4.08Q7 3.74 7.24 3.5 7.5 3.25 7.83 3.25M7 13.06L8.18 15.28H9.97L8 12.06L9.93 8.89H8.22L7.13 10.9L7.09 10.96L7.06 11.03Q6.8 10.5 6.5 9.96 6.25 9.43 5.97 8.89H4.16L6.05 12.08L4 15.28H5.78M13.88 19.5V17H8.25V19.5M13.88 15.75V12.63H12V15.75M13.88 11.38V8.25H12V11.38M13.88 7V4.5H8.25V7M20.75 19.5V17H15.13V19.5M20.75 15.75V12.63H15.13V15.75M20.75 11.38V8.25H15.13V11.38M20.75 7V4.5H15.13V7Z" />
                                            </svg>
                                        </div>
                                    </div>
									<div class="card-body">
										<div class="card-title bg-light p-2 border">
											<h5 class="fs-4 mb-0">Datos de la venta</h5>
										</div>
										<div class="datos d-flex justify-content-between">
											<p class="card-text">
												<strong>Mesa:</strong> <?= $ventas_activas['numero_mesa'] ?><br>
												<strong>Método de pago:</strong> <?= $ventas_activas['metodo_pago'] ?><br>
											</p>
											<div>
												<p class="card-text d-flex justify-content-between mb-0 fs-5">
													<span>Total base:</span><span class="ms-3"><?= $ventas_activas['total_base'] ?></span>
												</p>
												<p class="card-text d-flex justify-content-between mb-0 fs-5">
													<span>Total IVA:</span><span class="ms-3"><?= $ventas_activas['iva'] ?></span>
												</p>
												<p class="card-text d-flex justify-content-between mb-0 fs-5 border-top">
													<strong>Total:</strong><span class="ms-3"><?= $ventas_activas['total'] ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col mt-5">
								<div class="d-flex justify-content-between bg-secondary text-white mb-2">
									<h5 class="px-4 mb-0">Artículo</h5>
									<div class="d-flex">
										<h5 class="text-center px-3 mb-0">Cantidad</h5>
										<h5 class="text-end px-3 mb-0">Precio</h5>
									</div>
								</div>
							</div>

						</div>
						<div class="row mb-5">
							<div class="col">
								<ul class="list-group shadow rounded-0">
									<?php foreach ($articulos_venta as $articulo) : ?>
										<li class="list-group-item d-flex align-items-center">
											<img class="img-ticket" src="<?= $articulo['IMAGEN'] ?>">
											<div class="flex-grow-1">
												<span class="categoria-prod"><?= $articulo['CATEGORIA'] ?></span>
												<h4 class="nombre-prod mb-0"><?= $articulo['PRODUCTO'] ?>
											</div>
											<div>
												<p class="precio-prod text-center"><?= $articulo['numero_productos'] ?></p>
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
					<form action="ventas.php" method="GET">
						<div class="row mt-3 mb-3">
							<div class="col-6">
								<p>Filtrar por fecha:</p>
							</div>

							<div class="col-6">
								<div class="form-group">
									<input type="date" name="fecha" value="<?= htmlspecialchars($fecha); ?>" class="form-control">
								</div>
							</div>
						</div>

						<div class="row mt-3 mb-3">
							<div class="col-6">
								<p>Filtrar por mesa:</p>
							</div>
							<div class="col-6">
								<div class="form-group">
									<select name="mesa" class="form-control">
										<option value="">Todas</option>
										<?php foreach ($numeros_mesas as $numero_mesa) : ?>
											<option value="<?= $numero_mesa['numero'] ?>" <?=  $numero_mesa['numero'] == $mesa ? 'selected':'' ?>><?= $numero_mesa['numero'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="row mt-3 mb-3">
							<div class="col-12">
								<button type="submit" class="btn btn-primary w-100">Filtrar</button>
							</div>
						</div>

					</form>
					<div class="list-group">
						<?php foreach ($ventas as $venta) : ?>
							<?php if (isset($_GET['ticket']) && $venta["ticket"] == $_GET["ticket"]) : ?>
								<a class="sale-item list-group-item list-group-item-action d-flex justify-content-between active" href="ventas.php?
								ticket=<?php echo $venta['ticket'] ?>&fecha=<?= $fecha ?>&mesa=<?= $mesa ?>" aria-current="true">
									<div class="d-flex w-100 flex-column">
										<h5 class="mb-1">Nº: <?= $venta['ticket'] ?></h5>
										<p class="mb-0">Mesa: <?= $venta['numero_mesa'] ?> - <small>Hora: <?= $venta['hora'] ?></small></p>
										
									</div>
									<p class="mb-1 d-flex align-items-center fs-4 fw-bold flex-shrink-0"><?= $venta['total'] ?> €</p>
								</a>
							<?php else : ?>
								<a class="sale-item list-group-item list-group-item-action d-flex justify-content-between" href="ventas.php?
								ticket=<?php echo $venta['ticket'] ?>&fecha=<?= $fecha ?>&mesa=<?= $mesa ?>" aria-current="true">
									<div class="d-flex w-100 flex-column">
										<h5 class="mb-1">Nº: <?= $venta['ticket'] ?></h5>
										<p class="mb-0">Mesa: <?= $venta['numero_mesa'] ?> - <small>Hora: <?= $venta['hora'] ?></small></p>
										
									</div>
									<p class="mb-1 d-flex align-items-center fs-4 fw-bold flex-shrink-0"><?= $venta['total'] ?> €</p>
								</a>
							<?php endif; ?>
							
						<?php endforeach; ?>
					</div>
					<div class="row mt-3">
                        <div class="col">
                            <div class="bg-secondary" id="refresh-price">
                                <div class="row justify-content-between g-0">
                                    <div class="col">
                                        <h5 class="text-center text-white mb-0 pt-1">Total Ingresos</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-center text-white mb-0 pt-1">Media del día</h5>
                                    </div>
                                    <div class="row justify-content-between g-0">
                                        <div class="col">
                                            <h5 class="text-center text-white mb-0 pb-1">
                                                <?php if(isset($total_media['total']) && $total_media['total'] != null): ?>
                                                    <?= $total_media['total']; ?> €
                                                <?php else: ?>
                                                    0 €
                                                <?php endif; ?>
                                            </h5>
                                        </div>
                                        <div class="col">
                                            <h5 class="text-center text-white mb-0 border-start pb-1">
                                                <?php if(isset($total_media['media']) && $total_media['media'] != null): ?>
                                                    <?= $total_media['media']; ?> €
                                                <?php else: ?>
                                                    0 €
                                                <?php endif; ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</aside>
			</div>

		</div>
	</div>

	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="module" src="dist/main.js"></script>
</body>

</html>