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
		<th>Quant.</th>
		<th>Quant. Min.</th>
		<th>Ações</th>
	</tr>
	<?php foreach($inventory_list as $product): ?>
	<tr>
		<td><?php echo $product['name'] ?></td>
		<td>R$ <?php echo number_format($product['price'], 2, ',', '.') ?></td>
		<td width="60" style="text-align: center;"><?php echo $product['quant'] ?></td>
		<td width="90" style="text-align: center;"><?php  
		if($product['min_quant'] > $product['quant'])
		{
			echo '<span style="color:red">'.($product['min_quant']).'</span>';
		}else{

			echo $product['min_quant'];
		}
		?></td>
		<td width="200" style="text-align: center;">
			<?php if($edit_permission == true):?>
   				<div class="button button_small"><a href="<?php echo BASE ?>inventory/edit_product/<?php echo $product['id'] ?>">Editar</a></div>
				<div class="button button_delete"><a href="<?php echo BASE ?>inventory/delete_product/<?php echo $product['id'] ?>" onclick="return confirm('Realmente deseja excluir?')">Excluir</a></div>
			<?php else: ?>
				<div class="button button_small"><a href="<?php echo BASE ?>inventory/overview_product/<?php echo $product['id'] ?>">Visualizar</a></div>
			<?php  endif; ?>	
		</td>
	</tr>
	<?php endforeach; ?>
</table>


<?php endif; ?>