<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 12/01/15
 * Time: 16:23
 */

//dados
$servidor_mysql = 'activelifestudio.com.br';
$nome_banco = 'activ345_sistema';
$usuario = 'activ345_sistema';
$senha = 'active@GIT';
global $conn;
//conectar o bd
$conn = new PDO("mysql:host=$servidor_mysql;dbname=$nome_banco","$usuario","$senha");

?>