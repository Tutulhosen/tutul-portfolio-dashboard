<?php

if (!function_exists('status_convert')) {
    function status_convert($status) {
       if ($status==1) {
            return 'Active';
       } else {
            return 'InActive';
       }
       
    }
}

