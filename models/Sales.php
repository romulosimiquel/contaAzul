<?php
class Sales extends model{

	public function getSalesList($offset, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT sales.id, sales.total_price, sales.date_sale, sales.status, clients.name FROM sales LEFT JOIN clients ON clients.id = sales.id_client WHERE sales.id_company = :id_company ORDER BY sales.date_sale DESC LIMIT $offset, 10");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getInfo($id, $id_company)
	{
		$array = array();

		$sql = $this->db->prepare("SELECT *, (select clients.name from clients where clients.id = sales.id_client) as client_name FROM sales WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array['info'] = $sql->fetch();
		}

		$sql = $this->db->prepare("SELECT sales_products.quant, sales_products.sale_price, inventory.name FROM sales_products LEFT JOIN inventory ON inventory.id = sales_products.id_product WHERE sales_products.id_sale = :id_sale AND sales_products.id_company = :id_company");
		$sql->bindValue(":id_sale", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array['products'] = $sql->fetchAll();
		}

		return $array;
	}

	public function getSalesFiltered($client_name, $period1, $period2, $status, $order, $id_company)
	{
		$array = array();
		//$sql2 = $this->db->prepare();

		$sql = "SELECT 
					clients.name,
					sales.date_sale,
					sales.status,
					sales.total_price
				FROM 
					sales 
				LEFT JOIN
					clients
				ON 
					clients.id = sales.id_client
				WHERE ";

		$where = array();

		$where[] = "sales.id_company = :id_company";
		//$sql2->bindValue(":id_company", $id_company);

		if(!empty($client_name))
		{
			$where[] = "clients.name LIKE '%".$client_name."%'";
			//$sql2->bindValue(":client_name", $client_name);
		}

		if(!empty($period1))
		{
			$where[] = "sales.date_sale >= :period1";
			//$sql2->bindValue(":period1", $period1);
		}

		if(!empty($period2))
		{
			$where[] = "sales.date_sale <= :period2";
			//$sql2->bindValue(":period2", $period2);
		}

		if($status != '')
		{
			$where[] = "sales.status = :status";
			//$sql2->bindValue(":status", $status);
		}

		$sql .= implode(' AND ', $where);

		switch($order)
		{
			case 'date_desc':
			default:
				$sql .= " ORDER BY sales.date_sale DESC";
				break;

			case 'date_asc':
				$sql .= " ORDER BY sales.date_sale ASC";
				break;

			case 'status':
				$sql .= " ORDER BY sales.status";
				break;
		}

		$sql = $this->db->prepare($sql);

		$sql->bindValue(":id_company", $id_company);

		if(!empty($period1))
		{
			$sql->bindValue(":period1", $period1);
		}

		if(!empty($period2))
		{
			$sql->bindValue(":period2", $period2);
		}

		if($status != '')
		{
			$sql->bindValue(":status", $status);
		}

		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function addSell($id_company, $id_user, $id_client, $status, $quant)
	{
		$inv = new Inventory();

		// foreach ($quant as $id_prod => $quant_prod) 
		// {
			
		// 	$sql = $this->db->prepare("SELECT price FROM inventory WHERE id = :id AND id_company = :id_company");

		// 	$sql->bindValue(":id", $id_prod);
		// 	$sql->bindValue(":id_company", $id_company);
		// 	$sql->execute();

		// 	if($sql->rowCount() > 0)
		// 	{
		// 		$row = $sql->fetch();
		// 		$price[$id_prod] = $row['price'];

		// 		$total_price += $price[$id_prod] * $quant_prod;
		// 	}
		// }

		$sql = $this->db->prepare("INSERT INTO sales SET id_company = :id_company, id_client = :id_client, id_user = :id_user, total_price = :total_price, status = :status, date_sale = NOW()");
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id_client', $id_client);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':total_price', '0');
		$sql->bindValue(':status', $status);
		$sql->execute();

		$id_sale = $this->db->lastInsertId();

		$total_price = 0;

		foreach ($quant as $id_prod => $quant_prod) 
		{
			
			$sql = $this->db->prepare("SELECT price FROM inventory WHERE id = :id AND id_company = :id_company");

			$sql->bindValue(":id", $id_prod);
			$sql->bindValue(":id_company", $id_company);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				$row = $sql->fetch();
				$price = $row['price'];

				$sqlp = $this->db->prepare("INSERT INTO sales_products SET id_company = :id_company, id_sale = :id_sale, id_product = :id_prod, quant = :quant, sale_price = :sale_price");
				$sqlp->bindValue(':id_company', $id_company);
				$sqlp->bindValue(':id_sale', $id_sale);
				$sqlp->bindValue(':id_prod', $id_prod);
				$sqlp->bindValue(':quant', $quant_prod);
				$sqlp->bindValue(':sale_price', $price);
				$sqlp->execute();
				
				$inv->downInventory($id_prod, $id_company, $quant_prod, $id_user);

				$total_price += $price * $quant_prod;
			}
		}

		$sql = $this->db->prepare("UPDATE sales SET total_price = :total_price WHERE id = :id");
		$sql->bindValue(":total_price", $total_price);
		$sql->bindValue(":id", $id_sale);
		$sql->execute();
		// foreach ($quant as $id_prod => $quant_prod) 
		// {
		// 	echo "$id_prod -- $quant_prod -- ".$price[$id_prod]."<br>";

		// 	$sql = ;

		// }
	}

	public function editSell($id)
	{
		$sql = $this->db->prepare("INSERT INTO sales SET id_company = :id_company, id_client = :id_client, id_user = :id_user, total_price = :total_price, status = :status, date_sale = NOW()");
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id_client', $id_client);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':total_price', '0');
		$sql->bindValue(':status', $status);
		$sql->execute();

		$id_sale = $this->db->lastInsertId();

		$total_price = 0;

		foreach ($quant as $id_prod => $quant_prod) 
		{
			
			$sql = $this->db->prepare("SELECT price FROM inventory WHERE id = :id AND id_company = :id_company");

			$sql->bindValue(":id", $id_prod);
			$sql->bindValue(":id_company", $id_company);
			$sql->execute();

			if($sql->rowCount() > 0)
			{
				$row = $sql->fetch();
				$price = $row['price'];

				$sqlp = $this->db->prepare("INSERT INTO sales_products SET id_company = :id_company, id_sale = :id_sale, id_product = :id_prod, quant = :quant, sale_price = :sale_price");
				$sqlp->bindValue(':id_company', $id_company);
				$sqlp->bindValue(':id_sale', $id_sale);
				$sqlp->bindValue(':id_prod', $id_prod);
				$sqlp->bindValue(':quant', $quant_prod);
				$sqlp->bindValue(':sale_price', $price);
				$sqlp->execute();
				
				$inv->downInventory($id_prod, $id_company, $quant_prod, $id_user);

				$total_price += $price * $quant_prod;
			}
		}

		$sql = $this->db->prepare("UPDATE sales SET total_price = :total_price WHERE id = :id");
		$sql->bindValue(":total_price", $total_price);
		$sql->bindValue(":id", $id_sale);
		$sql->execute();
	}

	public function changeStatus($status, $id, $id_company)
	{
		$sql = $this->db->prepare("UPDATE sales SET status = :status WHERE id = :id AND id_company =:id_company");
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

	}

	public function getTotalRevenue($period1, $period2, $id_company)
	{
		$float = 0;

		$query = "SELECT SUM(total_price) as total FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2";
		$sql   = $this->db->prepare($query);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':period1', $period1);
		$sql->bindValue(':period2', $period2);
		$sql->execute();

		$n = $sql->fetch();
		$float = $n['total'];

		return $float;
	}

	public function getTotalExpenses($period1, $period2, $id_company)
	{
		$float = 0;

		$query = "SELECT SUM(total_price) as total FROM purchases WHERE id_company = :id_company AND date_purchase BETWEEN :period1 AND :period2";
		$sql   = $this->db->prepare($query);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':period1', $period1);
		$sql->bindValue(':period2', $period2);
		$sql->execute();

		$n = $sql->fetch();
		$float = $n['total'];

		return $float;
	}

	public function getSoldProducts($period1, $period2, $id_company)
	{
		$int = 0;

		$query = "SELECT id FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2";
		$sql   = $this->db->prepare($query);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':period1', $period1);
		$sql->bindValue(':period2', $period2);
		$sql->execute();

		if($sql->rowCount() > 0)
		{
			$p = array();

			foreach($sql->fetchAll() as $sale_item)
			{
				$p[] = $sale_item['id'];
			}

			$query = "SELECT SUM(quant) as total FROM sales_products WHERE id_company = :id_company AND id_sale IN (".implode(",",$p).")";
			$sql   = $this->db->prepare($query);
			$sql->bindValue(':id_company', $id_company);
			$sql->execute();

			$n 	 = $sql->fetch();
			$int = $n['total'];
		}

		return $int;
	}
	

}