<?php
class Sales extends model{

	public function getSalesList($offset, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT sales.id, sales.total_price, sales.date_sale, sales.status, clients.name FROM sales LEFT JOIN clients ON clients.id = sales.clients_id WHERE sales.id_company = :id_company ORDER BY sales.date_sale DESC LIMIT $offset, 10");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function addSell($id_company, $id_user, $id_client, $status, $total_price)
	{
		$sql = $this->db->prepare("INSERT INTO sales SET id_company = :id_company, id_client = :id_client, id_user = :id_user, total_price = :total_price, status = :status, date_sale = NOW()");
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id_client', $id_client);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':total_price', $total_price);
		$sql->bindValue(':status', $status);
		$sql->execute();
	}


}