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
			if (isset($_POST['name']) && !empty($_POST['name'])) 
			{
				$c = new Clients();


				if($added == true)
				{
					$data['success'] = "Permissão inserida com sucesso!";
				} else
				{
					$data['error']	 = "Erro na hora de adicionar permissão!";
				}
			}		 	

			$this->loadTemplate('clients_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('clients', $data);			
		}
	}

}