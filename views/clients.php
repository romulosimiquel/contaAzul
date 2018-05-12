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
	<?php foreach($clients_list as $client): ?>
	<tr>
		<td><?php echo $client['name'] ?></td>
		<td width="150"><?php echo $client['phone'] ?></td>
		<td width="150"><?php echo $client['address_city'] ?></td>
		<td width="70" style="text-align: center;"><?php echo $client['stars'] ?></td>
		<td width="170" style="text-align: center;">
			<?php if($edit_permission == true):?>
   				<div class="button button_small"><a href="<?php echo BASE ?>clients/edit_client/<?php echo $client['id'] ?>">Editar</a></div>
				<div class="button button_delete"><a href="<?php echo BASE ?>clients/delete_client/<?php echo $client['id'] ?>" onclick="return confirm('Realmente deseja excluir?')">Excluir</a></div>
			<?php else: ?>
				<div class="button button_small"><a href="<?php echo BASE ?>clients/overview_client/<?php echo $client['id'] ?>">Visualizar</a></div>
			<?php  endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>


<?php endif; ?>