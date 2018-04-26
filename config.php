<?php
/**
 * @autor Ricardo de Oliveira - ricardo.reksystem@gmail.com - 2018
 */

require 'environment.php';

//constants
define("RAIZ", "contaazul/");

define("BASE", "http://localhost/contaazul/");

//connexao
global $config;
$config = array();
if(ENVIRONMENT == 'development') 
{
    $config['dbname'] = 'contaazul';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';
} 
else 
{
    $config['dbname'] = 'contaazul';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = 'root';
}
?>