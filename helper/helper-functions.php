<?php

/**
 *
 */
if (!function_exists('requestParam')) {

    function requestParam($key) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch ($requestMethod) {
            case 'POST':
                return handlePostData($key);
                break;
            case 'GET':
                return handleGetData($key);
                break;
            default:
                return false;
                break;
        }
    }

}

if (!function_exists('handlePostData')) {

    function handlePostData($key) {
        if (!is_array($key)) {
            if (isset($_POST[$key])) {
                return htmlspecialchars(trim($_POST[$key]));
            }
        } else {
            $out = [];
            foreach ($_POST as $k => $v) {
                $out[$k] = htmlspecialchars(trim($v));
            }
            return $out;
        }
    }

}

if (!function_exists('handleGetData')) {

    function handleGetData($key) {
        if (!is_array($key)) {
            if (isset($_GET[$key])) {
                return htmlspecialchars(trim($_GET[$key]));
            }
        } else {
            $out = [];
            foreach ($_GET as $k => $v) {
                $out[$k] = htmlspecialchars(trim($v));
            }
            return $out;
        }
    }

}

if (!function_exists('getArrayValue')) {
    function getArrayValue($arr, $key)
    {
        if (is_array($arr)) {
            if (isset($arr[$key]) && !empty($arr[$key])) {
                return $arr[$key];
            }
        } else if (is_object($arr)) {
            if (isset($arr->$key) && !empty($arr->$key)) {
                return $arr->$key;
            }
        }
        return false;
    }
}

if (!function_exists('getCustomExcerpt')) {

    /**
     * getCustomExcerpt
     * @parameter
     * $length int
     * $postID int (either content or content)
     * $content string
     * @return
     *  string
     */
    function getCustomExcerpt($length, $postId) {
        $content = get_post($postId)->post_content;
        $content = apply_filters('the_excerpt', $content);
        $content = substr($content, 0, $length) . '...';
        $content = preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $content);
        $content = preg_replace("/<img[^>]+\>/i", '', $content);
        $content = preg_replace('/<iframe.*?>/', '', $content);
        $content = preg_replace("/<img[^>]+\>/i", '', $content);
        $content = str_replace("'", '', $content);
        $content = strip_shortcodes($content);
        $content = strip_tags($content);
        return htmlspecialchars_decode(htmlspecialchars($content));
    }

}

if (!function_exists('getContentTrim')) {

    /**
     * getCustomExcerpt
     * @parameter
     * $content (content you want to get trimmed) string
     * @return
     *  string
     */
    function getContentTrim($content, $length = 150) {
        $content = substr($content, 0, $length) . '...';
        $content = preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $content);
        $content = preg_replace("/<img[^>]+\>/i", '', $content);
        $content = preg_replace('/<iframe.*?>/', '', $content);
        $content = preg_replace("/<img[^>]+\>/i", '', $content);
        $content = str_replace("'", '', $content);
        $content = strip_shortcodes($content);
        $content = strip_tags($content);
        return $content;
    }

}


/**
 * print_r upgrade
 * */
if (!function_exists('pr')) {

    function pr($key) {
        echo '<pre>', print_r($key), '</pre>';
    }

}

if(!function_exists('bsg_loadView')){
    function bsg_loadView($view, $fields=array()) {
        if (!empty($fields)) {
            foreach ($fields as $key => $field) {
                $$key = $field;
            }
        }
    
       $view = ls_framework_view . $view . '.php';
        if (!file_exists($view)) {
            echo 'View not found!';
            return false;
        }
        require_once($view);
    }
}

