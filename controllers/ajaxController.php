<?php
class ajaxController extends controller {

	/** 
	* home class construct, verify if the user is logged, if don't it's sent to login page
	*/

	public function __construct(){
		parent::__construct();

		$u = new Users();

		if($u->isLogged() == false)
		{
			header("Location: ".BASE."login");
		}
	}

	public function index(){}

	public function search_clients()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$permissions= new Permissions();
		$client 	= new Clients();

		if(isset($_GET['q']) && !empty($_GET['q']))
		{
			$q = addslashes($_GET['q']);

			$data = $client->searchClientByName($q, $user->getCompany());
		}

		echo json_encode($data);
	}
}