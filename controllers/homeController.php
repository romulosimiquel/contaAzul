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

		$nf = new Nfe();
		$nf->emitirNFE(1);

		$data['company_name']  = $company->getCompanyName();
		$data['user_name']	   = $u->getUserName();

		$sale = new Sales();

		$data['products_sold'] = $sale->getSoldProducts(date('Y-m-d', strtotime('-90 days')), date('Y-m-d'), $u->getCompany());
		$data['revenue'] 	   = $sale->getTotalRevenue(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());
		$data['expenses']	   = $sale->getTotalExpenses(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());

		$this->loadTemplate('home', $data);
	}

	






}