<?php

/**
 *
 */
if (!function_exists('requestParam')) {

    function requestParam($key)
    {
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

    function handlePostData($key)
    {
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

    function handleGetData($key)
    {
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
    function getCustomExcerpt($length, $postId)
    {
        $content = get_post($postId)->post_content;
        if (!empty($content)) {
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
}

if (!function_exists('getContentTrim')) {
    /**
     * getCustomExcerpt
     * @parameter
     * $content (content you want to get trimmed) string
     * @return
     *  string
     */
    function getContentTrim($content, $length = 150)
    {
        $content = substr($content, 0, $length) . '...';
        if (!empty($content)) {
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
}

/**
 * print_r upgrade
 * */
if (!function_exists('pr')) {
    function pr($key)
    {
        echo '<pre>';
        print_r($key);
        echo '</pre>';
    }
}

if (!function_exists('bsg_loadView')) {
    function bsg_loadView($view, $fields = array())
    {
        if (!empty($fields)) {
            foreach ($fields as $key => $field) {
                $$key = $field;
            }
        }

        $view = bs_gallery_view . $view . '.php';
        if (!file_exists($view)) {
            echo 'View not found!';
            return false;
        }
        require_once($view);
    }
}

if (!function_exists('getShareingLinks')) {
    function getShareingLinks($attr = [])
    {
        ob_start();
        global $post;
        $url = isset($attr['url']) ? $attr['url'] : get_permalink($post->ID);
        $title = isset($attr['title']) ? $attr['title'] : ($post->post_title);
?>
        <div class="social_media_links mt-2 mb-3">
            <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo $url ?>" class="share_fb"></a>
            <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo $url ?>&text=<?php echo $title ?>&via={user_id}&hashtags=step2step" class="share_twitter"></a>
            <a target="_blank" href="<?php echo 'https://api.whatsapp.com/send?text=' . urlencode($url); ?>" class="share_whtsapp"></a>
            <a target="_blank" href="mailto:{email_address}?subject=<?php echo $title ?>&body=<?php echo $url ?>" target="_blank" class="share_email"></a>
        </div>
<?php
        return ob_get_contents();
    }
}
add_shortcode('social_share_links', 'getShareingLinks');


if (!function_exists('write_log')) {

    function write_log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

function fetchBsGalleryById($id)
{
    $objGallery = new \BsGallery\Controllers\GalleryController();
    return $objGallery->show($id);
}
