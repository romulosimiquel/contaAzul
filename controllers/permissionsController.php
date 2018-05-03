<?php
class permissionsController extends controller {

	public function __construct(){
		parent::__construct();

		$u = new Users();

		if($u->isLogged() == false)
		{
			header("Location: ".BASE."login");
		}
	}

	public function index()
	{
		$data = array();
		$u 		 = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $u->getUserName();

		if($u->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();
			$data['permissions_list'] = $permissions->getList($u->getCompany());

			$this->loadTemplate('permissions', $data);
		} else
		{	
			$data['error'] = 'Você não tem permissão para acessar esse campo.';
			$this->loadTemplate('permissions', $data);			
		}
	}

	public function add()
	{
		$data = array();
		$u 		 = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $u->getUserName();

		if($u->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();

			if (isset($_POST['name']) && !empty($_POST['name'])) 
			{
				$pname = addslashes($_POST['name']);

				$added = $permissions->add($pname, $u->getCompany());

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

	public function delete($id)
	{
		$data = array();
		$u 		 = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());

		$data['company_name'] = $company->getCompanyName();
		$data['user_name']	  = $u->getUserName();

		if($u->hasPermission('permissions_view'))
		{
			$permissions = new Permissions();

			if(isset($id) && !empty($id))
			{	
				$deleted = $permissions->delete($id);

				header("Location: ".BASE."permissions");
			}
		}
	}
}
