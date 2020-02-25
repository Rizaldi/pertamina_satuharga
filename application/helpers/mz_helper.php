<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('print_mz')){
    function print_mz($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }
}


if (!function_exists('GetHeaderFooterOperatorSPBU')){
    function GetHeaderFooterOperatorSPBU($flag_sidebar=NULL)
    {
        $CI =& get_instance();

        if($CI->session->userdata('webmaster_id'))
        {
            $data['dis_login'] = "display:'';";
            $data['nama_user'] = $CI->session->userdata('admin');
            //$data['breadcrumb'] = Breadcrumb();
        }
        else
        {
            $data['dis_login'] = "display:none;";
            $data['nama_user'] = "";
        }

        if(!$CI->session->userdata("webmaster_id_caleg")) {
            $CI->session->set_userdata("webmaster_tabel", "dki3");
            $CI->session->set_userdata("webmaster_alias", "dki3_GraceNatalie");
            $CI->session->set_userdata("webmaster_caleg", "20141020");
            $CI->session->set_userdata("webmaster_id_caleg", "5");
            $CI->session->set_userdata("webmaster_nm_caleg", "Grace Natalie");
        }

        // custom header for SPBU operator
        $data['header'] = 'operator/header_operator';
        // custom menu for SPBU operator
        $data['menu'] = 'operator/menu_operator';
        $data['breadcrumb'] = 'breadcrumb';
        $data['footer'] = 'footer';

        return $data;
    }
}


if (!function_exists('lastq')){
    function lastq()
    {
        $CI =& get_instance();
        die($CI->db->last_query());
    }
}

if (!function_exists('cekIpad')){
    function cekIpad()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/ipad/i',$user_agent)) return TRUE;
        else return FALSE;
    }
}

if (!function_exists('LogActivities')){
    function LogActivities($users_id,$tbl,$tbl_id,$logs)
    {
        $CI =& get_instance();
        $date = date("Y-m-d H:i:s");
        $data = array("id_users"=> $users_id,
            "tabel"=> $tbl,
            "tabel_id"=> $tbl_id,
            "logs"=> $logs,
            "create_date"=> $date
        );

        $CI->db->insert("logs", $data);
    }
}

if (!function_exists('DefaultTahun')){
    function DefaultTahun()
    {
        return 2014;
    }
}

if (!function_exists('GetAPIKey')){
    function GetAPIKey()
    {
        return "AIzaSyBeEPj1UtxUnb5N39BEKbX2-GrcBTlW1sY";
    }
}

if(!function_exists('GetDaystogo')){
    function GetDaystogo($tgl)
    {
        $countdown = (strtotime($tgl) - strtotime(date("Y-m-d"))) / 86400;
        return $countdown;
    }
}

function cekAccessMenu($ref_menu)
{
    $CI =& get_instance();
    $CI->db->where("filez",$ref_menu);
    $query = $CI->db->get("user_menu_input");
    //die($this->db->last_query());
    return $query;
}

function cekLogin($username,$userpass)
{
    $CI =& get_instance();
    $CI->db->where("username",$username);
    $CI->db->where("password",$userpass);
    $query=$CI->db->get("user");
    return $query;
}

if (!function_exists('permission')){
    function permission()
    {
        $CI =& get_instance();
        if(!$CI->session->userdata("webmaster_id")){
            redirect(site_url("login"));
            /*$CI->session->set_userdata('admin','Mazhters');
            $CI->session->set_userdata('webmaster_grup','8910');
            $CI->session->set_userdata('webmaster_id','1');*/
        }

        return $CI->session->userdata("webmaster_id");
    }
}

if (!function_exists('GetUserID')){
    function GetUserID()
    {
        $CI =& get_instance();
        return $CI->session->userdata("webmaster_id");
    }
}

if (!function_exists('GetProjectID')){
    function GetProjectID()
    {
        $CI =& get_instance();
        if($CI->session->userdata("project_id")) return $CI->session->userdata("project_id");
        else return 1;
    }
}

if (!function_exists('GetHeaderFooter')){
    function GetHeaderFooterMz($flag_sidebar=NULL)
    {
        $CI =& get_instance();

        if($CI->session->userdata('webmaster_id'))
        {
            $data['dis_login'] = "display:'';";
            $data['nama_user'] = $CI->session->userdata('admin');
            //$data['breadcrumb'] = Breadcrumb();
        }
        else
        {
            $data['dis_login'] = "display:none;";
            $data['nama_user'] = "";
        }

        if(!$CI->session->userdata("webmaster_id_caleg")) {
            $CI->session->set_userdata("webmaster_tabel", "dki3");
            $CI->session->set_userdata("webmaster_alias", "dki3_GraceNatalie");
            $CI->session->set_userdata("webmaster_caleg", "20141020");
            $CI->session->set_userdata("webmaster_id_caleg", "5");
            $CI->session->set_userdata("webmaster_nm_caleg", "Grace Natalie");
        }

        $data['header'] = 'header';
        $data['menu'] = 'menu';
        $data['breadcrumb'] = 'breadcrumb';
        $data['footer'] = 'footer';

        return $data;
    }
}

if (!function_exists('cek_akses')){
    function cek_akses($db, $id_menu, $webmaster_grup)
    {
        $CI =& get_instance();
        $CI->db->where("id_user_grup", $webmaster_grup);
        $CI->db->where("id_menu", $id_menu);
        $q = $CI->db->get("user_auth");
        if($q->num_rows() > 0) return true;
        else return false;
    }
}

if (!function_exists('Breadcrumb')){
    function Breadcrumb()
    {
        $CI =& get_instance();
        $breadcrumb = "";//Home
        $flag=1;
        $id_menu = $id_menu_temp = GetValue("id","user_menu", array("filez"=> "where/".$CI->uri->segment(1)));
        if($id_menu)
        {
            while($flag)
            {
                $CI->db->where("id", $id_menu);
                $q = $CI->db->get("user_menu");
                foreach($q->result_array() as $r)
                {
                    if($id_menu_temp == $id_menu) $breadcrumb = "<li class='bread_".strtolower($r['title'])."'>".$r['title']."</li>".$breadcrumb;
                    else $breadcrumb = "<li class='bread_".strtolower($r['title'])."'><a href='".site_url($r['filez'])."'><b>".$r['title']."</b></a></li>".$breadcrumb;
                    $id_menu=$r['id_parents'];
                    if($r['id_parents'] == 0) $flag=0;
                }
            }
        }

        if($CI->uri->segment(1) == "home" || !$CI->uri->segment(1)) return "<li class='first bread_home'><a>Dashboard</a></li><li class='bread_nas'><a>Nasional</a></li><li>&nbsp;</li>";
        else return "<li class='first bread_home'><a>Dashboard</a></li>".$breadcrumb;
    }
}

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

if (!function_exists('GetAll')){
    function GetAll($tbl,$filter=array(),$filter_where_in=array())
    {
        $CI =& get_instance();
        foreach($filter as $key=> $value)
        {
            // Multiple Like
            if(is_array($value))
            {
                $key = str_replace(" =","",$key);
                $like="";
                $v=0;
                foreach($value as $r=> $s)
                {
                    $v++;
                    $exp = explode("/",$s);
                    if(isset($exp[1]))
                    {
                        if($exp[0] == "like")
                        {
                            if($key == "tanggal" || $key == "tahun")
                            {
                                $key = "tanggal";
                                if(strlen($exp[1]) == 4)
                                {
                                    if($v == 1) $like .= $key." LIKE '%".$exp[1]."-%' ";
                                    else $like .= " OR ".$key." LIKE '%".$exp[1]."-%' ";
                                }
                                else
                                {
                                    if($v == 1) $like .= $key." LIKE '%-".$exp[1]."-%' ";
                                    else $like .= " OR ".$key." LIKE '%-".$exp[1]."-%' ";
                                }
                            }
                            else
                            {
                                if($v == 1) $like .= $key." LIKE '%".$exp[1]."%' ";
                                else $like .= " OR ".$key." LIKE '%".$exp[1]."%' ";
                            }
                        }
                    }
                }
                if($like) $CI->db->where("id > 0 AND ($like)");
                $exp[0]=$exp[1]="";
            }
            else $exp = explode("/",$value);

            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "or_like") $CI->db->or_like($key, $exp[1]);
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
            else if($exp[0] == "where") $CI->db->where($key);

            if($exp[0] == "group") $CI->db->group_by($key);
        }

        foreach($filter_where_in as $key=> $value)
        {
            if(preg_match("/!=/", $key)) $CI->db->where_not_in(str_replace("!=","",$key), $value);
            else $CI->db->where_in($key, $value);
        }

        $q = $CI->db->get($tbl);
        //die($CI->db->last_query());

        return $q;
    }
}

if (!function_exists('GetAllSelect')){
    function GetAllSelect($tbl,$select,$filter=array(),$filter_where_in=array())
    {
        $CI =& get_instance();
        $CI->db->select($select);
        foreach($filter as $key=> $value)
        {
            // Multiple Like
            if(is_array($value))
            {
                $key = str_replace(" =","",$key);
                $like="";
                $v=0;
                foreach($value as $r=> $s)
                {
                    $v++;
                    $exp = explode("/",$s);
                    if(isset($exp[1]))
                    {
                        if($exp[0] == "like")
                        {
                            if($key == "tanggal" || $key == "tahun")
                            {
                                $key = "tanggal";
                                if(strlen($exp[1]) == 4)
                                {
                                    if($v == 1) $like .= $key." LIKE '%".$exp[1]."-%' ";
                                    else $like .= " OR ".$key." LIKE '%".$exp[1]."-%' ";
                                }
                                else
                                {
                                    if($v == 1) $like .= $key." LIKE '%-".$exp[1]."-%' ";
                                    else $like .= " OR ".$key." LIKE '%-".$exp[1]."-%' ";
                                }
                            }
                            else
                            {
                                if($v == 1) $like .= $key." LIKE '%".$exp[1]."%' ";
                                else $like .= " OR ".$key." LIKE '%".$exp[1]."%' ";
                            }
                        }
                    }
                }
                if($like) $CI->db->where("id > 0 AND ($like)");
                $exp[0]=$exp[1]="";
            }
            else $exp = explode("/",$value);

            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "like_after") $CI->db->like($key, $exp[1], 'after');
                else if($exp[0] == "like_before") $CI->db->like($key, $exp[1], 'before');
                else if($exp[0] == "not_like") $CI->db->not_like($key, $exp[1]);
                else if($exp[0] == "not_like_after") $CI->db->not_like($key, $exp[1], 'after');
                else if($exp[0] == "not_like_before") $CI->db->not_like($key, $exp[1], 'before');
                else if($exp[0] == "order")
                {
                    $key = str_replace("=","",$key);
                    $CI->db->order_by($key, $exp[1]);
                }
                else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
            }
            else if($exp[0] == "where") $CI->db->where($key);

            if($exp[0] == "group") $CI->db->group_by($key);
        }

        foreach($filter_where_in as $key=> $value)
        {
            $CI->db->where_in($key, $value);
        }

        $q = $CI->db->get($tbl);
        //die($CI->db->last_query());

        return $q;
    }
}

if (!function_exists('GetQuery')){
    function GetQuery($field,$table,$where='',$order='',$group='')
    {
        $CI =& get_instance();
        $where = !empty($where) ? "WHERE ".$where : "";
        $order = !empty($order) ? "ORDER BY ".$order : "";
        $group = !empty($group) ? "GROUP BY ".$group : "";

        $q = $CI->db->query("SELECT $field FROM $table $where $order $group");

        return $q;
    }
}

if (!function_exists('GetJoin')){
    function GetJoin($tbl,$tbl_join,$condition,$type,$select,$filter=array(),$filter_where_in=array())
    {
        $CI =& get_instance();
        $CI->db->select($select);
        foreach($filter as $key=> $value)
        {
            // Multiple Like
            if(is_array($value))
            {
                if($key == "group") $CI->db->group_by($value);
                $exp[0]=$exp[1]="";
            }
            else $exp = explode("/",$value);
            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "or_like") $CI->db->or_like($key, $exp[1]);
                else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
                else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
            }

            if($exp[0] == "group") $CI->db->group_by($key);
        }

        foreach($filter_where_in as $key=> $value)
        {
            if(preg_match("/!=/", $key)) $CI->db->where_not_in(str_replace("!=","",$key), $value);
            else $CI->db->where_in($key, $value);
        }

        $CI->db->join($tbl_join, $condition, $type);
        $q = $CI->db->get($tbl);
        //die($CI->db->last_query());

        return $q;
    }
}

if (!function_exists('GetSum')){
    function GetSum($table,$field,$filter=array(),$get="")
    {
        $CI =& get_instance();
        $CI->db->select("SUM($field) as total");
        foreach($filter as $key=> $value)
        {
            $exp = explode("/",$value);
            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
                else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
            }

            if($exp[0] == "group") $CI->db->group_by($key);
        }

        $q = $CI->db->get($table);

        if($get == "value")
        {
            $val = 0;
            //die($CI->db->last_query());
            foreach($q->result_array() as $r) $val=$r['total'];
            return $val;
        }
        else return $q;
    }
}

if (!function_exists('GetCount')){
    function GetCount($table,$field,$filter=array(),$get="")
    {
        $CI =& get_instance();
        $CI->db->select("$field as label, COUNT($field) as total");
        foreach($filter as $key=> $value)
        {
            $exp = explode("/",$value);
            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
                else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
            }

            if($exp[0] == "group") $CI->db->group_by($key);
        }
        $q = $CI->db->get($table);
        if($get == "value")
        {
            $val = 0;
            //die($CI->db->last_query());
            foreach($q->result_array() as $r) $val=$r['total'];
            return $val;
        }
        else return $q;
    }
}

if (!function_exists('GetCountIn')){
    function GetCountIn($table,$field,$filter=array(),$filter_where_in=array(),$get="")
    {
        $CI =& get_instance();
        $CI->db->select("$field, COUNT($field) as total");
        foreach($filter as $key=> $value)
        {
            $exp = explode("/",$value);
            if(isset($exp[1]))
            {
                if($exp[0] == "where") $CI->db->where($key, $exp[1]);
                else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
                else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
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
        if($get == "value")
        {
            $val = 0;
            //die($CI->db->last_query());
            foreach($q->result_array() as $r) $val=$r['total'];
            return $val;
        }
        else return $q;
    }
}

if (!function_exists('GetColumns')){
    function GetColumns($tbl)
    {
        $CI =& get_instance();
        //if(substr($tbl,0,3) != "mz_") $tbl = "mz_".$tbl;
        $query = $CI->db->query("SHOW COLUMNS FROM ".$tbl);
        return $query->result_array();
    }
}

if (!function_exists('GetUrlDate')){
    function GetUrlDate($date)
    {
        $exp1 = explode(" ", $date);
        $exp = explode("-",$exp1[0]);
        return $exp[2]."/".$exp[1]."/".$exp[0];
    }
}

if (!function_exists('ExplodeNameFile')){
    function ExplodeNameFile($source)
    {
        $ext = strrchr($source, '.');
        $name = ($ext === FALSE) ? $source : substr($source, 0, -strlen($ext));

        return array('ext' => $ext, 'name' => $name);
    }
}

if (!function_exists('GetThumb')){
    function GetThumb($image, $path="_thumb")
    {
        $exp = ExplodeNameFile($image);
        return $exp['name'].$path.$exp['ext'];
    }
}

if (!function_exists('ResizeImage')){
    function ResizeImage($up_file,$w,$h)
    {
        //Resize
        $CI =& get_instance();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $up_file;
        $config['dest_image'] = "./".$CI->config->item('path_upload')."/";
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE; //Width=Height
        $config['height'] = $h;
        $config['width'] = $w;

        $CI->load->library('image_lib', $config);
        if($CI->image_lib->resize()) return 1;
        else return 0;
    }
}

if (!function_exists('InputFile')){
    function InputFile($filez,$filesize=500)
    {
        $CI =& get_instance();
        $file_up = $_FILES[$filez]['name'];
        $ext_file = strrchr($file_up, '.');
        $file_up = str_replace($ext_file,"",$file_up);
        $file_up = str_replace("-","_",url_title($file_up)).".".date("YmdHis").$ext_file;
        $myfile_up	= $_FILES[$filez]['tmp_name'];
        $ukuranfile_up = $_FILES[$filez]['size'];
        if($filez == "foto" || $filez == "foto1" || $filez == "foto2")
            $up_file = "./".$CI->config->item('path_upload')."/tokoh/".$file_up;
        else
            $up_file = "./".$CI->config->item('path_upload')."/".$file_up;

        if($ukuranfile_up < ($filesize * 1024))
        {
            if(strtolower($ext_file) == ".jpg" || strtolower($ext_file) == ".JPG" ||strtolower($ext_file) == ".jpeg" || strtolower($ext_file) == ".png")
            {
                if(copy($myfile_up, $up_file))
                {
                    //Thumbnail
                    //ResizeImage($up_file, 250, 250);
                    return $file_up;
                }
            }
            //else if(strtolower($ext_file) == ".doc" || strtolower($ext_file) == ".docx" || strtolower($ext_file) == ".pdf")
            else
            {
                if(copy($myfile_up, $up_file))
                {
                    return $file_up;
                }
                else return 3;
            }

        }
        else return 2;
    }
}

if (!function_exists('Page')){
    function Page($jum_record,$lmt,$pg,$path,$uri_segment)
    {
        $link = "";
        $config['base_url'] = $path;
        $config['total_rows'] = $jum_record;
        $config['per_page'] = $lmt;
        $config['num_links'] = 3;
        $config['cur_tag_open'] = '<li><strong>';
        $config['cur_tag_close'] = '</strong></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['uri_segment'] = $uri_segment;

        $CI =& get_instance();
        $CI->pagination->initialize($config);
        $link = $CI->pagination->create_links();
        return $link;
    }
}

if (!function_exists('Limit')){
    function Limit() {
        return 15;
    }
}

if (!function_exists('URISegment')){
    function URISegment() {
        return 5;
    }
}

if (!function_exists('CaptchaSecurityImages')){
    function CaptchaSecurityImages($width='120',$height='40',$characters='6')
    {
        $CI =& get_instance();
        $font = './assets/font/monofont.ttf';
        $code = generateCode($characters);
        /* font size will be 75% of the image height */
        $font_size = $height * 0.75;
        $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
        /* set the colours */
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 20, 40, 100);
        $noise_color = imagecolorallocate($image, 100, 120, 180);
        /* generate random dots in background */
        for( $i=0; $i<($width*$height)/3; $i++ ) {
            imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
        }
        /* generate random lines in background */
        for( $i=0; $i<($width*$height)/150; $i++ ) {
            imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
        }
        /* create textbox and add text */
        $textbox = imagettfbbox($font_size, 0, $font, $code) or die('Error in imagettfbbox function');
        $x = ($width - $textbox[4])/2;
        $y = ($height - $textbox[5])/2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code) or die('Error in imagettftext function');


        /* output captcha image to browser */
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
        $CI->session->set_userdata("security_code", $code);
    }
}

if (!function_exists('GetTanggal')){
    function GetTanggal($tgl)
    {
        if(strlen($tgl) == 1) $tgl = "0".$tgl;
        return $tgl;
    }
}

if (!function_exists('GetBulanIndo')){
    function GetBulanIndo($Bulan)
    {
        if($Bulan == "January")
            $Bulan = "Januari";
        else if($Bulan == "February")
            $Bulan = "Februari";
        else if($Bulan == "March")
            $Bulan = "Maret";
        else if($Bulan == "May")
            $Bulan = "Mei";
        else if($Bulan == "June")
            $Bulan = "Juni";
        else if($Bulan == "July")
            $Bulan = "Juli";
        else if($Bulan == "August")
            $Bulan = "Agustus";
        else if($Bulan == "October")
            $Bulan = "Oktober";
        else if($Bulan == "December")
            $Bulan = "Desember";

        return $Bulan;
    }
}

if (!function_exists('GetMonthIndex')){
    function GetMonthIndex($var)
    {
        $bln = array("Jan"=> "01","Feb"=> "02","Mar"=> "03","Apr"=> "04","May"=> "05","Jun"=> "06","Jul"=> "07","Aug"=> "08","Sep"=> "09","Oct"=> "10","Nov"=> "11","Dec"=> "12");
        return $bln[$var];
    }
}

if (!function_exists('GetMonth')){
    function GetMonth($id)
    {
        //$bln = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
        $bln = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
        return $bln[$id];
    }
}

if (!function_exists('GetMonthFull')){
    function GetMonthFull($id)
    {
        $id=intval($id);
        //$bln = array("","January","February","March","April","May","June","July","August","September","October","November","December");
        $bln = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return $bln[$id];
    }
}

if (!function_exists('GetMonthShort')){
    function GetMonthShort($val)
    {
        $bln = array("Januari"=> "Jan","Februari"=>"Feb","Maret"=>"Mar","April"=>"Apr","Mei"=>"May","Juni"=>"Jun","Juli"=>"Jul","Agustus"=>"Aug","September"=>"Sep","Oktober"=>"Oct","November"=>"Nov","Desember"=>"Dec");
        return $bln[$val];
    }
}

if (!function_exists('GetOptDate')){
    function GetOptDate()
    {
        $opt[''] = "- Tanggal -";
        for($i=1;$i<=31;$i++)
        {
            if(strlen($i) == 1) $j = "0".$i;
            else $j=$i;
            $opt[$j] = $j;
        }
        return $opt;
    }
}

if (!function_exists('GetOptMonth')){
    function GetOptMonth()
    {
        $opt[''] = "- Bulan -";
        $bln = array("01"=> "Januari","02"=> "Februari","03"=> "Maret","04"=>"April","05"=>"Mei","06"=>"Juni",
            "07"=>"Juli","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember");
        //$bln = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Dec");
        foreach($bln as $r=> $val)
        {
            $opt[$r] = $val;
        }

        return $opt;
    }
}

if (!function_exists('GetOptMonthFull')){
    function GetOptMonthFull()
    {
        $opt[''] = "- Bulan -";
        $bln = array("Januari"=> "Januari","Februari"=> "Februari","Maret"=> "Maret","April"=>"April","Mei"=>"Mei","Juni"=>"Juni",
            "Juli"=>"Juli","Agustus"=>"Agustus","September"=>"September","Oktober"=>"Oktober","November"=>"November","Desember"=>"Desember");
        //$bln = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Dec");
        foreach($bln as $r=> $val)
        {
            $opt[$r] = $val;
        }

        return $opt;
    }
}

if (!function_exists('GetOptPartai')){
    function GetOptPartai($tahun=2014, $level="")
    {
        $opt=array();
        if(!$level) $q = GetAll("zref_partai", array("tahun"=> "where/".$tahun, "no_urut"=> "order/asc"));
        else $q = GetAll("zref_partai", array("tahun"=> "where/".$tahun, "level"=> "where/1", "no_urut"=> "order/asc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_partai']] = $r['alias'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptPartaiParents')){
    function GetOptPartaiParents()
    {
        $opt=array();
        $opt[''] = "- Parents Partai -";
        $q = GetAll("zref_partai", array("tahun"=> "order/desc", "no_urut"=> "order/asc", "id_partai !="=> "where/0"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_partai']] = $r['tahun']." - ".$r['alias'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptTahunPartai')){
    function GetOptTahunPartai()
    {
        $opt=array();
        $q = GetAll("dpr_nas", array("tahun"=> "group", "tahun "=> "order/desc"));
        foreach($q->result_array() as $r) {
            $opt[$r['tahun']] = $r['tahun'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptKoalisi')){
    function GetOptKoalisi()
    {
        $CI =& get_instance();
        $webmaster_id = $CI->session->userdata("webmaster_id");
        $opt=array();
        $q = GetAll("zref_koalisi", array("create_id"=> "where/".$webmaster_id));
        $opt[''] = "- Koalisi -";
        foreach($q->result_array() as $r) {
            $opt[$r['id_koalisi']] = $r['koalisi'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptCountry')){
    function GetOptCountry()
    {
        $opt=array();
        $q = GetAll("zref_country");
        foreach($q->result_array() as $r) {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptProv')){
    function GetOptProv()
    {
        $opt=array();
        $opt[''] = "- Provinsi -";
        $q = GetAll("ref_prov");
        foreach($q->result_array() as $r) {
            $opt[$r['id_prov']] = ucwords(strtolower($r['provinsi']));
        }

        return $opt;
    }
}

if (!function_exists('GetOptKab')){
    function GetOptKab($id_prov=0)
    {
        $opt=array();
        if($id_prov) $q = GetAll("zref_kab", array("id_prov"=> "where/".$id_prov));
        else $q = GetAll("zref_kab");
        foreach($q->result_array() as $r) {
            if($id_prov) $opt[$r['id_kab']] = $r['kabupaten'];
            else $opt[$r['id_kab']] = $r['kabupaten'];
        }
        if(!count($opt)) $opt[] = "- Kabupaten/Kota -";

        return $opt;
    }
}

if (!function_exists('GetOptKecByProv')){
    function GetOptKecByProv($id_prov=0)
    {
        $opt=array();
        $q = GetAll("zref_kec", array("id_prov"=> "where/".$id_prov));
        foreach($q->result_array() as $r) {
            $opt[$r['id_kec']] = $r['kecamatan'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptDesaByProv')){
    function GetOptDesaByProv($id_prov=0)
    {
        $opt=array();
        $q = GetAll("zref_desa", array("id_prov"=> "where/".$id_prov));
        foreach($q->result_array() as $r) {
            $opt[$r['id']] = $r['desa'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptDesaByKab')){
    function GetOptDesaByKab($id=0)
    {
        $opt=array();
        $q = GetAll("zref_desa", array("id_kab"=> "where/".$id));
        foreach($q->result_array() as $r) {
            $opt[$r['id']] = $r['desa'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptKec')){
    function GetOptKec()
    {
        $opt=array();
        $q = GetAll("zref_kec");
        foreach($q->result_array() as $r) {
            $opt[$r['id_kec']] = $r['kecamatan'];
        }
        if(!count($opt)) $opt[] = "- Kecamatan -";

        return $opt;
    }
}

if (!function_exists('GetOptDapilDPR')){
    function GetOptDapilDPR()
    {
        $opt=array();
        $q = GetAll("zref_dapil_dpr", array("tahun"=> "order/desc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_dapil_dpr']] = $r['tahun']." - ".$r['dapil_dpr'];
        }
        if(!count($opt)) $opt[] = "- Dapil DPR -";

        return $opt;
    }
}

if (!function_exists('GetOptDapilDPRD1')){
    function GetOptDapilDPRD1()
    {
        $opt=array();
        $q = GetAll("zref_dapil_dprd1", array("tahun"=> "order/desc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_dapil_dprd1']] = $r['tahun']." - ".$r['dapil_dprd1'];
        }
        if(!count($opt)) $opt[] = "- Dapil DPRD1 -";

        return $opt;
    }
}

if (!function_exists('GetOptDapilDPRD2')){
    function GetOptDapilDPRD2()
    {
        $opt=array();
        $q = GetAll("zref_dapil_dprd2", array("tahun"=> "order/desc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_dapil_dprd2']] = $r['tahun']." - ".$r['dapil_dprd2'];
        }
        if(!count($opt)) $opt[] = "- Dapil DPRD2 -";

        return $opt;
    }
}

if (!function_exists('GetOptTokoh')){
    function GetOptTokoh($is="")
    {
        $opt=array(""=> "- Tokoh -");
        if($is) $q = GetAll("zref_tokoh", array($is=> "where/1", "nama"=> "order/asc"));
        else $q = GetAll("zref_tokoh", array("nama"=> "order/asc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_tokoh']] = $r['nama'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptPilkada')){
    function GetOptPilkada()
    {
        $q_prop = GetAll("zref_prov");
        foreach($q_prop->result_array() as $r) {
            $prop[$r['id_prov']] = $r['provinsi'];
        }

        $q_kab = GetAll("zref_kab");
        foreach($q_kab->result_array() as $r) {
            $kab[$r['id_kab']] = $r['kabupaten'];
        }

        $opt=array();
        $q = GetAll("zref_pilkada");
        foreach($q->result_array() as $r) {
            $id_prop = substr($r['id_pilkada'],0,2);
            $id_kab = substr($r['id_pilkada'],0,4);
            $propz = $prop[$r['id_prov']];
            $kabz = isset($kab[$r['id_kab']]) ? " - ".$kab[$r['id_kab']] : "";
            $opt[$r['id_pilkada']] = $r['id_pilkada']." - ".$propz.$kabz;
        }

        return $opt;
    }
}

if (!function_exists('GetOptPasangan')){
    function GetOptPasangan()
    {
        $opt=array();
        $q = GetAll("pasangan", array("pasangan"=> "order/asc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_pasangan']] = $r['pasangan'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptTanggal')){
    function GetOptTanggal()
    {
        $opt=array(""=> "- tgl -");
        for($i=1;$i<=31;$i++) {
            if($i<10) $i="0".$i;
            $opt[$i] = $i;
        }

        return $opt;
    }
}

if (!function_exists('GetOptBulan')){
    function GetOptBulan()
    {
        $opt=array(""=> "- bln -");
        for($i=1;$i<=12;$i++) {
            if($i<10) $i="0".$i;
            $opt[$i] = $i;
        }

        return $opt;
    }
}

/* OPTIONS DROPDOWN */
if (!function_exists('GetOptAll')){
    function GetOptAll($tabel,$judul=NULL)
    {
        if($tabel == "pendidikan") $filter = array("urut"=> "order/asc");
        else $filter = array();
        $q = GetAll($tabel, $filter);
        if($judul) $opt[''] = $judul;
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptPublish')){
    function GetOptPublish()
    {
        $opt = array("Publish"=> "Publish", "NotPublish"=> "NotPublish");

        return $opt;
    }
}

if (!function_exists('GetOptPeriode')){
    function GetOptPeriode()
    {
        $opt = array(""=> "- Periode -", "Sekarang"=> "Sekarang", "Harian"=> "Harian", "Mingguan"=> "Mingguan",
            "Bulanan"=> "Bulanan", "Tahunan"=> "Tahunan", "Sekali Saja"=> "Sekali Saja", "Ulang Tahun"=> "Ulang Tahun");

        return $opt;
    }
}

if (!function_exists('GetOptPartnerGrup')){
    function GetOptPartnerGrup()
    {
        $q = GetAll("client_grup");
        //$opt[''] = "- Grup -";
        $opt=array();
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}


if (!function_exists('GetOptTemplate')){
    function GetOptTemplate($type="SMS")
    {
        $q = GetAll("ae_template", array("type"=> "where/".$type));
        $opt[''] = "- Template -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptPartner')){
    function GetOptPartner($type="SMS")
    {
        $grup = GetOptAll("client_grup");
        $field = $type=="SMS" ? "phone" : "email";
        $q = GetAll("client", array("id_client_grup"=> "order/asc"));
        $opt['all'] = "All";
        foreach($q->result_array() as $r)
        {
            if(!isset($opt['grup'.$r['id_client_grup']])) $opt['grup'.$r['id_client_grup']] = $grup[$r['id_client_grup']];
            //$opt[$r['id']."~".$r[$field]."~".$r['nama']] = "&nbsp;&nbsp;&nbsp;".$r['nama'];
            $opt[$r['id']] = "&nbsp;&nbsp;&nbsp;".$r['nama'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptTypeKit')){
    function GetOptTypeKit()
    {
        $opt = array("0"=> "All", "1"=> "Perorangan", "2"=> "Institusi");
        return $opt;
    }
}

if (!function_exists('GetOptAkun')){
    function GetOptAkun()
    {
        $q = GetAll("zref_apbd_process", array("id_parents"=> "where/0"));
        $opt[''] = "- Akun -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['title']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptKelompok')){
    function GetOptKelompok()
    {
        $id_parents=array();
        $q = GetAll("zref_apbd_process", array("id_parents"=> "where/0"));
        foreach($q->result_array() as $r) {
            $id_parents[] = $r['id'];
        }

        $q = GetAll("zref_apbd_process", array(), array("id_parents"=> $id_parents));
        $opt[''] = "- Kelompok -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['title']] = GetValue("title", "zref_apbd_process", array("id"=> "where/".$r['id_parents']))." - ".$r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptJenis')){
    function GetOptJenis()
    {
        $id_parents=array();
        $q = GetAll("zref_apbd_process", array("id_parents"=> "where/0"));
        foreach($q->result_array() as $r) {
            $id_parents[] = $r['id'];
        }

        $q = GetAll("zref_apbd_process", array(), array("id_parents"=> $id_parents));
        $id_parents=array();
        foreach($q->result_array() as $r) {
            $id_parents[] = $r['id'];
        }

        $q = GetAll("zref_apbd_process", array(), array("id_parents"=> $id_parents));
        $opt[''] = "- Jenis -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['title']] = GetValue("title", "zref_apbd_process", array("id"=> "where/".$r['id_parents']))." - ".$r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptPDRBSektor')){
    function GetOptPDRBSektor()
    {
        $q = GetAll("zref_pdrb_sektor");
        $opt[''] = "- PDRB Sektor -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id_pdrb_sektor']] = $r['pdrb_sektor'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptMenu')){
    function GetOptMenu()
    {
        $q = GetAll("menu_admin", array("title"=> "order/asc"));
        $opt[''] = "- Parents Menu -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptMenuInput')){
    function GetOptMenuInput()
    {
        $q = GetAll("user_menu_input", array("title"=> "order/asc"));
        $opt[''] = "- Menu -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptParentsMenuInput')){
    function GetOptParentsMenuInput()
    {
        $q = GetAll("user_menu_input", array("id_parents"=> "where/0", "title"=> "order/asc"));
        $opt[''] = "- Parents Menu -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptGrup')){
    function GetOptGrup()
    {
        $q = GetAll("user_grup");
        $opt[''] = "- Grup User -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id_user_grup']] = $r['user_grup'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptAgama')){
    function GetOptAgama()
    {
        $q = GetAll("zref_agama");
        $opt[''] = "- Agama -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['agama'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptAgamaKit')){
    function GetOptAgamaKit()
    {
        $q = GetAll("zref_agama");
        $opt['0'] = "All";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id']] = $r['agama'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptEduc')){
    function GetOptEduc()
    {
        $q = GetAll("zref_educ");
        $opt[''] = "- Education -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id_educ']] = $r['educ'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptEtnis')){
    function GetOptEtnis()
    {
        $q = GetAll("zref_etnis");
        $opt[''] = "- Etnis -";
        foreach($q->result_array() as $r)
        {
            $opt[$r['id_etnis']] = $r['etnis'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptLawan')){
    function GetOptLawan($id, $candidate="1")
    {
        $q = GetAll("ae_ref_lawan", array("project_id"=> "where/".$id, "lawan_urut >="=> "where/".$candidate));
        foreach($q->result_array() as $r)
        {
            $opt[$r['lawan_urut']] = $r['lawan_title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptLawanNoUrut')){
    function GetOptLawanNoUrut($id)
    {
        $q = GetAll("ae_ref_lawan", array("project_id"=> "where/".$id, "lawan_no_urut"=> "order/asc"));
        foreach($q->result_array() as $r)
        {
            $opt[$r['lawan_no_urut']] = $r['lawan_title'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptMappingAtr')){
    function GetOptMappingAtr($id)
    {
        $q = GetAll("ae_ref_mapping_atr", array("project_id"=> "where/".$id));
        foreach($q->result_array() as $r)
        {
            $opt[$r['mapping_atr_id']] = $r['mapping_atr_title'];
        }

        return $opt;
    }
}

if (!function_exists('DelImage')){
    function DelImage()
    {
        $CI =& get_instance();
        $webmaster_id = $this->auth();
        $mz_function = new mz_function();
        $id = $CI->input->post('del_id_img');
        $table = $CI->input->post('del_table');
        $field = $CI->input->post('del_field');

        $GetFile = GetValue($field,$table, array("id"=> "where/".$id));
        $GetThumb = GetThumb($GetFile);
        if(file_exists("./".$CI->config->item('path_upload')."/".$GetFile)) unlink("./".$CI->config->item('path_upload')."/".$GetFile);
        if(file_exists("./".$CI->config->item('path_upload')."/".$GetThumb)) unlink("./".$CI->config->item('path_upload')."/".$GetThumb);

        $data[$field] = "";
        $this->db->where("id", $id);
        $this->db->update($table, $data);
    }
}

if (!function_exists('FormatTanggal')){
    function FormatTanggal($tgl, $flag="time")
    {
        if($flag=="time") {
            $exp = explode("-", substr($tgl,0,10));
            $time = substr($tgl,11,8);
            $tgl = $exp[2]."/".date("M", strtotime($tgl))."/".$exp[0]." ".$time;
        } else {
            $exp = explode("-", $tgl);
            $tgl = $exp[2]." ".GetMonthFull(intval($exp[1]))." ".$exp[0];
        }
        return $tgl;
    }
}

if (!function_exists('FormatTanggalShort')){
    function FormatTanggalShort($tgl)
    {
        $exp = explode("-", $tgl);
        //$tgl = $exp[2]." ".GetMonth(intval($exp[1]))." ".substr($exp[0],2,2);
        $tgl = $exp[2]." ".GetMonth(intval($exp[1]))." ".$exp[0];
        return $tgl;
    }
}

if (!function_exists('FormatTanggalChart')){
    function FormatTanggalChart($tgl)
    {
        $exp = explode("-", $tgl);
        //$tgl = $exp[2]." ".GetMonth(intval($exp[1]))." ".substr($exp[0],2,2);
        $tgl = $exp[2]."/".$exp[1];
        return $tgl;
    }
}

if (!function_exists('Rupiah')){
    function Rupiah($rp)
    {
        if($rp && $rp!="-") return "Rp ".number_format($rp,0,",",".").",-";
        else return 0;
    }
}

if (!function_exists('Decimal')){
    function Decimal($rp,$koma=2)
    {
        $rp = str_replace(" ","",$rp);
        if($rp=="-1") return "N/A";
        else if($rp && $rp!="-") return number_format($rp,$koma);
        else return 0;
    }
}

if (!function_exists('Number')){
    function Number($rp)
    {
        $rp = str_replace(" ","",$rp);
        if($rp && $rp!="-") return number_format($rp,0,",",".");
        else return 0;
    }
}

if (!function_exists('KomaToTitik')){
    function KomaToTitik($rp)
    {
        return str_replace(",","",$rp);
    }
}

if (!function_exists('GetFilename')){
    function GetFilename($val)
    {
        if($val) return substr($val,15);
        else return "";
    }
}

if (!function_exists('GetTanggalIndo')){
    function GetTanggalIndo($val, $time=NULL)
    {
        $dt = strtotime($val);
        $dt = date("d", $dt)." ".GetBulanIndo(date("F", $dt))." ".date("Y", $dt);
        if($time) $dt .= "&nbsp;&nbsp;".substr($val,11,8);
        return $dt;
    }
}


if (!function_exists('GetLamaKerja')){
    function GetLamaKerja($dt)
    {
        $hr = date("d") - substr($dt,8,2);
        $bln = date("m") - substr($dt,5,2);
        $thn = date("Y") - substr($dt,0,4);

        if($hr < 0)
        {
            $hr += 30;
            $bln -=1;
        }

        if($bln < 0)
        {
            $bln += 12;
            $thn -=1;
        }

        $tahun = $thn > 0 ? $thn." tahun " : "";
        $bulan = $bln > 0 ? $bln." bulan " : "";
        $hari = $hr > 0 ? $hr." hari " : "";

        $lama_kerja = $tahun.$bulan.$hari;
        return $lama_kerja;
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

if (!function_exists('to_doc')){
    function to_doc($query, $filename='docoutput')
    {
        header("Content-type: application/msword");
        header("Content-Disposition: attachment; filename=$filename.doc");
        echo "$query";
    }
}

if (!function_exists('CekKotaKab')){
    function CekKotaKab($kab)
    {
        if(preg_match("/jakarta/", strtolower($kab)) || preg_match("/seribu/", strtolower($kab))) $kab = $kab;
        else if(!preg_match("/kota /", strtolower($kab))) $kab = "Kabupaten ".$kab;
        else $kab = str_replace("KOTA", "Kota", $kab);
        return $kab;
    }
}

if (!function_exists('TrendPartai')){
    function TrendPartai($id_partai)
    {
        $i=0;
        $list_id_partai=array();
        if(is_array($id_partai)) {
            foreach($id_partai as $idz) {
                $i=0;
                $key=$idz;
                while($i==0) {
                    $list_id_partai[] = $idz;
                    $id_parents = GetValue("id_parents", "mz_zref_partai", array("id_partai"=> "where/".$idz));
                    if($id_parents) $idz = $id_parents;
                    else $i=1;
                }
            }
        } else {
            $id_partai_utama=$id_partai;
            while($i==0) {
                $list_id_partai[] = $id_partai;
                $id_parents = GetValue("id_parents", "mz_zref_partai", array("id_partai"=> "where/".$id_partai));
                if($id_parents) $id_partai = $id_parents;
                else $i=1;
            }

            $i=0;
            while($i==0) {
                $id_partai = GetValue("id_partai", "mz_zref_partai", array("id_parents"=> "where/".$id_partai_utama));
                if($id_partai) $list_id_partai[] = $id_partai_utama = $id_partai;
                else $i=1;
            }
        }

        return $list_id_partai;
    }
}

if (!function_exists('GetPengusung')){
    function GetPengusung($id_partai, $type, $id_wil) {
        $id_partai = str_replace("-","", $id_partai);
        $exp = explode(",", str_replace(" ","",$id_partai));
        $pengusung=array();
        foreach($exp as $p) {
            if($p) $pengusung[] = "<a class='fancy' href='".site_url('popup/partai_trend_frame/'.$type.'/'.$p.'/'.$id_wil)."'>".GetValue("alias", "zref_partai", array("id_partai"=> "where/".$p))."</a>";
        }
        if(!$id_partai) return "-";
        else return join(", ", $pengusung);
    }
}

if (!function_exists('GetKoalisiPartai')){
    function GetKoalisiPartai($id_partai) {
        $id_partai = str_replace("-","", $id_partai);
        $exp = explode(",", str_replace(" ","",$id_partai));
        $pengusung=array();
        foreach($exp as $p) {
            if($p) $pengusung[] = GetValue("alias", "zref_partai", array("id_partai"=> "where/".$p));
        }
        if(!$id_partai) return "-";
        else return join(", ", $pengusung);
    }
}

if (!function_exists('GetSVGIndo')){
    function GetSVGIndo() {
        $svg=array();
        $q = GetAll("zref_prov");
        foreach($q->result_array() as $r) {
            $svg[] = "{'name': '".$r['provinsi']."', 'path' : '".$r['svg']."', 'kode_prov': '".$r['id_prov']."'}";
        }
        return join(",", $svg);
    }
}

if (!function_exists('GetSVGProv')){
    function GetSVGProv($id) {
        $svg=array();
        $q = GetAll("zref_kab", array("id_prov"=> "where/".$id));
        foreach($q->result_array() as $r) {
            $svg[] = "{'name': '".$r['kabupaten']."', 'path' : '".$r['svg']."', 'kode_prov': '".$r['id_kab']."'}";
        }
        return join(",", $svg);
    }
}

if (!function_exists('GetSVGDapilDPR')){
    function GetSVGDapilDPR() {
        $svg=array();
        $q = GetAll("zref_dapil_dpr");
        foreach($q->result_array() as $r) {
            $svg[] = "{'name': '".$r['dapil_dpr']."', 'path' : '".$r['svg']."', 'kode_prov': '".$r['id_dapil_dpr']."'}";
        }
        return join(",", $svg);
    }
}

if (!function_exists('GetSVGDapilDPRD1')){
    function GetSVGDapilDPRD1($id) {
        $svg=array();
        $q = GetAll("zref_dapil_dprd1", array("id_prov"=> "where/".$id));
        foreach($q->result_array() as $r) {
            $svg[] = "{'name': '".$r['dapil_dprd1']."', 'path' : '".$r['svg']."', 'kode_prov': '".$r['id_dapil_dprd1']."'}";
        }
        return join(",", $svg);
    }
}

if (!function_exists('GetIssue')){
    function GetIssue($id_wil=NULL) {
        $list_issue="";
        if(!$id_wil) {
            $q = GetJoin("issue_nas", "user", "user.id=issue_nas.create_id", "inner", "issue_nas.*, user.nama");
        } else {
            $type = strlen($id_wil) == 2 ? "prov" : "kab";
            $q = GetJoin("issue_".$type, "user", "user.id=issue_".$type.".create_id", "inner", "issue_".$type.".*, user.nama", array("id_".$type=> "where/".$id_wil));
        }
        foreach($q->result_array() as $key=> $r) {
            $exp = explode(" ", $r['issue']);
            foreach($exp as $idx=> $e) {
                if(preg_match("/http:/", $e)) $exp[$idx] = "<a href='".$e."'>".$e."</a>";
            }
            $r['issue'] = join(" ", $exp);
            if($key%2 == 1) $list_issue .= "<li class='kanan'>".$r['issue']."<br><i>".$r['nama']."</i></li>";
            else $list_issue .= "<li>".$r['issue']."<br><i>".$r['nama']."</i></li>";
        }
        return $list_issue;
    }
}

if (!function_exists('GetProv')){
    function GetProv($id)
    {
        return GetValue("provinsi", "zref_prov", array("id_prov"=> "where/".$id));
    }
}

if (!function_exists('GetKab')){
    function GetKab($id)
    {
        return GetValue("kabupaten", "zref_kab", array("id_kab"=> "where/".$id));
    }
}

if (!function_exists('GetKec')){
    function GetKec($id)
    {
        return GetValue("kecamatan", "zref_kec", array("id_kec"=> "where/".$id));
    }
}

if (!function_exists('GetDesa')){
    function GetDesa($id)
    {
        return GetValue("desa", "zref_desa", array("id_desa"=> "where/".$id));
    }
}

if (!function_exists('GetPartai')){
    function GetPartai($id)
    {
        return GetValue("alias", "zref_partai", array("id_partai"=> "where/".$id));
    }
}

if (!function_exists('GetOptSurnasField')){
    function GetOptSurnasField()
    {
        $opt=array();
        //$opt[] = "- Type -";
        $q = GetAll("zref_surnas_field");
        foreach($q->result_array() as $r) {
            $opt[$r['tabel']] = $r['field'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptSurnas')){
    function GetOptSurnas()
    {
        $opt=array();
        //$opt[] = "- Type -";
        $q = GetAll("zref_surnas", array("thn"=> "order/desc", "bln"=> "order/desc", "tgl"=> "order/desc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_surnas']] = $r['field']." - ".$r['keterangan'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptVarBreakdown')){
    function GetOptVarBreakdown()
    {
        //if(!$judul) $judul="- Breakdown -";
        $opt=array();//""=> $judul);
        $q = GetAll("zref_sur_breakdown", array("var_breakdown"=> "group", "urut"=> "order/asc"));
        foreach($q->result_array() as $r) {
            $opt[$r['var_breakdown']] = $r['var_breakdown'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptBreakdownID')){
    function GetOptBreakdownID()
    {
        $opt=array();
        $q = GetAll("zref_sur_breakdown", array("id_breakdown"=> "order/asc"));
        foreach($q->result_array() as $r) {
            $opt[$r['id_breakdown']] = $r['var_breakdown']." - ".$r['breakdown'];
        }

        return $opt;
    }
}

if (!function_exists('GetOptIDBreakdown')){
    function GetOptIDBreakdown($var_break="")
    {
        $opt=array();
        //$opt[] = "All";
        if($var_break) {
            $q = GetAll("zref_sur_breakdown", array("var_breakdown"=> "where/".$var_break, "id_breakdown"=> "order/asc"));
            foreach($q->result_array() as $r) {
                $opt[$r['id_breakdown']] = $r['breakdown'];
            }
        }

        return $opt;
    }
}

if (!function_exists('GetOptFieldSurvei')){
    function GetOptFieldSurvei($cat="")
    {
        $param=array();
        if($cat=="arah_bangsa") $param=array("benar"=> "Benar", "salah"=> "Salah", "tttj"=> "TTTJ");
        else if(preg_match("/_kinerja/", $cat)) $param=array("puas"=> "Puas", "tidak_puas"=> "Tidak Puas", "tttj"=> "TTTJ");
        else if($cat=="demokrasi_prefer") $param=array("tidakpeduli"=> "Tidak Peduli", "not_prefer"=> "Not Prefer", "prefer"=> "Prefer", "tttj"=> "TTTJ");
        else if(preg_match("/ekonomi_/", $cat)) $param=array("better"=> "Better", "same"=> "Same", "worse"=> "Worse", "tttj"=> "TTTJ");
        else if(preg_match("/kondisi_/", $cat)) $param=array("baik"=> "Baik", "sedang"=> "Sedang", "buruk"=> "Buruk", "tttj"=> "TTTJ");
        else if($cat=="partyid") $param=array("ada"=> "Ada", "tidak_ada"=> "Tidak Ada", "tttj"=> "TTTJ");

        return $param;
    }
}

if (!function_exists('GetOptGender')){
    function GetOptGender()
    {
        $opt = array("1"=> "Laki-laki", "2"=> "Perempuan");

        return $opt;
    }
}

if (!function_exists('GetGender')){
    function GetGender($id_gender=0)
    {
        if(!$id_gender) return "";
        return $gender = $id_gender==1 ? "Laki-laki" : "Perempuan";
    }
}

if (!function_exists('CekNA')){
    function CekNA($val)
    {
        if(intval($val) == -1 || $val=="N/A") return "N/A";
        else return $val;
    }
}

if (!function_exists('GetJumKab')){
    function GetJumKab($id)
    {
        return GetCount("zref_kab", "id_prov", array("id_prov"=> "where/".$id), "value");
    }
}

if (!function_exists('GetJumIsland')){
    function GetJumIsland($id)
    {
        if($id < 30) $q = GetAll("zref_kab", array("id_prov <"=> "where/30"));
        else if($id > 30 && $id < 50) $q = GetAll("zref_kab", array("id_prov >"=> "where/30", "id_prov <"=> "where/50"));
        else if($id > 50 && $id < 60) $q = GetAll("zref_kab", array("id_prov >"=> "where/50", "id_prov <"=> "where/60"));
        else if($id > 60 && $id < 70) $q = GetAll("zref_kab", array("id_prov >"=> "where/60", "id_prov <"=> "where/70"));
        else if($id > 70 && $id < 80) $q = GetAll("zref_kab", array("id_prov >"=> "where/70", "id_prov <"=> "where/80"));
        else if($id > 80 && $id < 100) $q = GetAll("zref_kab", array("id_prov >"=> "where/80", "id_prov <"=> "where/100"));
        return $q->num_rows();
    }
}

if (!function_exists('GetJumNas')){
    function GetJumNas($id)
    {
        $q = GetAll("zref_kab");
        return $q->num_rows();
    }
}

if (!function_exists('CekPartaiUtama')){
    function CekPartaiUtama($id_partai)
    {
        $q = GetValue("is_utama", "zref_partai", array("id_partai"=> "where/".$id_partai));
        return $q;
    }
}

if (!function_exists('ConfigEmail')){
    function ConfigEmail()
    {
        $config=array();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "mazhtersevents@gmail.com";
        $config['smtp_pass'] = "ikutanah";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        return $config;
    }
}

if (!function_exists('sendsms')){
    function sendsms($no_hp, $isi_sms)
    {
        mysql_connect("localhost", "root", "");
        mysql_select_db("smsd");
        $sql = "Insert into outbox set DestinationNumber='$no_hp',TextDecoded='$isi_sms',InsertIntoDB='".date("Y-m-d H:i:s")."'";
        mysql_query($sql);

        mysql_close();
    }
}
?>