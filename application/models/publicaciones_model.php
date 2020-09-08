<?php

class Publicaciones_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }
    //Agrega la publicacion a la base de datos...
    public function add_publicacion($id,$donde){
        $contenido = $this->input->post('mensaje');
        $video = $this->input->post('video');
        if(empty($video))
            $video = NULL;
        if(empty($imagen))
            $imagen = NULL;
        $data = array(
            'contenido' => $contenido,
            'imagen' => $_FILES['imagen']['name'],
            'video' => $video,
            'id_usuario' => $id,
            'donde' => $donde
        );
        $this->db->insert('publicaciones',$data);
    }
    //Obtiene todas las publicaciones... Del usuario Logueado y  los usuarios a los que Sigue
    public function get_publicaciones($id){
        /*Muestra las publicaciones Propias*/
        $this->db->from('publicaciones');
        $this->db->where('id_usuario',$id);
        $this->db->join('usuarios', 'usuarios.id = publicaciones.id_usuario');
        //$this->db->join('megusta', 'megusta.id_publicacion = publicaciones.ids');
        $query1 = $this->db->get()->result_array(); //Guarda la consulta de las publicaciones

        /*  Muestra las publicaciones de los amigos que agregó el usuario */
        $this->db->from('amigos');
        $data = array(
            'id_envia' => $id,
            'estado' => '1'
        );
        $this->db->where($data);
        $this->db->join('publicaciones', 'publicaciones.id_usuario = amigos.id_recibe');
        $this->db->join('usuarios', 'usuarios.id = publicaciones.id_usuario');
        //$this->db->join('megusta', 'megusta.id_publicacion = publicaciones.ids');
        $query2 = $this->db->get()->result_array();
       
        /*  Muestra las publicaciones de los amigos que agregaron al usuario */
        $this->db->from('amigos');
        $data2 = array(
            'id_recibe' => $id,
            'estado' => '1'
        );
        $this->db->where($data2);
        $this->db->join('publicaciones', 'publicaciones.id_usuario = amigos.id_envia');
        $this->db->join('usuarios', 'usuarios.id = publicaciones.id_usuario');
        //$this->db->join('megusta', 'megusta.id_publicacion = publicaciones.ids');
        $query3 = $this->db->get()->result_array();
        return array_merge($query3,$query2,$query1); //Hace un UNION de las 2 consultas
    }
    //Obtiene las publicaciones del Usuario Logueado
     public function get_publicaciones_propias($id){
        /*Muestra las publicaciones Propias*/
        $this->db->from('publicaciones');
        $data = array(
            'id_usuario' => $id,
            'donde' => $id
        );
        $this->db->where($data)->or_where('donde',$id);
        $this->db->join('usuarios', 'usuarios.id = publicaciones.id_usuario');
        //$this->db->join('megusta', 'megusta.id_publicacion = publicaciones.ids');
        return $this->db->get()->result_array(); //Guarda la consulta de las publicaciones
    }
    //Obtiene el numero de publicaciones hechas...
    public function get_num_publicaciones($id){
        $this->db->from("publicaciones");
        $this->db->where('id_usuario',$id);
        return $this->db->get()->num_rows();
    }
    //Guarda en la DB los HT
    public function add_hashtag($find){
        $consulta = $this->db->get_where('hashtags',array('hashtag' => $find)); // Busca si el HT ya esta guardado
        if($consulta->num_rows() == 0){
            $data = array(
            'hashtag' => $find
            );
            $this->db->insert('hashtags',$data); // Guarda el HT
        }
    }
    //Obtiene los HT
    public function get_hashtag(){
        return $this->db->get('hashtags')->result_array();
    }
    //Obtiene el Historial de Publicaciones y Comentarios que han usado el HT
    public function get_publicaciones_hashtag($hash){
        $this->db->from('publicaciones');
        $match = "#".$hash;
        $this->db->like('contenido',$match);
        $this->db->join('usuarios', 'usuarios.id = publicaciones.id_usuario');
        $query1 = $this->db->get()->result_array();
        
        $this->db->from('comentarios');
        $match = "#".$hash;
        $this->db->like('contenido',$match);
        $this->db->join('usuarios', 'usuarios.id = comentarios.id_usuario');
        $query2 = $this->db->get()->result_array();
        return array_merge($query2,$query1);
    }
    //Agrega los comentarios a la DB
    public function add_comentarios($id_publicacion,$id_usuario){
        $data = array(
            'contenido' => $this->input->post('comentario'),
            'id_usuario' => $id_usuario,
            'id_publicacion' => $id_publicacion
        );
        $this->db->insert('comentarios',$data);
    }
    //Obtiene los Comentarios de la DB
    public function get_comentarios($ids){
        $this->db->from('comentarios');
        $this->db->where('id_publicacion',$ids);
        $this->db->join('usuarios', 'usuarios.id = comentarios.id_usuario');
        return $this->db->get()->result_array(); //Guarda la consulta de las publicaciones
    }
    //Obtiene el Numero de Mensajes Privados
    public function get_num_mensajes($id){
        $this->db->from("mensajes");
        $this->db->where('id_recibe',$id);
        return $this->db->get()->num_rows();
    }
    //Muestra los mensajes agrupados por usuario.. muestra el primer mensaje recibido... 
    public function mensajes($id){
        $this->db->from('mensajes');
        $this->db->where('id_recibe',$id);
        $this->db->join('usuarios', 'usuarios.id = mensajes.id_envia');
        $this->db->group_by('id_envia');
        $this->db->order_by('id_mensaje','DESC');
        return $this->db->get()->result_array();
    }
    //Muestra todos los mensajes recibidos y enviados a un usuario en especifico... 
    public function get_mensajes($id_envia,$id_recibe){
        //Selecciona los recibidos por un usuario
        $this->db->from('mensajes');
        $this->db->where('id_envia',$id_envia);
        $this->db->where('id_recibe',$id_recibe);
        $this->db->join('usuarios', 'usuarios.id = mensajes.id_envia');
        $query1 = $this->db->get()->result_array();
        //Selecciona los enviado a ese usuario
        $this->db->from('mensajes');
        $this->db->where('id_envia',$id_recibe);
        $this->db->where('id_recibe',$id_envia);
        $this->db->join('usuarios', 'usuarios.id = mensajes.id_envia');
        $query2 = $this->db->get()->result_array();
        
        return array_merge($query1,$query2);
    }
    public function enviar_mensaje($id_envia,$id_recibe){
        $data = array(
            'mensaje' => $this->input->post("mensaje"),
            'id_envia' => $id_envia,
            'id_recibe' => $id_recibe
        );
        $this->db->insert('mensajes',$data);
    }
    public function megusta($id){
        $query = 'UPDATE megusta SET megusta = megusta + 1 WHERE id_publicacion ='.$id;
        $this->db->query($query);
    }
}
?>
