<h1>Permissões</h1>

<?php if(isset($error) && !empty($error)):?>
    <div class="warning"><?php echo $error?></div>
<?php  exit; else: ?> 

<div class="tabarea">
	<div class="tabitem activetab">Grupos de permissões</div>
	<div class="tabitem">Permissões</div>
</div>
<div class="tabcontent">
	<div class="tabbody" style="display:block;">
		GRUPOS DE PERMISSÕES

	</div>
	<div class="tabbody">
		<a href="<?php echo BASE ?>permissions/add">Adicionar Permissão</a>
		

		<table border="0" width="100%">

			<tr>
				<th>Nome da Permissão</th>
				<th>Ações</th>
			</tr>
			<?php foreach ($permissions_list as $p) :?>
				<tr>
					<td><?php echo $p['name'] ?></td>
					<td><a href="<?php echo BASE ?>permissions/delete/<?php echo $p['id'] ?>">Excluir</a></td>
				</tr>
			<?php endforeach; ?>
		</table>		
	</div>
</div>
<?php endif; ?>