<?php
class permissionsController extends controller {

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
		$data 	 = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();
			$data['permissions_list'] 			= $permissions->getPermList($user->getCompany());
			$data['permissions_groups_list'] 	= $permissions->getGroupsList($user->getCompany());

			$this->loadTemplate('permissions', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('permissions', $data);			
		}
	}

	/** 
	* Adiciona um novo parâmetro de acesso ao banco de dados
	* @param string $name, nome do parâmetro
	* @return $data
	*/
	public function add_param()
	{
		$data = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();

			if (isset($_POST['name']) && !empty($_POST['name'])) 
			{
				$pname = addslashes($_POST['name']);

				$added = $permissions->add_param($pname, $user->getCompany());

				if($added == true)
				{
					$data['success'] = "Permissão inserida com sucesso!";
				} else
				{
					$data['error']	 = "Erro na hora de adicionar permissão!";
				}
			}		 	

			$this->loadTemplate('permissions_add', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('permissions', $data);			
		}
	}

	/** 
	* Adiciona um novo grupo de acesso
	* @param string $name, nome do grupo
	* @return $data
	*/
	public function add_group()
	{
		$data = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();

			if ((isset($_POST['name']) && !empty($_POST['name'])) && (isset($_POST['params']) && !empty($_POST['params']))) 
			{
				$gname = addslashes($_POST['name']);
				$pname = addslashes($_POST['params']);

				$added = $permissions->add_group($gname, $pname, $user->getCompany());

				if($added == true)
				{
					$data['success'] = "Grupo adicionado com sucesso!";
				} else
				{
					$data['error']	 = "Erro na hora de adicionar grupo!";
				}
			}		 	

			$this->loadTemplate('permissions_add_group', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('permissions', $data);			
		}
	}

	/** 
	* Deleta um parâmetro de acesso do banco de dados
	* @param int $id_param
	* @return boolean
	*/
	public function delete_param($id_param)
	{
		$data = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();

			if(isset($id_param) && !empty($id_param))
			{	
				$deleted = $permissions->delete_param($id_param);

				header("Location: ".BASE."permissions");
			}
		}
	}

	public function delete_group($id_param)
	{
		$data = array();
		$user 		 = new Users();
		$user->setLoggedUser();
		$company = new Companies($user->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $user->getUserName();

		if($user->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();

			if(isset($id_param) && !empty($id_param))
			{	
				$deleted = $permissions->delete_group($id_param);

				header("Location: ".BASE."permissions");
			}
		}
	}
}
