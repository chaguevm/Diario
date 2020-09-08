<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mini Red Social by Darwin Valero">
    <title>{titulo}</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.1/pure.css">
    <link rel="stylesheet" href="plantilla/test/css/layouts/email.css">
</head>
<body>
<div id="layout" class="content pure-g">
    <div id="nav" class="pure-u">
        <a href="#" class="nav-menu-button">Menu</a>
        <a href="#" class=""><img src="plantilla/images/logo.png" width="133" style="margin-top: 20px"></a>
        <div class="nav-inner">
            <button class="primary-button pure-button publica">Publica</button>
            {usuario}
            <div class="pure-menu pure-menu-open">
                <ul>
                    <li><a href=" ">Principal </a></li>
                    <li><a href="{Usuario}">Perfil </a></li>
                    <li><a href="#">Fotos</a></li>
                    <li><a href="#">Videos</a></li>
                    <li><a href="cerrar">Cerrar Sesion</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="list" class="pure-u-1">
        <div class="email-item pure-g hidden" id="publica">
            <form action='agregar_publicacion/{id}/{id}/1' method="POST" enctype="multipart/form-data" class="pure-form pure-form-aligned">
                <fieldset>
                    <div class="pure-control-group">
                        <textarea name='mensaje' placeholder="¿Que Es lo que Es Menol?" id="contenido" class="pure-input-2-3"></textarea>
                    </div>
                    <div class="pure-control-group">
                        <input type="text" name="video" class="pure-input-1-3" placeholder="Id del Video"/>
                        <input type="file" name="imagen"/>
                    </div>
                    <input type='submit' value='Publicar' id="enviar" class="pure-button pure-button-primary"/>
                </fieldset>
            </form>
        </div>
        {/usuario}
        <?php foreach ($mensajes as $m):  //Inicio del Foreach que recorre toda la data obtenida de mensajes... ?>
            <div class="email-item pure-g">
                <div class="pure-u">
                    <img class="email-avatar" alt="<?= $m['Nombre']; ?> <?= $m['Apellido']; ?> avatar" height="64" width="64" src="plantilla/images/<?= $m['foto']; ?>">
                </div>
                <div class="pure-u-3-4">
                    <a href="<?= $m['Usuario']; ?>"><h5 class="email-name"><?= $m['Nombre']; ?> <?= $m['Apellido']; ?></h5></a>
                    <?php
                    if ($id != $m['donde']) {
                        $usuario = sapo($m['donde']);
                        ?>
                        <h6 class="email-subject"> con <a href="<?= $usuario['Usuario']; ?>"><?= $usuario['Nombre']; ?> <?= $usuario['Apellido']; ?></a></h6>
                        <?php
                    }
                    ?>
                    <p class="email-desc">
                        <?php echo mencion($m['contenido']) ?><br>
                        <?php if ($m['video'] != NULL) { ?>
                            <iframe width="560" height="315" src="//www.youtube.com/embed/<?= $m['video']; ?>" frameborder="0" allowfullscreen></iframe>
                            <?php
                        }
                        ?>
                        <?php if ($m['imagen'] != NULL) { ?>
                            <img src="plantilla/images/<?= $m['Usuario']; ?>/albunes/<?= $m['imagen']; ?>" width="300px" height="300px">
                            <?php
                        }
                        ?>
                    </p>
                </div>
            </div>
        <?php endforeach; //Fin del Foreach?>
    </div>
    </div>    
        <script src="http://yui.yahooapis.com/3.14.1/build/yui/yui.js"></script>
        <script>
            YUI().use('node-base', 'node-event-delegate', function(Y) {

                var menuButton = Y.one('.nav-menu-button'),
                        nav = Y.one('#nav');

                // Setting the active class name expands the menu vertically on small screens.
                menuButton.on('click', function(e) {
                    nav.toggleClass('active');
                });

                // Your application code goes here...

            });
        </script>

        <script>
            YUI().use('node-base', 'node-event-delegate', function(Y) {
                // This just makes sure that the href="#" attached to the <a> elements
                // don't scroll you back up the page.
                Y.one('body').delegate('click', function(e) {
                    e.preventDefault();
                }, 'a[href="#"]');
            });
        </script>
        <script>
            YUI().use('node', function(Y) {
                // This just makes sure that the href="#" attached to the <a> elements
                // don't scroll you back up the page.
                var node = Y.one('#publica'); //Asigna a node, el div con id #Publica que contiene el form de publicacion
                Y.one('.publica').on('click', function(e) {
                    e.preventDefault();
                    node.replaceClass('hidden', 'show'); //Cambio la clase Hidden por Show para mostrar...
                }, 'a[href="#"]');
            });
        </script>
    </body>
</html>
