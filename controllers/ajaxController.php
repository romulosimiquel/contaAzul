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

			$clients = $client->searchClientByName($q, $user->getCompany());

			if($user->hasPermission('clients_edit'))
			{

				foreach ($clients as $citem) {
					$data[] = array(
						'name' => $citem['name'],
						'link' => BASE.'clients/edit_client/'.$citem['id']
					);
				}
			} else {
				foreach ($clients as $citem) {
					$data[] = array(
						'name' => $citem['name'],
						'link' => BASE.'clients/overview_client/'.$citem['id']
					);
				}
			}
		}

		echo json_encode($data);
	}
}