<h1>Clientes</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?>

<?php if($edit_permission == true):?>
    <div class="button"><a href="<?php echo BASE ?>clients/add_client">Adicionar Cliente</a></div>
<?php  endif; ?>

<input type="text" id="search" data-type="search_clients"/>
		

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

<div class="pagination">
	<?php if ($p > 1): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p-1; ?>"><div class="pag_button"><?php echo '<' ?></div></a>
	<?php endif; ?>

	<?php if ($p > 2): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo 1; ?>"><div class="pag_button"><?php echo '1' ?></div></a>
		<div class="pag_button"><?php echo '...' ?></div>
	<?php endif; ?>

	<?php if ($p > 1): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p-1; ?>"><div class="pag_button"><?php echo ($p-1) ?></div></a>
	<?php endif; ?>

	<a href="<?php echo BASE ?>clients/?p=<?php echo $p; ?>"><div class="pag_item pag_active"><?php echo $p ?></div></a>

	<?php if ($p < $p_count && $p != $p_count-1): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p+1; ?>"><div class="pag_button"><?php echo ($p+1) ?></div></a>
	<?php endif; ?>

	<?php if (($p < $p_count) && ($p_count-1 > $p)): ?>
		<div class="pag_button"><?php echo '...'?></div>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p_count; ?>"><div class="pag_button"><?php echo $p_count ?></div></a>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p+1; ?>"><div class="pag_button"><?php echo '>' ?></div></a>
	<?php elseif($p != $p_count): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p_count; ?>"><div class="pag_button"><?php echo $p_count ?></div></a>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p+1; ?>"><div class="pag_button"><?php echo '>' ?></div></a>
	<?php endif; ?>
</br>
</br>
</br>

<div class="pagination">
	<?php if ($p > 1): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo 0; ?>"><div class="pag_button"><?php echo '<<' ?></div></a>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p-1; ?>"><div class="pag_button"><?php echo '<' ?></div></a>
	<?php endif; ?>

	<a href="<?php echo BASE ?>clients/?p=<?php echo $p; ?>"><div class="pag_item pag_active"><?php echo $p ?></div></a>
	
	<?php if ($p < $p_count): ?>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p+1; ?>"><div class="pag_button"><?php echo '>'?></div></a>
		<a href="<?php echo BASE ?>clients/?p=<?php echo $p_count; ?>"><div class="pag_button"><?php echo '>>'?></div></a>
	<?php endif; ?>
</br>
</br>
</br>

<div class="pagination">
<?php for($i=1; $i <= $p_count; $i++):?>
	<a href="<?php echo BASE ?>clients/?p=<?php echo $i; ?>"><div class="pag_item <?php echo ($i==$p)?'pag_active':''?>"><?php echo $i ?></div></a>
<?php endfor; ?>
<div style="clear: both;"></div>
</div>
<?php endif; ?>