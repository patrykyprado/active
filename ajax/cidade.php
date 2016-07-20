<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );
require_once('../inc/conectar.php');
require_once('../inc/sql.php');
$uf = ( utf8_decode($_REQUEST['uf']) );

$cidade = array();

$sql = func_drop_cidade($uf);

while ( $row = $sql->fetch(PDO::FETCH_ASSOC) ) {
    $cidade[] = array(
        'cidade'			=> utf8_encode(($row['cidade']))
    );
}

echo( json_encode( $cidade ) );