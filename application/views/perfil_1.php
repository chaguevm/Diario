<!DOCTYPE HTML>
<html>
    <head>
        <title>Diario.com</title>
        <link href="../../plantilla/estilos.css"  rel="stylesheet" type="text/css" >
    </head>
    <body>
        <nav>
        {usuario}    
        <div id="usuario">
        <img src="../../plantilla/images/{foto}" width="100" height="100"></img>
        <span id="datos">
        <h2>{Nombre}</h2> 
        <h4>@{Usuario}</h4>
        </span>
        </div>
        <a href="../frontend/cerrar">Cerrar Sesion</a> <a href="../frontend">Inicio</a>
        <form action='../frontend/add_publicacion/{id_u}/perfil' method="POST" id="publicacion">
            <fieldset>
            <textarea name='mensaje' placeholder="¿Que hay de Nuevo?"></textarea>
            <input type='submit' value='Publicar'/>
            </fieldset>
        </form>   
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
            <li>
                <?php 
                switch ($seguimiento){
                    case 'propio':
                        ?>
                        <a href="">
                        <strong>Editar Perfil</strong>
                        </a>
                        <?php
                        break;
                    case 'no':
                        ?>
                        <a href="../frontend/seguir/{id_u}/{id}">
                        <strong>Seguir</strong>
                        </a>
                        <?php
                        break;
                    case 'si':
                        ?>
                        <a href="../frontend/dejar_seguir/{id_u}/{id}">
                        <strong>Dejar de Seguir</strong>
                        </a>
                        <?php
                        break;
                }
                ?>
            </li>
        </ul>
    {/usuario}     
    </nav>
    <div id="estorbo"></div>
    <div id="publicaciones">
        <hr>
        <h4>Mensajes</h4>
        <hr>
        <?php foreach ($mensajes as $m):?>
        <div id="formato">
            <p class="user">
                <a href="<?= $m['Usuario']; ?>"><b><?= $m['Nombre']; ?></b> </a>
                <span>@<?= $m['Usuario']; ?></span></p>
        <p class="content"><?= mencion_perfil($m['contenido']);?></p>
        </div>
        <?php endforeach;?>
    </div>
    <div id="social">
        <hr>
        <h4 align="center">Siguiendo</h4>
        <hr>
        {siguiendo}
            <p class="user">
                <a href="{Usuario}"><b>{Nombre}</b> </a>
                <span>@{Usuario}</span>
            </p>
        {/siguiendo}
        <hr>
        <h4 align="center">Seguidores</h4>
        <hr>
        {seguidores}
            <p class="user">
                <a href="{Usuario}"><b>{Nombre}</b> </a>
                <span>@{Usuario}</span>
            </p>
        {/seguidores}
    </div>
    </body>
</html>