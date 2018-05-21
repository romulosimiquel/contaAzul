$(function(){

		$('.tabitem').on('click', function()
		{
			$('.activetab').removeClass('activetab');
			$(this).addClass('activetab');

			var item = $('.activetab').index();

			$('.tabbody').hide();
			$('.tabbody').eq(item).show();
		});
	
	$('#search').on('focus', function(){
		$(this).animate({
			width:'250px'
		});
	});

	$('#search').on('blur', function(){
		if($(this).val() == '') {
			$(this).animate({
				width:'100px'
			});
		}
		setTimeout(function(){
			$('.searchresults').hide();
		}, 500);
		
	});	

	$('#search').on('keyup', function(){
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
						$('#search').after('<div class="searchresults"></div>')
					}

					$('.searchresults').css('left', $('#search').offset().left+'px');

					$('.searchresults').css('top', $('#search').offset().top+$('#search').height()+3+'px');

					var html = '';

					for(var i in json){
						html += '<div class="si"><a href="'+json[i].link+'">'+json[i].name+'</a></div>';
					}

					$('.searchresults').html(html);
				}				
			});
		}
	});

	$('#search').on('focus', function(){
		if($(this).val() != '') {
			$('.searchresults').show();
	}});
});