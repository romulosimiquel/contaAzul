<?php
class homeController extends controller {

	public function __construct(){
		parent::__construct();

		$u = new Users();

		if($u->isLogged() == false)
		{
			header("Location: ".BASE."login");
		}
	}

	public function index()
	{
		$data 	 = array();
		$u 		 = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $u->getUserName();

		if($u->hasPermission('permissions_view'))
		{
			$this->loadTemplate('permissions', $data);
		} else
		{
			header("Location: ".BASE);
		}

		$this->loadTemplate('home', $data);
	}

	






}