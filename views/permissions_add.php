<h1>Permissões - Adicionar</h1>

<form method="POST">
	<label for="name">Nome da Permissão</label></br>
	<input type="text" name="name"></input></br>
	</br>
	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>
	<input type="submit" value="Adicionar" />
</form>