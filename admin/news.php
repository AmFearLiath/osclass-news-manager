<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/oc-load.php');
require_once(osc_plugin_path('news-manager/classes/class.news-manager.php'));

$nm = new nm;
$edit = false;
$check = $nm->_get('news_height');

if (empty($check) || !isset($check)) {
    echo sprintf(__('<strong>Attention.</strong> You should configure the plugin first and set a height for the news-box! <a href="%s">Configuration</a>', 'news-manager'), osc_admin_render_plugin_url('news-manager/admin/config.php'));  
}

if (Params::getParam('type') == 'position') {
    if (!$nm->_saveOrder(Params::getParam('slide'))) {
        return false;    
    }    
} elseif (Params::getParam('type') == 'delete') {
    if (!$nm->_deleteNews(Params::getParam('delete_id'))) {
        return false;    
    }    
} elseif (Params::getParam('type') == 'edit') {

    $edit = $nm->_readNews(Params::getParam('edit_id'));
    
    $input = '<input type="hidden" name="news" value="edit" />
                <input type="hidden" name="news_edit" value="'.$edit['pk_i_id'].'" />'.PHP_EOL;
    $script = '<script>
                    $(document).ready(function () {
                        $.getScript("'.osc_plugin_url('news-manager/assets/js/editor.js').'editor.js");                     
                    });
                </script>'.PHP_EOL;    
} else {
    $input = '<input type="hidden" name="news" value="save" />';    
} 

if (Params::getParam('news') == 'save') {
    $save = array();
    foreach(osc_get_locales() as $k => $v) { 
        $push = array($v['pk_c_code'] => Params::getParam('message_'.$v['pk_c_code'], false, false));
        $save = array_merge($save, $push);    
    }
    if ($nm->_saveNews(serialize($save))) {
        ob_get_clean();
        osc_add_flash_ok_message(__('<strong>Message saved.</strong> Your message was saved succesfully', 'news-manager'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'news.php');    
    } else {
        ob_get_clean();
        osc_add_flash_error_message(__('<strong>Error.</strong> Your message can not be saved, please try again', 'news-manager'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'news.php');    
    }      
} elseif (Params::getParam('news') == 'edit') {
    $save = array();
    foreach(osc_get_locales() as $k => $v) { 
        $push = array($v['pk_c_code'] => Params::getParam('message_'.$v['pk_c_code'], false, false));
        $save = array_merge($save, $push);    
    }
    if ($nm->_saveNews(serialize($save), Params::getParam('news_edit'))) {
        ob_get_clean();
        osc_add_flash_ok_message(__('<strong>Message edited.</strong> Your message was edited succesfully', 'news-manager'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'news.php');    
    } else {
        ob_get_clean();
        osc_add_flash_error_message(__('<strong>Error.</strong> Your message can not be edited, please try again', 'news-manager'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'news.php');    
    }    
}

foreach ($nm->_readNews() as $k => $v) {
    $m = unserialize($v['message']);
    $l = osc_locale_code();
    $news .= '
        <tr class="sortable" id="slide-'.$v['pk_i_id'].'">
            <td class="move"><i class="fa fa-arrows"></i></td>
            <td class="date">'.$v['dt_date'].'</td>
            <td class="preview">'.osc_highlight($m[$l], 100).'</td>
            <td class="tools">
                <i class="fa fa-edit btn-info edit-news" data-id="'.$v['pk_i_id'].'"></i>
                <i class="fa fa-times btn-danger delete-news" data-id="'.$v['pk_i_id'].'"></i>
            </td>
        </tr>
    ';    
}

foreach(osc_get_locales() as $k => $v) {
    
    if ($k == '0') { 
        $current = ' current'; 
    } else {
        $current = '';
    }
    $message = unserialize($edit['message']);
    $tabs .= '<li class="tab-link'.$current.'" data-tab="tab-'.$v['pk_c_code'].'">'.$v['s_name'].'</li>';
    $textarea .= '
        <div id="tab-'.$v['pk_c_code'].'" class="tab-content'.$current.'">
            <textarea class="createNews" name="message_'.$v['pk_c_code'].'">'.(isset($message[$v['pk_c_code']]) ? $message[$v['pk_c_code']] : '').'</textarea>
        </div>
    ';
}    
?>
<div class="news">
    <div class="buttonAdd btn btn-info pull-right"><i class="fa fa-plus"></i></div>
    
    <div class="clearfix"></div>
    
    <div id="create">
        <div class="widget-title">
            <h3><?php _e('Create News', 'news-manager'); ?></h3>
        </div>
        <div id="create_news">
            <form action="<?php echo osc_admin_render_plugin_url('news-manager/admin/news.php'); ?>" method="POST">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>news.php" />
                <?php echo $input; ?>
                <div class="form-group">
                
                    <div class="container">
                        <ul class="tabs">
                            <?php echo $tabs; ?>
                        </ul>

                        <?php echo $textarea; ?>

                    </div>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info pull-right"><?php _e('Save', 'news-manager'); ?></button>
                </div>
                <div class="clearfix"></div>
                <?php if (isset($script)) { echo $script; } ?>
            </form>
        </div>
    </div>
    <div id="news">
        <table>
            <thead>
                <tr>
                    <td class="move"></td>
                    <td class="date"><?php _e('Date', 'news-manager'); ?></td>
                    <td class="preview"><?php _e('Preview', 'news-manager'); ?></td>
                    <td class="tools"><?php _e('Tools', 'news-manager'); ?></td>
                </tr>
            </thead>
            <tbody>
                <?php echo $news; ?>
            </tbody>
        </table>
    </div>
    <div id="sortStatus" style="display: none;"></div>
</div>