<?php
if(substr(getenv("SCRIPT_NAME"),-9)=="/init.php") {
	header("HTTP/1.0 404 Not Found");
	exit;
}
$install_state = false;
header("Content-Type: text/html; charset=UTF-8");
ini_set("display_errors",	0);
ini_set("error_reporting",	E_ALL);

define("DirPath",		$Dir);
define("RootPath",		"");

define("AdminDir",		"admin/");
define("MAdminDir",		"admin_m/");
define("MainDir",		"main/");
define("AdultDir",		"adult/");
define("AuctionDir",	"auction/");
define("BoardDir",		"board/");
define("FrontDir",		"front/");
define("GongguDir",		"gonggu/");
define("PartnerDir",	"partner/");
define("RssDir",		"rss/");
define("TempletDir",	"templet/");
define("SecureDir",		"ssl/");
define("VenderDir",		"vender/");
define("CashcgiDir",	"cash.cgi/");
define("AuthkeyDir",	"authkey/");
define("ImageDir",		"images/");
define("DataDir",		"data/");
define("TodaySaleDir",	"todayshop/");
define("MobileDir",		"m/");
define("JsDir",			"js/");


define("MinishopType",	"OFF");
/* 엑셀업로드 구매 방식 사용여부  ON/OFF */
define("Excelbuy",			"OFF");
define("B2B",			    "B2B/");            //엑셀업로드 폴더

#암호/복호화 키입니다. (해당 쇼핑몰에서 꼭 수정하시기 바랍니다.)
$password = crypt('mypassword');
define("enckey",		"password");
//define("enckey",		$password);

#시스템 관리자 메일
define("AdminMail", "cs@objet.co.kr");

//세션관련 로그인이 제대로 되지 않을경우 최상위의 tempss 폴더의 권한 설정확인
//사용시간을 늘리고자 하실때 $lifttime = 60 * 60 * 1 <== 1(한시간) 늘려주세요.
$_SESSION_LIFETIME = 60*60*2020;
//session_save_path($Dir."session_file");			  /*옐로콘즈 때문에 없앰*/
ini_set("session.cache_expire", $_SESSION_LIFETIME); // 세션 유효시간 : 분
ini_set("session.gc_maxlifetime", $_SESSION_LIFETIME); // 세션 가비지 컬렉션(로그인시 세션지속 시간) : 초
//set_time_limit(0);
session_cache_expire($_SESSION_LIFETIME);
@session_start();

$base_url  = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];
//$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

// 기본 사이트 url
define("BaseUrl", $base_url);


// 도매 가격 적용 상품 아이콘
$wholeSaleIconSet = "<img src='/images/common/wholeSaleIcon.gif' style=\"position:relative; top:0.2em;\" alt='' />";

//  벤더 대표 이미지 경로
$com_image_url = $Dir."data/shopimages/vender/";		

function album_star_chk($star_num) {
		if($star_num == 0) {
			$star_cnt = 0;
		} else 	if($star_num > 0 && $star_num < 1) {
			$star_cnt = '1';
		} else if($star_num >= 1 && $star_num < '1.5') {
			$star_cnt = '2';
		} else if($star_num >= '1.5' && $star_num < '2.0') {
			$star_cnt = 3;
		} else if($star_num >= 2 && $star_num < '2.5') {
			$star_cnt = 4;
		} else if($star_num >= '2.5' && $star_num < 3) {
			$star_cnt = 5;
		} else if($star_num >= 3 && $star_num < '3.5') {
			$star_cnt = 6;
		} else if($star_num >= '3.5' && $star_num < 4) {
			$star_cnt = 7;
		} else if($star_num >= 4 && $star_num < '4.5') {
			$star_cnt = 8;
		} else if($star_num >= '4.5' && $star_num < 5) {
			$star_cnt = 9;
		} else if($star_num >= 5) {
			$star_cnt = 10;
		}

		return $star_cnt;
}  


function get_member_img($mb_id){
	$page_sql= "SELECT profile_photo FROM tblmember where id= '{$mb_id}'";
	$rs=mysql_query($page_sql,get_db_conn());
	$row=mysql_fetch_object($rs);  
	$img = $row->profile_photo;	
	mysql_free_result($rs);
	return '/data/profile/'.$img;
}

//옐로콘츠 회원 정보와 기존 회원정보의 email를 비교해서 회원 id 찾아온다
function marge_member($m_seq){
	$page_sql = "SELECT * FROM tblmember AS a LEFT JOIN yc_member AS b ON a.email = b.m_email WHERE b.seq = '{$m_seq}'";
	//echo $page_sql;
	$rs=mysql_query($page_sql,get_db_conn());
	$row=mysql_fetch_object($rs);  
	
	return $row;
}

function strcut_utf8($str, $len, $checkmb=false, $tail='...') { 
  preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match); 
  $m    = $match[0]; 
  $slen = strlen($str);  // length of source string 
  $tlen = strlen($tail); // length of tail string 
  $mlen = count($m);    // length of matched characters 

  if ($slen <= $len) return $str; 
  if (!$checkmb && $mlen <= $len) return $str; 
  
  $ret  = array(); 
  $count = 0; 
  
  for ($i=0; $i < $len; $i++) { 
    $count += ($checkmb && strlen($m[$i]) > 1)?2:1; 
    if ($count + $tlen > $len) break; 
    $ret[] = $m[$i]; 
  } 
  return join('', $ret).$tail; 
} 

function regist_date($registDatetime) {
	$regist_time = strtotime($registDatetime);
	$reg_time = time() - strtotime($registDatetime);
	if($reg_time < 60) {
		$reg_date = $reg_time;
		$str = '초전';
	} else 	if($reg_time < 3600) {
		$reg_date = ceil($reg_time / 60);
		$str = '분전';
	} else 	if($reg_time < 86400) {
		$reg_date = ceil($reg_time / 3600);
		$str = '시간전';
	} else if($reg_time < 2592000) {
		$reg_date = ceil($reg_time / 86400);
		$str = '일전';
	} else if($reg_time < 31536000) {
		$reg_date = ceil($reg_time / 2592000);
		$str = '개월전';
	} else { 
		$reg_date= round($reg_time / 31536000);
		$str = '년전';
	}
	
	$regist_date = $reg_date.$str;


	return $regist_date;
}

?>