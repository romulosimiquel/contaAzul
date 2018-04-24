<?php
class Core {

    public function run() 
    {
        //Bellow, i verify which method use for get the controller and the action 
        
        if(ENVIRONMENT == 'development')
        {
            //echo 'development offline';
            
            //Below, i get a url true, independent of the file htaccess
            $urlReal = $_SERVER['PHP_SELF'];
            
            //Here, creates a array separate by "index.php"
            $url = explode("index.php", $urlReal);
        }
        else
        {
            //echo 'development online';
            
            //Bellow, i get a URL of the way it is in browser
            $urlReal = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        
            //Here, i create a array separate by domain more the RAIZ
            $url = explode($_SERVER['HTTP_HOST'].RAIZ, $urlReal); 
        }
        
        $url = end($url); //Returns the value of the last element in an array
        
        //Array that get parameters
        $params = array();
        
        //If URL is empty or is different of '/'
        if(!empty($url) && $url != '/') 
        {
            $url = explode('/', $url);
            
            //Remove the first element from an array, for remove the "/" initial
            array_shift($url); 

            //I get the "Controller"    
            $currentController = $url[0].'Controller';
            
            array_shift($url); //for remove the "controller"

            if(isset($url[0]) && !empty($url[0])) 
            {
                //I get the "Action" 
                $currentAction = $url[0];
                
                array_shift($url);//for remove the "Action"
            } 
            else 
            {
                //Value pattern
                $currentAction = 'index';
            }

            if(count($url) > 0) 
            {
                //Getting parameters
                $params = $url;
            }
        } 
        else //Value pattern
        {
            $currentController = 'homeController';
            $currentAction = 'index';
        }
        
        //If the Controller not exist in directory 'controllers' or the method (Action) not exist in class Controller
        if(!file_exists('controllers/'.$currentController.'.php') || !method_exists($currentController, $currentAction))
        {
            //ERRO 404
            $currentController = 'erroController';
            $currentAction     = 'index';
            $params = ['' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']];
        }

        //Creating object with the Controller that i received
        $c = new $currentController();
        
        //to see in  http://rghitech.com/
        call_user_func_array(array($c, $currentAction), $params);
    }
}