<h1>Permissões</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?> 

<div class="tabarea">
	<div class="tabitem activetab">Grupos de permissões</div>
	<div class="tabitem">Permissões</div>
</div>
<div class="tabcontent">
	<div class="tabbody" style="display:block">

		<div class="button"><a href="<?php echo BASE ?>permissions/add_team">Adicionar Grupo de Permissão</a></div>
		

		<table border="0" width="100%">

			<tr>
				<th>Nome do Grupo de Permissões</th>
				<th>Ações</th>
			</tr>
			<?php foreach ($permissions_teams_list as $p) :?>
				<tr>
					<td><?php echo $p['name'] ?></td>
					<td width="200px"><div class="button button_small"><a href="<?php echo BASE ?>permissions/edit_team/<?php echo $p['id'] ?>">Editar</a></div>
					<div class="button button_delete"><a href="<?php echo BASE ?>permissions/delete_team/<?php echo $p['id'] ?>" onclick="return confirm('Realmente deseja excluir?')">Excluir</a></div></td>
				</tr>
			<?php endforeach; ?>
		</table>

	</div>
	<div class="tabbody">
		
		<div class="button"><a href="<?php echo BASE ?>permissions/add_param">Adicionar Permissão</a></div>
		

		<table border="0" width="100%">

			<tr>
				<th>Nome da Permissão</th>
				<th>Ações</th>
			</tr>
			<?php foreach ($permissions_list as $p) :?>
				<tr>
					<td><?php echo $p['name'] ?></td>
					<td width="50px"><div class="button button_delete"><a href="<?php echo BASE ?>permissions/delete_param/<?php echo $p['id'] ?>" onclick="return confirm('Realmente deseja excluir?')">Excluir</a></div></td>
				</tr>
			<?php endforeach; ?>
		</table>		
	</div>
</div>
<?php endif; ?>