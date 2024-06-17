<div class="wrap">
  </h2>
  <div class="metabox-holder">
    <?php
                    function admin_tabs($tabs, $current=NULL){
    if(is_null($current)){
        if(isset($_GET['tab'])){
            $current = $_GET['tab'];
        }
    }
    $content = '';
    $content .= '<h2 class="nav-tab-wrapper">';
    foreach($tabs as $location => $tabname){
        if($current == $location){
            $class = ' nav-tab-active';
        } else{
            $class = '';    
        }
        $content .= '<a class="nav-tab'.$class.'" href="?page=wp-mp-frontend-post&tab='.$location.'">'.$tabname.'</a>';
    }
    $content .= '</h2>';
        return $content;
}

$my_plugin_tabs = array(    'wp-mp-frontend-post' => 'Labels',
    'wpmpf-presentation-setting' => 'Presentation',
    'wpmpf-payment-setting' => 'Membership',
	'wpmpf-other-setting' => 'Other',
	'wpmpf-custom-field-setting' => 'Custom Field',
	'wpmpf-help' => 'Help'
);

echo admin_tabs($my_plugin_tabs);
?>
    <?php settings_errors(); ?>
    <div id="mm-panel-overview" class="postbox">
      <div class="toggle default-hidden">
        <div id="mm-panel-options-wp-store">
          <?php
										
										    global $wpdb;

    $table = new custom_field_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_field'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
          <?php  if(isset($_GET['id'])){  ?>
          <h2><a class="add-new-h2"
                                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=wp-mp-frontend-post&tab=wpmpf-custom-field-setting');?>">
            <?php _e('back to list', 'custom_field')?>
            </a> </h2>
          <?php } else {

        ?>
          <h2><a class="add-new-h2"
                                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=wp-mp-frontend-post&tab=wpmpf-custom-field-setting');?>">
            <?php _e('Add New', 'custom_field')?>
            </a> </h2>
          <?php  } ?>
          <?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix

    $message = '';
    $notice = '';

    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
        'customfield' => '',
        'customlabel' => '',
		'customhelp' => '',
		'customrequire' => '',
		'customposition' => '',
        'type' => '',
		'customvalue' => '',
		
    );

    // here we are verifying does this request is post back and have correct nonce
    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        // combine our default item with request params
        $item = shortcode_atts($default, $_REQUEST);
        // validate data, and if all ok save item to database
        // if id is zero insert otherwise update
        $item_valid = custom_field_validate_person($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_name, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'custom_field');
					?>
          <?php
                } else {
                    $notice = __('There was an error while saving item', 'custom_field');
                }
            } else {
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'custom_field');
                } else {
                    $notice = __('There was an error while updating item', 'custom_field');
                }
            }
        } else {
            // if $item_valid not true it contains error message(s)
            $notice = $item_valid;
        }
    }
    else {
        // if this is not post back we load item to edit or give new one to create
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'custom_field');
            }
        }
    }

    // here we adding our custom meta box
    add_meta_box('persons_form_meta_box', 'Custom Field', 'custom_field_persons_form_meta_box_handler', 'person', 'normal', 'default');

    ?>
          <div class="wrap">
            <?php if (!empty($notice)): ?>
            <div id="notice" class="error">
              <p><?php echo $notice ?></p>
            </div>
            <?php endif;?>
            <?php if (!empty($message)): ?>
            <div id="message" class="updated">
              <p><?php echo $message ?></p>
            </div>
            <?php endif;?>
            <form id="form" method="POST">
              <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
              <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>
              <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
              <div class="metabox-holder" id="poststuff">
                <div id="post-body">
                  <div id="post-body-content">
                    <?php /* And here we call our custom meta box */ ?>
                    <?php do_meta_boxes('person', 'normal', $item); ?>
                    <input type="submit" value="<?php _e('Save', 'custom_field')?>" id="submit" class="button-primary" name="submit">
                    <br/>
                    <br/>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php  if(isset($_GET['id']) and (!isset($_GET['action'])) ){ echo'<div class="clear"></div>'; } else {

        ?>
          <form id="persons-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php $table->display() ?>
          </form>
          <?php  } ?>
        </div>
      </div>
    </div>
  </div>
</div>