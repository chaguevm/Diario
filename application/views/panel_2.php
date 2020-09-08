<!DOCTYPE HTML>
<html>
    <head>
        <title>{titulo}</title>
        <link href="plantilla/estilos.css"  rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav>
        {usuario}
        <div id="usuario">
        <img src="plantilla/images/{foto}" width="100" height="100"></img>
        <span id="datos">
        <h2><a href="Perfil/{Usuario}">{Nombre}</a></h2> 
        <h4>@{Usuario}</h4>
        </span>
        </div>
        <a href="frontend/cerrar">Cerrar Sesion</a>
        <form action='frontend/add_publicacion/{id}' method="POST" id="publicacion">
            <fieldset>
            <textarea name='mensaje' placeholder="¿Que hay de Nuevo?"></textarea>
            <input type='submit' value='Publicar'/>
            </fieldset>
        </form>
       {/usuario}
        <ul class="menu">
            <li>
                <a href="#">
                    <strong>{num_mensajes}</strong>
                    Mensajes
                </a>
            </li>
            <li>
                <a href="#">
                    <strong>{num_siguiendo}</strong>
                    Siguiendo
                </a>
            </li>
            <li>
                <a href="#">
                    <strong>{num_seguidores}</strong>
                    Seguidores
                </a>
            </li>
        </ul>
    </nav>
    <div id="estorbo">
        <hr>
        <h4 align="center">Hashtag</h4>
        <hr>
        {hashtags}
        <a href="Hashtags/{hashtag}"><h3>#{hashtag}</h3></a>
        {/hashtags}
    </div>
    <div id="publicaciones">
        <hr>
        <h4>Mensajes</h4>
        <hr>
        <?php foreach ($mensajes as $m):?>
        <div id="formato">
            <img src="plantilla/images/<?= $m['foto']; ?>" width="60" height="60"></img>
            <div id="tweet">
            <p class="user">
                <a href="Perfil/<?= $m['Usuario']; ?>"><b><?= $m['Nombre']; ?></b> </a>
                <span>@<?= $m['Usuario']; ?></span></p>
            <p class="content"><?php echo mencion($m['contenido'])?></p>
            </div>
        <!--<a href="#">Me Gusta </a> <a href="#"> Comentar </a> <a href="#"> Compartir</a>-->
            <div id="comentarios">
                <hr>
                Comentarios
                <hr>
                <?php 
                    $CI =& get_instance();
                    $CI->load->model('publicaciones_model');
                    $Comentarios = $CI->publicaciones_model->get_comentarios($m['ids']);
                    foreach ($Comentarios as $_Comentarios){
                        ?>
                        <p class="user">
                        <a href="Perfil/<?= $_Comentarios['Usuario']; ?>"><b><?= $_Comentarios['Nombre']; ?></b> </a>
                        <span>@<?= $_Comentarios['Usuario']; ?></span></p>
                        <p class="content"><?php echo mencion($_Comentarios['contenido'])?></p>
                        <?php
                    }
                ?>
                        <form action="frontend/add_comentario/<?= $m['ids']?>/{id}" method="POST">
                            <input type="text" placeholder="Comentar" name="comentario"/>
                            <input type="submit" value="Comentar"/>
                        </form>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <div id="social">
        <hr>
        <h4 align="center">Ultimos Usuarios</h4>
        <hr>
        {ultimos}
        <p class="user">
                <a href="Perfil/{Usuario}"><b>{Nombre}</b> </a>
                <span>@{Usuario}</span>
        </p>
        {/ultimos}
    </div>
    
    </body>
</html>