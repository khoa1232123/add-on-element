!function($){"use strict";

	function logoCarousel($scope,$){
		var $_this=$scope.find(".carousel-layout");
		var $currentID="#"+$_this.attr("id");
		var $loop=$_this.data("loop");
		var $dots=$_this.data("dots");
		var $navs=$_this.data("navs");
		var $margin=$_this.data("margin");
		var $autoplay=$_this.data("autoplay");
		var $timeout=$_this.data("autoplaytimeout");
		var $autoplayTimeout = $timeout * 1000;
		var $showitems = $_this.data('showitems');
		var $showitemstablet = $_this.data('showitemstablet');
		var $showitemsmobile = $_this.data('showitemsmobile');
		console.log($autoplayTimeout);
		console.log($currentID);
		console.log($dots);
		$($currentID).owlCarousel({
			loop: $loop,
			margin: $margin,
			nav: $navs,
			autoplay: $autoplay,
			dots: $dots,
			autoplayTimeout: $autoplayTimeout,
			responsive:{
				0:{
					items:$showitemsmobile
				},
				361:{
					items:$showitemstablet
				},
				769:{
					items:$showitems
				}
			}
		})
	}
	$(window).on("elementor/frontend/init", function(){
		elementorFrontend.hooks.addAction("frontend/element_ready/aoe-products-carousel.default",logoCarousel)
		elementorFrontend.hooks.addAction("frontend/element_ready/aoe-posts-carousel.default",logoCarousel)
	})
}(jQuery);