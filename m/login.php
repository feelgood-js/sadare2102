
<?php
// 상품가격 0원 오류 관련 수정함(비회원 구매 시 연결링크 수정) 2016-04-07 Seul
include_once("top.php");

$shopconfig = shopconfig();

$chUrl=trim(urldecode($_REQUEST["chUrl"]));

if(strlen($_ShopInfo->getMemid())>0) {	
	if (strlen($chUrl)>0) { $onload=$chUrl; }
	else { $onload="./index.php"; }

	echo '<script>location.href="'.$onload.'";</script>';
	exit;
}


if(strpos($chUrl,"?") && (ereg("order.php",$chUrl) || ereg("order3.php",$chUrl))){
	$orderParm =  substr($chUrl, strpos($chUrl,"?"));
	$chUrl = substr($chUrl,0,strpos($chUrl,"?"));
}
?>

<script type="text/javascript">
    $(function(){
        $('.kjku>input').focus(function(){
            $('.login_bt').css('display','none');
        });
        $('.kjku>input').blur(function(){
            $('.login_bt').css('display','block');
        });
    });
</script>
<div id="login">

	<? if(substr($chUrl,-13) == "orderlist.php"){ //비회원 주문조회 ?>

	<div class="h_area2">
		<h2>비회원 주문조회</h2>
		<a href="index.php" class="btn_home" rel="external"><span class="vc">홈</span></a>
		<a href="javascript:history.back()" class="btn_prev" rel="external"><span>이전</span></a>
	</div>
	<div class="wrapper">
		<form name="orderForm" action="./orderdetailpop.php" target="orderpop" method="post">
			<input type="text" name="ordername" value="" placeholder="주문자명" />
			<input type="text" name="ordercodeid" value="" placeholder="주문번호"/>
		</form>
		<div class="login_bt" onClick="javascript:order();">SEARCH</div>

	<? }else{ //일반 로그인 페이지 ?>
	<div class="h_area2">
		<a href="index.php" class="btn_home" rel="external"><span class="vc">홈</span></a>
		<a href="javascript:history.go(-2)" class="btn_prev" rel="external"><span>이전</span></a>
	</div>
	<div class="in_h2">
	    <h2>후기로 돈 버는 쇼핑<br>사다리와 함께 시작해요!</h2>
	</div>
	<div class="wrapper">
		<form name="form1" action="/front/login.php" method="post">
		<input type="hidden" name="type" value="" />
		<?if($_data->ssl_type=="Y" && strlen($_data->ssl_domain)>0 && strlen($_data->ssl_port)>0 && $_data->ssl_pagelist["LOGIN"]=="Y") {?>
		<input type="hidden" name="shopurl" value="<?=getenv("HTTP_HOST")?>" />
		<IFRAME id="loginiframe" name="loginiframe" style="display:none;" /></IFRAME>
		<?}?>
		<div class="kjku">
		<h3>아이디</h3>
		<input type="text" class="id" name="id" title="아이디" placeholder="아이디 입력" value="<?=$_COOKIE[save_id]?>" />
		<h3 class="h3_12">비밀번호</h3>
		<input type="password" class="password oopp" name="passwd" title="비밀번호" placeholder="비밀번호 입력" value="<?=$save_pw?>" onkeydown="javascript: if (event.keyCode == 13) {CheckForm();}" />
		</div>
		<!--<div class="save_id"><input type="checkbox" name="id_check" class="input_check" id="saveid" value="Y" <? if(!empty($save_id)) echo "checked"; ?>><label for="saveid">아이디 저장</label></div>-->

		<div class="login_bt" onClick="CheckForm()">로그인</div>

		<?
			if(substr($chUrl,-9)=="order.php") {
				if($_data->member_buygrant=="U" && ( ereg("order.php",$chUrl) || ereg("order3.php",$chUrl) ) ) {
		?>
		<!-- 모바일 바로구매 관련 연결링크 수정함 2016-04-07 Seul-->
		<a href="order.php<?=$orderParm?>" rel="external" style="display:block;" class="login_bt">비회원구매</a>
		<?
				}
			}
		?>
    <style type="text/css">
        #top{display:none;}
        .h_area2{height:14vw;background:#fff;}
        .in_h2{text-align:center;font-size:3.333vw;color:#766DC1;margin:24.333vw 0 10vw;}
        #login .wrapper{padding:0;}
        #login .login_bt{line-height:0;position:absolute;bottom:0;width:100%;height:16.666vw;line-height:16.666vw;background:#766dc1;}
        form>input{margin-top:3.333vw;}
        #login .save_id label{width:20%;position:absolute;left:50%;top:74%;transform:translate(-50%,-74%);line-height:8.888vw;display:flex;justify-content: space-around}
        label:after,label:before{display:none;}
        #login input[type='text'], #login input[type='password']{border:none;border-bottom:1px solid #ddd;padding:0;}
        .h3_12{margin-top:20.333vw;color:#766DC1;}
        .kjku{width:90%;margin:0px auto;}
        .oopp{border-bottom:2px solid #766dc1;}
        .basic_btn_area>a{display:block;width:100%;}
        .basic_btn_area>a:nth-child(1){color:#C87271;margin:18vw 0 3.333vw;}
        .basic_btn_area>a:nth-child(1) span{color: #666;}
        .basic_btn_area>a:nth-child(2){color: #666;}
        .ddde{height:40vw;width:100%; display: none} 
        </style>
		<div class="basic_btn_area">
			<!--<a href="member_join.php" rel="external">사다리 회원이 아니라면? <span>회원가입</span></a>-->
			<a href="Description_1.html" rel="external">사다리 회원이 아니라면? <span>회원가입</span></a>
			<a href="./findpwd.php" rel="external">아이디/비밀번호 찾기</a>
		</div>
		<div class="ddde"></div>

		
		<?php if ($_data->sns_login_type == "Y" && count($arSnsinfo) > 0) { ?>
		<!-- SNS 로그인 버튼 -->
		<ul class="int_ul">
			<?php
			if ($arSnsinfo["nhn"]["state"] == "Y") {
				echo "<li>".$naver->login()."</li>";
			}
			if ($arSnsinfo["kko"]["state"] == "Y") {
				echo "<li>".$kakao->login()."</li>";
			}
			if ($arSnsinfo["fb"]["state"] == "Y") {
				echo "<li>".$facebook->login()."</li>";
			}
			?>
		</ul>
		<?php } ?>
	

	<? } ?>
	</div>
</div>




<script type="text/javascript">
<!--
function CheckForm() {

	try {
		if(document.form1.id.value.length==0) {
			alert("회원 아이디를 입력하세요.");
			document.form1.id.focus();
			return;
		}
		if(document.form1.passwd.value.length==0) {
			alert("비밀번호를 입력하세요.");
			document.form1.passwd.focus();
			return;
		}
		document.form1.target = "";
		<?if($_data->ssl_type=="Y" && strlen($_data->ssl_domain)>0 && strlen($_data->ssl_port)>0 && $_data->ssl_pagelist["LOGIN"]=="Y") {?>
		if(typeof document.form1.ssllogin!="undefined"){
			if(document.form1.ssllogin.checked==true) {
				document.form1.target = "loginiframe";
				document.form1.action='https://<?=$_data->ssl_domain?><?=($_data->ssl_port!="443"?":".$_data->ssl_port:"")?>/<?=RootPath.SecureDir?>login.php';
			}
		}
		<?}?>
		document.form1.submit();
	} catch (e) {
		alert("로그인 페이지에 문제가 있습니다.\n\n쇼핑몰 운영자에게 문의하시기 바랍니다.");
	}
}

function CheckOrder() {
	if(document.form1.ordername.value.length==0) {
		alert("주문자 이름을 입력하세요.");
		document.form1.ordername.focus();
		return;
	}
	if(document.form1.ordercodeid.value.length==0) {
		alert("주문번호 6자리를 입력하세요.");
		document.form1.ordercodeid.focus();
		return;
	}
	if(document.form1.ordercodeid.value.length!=6) {
		alert("주문번호는 6자리입니다.\n\n다시 입력하세요.");
		document.form1.ordercodeid.focus();
		return;
	}
	document.form2.ordername.value=document.form1.ordername.value;
	document.form2.ordercodeid.value=document.form1.ordercodeid.value;
	window.open("about:blank","orderpop","width=610,height=500,scrollbars=yes");
	document.form2.submit();
}

	

function order(){
	var _form = document.orderForm;
	if(_form.ordername.value == ""){
		alert("주문자명을 입력해주세요.");
		_form.ordername.focus();
		return;
	}else if(_form.ordercodeid.value == ""){
		alert("주문번호를 입력해주세요.");
		_form.ordercodeid.focus();
		return;

	}
	window.open("about:blank","orderpop");
	document.orderForm.submit();
}

$(document).ready(function() {
	document.form1.id.focus();

	$(".input_pw").keydown(function(e){
		if(e.keyCode == 13){
			CheckForm();
		}
	});
});
//->
</script>
