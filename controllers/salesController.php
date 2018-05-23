<?php
class salesController extends controller {

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

		if($user->hasPermission('sales_view'))
		{
			$sale   = new Sales();
			$offset = 0;

			$data['sales_list'] = $sale->getSalesList($offset, $user->getCompany());

			$this->loadTemplate('sales', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('sales', $data);			
		}

	}

	public function add_sell()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$company 	= new Companies($user->getCompany());
		$permissions= new Permissions();

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('sales_view'))
		{
			$sale   = new Sales();

			if(isset($_POST['client_id']) && !empty($_POST['client_id']))
			{

				$id_client 		= addslashes($_POST['client_id']);
				$status 		= addslashes($_POST['status']);
				$total_price 	= addslashes($_POST['total_price']);

				$sale->addSell($user->getCompany(), $user->getId(), $id_client, $status, $total_price);

				header('Location: '.BASE.'sales');
			}

			$this->loadTemplate('sales_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('sales', $data);			
		}
	}

}