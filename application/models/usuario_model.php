<?php
/*
 * Model de Usuarios
 */
class Usuario_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    public function verificar_usuario(){
        $data = array(
            'Usuario' => $this->input->post('Usuario'),
            'Clave' => $this->input->post('Clave')
        );
        $consulta = $this->db->get_where('usuarios',$data);
        if($consulta->num_rows() == 1){
             return true;
        }
        else{
            return false;
        }
    }
    public function registrar(){
        $usuario = $this->input->post('Usuario2');
        $data = array(
            'Nombre' => $this->input->post('Nombre2'),
            'Apellido' => $this->input->post('Apellido'),
            'Usuario' => $usuario,
            'Clave' => $this->input->post('Clave2'),
            'Correo' => $this->input->post('Correo2'),
            'foto' => 'sinfoto.png'
        );
        $this->db->insert('usuarios',$data);
        mkdir('plantilla/images/'.$usuario);
        mkdir('plantilla/images/'.$usuario.'/perfil');
        mkdir('plantilla/images/'.$usuario.'/albunes');
    }
    public function buscar_usuario(){
        //Busca el usuario en la db
        $consulta = $this->db->get_where('usuarios',array('Usuario' => $this->input->post('Usuario2')));
        if($consulta->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }
    public function buscar_correo(){
        //Busca el correo en la db
        $consulta = $this->db->get_where('usuarios',array('Correo' => $this->input->post('Correo2')));
        if($consulta->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }
    public function get_usuario($usuario){
        //Obtiene los datos del usuario por medio del username
        $consulta =  $this->db->get_where('usuarios',array('Usuario' => $usuario));
        return $consulta->result_array();
    }
    public function get_usuario_id($id){
        //Obtiene los datos del usuario por medio del ID
        $consulta =  $this->db->get_where('usuarios',array('id' => $id));
        return $consulta->row_array();
    }
    public function get_id($usuario){
        //Obtiene la ID del Usuario por medio de su Username
        $this->db->select('id');
        $this->db->from('usuarios');
        $this->db->where('Usuario',$usuario);
        $consulta = $this->db->get();
        if($consulta->num_rows() == 1){
            return $consulta->row_array();
        }
        else {
            return 0;
       }
    }
    public function verificar_amistad($id_envia,$id_recibe){
        if($id_envia != $id_recibe){
            $where = "(id_envia = ".$id_envia." AND id_recibe =".$id_recibe.") 
                OR ( id_recibe =".$id_envia." AND id_envia =".$id_recibe.")";
            $this->db->select('estado')->from('amigos')->where($where);
            $consulta = $this->db->get();
        if($consulta->num_rows() != 0){
            $estado = $consulta->row_array();
            if($estado['estado'] == '2'){
                return 'esperando';
            }
            else if($estado['estado'] == '1'){
                return 'amigos';
            }
        }
        else{
            return 'no';
        }  
        }
        else{
            return 'propio';
        }
    }

    public function solicitud_amistad($id_envia,$id_recibe){
        $data = array(
            'id_envia' => $id_envia,
            'id_recibe' => $id_recibe,
            'estado' => '2'
        );
        $this->db->insert('amigos',$data);
    }
    public function aceptar_amistad($id_envia,$id_recibe){
        $data = array(
            'id_envia' => $id_envia,
            'id_recibe' => $id_recibe,
            'estado' => '2'
        );
        $data2 = array(
            'estado' => '1'
        );
        $this->db->where($data)->update('amigos',$data2);
    }
    public function solicitudes_enviadas($id_envia){
        $data = array(
            'id_envia' => $id_envia,
            'estado' => '2'
        );
        $this->db->from('amigos')->where($data)->join('usuarios', 'usuarios.id = amigos.id_recibe');
        return $this->db->get()->result_array();
    }
    public function solicitudes_recibidas($id_recibe){
        $data = array(
            'id_recibe' => $id_recibe,
            'estado' => '2'
        );
        $this->db->from('amigos')->where($data)->join('usuarios', 'usuarios.id = amigos.id_envia');
        return $this->db->get()->result_array();
    }
    public function get_amigos($id){
            //Obtiene los amigos que el usuario agrego
            $this->db->from('amigos')->where('estado','1')->where('id_envia',$id);
            $this->db->join('usuarios', 'usuarios.id = amigos.id_recibe');
            $consulta1 = $this->db->get()->result_array();
          
            //Obtiene los amigos que agregaron al Usuario
            $this->db->from('amigos')->where('estado','1')->where('id_recibe',$id);
            $this->db->join('usuarios', 'usuarios.id = amigos.id_envia');
            $consulta2 = $this->db->get()->result_array();  
            
            return array_merge($consulta1,$consulta2);  
    }
    public function num_amigos($id){
            //Obtiene los amigos que el usuario agrego
            $this->db->from('amigos')->where('estado','1')->where('id_envia',$id);
            $this->db->join('usuarios', 'usuarios.id = amigos.id_recibe');
            $consulta1 = $this->db->count_all_results();
          
            //Obtiene los amigos que agregaron al Usuario
            $this->db->from('amigos')->where('estado','1')->where('id_recibe',$id);
            $this->db->join('usuarios', 'usuarios.id = amigos.id_envia');
            $consulta2 = $this->db->count_all_results();
            
            return $consulta1 + $consulta2; 
    }
    public function get_ultimos(){
        $this->db->from('usuarios');
        $this->db->order_by('id','DESC');
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }
}

?>
