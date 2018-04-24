<?php
class controller 
{
    //To call a "view" in the dry
    public function loadView($viewName, $viewData = array()) 
    {
        extract($viewData);
        include 'views/'.$viewName.'.php';
    }

    //To call a "template" and pass parameters
    public function loadTemplate($viewName, $viewData = array()) 
    {
        include 'views/template.php';
    }

    //Used inside of a "template"
    public function loadViewInTemplate($viewName, $viewData) 
    {
        extract($viewData);
        include_once 'views/'.$viewName.'.php';
    }
}