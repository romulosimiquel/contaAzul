<?php
class Permissions extends model {

	private $team;
	private $permissions;

	public function setTeam($id, $id_company) 
	{
		$this->team = $id;
		$this->permissions = array();

		$sql = $this->db->prepare("SELECT params FROM permission_teams WHERE id = :id AND id_company = :id_company");
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

	public function getTeamsList($id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM permission_teams WHERE id_company = :id_company");
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

	public function add_team($name, $plist, $id_company)
	{
		$params = implode(',', $plist);

		$sql = $this->db->prepare("INSERT INTO permission_teams SET name = :name, id_company = :id_company, params = :params");
		$sql->bindValue(':params', $params);
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

	public function delete_team($id)
	{
		$user = new Users();

		if($user->findUsersInTeam($id) == false)
		{
		$sql = $this->db->prepare("DELETE FROM permission_teams WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();
		} else
		{
			echo "VEI PRA CÁ";
			exit;
		}
	}
}