<?php
/**
 * Created by PhpStorm.
 * User: RIDHA DANJANI
 * Date: 22/01/2019
 * Time: 14:39
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excellibrary  {

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

    private $CI;

    /**
     * Hello constructor.
     */
    public function __construct()
    {
    	$this->CI =& get_instance();
    	// $this->CI->load->database();
        // init spreadsheet
        $this->spreadsheet = new Spreadsheet();
        // init HTTP Client
        // $this->client = new GuzzleHttp\Client();
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
    public function excel($start_date, $end_date) {
	    ini_set("max_execution_time", -1);

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
        
        $x = 0;

        foreach ($this->data_source($start_date, $end_date) as $r) {

            // total data
            $total = $count;
            // if 1st data loop, then assign top cell
            if($count == 0) {
                $top = 'B' . strval($i);
                $top_row_data = $i;
                $bottom = 'N' . strval($i);
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
    public function data_source($start_date, $end_date) {

        if($start_date == $end_date) {
            // $query_excel = "SELECT * FROM view_excel WHERE tgl LIKE '%{$start_date}%' ";
            $query_excel = "SELECT * FROM view_excel_revised WHERE tgl = '{$start_date}' ";            
        } else {
            $query_excel = "SELECT * FROM view_excel_revised WHERE tgl BETWEEN '{$start_date}' AND '{$end_date}' ";            
        }
        
        if($this->CI->db->query($query_excel)->num_rows() > 0) {
            // echo $this->CI->db->query($query_excel)->num_rows();
            return $this->CI->db->query($query_excel)->result_array();
            
            // echo '<pre>';
            // print_r($this->CI->db->query($query_excel)->result_array());
            // echo '</pre>';
            
        } else {
            
            // notice if data not available in choosen date. 
            echo "<script type='text/javascript'>
                alert('Data tidak tersedia pada tanggal yang dipilih. Silakan atur tanggal kembali');
                window.location = 'https://ptmsatuharga.com/home';
            </script>";
            
        }

    }


}