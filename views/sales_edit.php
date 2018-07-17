<h1>Vendas - Editar</h1>


<strong>Nome do Cliente:</strong><br>
<?php echo $sales_info['info']['client_name'] ?><br><br>

<strong>Data da Venda</strong><br>
<?php echo date('d/m/Y', strtotime($sales_info['info']['date_sale'])) ?><br><br>

<strong>Total da Venda</strong><br>
R$ <?php echo number_format($sales_info['info']['total_price'], 2, ',', '.'); ?><br><br>

<strong>Status da Venda</strong>


<form></form>

<hr/>

<table border="0" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th>Quantidade</th>
		<th>Preço Unitario</th>
		<th>Sub-Total</th>
	</tr>
	<?php foreach($sales_info['products'] as $productitem): ?>
	<tr>
		<td><?php echo $productitem['name'] ?></td>
		<td><?php echo $productitem['quant'] ?></td>
		<td>R$ <?php echo number_format($productitem['sale_price'], 2, ',', '.');?></td>
		<td>R$ <?php echo number_format($productitem['sale_price']*$productitem['quant'], 2, ',', '.');?></td>
	</tr>
	<?php endforeach ?>
</table>