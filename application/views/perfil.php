<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Diario.com</title>
        <link href="../plantilla/estilos.css"  rel="stylesheet" type="text/css" >
        <script src="../plantilla/js/jquery-1.8.1.min.js"></script>
        <!--<script src="../plantilla/js/funciones.js"></script>  
        <script src="../plantilla/js/charCount.js"></script>-->
    </head>
    <body>
        <header id="header">
            <span>
            <a href="frontend"><h1>Diario</h1></a>
            <ul id="menu-sup">
                <li>
                    <?php 
                    if($id_u == $id_p){
                        ?>
                            <a href="mensajes">{num_mensajes} Mensajes</a>
                        <?php
                    }
                    ?>
                </li>
                <li>
                    <a href="cerrar">Cerrar Sesion</a>
                </li>
            </ul>
            </span>
        </header>
        <div id="pagina">
        <nav>
            {usuario}
            <div id="usuario">
                <img src="../../plantilla/images/{foto}" width="100" height="100">
                <span id="datos">
                <h2><a href="{Usuario}">{Nombre}</a></h2>
                <?php
                $enable = 'habilitado';
                switch ($seguimiento){
                    case 'propio':
                        ?>
                        <a href="">
                        <strong>Editar Perfil</strong>
                        </a>
                        <?php
                        break;
                    case 'no':
                        $enable = 'deshabilitado';
                        ?>
                        <a href="solicitud/{id_u}/{id}">
                        <strong>Enviar Solicitud de Amistad</strong>
                        </a>
                        <?php
                        break;
                    case 'amigos':
                        ?>
                        <a href="dejar/{id_u}/{id}">
                        <strong>Eliminar de Mis Amigos</strong>
                        </a>
                        <?php
                        break;
                    case 'esperando';
                        $enable = 'deshabilitado';
                        ?>
                        <strong>Solicitud Enviada</strong>
                        <?php
                        break;
                }
                ?>
                </span>
            </div>
            <div id="publicacion" class="<?= $enable; ?>">
                <form action='agregar_publicacion/{id_u}/{id_p}/2' method="POST">
                    <fieldset>
                        <textarea name='mensaje' placeholder="Hablame el mio! Que se dice?" id="contenido"></textarea>
                        <label for="video">Id del Video</label>
                        <input type="text" name="video" />
                        <input type="file" name="imagen"/>
                        <input type='submit' value='Publicar' id="enviar"/>
                    </fieldset>
                </form>
            </div>
            
            {/usuario}
    </nav>
    <?php 
    if($id_u == $id_p){
        ?>
            <div id="social">
            <hr>
            <h4 align="center">Solicitudes Recibidas</h4>
            <hr>
            {solicitudes_recibidas}
            <div class="usuario">
                <div class="avatar">
                    <img src="plantilla/images/{foto}" width="60" height="60"></img>
                </div>
                <div id="user">
                    <a href="{Usuario}">{Nombre}</a>  <a href="aceptar/{id}/{id_u}">Aceptar</a>
                </div>
            </div>
            {/solicitudes_recibidas}
            </div>
        <?php
    }
        
    ?>
    <div id="estorbo">
        <hr>
        <h4 align="center">{num_amigos} Amigos</h4>
        <hr>
        {amigos}
        <div class="usuario">
            <div class="avatar">
                <img src="plantilla/images/{foto}" width="60" height="60"></img>
            </div>
            <div id="user">
                <a href="{Usuario}">{Nombre}</a>
            </div>
        </div>
        {/amigos}
    </div>
    <div id="publicaciones">
        <ul class="timeline">
        <?php foreach ($publicaciones_propias as $m):?>
            <li>
                <div id="avatar">
                    <img src="../../plantilla/images/<?= $m['foto']; ?>" width="60" height="60"></img>
                </div>
                <div id="mensaje">
                    <p class="user">
                    <a href="<?= $m['Usuario']; ?>"><b><?= $m['Nombre']; ?> <?= $m['Apellido']; ?></b></a>
                    </p>
                    <p class="content">
                        <?php echo mencion($m['contenido'])?><br>
                        <?php if($m['video'] != NULL) {?>
                            <iframe width="560" height="315" src="//www.youtube.com/embed/<?= $m['video']; ?>" frameborder="0" allowfullscreen></iframe>
                        <?php 
                        }
                        ?>
                        <?php if($m['imagen'] != NULL) {?>
                            <img src="plantilla/images/<?= $m['Usuario']; ?>/albunes/<?= $m['imagen']; ?>" width="300px" height="300px">
                        <?php 
                        }
                        ?>    
                    </p>
                    <a href="megusta/<?= $m['ids'];?>"><?= $m['megusta']?> Likes</a>
                <div id="comentarios">
                        <?php 
                        $CI =& get_instance();
                        $CI->load->model('publicaciones_model');
                        $Comentarios = $CI->publicaciones_model->get_comentarios($m['ids']);
                        ?>
                        <ul class="comentarios">
                        <?php
                        foreach ($Comentarios as $_Comentarios){
                            ?>
                            <li>
                                <div id="avatar">
                                    <img src="../../plantilla/images/<?= $_Comentarios['foto']; ?>" width="60" height="60"></img>
                                </div>
                                <div id="mensaje">
                                    <p class="user">
                                    <a href="<?= $_Comentarios['Usuario']; ?>"><b><?= $_Comentarios['Nombre']; ?></b> </a>
                                    <span>@<?= $_Comentarios['Usuario']; ?></span></p>
                                    <p class="content">
                                        <?php echo mencion($_Comentarios['contenido'])?>
                                        
                                    </p>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                        </ul>
                    <div id="form" class="<?= $enable ?>">
                        <form action="comentar/<?= $m['ids']?>/{id_u}" method="POST">
                            <input type="text" placeholder="Comentar" name="comentario"/>
                            <input type="submit" value="Comentar"/>
                        </form>
                    </div>   
                </div>
                </div>   
            </li>
        <?php endforeach;?>
        </ul>
    </div>
    </div>        
    </body>
</html>