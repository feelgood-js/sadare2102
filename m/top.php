<?
$Dir = "../";
	include_once($Dir."lib/init.php");
	include_once($Dir."lib/lib.php");
	include_once($Dir."lib/shopdata.php");
	include_once($Dir."lib/ext/func.php");
	include_once($Dir."lib/class/pages.php");	  	
	include_once($Dir."lib/venderlib.php");
	include_once($Dir."m/inc/function.php");

	//옵션 클래스 2016-09-26 Seul
	include_once($Dir."lib/class/option.php");
	$optClass = new Option;

	$configSQL = "SELECT * FROM tblmobileconfig ";
	if(false !== $configRes = mysql_query($configSQL,get_db_conn())){	
		$configRow = mysql_fetch_assoc($configRes);

		$usesite = isset($configRow['use_mobile_site'])?trim($configRow['use_mobile_site']):""; // 모바일 사이트 사용여부
		$skinname = isset($configRow['skin'])?trim($configRow['skin']):"basic"; // 모바일 사이트 스킨명
		$skinfile = isset($configRow['skin_css'])?trim($configRow['skin_css']):""; // 모바일 사이트 스킨별 CSS 파일
		$logofile = isset($configRow['logo'])?trim($configRow['logo']):""; // 모바일 사이트 상단 로고파일 명
		$iconfile = isset($configRow['icon'])?trim($configRow['icon']):""; // 모바일 사이트 아이콘 파일 명
		$text_copyright = isset($configRow['copyright_text'])?trim($configRow['copyright_text']):""; //텍스트 하단 카피라이터
		$image_copyright = isset($configRow['copyright_image'])?trim($configRow['copyright_image']):""; // 이미지 하단 카피라이터
		$mainsort = isset($configRow['main_item_sort'])?trim($configRow['main_item_sort']):""; // 메인 정렬 순서
		$productlist_basket = isset($configRow['use_productlist_basket'])?trim($configRow['use_productlist_basket']):"N"; // 상품리스트화면 바로담기기능 사용여부
		$productlist_quick = isset($configRow['use_productlist_quick'])?trim($configRow['use_productlist_quick']):"N"; // 상품리스트화면 하단 퀵버튼 사용여부
		
		mysql_free_result($configRes);
	}

	//모바일사이트 사용여부
	if($usesite=="N"){
		header("Location:/");
		exit;
	}

	$charset = "UTF-8";
	$shopname = $_data->shoptitle;
	$configPATH = $Dir."m/upload/"; //상단 로고, 아이콘, 카피라이트 저장 경로
	$skinPATH = $Dir."m/skin/".$skinname."/";
	$logo = $configPATH.$logofile; // 로고
	$icon = $configPATH.$iconfile; // 아이콘
	$mobliePATH = $Dir."m/";

	//장바구니 상품 카운터
	if(strlen($_ShopInfo->getMemid())==0) {	//비회원
		$basketcount = _basketCount('tblbasket',$_ShopInfo->getTempkey());
	}else{
		$basketcount = _basketCount2('tblbasket',$_ShopInfo->getMemid());
	}

	include($skinPATH."header.php");

	if ($image_copyright != "") {
		$copyright = "<img src=".$configPATH.$image_copyright." border=0 style=\"border-width:1pt; border-color:rgb(235,235,235); border-style:solid;\">";
	} else {
		$copyright = $text_copyright;
	}    

	include_once('location.php'); 


//옐로콘츠 로그인
if($_ShopInfo->getMemid()){
	$sql22 = "SELECT * FROM yc_member AS yc LEFT JOIN tblmember AS l ON yc.m_email = l.email  WHERE l.id='".$_ShopInfo->getMemid()."'";
	$result22 = mysql_query($sql22,get_db_conn());	  	
	if($row22 = mysql_fetch_object($result22)){
		$seq = $row22->seq;
	}
	mysql_free_result($result22);

	$_SESSION['login_id'] = $seq;
	$_SESSION['m_id'] = $_ShopInfo->getMemid();
	$_SESSION['is_login'] = 'Y';		
	$_SESSION['sql22'] = $sql22;

	$eSql = "update yc_member set auto_login='Y' where seq='".$seq."'";	   		 
	mysql_query($eSql,get_db_conn()); 
}
//옐로콘츠 로그인 끝
?>



<!DOCTYPE html>
<html lang="ko">
<head>

<script type="text/javascript">
		<!--
		//카테고리 전체보기
		$(document).ready(function(){
			var sidebar = $('[data-sidebar]');
			sidebar.show(0, function() {
				sidebar.css('transition', 'all 0.3s ease');
			});
		});

		//카테고리 전체보기 메뉴열기(아이폰+크롬 조합에서 미동작 문제 수정)
		function openMenuAll(){
			$('.left_bg').fadeIn();
			$('#left_menu').addClass('on');
			$('body').addClass('lock');
		}
		//-->
	</script>  

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <title>사다리</title>
</head>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/detail.css">
<link href="css/style.css" rel="stylesheet">
<body>
    <header>
        </header>