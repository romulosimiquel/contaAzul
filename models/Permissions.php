<?php
class Permissions extends model {

	private $group;
	private $permissions;

	public function setGroup($id, $id_company) 
	{
		$this->group = $id;
		$this->permissions = array();

		$sql = $this->db->prepare("SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$row = $sql->fetch();
			
			if(empty($row['params']))
			{
				$row['params'] = '0';
			}

			$params = $row['params'];

			$sql = $this->db->prepare("SELECT name FROM permission_params WHERE id IN ($params) AND id_company = :id_company");
			$sql->bindValue(':id_company', $id_company);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				foreach($sql->fetchAll() as $item) 
				{
					$this->permissions[] = $item['name'];
				}
			}
		}
	}

	public function hasPermission($name)
	{
		if(in_array($name, $this->permissions))
		{
			return true;
		} else 
		{
			return false;
		}
	}

	public function getPermList($id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM permission_params WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getGroupsList($id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function add_param($name, $id_company)
	{
		$sql = $this->db->prepare("INSERT INTO permission_params SET name = :name, id_company = :id_company");
		$sql->bindValue(':name', $name);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			return true;
		} else 
		{
			return false;
		}
	}

	public function add_group($name, $param, $id_company)
	{
		$sql = $this->db->prepare("INSERT INTO permission_groups SET name = :name, id_company = :id_company, params = :param");
		$sql->bindValue(':param', $param);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			return true;
		} else 
		{
			return false;
		}

	}

	public function delete_param($id)
	{
		$sql = $this->db->prepare("DELETE FROM permission_params WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();
	}

	public function delete_group($id)
	{
		$sql = $this->db->prepare("DELETE FROM permission_groups WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();
	}
}