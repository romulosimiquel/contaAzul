<h1>Vendas</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?>

<div class="button"><a href="<?php echo BASE ?>sales/add_sell">Adicionar Venda</a></div>

<table border="0" width="100%">
	<tr>
		<th>Nome do Cliente</th>
		<th>Data</th>
		<th>Status</th>
		<th>Valor</th>
		<th>Ações</th>
	</tr>
	<?php foreach ($sales_list as $sales_item): ?>
	<tr>
		<td><?php echo $sales_item['name'] ?></td>
		<td><?php echo date('d/m/Y', strtotime($sales_item['date_sale'])) ?></td>
		<td><?php echo $sale_status[$sales_item['status']] ?></td>
		<td><?php echo number_format($sales_item['total_price'], 2, ',', '.') ?></td>
		<td>
			<div class="button button_small"><a href="<?php echo BASE ?>sales/edit_sell/<?php echo $sales_item['id'] ?>">Editar</a></div>
		</td>
	</tr>
	<?php endforeach ;?>
</table>


<?php endif; ?>