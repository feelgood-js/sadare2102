<?php
    session_cache_limiter("private_no_expire");
    session_start();        //세션시작에 실패하면 false 반환   에러시 무시: @sesison_start(); 또는 output_buffering=on인지 확인
?>
