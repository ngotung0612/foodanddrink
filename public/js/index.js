$(document).on('mouseover', '.fh5co-card-item', function(){
	$(this).parent().find('.btnmua').addClass('btn-hover');
})
$(document).on('mouseout', '.fh5co-card-item', function(){
	$(this).parent().find('.btnmua').removeClass('btn-hover');
})

$(document).on('mouseover', '.btnmua', function(){
	// $('.btnmua').addClass('btn-hover');
	$(this).parent().find('.btnmua').addClass('btn-hover');
	// $(this).parent().find('.fh5co-card-item.image-popup').addClass('cart-hover');
	$(this).parent().find('.fh5co-card-item').addClass('cart-hover');
})
$(document).on('mouseout', '.btnmua', function(){
	// $('.btnmua').removeClass('btn-hover');
	$(this).parent().find('.btnmua').removeClass('btn-hover');
	// $(this).parent().find('.fh5co-card-item.image-popup').removeClass('cart-hover');
	$(this).parent().find('.fh5co-card-item').removeClass('cart-hover');
})


$(document).on('mouseover', '.btnmua', function(){
	// $(this).parent().find('.btnmua').removeClass('btn-hover');
})