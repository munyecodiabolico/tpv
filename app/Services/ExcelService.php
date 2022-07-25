<?php

namespace app\Services;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;

class ExcelService {

	public function exportSaleToExcel($productos)
    {

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/ticket.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $spreedsheet->getActiveSheet()->setCellValue('A3', $sale['ticket']);
        $spreedsheet->getActiveSheet()->setCellValue('D2', $sale['fecha_emision']);
        $spreedsheet->getActiveSheet()->setCellValue('D3', $sale['hora_emision']);
        $spreedsheet->getActiveSheet()->setCellValue('D6', $sale['total_base']);
        $spreedsheet->getActiveSheet()->setCellValue('D8', $sale['iva']);
        $spreedsheet->getActiveSheet()->setCellValue('D9', $sale['total']);

        for($i = 0; $i < count($products); $i++){
            $spreedsheet->getActiveSheet()->insertNewRowBefore(6 + $i, 1); 
            $spreedsheet->getActiveSheet()->setCellValue('A' . ($i + 6), $products[$i]['PRODUCTO']);
            $spreedsheet->getActiveSheet()->setCellValue('B' . ($i + 6), $products[$i]['numero_productos']);
            $spreedsheet->getActiveSheet()->setCellValue('C' . ($i + 6), $products[$i]['BASE_IMPONIBLE']);
            $spreedsheet->getActiveSheet()->setCellValue('D' . ($i + 6), '=B'.($i + 6).'*C'.($i + 6));
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tickets/ticket-'.$sale['ticket'].'.xls');

        return $excel_file;
	}

    public function exportProductToExcel($productos)
    {

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/table.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $spreedsheet->getActiveSheet()->setCellValue('A1', 'Nombre Producto');
        $spreedsheet->getActiveSheet()->setCellValue('B1', 'Categoría');
        $spreedsheet->getActiveSheet()->setCellValue('C1', 'Precio');
        $spreedsheet->getActiveSheet()->setCellValue('D1', 'IVA');
        $spreedsheet->getActiveSheet()->setCellValue('E1', 'Visible');

        for($i = 0; $i < count($productos); $i++){
            $spreedsheet->getActiveSheet()->insertNewRowBefore(2 + $i, 1); 
            $spreedsheet->getActiveSheet()->setCellValue('A' . ($i + 2), $productos[$i]['nombre']);
            $spreedsheet->getActiveSheet()->setCellValue('B' . ($i + 2), $productos[$i]['categoria']);
            $spreedsheet->getActiveSheet()->setCellValue('C' . ($i + 2), $productos[$i]['precio']);
            $spreedsheet->getActiveSheet()->setCellValue('D' . ($i + 2), $productos[$i]['iva']);
            $spreedsheet->getActiveSheet()->setCellValue('E' . ($i + 2), $productos[$i]['visible']);
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tables/table.xls');

        return $excel_file;
	}

    public function exportExcelToPdf($excel_file, $filename)
    {
        $pdf = new Dompdf($excel_file);
        $pdf_file = $pdf->save($filename.".pdf");

        return $pdf_file;
    }
}

?>