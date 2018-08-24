<style type="text/css">
	th{text-align: left}
</style>
<h1>Relatório de vendas</h1>

<fieldset>
	<?php

		foreach ($filters as $tipo => $filtro) 
		{
			if(($tipo == 'period2' && $filtro != '' || $tipo == 'period1' && $filtro != ''))
			{
				$filtro = date('d/m/Y', strtotime($filtro));
			}
			elseif ($tipo == 'status' && $filtro != '') 
			{
				$filtro = $sale_status[$filtro];
			}
			elseif ($tipo == 'order') 
			{
				$filtro = $order[$filtro];
			}

			if($filtro != '')
			{
				echo "Filtrado por: ".$filtro."<br>";
			}
			
		}
		// if(isset($filters['client_name']) && !empty($filters['client_name']))
		// {
		// 	echo "Filtrado pelo cliente: ".$filters['client_name']."<br>";
		// }

		// if(isset($filters['period1']) && !empty($filters['period1']))
		// {
		// 	echo "Filtrado a partir de: ".date('d/m/Y', strtotime($filters['period1']))."<br>";
		// } 

		// if(isset($filters['period2']) && !empty($filters['period2']))
		// {
		// 	echo "Filtrado até: ".date('d/m/Y', strtotime($filters['period2']))."<br>";
		// } 

		// if($filters['status'] != '')
		// {
		// 	echo "Filtrado pelo status: ".$sale_status[$filters['status']]."<br>";
		// } 
	?>
</fieldset>
<br>
<table border="0" width="100%">
	<tr>
		<th>Nome do Cliente</th>
		<th>Data</th>
		<th>Status</th>
		<th>Valor</th>
	</tr>
	<?php foreach ($sales_list as $sales_item): ?>
	<tr>
		<td><?php echo $sales_item['name'] ?></td>
		<td><?php echo date('d/m/Y', strtotime($sales_item['date_sale'])) ?></td>
		<td><?php echo $sale_status[$sales_item['status']] ?></td>
		<td><?php echo number_format($sales_item['total_price'], 2, ',', '.') ?></td>
	</tr>
	<?php endforeach ;?>
</table>