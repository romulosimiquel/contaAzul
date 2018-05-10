<h1>Clients - Adicionar</h1>

<form method="POST">
	<label for="name">Nome do Cliente</label></br>
	<input type="text" name="name" required></input></br>

	<label for="email">E-mail</label></br>
	<input type="email" name="email"></input></br>

	<label for="phone">Telefone</label></br>
	<input type="text" name="phone"></input></br>

	<label for="stars">Estrelas</label></br>
	<select name="stars" id="stars">
		<option value="1">1 Estrela</option>
		<option value="2">2 Estrelas</option>
		<option value="3" selected="selected">3 Estrelas</option>
		<option value="4">4 Estrelas</option>
		<option value="5">5 Estrelas</option>
	</select>
	</br>
	</br>

	<label for="internal_obs">Observações internas</label></br>
	<textarea name="internal_obs" id="internal_obs"></textarea>
	</br></br>

	<label for="address_zipcode">CEP</label></br>
	<input type="text" name="zipcode"></input></br>

	<label for="address">Rua</label></br>
	<input type="text" name="address_street"></input></br>

	<label for="address_neigh">Bairro</label></br>
	<input type="text" name="address_street"></input></br>

	<label for="address_city">Cidade</label></br>
	<input type="text" name="address_street"></input></br>

	<label for="address_country">País</label></br>
	<input type="text" name="address_street"></input></br>

	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>
	<input class="button" type="submit" value="Adicionar" />
</form>

<script type="text/javascript" src="<?php echo BASE; ?>assets/js/script_clients_add.js"></script>