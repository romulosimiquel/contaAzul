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

	public function getInvData($id, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM inventory WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetch();
		}

		return $array;
	}

	public function setLog($id_user, $action, $date_action, $id_company, $id_product)
	{
		$sql = $this->db->prepare("INSERT INTO inventory_history SET id_product = :id_product, id_user = :id_user, action = :action, date_action = NOW(), id_company = :id_company");
		$sql->bindValue(':id_product', $id_product);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':action', $action);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
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

		$this->setLog($id_user, 'add', $date_action, $id_company, $id_product);

		if($sql->rowCount() > 0)
		{
			return true;

		} else 
		{
			return false;
		}
	}

	public function edit_product($name, $quant, $min_quant, $price, $id_product, $id_company, $id_user)
	{
		$sql = $this->db->prepare("UPDATE inventory SET name = :name, quant = :quant, min_quant = :min_quant, price = :price WHERE id_company = :id_company AND id = :id_product");
		$sql->bindValue(':name', $name);
		$sql->bindValue(':quant', $quant);
		$sql->bindValue(':min_quant', $min_quant);
		$sql->bindValue(':price', $price);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id_product', $id_product);
		$sql->execute();

		$this->setLog($id_user, 'edit', $date_action, $id_company, $id_product);

		if($sql->rowCount() > 0)
		{
			return true;

		} else 
		{
			return false;
		}
	}

	public function delete_product($id_product, $id_company, $id_user)
	{	

		$sql = $this->db->prepare("DELETE FROM inventory WHERE id = :id_product AND id_company = :id_company");
		$sql->bindValue(':id_product', $id_product);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		$this->setLog($id_user, 'delete', $date_action, $id_company, $id_product);
	}



}