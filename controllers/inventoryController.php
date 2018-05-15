<?php
class inventoryController extends controller {

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

		if($user->hasPermission('inventory_view'))
		{
			$inv = new Inventory();

			$offset = 0;

			$data['inventory_list'] 	= $inv->getList($offset, $user->getCompany());

			$data['add_permission'] 	= $user->hasPermission('inventory_add');
			$data['edit_permission'] 	= $user->hasPermission('inventory_edit');

			$this->loadTemplate('inventory', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('inventory', $data);			
		}

	}

	public function add_product()
	{
		$data 		= array();
		$user 		= new Users();
		$user->setLoggedUser();
		$company 	= new Companies($user->getCompany());
		$permissions= new Permissions();

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('inventory_add'))
		{	
			$permissions = new Permissions();

			if(isset($_POST['name']) && !empty($_POST['name']))
			{
				$name 		= addslashes($_POST['name']);
				$quant 		= addslashes($_POST['quant']));
				$min_quant  = addslashes($_POST['min_quant']);
				$price 		= addslashes($_POST['price']);

				$added = $user->add_product($name, $quant, $min_quant, $price, $user->getCompany());

				if($added == true)
				{
					$data['success'] = "Usuário adicionado com sucesso!";
				} elseif ($added == '0') 
				{
					$data['error'] = "Usuário já existe";
				}else
				{
					$data['error']	 = "Erro na hora de adicionar usuário!";
				}
			}

			$this->loadTemplate('inventory_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('users', $data);			
		}
	}

}