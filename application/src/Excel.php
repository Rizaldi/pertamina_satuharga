<?php
/**
 * Created by PhpStorm.
 * User: RIDHA DANJANI
 * Date: 22/01/2019
 * Time: 14:39
 */

namespace Danjanny;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends CI_Controller {

    /**
     * Spreadsheet
     * @var Spreadsheet
     */
    private $spreadsheet;

    /**
     * Worksheet
     * @var $sheet
     */
    private $sheet;

    /**
     * HTTP Client
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Date & Time
     * @var
     */
    private $dateTime;

    /**
     * Hello constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // init spreadsheet
        $this->spreadsheet = new Spreadsheet();
        // init HTTP Client
        $this->client = new GuzzleHttp\Client();
        // init date & time
        date_default_timezone_set('Asia/Jakarta');
        $this->dateTime = date("Y-m-d H:i:s");
    }

    public function index()
    {

    }

    /**
     * Turn data source from http client into excel file
     * and export it to browser
     * @return void
     *
     */
    public function excel() {

        // init active sheet for use
        $sheet = $this->spreadsheet->getActiveSheet()->setTitle("Satu_harga");

        // header table
        $this->header_table($sheet);

        // CONTENT TABLE
        // row excel
        $i = 5;
        // data counter (start from 0)
        $count = 0;
        // total data (size of array)
        $total = 0;
        // top of cell
        $top = "";
        // bottom of cell
        $bottom = "";

        $top_row_data = 0;

        foreach ($this->data_source() as $r) {

            // total data
            $total = $count;
            // if 1st data loop, then assign top cell
            if($count == 0) {
                $top = 'B' . strval($i);
                $top_row_data = $i;
                // else if last data loop, then assign bottom cell
            } else if($count == $total) {
                $bottom = 'N' . strval($i);
            }

            // assign value to cell loop by row
            $sheet->setCellValue('B' . strval($i), $r['no_spbu']);
            $sheet->setCellValue('C' . strval($i), $r['lokasi']);
            $sheet->setCellValue('D' . strval($i), $r['kab_kot']);
            $sheet->setCellValue('E' . strval($i), $r['region']);
            $sheet->setCellValue('F' . strval($i), $r['create_date']);
            $sheet->setCellValue('G' . strval($i), $r['pilihan_bbm']);
            $sheet->setCellValue('H' . strval($i), $r['stok_awal']);
            $sheet->setCellValue('I' . strval($i), $r['jual']);
            $sheet->setCellValue('J' . strval($i), $r['terima']);
            $sheet->setCellValue('K' . strval($i), $r['stok_akhir']);
            $sheet->setCellValue('L' . strval($i), $r['dot']);
            $sheet->setCellValue('M' . strval($i), $r['cd']);

            // add spbu's status from CD and fill color
            $cd = $r['cd'];
            switch (true) {
                case $cd >= 1:
                    $status = "Aman";
                    $fillColor = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN;
                    break;
                case $cd > 0 && $cd < 1:
                    $status = "Kritis";
                    $fillColor = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW;
                    break;
                case $cd > -1000 && $cd <= 0:
                    $status = "Kosong";
                    $fillColor = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED;
                    break;
                default:
                    $status = "-";
                    $fillColor = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE;
                    break;
            }

            $sheet->setCellValue('N' . strval($i), $status);
            $sheet->getStyle('N' . strval($i))
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                ->setARGB($fillColor);

            // increment excel row cell
            $i++;
            // increment row data
            $count++;

        }

        // table style
        $this->style_table($sheet, $top, $bottom);

        // export to browser
        $this->export_to_browser();

    }

    /**
     * Create header of table
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return void
     */
    private function header_table($sheet) {

        // map column to title
        $cols = ['B' => 'No SPBU', 'C' => 'LOKASI SPBU', 'D' => 'KABUPATEN / KOTA', 'E' => 'REGION', 'F' => 'WAKTU PENGISIAN'
            , 'G' => 'JENIS BBM' ,'H' => 'STOK AWAL (KL)', 'I' => 'PENJUALAN (KL)', 'J' => 'PENERIMAAN (KL)',
            'K' => 'STOK AKHIR (KL)', 'L' => 'DOT (KL)', 'M' => 'COVERAGE DAYS', 'N' => 'STATUS'
        ];

        foreach ($cols as $col => $title) {
            // set title
            $sheet->setCellValue($col . '4', $title);
            // set col width
            $sheet->getColumnDimension($col)->setWidth(25);
        }

        // set row height
        $sheet->getRowDimension('4')->setRowHeight(50);

        // config of style
        $styleArray = [
            'font' => [
                'bold' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'ffc001']
            ]
        ];


        // apply style to data range
        $sheet->getStyle('B4:N4')->applyFromArray($styleArray);

    }

    /**
     * Style the content table
     */
    private function style_table($sheet, $top, $bottom) {

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        // applied the style to this cell coordinate
        $cell_coordinate = $top . ':' . $bottom;

        // apply style to sheet which have a this cell coordinate
        $sheet->getStyle($cell_coordinate)->applyFromArray($styleArray);
    }


    /**
     * Export excel file to browser
     */
    private function export_to_browser() {
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        header('Content-type: application/vnd.ms-excel');

        // create date & time now while download
        $old_str = ['-', ' ', ':'];
        $new_str = ['', '_', ''];
        $this->dateTime = str_replace($old_str, $new_str, $this->dateTime);

        $filename = 'SATU_HARGA_' . $this->dateTime;
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        $writer->save('php://output');
    }

    /**
     * Get transaction data source
     * @return Array of data
     */
    public function data_source() {
        // // request to endpoint api
        // $res = $this->client->request('GET', 'http://stokbbmsatuharga.com/Api/satuharga/excel');
        // // decode json string to array
        // $transaction_data = json_decode($res->getBody(), TRUE);
        // // return Array of transaction
        // return $transaction_data["data"];

        // query stmt
        $query_excel = "SELECT * FROM view_excel";
        // result array
        return $this->db->query($query_excel)->result_array();
    }

    public function data_new() {
        $res = $this->client->request('POST', 'http://stokbbmsatuharga.com/Api/satuharga/woy', [
            'form_params' => [
                'message' => 'Ridha Danjanny'
            ]
        ]);

        $t = json_decode($res->getBody(), TRUE);
        var_dump($t["data"]);
    }

}