<?php
class Clients extends model{

	public function getClientsList($offset, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT * from clients WHERE id_company = :id_company LIMIT $offset, 10");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getClientData($id, $id_company)
	{
		$array = array();
		$sql = $this->db->prepare("SELECT * FROM clients WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetch();
		}

		return $array;
	}

	public function getClientsCount($id_company)
	{
		$r = 0;

		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM clients WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
		$row = $sql->fetch();

		$r = $row['c'];

		return $r;
	}

	public function add_client($id_company, $name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neigh, $address_city, $address_state, $address_country)
	{
		$sql = $this->db->prepare("INSERT INTO clients SET id_company = :id_company, name = :name, email = :email, phone = :phone, stars = :stars, internal_obs = :internal_obs, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_neigh = :address_neigh, address_city = :address_city, address_state = :address_state, address_country = :address_country");

		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':phone', $phone);
		$sql->bindValue(':stars', $stars);
		$sql->bindValue(':internal_obs', $internal_obs);
		$sql->bindValue(':address_zipcode', $address_zipcode);
		$sql->bindValue(':address', $address);
		$sql->bindValue(':address_number', $address_number);
		$sql->bindValue(':address2', $address2);
		$sql->bindValue(':address_neigh', $address_neigh);
		$sql->bindValue(':address_city', $address_city);
		$sql->bindValue(':address_state', $address_state);
		$sql->bindValue(':address_country', $address_country);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			return true;

		} else 
		{
			return false;
		}
	}

	public function edit_client($id, $id_company, $name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neigh, $address_city, $address_state, $address_country)
	{
		$sql = $this->db->prepare("UPDATE clients SET name = :name, email = :email, phone = :phone, stars = :stars, internal_obs = :internal_obs, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_neigh = :address_neigh, address_city = :address_city, address_state = :address_state, address_country = :address_country WHERE id = :id AND id_company = :id_company");

		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':phone', $phone);
		$sql->bindValue(':stars', $stars);
		$sql->bindValue(':internal_obs', $internal_obs);
		$sql->bindValue(':address_zipcode', $address_zipcode);
		$sql->bindValue(':address', $address);
		$sql->bindValue(':address_number', $address_number);
		$sql->bindValue(':address2', $address2);
		$sql->bindValue(':address_neigh', $address_neigh);
		$sql->bindValue(':address_city', $address_city);
		$sql->bindValue(':address_state', $address_state);
		$sql->bindValue(':address_country', $address_country);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			return true;

		} else 
		{
			return false;
		}
	}

	public function delete_client($id, $id_company)
	{
		echo "TEM QUE FAZER MAIS COISA ANTES DE FAZER O DELETE";
	}

	public function searchClientByName($name, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT name, id FROM clients WHERE name LIKE :name AND id_company = :id_company LIMIT 10");
		$sql->bindValue(':name', '%'.$name.'%');
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

}