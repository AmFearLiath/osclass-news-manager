<?php
if (!defined('OC_ADMIN') || OC_ADMIN!==true) exit('Access is not allowed.');

$nm = new nm;

if (Params::getParam('news') == 'save') {
    $params = Params::getParamsAsArray();
    if ($nm->_saveSettings($params)) {
        ob_get_clean();
        osc_add_flash_ok_message(__('<strong>All Settings saved.</strong> Your plugin ist now configured', 'news-manager'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'config.php');    
    } else {
        ob_get_clean();
        osc_add_flash_error_message(__('<strong>Error.</strong> Your settings can not be saved, please try again', 'news-manager'), 'admin');
        osc_admin_render_plugin( osc_plugin_folder(__FILE__) . 'config.php');    
    }      
}

$data = $nm->_get();
    
?>

<div class="news-manager">
    <div class="title">
        <h3>
            <?php _e('News Manager Settings', 'news-manager'); ?>
        </h3>
    </div>
    <div class="settings">
        <form action="<?php echo osc_admin_render_plugin_url('news-manager/admin/config.php'); ?>" method="POST">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>config.php" />
            <input type="hidden" name="news" value="save" />
            <div class="row">
            
                <div class="col-md-4">
                    <div class="contentbox">
                        <div class="description">
                            <?php _e('Activate needed resources', 'news-manager'); ?>    
                        </div>
                        <div class="controls">
                            <div class="form-group">
                                <?php if (isset($data['news_bxslider']) && $data['news_bxslider'] == '1') $bxslider = ' checked="checked"'; ?>
                                <label>
                                    <input type="checkbox" name="news_bxslider" class="settbox" value="1"<?php if (isset($bxslider)) echo $bxslider; ?> />
                                    <?php _e('bxSlider', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can here activate the bxSlider. If it is previously loaded by another script, deactivate it here', 'news-manager'); ?>"></i>
                                </label>
                            </div>
                            <div class="form-group">
                                <?php if (isset($data['news_fontawesome']) && $data['news_fontawesome'] == '1') $fontawesome = ' checked="checked"'; ?>
                                <label>
                                    <input type="checkbox" name="news_fontawesome" class="settbox" value="1"<?php if (isset($fontawesome)) echo $fontawesome; ?> />
                                    <?php _e('Font Awesome', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can here activate the Font Awesome. If it is previously loaded by another script, deactivate it here', 'news-manager'); ?>"></i>
                                </label>
                            </div>
                            <div class="form-group">
                                <?php if (isset($data['news_bootstrap']) && $data['news_bootstrap'] == '1') $bootstrap = ' checked="checked"'; ?>
                                <label>
                                    <input type="checkbox" name="news_bootstrap" class="settbox" value="1"<?php if (isset($bootstrap)) echo $bootstrap; ?> />
                                    <?php _e('Bootstrap', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can here activate Bootstrap. If it is previously loaded by another script, deactivate it here', 'news-manager'); ?>"></i>
                                </label>
                            </div>
                            <div class="form-group">
                                <?php if (isset($data['news_wysiwyg']) && $data['news_wysiwyg'] == '1') $wysiwyg = ' checked="checked"'; ?>
                                <label>
                                    <input type="checkbox" name="news_wysiwyg" class="settbox" value="1"<?php if (isset($wysiwyg)) echo $wysiwyg; ?> />
                                    <?php _e('WYSIWYG Editor', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can here activate the WYSIWYG Editor. If it is previously loaded by another script, deactivate it here', 'news-manager'); ?>"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="contentbox">
                        <div class="description">
                            <?php _e('Set here the Dimensions of the News box', 'news-manager'); ?>    
                        </div>
                        <div class="controls">
                            <div class="form-group">
                                <label>
                                    <?php _e('Height', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can use all kind of parameters here (px, %, vh, etc...)', 'news-manager'); ?>"></i>
                                </label>
                                <input type="text" name="news_height" class="form-control" value="<?php if (isset($data['news_height'])) echo $data['news_height']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php _e('Width', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can use all kind of parameters here (px, %, vw, etc...)', 'news-manager'); ?>"></i>
                                </label>
                                <input type="text" name="news_width" class="form-control" value="<?php if (isset($data['news_width'])) echo $data['news_width']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-4">
                    <div class="contentbox">
                        <div class="description">
                            <?php _e('Set here the Apperance of the News box', 'news-manager'); ?>    
                        </div>
                        <div class="controls">
                            <div class="form-group">
                                <label>
                                    <?php _e('Border', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can use all kind of parameters here (px, dashed, rgba, etc...)', 'news-manager'); ?>"></i>
                                </label>
                                <input type="text" name="news_border" class="form-control" value="<?php if (isset($data['news_border'])) echo $data['news_border']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php _e('Border Radius', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can use all kind of parameters here (px, %, em, etc...)', 'news-manager'); ?>"></i>
                                </label>
                                <input type="text" name="news_borderradius" class="form-control" value="<?php if (isset($data['news_borderradius'])) echo $data['news_borderradius']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>
                                    <?php _e('Background', 'news-manager'); ?>
                                    <i class="fa fa-info" title="<?php _e('You can use all kind of parameters here (url, rgba, transparent, etc...)', 'news-manager'); ?>"></i>
                                </label>
                                <input type="text" name="news_background" class="form-control" value="<?php if (isset($data['news_background'])) echo $data['news_background']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <button type="submit" class="btn btn-info"><?php _e('Save', 'news-manager'); ?></button>
        </form>
    </div>
</div>   