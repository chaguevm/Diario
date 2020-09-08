<?php
//Ordenamiento por burbuja por ids de publicacion
function ordenar($mensajes) {
    $n = count($mensajes);
    for ($i = 1; $i < $n; $i++) {
        for ($j = $n - 1; $j >= $i; $j--) {
            if ($mensajes[$j - 1]['ids'] < $mensajes[$j]['ids']) {
                $aux = $mensajes[$j];
                $mensajes[$j] = $mensajes[$j - 1];
                $mensajes[$j - 1] = $aux;
            }
        }
    }
    return $mensajes;
}
function ordenar2($mensajes) {
    $n = count($mensajes);
    for ($i = 0; $i < $n-1; $i++) {
        for ($j = 0; $j <  $n-1; $j++) {
            if ($mensajes[$j]['id_mensaje'] > $mensajes[$j+1]['id_mensaje']) {
                $aux = $mensajes[$j];
                $mensajes[$j] = $mensajes[$j + 1];
                $mensajes[$j + 1] = $aux;
            }
        }
    }
    return $mensajes;
}
function mencion($text) {
    //Comprobamos las Menciones
    preg_match_all("/[@]+([A-Za-z0-9-_]+)/", $text, $users);
    $mentions = $users[1];

    foreach ($mentions as $key => $user) {
        $uid = 1; // comprobamos si existe en nuestra database, modificar segun su script 
        if (!empty($uid)) {
            $find = '@' . $user;
            $replace = '<a href="' . $user . '" >@' . $user . '</a> ';
            $text = str_replace($find, $replace, $text);
        }
    }

    //Comprobamos los Hashtag
    preg_match_all('/[#]+([A-Za-z0-9-_]+)/', $text, $hash);
    $hashtag = $hash[1];

    foreach ($hashtag as $key => $hash) {
        //Aqui podemos hacer que lo agrege a la database
        $find = '#' . $hash;
        $replace = '<strong>#' . $hash . '</strong> ';
        $text = str_replace($find, $replace, $text);
    }
    return $text;
}
function sapo($id){
            $CI =& get_instance();
            $CI->load->model('usuario_model');
            $usuario = $CI->usuario_model->get_usuario_id($id);
            return $usuario;
} 
?>