<?
if(substr(getenv("SCRIPT_NAME"),-15)=="/mobile_eventlayer.php"){
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(is_array($_layerdata)) {	//상단 이벤트 팝업에서 이미 쿼리를 하였다.
?>
	<script language="javascript">
		var AllList=new Array();

		function LayerList() {
			var argv = LayerList.arguments;   
			var argc = LayerList.arguments.length;
			
			this.classname		= "LayerList";
			this.debug			= false;
			this.id				= new String((argc > 0) ? argv[0] : "");
			this.val			= new String((argc > 1) ? argv[1] : "");
			this.time			= new String((argc > 2) ? argv[2] : "");
		}

		function p_windowclose(pID, bSetCookie) {
			for(i=0;i<AllList.length;i++){
				if(pID==AllList[i].id) {
					document.all[pID].style.visibility="hidden";
					if (bSetCookie=="1"){
						expire = new Date();
						if(parseInt(AllList[i].time)==2) {
							expire.setTime(Date.parse(expire) + 1000*60*60*24*30);
							document.cookie = AllList[i].id + "=" + escape(AllList[i].val) + ";expires=" + expire.toGMTString() + ";path=/<?=RootPath?>;";
						} else if(parseInt(AllList[i].time)==1) {
							expire.setTime(Date.parse(expire) + 1000*60*60*24*parseInt(AllList[i].time));
							document.cookie = AllList[i].id + "=" + escape(AllList[i].val) + ";expires=" + expire.toGMTString() + ";path=/<?=RootPath?>;";
						} else {
							document.cookie = AllList[i].id + "=" + escape(AllList[i].val) + ";path=/<?=RootPath?>;";
						}
					}
					break;
				}			
			}
		}

		function p_windowopen(pID, pVal, pTime){
			if(pVal!=getCookie(pID)) {
				layerlist=new LayerList();
				layerlist.id=pID;
				layerlist.val=pVal;
				layerlist.time=pTime;
				AllList[AllList.length]=layerlist;
				layerlist=null;

				document.all[pID].style.visibility="visible";
			}
		}
	</script>

	<style>
		.mobile_pop_contents img{max-width:100%;height:auto;max-height:100%;}
	</style>

<?
	$layer_str="";
	for($i=0;$i<count($_layerdata);$i++){
		if($_layerdata[$i]->frame_type=="0"){
			$cookiename="eventpopup_".$_layerdata[$i]->num;
			if($_layerdata[$i]->end_date!=$_COOKIE[$cookiename]){
				$row=$_layerdata[$i];
				$layer="Y";
				$one=2;
				$layer_str.= "p_windowopen('".$cookiename."','".$_layerdata[$i]->end_date."','".$_layerdata[$i]->cookietime."');\n";

				echo "<div id=\"".$cookiename."\" class='mobile_pop_contents' style=\"display:table;POSITION:fixed;TOP:0px;LEFT:0px;WIDTH:100%;HEIGHT:100%;overflow:hidden;z-index:1000;\">\n";
				include($Dir.TempletDir."event/mobileevent".$_layerdata[$i]->design.".php");
				echo "</div>\n";
			}
		}
	}
	if(strlen($layer_str)>0) {
		echo "<script>\n";
		echo $layer_str;
		echo "</script>\n";
	}
}
?>