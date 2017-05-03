<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/oc-load.php');
require_once(osc_plugin_path('news-manager/classes/class.news-manager.php'));

$nm = new nm; $messages = '';
$get = $nm->_get();
foreach ($nm->_readNews() as $k => $v) {
    $timestamp = strtotime($v['dt_date']);
    $time = date("H:i:s", $timestamp);
    $date = date("d.m.Y", $timestamp);
    $m = unserialize($v['message']);
    $l = osc_current_user_locale();
    
    $messages .= '
        <div id="news'.$v['pk_i_id'].'" class="message_item" style="float: none; list-style: none; position: relative; width: 296px;">
            <div class="review_date">
                <small>'.sprintf(__('on %s at %s', 'news-manager'), $date, $time).'</small>
            </div>            
            <div class="review_content">'.$m[$l].'</div>
        </div>
    ';    
}    
?>
<div id="news_wrapper">
    <?php if (isset($messages)) echo $messages; ?>
</div>
<style>
#news_wrapper {
    <?php
        if (!empty($get['news_height'])) echo 'height: '. $get['news_height'].';';
        if (!empty($get['news_width'])) echo 'width: '. $get['news_width'].';';
        if (!empty($get['news_border'])) echo 'border: '. $get['news_border'].';';
        if (!empty($get['news_borderradius'])) echo 'borderradius: '. $get['news_borderradius'].';';
        if (!empty($get['news_background'])) echo 'background: '. $get['news_background'].';';
    ?>
}
.bx-viewport {
    <?php
        if (!empty($get['news_height'])) {
            echo 'height: '. $get['news_height'].' !important;';    
        } else {
            echo 'height: 200px !important;';
        }
    ?>
}
</style>