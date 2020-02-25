<?php

/**
 * Api Satuharga
 * data transaksi penjualan / penerimaan spbu (liter)
 */
class Satuharga extends REST_Controller
{

    private $result = [];


    public function __construct()
    {
        parent::__construct();
        // TAMPILKAN HANYA PREMIUM DAN SOLAR
        $query['all_transaction'] = 'SELECT
	                                    CASE 
	                                        WHEN id_bbm = 1 THEN "Premium"
	                                        WHEN id_bbm = 2 THEN "Solar"
	                                        WHEN id_bbm = 3 THEN "Pertalite"
	                                        WHEN id_bbm = 4 THEN "Dexlite"
	                                    END AS `pilihan_bbm`,                                    
	                                    no_spbu, 
	                                    stok_awal,
	                                    terima, 
	                                    jual,
	                                    stok_akhir,
	                                    loses,
	                                    tgl     
	                                        FROM kg_bbm_satu_harga
	                                          WHERE id_bbm IN(1,2) 
	                                            ORDER BY create_date DESC';


        $this->result['all_transaction'] = $this->db->query($query['all_transaction']);


    }

    public function transaction_get()
    {
        $this->response([
            "data" => $this->result['all_transaction']->result()
        ]);
    }

    /**
     * API transaksi satu harga per spbu
     * ex : https://ptmsatuharga.com/Api/satuharga/transaksi_spbu/?no_spbu=54.85709
     */
    public function transaksi_spbu_get()
    {
        $no_spbu = $this->input->get("no_spbu");
        $query_stmt_transaksi_spbu = "SELECT
            CASE 
                WHEN id_bbm = 1 THEN 'Premium'
                WHEN id_bbm = 2 THEN 'Solar'
                WHEN id_bbm = 3 THEN 'Pertalite'
                WHEN id_bbm = 4 THEN 'Dexlite'
            END AS `pilihan_bbm`,                                    
            sh.no_spbu, 
            stok_awal,
            terima, 
            jual,
            stok_akhir,
            loses,
            tgl,
            spbu.provinsi,
            spbu.kabupaten
                FROM kg_bbm_satu_harga AS sh 
                    INNER JOIN 
                    -- left join spbu : no_spbu, prov, kab / kota
                        (
                        SELECT 
                            wil_spbu.no_spbu, 
                            prov.provinsi, 
                            kab.kabupaten,
                            wil_spbu.id_prov,
                            wil_spbu.id_kab
                             FROM (
                                SELECT 
                                    spbu.no_spbu, 
                                    kab.id_prov, 
                                    spbu.id_kab 
                                        FROM `kg_member_spbu` AS spbu
                                            LEFT JOIN kg_ref_kab AS kab
                                                ON spbu.id_kab = kab.id_kab
                                                ) AS wil_spbu
                                        INNER JOIN kg_ref_prov AS prov
                                            ON wil_spbu.id_prov = prov.id_prov
                                        INNER JOIN kg_ref_kab AS kab
                                            ON wil_spbu.id_kab = kab.id_kab
                                ) AS spbu
                        ON sh.no_spbu = spbu.no_spbu
                        -- param : no_spbu
                            WHERE sh.no_spbu = '{$no_spbu}'
                                ORDER BY create_date DESC";

        $this->response($this->db->query($query_stmt_transaksi_spbu)->result());
    }

    public function filter_get()
    {
        // get input data from select2 filter
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $id_bbm = $this->input->get('id_bbm');
        $id_prov = $this->input->get('id_prov');
        $id_kabkot = $this->input->get('id_kabkot');

        // if user don't choose pilihan bbm, provinsi, and kab kota
        if ($id_bbm == "0" || $id_prov == "0" || $id_kabkot == "0") {
            $query_stmt_test = "SELECT
                CASE 
                    WHEN id_bbm = 1 THEN \"Premium\"
                    WHEN id_bbm = 2 THEN \"Solar
            \"        WHEN id_bbm = 3 THEN \"Pertalite\"
                    WHEN id_bbm = 4 THEN \"Dexlite\"
                END AS `pilihan_bbm`,                                    
                sh.no_spbu, 
                stok_awal,
                terima, 
                jual,
                stok_akhir,
                loses,
                tgl,
                spbu.provinsi,
                spbu.kabupaten
                    FROM kg_bbm_satu_harga AS sh 
                        INNER JOIN 
                        -- left join spbu : no_spbu, prov, kab / kota
                            (
                            SELECT 
                                wil_spbu.no_spbu, 
                                prov.provinsi, 
                                kab.kabupaten,
                                wil_spbu.id_prov,
                                wil_spbu.id_kab
                                 FROM (
                                    SELECT 
                                        spbu.no_spbu, 
                                        kab.id_prov, 
                                        spbu.id_kab 
                                            FROM `kg_member_spbu` AS spbu
                                                LEFT JOIN kg_ref_kab AS kab
                                                    ON spbu.id_kab = kab.id_kab
                                                    ) AS wil_spbu
                                            INNER JOIN kg_ref_prov AS prov
                                                ON wil_spbu.id_prov = prov.id_prov
                                            INNER JOIN kg_ref_kab AS kab
                                                ON wil_spbu.id_kab = kab.id_kab
                                    ) AS spbu
                            ON sh.no_spbu = spbu.no_spbu
                            -- param : id_bbm, start_date, end_date
                                WHERE tgl BETWEEN '{$start_date}' AND '{$end_date}'
                                    ORDER BY create_date DESC";
        } else {

            // insert GET params from query string to sql query statement
            $query_stmt_test = "SELECT
            CASE 
                WHEN id_bbm = 1 THEN 'Premium'
                WHEN id_bbm = 2 THEN 'Solar'
                WHEN id_bbm = 3 THEN 'Pertalite'
                WHEN id_bbm = 4 THEN 'Dexlite'
            END AS `pilihan_bbm`,                                    
            sh.no_spbu, 
            stok_awal,
            terima, 
            jual,
            stok_akhir,
            loses,
            tgl,
            spbu.provinsi,
            spbu.kabupaten
                FROM kg_bbm_satu_harga AS sh 
                    INNER JOIN 
                    -- left join spbu : no_spbu, prov, kab / kota
                        (
                        SELECT 
                            wil_spbu.no_spbu, 
                            prov.provinsi, 
                            kab.kabupaten,
                            wil_spbu.id_prov,
                            wil_spbu.id_kab
                             FROM (
                                SELECT 
                                    spbu.no_spbu, 
                                    kab.id_prov, 
                                    spbu.id_kab 
                                        FROM `kg_member_spbu` AS spbu
                                            LEFT JOIN kg_ref_kab AS kab
                                                ON spbu.id_kab = kab.id_kab
                                                -- params : id_prov, id_kab
                                                WHERE kab.id_prov = {$id_prov} AND spbu.id_kab = {$id_kabkot}
                                                ) AS wil_spbu
                                        INNER JOIN kg_ref_prov AS prov
                                            ON wil_spbu.id_prov = prov.id_prov
                                        INNER JOIN kg_ref_kab AS kab
                                            ON wil_spbu.id_kab = kab.id_kab
                                ) AS spbu
                        ON sh.no_spbu = spbu.no_spbu
                        -- param : id_bbm, start_date, end_date
                            WHERE id_bbm = '{$id_bbm}' AND (tgl BETWEEN '{$start_date}' AND '{$end_date}')
                                ORDER BY create_date DESC";
        }

        // response as json
        $this->response($this->db->query($query_stmt_test)->result());

    }

    public function filter_test_get()
    {
        // get input data from select2 filter
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $id_bbm = $this->input->get('id_bbm');
        $id_prov = $this->input->get('id_prov');
        $id_kabkot = $this->input->get('id_kabkot');

        if ($id_bbm == 0) {
            $id_bbm_stmt = "";
        } else {
            $id_bbm_stmt = "id_bbm = '{$id_bbm}' AND ";
        }

        if ($id_prov == 0) {
            $prov_kab_stmt = "";
        } else {
            if ($id_kabkot == 0) {
                $prov_kab_stmt = "WHERE kab.id_prov = {$id_prov}";
            } else {
                $prov_kab_stmt = "WHERE kab.id_prov = {$id_prov} AND spbu.id_kab = {$id_kabkot}";
            }
        }

        // insert GET params from query string to sql query statement
        $query_stmt_test = "SELECT
            CASE 
                WHEN id_bbm = 1 THEN 'Premium'
                WHEN id_bbm = 2 THEN 'Solar'
                WHEN id_bbm = 3 THEN 'Pertalite'
                WHEN id_bbm = 4 THEN 'Dexlite'
            END AS `pilihan_bbm`,                                    
            sh.no_spbu, 
            stok_awal,
            terima, 
            jual,
            stok_akhir,
            loses,
            tgl,
            spbu.provinsi,
            spbu.kabupaten
                FROM kg_bbm_satu_harga AS sh 
                    INNER JOIN 
                    -- left join spbu : no_spbu, prov, kab / kota
                        (
                        SELECT 
                            wil_spbu.no_spbu, 
                            prov.provinsi, 
                            kab.kabupaten,
                            wil_spbu.id_prov,
                            wil_spbu.id_kab
                             FROM (
                                SELECT 
                                    spbu.no_spbu, 
                                    kab.id_prov, 
                                    spbu.id_kab 
                                        FROM `kg_member_spbu` AS spbu
                                            LEFT JOIN kg_ref_kab AS kab
                                                ON spbu.id_kab = kab.id_kab AND spbu.kategori_spbu=1
                                                -- params : id_prov, id_kab
                                                {$prov_kab_stmt}
                                                ) AS wil_spbu
                                        INNER JOIN kg_ref_prov AS prov
                                            ON wil_spbu.id_prov = prov.id_prov
                                        INNER JOIN kg_ref_kab AS kab
                                            ON wil_spbu.id_kab = kab.id_kab
                                ) AS spbu
                        ON sh.no_spbu = spbu.no_spbu
                        -- param : id_bbm, start_date, end_date
                            WHERE {$id_bbm_stmt} (tgl BETWEEN '{$start_date}' AND '{$end_date}')
                                ORDER BY create_date DESC";

        // response as json
        //die($query_stmt_test);
        $this->response($this->db->query($query_stmt_test)->result());

    }

    public
    function iseng_get()
    {
        $no = '12345';
        $no_spbu = "no_spbu = {$no} ";
        $query_stmt = "SELECT * FROM kg_bbm_satu_harga WHERE $no_spbu ";
        $this->response($this->db->query($query_stmt)->result());
    }
    public function satuhargadata_post()
    {
        $this->load->model('Spbu_model');
        $param['start_date'] = $this->input->post('start_date');
        $param['end_date'] = $this->input->post('end_date');
        $param['no_spbu'] = $this->input->post('no_spbu');
        $param['no_pol'] = $this->input->post('no_pol');

        $list   = $this->Spbu_model->get_datatables($param);
        $data   = array();
        $no     = $_POST['start'];
        foreach ($list as $row_data) {
            $no++;
            $aksi = '';

            $row = array();
            $row[] = $no;
            $row[] = $row_data->no_spbu;
            $row[] = $row_data->no_pol;
            $row[] = $row_data->no_hp;
            $row[] = 'Rp '.number_format($row_data->rupiah);
            $row[] = $row_data->tgl;
            // $row[] = $aksi;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw"              => $_POST['draw'],
                        "recordsTotal"      => $this->Spbu_model->count_all($param),
                        "recordsFiltered"   => $this->Spbu_model->count_filtered($param),
                        "data"              => $data,
                );
        echo json_encode($output);
        // if (!empty($start_date) || !empty($end_date)) {
        //     $this->db->where('tgl >=', $start_date);
        //     $this->db->where('tgl <=', $end_date);
        // }
        // if (!empty($no_spbu)) {
        //     $this->db->where('no_spbu', $no_spbu);
        // }
        // if (!empty($no_pol)) {
        //     $this->db->where('no_pol', $no_pol);
        // }
        // $this->db->where('app', 'satuharga');
        // $this->response($this->db->get("kg_beli_pribadi")->result());

    }
}