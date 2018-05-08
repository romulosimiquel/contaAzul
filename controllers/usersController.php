<?php
class usersController extends controller {

	public function __construct(){
		parent::__construct();

		$user = new Users();

		if($user->isLogged() == false)
		{
			header("Location: ".BASE."login");
		}
	}

	/** 
	* Call index permission view, verify if the user has permission to see the permissions view
	* @param array $data
	* @param object $company
	* @param object $u
	* @param object $permissions
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

		if($user->hasPermission('users_view'))
		{
			$data['users_list'] = $user->getList($user->getCompany());

			$this->loadTemplate('users', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('users', $data);			
		}
	}


}