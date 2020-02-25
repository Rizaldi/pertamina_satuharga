<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*************************************
 * Created : June 2013
 * Update  : June 2013
 * Creator : Andi Galuh S
 * Email   : andi@komunigrafik.com
 *************************************/

class quick_links_to_lessons_learnt extends CI_Controller  {

    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data['content'] = $query = $this->db->query("select * from kg_contentmdf where parent=''");
        $data['executive'] = $query = $this->db->query("select * from kg_executive_summary where id='1'")->row();
        $data['acknowledgements'] = $query = $this->db->query("select * from kg_acknowledgements where id='1'")->row();
        $data['foreword'] = $query = $this->db->query("select * from kg_foreword where id='1'")->row();

        $data['table'] = $query = $this->db->query("select * from kg_contentmdf where parent=''")->result();
        $data['gallery'] = $query = $this->db->query("select * from kg_gallery order by id Desc LIMIT 0,5 ")->result();


        $this->load->view('forward',$data);
    }
    function p($id){


    }
    function main(){
        $data = GetHeaderFooter(1);

        $this->load->view('home',$data);
    }

    function newsletter_signup()
    {
        $this->form_validation->set_rules('newsletter', 'Newletter', 'trim|required|valid_email|callback_valid_email_newsletter');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            echo "ok";
        }

    }

    function valid_email_newsletter($nis)
    {
        $exist_email = $this->all_model->CekTotalRecord('kg_newsletter','email',$nis);

        if($exist_email > 0)
        {
            $this->form_validation->set_message('valid_email_newsletter', lang('email_newsletter_exist'));
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function newsletter_process()
    {
        $email_address = $this->input->post('email_address');
        $nama = $this->input->post('nama');
        $org = $this->input->post('org');
        $position = $this->input->post('position');
        $data = array('email'=>$email_address,'title'=>$nama,'organization'=>$org,'position'=>$position,'create_date'=>date('Y-m-d H:i:s',now()));
        $this->db->insert("kg_newsletter", $data);
        $idins = $this->db->insert_id();
        $this->load->library('email');

        //email to user
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from('no-reply', 'no-reply');
        $this->email->to($email_address);
        $this->email->subject('Newsletter Registration');
        $this->email->message('Dear '.$nama.',<br/><br/>
			Thank you for subscribing to updates from The Prakarsa.<br/><br/>
			Kind regards,<br/>
			The Prakarsa Communications Team 
			');

        $this->email->send();

        //email to admin
        $config1['wordwrap'] = TRUE;
        $config1['mailtype'] = 'html';

        $this->email->initialize($config1);
        $this->email->from($email_address);
        $this->email->to('perkumpulan@theprakarsa.org; andi@komunigrafik.com');
        $this->email->subject('Newsletter Registration Theprakarsa.org');
        $this->email->message('Hello Admin,<br/><br/>
			New registered newsletter !<br/>
			name : '.$nama.'<br/>
			email : '.$email_address.'<br/>
			organisation : '.$org.'<br/>
			position : '.$position.'
			');
        $this->email->send();

        echo "true";
    }


}