<?php
class Users extends model {

	private $userInfo;
	private $permissions;

	public function isLogged()
	{
		if(isset($_SESSION['ccUser']) &&  !empty($_SESSION['ccUser']))
		{
			return true;
		} else{
			return false;
		}
	}

	public function doLogin($email, $password)
	{
		$sql = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
		$sql->bindValue(':email', $email);
		$sql->bindValue(':password', md5($password));
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$row = $sql->fetch();

			$_SESSION['ccUser'] = $row['id'];

			return true;
		} else{
			return false;
		}
	}

	public function setLoggedUser()
	{
		if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser']))
		{
			$id = $_SESSION['ccUser'];

			$sql = $this->db->prepare("SELECT * FROM users WHERE id = :id ");
			$sql->bindValue(':id', $id);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				$this->userInfo 	= $sql->fetch();
				$this->permissions 	= new Permissions();
				$this->permissions->setGroup($this->userInfo['group'], $this->userinfo['id_company']);
			}
		}
	}

	public function logout()
	{
		unset($_SESSION['ccUser']);
	}

	public function getCompany()
	{	
		if(isset($this->userInfo['id_company']))
		{	
			return $this->userInfo['id_company'];
		} else {
			return 0;
		}
	}

	public function getUserName()
	{	
		if(isset($this->userInfo['name']))
		{	
			return $this->userInfo['name'];
		} else {
			return '';
		}
	}





}