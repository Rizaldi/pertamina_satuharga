<?php



if(!function_exists('loggedin_permission')) {
    function loggedin_permission() {
        if (!$this->session->userdata('admin')) {
            redirect('login/index/err');
        }
    }
}



if(!function_exists('GetHeaderFooter')) {
	function GetHeaderFooter() {
		$data['header'] = 'header';		
		$data['footer'] = 'footer';
		$data['sidebar'] = 'sidebar';
		return $data;
	}
}

if (!function_exists('to_excel')){
	function to_excel($query, $filename='xlsoutput')
	{
		$headers = '';
	  header("Content-type: application/x-msdownload");
	  header("Content-Disposition: attachment; filename=$filename.xls");
	  echo "$headers\n$query";
	}
}

/**
 * Mz helper
 */

if (!function_exists('GetValue')){
    function GetValue($field,$table,$filter=array(),$filter_where_in=array())
    {
        $CI =& get_instance();
        $CI->db->select($field);
        foreach($filter as $key=> $value)
        {
            $exp = explode("/",$value);
            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "like_after") $CI->db->like($key, $exp[1], 'after');
                else if($exp[0] == "like_before") $CI->db->like($key, $exp[1], 'before');
                else if($exp[0] == "not_like") $CI->db->not_like($key, $exp[1]);
                else if($exp[0] == "not_like_after") $CI->db->not_like($key, $exp[1], 'after');
                else if($exp[0] == "not_like_before") $CI->db->not_like($key, $exp[1], 'before');
                else if($exp[0] == "wherebetween"){
                    $xx=explode(',',$exp[1]);
                    $CI->db->where($key.' >=',$xx[0]);
                    $CI->db->where($key.' <=',$xx[1]);
                }
                else if($exp[0] == "order")
                {
                    $key = str_replace("=","",$key);
                    $CI->db->order_by($key, $exp[1]);
                }
                else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
            }

            if($exp[0] == "group") $CI->db->group_by($key);
        }

        foreach($filter_where_in as $key=> $value)
        {
            if(preg_match("/!=/", $key)) $CI->db->where_not_in(str_replace("!=","",$key), $value);
            else $CI->db->where_in($key, $value);
        }

        $q = $CI->db->get($table);
        foreach($q->result_array() as $r)
        {
            return $r[$field];
        }
        return 0;
    }
}