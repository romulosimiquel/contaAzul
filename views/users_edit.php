<h1>Usuários - Editar</h1>

<form method="POST">
	<label for="name">Nome do Usuário</label></br>
	<input type="text" name="name" value="<?php echo $user_info['name']?>"></input></br>

	<label for="email">E-mail</label></br>
	<?php echo $user_info['email']?></br>

	<label for="password">Senha</label></br>
	<input type="password" name="password"></input></br></br>

	<label for="group_name">Grupo de Permissões</label></br>
	<select name="group_name" id="group_name">
		<?php foreach ($group_list as $g) :?>
			<option value="<?php echo $g['id'];?>" <?php echo $g['id'] == $user_info['id_group']?'selected="selected"':''?>><?php echo $g['group_name'];?></option>
		<?php endforeach;?>
	</select>
	</br>
	</br>
	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>
	<input class="button" type="submit" value="Editar" />
</form>