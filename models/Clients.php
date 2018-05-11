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

	public function add_client($id_company, $name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neigh, $address_city, $address_state, $address_country)
	{
		$sql = $this->db->prepare("INSERT INTO clients SET id_company = :id_company, name = :name, email = :email, phone = :phone, stars = :stars, internal_obs = :internal_obs, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_neigh = :address_neigh, address_city = :address_city, address_state = :address_state, address_country = :address_country");

		$sql->bindValue(":id_company", $id_company);
		$sql->bindValue(":name", $name);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":phone", $phone);
		$sql->bindValue(":stars", $stars);
		$sql->bindValue(":internal_obs", $internal_obs);
		$sql->bindValue(":address_zipcode", $address_zipcode);
		$sql->bindValue(":address", $address);
		$sql->bindValue(":address_number", $address_number);
		$sql->bindValue(":address2", $address2);
		$sql->bindValue(":address_neigh", $address_neigh);
		$sql->bindValue(":address_city", $address_city);
		$sql->bindValue(":address_state", $address_state);
		$sql->bindValue(":address_country", $address_country);
		$sql->execute();

	}
}