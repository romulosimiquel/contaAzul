$('input[name=address_zipcode]').on('blur', function(){
	var cep = $(this).val();

	$.ajax({
		url:'http://api.postmon.com.br/v1/cep/'+cep,
		type:'GET',
		dataType:'json',
		success:function(json){
			if(typeof json.cidade != 'undefined'){
				$('input[name=address]').val(json.logradouro);
				$('input[name=address_neigh]').val(json.bairro);
				$('input[name=address_city]').val(json.cidade);
				$('input[name=address_state]').val(json.estado);
				$('input[name=address_country]').val("Brasil");

				if(typeof json.logradouro != 'undefined'){
					$('input[name=address_number]').focus();
				} else{
					$('input[name=address]').focus();
				}
			}
		}
	});
});

jQuery('input[name=phone]').mask('(00) 0000-00009', {'translation': {0: {pattern: /[0-9*]/}}});
jQuery('input[name=address_zipcode]').mask('00000-000', {'translation': {0: {pattern: /[0-9*]/}}});
//jQuery('input[name=price]').mask('', {'translation': {0: {pattern: /[0-9*]/}}});