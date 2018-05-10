<?php
class Clients extends model{

	public function getlist($offset)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * from clients LIMIT :offset, 10");
		$sql->bindValue(":offset", $offset);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}
}