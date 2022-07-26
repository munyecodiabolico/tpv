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
	
			$venta_seleccionada = $this->venta->show($venta_id);
			$venta = $this->venta->venta_activa($venta_seleccionada['numero_ticket']);
			$productos = $this->venta->articulos_venta($venta_seleccionada['numero_ticket']);
			
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
					<body>'.
					'<h1>Ticket de venta</h1>'.
					'<p>Numero de ticket: '.$sale['ticket'].'</p>'.
					'<p>Fecha: '.$sale['fecha_emision'].'</p>'.
					'<p>Mesa: '.$sale['numero_mesa'].'</p>'.
	
			$html .= 
				'<table>
					<tr>
						<th>Cant</th>
						<th>Descripción</th>
						<th>Total</th>
					</tr>';
			
			foreach($products as $product){
				$html .=
				'<tr>
				  <td>'.$product['numero_productos'].'</td>
				  <td>'.$product['PRODUCTO'].'</td>
				  <td>'.$product['BASE_IMPONIBLE'].'</td>
				</tr>';
			}
	
			$html .=
				'</table>'.
				'<p>Base: '.$sale['total_base'].'</p>'.
				'<p>IVA: '.$sale['iva'].'</p>'.
				'<p>Total: '.$sale['total'].'</p>'.
				'<p>Forma de pago: '.$sale['metodo_pago'].'</p>';
				'</body></html>';
			
			$pdf_service = new PdfService();
			$pdf = $pdf_service->exportToPdf($html);
	
			file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/pdf/tickets/ticket-'.$sale['numero_ticket'].'.pdf', $pdf);
		
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
