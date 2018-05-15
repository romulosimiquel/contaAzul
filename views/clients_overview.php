<h1>Clients - Visualizar</h1>

	<?php if(isset($error) && !empty($error)) :?>
		<div class="warning"><?php echo $error?></div>
	<?php elseif(isset($success) && !empty($success)) :?>
		<div class="success"><?php echo $success?></div>
	<?php endif;?>



<label for="name">Nome do Cliente</label></br>
<?php echo $client_info['name'] ?></br></br>

<label for="email">E-mail</label></br>
<?php echo $client_info['email']?></br></br>

<label for="phone">Telefone</label></br>
<?php echo $client_info['phone'] ?></br></br>

<label for="stars">Estrelas</label></br>

	<?php echo $client_info['stars']?>

</br>
</br>

<label for="internal_obs">Observações internas</label></br>
<?php echo $client_info['internal_obs'] ?>
</br></br>

<label for="address_zipcode">CEP</label></br>
<?php echo $client_info['address_zipcode'] ?></br></br>

<label for="address">Rua</label></br>
<?php echo $client_info['address'] ?></br></br>

<label for="address_number">Número</label></br>
<?php echo $client_info['address_number'] ?></br></br>

<label for="address2">Complemento</label></br>
<?php echo $client_info['address2'] ?></br></br>

<label for="address_neigh">Bairro</label></br>
<?php echo $client_info['address_neigh'] ?></br></br>

<label for="address_city">Cidade</label></br>
<?php echo $client_info['address_city'] ?></br></br>

<label for="address_state">Estado</label></br>
<?php echo $client_info['address_state'] ?>"></br></br>

<label for="address_country">País</label></br>
<?php echo $client_info['address_country'] ?></br></br>