<h1>Usuários</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?>

<div class="button"><a href="<?php echo BASE ?>users/add_user">Adicionar Usuário</a></div>
		

<table border="0" width="100%">

	<tr>
		<th>Usuário</th>
		<th>E-mail</th>
		<th>Grupo de Permissões</th>
		<th>Ações</th>
	</tr>
	<?php foreach($users_list as $user): ?>
	<tr>
		<td><?php echo $user['name']; ?></td>
		<td><?php echo $user['email']; ?></td>
		<td><?php echo $user['group_name']; ?></td>
		<td width="200px"><div class="button button_small"><a href="<?php echo BASE ?>users/edit_user/<?php echo $user['id'] ?>">Editar</a></div>
		<div class="button button_delete"><a href="<?php echo BASE ?>users/delete_user/<?php echo $user['id'] ?>" onclick="return confirm('Realmente deseja excluir?')">Excluir</a></div>
		</td>
	</tr>
	<?php endforeach; ?>
</table>


<?php endif; ?>