<style type="text/css">
	th{text-align: left}
</style>
<h1>Relatório de inventário</h1>
<br>
<h4>Itens abaixo do minimo do estoque</h4>
<br>
<table border="0" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th>Preço</th>
		<th>Quant.</th>
		<th>Quant. Min.</th>
	</tr>
	<?php foreach ($inventory_list as $product): ?>
	<tr>
		<td><?php echo $product['name'] ?></td>
		<td><?php echo number_format($product['price'], 2, ',', '.') ?></td>
		<td  width="90"><?php
			if($product['quant'] < $product['min_quant'])
			{
				echo '<span style="color:red">'.$product['quant'].'</span>';
			}
			else
			{
				echo $product['quant'];
			}
		?></td>
		<td width="60"><?php echo $product['min_quant'] ?></td>
	</tr>
	<?php endforeach ;?>
</table>