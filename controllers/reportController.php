<?php
class reportController extends controller {

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

		if($user->hasPermission('report_view'))
		{

			$this->loadTemplate('report', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('report', $data);			
		}

	}

	public function sales()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$company 	= new Companies($user->getCompany());
		$permissions= new Permissions();

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('report_view'))
		{

			$data['sale_status']= array(
				'0' => 'Aguardando Pagto.',
				'1' => 'Pago',
				'2' => 'Cancelado'
			);
			$this->loadTemplate('report_sales', $data);
		} 
		else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('report', $data);			
		}
	}

	public function sales_pdf()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$company 	= new Companies($user->getCompany());
		$permissions= new Permissions();

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('report_view'))
		{
			$data['sale_status']= array(
				'0' => 'Aguardando Pagto.',
				'1' => 'Pago',
				'2' => 'Cancelado'
			);
			
			$data['order'] = array(
				'date_asc' 	=> 'Mais antigo',
				'date_desc' => 'Mais recente',
				'status' 	=> 'Status'
			);

			$client_name = addslashes($_GET['client_name']);
			$period1 	 = addslashes($_GET['period1']);
			$period2 	 = addslashes($_GET['period2']);
			$status 	 = addslashes($_GET['status']);
			$order 		 = addslashes($_GET['order']);

			$sale = new Sales();
			$data['sales_list'] = $sale->getSalesFiltered($client_name, $period1, $period2, $status, $order, $user->getCompany());

			$data['filters'] = $_GET;

			$this->loadView('report_sales_pdf', $data);
		} 
		else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('report', $data);			
		}
	}

}