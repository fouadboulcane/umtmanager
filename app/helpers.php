<?php 

if (! function_exists('linkify')) {
    function linkify($string)
    {
        $pattern = "~(https?://\S+)|([^\s@]+@[^\s@]+)|(\+\d+)~";
    
        return preg_replace_callback($pattern, function($matches) {
            
            $template = '<a href="%1$s%2$s" class="text-primary-400" rel="noopener nofollow" target="_blank">%2$s</a>';
            
            if ($matches[1] !== "") return sprintf($template, "", $matches[1]);        
            if ($matches[2] !== "") return sprintf($template, "mailto:", $matches[2]);        
            if ($matches[3] !== "") return sprintf($template, "tel:", $matches[3]);
        }, $string);  
    }


}