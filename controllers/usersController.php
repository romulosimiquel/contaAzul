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
	* Call index permission view, verify if the user has permission to access users view
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

	/** 
	* Adds a new user to the curent company
	* @return $data
	*/
	public function add_user()
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
			$permissions = new Permissions();

			if(isset($_POST['email']) && !empty($_POST['email']))
			{
				$email = addslashes($_POST['email']);
				$pass  = md5(($_POST['password']));
				$name  = addslashes($_POST['name']);
				$group = addslashes($_POST['group_name']);

				$added = $user->addUser($email, $pass, $name, $group, $user->getCompany());

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
			
			$data['group_list'] = $permissions->getGroupsList($user->getCompany());

			$this->loadTemplate('users_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('users', $data);			
		}
	}

	/** 
	* Edits a selected user from the curent company
	* @return $data
	*/
	public function edit_user($id)
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
			$permissions = new Permissions();

			if(isset($_POST['name']) && !empty($_POST['name']))
			{
				$pass  = addslashes($_POST['password']);
				$name  = addslashes($_POST['name']);
				$group = addslashes($_POST['group_name']);

				$edited = $user->editUser($id, $pass, $name, $group, $user->getCompany());

				if($edited == true)
				{
					$data['success'] = "Usuário adicionado com sucesso!";
				} else
				{
					$data['error']	 = "Erro na hora de editar usuário!";
				}
			}
			
			$data['user_info']	= $user->getUserData($id, $user->getCompany());
			$data['group_list'] = $permissions->getGroupsList($user->getCompany());

			$this->loadTemplate('users_edit', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('users', $data);			
		}
	}

	public function delete_user($id)
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
			$permissions = new Permissions();

			if(isset($id) && !empty($id))
			{
				$user->deleteUser($id, $user->getCompany());

				header("Location: ".BASE."users");
			} else
			{
				header("Location: ".BASE."users");
			}
		}
	}















}