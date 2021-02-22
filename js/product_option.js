$j(document).ready(function () {
    $j(".product_opt h1").click(function () {

        var opth1 = $j(this).next("ul").height();
        var opthh1 = $j(this).next("ul").css("height", "auto").height();

        if (opth1 === 0) {
            $j(this).next("ul").height(0);
            $j(this).next("ul").animate({
                height: opthh1,
                marginTop: 15
            }, 300, function () {
                $j(this).next("ul").height("auto");
            });
            $j.cookie('searchmore','1');
        } else {
            $j(this).next("ul").animate({
                height: 0,
                marginTop: 0
            }, 300);
            $j.cookie('searchmore','2');
        }


        $j(this).toggleClass('active');

    });

    $j(".product_optbt").click(function () {

        var opth = $j(".product_opt").height();
        var opthh = $j(".product_opt").css("height", "auto").height();

        if (opth === 0) {
            $j(".product_opt").height(0);
            $j(".product_opt").animate({
                marginTop: 0
            }, 100);
            $j(".product_opt").animate({
                height: opthh,
                paddingTop: 45,
                paddingBottom: 45
            }, 500, function () {
                $j(".product_opt").height("auto");
            });
        } else {
            $j(".product_opt").animate({
                height: 0,
                padding: 0
            }, 400);
            $j(".product_opt").animate({
                marginTop: -1
            }, 0);

        }
        $j(this).toggleClass('active');
        $j(".product_opt").toggleClass('active');
    });
});