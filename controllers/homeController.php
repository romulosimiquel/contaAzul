<?php
class homeController extends controller {

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

	/** 
	* Call home view
	* @return home view
	*/

	public function index()
	{
		$data 	 = array();
		$u 		 = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $u->getUserName();

	

		$this->loadTemplate('home', $data);
	}

	






}