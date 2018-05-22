function selectClient(obj)
{
	var id = $(obj).attr('data-id');
	var name = $(obj).html();

	$('.searchresults').hide();
	$('#client_name').val(name);
	$('#client_name').attr('data-id', id);
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
						$('#client_name').attr('data-id', json.id);
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

	$('#client_name').on('focus', function(){
		if($(this).val() != '') {
			$('.searchresults').show();
	}});
});