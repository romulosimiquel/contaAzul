<h1>Estoque - Adicionar Produto</h1>

	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>

<form method="POST">
	<label for="name">Nome do produto</label></br>
	<input type="text" name="name" required></input></br>

	<label for="price">Preço</label></br>	
	<input type="text" name="price"></input></br>

	<label for="quant">Quantidade</label></br>
	<input type="text" name="quant"></input></br>

	<label for="min_quant">Quantidade Mínima</label></br>
	<textarea name="min_quant" id="min_quant"></textarea>
	</br></br>
	
	<input class="button" type="submit" value="Adicionar" />
</form>

<script type="text/javascript" src="<?php echo BASE; ?>assets/js/script_clients_add.js"></script>