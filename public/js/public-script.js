jQuery(document).ready(function($) {  
    $('.ultimate-security-for-woocommerce-switch-to-another').find('.ultimate-security-for-woocommerce-header-text').on('click', function(){
		$(this).next().slideToggle(10);
	});  
    $(document).on("click", function (event) {
		// If the target is not the container or a child of the container, then process
		// the click event for outside of the container.
		if ($(event.target).closest(".ultimate-security-for-woocommerce-switch-to-another").length === 0) {
		  $('.ultimate-security-for-woocommerce-switch-to-another').find('.ultimate-security-for-woocommerce-hover-content').hide();
		}
	  });
});