<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function verificar(){
        if($this->session->userdata('nombre'))
        {
            redirect('frontend');
        }
        }
	public function index()
	{
            $this->verificar();
            $data = array(
                'action' => 'frontend/iniciar',
                'action2' => 'frontend/registrar'
            );
            $this->parser->parse('welcome_message', $data);
            //$this->load->view('welcome_message',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */