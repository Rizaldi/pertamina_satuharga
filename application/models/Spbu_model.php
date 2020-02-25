<?php



/**

 * Created by PhpStorm.

 * User: DANJANNY

 * Date: 19/07/2019

 * Time: 13:16

 */

class Spbu_model extends CI_Model

{

    private $table_name = "kg_member_spbu";

    var $column_order   = array('kg_beli_pribadi.id'); //set column field database for datatable orderable
    var $column_search  = array('kg_beli_pribadi.no_spbu, kg_beli_pribadi.no_pol', 'kg_beli_pribadi.rupiah'); //set column field database for datatable searchable 
    var $order          = array('kg_beli_pribadi.id' => 'desc'); // default order

    public function __construct()

    {

        parent::__construct();

    }



    public function get_data_provinsi() {

        return $this->db->query("SELECT * FROM kg_ref_prov")->result_array();

    }

    
    function _get_datatables_query($param = null)
    {   
        $this->db->select('*');
        $this->db->from('kg_beli_pribadi');
        ($param['no_spbu'] != null) ? $this->db->where('kg_beli_pribadi.no_spbu', $param['no_spbu']) : "";
        ($param['no_pol'] != null) ? $this->db->like('kg_beli_pribadi.no_pol', $param['no_pol']) : "";
        $this->db->where('kg_beli_pribadi.app', 'satuharga');
        // () ? $this->db->where('rd_konsumen_member.tgl >=', $param['start_date'])->where('rd_konsumen_member.tgl <=', $param['end_date']) : ""; 
        // if ($param['start_date'] != "" && $param['end_date'] != "") {
            // $this->db->where('kg_beli_pribadi.tgl >=', date("Y-m-d",strtotime($param['start_date'])));
            // $this->db->where('kg_beli_pribadi.tgl <=', date("Y-m-d",strtotime($param['end_date'])));






        // }
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
            }
            $i++;
        }

        // $this->db->group_by('t1.id_member');
        // print_r($this->db->last_query());
         
        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($param = null)
    {
        $this->_get_datatables_query($param);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($param = null)
    {
        $this->_get_datatables_query($param);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all($param = null)
    {
        $this->db->select('*');
        $this->db->from('kg_beli_pribadi');
        ($param['no_spbu'] != null) ? $this->db->where('kg_beli_pribadi.no_spbu', $param['no_spbu']) : "";
        ($param['no_pol'] != null) ? $this->db->like('kg_beli_pribadi.no_pol', $param['no_pol']) : "";
        // () ? $this->db->where('rd_konsumen_member.tgl >=', $param['start_date'])->where('rd_konsumen_member.tgl <=', $param['end_date']) : "";
        // if ($param['start_date'] != "" && $param['end_date'] != "") {
            $this->db->where('kg_beli_pribadi.tgl >=', date("Y-m-d",strtotime($param['start_date'])));
            $this->db->where('kg_beli_pribadi.tgl <=', date("Y-m-d",strtotime($param['end_date'])));
        $this->db->where('kg_beli_pribadi.app', 'satuharga');
        return $this->db->count_all_results();
    }

}