<?
	$Dir="../";
	include_once($Dir."lib/init.php");
	include_once($Dir."lib/lib.php");
	//include_once($Dir."lib/cache_product.php");
	include_once($Dir."lib/shopdata.php");
	include_once($Dir."lib/ext/product_func.php");
	include_once($Dir."lib/ext/member_func.php");
	include_once($Dir."lib/class/class.category.php");

	//모바일에서 접근시 모바일 버전 상품목록으로 이동
	if(eregi("PSP|Symbian|Nokia|LGT|mobile|Mobile|Mini|iphone|SAMSUNG|Windows Phone|Android|Galaxy", $_SERVER['HTTP_USER_AGENT'])) {
		echo("<script>location.replace('".$Dir."m/productlist.php?code=".$_REQUEST['code']."');</script>");
	}

	// 카테고리 클래스
	$categoryClass = new category;
	$category = json_decode($categoryClass->getCategory());

	if($_REQUEST['listtype']) $_SESSION['PAGETYPE'] = $_REQUEST['listtype'];
	if(!$_SESSION['PAGETYPE']) $_SESSION['PAGETYPE'] = "n"; //n : 기본형태, l : 빠른주문형태
	if(!$_ShopInfo->getMemid()) $_SESSION['PAGETYPE'] = "n"; //비회원은 일반형태로만

	$rcode=$_REQUEST["code"];
	$prd_category = json_decode($categoryClass->getCategoryFromPrdCode($rcode, TRUE));
	if(strlen($rcode)==0) {
		Header("Location:".$Dir.MainDir."main.php");
		exit;
	}

	$selfcodefont_start = "<font class=\"prselfcode\">"; //진열코드 폰트 시작
	$selfcodefont_end = "</font>"; //진열코드 폰트 끝

	$code = '';
	$likecode='';
	for($i=0;$i<4;$i++){
		$tcode = substr($rcode,$i*3,3);
		if(strlen($tcode) != 3 || $tcode == '000'){
			$tcode = '000';
		}else{
			$likecode.=$tcode;
		}
		${'code'.chr(65+$i)} = $tcode;
		$code.=$tcode;
	}

	function getCodeLoc($code,$color1="9E9E9E",$color2="9E9E9E") {
		global $_ShopInfo, $Dir,$code;
		$naviitem = array();
		array_push($naviitem,"<A HREF=\"".$Dir.MainDir."main.php\"><span style=\"color:".$color1.";\">홈</span></A>&nbsp;");

		for($i=0;$i<4;$i++){
			$tmp = array();

			$getsub = ($GLOBALS['code'.chr(65+$i)] == '000');
			$tmp = getCategoryItems(substr($code,0,$i*3),true);
			if(is_array($tmp) && count($tmp) > 0 && count($tmp['items']) > 0){
				$str = '&nbsp;<select name="code'.chr(65+$i).'"  id="code'.chr(65+$i).'" onChange="javascript:chgNaviCode('.$i.')">';
				if($tmp['depth'] != $i){
					exit('System Error');
				}
				$sel = '';
				if($getsub)  $str .= '<option value="">전체</option>';
				foreach($tmp['items'] as $item){
					if($sel != 'ok'){
						for($j=0;$j<=$i;$j++){
							if($j >0 && $sel != 'selected') break;
							if($item['code'.chr(65+$j)] == $GLOBALS['code'.chr(65+$j)]) $sel = 'selected';
							else $sel = '';
						}
					}

					if($sel == 'selected'){
						$str .= '<option value="'.$item['code'.chr(65+$i)].'" selected>'.$item['code_name'].'</option>';
						$sel = 'ok';
					}else{
						$str .= '<option value="'.$item['code'.chr(65+$i)].'" >'.$item['code_name'].'</option>';
					}
				}
				$str .= '</select>';
				array_push($naviitem,$str);
			}
			if($getsub) break;
		}
		return implode('&nbsp;<span style=\'color:'.$color1.';\'>&gt;</span>',$naviitem);
	}
// search by alice [START]
	$search_bridx = $_REQUEST["search_bridx"];
	$search_price_s = $_REQUEST["search_price_s"];
	$search_price_e = $_REQUEST["search_price_e"];
	$search_color_idx = $_REQUEST["search_color_idx"];
	$searchkey = $_REQUEST["searchkey"];

	//브랜드
	$brand_sql = "SELECT bridx, brandname FROM tblproductbrand WHERE 1=1";
	$brand_sql .= " ORDER BY brandname ";
	$brand_result = mysql_query($brand_sql,get_db_conn());
	$brand_count = mysql_num_rows($brand_result);

	//상품색상
	$color_sql = "SELECT color_idx, color_name FROM tblproductcolor WHERE enabled = 'Y' ORDER BY color_idx ";
	$color_result = mysql_query($color_sql,get_db_conn());
// search by alice [ END ]

	$_cdata="";
	$sql = "SELECT * FROM tblproductcode WHERE codeA='".$codeA."' AND codeB='".$codeB."' ";
	$sql.= "AND codeC='".$codeC."' AND codeD='".$codeD."' ";
	$result=mysql_query($sql,get_db_conn());
	if($row=mysql_fetch_object($result)) {
		//접근가능권한그룹 체크
		if($row->group_code=="NO") {
			echo "<html></head><body onload=\"location.href='".$Dir.MainDir."main.php'\"></body></html>";exit;
		}
		if(strlen($_ShopInfo->getMemid())==0) {
			if(strlen($row->group_code)>0) {
				echo "<html></head><body onload=\"location.href='".$Dir.FrontDir."login.php?chUrl=".getUrl()."'\"></body></html>";exit;
			}
		} else {
			//if($row->group_code!="ALL" && strlen($row->group_code)>0 && $row->group_code!=$_ShopInfo->getMemgroup()) {
			if(strlen($row->group_code)>0 && strpos($row->group_code,$_ShopInfo->getMemgroup())===false) {	//그룹회원만 접근
				echo "<html></head><body onload=\"alert('해당 카테고리 접근권한이 없습니다.');location.href='".$Dir.MainDir."main.php'\"></body></html>";exit;
			}
		}
		$_cdata=$row;

		// 미리보기
		if( @!preg_match( 'U', $_cdata->list_type ) AND $preview===true ) {
			$_cdata->list_type = $_cdata->list_type."U";
		}
	} else {
		echo "<html></head><body onload=\"location.href='".$Dir.MainDir."main.php'\"></body></html>";exit;
	}
	mysql_free_result($result);


	$sort=$_REQUEST["sort"];
	$listnum=(int)$_REQUEST["listnum"];

	if($listnum<=0) $listnum=$_data->prlist_num;

	//리스트 세팅
	$setup[page_num] = 10;
	$setup[list_num] = $listnum;

	$block=$_REQUEST["block"];
	$gotopage=$_REQUEST["gotopage"];

	if ($block != "") {
		$nowblock = $block;
		$curpage = $block * $setup[page_num] + $gotopage;
	} else {
		$nowblock = 0;
	}

	if (($gotopage == "") || ($gotopage == 0)) {
		$gotopage = 1;
	}

	$sql = "SELECT codeA, codeB, codeC, codeD FROM tblproductcode ";
	if(strlen($_ShopInfo->getMemid())==0) {
		$sql.= "WHERE group_code!='' ";
	} else {
		//$sql.= "WHERE group_code!='".$_ShopInfo->getMemgroup()."' AND group_code!='ALL' AND group_code!='' ";
		$sql.= "WHERE group_code NOT LIKE '%".$_ShopInfo->getMemgroup()."%' AND group_code!='' ";
	}
	$result=mysql_query($sql,get_db_conn());
	$not_qry="";
	while($row=mysql_fetch_object($result)) {
		$tmpcode=$row->codeA;
		if($row->codeB!="000") $tmpcode.=$row->codeB;
		if($row->codeC!="000") $tmpcode.=$row->codeC;
		if($row->codeD!="000") $tmpcode.=$row->codeD;
		$not_qry.= "AND a.productcode NOT LIKE '".$tmpcode."%' ";
	}
	mysql_free_result($result);

	$qry = "WHERE 1=1 ";
	if(eregi("T",$_cdata->type)) {	//가상분류
		$sql = "SELECT productcode FROM tblproducttheme WHERE code LIKE '".$likecode."%' ";
		if(strlen($_cdata->sort)==0 || $_cdata->sort=="date" || $_cdata->sort=="date2") {
			$sql.= "ORDER BY date DESC ";
		} else if($_cdata->sort=="date3") {
			//역순일 때 2016-08-26 Seul
			$sql.= "ORDER BY date ASC ";
		}
		$result=mysql_query($sql,get_db_conn());
		$t_prcode="";
		while($row=mysql_fetch_object($result)) {
			$t_prcode.=$row->productcode.",";
			$i++;
		}
		mysql_free_result($result);

		//추가 카테고리가 있는지 체크
		$sql = "SELECT productcode FROM tblcategorycode WHERE categorycode LIKE '".$likecode."%' ";
		$result=mysql_query($sql,get_db_conn());
		while($row=mysql_fetch_object($result)) {
			$t_prcode.=$row->productcode.",";
			$i++;
		}
		mysql_free_result($result);
		//# 추가 카테고리가 있는지 체크

		$t_prcode=substr($t_prcode,0,-1);
		$t_prcode=ereg_replace(',','\',\'',$t_prcode);
		$qry.= "AND a.productcode IN ('".$t_prcode."') ";

		$add_query="&code=".$code;
	} else {	//일반분류
		//$qry.= "AND a.productcode LIKE '".$likecode."%' ";

		//추가 카테고리가 있는지 체크
		/*
		$sql = "SELECT productcode FROM tblcategorycode WHERE categorycode LIKE '".$likecode."%' ";

		$result=mysql_query($sql,get_db_conn());
		$prcode="";
		while($row=mysql_fetch_object($result)) {
			$prcode.=$row->productcode.",";
			$i++;
		}
		mysql_free_result($result);
		$prcode=substr($prcode,0,-1);
		$prcode=ereg_replace(',','\',\'',$prcode);
		$qry.= "AND a.productcode IN ('".$prcode."') ";
		$add_query="&code=".$code;*/
		$qry.= "AND cc.categorycode LIKE '".$likecode."%' ";
	//	echo $qry;
		$add_query="&code=".$code;
	}
	$qry.="AND a.display='Y' ";
	//echo $qry;


	//입점업체 관리자 설정 가져오기
	$venderSetSql="SELECT * FROM shop_more_info";
	$venderSetResult=mysql_query($venderSetSql,get_db_conn());
	$venderSetSetting=mysql_fetch_object($venderSetResult);


	//현재위치
	$codenavi=getCodeLoc($code);

	$PAGE_TITLE = !_empty($_cdata->code_name)?'['.$_cdata->code_name.']':"카테고리";
	include_once($Dir."lib/header.php");

	//상품목록 디자인
	$design_sql="SELECT type FROM tbldesignnewpage WHERE type='prlist'";
	$design_result=mysql_query($design_sql,get_db_conn());
	$design_row=mysql_fetch_object($design_result);
	if($design_row->type == 'prlist'){
		echo "<link rel='stylesheet' type='text/css' href='".$Dir."data/design_user/css/user_list.css' />\n";
	}else{
		echo "<link rel='stylesheet' type='text/css' href='".$Dir."css/list.css' />\n";
	}

	//섬네일 효과 설정값 가져오기
	$preffect_sql="SELECT primg_effect, range_effect, radius_use, radius_value, radius_position FROM tblshopinfo";
	$preffect_result=mysql_query($preffect_sql,get_db_conn());
	$preffect_row=mysql_fetch_object($preffect_result);
	$prradius_position=explode(",",$preffect_row->radius_position);

	//이미지 라운드 효과 적용
	if($preffect_row->radius_use=='Y' && $preffect_row->radius_value>0){
		$prradius1=($prradius_position[1]=="Y"?$preffect_row->radius_value:"0");
		$prradius2=($prradius_position[2]=="Y"?$preffect_row->radius_value:"0");
		$prradius3=($prradius_position[4]=="Y"?$preffect_row->radius_value:"0");
		$prradius4=($prradius_position[3]=="Y"?$preffect_row->radius_value:"0");
		$prradius="border-radius:".$prradius1."px ".$prradius2."px ".$prradius3."px ".$prradius4."px;overflow:hidden;";
	}
?>
<body<?=(substr($_data->layoutdata["MOUSEKEY"],0,1)=="Y"?" oncontextmenu=\"return false;\"":"")?><?=(substr($_data->layoutdata["MOUSEKEY"],1,1)=="Y"?" ondragstart=\"return false;\" onselectstart=\"return false;\"":"")?> leftmargin="0" marginwidth="0" topmargin="0" marginheight="0"><?=(substr($_data->layoutdata["MOUSEKEY"],2,1)=="Y"?"<meta http-equiv=\"ImageToolbar\" content=\"No\">":"")?>
<?
	include ($Dir.MainDir.$_data->menu_type.".php");

	if(strlen($_cdata->list_type)==5) {
		include($Dir.TempletDir."product/list_".$_cdata->list_type.".php");
	} else if (strlen($_cdata->list_type)==6 && substr($_cdata->list_type,5,6)=="U") {
		//leftmenu : 적용여부
		$tmp = categorySubTab($code);
		$_ndata = NULL;
		do{
			$chkcode = '';
			for($i=0;$i<4;$i++) $chkcode .= ($i < $tmp['depth'])?$tmp['code'.chr(65+$i)]:'000';
			if($tmp['depth'] == 0){
				$sql = "SELECT leftmenu,body,code FROM ".$designnewpageTables." WHERE type='prlist' AND (code='".$chkcode."' OR code='ALL') AND leftmenu='Y' ORDER BY code ASC LIMIT 1 ";
				$result=mysql_query($sql,get_db_conn());
			}else{
				//$sql = "SELECT leftmenu,body,code FROM ".$designnewpageTables." WHERE type='prlist' AND (code='".$chkcode."' OR code='ALL') AND leftmenu='Y' ORDER BY code ASC LIMIT 1 ";
				$sql = "SELECT leftmenu,body,code FROM ".$designnewpageTables." WHERE type='prlist' AND (code='".$chkcode."') AND leftmenu='Y' ORDER BY code ASC LIMIT 1 ";
				$result=mysql_query($sql,get_db_conn());
			}
		
			if(mysql_num_rows($result)){
				$_ndata=mysql_fetch_object($result);
			}else{
				if($tmp['depth'] == 0) break;
				$csql = "select dsameparent from tblproductcode where codeA='".$tmp['codeA']."' and codeB='".$tmp['codeB']."' and codeC='".$tmp['codeC']."' and codeD='".$tmp['codeD']."' limit 1";				
				$cresult = mysql_query($csql);
				if($cresult && mysql_num_rows($cresult) && mysql_result($cresult,0,0) == '1'){
					$tmp['depth'] -= 1;
					$tmp['code'.chr(65+$tmp['depth'])] = '000';
					continue;
				}
				$tmp['depth'] = 0;
			}
		}while(empty($_ndata) && $tmp['depth'] >= 0);
		mysql_free_result($result);
		if($_ndata) {
			$body=$_ndata->body;
			$body=str_replace("[DIR]",$Dir,$body);
			include($Dir.TempletDir."product/list_U.php");
		} else {
			include($Dir.TempletDir."product/list_".substr($_cdata->list_type,0,5).".php");
		}
	}
?>

<script src="/js/jquery.cookie.js"></script>

<form name="form2" method="get" action="<?=$_SERVER[PHP_SELF]?>">
	<input type="hidden" name="listtype" value="<?=$listtype?>" />
	<input type="hidden" name="code" value="<?=$rcode?>" />
	<input type="hidden" name="listnum" value="<?=$listnum?>" />
	<input type="hidden" name="sort" value="<?=$sort?>" />
	<input type="hidden" name="block" value="<?=$block?>" />
	<input type="hidden" name="gotopage" value="<?=$gotopage?>" />
	<input type="hidden" name="search_bridx" value="<?=$search_bridx?>" />
	<input type="hidden" name="search_price_s" value="<?=$search_price_s?>" />
	<input type="hidden" name="search_price_e" value="<?=$search_price_e?>" />
	<input type="hidden" name="search_color_idx" value="<?=$search_color_idx?>" />
	<input type="hidden" name="searchkey" value="<?=$searchkey?>" />
</form>

<form name="codeNaviForm" id="codeNaviForm" action="<?=$_SERVER['PHP_SELF']?>">
	<input type="hidden" name="code" value="" />
</form>

<script type="text/javascript">
//<![CDATA[
	$j('.search_other_brand input').click(function() {
		var obrand = '';
		$j('.search_other_brand input[type=checkbox]:checked').each(function (i) {
			if(obrand != '') { obrand += '|'; }
			if(this.checked){ obrand += ':'+$j(this).val()+':'; }
		});
		$j('form[name="form2"] input[name=search_bridx]').val(obrand);
		$j('form[name="form2"]').submit();
	});
	$j('.btn_search_price').click(function() {
		var sprice = $j(".price input[name=search_price_s]").val();
		var eprice = $j(".price input[name=search_price_e]").val();
		var searchkey = $j(".searchWord input[name=searchkey]").val();
		$j('form[name="form2"] input[name=search_price_s]').val(sprice);
		$j('form[name="form2"] input[name=search_price_e]').val(eprice);
		$j('form[name="form2"] input[name=searchkey]').val(searchkey);
		$j('form[name="form2"]').submit();
	});
	$j('.search_color input').click(function() {
		var cidx = '';
		$j('.search_color input[type=checkbox]:checked').each(function (i) {
			if(cidx != '') { cidx += '|'; }
			if(this.checked){ cidx += ':'+$j(this).val()+':'; }
		});
		$j('form[name="form2"] input[name=search_color_idx]').val(cidx);
		$j('form[name="form2"]').submit();
	});
//]]>
</script>
<script src="/js/product_option.js"></script>

<script type="text/javascript">
	<!--
	function ClipCopy(url) {
		var tmp;
		tmp = window.clipboardData.setData('Text', url);
		if(tmp) {
			alert('주소가 복사되었습니다.');
		}
	}
	
	function ChangeType(val) {
		document.form2.block.value="";
		document.form2.gotopage.value="";
		document.form2.listtype.value=val;
		document.form2.submit();
	}
	
	function ChangeSort(val) {
		document.form2.block.value="";
		document.form2.gotopage.value="";
		document.form2.sort.value=val;
		document.form2.submit();
	}

	function ChangeListnum(val) {
		document.form2.block.value="";
		document.form2.gotopage.value="";
		document.form2.listnum.value=val;
		document.form2.submit();
	}

	function GoPage(block,gotopage) {
		document.form2.block.value=block;
		document.form2.gotopage.value=gotopage;
		document.form2.submit();
	}

	function ChangeNum(obj) {
		document.form2.listnum.value=obj.value;
		document.form2.submit();
	}

	function chgNaviCode(dp){
		var code = '';
		dp = parseInt(dp);
		if(dp > 4) dp = 4
		for(i=0;i<=dp;i++){
			var el = document.getElementById('code'+String.fromCharCode(65+i));
			if(el){
				code += el.options[el.selectedIndex].value;
			}else{
				break;
			}
		}
		document.codeNaviForm.code.value = code;
		document.codeNaviForm.submit();
	}
//-->
</SCRIPT>

<div id="create_openwin" style="display:none;"></div>

<? if($HTML_CACHE_EVENT=="OK") ob_end_flush(); ?>

<? include ($Dir."lib/bottom.php"); ?>