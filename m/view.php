<?
@session_start();
include_once('top.php'); 
$base_menu = "레더";

$type=$_REQUEST["type"];
$date=$_REQUEST["date"];

switch ($type){
						case "net": 							
							$icon_img_src="/m/img/icc4.png";
							break;
						case "info": 							
							$icon_img_src="/m/img/icc3.png";
							break;
						case "life": 							
							$icon_img_src="/m/img/icc2.png";
							break;
						default :							
							$icon_img_src="/m/img/icc1.png";
							break;
						
}   
				
$sql= "SELECT a.*, b.maximage, b.productname FROM tblproductreview AS a 
LEFT JOIN tblproduct AS b ON a.productcode = b.productcode							
where a.date = $date";			
$result=mysql_query($sql,get_db_conn());
$row=mysql_fetch_object($result);	
$product_image =  "/product/".$row->maximage;
$review_image =  "/productreview/".$row->img;

for($i=1;$i<=5;$i++){
	if($i <= $row->marks){
		$viewstar.='<span>★</span>';
	}else{
		$viewstar.='★';
	}
}    
	
?>
<style type="text/css">
    body{padding-bottom: 20vw;}
    .review{position:relative;}
	.review2 {padding-bottom: 90px}
    .review2>.bbn{margin-top: 0;}
    .review2>.bbn{width:7vw;height:6vw;position:absolute;right:4%;top:120px;transform:translate(4%,-20%);margin-top:0;}
    .bbn>img {width: 100%;}
	#header .in_btn select, #header #gnb_button {display:none}
	#comm .click-comm {line-height: 34px;}
	#comm .click-comm>img {width: 12px; margin-left: 10px;}
	.depth1 li:after, #comm .depth2 li:after, #comm .depth2:after {content:''; display:block; clear:both}
	.depth1 li h4 {width: 12%; padding-bottom: 12%; position:relative; border-radius: 50%; overflow: hidden; float: left;}
	.depth1 li h4 img {height: 100%; position:absolute; left: 50%; top: 50%; transform:translate(-50%,-50%);}
	.depth1 li .txt {width: 85%; float: right;}
	.depth1 li .txt p {display: inline-block; font-size: 12px; line-height: 16px; padding: 3px 10px; border-radius: 5px; background: #eee;}
	.depth1 li .txt p span {display:block; font-weight: bold}
	.depth1 li .txt ul li, .depth2 li li  {width: auto; float: left; line-height: 20px; padding: 3px 10px;}
	.depth1 {margin-top: 10px;}
	.depth2 {width: 100%; padding-left:15%; margin-top: 10px; box-sizing: border-box;}
	.depth2 li {width: 100%}
	.depth2 li h4 {width: 8%; padding-bottom: 8%; position:relative; border-radius: 50%; overflow: hidden; float: left}
	.depth2 li h4 img {width: 100%; position:absolute;}
	.depth2 li .txt {width: 85%; float: right;}
	#comm>div {display:none;}
</style>
<script language="javascript">
	<!--
	function DeleteForm(idx){
		if(!confirm("삭제 하시겠 습니까?")){
			return;
		}
		location.href="lader_write_ok.php?date="+idx+"&mode=delete";
	}
	//-->
</script>

<div class="life_sub">
<div style="position:absolute;top:4px;left:15px;">
<!--<img style="width:20px;" src="<?=$icon_img_src?>">  -->
</div>
    


    <ul>
<?
if($type=="review" && $row->productname){
?>
        <li>
            <div><img width="100%" src="/data/shopimages<?=$product_image?>"></div>
            <div>
                <div class="review">  				
				<p><?=$row->productname?><Br><Br><Br></p>
				
                    <h3>
					<?	  						
						echo "<div style='overflow:hidden;'>";
						echo "	평점 : <p class=\"review_point\" style='float:right;'>".$viewstar."</p>";
						echo "</div>";
					?>
					</h3>
                    <div>
                        <a href="productdetail_tab01.php?productcode=<?=$row->productcode?>&l_id=<?=$row->id?>">구매하러 가기</a>
                    </div> 
					
                </div>
            </div>
        </li>
 <?
}else{

$sql= "SELECT a.*, b.photos, b.my_biz_txt, b.biz_name FROM tblproductreview AS a 
LEFT JOIN yc_biz_info AS b ON a.productcode = b.seq							
where a.date = $date";			
//echo	$sql;
$result=mysql_query($sql,get_db_conn());
$row=mysql_fetch_object($result);	
$expPhoto = explode(",", $row->photos);
if(!$expPhoto[0]) $product_image='/img/no_img.jpg';
else  $product_image='/yc/data/bbs/'.$expPhoto[0];

$review_image =  "/productreview/".$row->img;

for($i=1;$i<=5;$i++){
	if($i <= $row->marks){
		$viewstar.='<span>★</span>';
	}else{
		$viewstar.='★';
	}
}   

?>		  <li onclick="document.location.href='/yc/sub/store-offline.html?seq=<?=$row->productcode?>'">
            <div><img width="100%" src="<?=$product_image?>"></div>
            <div>
                <div class="review">  				
				<p><?=$row->biz_name?><Br><?=$row->my_biz_txt?><Br><Br></p>
				
                    <h3>
					<?	  						
						echo "<div style='overflow:hidden;'>";
						echo "	평점 : <p class=\"review_point\" style='float:right;'>".$viewstar."</p>";
						echo "</div>";
					?>
					</h3>	                      
					
                </div>
            </div>
        </li>

<?
}
 ?>
		<li> 		
		
<?
			if($row->id==$_ShopInfo->memid){		
						echo "<a href='prreview_edit.php?date=$date&mode=edit'><button  style='float:none;' >수 정</button></a>";
						
						echo "<a href='#' onclick='DeleteForm($date);'><button  style='float:none;' >삭 제</button></a>";
			}
?>
		</li>

    </ul>

    </div>
<div class="life_sub2">
    <ul class="sub2_ul">
	<li> 		
		
<?
			if(($row->id==$_ShopInfo->memid) &&$type!="review"){		
						echo "<a href='lader_write.php?date=$date&mode=edit' style='display:none'><button  style='float:none;height:25px;' >수 정</button></a>";
						
						echo "<a href=#' onclick='DeleteForm($date)' style='display:none'><button  style='float:none;height:25px;' >삭 제</button></a>";
			}
?>
		</li>
        <li>
			
            <div>
                <div class="review2">
                    <p><?=date("Y년 m월 d일",strtotime($row->date))?></p>
                    
					<?
					  if($type!="review") echo "<h2>$row->title</h2>";
					?>
                    <p><?
							$content=explode("=",$row->content);
							echo $content[0];
						/*	if(strlen($content[1])>0) {	 //메인은 관리자 뎃글 안보이게
								echo "<br/><img src=\"".$Dir."images/common/review/review_replyicn2.gif\" align=absmiddle border=0> ".nl2br($content[1]);
							}	 */
						
			if ($review_image != '/productreview/'){			  				
			?>
            <div class="sub2_img"><img width="100%" src="/data/shopimages<?=$review_image?>"></div>	 <br>
			<?
				}
			
							if($row->video){
								echo '
									<video width="100%" controls>
									<source src="/data/shopimages/productreview/'.$row->video.'">	  
									</video>
								';
							}
						 ?>
					</p>
					
					<?
						 $sql_hart= "SELECT * ,  COUNT(idx) AS cnt  from ladder_hart where review_date = {$row->date} and id='{$_ShopInfo->getMemid()}'";		
						
							$result_hart=mysql_query($sql_hart,get_db_conn());
							$rs_hart=mysql_fetch_object($result_hart);
						
							if($rs_hart->cnt == 0){
										$hart_img='/m/img/llove.png';
							}	else $hart_img='/m/img/llove2.png';

					?>
                    <div class="bbn"><img src="<?=$hart_img?>" alt="" class="uuo"  id ="uuo" onclick="click_love('<?=$row->date?>');"></div>
					<input type="hidden" id="type" value="<?=$type?>">
					<input type="hidden" id="date" value="<?=$date?>">
					<input type="hidden" id="fid" value="">
					
					
					<div id="comm">
						<p class="click-comm">모든 댓글 <img src="img/arrow.png"></p>
						<div>
						<p style="margin:5px 0">
						<textarea class='txt' id="memo" name=\"memo\" rows='5' style='height:45px;padding:10px;box-sizing:border-box;' maxbyte='1000' required></textarea>
						<button onclick="coment_ok('write');" style="width:14%;height:45px;background:#ccc;display:block;float:right;">덧글</button>
						</p>
						
						 <div id='coment' style="margin-top:0px"><p>&nbsp;</p></div>
						
							<?	 								
								$sql= "SELECT * FROM ladder_coment where review_date='".$date."'							
								 ORDER BY fid, thread asc "; 	   								
								$result=mysql_query($sql,get_db_conn());
								while($row=mysql_fetch_object($result)) {
									$del_button = "";

									if($_ShopInfo->getMemid()==$row->id) $del_button="&nbsp;&nbsp;<button onclick='del(".$row->idx.")' style='height:21px;width:34px;'>삭제</button>"; 

									 //echo "<div style='margin-top:4px' id='coment'><p>".$row->id." - ".$row->content.$del_button."</p></div> ";

									 $img_src = get_member_img($row->id);
									if($img_src=="/data/profile/")	$img_src = './img/la_ic2.png';
									if($row->thread=='AA')	$class = 'depth2';
									else  $class = 'depth1';
									
								?>
									<ul class="<?=$class?>">
										<li>
											<h4><img src="<?=$img_src?>"></h4>
											<div class="txt">
												<p><span><b><?=$row->id?></b></span>&nbsp;&nbsp;<?=$row->content?></p>
												<ul>
													<li><?=regist_date($row->date)?></li>
													<li onclick="reply('<?=$row->id?>','<?=$row->fid?>')">답글달기</li>
													<li><?=$del_button?></li>
												</ul>
											</div>
										</li>
									</ul>
								<?

								}	  

								mysql_free_result($result);											
								
							?>										

						
						
					
					</div>
                    <div>
                       <!-- <a href="#">구성</a>
                        <a href="#">내용확정</a>	   -->
                    </div>
                </div>
            </div>
        </li>
    </ul>
    </div>
<?
$menu_set = 'ladder';	  
include_once('footer.php');
?>
</body>
</html>   
<script>
function reply(m_id,fid){	
	  document.getElementById("memo").value = m_id+"--";
	  document.getElementById("fid").value=fid;
	  document.getElementById("memo").focus();
}
function coment_ok(mode)	{ 
	var type = document.getElementById("type").value;
    var date = document.getElementById("date").value;
	var memo = document.getElementById("memo").value;
	var fid = document.getElementById("fid").value;
	if(memo==""){
		alert("내용을 입력하세요")	;
			document.getElementById("memo").focus();
			return;
	}

	var array = memo.split("--");	   
	if(array.length==2){
		if(array[1]==""){
			alert("내용을 입력하세요")	;
			document.getElementById("memo").focus();
			return;
		}
	}
	

	$.ajax({
		type : "GET",
		url : "ladder_coment.php?mode="+mode+"&date="+date+"&memo="+memo+"&type="+type+"&fid="+fid,
		dataType : "text",
		error : function()	{
			console.log('통신실패!!');
		},
		success : function(data)	{
//			console.log('통신성공!!');
			$("#coment").html(data);
		}
	});
}   

function del(idx)	{ 
	var type = document.getElementById("type").value;
    var date = document.getElementById("date").value;
	var memo = document.getElementById("memo").value;

	$.ajax({
		type : "GET",
		url : "ladder_coment.php?mode=dell&date="+date+"&memo="+memo+"&type="+type+"&idx="+idx,
		dataType : "text",
		error : function()	{
			console.log('통신실패!!');
		},
		success : function(data)	{
//			console.log('통신성공!!');
			$("#coment").html(data);
		}
	});
}

function click_love(date)	{ 		 

	$.ajax({
		type : "GET",
		url : "ajax.click_love.php",
		dataType : "text",
		data:{date:date},
		error : function()	{
			console.log('통신실패!!');
//			console.log(data);
		},
		success : function(data)	{
//			console.log('통신성공!!');
			data = $.trim(data);
			if(data=="INSERT"){	
				$("#uuo").attr("src", '/m/img/llove2.png');		  				
			}else if(data=="DELETE"){
				$("#uuo").attr("src", '/m/img/llove.png');						
			}
			console.log(data);
			
//			$("#coment").html(data);
		}
	});
}  
 /*
 $(function(){
        $('.bbn').click(function() {
  var clicks = $(this).data('clicks');
  if (clicks) {
    $('.uuo').attr('src', '/m/img/llove.png');
  } else {
     $('.uuo').attr('src', '/m/img/llove2.png');
  }
  $(this).data("clicks", !clicks);
});
    })
*/	

$('.click-comm').click(function() {
	  $('#comm>div').slideToggle(300);
	});
</script>

     