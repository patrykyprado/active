<?php

header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', '55B5184AC3CE4996B870F6F0150E13D4');

class PagSeguroNpi {

    private $timeout = 20; // Timeout em segundos

    public function notificationPost() {
        $postdata = 'Comando=validar&Token='.TOKEN;
        foreach ($_POST as $key => $value) {
            $valued    = $this->clearStr($value);
            $postdata .= "&$key=$valued";
        }
        return $this->verify($postdata);
    }

    private function clearStr($str) {
        if (!get_magic_quotes_gpc()) {
            $str = addslashes($str);
        }
        return $str;
    }

    private function verify($data) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = trim(curl_exec($curl));
        curl_close($curl);
        return $result;
    }

}

if (count($_POST) > 0) {

    // POST recebido, indica que é a requisição do NPI.
    $npi = new PagSeguroNpi();
    $result = $npi->notificationPost();

    $transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';

    if ($result == "VERIFICADO") {
        //O post foi validado pelo PagSeguro.
    } else if ($result == "FALSO") {
        //O post não foi validado pelo PagSeguro.
    } else {
        //Erro na integração com o PagSeguro.
    }

} else {
    // POST não recebido, indica que a requisição é o retorno do Checkout PagSeguro.
    // No término do checkout o usuário é redirecionado para este bloco.
    ?>
    <h3>Obrigado por efetuar a compra.</h3>
    <?php
}

?>