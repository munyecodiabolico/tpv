<?php

	namespace app\Controllers;

	require_once 'app/Models/Venta.php';
	require_once 'app/Services/ExcelService.php';
	require_once 'app/Services/PdfService.php';

	use app\Models\Venta;
	use app\Services\ExcelService;
	use app\Services\PdfService;

	class VentaController {

		protected $venta;

		public function __construct() {
			$this->venta = new Venta();
		}

		public function index() {
			return $this->venta->index();
		}

		public function listadoVentas() {
			return $this->venta->listadoVentas();
		}

		public function venta_activa($venta_id) {
			return $this->venta->venta_activa($venta_id);
		}

		public function filtrar($fecha, $mesa) {
			return $this->venta->filtrar($fecha, $mesa);
		}

		public function articulos_venta($venta_id) {
			return $this->venta->articulos_venta($venta_id);
		}

		public function total_media($fecha, $mesa) {
			return $this->venta->total_media($fecha, $mesa);
		}

		public function last_ticket() {

			$last_ticket_number = $this->venta->last_ticket();
			$date = date("Ymd");
			   	
			if(!empty($last_ticket_number['numero_ticket']) && strpos($last_ticket_number['numero_ticket'], $date) !== false){
				$ticket = $last_ticket_number['numero_ticket'] + 1;
			} else {
				$ticket = $date . "0001";
			};
		 
			return $ticket;
		}

		public function fake_last_ticket($date) {

			$date = str_replace("-", "", $date);

			$last_ticket_number = $this->venta->last_ticket();
			   	
			if(!empty($last_ticket_number['numero_ticket']) && strpos($last_ticket_number['numero_ticket'], $date) !== false){
				$ticket = $last_ticket_number['numero_ticket'] + 1;
			} else {
				$ticket = $date . "0001";
			};
		 
			return $ticket;
		}

		public function exportSaleToExcel($venta_id){

			$excel_service = new ExcelService();
	
			$venta = $this->venta->venta_activa($venta_id);
			$productos = $this->venta->articulos_venta($venta_id);
			
			$excel_service->exportSaleToExcel($venta, $productos);
		}

		public function exportVentaToExcel(){
			$excel_service = new ExcelService();

			$ventas = $this->venta->listadoVentas();

			$excel_service->exportTableToExcel('venta', $ventas);
		}

		public function exportSaleToPdf($sale_id){

			$sale = $this->venta->venta_activa($sale_id);
			$products = $this->venta->articulos_venta($sale_id);
			$html =
				'<html>
					<head>
						<style>
							html {
								margin: 0 1rem 1rem;
							}	
							body {
								font-family: Monospace, Helvetica, sans-serif;
								font-size: 12px;
							}
							h1 {
								font-family: Arial, Helvetica, sans-serif;
								font-size: 24px;
								text-align: center;
								border-bottom: .5px solid #000;
								margin-bottom: 1.5rem;
								margin-top:1.5rem;
							}
							p {
								line-height: 0.3;
							}
							p span {
								font-weight: bold;
								font-size: .8rem;
							}
							.articulos {
								margin-top: 1.5rem;
							}
							th.cantidad {
								text-align: center;
							}
							th.descrip, td.descrip {
								text-align: left;
								padding-left: .5rem;
								padding-right: .5rem;
								margin-bottom: .3rem;
							}
							th.total, td.total {
								text-align: right;
								margin-bottom: .3rem;
							}
							td.cantidad {
								text-align: center;
								margin-bottom: .3rem;
							}
							.precios, .pago {
								margin-top: 2rem;
							}
							.precio-total {
								font-weight: bold;
								font-size: 1.1rem;
							}
						</style>
						</head>
					<body>'.
					'<h1 style="">Ticket de venta</h1>'.
					'<p><span>Nº Ticket: </span>'.$sale['ticket'].'</p>'.
					'<p><span>Fecha: </span>'.$sale['fecha_emision'].'</p>'.
					'<p><span>Mesa: </span>'.$sale['numero_mesa'].'</p>'.
	
			$html .= 
				'<table class="articulos">
					<tr>
						<th class="cantidad">Cant</th>
						<th class="descrip">Descripción</th>
						<th class="total">Total</th>
					</tr>';
			
			foreach($products as $product){
				$html .=
				'<tr>
				  <td class="cantidad">'.$product['numero_productos'].'</td>
				  <td class="descrip">'.$product['PRODUCTO'].'</td>
				  <td class="total">'.$product['BASE_IMPONIBLE'].'</td>
				</tr>';
			}
	
			$html .=
				'</table>'.
				'<p class="precios"><span>Base: </span>'.$sale['total_base'].'</p>'.
				'<p><span>IVA: </span>'.$sale['iva'].'</p>'.
				'<p class="precio-total"><span>Total: </span>'.$sale['total'].'</p>'.
				'<p class="pago"><span>Forma de pago: </span>'.$sale['metodo_pago'].'</p>';
				'</body></html>';
			
			$pdf_service = new PdfService();
			$pdf = $pdf_service->exportToPdf($html);
	
			file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/pdf/tickets/ticket-'.$sale['ticket'].'.pdf', $pdf);
		
		}
		

		public function safe_venta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada) {
			return $this->venta->safe_venta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada);
		}

		public function safeFakeVenta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada, $date, $time, $plus_random_timestamp) {
			return $this->venta->safeFakeVenta($mesa, $base, $iva, $total, $numero_ticket, $metodo_pago, $mesa_ocupada, $date, $time, $plus_random_timestamp);
		}

		public function getChartData($chart_data){
			return $this->venta->getChartData($chart_data);
		}
	}

?>
