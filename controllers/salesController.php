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
			$data['sale_status']= array(
				'0' => 'Aguardando Pagto.',
				'1' => 'Pago',
				'2' => 'Cancelado'
			);

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
				$quant			= $_POST['quant'];


				$sale->addSell($user->getCompany(), $user->getId(), $id_client, $status, $quant);

				header('Location: '.BASE.'sales');
			}

			$this->loadTemplate('sales_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('sales', $data);			
		}
	}

	public function edit_sell($id)
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$company 	= new Companies($user->getCompany());
		$permissions= new Permissions();

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		$data['sale_status']= array(
				'0' => 'Aguardando Pagto.',
				'1' => 'Pago',
				'2' => 'Cancelado'
			);

		if($user->hasPermission('sales_view'))
		{
			$sale   = new Sales();

			$data['permission_edit'] = $user->hasPermission('sales_edit');

			if(isset($_POST['status'])  && $data['permission_edit'])
			{
				$status 		= addslashes($_POST['status']);

				$sale->changeStatus($status, $id, $user->getCompany());

				header('Location: '.BASE.'sales');
			}

			$data['sales_info'] = $sale->getInfo($id, $user->getCompany());

			$this->loadTemplate('sales_edit', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('sales', $data);			
		}
	}

}