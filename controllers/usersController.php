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

				$added = $user->add_user($email, $pass, $name, $group, $user->getCompany());

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
				$pass  = addclashes($_POST['password']);
				$name  = addslashes($_POST['name']);
				$group = addslashes($_POST['group_name']);

				$edited = $user->edit_user($id, $pass, $name, $group, $user->getCompany());

				if($added == true)
				{
					$data['success'] = "Usuário adicionado com sucesso!";
				} else
				{
					$data['error']	 = "Erro na hora de adicionar usuário!";
				}
			}
			
			$data['user_info']	= $user->getUserData($id);
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
				$user->delete_user($id, $user->getCompany());

				header("Location: ".BASE."users");
			} else
			{
				header("Location: ".BASE."users");
			}
		}
	}















}