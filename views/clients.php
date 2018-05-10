<h1>Clientes</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?>

<?php if($edit_permission == true):?>
    <div class="button"><a href="<?php echo BASE ?>clients/add_client">Adicionar Cliente</a></div>
<?php  endif; ?>


		

<table border="0" width="100%">

	<tr>
		<th>Nome</th>
		<th>Telefone</th>
		<th>Cidade</th>
		<th>Estrelas</th>
		<th>Ações</th>
	</tr>
	<?php foreach($clients_list as $c): ?>
		<td><?php echo $c['name'] ?></td>
		<td><?php echo $c['phone'] ?></td>
		<td><?php echo $c['address_city'] ?></td>
		<td><?php echo $c['stars'] ?></td>
		<td>
			
		</td>
	<?php endforeach; ?>
</table>


<?php endif; ?>