$(function(){

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
						html += '<div class="si">'+json[i].name+'</div>';
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