
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c2493c96e8f7cdb534f703340cf1716a&libraries=services"></script>


<script>

if (navigator.geolocation) {

    

    // GeoLocation을 이용해서 접속 위치를 얻어옵니다

    navigator.geolocation.getCurrentPosition(function(position) {

        

        var lat = position.coords.latitude, // 위도

            lon = position.coords.longitude; // 경도			       		
				
        console.log(lat + '-' + lon);

		$.post("location_set.php", {

			"lat" : lat,

			"lng" : lon



		}, function(data) {	  					

		});

      });

}


</script>