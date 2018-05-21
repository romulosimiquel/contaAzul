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




}