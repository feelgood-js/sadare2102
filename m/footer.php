<?
switch ($menu_set){
	case 'my':
	echo '
	   <ul class="foo_menu">
            <li><a href="product.php"><img src="./img/f1.png" alt=""><p>홈</p></a></li>
            <li><a href="productlist.php?code=000"><img src="./img/f2.png" alt=""><p>쇼핑</p></a></li>
            <li><a href="local.php"><img src="./img/f3.png" alt=""><p>로컬</p></a></li>
            <li><a href="ladder.php"><img src="./img/f41.png" alt=""><p>레더</p></a></li>
            <li style="border-top:1.444vw solid #766DC1;"><a href="mypage.php"><img src="./img/f51.png" alt=""><p style="color:#766DC1">마이</p></a></li>
        </ul>
	';
	break;

	case 'ladder':
	echo '
	   <ul class="foo_menu">
            <li><a href="product.php"><img src="./img/f1.png" alt=""><p>홈</p></a></li>
            <li><a href="productlist.php?code=000"><img src="./img/f2.png" alt=""><p>쇼핑</p></a></li>
            <li><a href="local.php"><img src="./img/f3.png" alt=""><p>로컬</p></a></li>
            <li style="border-top:1.444vw solid #766DC1;"><a href="ladder.php"><img src="./img/f4.png" alt=""><p style="color:#766DC1">레더</p></a></li>
            <li><a href="mypage.php"><img src="./img/f5.png" alt=""><p>마이</p></a></li>
        </ul>
	';
	break;

	case 'local':
	echo '
	   <ul class="foo_menu">
            <li><a href="product.php"><img src="./img/f1.png" alt=""><p>홈</p></a></li>
            <li><a href="productlist.php?code=000"><img src="./img/f2.png" alt=""><p>쇼핑</p></a></li>
            <li style="border-top:1.444vw solid #766DC1;"><a href="local.php"><img src="./img/f33.png" alt=""><p style="color:#766DC1">로컬</p></a></li>
            <li><a href="ladder.php"><img src="./img/f41.png" alt=""><p>레더</p></a></li>
            <li><a href="mypage.php"><img src="./img/f5.png" alt=""><p>마이</p></a></li>
        </ul>
	';
	break;

	case 'shoping':
	echo '
	   <ul class="foo_menu">
            <li><a href="product.php"><img src="./img/f1.png" alt=""><p>홈</p></a></li>
            <li style="border-top:1.444vw solid #766DC1;"><a href="productlist.php?code=000"><img src="./img/f22.png" alt=""><p style="color:#766DC1">쇼핑</p></a></li>
            <li><a href="local.php"><img src="./img/f3.png" alt=""><p>로컬</p></a></li>
            <li><a href="ladder.php"><img src="./img/f41.png" alt=""><p>레더</p></a></li>
            <li><a href="mypage.php"><img src="./img/f5.png" alt=""><p>마이</p></a></li>
        </ul>
	';
	break;

	case 'home':
	echo '
	   <ul class="foo_menu">
            <li style="border-top:1.444vw solid #766DC1;"><a href="product.php"><img src="./img/f11.png" alt=""><p style="color:#766DC1">홈</p></a></li>
            <li><a href="productlist.php?code=000"><img src="./img/f2.png" alt=""><p>쇼핑</p></a></li>
            <li><a href="local.php"><img src="./img/f3.png" alt=""><p>로컬</p></a></li>
            <li><a href="ladder.php"><img src="./img/f41.png" alt=""><p>레더</p></a></li>
            <li><a href="mypage.php"><img src="./img/f5.png" alt=""><p>마이</p></a></li>
        </ul>
	';
	break; 
	
	default :
	echo '
	   <ul class="foo_menu">
            <li style="border-top:1.444vw solid #766DC1;"><a href="product.php"><img src="./img/f11.png" alt=""><p style="color:#766DC1">홈</p></a></li>
            <li><a href="productlist.php?code=000"><img src="./img/f2.png" alt=""><p>쇼핑</p></a></li>
            <li><a href="local.php"><img src="./img/f3.png" alt=""><p>로컬</p></a></li>
            <li><a href="ladder.php"><img src="./img/f41.png" alt=""><p>레더</p></a></li>
            <li><a href="mypage.php"><img src="./img/f5.png" alt=""><p>마이</p></a></li>
        </ul>
	';
	break;

}

?>
<a href="#" class="top_move"><img src="/m/img/top.png"></a>		

<style>
	a.top_move {display:block; width: 50px; height: 50px; position:fixed; right: 5%; bottom: 10%; }
	a.top_move img {width: 100%; opacity:0.5}
</style>