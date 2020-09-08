<!DOCTYPE HTML>
<html lang="es">
    <head>
        <title>{titulo}</title>
        <meta charset="utf-8">
        <link href="plantilla/estilos.css"  rel="stylesheet" type="text/css">
        <script src="plantilla/js/jquery-1.8.1.min.js"></script>
        <!--<script src="plantilla/js/funciones.js"></script>  
        <script src="plantilla/js/charCount.js"></script> -->
    </head>
    <body>
        <header id="header">
            <span>
            <a href=""><h1>Diario</h1></a>
            <ul id="menu-sup">
                <li>
                   <a href="mensajes">{num_mensajes} Mensajes</a>
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
                <img src="plantilla/images/{foto}" width="100" height="100"></img>
                <span id="datos">
                <h2>{Nombre}</h2>
                <h4><a href="{Usuario}">Perfil</a></h4>
                </span>
            </div>
            <div id="publicacion">
                <form action='agregar_publicacion/{id}/{id}/1' method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <textarea name='mensaje' placeholder="¿Que Es lo que Es Menol?" id="contenido"></textarea>
                        <label for="video">Id del Video</label>
                        <input type="text" name="video" />
                        <input type="file" name="imagen"/>
                        <input type='submit' value='Publicar' id="enviar"/>
                    </fieldset>
                </form>
            </div>
            
            {/usuario}
        </nav>
        <div id="social" class="visible">
        <hr>
        <h4 align="center">Ultimos Usuarios</h4>
        <hr>
        {ultimos}
        <div class="usuario">
            <div class="avatar">
                <img src="plantilla/images/{foto}" width="60" height="60"></img>
            </div>
            <div id="user">
                <a href="{Usuario}">{Nombre}</a>
            </div>
        </div>
        {/ultimos}
        </div>
    <div id="estorbo">
        {hashtags}
        <a href="Hashtags/{hashtag}"><h3>#{hashtag}</h3></a>
        {/hashtags}
    </div>
    <div id="publicaciones">
        <ul class="timeline">
        <?php foreach ($mensajes as $m):?>
            <li>
                <div id="avatar">
                    <img src="plantilla/images/<?= $m['foto']; ?>" width="60" height="60"></img>
                </div>
                <div id="mensaje">
                    <p class="user">
                    <a href="<?= $m['Usuario']; ?>"><b><?= $m['Nombre']; ?> <?= $m['Apellido']; ?></b></a>
                        <?php 
                        if($id != $m['donde']){
                            $usuario = sapo($m['donde']);
                            ?>
                            Publicó en el Muro de <a href="<?= $usuario['Usuario']; ?>"><b><?= $usuario['Nombre']; ?> <?= $usuario['Apellido']; ?></b></a>
                            <?php
                        }
                        ?>
                    </p>
                    <p class="content">
                        <?php echo mencion($m['contenido'])?><br>
                        <?php if($m['video'] != NULL) {?>
                            <iframe width="560" height="315" src="//www.youtube.com/embed/<?= $m['video']; ?>" frameborder="0" allowfullscreen></iframe>
                        <?php 
                        }
                        ?>
                        <?php if($m['imagen'] != NULL) {?>
                            <img src="plantilla/images/<?= $m['imagen']?>" width="300px" height="300px">
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
                                    <img src="plantilla/images/<?= $_Comentarios['foto']; ?>" width="60" height="60"></img>
                                </div>
                                <div id="mensaje">
                                    <p class="user">
                                    <a href="<?= $_Comentarios['Usuario']; ?>"><b><?= $_Comentarios['Nombre']; ?></b> </a>
                                    </p>
                                    <p class="content"><?php echo mencion($_Comentarios['contenido'])?></p>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                        </ul>
                    <div id="form">
                        <form action="comentar/<?= $m['ids']?>/{id}" method="POST">
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