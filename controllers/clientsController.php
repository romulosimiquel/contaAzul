<?php
class clientsController extends controller {

	/** 
	* Call clients view
	* @return 
	*/
	public function __construct(){
		parent::__construct();

		$user = new Users();

		if($user->isLogged() == false)
		{
			header("Location: ".BASE."login");
		}
	}

	/** 
	* Call index clients view, verify if the user has permission to access clients view
	* @return $data
	*/
	public function index()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$company 	= new Companies($user->getCompany());
		$permissions= new Permissions();

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('clients_view'))
		{
			$c = new Clients();
			$offset = 0;

			$data['clients_list'] 	 = $c->getList($offset);
			$data['edit_permission'] = $user->hasPermission('clients_edit');

			$this->loadTemplate('clients', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('clients', $data);			
		}
	}

	/** 
	* Adds a new client
	* @return client view with $data
	*/
	public function add_client()
	{
		$data = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('clients_edit'))
		{
			$client = new Clients();

			if(isset($_POST['name']) && !empty($_POST['name']))
			{
				$name 				= addslashes($_POST['name']);
				$email 				= addslashes($_POST['email']);
				$phone 				= addslashes($_POST['phone']);
				$stars 				= addslashes($_POST['stars']);
				$internal_obs 		= addslashes($_POST['internal_obs']);
				$address_zipcode 	= addslashes($_POST['address_zipcode']);
				$address 			= addslashes($_POST['address']);
				$address_number		= addslashes($_POST['address_number']);
				$address2 			= addslashes($_POST['address2']);
				$address_neigh 		= addslashes($_POST['address_neigh']);
				$address_city 		= addslashes($_POST['address_city']);
				$address_state		= addslashes($_POST['address_state']);
				$address_country 	= addslashes($_POST['address_country']);

				$added = $client->add_client($user->getCompany(), $name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neigh, $address_city, $address_state, $address_country);
			}

			if($added == true)
			{
				$data['success'] = "Cliente inserido com sucesso!";
			} else
			{
				$data['error']	 = "Erro na hora de adicionar cliente!";
			}		 	

			$this->loadTemplate('clients_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('clients', $data);			
		}
	}

}