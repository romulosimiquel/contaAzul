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
						'link' => BASE.'clients/edit_client/'.$citem['id'],
						'id'   => $citem['id']
					);
				}
			} else {
				foreach ($clients as $citem) {
					$data[] = array(
						'name' => $citem['name'],
						'link' => BASE.'clients/overview_client/'.$citem['id'],
						'id'   => $citem['id']
					);
				}
			}
			echo json_encode($data);
		}
	}

	public function search_inventory()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$inv 	= new Inventory();

		if(isset($_GET['q']) && !empty($_GET['q']))
		{
			$q = addslashes($_GET['q']);

			$prod = $inv->searchProdByName($q, $user->getCompany());

			if($user->hasPermission('inventory_view'))
			{

				foreach ($prod as $pitem) {
					$data[] = array(
						'name' => $pitem['name'],
						'link' => BASE.'inventory/edit_product/'.$pitem['id']
					);
				}
			}
		}

		echo json_encode($data);
	}

	public function add_client()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$inv 		= new Inventory();
		$client 	= new Clients();

		if(isset($_POST['name']) && !empty($_POST['name']))
		{
			$name 				= addslashes($_POST['name']);

			$data['client_id'] 	= $client->addClient($user->getCompany(), $name);

		}

		echo json_encode($data);
	}

	
}