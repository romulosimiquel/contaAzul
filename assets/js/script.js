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
	});	

	$('#search').on('keyup', function(){
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if(datatype != ''){
			$.ajax({
				url:BASE+'/ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json){

				}				
			});
		}
	});	
});