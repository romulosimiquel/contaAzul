<?php
/**
 * erro <b>Class responsive for show erros for user</b>
 *
 * @autor Ricardo de Oliveira - ricardo.reksystem@gmail.com - 2018
 */

class erroController extends controller
{
    public function index($paginaIne = '') 
    {
        $dados = array('paginaIne' => $paginaIne);  

        $this->loadTemplate('error', $dados);
    }
}
