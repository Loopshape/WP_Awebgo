<?php
use Webcodin\WCPContactForm\Core\Agp_Module;

class SCFP_FormEntries extends Agp_Module {
    
    /**
     * @var object The single instance of the class 
     */
    protected static $_instance = null;    
    
	/**
	 * Main Instance
	 *
     * @return Visualizer
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( dirname(dirname(__FILE__)) );
		}
		return self::$_instance;
	}    
    
	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
    }        
    
    public function __construct($baseDir) {
        parent::__construct($baseDir);        
        
        add_filter( 'post_row_actions', array( $this, 'changeRowActions' ), 10, 2 );        
        add_action( 'admin_menu', array( $this, 'disableNewPost' ) );                
        add_action( 'admin_menu', array( $this, 'changeMenuLabels' ) );                        
        add_action( 'init', array( $this, 'customPostStatus' ) );   
        add_action( 'admin_footer-post.php', array( $this, 'appendPostStatusList' ) );        
        add_action( 'admin_footer-edit.php', array( $this, 'appendCustomBulkActions' ) );                
        add_filter( 'display_post_states', array( $this, 'displayUnreadState' ) ); 
        add_filter( 'bulk_actions-edit-form-entries', array( $this, 'changeBulkActions') );        
        add_action( 'load-post.php', array( $this, 'customActions' ) );       
        add_action( 'load-edit.php', array( $this, 'customBulkActions' ) );               
        add_action( 'admin_notices', array( $this, 'customAdminNotices' ) ); 
        add_filter( 'views_edit-form-entries', array( $this, 'changeViews') ); 
        
        add_action( 'admin_menu', array( $this, 'appendViewPage' ) ); 
        
        add_filter('manage_form-entries_posts_columns', array( $this, 'entrieColumns' ) );
        add_filter('manage_form-entries_posts_custom_column', array( $this, 'fillEntrieColumns' ) );
        add_filter('manage_edit-form-entries_sortable_columns', array( $this, 'addSortableColumns' ) );
        
        add_action( 'pre_get_posts', array( $this, 'manageEntriesPreGetPosts' ) );
        add_action( 'trashed_post', array( $this, 'redirectAfterTrashing' ), 10 );
        add_filter( 'get_edit_post_link', array( $this, 'getEditPostLink' ), 10, 3 );
        add_action( 'admin_init', array( $this, 'markRead' ));
        add_action( 'plugins_loaded', array( $this, 'downloadCsv' ));
        
        add_filter( 'parent_file', array($this, 'currentMenu') ); 
        
        add_action( 'admin_bar_menu', array($this, 'adminBarMenu'), 999, 1 );
    }
    
    public function changeMenuLabels () {
        global $menu;
        
        if (!empty($menu) && is_array($menu)) {
            foreach ($menu as &$menuItem) {
                if (!empty($menuItem) && is_array($menuItem)) {
                    if ($menuItem[2] == 'scfp') {
                        $count = SCFP_Form::getUnreadEntriesCount();
                        if ($count) {
                            if ($count > 99) {
                                $count = '99+';
                            }
                            $menuItem[0] = $menuItem[0] . '</span><span class="wcp-items"><span class="wcp-items-count">' . $count . '</span></span>';
                        }
                    }
                }
                
            }
        }
        
    }
    
    public function adminBarMenu ($admin_bar) {
        global $wp_admin_bar;

        if ( !is_super_admin() || !is_admin_bar_showing() )
            return;
        
        $count = SCFP_Form::getUnreadEntriesCount();
        if ($count > 99) {
            $count = '99+';
        }
        
        $count = $count ? '<span class="ab-items"><span class="ab-items-count">' . $count . '</span></span>' : '';
        
        $wp_admin_bar->add_menu(array(
            'id' => 'wcp-contactform-menu',
            'title' => '<span class="ab-icon"></span><span class="ab-label">Contact Form</span>' . $count,
            'parent' => '',
            'href' => admin_url( 'edit.php?post_status=unread&post_type=form-entries'),
            'group' => NULL,
            'meta' => array(
            ),
        ));
        
        $wp_admin_bar->add_menu(array(
            'id' => 'wcp-contactform-menu-inbox',
            'title' => 'Inbox',
            'parent' => 'wcp-contactform-menu',
            'href' => admin_url( 'edit.php?post_type=form-entries'),
            'group' => NULL,
            'meta' => array(
            ),
        ));        
        
        $wp_admin_bar->add_menu(array(
            'id' => 'wcp-contactform-menu-settings',
            'title' => 'Settings',
            'parent' => 'wcp-contactform-menu',
            'href' => admin_url( 'admin.php?page=scfp_plugin_options'),
            'group' => NULL,
            'meta' => array(
            ),
        ));                
    }
    
    public function currentMenu($parent_file){
        global $submenu_file, $pagenow, $plugin_page;

        if ($pagenow == 'admin.php' && !empty($_REQUEST['post']) && !empty($_REQUEST['page']) && $_REQUEST['page'] == 'view-entry') {
            $p = $_REQUEST['post'];
            $postType = get_post_type($p);
                     
            if ($postType == 'form-entries') {
                $parent_file = 'admin.php?page=scfp_plugin_options';
                $submenu_file = 'edit.php?post_type=form-entries';
                $plugin_page = 'edit.php?post_type=form-entries';
            }
        }

        
        return $parent_file;

    }         
    
    public function appendViewPage () {
        add_submenu_page( 'admin.php', 'Entry', 'Entry', 'manage_options', 'view-entry', array( $this, 'displayViewPage' ) );        
    }
    
    public function displayViewPage () {
        if (!empty($_GET['post'])) {
            $post = get_post($_GET['post']);
            echo $this->getTemplate('admin/form-view', $post);    
        }
        
    }
    
    public function disableNewPost() {
        global $submenu;
        unset($submenu['edit.php?post_type=form-entries'][10]);

        if (isset($_GET['post_type']) && $_GET['post_type'] == 'form-entries' && empty($_GET['download_csv'])) {
            echo '<style type="text/css">
            #favorite-actions, .add-new-h2 { display:none; }
            </style>';
        }
    }  
    
    public function customPostStatus(){
        register_post_status( 'read', array(
                'label'                     => _x( 'Read', 'form-entries' ),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 'Read <span class="count">(%s)</span>', 'Read <span class="count">(%s)</span>' ),
            ) 
        );
        
        register_post_status( 'unread', array(
                'label'                     => _x( 'Unread', 'form-entries' ),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 'Unread <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
            ) 
        );
    }
    
    
    public function appendPostStatusList(){
        global $post;
        $unread_complete = $read_complete = '';
        $unread_label = $read_label = '';
        if($post->post_type == 'form-entries' && empty($_GET['download_csv'])) :
            if($post->post_status == 'unread') {
                 $unread_complete = ' selected="selected"';
                 $unread_label = '<span id="post-status-display"> Unread</span>';
            }
            if($post->post_status == 'read') {
                 $read_complete = ' selected="selected"';
                 $read_label = '<span id="post-status-display"> Read</span>';
            }            
        ?>    
            <script type="text/javascript">
            jQuery(document).ready(function($){
                 $("select#post_status").append('<option value="unread"<?php echo $unread_complete; ?>>Unread</option>');
                 $(".misc-pub-section label").append('<?php echo $unread_label; ?>');
                 $("select#post_status").append('<option value="read"<?php echo $read_complete; ?>>Read</option>');
                 $(".misc-pub-section label").append('<?php echo $read_label; ?>');                 
            });
            </script>
        <?php            
        endif;
    }    
    
    public function appendCustomBulkActions () {
        global $post_type;

        if ($post_type == 'form-entries' && empty($_GET['download_csv'])) {
            $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : '';
            
        ?>
            <script type="text/javascript">
            jQuery(document).ready(function($){
                <?php if (empty($post_status) || $post_status == 'unread' || $post_status == 'all') :?>
                    $('<option>').val('read').text('<?php _e('Mark as Read')?>').insertBefore("select[name='action'] option[value=trash]");
                    $('<option>').val('read').text('<?php _e('Mark as Read')?>').insertBefore("select[name='action2'] option[value=trash]");
                <?php endif;?>                        
                <?php if (empty($post_status) || $post_status == 'read' || $post_status == 'all') :?>
                    $('<option>').val('unread').text('<?php _e('Mark as Unread')?>').insertBefore("select[name='action'] option[value=trash]");
                    $('<option>').val('unread').text('<?php _e('Mark as Unread')?>').insertBefore("select[name='action2'] option[value=trash]");
                <?php endif;?>                        
            });
            </script>
        <?php
        }        
    }
    
    public function displayUnreadState( $states ) {
        global $post;
        $arg = get_query_var( 'post_status' );
        if( $arg != 'unread' ){
             if($post->post_status == 'unread'){
                  return array('Unread');
             }
        }
        return $states;
    }

    
    public function changeRowActions( $actions, $post ) {
        if ( get_post_type() === 'form-entries' && empty($_GET['download_csv']) ) {
            $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : '';
            $res = array();                            
            switch ($post_status) {
                case '':
                case 'all':                    
                case 'read':
                case 'unread':             
                    $res['view'] = '<a title="View" href="'.admin_url( 'admin.php?post='. $post->ID .'&page=view-entry' ).'">View</a>';
                    if ($post->post_status == 'unread') {
                        $res['read'] = '<a title="Mark as Read" href="'.admin_url( 'post.php?post='. $post->ID .'&action=read'.(!empty($post_status) ? '&post_status='.$post_status : '') ).'">Mark as Read</a>';    
                    } else {
                        $res['unread'] = '<a title="Mark as Unread" href="'.admin_url( 'post.php?post='. $post->ID .'&action=unread'.(!empty($post_status) ? '&post_status='.$post_status : '') ).'">Mark as Unread</a>';    
                    }
                    $res['trash'] = $actions['trash'];                
                    break;
                default :
                    $res = $actions;
                    break;
            }
            
            $actions = $res;
        }
        return $actions;
    }        
    
    public function dataCsv(){
        //get header
        $this->customPostStatus();
        $data = SCFP()->getSettings()->getFieldsSettings();

        
        $header = array();
        foreach( $data as $datakey => $datavalue ){
            if( $datavalue['field_type'] != 'captcha' && $datavalue['field_type'] != 'captcha-recaptcha' && !empty($datavalue['visibility']) && !empty($datavalue['exportCSV']) ){
               $header[] = $datavalue['name'];
            }
        }
        $header = implode(';', $header)."\n";

        $args = array_merge(array(
            'post_status' => 'any',
            'posts_per_page' => -1
        ), $_REQUEST);

        if ($args['post_status'] == 'all') {
            $args['post_status'] = 'any';    
        }
        
        $query = new WP_Query($args);            
        
        //get data
        $content = '';
        foreach ( $query->posts as $key => $p ) {
            $post_ID = $p->ID;
            $content_row = array();
            foreach( $data as $datakey => $datavalue ){
                if( $datavalue['field_type'] != 'captcha' && $datavalue['field_type'] != 'captcha-recaptcha' && !empty($datavalue['visibility']) && !empty($datavalue['exportCSV']) ){
                    
                    if( $datavalue['field_type'] == 'checkbox' ){
                        $subscribe = html_entity_decode( strip_tags( get_post_meta( $post_ID, 'scfp_'.$datakey, true ) ) ); 
                        $row =  !empty( $subscribe )? 'Yes' : 'No'; 
                        $content_row[] = str_replace( chr(13).chr(10), " ", $row );
                    } else {
                        $row = html_entity_decode(strip_tags( get_post_meta( $post_ID, 'scfp_'.$datakey, true ) ));
                        $content_row[] = str_replace( chr(13).chr(10), " ", $row );
                    }
                }
            }
            $content .= implode(';', $content_row)."\n";
        }
        
        return $result = $header . $content;
    }
    
    public function downloadCsv(){
        
        if( !empty( $_GET['download_csv'] ) ){
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=" . date( 'YmdHis' ) . ".csv");
            header("Pragma: no-cache");
            header("Expires: 0");            
            
            $result = $this->dataCsv();

            echo $result;
            
            exit();
        }        
    }
    
    public function changeBulkActions ($actions) {
        $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : '';
        switch ($post_status) {
            case '':
            case 'all':                                    
            case 'read':                
            case 'unread':                
                $res = array(
                    'trash' => $actions['trash'],                
                );
                break;
            default :
                $res = $actions;
                break;
        }
        return $res;
    }

    public function customActions () {
        $post_id = !empty($_GET['post']) ? $_GET['post'] : NULL;        
        $action = !empty($_GET['action']) ? $_GET['action'] : NULL;        
        $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : NULL;        
        
        switch ($action) {
            case 'read':
                if (!empty($post_id)) {
                    $post = get_post($post_id);
                    
                    $args = array(
                        'ID' => $post_id,
                        'post_status' => 'read',
                    );
                    wp_update_post($args);
                    
                    $count_posts = wp_count_posts($post->post_type);
                    $sendback = add_query_arg( array('post_type' => $post->post_type), admin_url( 'edit.php' ) );
                    if (!empty($post_status) && $count_posts->$post_status > 0) {
                        $sendback = add_query_arg( array('post_status' => $post_status), $sendback );    
                    }
                    $sendback = add_query_arg( array('readed' => 1, 'ids' => $post_id ), $sendback );                        
                    
                    wp_redirect($sendback);
                    exit();                
                }
                break;
            case 'unread':
                if (!empty($post_id)) {
                    $post = get_post($post_id);

                    $args = array(
                        'ID' => $post_id,
                        'post_status' => 'unread',
                    );
                    wp_update_post($args);
                    
                    $count_posts = wp_count_posts($post->post_type);
                    $sendback = add_query_arg( array('post_type' => $post->post_type), admin_url( 'edit.php' ) );
                    if (!empty($post_status) && $count_posts->$post_status > 0) {
                        $sendback = add_query_arg( array('post_status' => $post_status), $sendback );    
                    }
                    $sendback = add_query_arg( array('unreaded' => 1, 'ids' => $post_id ), $sendback );                        
                    
                    wp_redirect($sendback);
                    exit();                
                }
                break;
        }
    }

    public function customBulkActions() {
        $post_ids = !empty($_GET['post']) ? $_GET['post'] : NULL;
        $post_type = !empty($_GET['post_type']) ? $_GET['post_type'] : NULL;
        
        if (!empty($post_ids)) {
            check_admin_referer('bulk-posts');
            $action = ($_GET['action'] == -1) ? $_GET['action2'] : $_GET['action'];
            
            switch($action) {
                case 'read':
                    $process = 0;
                    foreach( $post_ids as $post_id ) {
                        $post = get_post($post_id);                        
                        
                        $args = array(
                            'ID' => $post_id,
                            'post_status' => 'read',
                        );
                        wp_update_post($args);
                        $process++;
                    }

                    $count_posts = wp_count_posts($post_type);
                    $sendback = add_query_arg( array('post_type' => $post_type), admin_url( 'edit.php' ) );
                    if (!empty($post_status) && $count_posts->$action > 0) {
                        $sendback = add_query_arg( array('post_status' => $action), $sendback );    
                    }
                    $sendback = add_query_arg( array('readed' => $process, 'ids' => join(',', $post_ids) ), $sendback );                        
                    
                    wp_redirect($sendback);
                    exit();                 
                    break;
                case 'unread':
                    $process = 0;
                    foreach( $post_ids as $post_id ) {
                        $post = get_post($post_id);                        
                        
                        $args = array(
                            'ID' => $post_id,
                            'post_status' => 'unread',
                        );
                        wp_update_post($args);
                        $process++;
                    }

                    $count_posts = wp_count_posts($post_type);
                    $sendback = add_query_arg( array('post_type' => $post_type), admin_url( 'edit.php' ) );
                    if (!empty($post_status) && $count_posts->$action > 0) {
                        $sendback = add_query_arg( array('post_status' => $action), $sendback );    
                    }
                    $sendback = add_query_arg( array('unreaded' => $process, 'ids' => join(',', $post_ids) ), $sendback );                        
                    
                    wp_redirect($sendback);
                    exit();                 
                    break;                
                default: return;
            }
        }
    }
    
        
    public function customAdminNotices() {

        global $post_type, $pagenow;

        if ( $pagenow == 'edit.php' && $post_type == 'form-entries' && empty($_GET['download_csv']) ) {
            if (isset($_REQUEST['readed']) && (int) $_REQUEST['readed'] > 1) {
                $message = $_REQUEST['readed'] . ' entries was marked as Read';
                echo '<div class="updated"><p>'.$message.'</p></div>';
            } elseif (isset($_REQUEST['readed']) && (int) $_REQUEST['readed'] = 1) {
                $message = $_REQUEST['readed'] . ' entry was marked as Read';
                echo '<div class="updated"><p>'.$message.'</p></div>';
            } elseif (isset($_REQUEST['unreaded']) && (int) $_REQUEST['unreaded'] > 1) {
                $message = $_REQUEST['unreaded'] . ' entries was marked as Unread';
                echo '<div class="updated"><p>'.$message.'</p></div>';
            } elseif (isset($_REQUEST['unreaded']) && (int) $_REQUEST['unreaded'] = 1) {
                $message = $_REQUEST['unreaded'] . ' entry was marked as Unread';
                echo '<div class="updated"><p>'.$message.'</p></div>';
            }
        }
    }    

    public function changeViews ($views) {
        global $post_type, $pagenow;
        if ( $pagenow == 'edit.php' && $post_type == 'form-entries' && empty($_GET['download_csv']) ) {

            $key = 'trash';
            if (array_key_exists($key, $views)) {
                $value = $views[$key];
                unset($views[$key]);
                array_unshift($views, $value);
            }            

            $key = 'read';
            if (array_key_exists($key, $views)) {
                $value = $views[$key];
                unset($views[$key]);
                array_unshift($views, $value);
            }                        
            
            $key = 'unread';
            if (array_key_exists($key, $views)) {
                $value = $views[$key];
                unset($views[$key]);
                array_unshift($views, $value);
            }                                    
            
            $key = 'all';
            if (array_key_exists($key, $views)) {
                $value = $views[$key];
                unset($views[$key]);
                array_unshift($views, $value);
            }                                                
        }
        
        return $views;
    }

    public function entrieColumns( $columns ){
        unset( $columns['title'] );

        
        $results['cb'] = '<input type="checkbox" />';
        
        $results['title'] = 'ID';

        $fields = SCFP()->getSettings()->getFieldsSettings();        
        foreach( $fields as $key => $value ):
            if (!empty( $value['visibility'] ) && $value['field_type'] !== 'captcha' && $value['field_type'] != 'captcha-recaptcha' && $value['field_type'] !== 'textarea') :
                $results[$key] = $value['name'];    
            endif;
        endforeach;

        $results['date'] = $columns['date']; 
        $results['reply'] = 'Reply'; 
        

        return $results;
    }
    
    public function fillEntrieColumns( $column ){
        global $post;

        switch ( $column ) {
            case 'title' :
                echo get_post_meta( $post->ID, 'entry_id', true );
                break;
            case 'reply' :
                echo $this->getReplyButton($post->ID,'',array('class'=>'scfp-reply-icon')); 
                break;            
            default :
                $fields = SCFP()->getSettings()->getFieldsSettings();        
                foreach( $fields as $key => $value ):
                    if ($key == $column && !empty( $value['visibility'] ) && $value['field_type'] !== 'captcha' && $value['field_type'] != 'captcha-recaptcha' && $value['field_type'] !== 'textarea') :
                        if ($value['field_type'] == 'checkbox') {
                            $data = get_post_meta( $post->ID, "scfp_{$key}", true ); 
                            echo !empty( $data )? 'Yes' : 'No'; 
                        } else {
                            echo get_post_meta( $post->ID, "scfp_{$key}", true );
                        }
                    endif;
                endforeach;
                break;
        }
    }
    
    public function addSortableColumns($sortable_columns){
        $sortable_columns['id'] = 'id';
        
        $fields = SCFP()->getSettings()->getFieldsSettings();        
        foreach( $fields as $key => $value ):
            if (!empty( $value['visibility'] ) && $value['field_type'] !== 'captcha' && $value['field_type'] != 'captcha-recaptcha' && $value['field_type'] !== 'textarea') :
                $sortable_columns[$key] = $key;
            endif;
        endforeach;        
        
        return $sortable_columns;
    }
    
    public function manageEntriesPreGetPosts($query){
        if( ! is_admin() )
        return;
 
        $orderby = $query->get( 'orderby');

        if( 'entry_id' == $orderby ) {
            $query->set('meta_key','entry_id');
            $query->set('orderby','meta_value_num');
        }
      
    }
    
    public function getEntryId($post_id){
        return get_post_meta( $post_id, 'entry_id', true );
    }
    
    public function redirectAfterTrashing( $post_id ) {
        global $pagenow;

        if( get_post_type( $post_id ) == 'form-entries' && $pagenow == 'post.php' && empty($_GET['download_csv'])){
            wp_redirect( admin_url("edit.php?post_type=form-entries") );
            exit;
        }
    }
    
    public function getEditPostLink($link, $post_id, $context) {
        global $pagenow;
        
         if( get_post_type( $post_id ) == 'form-entries' && $pagenow == 'edit.php' && empty($_GET['download_csv'])){
            $link = admin_url( 'admin.php?post='. $post_id .'&page=view-entry' );
        }
        
        return $link;
    }
    
    public function markRead($a) {
        global $pagenow;
        if ($pagenow == 'admin.php' && !empty($_REQUEST['page']) && $_REQUEST['page'] == 'view-entry') {
            if (!empty($_REQUEST['post'])) {
                wp_update_post( array(
                        'ID'           => $_REQUEST['post'],
                        'post_status'   =>  'read',
                    )
                );                            
            }    
        }
    }
    
    public function getReplyButton ($postId, $title = '', $atts = array()) {
        $result = '';
        $settings = SCFP()->getSettings()->getNotificationSettings();
        $key = !empty($settings['user_email']) ? $settings['user_email'] : 'email';
        
        $atts_s = '';
        if (is_array($atts) && !empty($atts)) {
            foreach ($atts as $k => $value) {
                $atts_s .= $k . '="' . $value . '"';
            }
        }
        
        $mail = get_post_meta( $postId, "scfp_{$key}", true ); 
        if (!empty($mail)) {
            $result = sprintf('<a href="mailto:%s" %s><span class="dashicons dashicons-email-alt"></span>%s</a>', $mail, $atts_s, $title);
        }
        
        return $result;
    }
}

