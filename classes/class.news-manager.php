<?php
class nm extends DAO {
    
    private static $instance ;
    
    public static function newInstance() {
        if( !self::$instance instanceof self ) {
            self::$instance = new self ;
        }
        return self::$instance ;
    }
    
    function __construct() {
        $this->_table_news = '`'.DB_TABLE_PREFIX.'t_news`';
        
        parent::__construct();
    }
    
    public static function _install() {
        $file = osc_plugin_resource('news-manager/assets/create_table.sql');
        $sql = file_get_contents($file);
        
        if (self::newInstance()->dao->importSQL($sql)) {
            throw new Exception( "Error importSQL::nm<br>".$file ) ;
        }
        
        $opts = self::newInstance()->_opt(); $pref = self::newInstance()->_sect();       
        foreach ($opts AS $k => $v) {
            if (!osc_set_preference($k, $v[0], $pref, $v[1])) {
                return false;    
            }
        }
        return true;            
    }
    
    function _uninstall() {
        $pref = $this->_sect();                
        Preference::newInstance()->delete(array("s_section" => $pref));    
        $this->dao->query(sprintf('DROP TABLE %s', $this->_table_news));    
    }
    
    function _opt($key = false) {                
        $opts = array(
            'news_bxslider'     => array('1', 'BOOLEAN'),
            'news_fontawesome'  => array('1', 'BOOLEAN'),
            'news_bootstrap'    => array('1', 'BOOLEAN'),
            'news_wysiwyg'      => array('1', 'BOOLEAN'),
            'news_height'       => array('400px', 'STRING'),
            'news_width'        => array('100%', 'STRING'),
            'news_border'       => array('', 'STRING'),
            'news_borderradius' => array('', 'STRING'),
            'news_background'   => array('', 'STRING')
        );
        
        if ($key) { return $opts[$key]; }
                
        return $opts;
    }
    
    function _sect() {
        return 'plugin_newsmanager';
    }
    
    function _admin_menu_draw() {
         AdminToolbar::newInstance()->add_submenu( array(
             'id'        => 'bt_tools_menu',
             'subid'     => 'News',
             'title'     => 'News Management',
             'href'      => osc_admin_render_plugin_url(dirname(osc_plugin_folder(__FILE__)).'/admin/news.php'),
             'meta'      => array('class' => 'news'),
             'target'    => '_self'
         ));    
    }

    function _get($opt = false) {
        $pref = $this->_sect();
        if ($opt) {        
            return osc_get_preference($opt, $pref);
        } else {
            $opts = array(
                'news_bxslider'     => osc_get_preference('news_bxslider', $pref),
                'news_fontawesome'  => osc_get_preference('news_fontawesome', $pref),
                'news_bootstrap'    => osc_get_preference('news_bootstrap', $pref),
                'news_wysiwyg'      => osc_get_preference('news_wysiwyg', $pref),
                'news_height'       => osc_get_preference('news_height', $pref),
                'news_width'        => osc_get_preference('news_width', $pref),
                'news_border'       => osc_get_preference('news_border', $pref),
                'news_borderradius' => osc_get_preference('news_borderradius', $pref),
                'news_background'   => osc_get_preference('news_background', $pref)
            );
            return $opts;
        }
    }
    
    function _saveSettings($params) {
        $data = array(
            'news_bxslider'     => $params['news_bxslider'],
            'news_fontawesome'  => $params['news_fontawesome'],
            'news_bootstrap'    => $params['news_bootstrap'],
            'news_wysiwyg'      => $params['news_wysiwyg'],
            'news_height'       => $params['news_height'],
            'news_width'        => $params['news_width'],
            'news_border'       => $params['news_border'],
            'news_borderradius' => $params['news_borderradius'],
            'news_background'   => $params['news_background'],
        );
        
        $pref = $this->_sect();
        $forbidden = array('CSRFName', 'CSRFToken', 'page', 'file', 'action', 'news');
        
        foreach($data as $k => $v) {
            if (!in_array($k, $forbidden)) {
                $opt = $this->_opt($k);
                if (empty($v)) { 
                    osc_delete_preference($k, $pref); 
                } else {
                    if (!osc_set_preference($k, $v, $pref, $opt[1])) {
                        return false;
                    }   
                }
                
            }
        }
        return true;
    }
    
    function showNews() {
        include_once(osc_plugin_path('news-manager/view/news.php'));
    }
    
    function _readNews($id = false) {
        $this->dao->select('*');
        $this->dao->from($this->_table_news);
        
        if (is_numeric($id)) {
            $this->dao->where('pk_i_id', $id);
        }

        $this->dao->orderBy('i_priority', 'ASC');
        $result = $this->dao->get();
        if (!$result) { return false; }
            
        if (is_numeric($id)) {
            return $result->row();
        } else {
            return $result->result();    
        }
    }
    
    function _saveNews($news, $edit = false) {
        if (!empty($news)) {
            if ($edit) {
                if (!$this->dao->update($this->_table_news, array('message' => $news), array('pk_i_id' => $edit))) {
                    return false;    
                }    
            } else {
                if (!$this->dao->insert($this->_table_news, array('message' => $news))) {
                    return false;    
                }    
            }                
        } else {
            return false;
        }
        return true;
    }
    
    function _deleteNews($id) {
        if (!$this->dao->delete($this->_table_news, 'pk_i_id = '.$id)) {
            return false;
        }
        return true;
    }
    
    function _saveOrder($order) {
        $i = 1;
        foreach($order as $v) {
            if (!$this->dao->update($this->_table_news, array('i_priority' => $i), array('pk_i_id' => $v))) {
                return false;
            }
            $i++;
        }
        return true;
    }
    
    function r($var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }    
}
?>