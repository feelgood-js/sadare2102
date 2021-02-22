<?

header("location:product.php");

include_once('top.php'); 

$base_menu = "레더";



?>

 <script>

$('.tab1_tab1').css({   

    color: "darkred"

}); 

</script>

        <div class="tab_container">

        <div id="tab1" class="tab_content">

            <ul>

                <?

				$itemcount = 10; // 페이지당 게시글 리스트 수 

				$page_sql= "SELECT count(id) as total_count FROM tblproductreview ";

				$page_reserve=mysql_query($page_sql,get_db_conn());

				$page_row=mysql_fetch_object($page_reserve);  

				$total_count = $page_row->total_count;

				$total_page  = ceil($total_count / $itemcount);

				mysql_free_result($page_reserve);

				$now_page=$_REQUEST["page"];

				if($now_page == "" || $now_page < 0) $now_page = 0;			

				if($now_page >= $total_page) $now_page = $total_page-1;

				

				$sql= "SELECT a.*, b.maximage FROM tblproductreview AS a 

						LEFT JOIN tblproduct AS b ON a.productcode = b.productcode							

						ORDER BY a.date DESC";

				$sql.= " LIMIT " . ($now_page*$itemcount) . ", " . $itemcount;	   				

				$result=mysql_query($sql,get_db_conn());

				while($row=mysql_fetch_object($result)) {

					if($row->img == "") $image =  "/product/".$row->maximage;

					else $image =  "/productreview/".$row->img;



					switch ($row->productcode){

						case "net":

							$type="net";

							$icon_img_src="/m/img/icc4.png";

							break;

						case "info":

							$type="info";

							$icon_img_src="/m/img/icc3.png";

							break;

						case "life":

							$type="life";

							$icon_img_src="/m/img/icc2.png";

							break;

						default :

							$type="review";

							$icon_img_src="/m/img/icc1.png";

							break;

						

					}

				?>	 				

				<a href="view.php?date=<?=$row->date?>&type=<?=$type?>">

					<li>

						<div>

						<img width="100%" src="/data/shopimages<?=$image?>">

						<img style="width:30px;top:18px;left:19px;" src="<?=$icon_img_src?>">   						

						</div>

						<div>

							<div class="main_a">

								<?			

									//출력문자 제한

									$str_size=13;

									$content_temp=explode("=",$row->content);

									$content=mb_substr($content_temp[0], 0, $str_size, "utf-8");

									if(mb_strlen($content,"utf-8")>=$str_size)		$content.=" ...";

									echo " <h3>$content</h3>";

									$reserve_sql= "SELECT sum(reserve) as reserve FROM tblreserve where id='".$row->id."'";

									$result_reserve=mysql_query($reserve_sql,get_db_conn());

									$reserve_row=mysql_fetch_object($result_reserve);  

									

									echo "<p>{$row->name} 레더 : 공감 ".number_format($reserve_row->reserve)."점</p>";

									mysql_free_result($result_reserve);									

								?>

							</div>

						</div>

					</li>

				</a>  				

				<?

				}

				mysql_free_result($result);		

				?>	

				</ul>

				<div class="product_pageing" id="page_wrap">

                <div>

				     <a href="index.php?searchkey=&amp;list_type=&amp;page=0" rel="external">

					    <img src="/images/common/btn_page_start.gif" border="0" align="absmiddle" alt="">

					 </a>

				     <a href="index.php?searchkey=&amp;list_type=&amp;page=<?=$now_page-1?>" rel="external">

					  <img src="/images/common/btn_page_prev.gif" border="0" align="absmiddle" alt="">

					 </a>

					 

					 

				     <div>

						 <?   						

						 			 paging("","index.php",$total_page,$now_page);

						 ?>

						 

				     </div>

					 

				     <a href="index.php?searchkey=&amp;list_type=&amp;page=<?=$now_page+1?>" rel="external">

					     <img src="/images/common/btn_page_next.gif" border="0" align="absmiddle" alt="">

					 </a>

				     <a href="index.php?searchkey=&amp;list_type=&amp;page=<?=$total_page?>" rel="external">

					   <img src="/images/common/btn_page_end.gif" border="0" align="absmiddle" alt="">

					 </a>

               </div>

            </div> 

            <div class="tab1_ad">광고</div>

        </div>        

    </div>

    </div>

</body>

</html>