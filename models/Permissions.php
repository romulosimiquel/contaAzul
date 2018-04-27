<?php
class Permissions extends model {

	private $group;
	private $permissions;

	public function setGroup($id) 
	{
		$this->group = $id;

		$sql = $this->db->prepare("SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$row = $sql->fetch();
			$row = explode(',', $row);

			$sql = $this->db->prepare("SELECT name FROM permission_params WHERE id IN (:id )  AND  id_company = :id_company");
			$sql->bindValue(':id', $row['params']);
			$sql->bindValue(':id_company', $id_company);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				$p = $sql->fetchAll();
				foreach ($sql->fetchAll as $item) {
					$this->permissions[] = $item['name'];
				}
			}
		}
	}



}