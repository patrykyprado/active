<?php
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );
require_once('../inc/conectar.php');
$con = mysql_connect( $servidor_mysql, $usuario, $senha ) ;
mysql_select_db( $nome_banco, $con );

$uf = mysql_real_escape_string( $_REQUEST['uf'] );
$cidade = array();

$sql = "SELECT * FROM cidades WHERE uf LIKE '$uf%' ORDER BY cidade";
$res = mysql_query( $sql );
while ( $row = mysql_fetch_array( $res ) ) {
    $cidade[] = array(
        'cidade'			=> $row['cidade']

    );
}

echo( json_encode( $cidade ) );


?>