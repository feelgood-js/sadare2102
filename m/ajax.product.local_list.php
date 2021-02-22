<?
include_once('ajax.top.php'); 

   /*
   추천수 정렬 상위 30개 가져오기
   like_cnt 추천수
   */
   $rs_num=1;
$sql= "SELECT * from yc_biz_info order by rand() limit 100"; 					
	$result=mysql_query($sql,get_db_conn());
	while($row=mysql_fetch_object($result)) {
		$state=mb_substr($row->addr1, 0, 2, 'utf-8');

		$cut_len = 30;
		$content = $row->content;
		if(!$content)	$content = $row->my_biz_txt;

		$content_len = mb_strlen( $content, 'utf-8' );

		if($content_len > $cut_len){
			$content = mb_substr($content, 0, $cut_len, 'utf-8').'...';
		}

	$expPhoto = explode(",", $row->photos);
	$yc_img='/yc/data/bbs/';
	$share_photo='/img/no_img.jpg';
	$share_photo = $yc_img.$expPhoto[0];
	if(!$expPhoto[0]) $share_photo='/img/no_img.jpg';


?>      

	  <div class="swiper-slide"><a href="/yc/sub/store-offline.html?seq=<?=$row->seq?>"><img src="<?=$share_photo?>" alt=""></a>
          <div class="con3_p">
              <h2 class="co_h2"><span>[<?=$state?>]</span> <?=$row->biz_name?> </h2>
              <p><?=$content?></p>
          </div>
          <div class="con3_2">
              
                  
				  <!--앨범에서 후기중 추천 제일 많은것 1개 가져오기-->
				  <?
				    $sql= "SELECT * from yc_album where r_seq = ".$row->seq." order by like_cnt desc limit 1"; 					
					$result_=mysql_query($sql,get_db_conn());
					$row_=mysql_fetch_object($result_);

					$cut_len_l = 40;
					$content_l = $row_->contents;
					$content_len_l = mb_strlen( $content_l, 'utf-8' );		 
					
					if($content_len_l > $cut_len_l){
						$content_l = mb_substr($content_l, 0, $cut_len_l, 'utf-8').'...';
					}
					 if($row_->m_seq){

						 //yc 회원정보 검색후 email 정보로 회원을 검색한다
						$mem_info =  marge_member($row_->m_seq);
						
						$img_src = get_member_img($mem_info->id);
						if($img_src=="/data/profile/")	$img_src = './img/la_ic2.png';

					 echo '
							<div class="con3_21">
					 		<div>
							<div><img src="'.$img_src.'" alt=""></div>
						    <div>'.$content_l.'</div>
							</div>
	    					 </div>
					 ';
					 }


					mysql_free_result($result_);
				  ?>	                      

                  
             
              <div class="buu23"><button type="button" onclick="window.location.reload(true);location.href='#click_list'"><img src="./img/reset_ic.png" alt="">핫플레이스 새로보기<span><span><?=$rs_num++?></span>/10</span></button></div>
          </div>
      </div>	

<?
}
mysql_free_result($result);
?>
<script>
    var swiper = new Swiper('.swiper-container3', {
        autoHeight: true,
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 66,
        stretch: 0,
        depth: 100,
        modifier: 1,
      },
      pagination: {
        el: '.swiper-pagination2',
      },
    });
  </script> 