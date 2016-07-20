$(function(){
    $('body').delegate('#excluir_cliente', 'Onclick', function(e){
        var botao = $(this);
        var tipo = botao.attr('tipo');
        var cod_cliente = $(this).attr('cod_cliente');

        if(cod_cliente != 0){
            if(tipo == 'ler'){
                $.post('../acesso/sys/funcoes.php',{
                acao: 'ler',
                cod_cliente: cod_cliente

            }, function(retorno){
               $('.modal-excluir-cliente').append(retorno);
                });

            }
        }
        /**
 * Created by Patryky on 01/02/15.
 */
    });
});
