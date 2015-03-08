<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 12/01/15
 * Time: 16:23
 */

//dados
$servidor_mysql = 'dbmy0058.whservidor.com';
$nome_banco = 'ceteps1_2';
$usuario = 'ceteps1_2';
$senha = 'gestao@2015';
global $conn;
//conectar o bd
$conn = new PDO("mysql:host=$servidor_mysql;dbname=$nome_banco","$usuario","$senha");

?>