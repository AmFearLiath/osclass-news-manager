<?php
/*
Plugin Name: News Manager
Plugin URI: http://amfearliath.tk/
Description: News Manager system for showing self designed news 
Version: 1.0.0
Author: Liath
Author URI: http://amfearliath.tk
Short Name: news_manager
Plugin update URI: news-manager
*/

require_once('classes/class.news-manager.php');


/*
    FUNCTIONS
*/
function nm_admin_page_header() {   
    echo '<h1>'.__('News Managment', 'news_manager').'</h1>';    
}
function nm_install() {
    nm::newInstance()->_install();
}

function nm_uninstall() {
    nm::newInstance()->_uninstall();
}

function showNews() {
    nm::newInstance()->showNews();
}

function nm_style() {
    osc_enqueue_style('news_manager-styles', osc_plugin_url('news-manager/assets/css/style.css').'style.css');
}

function nm_style_admin() {
    $nm = new nm;
    $params = Params::getParamsAsArray();    
    if (isset($params['file'])) {
        $plugin = explode("/", $params['file']);
        if ($plugin[0] == 'news-manager') {
            
            $fontawesome = $nm->_get('news_fontawesome');
            $bootstrap = $nm->_get('news_bootstrap');
            $wysiwyg = $nm->_get('news_wysiwyg');
            $bxslider = $nm->_get('news_bxslider');
            
            osc_enqueue_style('news_manager-styles_admin', osc_plugin_url('news-manager/assets/css/admin.css').'admin.css');
            
            if ($fontawesome == '1') {
                osc_enqueue_style('news_manager-styles_fontawesome', osc_plugin_url('news-manager/assets/css/font-awesome.min.css').'font-awesome.min.css');    
            }
            
            if ($bootstrap == '1') {
                osc_enqueue_style('news_manager-styles_bootstrap', osc_plugin_url('news-manager/assets/css/bootstrap.min.css').'bootstrap.min.css');
                osc_register_script('news_manager-bootstrap', osc_plugin_url('news-manager/assets/js/bootstrap.min.js') . 'bootstrap.min.js', array('jquery'));
                osc_enqueue_script('news_manager-bootstrap');    
            }
            
            if ($bxslider == '1') {
                osc_enqueue_style('bxslider-style', osc_plugin_url('news-manager/assets/css/jquery.bxslider.css').'jquery.bxslider.css');
                osc_register_script('bxslider-script', osc_plugin_url('news-manager/assets/js/jquery.bxslider.min.js') . 'jquery.bxslider.min.js', array('jquery'));
                osc_enqueue_script('bxslider-script');    
            }
            
            if ($wysiwyg == '1') {
                osc_enqueue_style('jQWE-styles', osc_plugin_url('news-manager/assets/css/jQWE.css').'jQWE.css');
                osc_enqueue_style('jQWE-fonts', osc_plugin_url('news-manager/assets/css/fonts.css').'fonts.css');
                
                osc_register_script('wysiwyg-main', osc_plugin_url('news-manager/assets/js/wysiwyg.min.js') . 'wysiwyg.min.js', array('jquery'));
                osc_enqueue_script('wysiwyg-main');
                
                osc_register_script('wysiwyg-editor', osc_plugin_url('news-manager/assets/js/wysiwyg-editor.min.js') . 'wysiwyg-editor.min.js', array('jquery'));
                osc_enqueue_script('wysiwyg-editor');
                
                osc_register_script('news_manager-editor', osc_plugin_url('news-manager/assets/js/editor.js') . 'editor.js', array('jquery'));
                osc_enqueue_script('news_manager-editor');    
            }
            
            osc_register_script('news_manager-admin', osc_plugin_url('news-manager/assets/js/admin.js') . 'admin.js', array('jquery'));
            osc_enqueue_script('news_manager-admin');
            
            osc_add_hook('admin_page_header','nm_admin_page_header');
            osc_remove_hook('admin_page_header', 'customPageHeader');    
        }    
    }    
}

function nm_configuration() {
    osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin/config.php');
}

function nm_admin_toolbar() {
    nm::newInstance()->_admin_menu_draw();
}                   

    
osc_register_plugin(osc_plugin_path(__FILE__), 'nm_install');

function nm_init() {
    if (!osc_is_moderator()) {
        nm::newInstance()->_admin_menu_draw();    
    }
}

/*
    HOOKS
*/ 

if(osc_version() >= 300) {
    osc_add_hook('admin_menu_init', 'nm_admin_menu_init');
} else {
    osc_add_hook('admin_menu', 'nm_admin_menu');
}

if (osc_version() < 311) {
    echo '<script type="text/javascript" src="'.osc_plugin_url('news-manager/assets/js/script.js').'script.js"></script>';    
    osc_add_hook('admin_menu', 'nm_admin_toolbar');
} else {
    osc_register_script('news_manager-script', osc_plugin_url('news-manager/assets/js/script.js') . 'script.js', array('jquery'));
    osc_enqueue_script('news_manager-script');    
    osc_add_hook('admin_menu_init', 'nm_admin_toolbar');
}

//Plugin un/installation and configuration
osc_add_hook('header', 'nm_style');
osc_add_hook('admin_header', 'nm_style_admin');
osc_add_hook('add_admin_toolbar_menus', 'news_manager', 1);
osc_add_hook('init_admin', 'nm_init');
    
osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'nm_configuration');
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'nm_uninstall');

//Add Seller details on account page
osc_add_hook('account_menu','nm_account_menu');


function nm_admin_menu_init() {
    osc_add_admin_menu_page( __('News Manager', 'news_manager'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/news.php'), 'nm_admin', 'administrator' );
    osc_add_admin_submenu_page('nm_admin', __('News', 'news_manager'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/news.php'), 'nm_admin_news', 'administrator');
    osc_add_admin_submenu_page('nm_admin', __('Settings', 'news_manager'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/config.php'), 'nm_admin_settings', 'administrator');
    osc_add_admin_submenu_page('nm_admin', __('Help', 'news_manager'), osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/help.php'), 'nm_admin_help', 'administrator');
}

function nm_admin_menu() {
    echo '<h3><a href="#">' . __('News Manager', 'news_manager') . '</a></h3>
    <ul>
        <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/news.php') . '">&raquo; ' . __('News', 'news_manager') . '</a></li>
        <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/config.php') . '">&raquo; ' . __('Settings', 'news_manager') . '</a></li>
        <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/help.php') . '">&raquo; ' . __('Help', 'news_manager') . '</a></li>
    </ul>';
}

?>
