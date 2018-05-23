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
		$data 			= array();
		$user 			= new Users();
		$user->setLoggedUser();
		$company 		= new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('inventory_add'))
		{	
			$inv = new Inventory();

			if(isset($_POST['name']) && !empty($_POST['name']))
			{
				$name 		= addslashes($_POST['name']);
				$quant 		= addslashes($_POST['quant']);
				$min_quant  = addslashes($_POST['min_quant']);
				$price 		= addslashes($_POST['price']);

				//to change brasilian numeral format to international numeral format, if already using intenational pattern coment this function
				$price	= str_replace('.', '', $price);
				$price 	= str_replace(',', '.', $price);
 
				$added = $inv->addProduct($name, $quant, $min_quant, $price, $user->getCompany(), $user->getID());

				if($added == true)
				{
					$data['success'] = "Produto adicionado com sucesso!";
				}else
				{
					$data['error']	= "Erro na hora de adicionar produto!";
				}
			}

			$this->loadTemplate('inventory_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('users', $data);			
		}
	}

	public function edit_product($id)
	{
		$data 		 = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company 	 = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('inventory_edit'))
		{
			$inv = new Inventory();

			if(isset($_POST['name']) && !empty($_POST['name']))
			{
				$name 		= addslashes($_POST['name']);
				$quant 		= addslashes($_POST['quant']);
				$min_quant  = addslashes($_POST['min_quant']);
				$price 		= addslashes($_POST['price']);

				$price	= str_replace('.', '', $price);
				$price 	= str_replace(',', '.', $price);

				$edited = $inv->editProduct($name, $quant, $min_quant, $price, $id, $user->getCompany(), $user->getID());

				if($edited == true)
				{
					$data['success'] = "Produto alterado com sucesso!";
				} else
				{
					$data['error']	 = "Erro na hora de adicionar produto!";
				}
			} 	

			$data['product_info'] = $inv->getInvData($id, $user->getCompany());

			$this->loadTemplate('inventory_edit', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('inventory', $data);			
		}
	}

	public function delete_product($id)
	{
		$data = array();
		$user = new Users();
		$user->setLoggedUser();

		if($user->hasPermission('inventory_edit'))
		{
			$inv = new Inventory();

			if(isset($id) && !empty($id))
			{
				$inv->deleteProduct($id, $user->getCompany(), $user->getID());

				header("Location: ".BASE."inventory");
			} 
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('inventory', $data);			
		}
	}

}