<h1>Usuários - Adicionar</h1>

<form method="POST">
	<label for="name">Nome do Usuário</label></br>
	<input type="text" name="name" required></input></br>

	<label for="email">Email</label></br>
	<input type="email" name="email" required></input></br>

	<label for="password">Senha</label></br>
	<input type="password" name="password" required></input></br>

	<label for="group_name">Grupo de Permissões</label></br>
	<select name="group_name" id="group_name" required>
		<?php foreach ($group_list as $g) :?>
			<option value="<?php echo $g['id'];?>"><?php echo $g['group_name'];?></option>
		<?php endforeach;?>
	</select>
	</br>
	</br>
	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>
	<input class="button" type="submit" value="Adicionar" />
</form>