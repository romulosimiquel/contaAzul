<?php
class Inventory extends model{


	public function getList($offset, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM inventory WHERE id_company = :id_company LIMIT $offset, 10");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function add_product($name, $quant, $min_quant, $price, $id_company, $id_user)
	{
		$sql = $this->db->prepare("INSERT INTO inventory SET name = :name, quant = :quant, min_quant = :min_quant, price = :price, id_company = :id_company");
		$sql->bindValue(':name', $name);
		$sql->bindValue(':quant', $quant);
		$sql->bindValue(':min_quant', $min_quant);
		$sql->bindValue(':price', $price);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		$id_product = $this->db->lastInsertId();

		$sql = $this->db->prepare("INSERT INTO inventory_history SET id_product = :id_product, id_user = :id_user, action = :action, date_action = NOW(), id_company = :id_company");
		$sql->bindValue(':id_product', $id_product);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':action', "add");
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





}