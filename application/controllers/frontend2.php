<?php
/*
 * Control del FrontEnd
 */
class Frontend extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('publicaciones_model');
    }
    public function index(){
        $this->verificar();
        $test = $this->usuario_model->get_id($this->session->userdata('nombre'));
        $data = array(
            'usuario' => $this->usuario_model->get_usuario($this->session->userdata('nombre')),
            'mensajes' => $this->publicaciones_model->get_publicaciones($test['id']),
            'num_siguiendo' => $this->usuario_model->get_num_siguiendo($test['id']),
            'num_seguidores' => $this->usuario_model->get_num_seguidores($test['id']),
            'siguiendo' => $this->usuario_model->get_siguiendo($test['id']),
            'seguidores' => $this->usuario_model->get_seguidores($test['id']),
            'num_mensajes' => $this->publicaciones_model->get_num_publicaciones($test['id'])
        );
        $this->load->view('panel',$data);
    }
     public function perfil($usuario){
        $test = $this->usuario_model->get_id($usuario);
        $idanterior = $this->usuario_model->get_id($this->session->userdata('nombre'));
        if($test !=0){
        $data = array(
            'id_u' => $idanterior['id'],
            'usuario' => $this->usuario_model->get_usuario($usuario),
            'action' => $this->get_url3($test['id']),
            'mensajes' => $this->publicaciones_model->get_publicaciones_propias($test['id']),
            'num_siguiendo' => $this->usuario_model->get_num_siguiendo($test['id']),
            'num_seguidores' => $this->usuario_model->get_num_seguidores($test['id']),
            'siguiendo' => $this->usuario_model->get_siguiendo($test['id']),
            'seguidores' => $this->usuario_model->get_seguidores($test['id']),
            'num_mensajes' => $this->publicaciones_model->get_num_publicaciones($test['id'])
        );
        $this->load->view('perfil',$data);
        }
        else {
            redirect('frontend','refresh');
        }
    }
    public function iniciar(){
       if($this->verificar_sesion() == TRUE){
           $data = array(
               'nombre' => $this->input->post('Usuario')
           );
           $this->session->set_userdata($data);
           redirect('frontend','refresh');
       }
       else
       {
           $data = array(
               'action' => $this->get_url('iniciar'),
               'action2' => $this->get_url('registrar')
           );
           $this->load->view('welcome_message',$data);
       }
    }
    public function verificar_sesion(){
        $this->form_validation->set_rules('Usuario','Usuario','required|callback_verificar_usuario');
        $this->form_validation->set_rules('Clave','Clave','required');
        
        $this->form_validation->set_message('verificar_usuario','El Usuario/Contraseña Son Incorrecto');
        $this->form_validation->set_message('required','El Campo %s Es Requerido');
        return $this->form_validation->run();
    }
    public function verificar_usuario(){
        if($this->usuario_model->verificar_usuario() == TRUE)
            return true;
        else
            return false;
    }
    public function cerrar(){
        $this->session->sess_destroy();
        redirect('welcome');
    }
    public function verificar(){
        if(!$this->session->userdata('nombre'))
        {
            redirect('welcome');
        }
    }
    public function registrar(){
        if($this->verificar_registro() == true){
            $this->usuario_model->registrar();
            redirect('welcome');
        }
        else
        {
            $data = array(
               'action' => $this->get_url2('iniciar'),
               'action2' => $this->get_url2('registrar')
           );
           $this->load->view('welcome_message',$data);
        }
    }
    public function verificar_registro(){
        $this->form_validation->set_rules('Usuario2','Usuario','required|trin|callback_buscar_usuario');
        $this->form_validation->set_rules('Nombre2','Nombre','required');
        $this->form_validation->set_rules('Correo2','Correo','required|trin|valid_email|callback_buscar_correo');
        $this->form_validation->set_rules('Clave2','Clave','required|trin');
        
        $this->form_validation->set_message('required','El Campo %s Es Requerido');
        $this->form_validation->set_message('valid_email','Ingrese un Correo Valido');
        $this->form_validation->set_message('buscar_usuario','El Usuario ya esta Registrado');
        $this->form_validation->set_message('buscar_correo','El Correo ya esta Registrado');
        return $this->form_validation->run();
    }
    public function get_url($pagina){
        if(current_url() == 'http://diario.com/frontend/iniciar'){
              $action = $pagina;
        }      
        else{
              $action = 'frontend/'.$pagina;
        }
        return $action;
    }
    public function get_url2($pagina){
        if(current_url() == 'http://diario.com/frontend/registrar')
              $action2 = $pagina;
        else
              $action2 = 'frontend/'.$pagina;
        return $action2;
    }
    public function get_url3($id){
        if(current_url() == 'http://diario.com/frontend/perfil/'.$id)
              $action = '../cerrar';
        else
              $action = 'frontend/cerrar';
        return $action;
    }
    public function buscar_usuario(){
        if($this->usuario_model->buscar_usuario() == true)
            return false;
        else
            return true;
    }
    public function buscar_correo(){
        if($this->usuario_model->buscar_correo() == true)
            return false;
        else
            return true;
    }
    public function add_publicacion($id,$url = ''){
        $mensaje = $this->input->post('mensaje');
        if(!empty($mensaje)){
            $this->publicaciones_model->add_publicacion($id);
            if($url == 'perfil')
              redirect('frontend/perfil/'.$id);
            else
              redirect('frontend');
        }
    }
}
?>
