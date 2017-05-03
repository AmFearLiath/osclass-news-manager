<?php
?>
<div class="help">
    <h2>
        <?php _e('News Manager', 'news-manager'); ?>
    </h2>
    <p><?php _e('Welcome to the News Manager. Here you can write News and show them on your frontside on a smart way', 'news-manager'); ?></p>
    <br /><br />
    <p><?php echo sprintf(__('At first ensure that you have setup the plugin on the <a href="%s">configuration page</a>. The only important option is the height for the news slider, all others can be ignored', 'news-manager'), osc_admin_render_plugin_url('news-manager/admin/config.php')); ?></p>
    <p<?php _e('BUT!!! You have to ensure, that all needed scripts are loaded. Through this plugin or from other plugins, in this case you can deactivate it separately.', 'news-manager'); ?>></p>
    <br />
    <p><?php echo sprintf(__('After the configuration, you can write your news <a href="%s">here</a>.', 'news-manager'), osc_admin_render_plugin_url('news-manager/admin/news.php')); ?></p>
    <br />
    <p><?php _e('To show the News on your Page, you have to include a little code on this place, where you want to appear the news.', 'news-manager'); ?></p>
    <pre>&lt;?php showNews(); ?&gt;</pre>
    <br /><br />
    <p><?php _e('Thats all! Have fun with this little News Manager', 'news-manager'); ?></p>
</div>