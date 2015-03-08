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

    function f_moeda(el){
        return document.getElementsByClassName(el);
    }
    String.prototype.formatMoney = function(){
        var v = this.replace(/(\d{1,3})$/g,"$1,00");
        v = v.replace(/(\d{1,3})(\d{3},00)$/,"$1.$2");
        return v;
    };
    window.onload = function(){
        f_moeda('f_moeda').onblur = function(){
            var v = this.value;
            if( v.indexOf(',')===0 ){
                v = v.replace(',','');
                if(v.length===1) v = '0,' + v + '0';
                else v = '0,' + v;
            } else {
                v = v.formatMoney();
            }
            this.value = v;
        }
    };
});




