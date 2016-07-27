<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$cc3 = ( utf8_decode($_REQUEST['cc3']) );

$cc4 = array();

$sql = func_drop_cc4($cc3);

while ( $row = $sql->fetch(PDO::FETCH_ASSOC) ) {
    $cc4[] = array(
        'cc4_id'			=> utf8_encode(($row['id'])),
        'cc4_nome'			=> utf8_encode(($row['nome_cc4']))
    );
}

echo( json_encode( $cc4 ) );