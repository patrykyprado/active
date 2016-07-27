<?php

/**
 *
 */
const hostSistema = 'http://activelifestudio.com.br/active/';

/**
 * @param $str
 * @return mixed
 */
function limpar_string($str) {
    $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);
    return $str;
}

/**
 * @return string
 */
function hostUsuario(){
    return 'http://'.$_SERVER['HTTP_HOST'];
}

/**
 * @return string
 */
function nomeMenuQuebra($texto){
    $maxLinha = 14;
    $qtdQuebras = strlen($texto)/$maxLinha;
    $novoTexto = substr($texto,0,$maxLinha);
    if($maxLinha >= 1){
        $novoTexto .= "<br>".substr($texto,14,20);
    }
    return $novoTexto;
}
/**
 * @param $al
 * @return string
 */
function format_data($al)
{
    $exib = '';
    if(!empty($al)) {
        $exib = substr($al, 8, 2) . "/" . substr($al, 5, 2) . "/" . substr($al, 0, 4);
    }
    return $exib;
}


/**
 * @param $data
 * @return string
 */
function format_data_us($data)
{
    $exib = '';
    if(!empty($data)) {
        $exib = substr($data, 6, 4) . "-" . substr($data, 3, 2) . "-" . substr($data, 0, 2);
    }
    return $exib;
}

/**
 * @param $al
 * @return string
 */
function format_data_hora($al)
{
    $exib = substr($al,8,2)."/".substr($al,5,2)."/".substr($al,0,4)." ".substr($al,11,10);
    return $exib;
}

/**
 *
 */
function ShadowClose() {
    window.parent.Shadowbox.close();
    window.location.reload();
}

/**
 * @param $cel
 * @return mixed|string
 */
function formatar_sms($cel)
{
    $cel_filtrado = preg_replace("/[^0-9]/", "", $cel);
    if(strlen($cel_filtrado) <= 11&&strlen($cel_filtrado>0)){
        if(substr($cel_filtrado,0,1)==3){
            $cel_filtrado = "Número Inválido";
            return $cel_filtrado;
        }
        if(substr($cel_filtrado,0,2)==273){
            $cel_filtrado = "Número Inválido";
            return $cel_filtrado;
        }
        if(substr($cel_filtrado,0,1)==9){
            $cel_filtrado = "5527".$cel_filtrado;
            return $cel_filtrado;
        }

        $cel_filtrado = "55".$cel_filtrado;
    } else {
        $cel_filtrado = "Número Inválido";
    }
    return $cel_filtrado;
}

/**
 * @param $al
 * @return mixed
 */
function not($al)
{
    $exib = $al;
    return utf8_encode($exib);
}

/**
 * @param $al
 * @return string
 */
function format_email($al)
{
    $exib = strtolower($al);
    return $exib;
}

/**
 * @param $al
 * @return string
 */
function format_valor($al)
{
    $exib = number_format($al,2,",",".");
    return $exib;
}

/**
 * @param $valor
 * @return mixed
 */
function format_valor_db($valor)
{
    $exib = str_replace(',','.',$valor);
    return $exib;
}

/**
 * @param $al
 * @return string
 */
function format_valor_tela($al)
{
    $exib = number_format($al,2,",","");
    return $exib;
}

/**
 * @param $al
 * @return string
 */
function format_curso($al)
{
    $exib = ucwords(strtolower($al));
    return utf8_encode($exib);
}

/**
 * @param $texto
 * @return string
 */
function format_nome($texto){
    $palavras = explode(" ", $texto);
    $qtd_palavras = count($palavras);
    $nome_final = "";
    for($i = 0; $i < $qtd_palavras; $i++){
        $nome_final .= ucwords($palavras[$i]).' ';
    }
    return utf8_encode(trim($nome_final));


}

/**
 * @param $data_mes
 * @return string
 */
function format_mes($data_mes)
{
    if($data_mes == '01'){
        $data_mes_nome = "Janeiro";
    }
    if($data_mes == '02'){
        $data_mes_nome = "Fevereiro";
    }
    if($data_mes == '03'){
        $data_mes_nome = "Março";
    }
    if($data_mes == '04'){
        $data_mes_nome = "Abril";
    }
    if($data_mes == '05'){
        $data_mes_nome = "Maio";
    }
    if($data_mes == '06'){
        $data_mes_nome = "Junho";
    }
    if($data_mes == '07'){
        $data_mes_nome = "Julho";
    }
    if($data_mes == '08'){
        $data_mes_nome = "Agosto";
    }
    if($data_mes == '09'){
        $data_mes_nome = "Setembro";
    }
    if($data_mes == '10'){
        $data_mes_nome = "Outubro";
    }
    if($data_mes == '11'){
        $data_mes_nome = "Novembro";
    }
    if($data_mes == '12'){
        $data_mes_nome = "Dezembro";
    }
    return $data_mes_nome;
}

/**
 * @param $data
 * @return string
 */
function format_data_escrita($data){
    $ano = substr($data,0,4);
    $mes = substr($data,5,2);
    $dia = substr($data,8,2);

    $mes_escrito = format_mes($mes);

    return $dia." de ".$mes_escrito." de ".$ano;
}

/**
 * @param $data
 * @return string
 */
function format_data_escrita_BR($data){
    $ano = substr($data,6,4);
    $mes = substr($data,3,2);
    $dia = substr($data,0,2);

    $mes_escrito = format_mes($mes);

    return $dia." de ".$mes_escrito." de ".$ano;
}


/**
 * @param $string
 * @return mixed
 */
function remover_acentos($string) {
    return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($string));

}

/**
 * @param $data
 * @return bool|string
 */
function dia_semana($data){
    return date("N", strtotime($data));
}

/**
 * @param $msg
 * @param int $reload
 * @param null $close
 * @param null $extra
 * @return string
 */
function alert($msg, $reload = 1, $close = null, $extra = null){
    $alerta = "<script language='javascript'>
alert('".$msg."');";
    if($reload == 1){
        $alerta .= "window.reload();";
    }
    if(!empty($extra)){
        $alerta .= $extra;
    }
    if($close == 1){
        $alerta .= "window.close();";
    }
    $alerta .= "
</script>";
    return $alerta;
}

/**
 * @param $inp
 * @return array|mixed
 */
function limpar_para_banco($inp)
{
    if (is_array($inp))
        return array_map(__METHOD__, $inp);

    if (!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

/**
 * @param $string
 * @return float
 */
function arredondamento($string){
    $string = floatval($string);
    $string = number_format($string,2,'.','');
    if(strpos($string,".")== FALSE){
        return $string;
    } else {
        $exp_string = explode(".",$string);
        $n1 = $exp_string[0];
        $n2 = $exp_string[1];
        if($n2 <= 50){
            $n2_soma = 0.5;
        }
        if($n2 > 50){
            $n2_soma = 1;
        }
        $nota = $n1 + $n2_soma;
        return $nota;
    }

}

/**
 * @param $letra
 * @return string
 */
function format_letra($letra)
{
    if($letra == '1'){
        $letra_exib = "A)";
    }
    if($letra == '2'){
        $letra_exib = "B)";
    }
    if($letra == '3'){
        $letra_exib = "C)";
    }
    if($letra == '4'){
        $letra_exib = "D)";
    }
    if($letra == '5'){
        $letra_exib = "E)";
    }
    if($letra == '6'){
        $letra_exib = "F)";
    }
    if($letra == '7'){
        $letra_exib = "G)";
    }
    if($letra == '8'){
        $letra_exib = "H)";
    }
    if($letra == '9'){
        $letra_exib = "I)";
    }
    return $letra_exib;
}

/**
 * @param $consulta
 * @param int $tempo
 * @return array|resource|string
 */
function memedCache($consulta, $tempo = 7200) {
    $chave = md5($consulta);

    $mem = new Memcache;
    $mem->addServer($_SERVER['HTTP_HOST']);

    $query = $mem->get($chave);
    if ($query === false) {
        $query = mysql_query($consulta);
        $mem->set($chave, $query, 0, $tempo);
    }

    return $query;
}

/**
 * @param $dadosTurma
 * @param $extensao
 * @return string
 */
function gerarNomeDocumentoTurma($dadosTurma,$extensao){
    $curso_exp = explode(' ', $dadosTurma['nivel']);
    $pt1 = substr($curso_exp[0],0,1).substr($curso_exp[1],0,1);
    $pt2 = strtoupper(substr($dadosTurma['curso'],0,3)).$dadosTurma['modulo'];
    $pt3 = '('.$dadosTurma['turno'].str_replace('/', '',$dadosTurma['grupo']).')';

    return $pt1.'-'.$pt2.' '.$pt3.' '.date('dmY His').'.'.$extensao;
}

/**
 * @param $tempoInicio
 * @param $tempoFim
 * @return string
 */
function calcularTempoExecucao($tempoInicio, $tempoFim){
    $tempoInicio = DateTime::createFromFormat('H:i:s', $tempoInicio);
    $tempoFim = DateTime::createFromFormat('H:i:s', $tempoFim);
    return  $tempoInicio->diff($tempoFim)->format('%H:%I:%S');
}

/**
 * @param $str
 * @return mixed
 */
function removePontuacao($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', ' ', $str);
    $str = preg_replace('/_+/', '', $str); // ideia do Bacco :)
    return $str;
}

/**
 * @param $str
 * @return mixed
 */
function removerLtda($str) {
    #remove LTDA
    $str = preg_replace('/LTDA/', '', $str);
    return $str;
}

/**
 * @param $texto1
 * @param $texto2
 * @return array
 */
function verificarPlagio($texto1,$texto2){


    $texto_1 = explode(' ', removePontuacao(strip_tags($texto1)));
    $texto_2 = explode(' ', removePontuacao(strip_tags($texto2)));

    $total_palavras1 = count($texto_1);
    $total_palavras2 = count($texto_2);

    $total_coincidente = 0;
    foreach($texto_2 as $palavra){
        if(in_array($palavra, $texto_1)){
            $total_coincidente += 1;
        }
    }

    $porcentagem = (100*$total_coincidente)/$total_palavras1;

    if($total_palavras2 > $total_palavras1){
        $porcentagem -= 60;
    }
    /*
    if($total_palavras1 < $total_palavras2){
        $porcentagem -= 100;
    }*/

    $retorno = array(
        'total_palavras_1' => $total_palavras1,
        'total_palavras_2' => $total_palavras2,
        'coincidentes' => $total_coincidente,
        'porcentagem_coincidencia' => $porcentagem,

    );

    return $retorno;
}



/**
 * Class clsTexto
 */
class clsTexto
{

    /**
     * @param int $valor
     * @param bool|true $bolExibirMoeda
     * @param bool|false $bolPalavraFeminina
     * @return string
     */
    public static function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {

        $singular = null;
        $plural = null;

        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");


        if ( $bolPalavraFeminina )
        {

            if ($valor == 1)
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }


            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");


        }


        $z = 0;

        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );

        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ )
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;

            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];

            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        $rt = mb_substr( $rt, 1 );

        return($rt ? trim( $rt ) : "zero");

    }
}


/**
 * @return bool
 */
function validarMobile(){
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
    $validar_mobile = false;
    if($iphone == true) {
        $validar_mobile = true;
    }
    if($ipad == true) {
        $validar_mobile = true;
    }
    if($android == true) {
        $validar_mobile = true;
    }
    if($palmpre == true) {
        $validar_mobile = true;
    }
    if($berry == true) {
        $validar_mobile = true;
    }
    if($ipod == true) {
        $validar_mobile = true;
    }
    if($symbian == true) {
        $validar_mobile = true;
    }
    return $validar_mobile;
}

/**
 * @return DateTime
 */
function proxima_quarta(){
    $novaData = date('Y-m-d');
    $proximaData = new DateTime($novaData);
    $dias = 7;
    $proximaData->add( new DateInterval('P'.$dias.'D'));
    $diaSemana = dia_semana($proximaData->format('Y-m-d'));
    switch ($diaSemana){
        case 1:
            $proximaData = new DateTime($novaData);
            $diasAdd = 9;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
        case 2:
            $proximaData = new DateTime($novaData);
            $diasAdd = 8;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
        case 3:
            $proximaData = new DateTime($novaData);
            $diasAdd = 7;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
        case 4:
            $proximaData = new DateTime($novaData);
            $diasAdd = 13;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
        case 5:
            $proximaData = new DateTime($novaData);
            $diasAdd = 12;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
        case 6:
            $proximaData = new DateTime($novaData);
            $diasAdd = 11;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
        case 7:
            $proximaData = new DateTime($novaData);
            $diasAdd = 10;
            $proximaData->add( new DateInterval('P'.$diasAdd.'D'));
            return $proximaData;
            break;
    }
}

/**
 * @param $comentario
 * @return int
 */
function validarComentario($comentario){
    $procurar = 'xml';
    $procurarem = $comentario;

    $explodeProcurar = explode('<', $procurarem);
    $precisaTratar = 0;
    foreach($explodeProcurar as $tratar){
        //echo substr(trim($tratar),0,-1).'<br>';
        if ($procurar == substr(trim($tratar),0,-1)) {
            $precisaTratar +=1;
        }
    }
    return $precisaTratar;
}

/**
 * @param $layout
 * @param $idTitulo
 * @param $parcela
 * @param $clienteFornecedor
 * @return string
 */
function linkBoleto($layout, $idTitulo, $parcela, $clienteFornecedor){
    return 'externos/boleto/'.$layout.'?id='.$idTitulo.'&p='.$parcela.'&id2='.$clienteFornecedor;
}

/**
 * @return array
 */
function drop_banco_retorno(){
    $bancoRetorno = array();
    $bancoRetorno[] = array('id' => 1, 'arquivo' => 'ler_bradesco.php',  'nome' => '237 - Bradesco');

    return $bancoRetorno;
}

/**
 * @param $html
 * @return mixed
 */
function limpar_mso($html){
    return preg_replace('(mso-[a-z0-9\s\-:;]+)i', '', $html);
}

function corHtml(){
    $letters = '0123456789ABCDEF';
    $color = '#';
    for($i = 0; $i < 6; $i++) {
        $index = rand(0,15);
        $color .= $letters[$index];
    }
    return $color;
}


function formatCpf($cpfInt){
    return substr($cpfInt, 0,3).'.'.substr($cpfInt, 3,3).'.'.substr($cpfInt, 6,3).'-'.substr($cpfInt, 9,2);
}


function minutosHora($mins) {
    // Se os minutos estiverem negativos
    if ($mins < 0)
        $min = abs($mins);
    else
        $min = $mins;

    // Arredonda a hora
    $h = floor($min / 60);
    $m = ($min - ($h * 60)) / 100;
    $horas = $h + $m;

    // Matemática da quinta série
    // Detalhe: Aqui também pode se usar o abs()
    if ($mins < 0)
        $horas *= -1;

    // Separa a hora dos minutos
    $sep = explode('.', $horas);
    $h = $sep[0];
    if (empty($sep[1]))
        $sep[1] = 00;

    $m = $sep[1];

    // Aqui um pequeno artifício pra colocar um zero no final
    if (strlen($m) < 2)
        $m = $m . 0;

    return sprintf('%02d:%02d', $h, $m);
}

function calcula_frete($servico,$CEPorigem,$CEPdestino,$peso,$altura='4',$largura='12',$comprimento='16',$valor='1.00'){
    ////////////////////////////////////////////////
    // Código dos Serviços dos Correios
    // 41106 PAC
    // 40010 SEDEX
    // 40045 SEDEX a Cobrar
    // 40215 SEDEX 10
    ////////////////////////////////////////////////
    // URL do WebService
    $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$CEPorigem."&sCepDestino=".$CEPdestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor."&sCdAvisoRecebimento=n&nCdServico=".$servico."&nVlDiametro=0&StrRetorno=xml";
    // Carrega o XML de Retorno
    $xml = simplexml_load_file($correios);
    // Verifica se não há erros
    if($xml->cServico->Erro == '0'){
        return str_replace(',','.', $xml->cServico->Valor);
    }else{
        return false;
    }
}

function selected( $value, $selected ){
    return $value==$selected ? ' selected="selected"' : '';
}

function download( $path, $fileName = '' ){

    if( $fileName == '' ){
        $fileName = basename( $path );
    }

    header("Content-Type: application/force-download");
    header("Content-type: application/octet-stream;");
    header("Content-Length: " . filesize( $path ) );
    header("Content-disposition: attachment; filename=" . $fileName );
    header("Pragma: no-cache");
    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    readfile( $path );
    flush();
}

function requerido(){
    return '<b><font color="red">*</font></b>';
}

function requestCompleto(){
    $expRequest = explode('?',$_SERVER['REQUEST_URI']);
    return $expRequest[1];
}
?>