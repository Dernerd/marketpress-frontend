 <div class="wrap">
 
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
                                        <form method="post" action="options.php">
   <?php settings_fields('wpmpf-paymentsetting-group'); ?>
   <?php register_wpmpf_woosettings('wpmpf-paymentsetting-group'); ?>
     <?php 
								
						        $woocommercevendor = get_option('woocommercevendor');
								$woovendor = get_option('woovendor'); 
								$ecomemrcevendor = get_option('ecomemrcevendor'); 
								$ecommercevendorrate = get_option('ecommercevendorrate'); 

                            
								?>
     <table class="form-table">
            <b>Membership Settings</b>
    <br/> 
               <?php  	
				 if( ( is_admin() && class_exists('membershipadmin') ) || ( !is_admin() && class_exists('membershippublic') ) ) {
					
											

		function get_membership_levels() {
		global $wpdb;
		return $wpdb->get_results( "SELECT * FROM " . membership_db_prefix($wpdb, 'membership_levels') . " WHERE level_active = 1;" );
	} ?>
    <tr valign="top">
                    <th scope="row">Select Membership Level:</th>
                    <td><select name='accesslevels' id='strangerlevel'>
       
							<option value="0"><?php _e('Disable', 'wpmpfrontend'); ?></option>

							<?php
							
							$levels = get_membership_levels();
                            $accesslevels = get_option('accesslevels'); 
							if ($levels) {
								foreach ($levels as $key => $level) {
							?>
							<option value="<?php echo esc_html($level->level_title); ?>" <?php if (esc_html($level->level_title) == $accesslevels) echo "selected='selected'"; ?>><?php echo esc_html($level->level_title); ?></option>
							<?php } }  ?>
						</select></td>
                </tr>
           
         <?php } else { ?> Please install <a href="http://wordpress.org/plugins/membership/">Membership </a>Plugin for use this function <?php } ?>
          
<br/>
              <tr valign="top">
                <th scope="row">Access Error</th>
                <td><textarea type="text" style="width:300px;" name="accesslevelserror"><?php
echo get_option('accesslevelserror'); ?>
</textarea>
                  <p> //Error when user don't have required level access</p></td>
              </tr>
    </table>
	<?php submit_button(); ?>
            </form>
</div></div></div>
</div></div>