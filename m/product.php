<?
include_once('top.php'); 
$base_menu = "판매";
include_once('location.php'); 



?>
 <script>
$('.tab2_tab2').css({   
    color: "darkred"
}); 
</script>
<style>
	.swiper-slide{border:none;}
    .jl6{overflow: hidden;
	text-overflow: ellipsis;
	word-wrap: break-word;
	display: -webkit-box;
	-webkit-line-clamp: 3; /* ellipsis line */
	-webkit-box-orient: vertical;

	/* webkit 엔진을 사용하지 않는 브라우저를 위한 속성. */
	/* height = line-height * line = 1.2em * 3 = 3.6em  */
	line-height: 1.2em;
	height: 2.4em;}
	#header .in_btn select {display:none;}
	a.back {display: none}
    .top_move{z-index: 9999;}
</style>
 <!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="/js/magnific-popup.css">
<!-- Magnific Popup core JS file -->
<script src="/js/jquery.magnific-popup.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.modal_movie').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	});

    $(function(){
        /*웹페이지 열었을 때*/
            $(".img1").show();
            $(".img2").hide();
 
            /*img1을 클릭했을 때 img2를 보여줌*/
            $(".img1").click(function(){
                $(".img1").hide();
                $(".img2").show();
            });
        
         /*img1을 클릭했을 때 img2를 보여줌*/
            $(".img2").click(function(){
                $(".img2").hide();
                $(".img1").show();
            });
    });



 if (!navigator.geolocation) {
        alert('<p>사용자의 브라우저는 위치기반 서비스를 지원하지 않습니다.</p>');
        return;
    }
	 navigator.geolocation.getCurrentPosition(function(position) {
		console.log(position);
		
		//sessionStorage.removeItem("latitude");
		//sessionStorage.removeItem("longitude");

		sessionStorage.setItem("latitude",  position.coords.latitude);
		sessionStorage.setItem("longitude", position.coords.longitude);       
		
		//sessionStorage.removeItem("latitude");
		//sessionStorage.removeItem("longitude");		
        //setLocSession(latitude, longitude);

      }, function(error) {
        console.error(error);
      }, {
        enableHighAccuracy: false,
        maximumAge: 0,
        timeout: Infinity
      });    

</script>
<!-- 내용 -->
<div id="main">
	<!-- 메인 비주얼 -->
	<div class="top_js">
		    <h3>Welcom to SADARE</h3>
			<p>we want you choice</p>
	</div>
	<div id="main_visual">
		<!-- slide-delay 속성으로 인터벌 조정 및 오토플레이 유무 설정가능 -->
		<div class="swiper-container" slide-delay="5000">
			<div class="swiper-wrapper">
				<?
					$bannerSQL="SELECT * FROM tblmainbanner WHERE position='T' and device = 'M' ORDER BY date DESC";

				//	$bannerSQL="SELECT image,url,target FROM tblmobilebanner WHERE position='visiul' ORDER BY date DESC LIMIT 5";

					$rowcount=0;
					if(false !== $bannerRes = mysql_query($bannerSQL,get_db_conn())){
						$rowcount = mysql_num_rows($bannerRes);
						if($rowcount>0){
							while($bannerRow = mysql_fetch_assoc($bannerRes)){
				?>
							<div class="swiper-slide" style="font-size:0px;line-height:0%;">
							<?
								if($bannerRow['type']=="M"){
									echo "
										<div style=\"position:relative;\">
											<a href='http://www.youtube.com/watch?v=".$bannerRow['movie_url']."' class='modal_movie''>
												<div style='position:absolute;top:50%;left:50%;width:80px;height:80px;margin-left:-40px;margin-top:-40px;font-size:0px;line-height:0%;background:url(/images/movie_icon.png') no-repeat;background-size:auto;></div>
												<img src='https://img.youtube.com/vi/".$bannerRow['movie_url']."/sddefault.jpg' alt= ''/>
											</a>
										</div>
									";
								}else{
									//링크주소 정보가 있을 경우
									if(strlen($bannerRow['link_url'])>0){
										echo '<a href="http://'.$bannerRow['link_url'].'" target="'.$bannerRow['target'].'">';
									}

									echo $bannerRow[bannerText_modal]=='Y'?"<div style='position:absolute;top:0px;left:0px;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1;'><!--modal bg--></div>":"<div style='position:absolute;top:0px;left:0px;width:100%;height:100%;background:rgba(0,0,0,0);z-index:1;'><!--modal bg--></div>";

									if(strlen($bannerRow[title])>0 || strlen($bannerRow[contents])>0){
							?>
									<div style="position:absolute;top:0px;left:0px;width:100%;height:100%;padding:7%;box-sizing:border-box;z-index:2;">
										<div style="display:table;width:100%;height:100%;">
											<div style="z-index:2;display:table-cell;text-align:<?=$bannerRow[contents_position_x]?>;vertical-align:<?=$bannerRow[contents_position_y]?>;">
												<? if(strlen($bannerRow[title])>0){ ?>
													<h2 style="margin:10px 0px;color:<?=$bannerRow[title_color]?>;font-size:<?=$bannerRow[title_size]?>;font-weight:<?=$bannerRow[title_weight]=='B'?"bold":""?>;font-family:<?=$bannerRow[title_fonts]?>;letter-spacing:-1px;line-height:120%;<?=($bannerRow[bannerText_shadow]=='Y'?"text-shadow:0px 0px 15px rgba(0,0,0,0.65);":"")?>"><?=$bannerRow[title]?></h2>
												<? } ?>
												<? if(strlen($bannerRow[contents])>0){ ?>
													<span style="display:inline-block;width:75%;color:<?=$bannerRow[contents_color]?>;font-size:<?=$bannerRow[contents_size]?>;font-weight:<?=$bannerRow[contents_weight]=='B'?"bold":""?>;font-family:<?=$bannerRow[contents_fonts]?>;letter-spacing:-1px;line-height:120%;<?=($bannerRow[bannerText_shadow]=='Y'?"text-shadow:0px 0px 15px rgba(0,0,0,0.65);":"")?>"><?=$bannerRow[contents]?></span>
												<? } ?>
											</div>
										</div>
									</div>
							<?
									}
									echo '<img src="'.$configPATH.$bannerRow['files'].'" border="0" alt="" width="100%" />';
									//링크주소 정보가 있을 경우
									if(strlen($bannerRow['link_url'])>0){
										echo "</a>";
									}
								}
							?>
							</div>
				<?
							}
						}else{
				?>
				<div><img src="<?=$configPATH?>@main_banner.png" alt="배너를 등록하세요~" /></div>
				<?
						}
					}
				?>
			</div>
			<div class="swiper-pagination swiper-pagination-white"></div>
		</div>
		<script>
			//메인 비주얼 기본 슬라이드
			if($('.swiper-container').attr('slide-delay')==undefined){
				slide_delay = false;
			}else{
				slide_delay = {delay: $('.swiper-container').attr('slide-delay'), disableOnInteraction: false}
			}
			var mySwiper = new Swiper('.swiper-container', {
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true
				},
				autoplay : slide_delay
			});
		</script>
	</div>

    <div class="main_cont2">
        <div class="cont2_1">
            <h2>LADDER's Best Review</h2>
            <p>Best</p>
        </div>
        <div class="swiper-container2">
        <div class="swiper-wrapper" id="best_review"><!--10개-->

<?
   /*
   추천수 정렬 상위 30개 가져오기
   reserve 추천수
   */
$sql= "SELECT a.*, b.maximage FROM tblproductreview AS a 
		LEFT JOIN tblproduct AS b ON a.productcode = b.productcode  WHERE a.productcode REGEXP '^[0-9]+$'						
		ORDER BY a.reserve DESC limit 0, 30"; 					
				$result=mysql_query($sql,get_db_conn());
				while($row=mysql_fetch_object($result)) {
					if($row->img == "") $image =  "/product/".$row->maximage;
					else $image =  "/productreview/".$row->img;	
					//50자 로 잘라서 표시
					$cut_len = 45;
					$review_content = $row->content;
					$review_content_len = mb_strlen( $review_content, 'utf-8' );

					if($review_content_len > $cut_len){
						$review_content = mb_substr($review_content, 0, $cut_len, 'utf-8').'...';
					}

				
				$img_src = get_member_img($row->id);
				if($img_src=="/data/profile/")	$img_src = './img/la_ic2.png';
	

?>
            <div class="swiper-slide"><a href="/m/view.php?type=review&date=<?=$row->date?>">
                <div>
                    <div>
                    <div><img src="<?=$img_src?>" alt=""></div>
                    <p><?=$row->name?><br><span><?=$row->date?></span></p>
                    <button class="img1"><img src="./img/love.png" alt=""></button>
                    <button class="img2"><img src="./img/love2.png" alt=""></button>
                </div>
                    <div>
                        <div>
                            <img src="/data/shopimages<?=$image?>" alt="">
                        </div>
                        <div>
                            <h2>지금 <span><?=$row->name?> 레더</span>의 <span>찐후기</span> 보러가기</h2>
                        </div>
                    </div>
                    <div>
                        <p class="jl6"><?=$review_content?></p>
                    </div>
                </div>
            </a></div>	     
<?
				}
mysql_free_result($result);
?>	
			

        </div>
    </div>
    <script>
    var swiper = new Swiper('.swiper-container2', {
        scrollbar: '.swiper-scrollbar',																								  
        scrollbarHide: true,
        slidesPerView: '1.2',
        centeredSlides: true,
        spaceBetween: 16,
        grabCursor: true
    });
    </script>
    <div class="main_cont3" id = "click_list">
        <div>
            <h2>전국 HOT Place 전부 모아봤어</h2>	<!--10개-->
            <p class="co_pp" onclick="window.location.reload(true);location.href='#click_list'"><span>새로보기</span></p>
        </div>
        <div class="swiper-container3">
    <div class="swiper-wrapper" id="local_list">	    

    </div>
   
  </div>
   
    </div>
    </div>
    <ul class="cont33">
        

		<?
			  $listSQL="SELECT * FROM tblboard where board ='storytalk' order by num desc limit 5";
			    if(false !== $listRes = mysql_query($listSQL,get_db_conn())){						
                    $listrowcount = mysql_num_rows($listRes);
                    if($listrowcount>0){
						echo '<h2>오늘은 어떤 주제가 HOT? HOT!</h2>';
						 while($listRow = mysql_fetch_object($listRes)){
                            $title = $listRow->title;
							 if($listRow->filename){
								$filename="/data/shopimages/board/storytalk/".$listRow->filename;	  							
							}else{
								$filename="/images/no_img.gif";
							}
							
							$cut_len = 11;
							$review_content = strip_tags($listRow->content);
							$review_content_len = mb_strlen( $review_content, 'utf-8' );

							if($review_content_len > $cut_len){
								$review_content = mb_substr($review_content, 0, $cut_len, 'utf-8').'...';
							}
		?>	 
        <li><a href="board_view.php?board=storytalk&view=1&num=<?=$listRow->num?>">
            <img src="<?=$filename?>" alt="">
        </a>
        </li>	
        <h3><?=$title?></h3>
            <p><?=$review_content?></p>	 
		<?
						 }
						echo '<a href="board_list.php?board=storytalk">스토리 더보기</a>';
					}
				}
		?>
        
    </ul>	
	


<script>
function append_local_list(){	  		
		$.post("/m/ajax.product.local_list.php"
			,{
			page:"1"			
			},
			function(data){ 
			$("#local_list").html(data);	 			
		});
		

}

append_local_list();


</script>

<?


	include_once('skin/basic/footer.php');
	include_once($Dir."lib/mobile_eventlayer.php");
	$menu_set = 'home';	
	include_once('footer.php');
?>