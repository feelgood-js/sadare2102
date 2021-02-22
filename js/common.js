//정방형 리사이징
function resizing_img() {
	$j('.resizing_img').each(function () {
		$j(this).wrap("<div class='resizing_wrap'></div>");
		if ($j(this).width() < $j(this).height()) {
			$j(this).css('width', '100%');
			$j(this).css('height', 'auto');
		} else {
			$j(this).css('width', 'auto');
			$j(this).css('height', '100%');
		}
	});
}

//제품 레이아웃
function product_view() {
	$j('.product_view').each(function () {
		//$j(this).height($j(this).width());
		//$j('a',this).height($j(this).width());
	});

	$j('.product_slide_wrap').each(function () {
		var productH = $j(this).find('.product_view').height();
		//$j(this).find('.slide_button').css("top", productH / 2 + $j(this).find('.product_view').position().top);
		$j(this).find('.slide_button').css("top", productH / 2);
	});
}

//제품 슬라이더
function product_slider() {
	$j('.product_slide').each(function () {
		$j(this).wrap("<div class='product_slide_wrap'></div>");
		$j(this).after("<div class='slide_button'><div class='swiper-button-prev'></div><div class='swiper-button-next'></div></div>");
		//$j(this).after("<div class='slide_button'><div class='wrapper'><div><div class='swiper-button-prev'></div><div class='swiper-button-next'></div></div></div></div>");

		if ($j(this).attr('col') == undefined) {
			if ($j(this).hasClass('product_b') == true) {
				product_col = 2;
			} else if ($j(this).hasClass('product_c') == true) {
				product_col = 1;
			} else {
				product_col = 4;
			}
		} else {
			product_col = $j(this).attr('col');
		}
		if ($j(this).attr('slide-delay') == undefined) {
			slide_delay = false;
		} else {
			slide_delay = {
				delay: $j(this).attr('slide-delay'),
				disableOnInteraction: false
			}
		}

		var product_slide = new Swiper($j(this), {
			loop: true,
			navigation: {
				nextEl: $j(this).parent('.product_slide_wrap').find('.swiper-button-next'),
				prevEl: $j(this).parent('.product_slide_wrap').find('.swiper-button-prev')
			},
			containerModifierClass: 'product_slide',
			wrapperClass: 'product_slide .product_list',
			slideClass: 'product_slide .product_item',
			slidesPerView: product_col,
			spaceBetween: parseInt($j(this).find('.product_item').css("margin-right")),
			autoplay: slide_delay
		});

	});
}

$j(document).ready(function () {
	//상단 검색
	$j('#top .link_search').click(function () {
		$j('#search').slideToggle(500);
		$j('.bg').fadeToggle(500);
	});

	$j('.detail_options>div>ul').click(function () {
		$(this).toggleClass('on').parent('div').siblings('div').children('ul').removeClass('on');
	});

	product_slider();
	product_view();
	resizing_img();

	$j(window).resize(function () {
		product_view();
		resizing_img();
	});
});


//카테고리 뷰(상단 메뉴)
function categoryView(obj,type){
	var div=$j('#'+obj);
	if(type=='open'){
		div.css('display',"block");
	}else if(type=='over'){
		div.css('display',"block");
	}else if(type=='out'){
		div.css('display',"none");
	}
}


function logout() {
	//location.href="../main/main.php?type=logout";
	location.href="logout.php";
}


function TopSearchCheck() {
	try {
		if(document.search_tform.search.value.length==0) {
			alert("상품 검색어를 입력하세요.");
			document.search_tform.search.focus();
			return;
		}
		document.search_tform.submit();
	} catch (e) {}
}


function sendsns(type,title,shop_url,site_name){
	//var shop_url = shop_url;
	switch(type){
		case "twitter" :
			var link = 'http://twitter.com/home?status=' + encodeURIComponent(title) + ' : ' + encodeURIComponent(shop_url);
			var w = window.open("http://twitter.com/home?status=" + encodeURIComponent(title) + " " + encodeURIComponent(shop_url), 'twitter', 'menubar=yes,toolbar=yes,status=yes,resizable=yes,location=yes,scrollbars=yes');
			if(w)  {	w.focus();	}
			break;

		case "facebook" :
			var link = 'http://www.facebook.com/share.php?t=' + encodeURIComponent(title) + '&u=' + encodeURIComponent(shop_url);
			var w = window.open(link,'facebook', 'menubar=yes,toolbar=yes,status=yes,resizable=yes,location=yes,scrollbars=yes');
			if(w)  {	w.focus();	}
			break;

		case "me2day" :
			var tag = site_name;
			var link = 'http://me2day.net/posts/new?new_post[body]="' + encodeURIComponent(title) + '" : ' + encodeURIComponent(shop_url) + '&new_post[tags]=' + encodeURIComponent(tag) ;
			var w = window.open(link,'me2day', 'menubar=yes,toolbar=yes,status=yes,resizable=yes,location=yes,scrollbars=yes');
			if(w)  {	w.focus();	}
			break;

		case "yozm" :
			//parameter = "ggg";
			var href = "http://yozm.daum.net/api/popup/prePost?link=" + encodeURIComponent(shop_url) + "&prefix=" + encodeURIComponent(title) + "&parameter=" + encodeURIComponent(site_name);
			var w = window.open(href, 'yozm', 'width=466, height=356');
			if(w)  {	w.focus();	}
			break;

		case "cyworld" :
			var href = "http://api.cyworld.com/openscrap/post/v1/?xu=/cyworldApi.php?code=" + code +"&sid=코드입력";
			var w = window.open(href, 'cyworld', 'width=450,height=410');
			if(w)  {	w.focus();	}
			break;

		default :
			break;
	}
}


function quantityControl(mode, idx){
	var _form = document['form_'+idx];
	if(mode != null || mode != 'undifined'){
		if(mode == 'plus'){
			_form.quantity.value = parseInt(_form.quantity.value) + 1;
		}
		if(mode == 'minus'){
			if(_form.quantity.value > 1){
				_form.quantity.value = parseInt(_form.quantity.value) - 1;
			}else{
				alert("최소 구매가능한 수량은 1개 입니다.");
			}
		}
	}
}


function openSubCate(idx){
	var open = document.getElementById('btn_plus_'+idx);
	var close = document.getElementById('btn_minus_'+idx);
	var viewbox = document.getElementById('subCatelist_'+idx);
	if(idx != "undifined" && idx != null){
		open.style.display = "none";
		close.style.display = "inline-block";
		viewbox.style.display = "block";
	}
}


function closeSubCate(idx){
	var open = document.getElementById('btn_plus_'+idx);
	var close = document.getElementById('btn_minus_'+idx);
	var viewbox = document.getElementById('subCatelist_'+idx);
	if(idx != "undifined" && idx != null){
		close.style.display = "none";
		open.style.display = "inline-block";
		viewbox.style.display = "none";
	}
}


function _toggle(idx){
	var open = document.getElementById('btn_plus_'+idx);
	var close = document.getElementById('btn_minus_'+idx);
	var viewbox = document.getElementById('subCatelist_'+idx);
	if(viewbox.style.display == 'block'){
		viewbox.style.display = 'none';
		close.style.display = 'none';
		open.style.display = 'inline-block';	
	}else{
		viewbox.style.display = 'block';
		open.style.display = 'none';
		close.style.display = 'inline-block';
	}
	return;
}
