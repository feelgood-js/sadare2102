$(document).ready(function () {
	$(".product_opt h1").click(function () {

		var opth1 = $(this).next("ul").height();
		var opthh1 = $(this).next("ul").css("height", "auto").height();

		if (opth1 === 0) {
			$(this).next("ul").height(0);
			$(this).next("ul").animate({
				height: opthh1,
				marginTop: 15
			}, 300, function () {
				$(this).next("ul").height("auto");
			});
			$.cookie('searchmore','1');
		} else {
			$(this).next("ul").animate({
				height: 0,
				marginTop: 0
			}, 300);
			$.cookie('searchmore','2');
		}


		$(this).toggleClass('active');

	});

	$(".product_optbt").click(function () {

		var opth = $(".product_opt").height();
		var opthh = $(".product_opt").css("height", "auto").height();

		if (opth === 0) {
			$(".product_opt").height(0);
			$(".product_opt").animate({
				marginTop: 0
			}, 100);
			$(".product_opt").animate({
				height: opthh,
				paddingTop: 45,
				paddingBottom: 45
			}, 500, function () {
				$(".product_opt").height("auto");
			});
		} else {
			$(".product_opt").animate({
				height: 0,
				padding: 0
			}, 400);
			$(".product_opt").animate({
				marginTop: -1
			}, 0);

		}
		$(this).toggleClass('active');
		$(".product_opt").toggleClass('active');
	});
});