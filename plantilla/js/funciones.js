/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*$(function(){

                var valor, contador, parrafo;

                $('<p class="indicador"><span>140</span> caracteres</p>').appendTo('#contador');	

                $('#contenido').keydown(function(){

                        contador = 140;
                        $('.advertencia').remove();
                        $('.indicador').remove();

                        valor = $('#contenido').val().length;
                        contador = contador - valor;

                        if(contador < 0) {
                                parrafo = '<p class="advertencia">';
                                $("#enviar").attr("disabled","disabled");
                        }
                        else {
                                parrafo = '<p class="indicador">';
                                $("#enviar").removeAttr("disabled");
                        }

                        $('#contador').append(parrafo + contador + ' caracteres</p>');

                });
        });*/
$(document).ready(function(){	
$("#contenido").charCount();
});        
       