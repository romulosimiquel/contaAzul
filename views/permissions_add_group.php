<h1>Permissões - Adicionar Grupo</h1>

<form method="POST">
	<label for="name">Nome do Grupo</label></br>
	<input type="text" name="name"></input></br>
	<label for="params">Número do parâmetro</label>
	<input type="text" name="params"></input></br>
	</br>
	<input class="button" type="submit" value="Adicionar" />
		
	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>		
</form>