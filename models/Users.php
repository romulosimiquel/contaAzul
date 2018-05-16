<?php
class Users extends model {

	private $userInfo;
	private $permissions;

	/** 
	* Verify if users session is seted
	* @return boolean
	*/
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
				$this->permissions->setGroup($this->userInfo['id_group'], $this->userInfo['id_company']);
			}
		}
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

	public function getId()
	{	
		if(isset($this->userInfo['id']))
		{	
			return $this->userInfo['id'];
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

	public function getUserData($id, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM users WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
			{
				$array = $sql->fetch();
			}

		return $array;
	}

	public function getList($id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT users.id, users.name, users.email, permission_groups.group_name FROM users LEFT JOIN permission_groups ON permission_groups.id = users.id_group WHERE users.id_company = :id_company");
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();

		}

		return $array;
	}

	public function logout()
	{
		unset($_SESSION['ccUser']);
	}

	public function hasPermission($name)
	{
		return $this->permissions->hasPermission($name);
	}

	public function findUsersInGroup($id)
	{
		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM users WHERE id_group = :id_group");
		$sql->bindValue(":id_group", $id);
		$sql->execute();

		$row = $sql->fetch();
		if($row['c'] == '0')
		{
			return false;
		} else
		{
			return true;
		}
	}

	public function add_user($email, $password, $name, $id_group, $id_company)
	{
		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM users WHERE email = :email");
		$sql->bindValue(':email', $email);
		$sql->execute();
		$row = $sql->fetch();

		if($row['c'] == '0')
		{
			$sql = $this->db->prepare("INSERT INTO users SET email = :email, password = :password, name = :name, id_group = :id_group, id_company = :id_company");
			$sql->bindValue(':email', $email);
			$sql->bindValue(':password', md5($password));
			$sql->bindValue(':name', $name);
			$sql->bindValue(':id_group', $id_group);
			$sql->bindValue(':id_company', $id_company);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				return true;

			} else 
			{
				return false;
			}
		} else
		{
			return '0';
		}
	}

	public function edit_user($id, $password, $name, $id_group, $id_company)
	{
		$sql = $this->db->prepare("UPDATE users SET name = :name, id_group = :id_group WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':name', $name);
		$sql->bindValue(':id_group', $id_group);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if(!empty($password)) 
		{
			$sql = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id AND id_company = :id_company");
			$sql->bindValue(':password', md5($password));
			$sql->bindValue(':id_company', $id_company);
			$sql->bindValue(':id', $id);
			$sql->execute();
		}

		if($sql->rowCount() > 0)
		{
			return true;
		} else 
		{
			return false;
		}
	}

	public function delete_user($id, $id_company)
	{	
		$sql = $this->db->prepare("SELECT id_company FROM users WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();
		$comp = $sql->fetch();

		if($id_company == $comp['id_company'])
		{
		$sql = $this->db->prepare("DELETE FROM users WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
		}
	}
}