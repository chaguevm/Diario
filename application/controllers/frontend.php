<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Control del FrontEnd
 */
require 'plantilla/funciones.php';
class Frontend extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('publicaciones_model');
    }
    //Verifica si hay un inicio de sesion!
    public function verificar(){
        $existe = false;
        if($this->session->userdata('nombre'))
        {
            $existe = true;
        }
        return $existe;
    }
    //Carga la vista del Welcome
    public function welcome(){
        $data = array(
                'action' => 'frontend/iniciar',
                'action2' => 'frontend/registrar'
            );
        $this->parser->parse('welcome_message', $data);
    }
    //Carga la vista principal... 
    public function index(){
        if($this->verificar()){
        $test = $this->usuario_model->get_id($this->session->userdata('nombre'));
        $mensajes = $this->publicaciones_model->get_publicaciones($test['id']);
        $data = array(
            'id' => $test['id'],
            'titulo' => 'Timeline Diario.com',
            'usuario' => $this->usuario_model->get_usuario($this->session->userdata('nombre')),
            'mensajes' => ordenar($mensajes),
            'ultimos' => $this->usuario_model->get_ultimos(),
            'hashtags' => $this->publicaciones_model->get_hashtag(),
            'num_mensajes' => $this->publicaciones_model->get_num_mensajes($test['id'])
        );
        $this->parser->parse('panel',$data);
        }
        else{
            $this->welcome();
        }
    }
    //Carga la vista del Perfil
    public function perfil($usuario){
        if($this->verificar()){
            $test = $this->usuario_model->get_id($usuario); //Obtiene id del usuario al que se va a ver el Perfil
            $idanterior = $this->usuario_model->get_id($this->session->userdata('nombre')); //Obtiene el id del usuario Logueado
            $publicaciones_propias = $this->publicaciones_model->get_publicaciones_propias($test['id']); //Obtiene publicacion del Perfil del Usuario Logueado o Visitado
            if($test !=0){
            $data = array(
                'id_u' => $idanterior['id'],
                'id_p' => $test['id'],
                'usuario' => $this->usuario_model->get_usuario($usuario),
                'publicaciones_propias' => ordenar($publicaciones_propias),
                'num_publicaciones' => $this->publicaciones_model->get_num_publicaciones($test['id']),
                'num_mensajes' => $this->publicaciones_model->get_num_mensajes($test['id']),
                'seguimiento' => $this->usuario_model->verificar_amistad($idanterior['id'],$test['id']),
                'solicitudes_recibidas' => $this->usuario_model->solicitudes_recibidas($idanterior['id']),
                'amigos' => $this->usuario_model->get_amigos($test['id']),
                'num_amigos' => $this->usuario_model->num_amigos($test['id']),
                'num_mensajes' => $this->publicaciones_model->get_num_mensajes($idanterior['id'])
            );
            $this->parser->parse('perfil',$data);
            }
            else {
                redirect('','refresh');
            }
        }
        else{
            $this->welcome();
        }
    }
    public function iniciar(){
       if($this->verificar_sesion() == TRUE){
           $data = array(
               'nombre' => $this->input->post('Usuario')
           );
           $this->session->set_userdata($data);
           redirect('','refresh');
       }
       else
       {
           $data = array();
           $this->parser->parse('welcome_message',$data);
       }
    }
    //Verifica la informacion pasada por formulario! 
    public function verificar_sesion(){
        $this->form_validation->set_rules('Usuario','Usuario','required|callback_verificar_usuario');
        $this->form_validation->set_rules('Clave','Clave','required');
        
        $this->form_validation->set_message('verificar_usuario','El Usuario/Contraseña Son Incorrecto');
        $this->form_validation->set_message('required','El Campo %s Es Requerido');
        return $this->form_validation->run();
    }
    //Comprueba si el usuario existe en la DB
    public function verificar_usuario(){
        if($this->usuario_model->verificar_usuario() == TRUE)
            return true;
        else
            return false;
    }
    public function cerrar(){
        $this->session->sess_destroy();
        redirect('');
    }
    public function registrar(){
        if($this->verificar_registro() == true){
            $this->usuario_model->registrar();
            redirect('');
        }
        else
        {
           $data = array();
           $this->parser->parse('welcome_message',$data);
        }
    }
    public function verificar_registro(){
        $this->form_validation->set_rules('Usuario2','Usuario','required|trin|callback_buscar_usuario');
        $this->form_validation->set_rules('Nombre2','Nombre','required');
        $this->form_validation->set_rules('Apellido','Apellido','required');
        $this->form_validation->set_rules('Correo2','Correo','required|trin|valid_email|callback_buscar_correo');
        $this->form_validation->set_rules('Clave2','Clave','required|trin|matches[ConfClave]');
        $this->form_validation->set_rules('ConfClave','ConfClave','required|trin');
        
        $this->form_validation->set_message('required','El Campo %s Es Requerido');
        $this->form_validation->set_message('valid_email','Ingrese un Correo Valido');
        $this->form_validation->set_message('buscar_usuario','El Usuario ya esta Registrado');
        $this->form_validation->set_message('buscar_correo','El Correo ya esta Registrado');
        $this->form_validation->set_message('matches','No Coinciden las Contraseñas');
        return $this->form_validation->run();
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
    public function subirimagen($usuario){
        $config['upload_path'] = 'plantilla/images/'.$usuario.'/albunes';
	$config['allowed_types'] = 'gif|jpg|png';
	$config['max_size']	= '500';
	$config['max_width']  = '1024';
	$config['max_height']  = '768';
        
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('imagen'))
            {
		$error = array('error' => $this->upload->display_errors());
            }	
	else
            {
		$data = array('upload_data' => $this->upload->data());
            }
    }
    public function add_publicacion($id,$donde,$url){
        $user = $this->usuario_model->get_usuario_id($id);
        $mensaje = $this->input->post('mensaje');
            if(!empty($mensaje)){
                $usuario = $user['Usuario'];
                $this->subirimagen($usuario);
                $this->publicaciones_model->add_publicacion($id,$donde);
                if(preg_match_all('/[#]+([A-Za-z0-9-_]+)/',$mensaje, $hash))
                {
                    $hashtag = $hash[1];
                    foreach($hashtag  as $key => $hash){
                        $this->publicaciones_model->add_hashtag($hash);
                    }
                }
                if($url == 1){
                    redirect('');
                }    
                else if($url == 2){
                    if($id == $donde){
                        $user = $this->usuario_model->get_usuario_id($id);
                        $usario = $user['Usuario'];
                        redirect($usario,'refresh');
                    }
                    else{
                        $user = $this->usuario_model->get_usuario_id($donde);
                        $usario = $user['Usuario'];
                        redirect($usario,'refresh');
                    }
                }
                    
            }
    }
    public function solicitud_amistad($seguidor,$seguido){
            $this->usuario_model->solicitud_amistad($seguidor,$seguido);
            $user = $this->usuario_model->get_usuario_id($seguido);
            redirect('/'.$user['Usuario'],'refresh');
    }
    public function aceptar_amistad($id_envia,$id_recibe){
            $this->usuario_model->aceptar_amistad($id_envia,$id_recibe);
            $user = $this->usuario_model->get_usuario_id($id_recibe);
            redirect('/'.$user['Usuario'],'refresh');
    }
    public function dejar_amistad($seguidor,$seguido){
            $this->usuario_model->dejar_amistad($seguidor,$seguido);
            $user = $this->usuario_model->get_usuario_id($seguido);
            redirect('/'.$user['Usuario'],'refresh');
    }
    public function get_comentarios($ids){
        $this->publicaciones_model->get_comentarios($ids);
    }
    public function add_comentario($id_publicaicon,$id_usuario){
        $mensaje = $this->input->post('comentario');
            if(!empty($mensaje)){
                $this->publicaciones_model->add_comentarios($id_publicaicon,$id_usuario);
                if(preg_match_all('/[#]+([A-Za-z0-9-_]+)/',$mensaje, $hash))
                {
                    $hashtag = $hash[1];
                    foreach($hashtag  as $key => $hash){
                        $this->publicaciones_model->add_hashtag($hash);
                    }
                }
                  redirect('');
            }
    }
    public function hashtags($hash){
        $data = array(
            'mensajes' => $this->publicaciones_model->get_publicaciones_hashtag($hash),
            'hashtags' => $this->publicaciones_model->get_hashtag()
        );
        $this->parser->parse('hashtags',$data);
    }
    //Muestra la lista de los mensajes... 
    public function mensajes($id){
        $data = array(
            'id_u' => $id,
            'mensajes' => $this->publicaciones_model->mensajes($id)
        );
        $this->parser->parse("mensajes",$data);
    }
    public function detalles_mensajes($id_envia,$id_recibe){
        $data = array(
            'id_logueado' => $id_recibe,
            'id_destino' => $id_envia,
            'mensajes' => ordenar2($this->publicaciones_model->get_mensajes($id_envia,$id_recibe))
        );
        $this->parser->parse("detallesmensajes",$data);
    }
    public function get_mensajes($id_envia,$id_recibe){
        $this->publicaciones_model->get_mensajes($id_envia,$id_recibe);
    }
    public function enviar_mensaje($id_envia,$id_recibe){
        $mensaje = $this->input->post('mensaje');
        if(!empty($mensaje))
            $this->publicaciones_model->enviar_mensaje($id_envia,$id_recibe);
        $ruta = "frontend/detalles_mensajes/".$id_recibe."/".$id_envia;
        redirect($ruta,'refresh');  
    }
    public function megusta($id){
        $this->publicaciones_model->megusta($id);
        redirect('');
    }
}
?>
