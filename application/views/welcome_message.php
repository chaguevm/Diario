<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bienvenidos a Diarios.com</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background: #E7EBF2;
                background-size: cover;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
                font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
        input{
            outline: none;
        }
        input:required:valid{
            border: 1px solid green;
        }
	#header {
		color: #fff;
		background-color: rgb(59, 89, 152);
		border-bottom: 1px solid #D0D0D0;
		font-weight: normal;
                height: 50px;
	}
        #header img{
            float:left;
            width: 300px;
            height: 50px;
        }
        .inicio-sesion{
            margin-top: 12px;
            float: right;
            width: 700px;
        }
        .input{
            font-family: "Tahoma";
            font-weight: bold;            
            margin: 0 15px 0 15px;
            padding-left: 5px;
            height: 20px;
            width: 200px;
            border: 1px solid #000;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
        }
        .entrar{
            margin: 0;
            font-family: "Tahoma";
            background: rgb(114,131,165); /* Old browsers */
            background: -moz-linear-gradient(top,  rgba(114,131,165,1) 0%, rgba(91,116,168,1) 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(114,131,165,1)), color-stop(100%,rgba(91,116,168,1))); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  rgba(114,131,165,1) 0%,rgba(91,116,168,1) 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  rgba(114,131,165,1) 0%,rgba(91,116,168,1) 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  rgba(114,131,165,1) 0%,rgba(91,116,168,1) 100%); /* IE10+ */
            background: linear-gradient(to bottom,  rgba(114,131,165,1) 0%,rgba(91,116,168,1) 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7283a5', endColorstr='#5b74a8',GradientType=0 ); /* IE6-9 */
            height: 24px;
            color: #fff;
            border: 1px solid #999;
        }
        .borde{
            border-color: #29447e #29447e #1a356e;
        }
	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
            overflow: auto;
            margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
                overflow: auto;
		margin: 100px 10px 10px 10px;
		border: 1px solid #D0D0D0;
                -moz-box-shadow: 0 0 8px #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
                box-shadow: 0 0 8px #D0D0D0;
	}
        #mensaje{
            float:left;
            width: 60%;
        }
        #form_sesion{
            float: left;
            width: 310px;
            height: 400px;
        }
        #form_sesion input,label{
            font-family: "Tahoma";
            font-weight: bold;
        }
        #form-sesiom h1,h3{
            font-weight: normal;
        }
        .input2{
            height: 25px;
            width: 303px;
        }
        .border{
            border: 1px solid rgb(189, 199, 216);;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
        }
        .espacio{
            margin-left: 0;
            margin-bottom: 10px;
            padding-left: 5px;
        }
        .left{
            float: left;
            width: 145px;
            height: 25px;
        }
        .right{
            float: right;
            width: 145px;
            height: 25px;
        }
        .boton{
            /*background: -webkit-linear-gradient(top, #79bc64, #578843);*/
            color: #fff;
            font-family: 'Tahoma';
            font-weight: bold;
            background:  rgba(87,136,67,1);
            width: 200px;
            height: 35px;
            line-height: 10px;
            border: 1px solid #2C5115;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            box-shadow: inset 0px 1px 1px 0px rgba(121,188,100,1);
        }
        .boton:hover{
            background: rgb(121,188,100); /* Old browsers */
            background: -moz-linear-gradient(top,  rgba(121,188,100,1) 0%, rgba(87,136,67,1) 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(121,188,100,1)), color-stop(100%,rgba(87,136,67,1))); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  rgba(121,188,100,1) 0%,rgba(87,136,67,1) 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  rgba(121,188,100,1) 0%,rgba(87,136,67,1) 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  rgba(121,188,100,1) 0%,rgba(87,136,67,1) 100%); /* IE10+ */
            background: linear-gradient(to bottom,  rgba(121,188,100,1) 0%,rgba(87,136,67,1) 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#79bc64', endColorstr='#578843',GradientType=0 ); /* IE6-9 */
        }
	</style>
</head>
<body>

<div id="container">
	<header id="header">
            <img src="plantilla/images/logo.png">
            <form action="iniciar" method="POST" class="inicio-sesion">
                  <label for="Usuario">Usuario</label>
                  <input type="text" name="Usuario" value="<?= @set_value('Usuario');?>" placeholder="Nombre de Usuario" class="input" required/>
                  <label for="Clave">Contraseña</label>
                  <input type="password" name="Clave" placeholder="Contraseña" class="input" required/>
                  <input type="submit" value="Entrar" class="entrar borde"/>         
            </form>
             <?= form_error('Usuario');?>
             <?= form_error('Clave');?>
        </header>
        
	<div id="body">
            <div id="mensaje">
		<p>El Portal web en donde podras dejar tus vivencias diarias</p>

		<p>Diario.com intentara ser tu diario personal, o compartido...</p>
		
		<p>Cuando estes listo para Empezar, Registrate o Inicia Sesion</p>
            </div>
            <div id="form_sesion">
                <form action="registrar" method="POST">
                    <h1>Regístrate</h1>
                    <h3>Es Gratis</h3>
                    <input type="text" name="Usuario2" value='<?= @set_value('Usuario2');?>' placeholder="Nombre de Usuario" class="input2 border espacio" required maxlength="6" title="Hace falta un Nombre de Usuario"/>
                        <input type="text" name="Nombre2" value='<?= @set_value('Nombre2');?>'placeholder="Nombre" class="left border espacio" required/>
                        <input type="text" name="Apellido" value='<?= @set_value('Apellido');?>'placeholder="Apellido" class="right border espacio" required/>
                        <input type="email" name="Correo2" value='<?= @set_value('Correo2');?>'placeholder="Correo Electronico" class="input2 border espacio" required/>
                        <input type="password" name="Clave2" placeholder="Contraseña" class="input2 border espacio" required/>
                        <input type="password" name="ConfClave" placeholder="Repite Contraseña" class="input2 border espacio" required/>
                        <input type="text" name="fecha-nacimiento" placeholder="Fecha de Nacimiento" class="input2 border espacio" />
                        <input type="radio" value="M" name="Sexo" class="espacio" /><label for="Sexo"> Hombre </label> 
                        <input type="radio" value="F" name="Sexo" class="espacio" /><label for="Sexo"> Mujer</label> 
                        <input type="submit" value="Regístrate" class="boton"/>
                </form>
                <?= form_error('Usuario2');?>
                <?= form_error('Nombre2');?>
                <?= form_error('Correo2');?>
                <?= form_error('Clave2');?>
             </div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>