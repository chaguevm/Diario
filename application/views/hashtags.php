<!DOCTYPE HTML>
<html>
    <head>
        <title>Diario.com</title>
        <link href="../../plantilla/estilos.css"  rel="stylesheet" type="text/css" >
    </head>
    <body>   
    </nav>
    <div id="estorbo">
        <hr>
        <h4 align="center">Hashtag</h4>
        <hr>
        {hashtags}
        <a href="{hashtag}"><h3>#{hashtag}</h3></a>
        {/hashtags}
    </div>
    <div id="publicaciones">
        <hr>
        <h4>Mensajes</h4>
        <hr>
        <?php foreach ($mensajes as $m):?>
        <div id="formato">
            <p class="user">
                <a href="<?= $m['Usuario']; ?>"><b><?= $m['Nombre']; ?></b> </a>
                <span>@<?= $m['Usuario']; ?></span></p>
        <p class="content"><?= mencion($m['contenido']);?></p>
        </div>
        <?php endforeach;?>
    </div>
    <div id="social">

    </div>
    </body>
</html>