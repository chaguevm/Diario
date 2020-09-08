<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$contador = count($mensajes);
echo $mensajes[$contador-1]['mensaje'];
?>
<ul>
    {mensajes}
    <li>
        {Nombre} {Usuario}
        {mensaje}
    </li>
    {/mensajes}
</ul>

Responder<br>
<form action="../../enviar_mensaje/{id_logueado}/{id_destino}" method="POST">
    <textarea name="mensaje"></textarea>
    <input type="submit" value="Enviar"/>
</form>