function selectClient(obj)
{
	var id = $(obj).attr('data-id');
	var name = $(obj).html();

	$('.searchresults').hide();
	$('#client_name').val(name);
	$('input[name=client_id]').val(id);
}

function updateSubtotal(obj)
{
	var quant = $(obj).val();
	if(quant <= 0){
		$(obj).val(1);
		quant = 1;
	}

	var price = $(obj).attr('data-price');
	var subtotal = price * quant;

	subtotal = parseFloat(Math.round(subtotal * 100) / 100).toFixed(2);

	$(obj).closest('tr').find('.subtotal').html('R$ '+subtotal);

	updateTotal();
}

function updateTotal()
{
	var total = 0;

	for(var q=0;q<$('.p_quant').length;q++)
	{
		var quant = $('.p_quant').eq(q);

		var price = quant.attr('data-price');
		var subtotal = price * parseInt(quant.val());

		total += subtotal;
	}

	total = parseFloat(Math.round(total * 100) / 100).toFixed(2);

	$('input[name=total_price]').val(total);
}

function excluirProd(obj)
{
	$(obj).closest('tr').remove();
}

function addProd(obj)
{
	var id 		= $(obj).attr('data-id');
	var name 	= $(obj).attr('data-name');
	var price 	= $(obj).attr('data-price');

	$('.searchresults').hide();

	if($('input[name="quant['+id+']"]').length == 0) {
		var tr = '<tr>'+ 
					'<td>'+name+'</td>'+
					'<td>'+
						'<input type="number" name="quant['+id+']" class="p_quant" value="1" onchange="updateSubtotal(this)" data-price="'+price+'"/>'+
					'</td>'+ 
					'<td>R$ '+price+'</td>'+
					'<td class="subtotal">R$ '+price+'</td>'+ 
					'<td><div class="button button_small"><a href="javascript:;" onclick="excluirProd(this)">Excluir</a></div></td>'+ 
				 '</tr>';

		$('#products_table').append(tr);
	}

	
	
	updateTotal();

}

$(function(){

	$('.client_add_button').on('click', function(e){
		e.preventDefault();

		var name = $('#client_name').val();
		if(name != '' && name.length >= 3){

			if(confirm('Você deseja adicionar um cliente com nome: '+name+' ?')){

				$.ajax({
					url:BASE+'ajax/add_client',
					type:'POST',
					data:{name:name},
					dataType:'json',
					success:function(json) {
						$('.searchresults').hide();
						$('input[name=client_id]').val(json.id);

					}
				});
			}
		}
	});

	$('#client_name').on('keyup', function(){
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if(datatype != ''){
			$.ajax({
				url:BASE+'ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json){
					if( $('.searchresults').length == 0){
						$('#client_name').after('<div class="searchresults"></div>')
					}

					$('.searchresults').css('left', $('#client_name').offset().left+'px');

					$('.searchresults').css('top', $('#client_name').offset().top+$('#client_name').height()+3+'px');

					var html = '';

					for(var i in json){
						html += '<div class="si" onclick="selectClient(this)" data-id="'+json[i].id+'">'+json[i].name+'</div>';
					}

					$('.searchresults').html(html);

				}				
			});
		}
	});

	$('#add_prod').on('keyup', function(){
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if(datatype != ''){
			$.ajax({
				url:BASE+'ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json){
					if( $('.searchresults').length == 0){
						$('#add_prod').after('<div class="searchresults"></div>')
					}

					$('.searchresults').css('left', $('#add_prod').offset().left+'px');

					$('.searchresults').css('top', $('#add_prod').offset().top+$('#add_prod').height()+3+'px');

					var html = '';

					for(var i in json){
						html += '<div class="si" onclick="addProd(this)" data-id="'+json[i].id+'" data-price="'+json[i].price+'" data-name="'+json[i].name+'">'+json[i].name+' - R$ '+json[i].price+'</div>';
					}

					$('.searchresults').html(html);
					
				}				
			});
		}
	});	

	// $('#client_name').on('blur', function(){
	// 	setTimeout(function(){
	// 		$('.searchresults').hide();
	// 	}, 100);	
	// });


	$('#client_name').on('focus', function(){
		if($(this).val() != '') {
			$('.searchresults').show();
		}});

	$('#add_prod').on('focus', function(){
		if($(this).val() != '') {
			$('.searchresults').show();
		}else{
			setTimeout(function(){
				$('.searchresults').hide();
			}, 500);
		}
	});	


	$('input[name=total_price]').maskMoney({prefix:'R$ ',thousands:'.', decimal:',', affixesStay: false});
});