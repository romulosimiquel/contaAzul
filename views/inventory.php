<h1>Estoque</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?>

<?php if($edit_permission == true):?>
    <div class="button"><a href="<?php echo BASE ?>inventory/add_product">Adicionar Produto</a></div>
<?php  endif; ?>

<table border="0" width="100%">

	<tr>
		<th>Nome</th>
		<th>Preço</th>
		<th>Quantidade</th>
		<th>Quant. Min.</th>
		<th>Ações</th>
	</tr>
	<?php foreach($inventory_list as $product): ?>
	<tr>
		<td><?php echo $product['name'] ?></td>
		<td><?php echo number_format($product['price'], 2) ?></td>
		<td><?php echo $product['quant'] ?></td>
		<td><?php echo $product['min_quant'] ?></td>
		<td>
				
		</td>
	</tr>
	<?php endforeach; ?>
</table>


<?php endif; ?>