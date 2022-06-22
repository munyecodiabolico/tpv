<?php

	require_once 'app/Controllers/TicketController.php';

	use app\Controllers\TicketController;

    $mesa = $_GET['mesa'];
	$ticket = new TicketController();
	$tickets = $ticket->index($mesa);

?>
<div class="col-12 col-lg-5 col-xl-4 mt-5">
    <aside>
        <h2 class="text-center">TICKET MESA 1</h2>
        <ul class="list-group shadow mt-4">
            <?php $total_imponible = 0; ?>
            <?php $total_iva = 0; ?>
            <?php $total_final = 0; ?>             
            <?php foreach($tickets as $ticket): ?>
                <li class="list-group-item d-flex align-items-center">
                    <button class="btn btn-light btn-sm me-2" type="button">
                    <i class="la la-close"></i></button><img class="img-ticket" src="<?= $ticket['IMAGEN'] ?>">
                    <div class="flex-grow-1">
                        <span class="categoria-prod"><?= $ticket['CATEGORIA'] ?></span>
                        <h4 class="nombre-prod mb-0"><?= $ticket['PRODUCTO'] ?>
                    </div>
                    <p class="precio-prod"><?= $ticket['BASE_IMPONIBLE'] ?></p>
                </li>
                <?php $total_imponible += round($ticket['BASE_IMPONIBLE'],2); ?>
                <?php $total_iva = round($ticket['BASE_IMPONIBLE'] * $ticket['IVA']/100,2); ?>
                <?php $total_final += round(($total_imponible + $total_iva),2); ?>
                <?php $porcentaje_iva = $ticket['IVA']; ?>
                <?php var_dump($total_imponible); var_dump($total_iva); var_dump($total_final); var_dump($porcentaje_iva); ?>

            <?php endforeach; ?>
            <?php var_dump($total_imponible); var_dump($total_iva); var_dump($total_final); var_dump($porcentaje_iva); ?>

        </ul>
        <div class="row mt-3">
            <div class="col">
                <div class="bg-secondary">
                    <div class="row justify-content-between g-0">
                        <div class="col">
                            <h5 class="text-center text-white mb-0 pt-1">B. Imponible</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 border-start pt-1">IVA <?php echo $porcentaje_iva ?>%</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 bg-dark pt-1">TOTAL</h5>
                        </div>
                    </div>
                    <div class="row justify-content-between g-0">
                        <div class="col">
                            <h5 class="text-center text-white mb-0 pb-1"><?php echo $total_imponible ?> €</h5>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 border-start pb-1"><?php echo $total_iva ?></h5>
                        </div>
                        <div class="col">
                            <h5 class="text-center text-white mb-0 bg-dark pb-1"><?php echo $total_final ?> €</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-6">
                <div><a class="btn btn-danger btn-lg w-100" role="button" href="#myModal" data-bs-toggle="modal">ELIMINAR</a>
                    <div class="modal fade" role="dialog" tabindex="-1" id="myModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Eliminar ticket</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center text-muted">Está a punto de borrar el pedido sin ser cobrado. ¿Está completamente seguro de realizar esta acción?</p>
                                </div>
                                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button><button class="btn btn-success" type="button">ELIMINAR</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div><a class="btn btn-success btn-lg w-100" role="button" href="#myModal-2" data-bs-toggle="modal">COBRAR</a>
                    <div class="modal fade" role="dialog" tabindex="-1" id="myModal-2">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Metodo de pago</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row align-items-center flex-column">
                                        <div class="col-6 d-lg-flex m-2"><button class="btn btn-primary w-100" type="button">EFECTIVO</button></div>
                                        <div class="col-6 d-lg-flex m-2"><button class="btn btn-success w-100" type="button">TARJETA CRÉDITO</button></div>
                                        <div class="col-6 d-lg-flex m-2"><button class="btn btn-danger w-100" type="button">BIZUM</button></div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">CERRAR</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>