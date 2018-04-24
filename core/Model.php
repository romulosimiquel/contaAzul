<?php
/**
 * model <b>This class is the main of all system</b>
 * @autor Ricardo de Oliveira - ricardo.reksystem@gmail.com - 2018
 */

class model 
{
    /** @var PDO  */
    protected $pdo;

    public function __construct() 
    {
        global $config;
        $this->pdo = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
    }
}
?>