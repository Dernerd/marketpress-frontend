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
   <?php settings_fields('wpmpf-woosettings-group'); ?>
   <?php register_wpmpf_woosettings('wpmpf-woosettings-group'); ?>
     <?php 
								
						
								$posttype = get_option('posttype'); 
								$posttaxonomies = get_option('posttaxonomies'); 
								$autopublish = get_option('autopublish'); 
								$posttags = get_option('posttags'); 
								$posttitleenabledisables = get_option('posttitleenabledisables'); 
								$postdiscriptionenabledisable = get_option('postdiscriptionenabledisable');
								$postauthorenabledisable  = get_option('postauthorenabledisable');
								$postcategoryenabledisable = get_option('postcategoryenabledisable');
								$uploadimageenabledisable = get_option('uploadimageenabledisable');
								$uploadgalleyenabledisable = get_option('uploadgalleyenabledisable');
								$tagsenabledisable = get_option('tagsenabledisable');
								$expertsenabledisable = get_option('expertsenabledisable');
								$downloadableenabledisable = get_option('downloadableenabledisable'); 
								$titlerequire = get_option('titlerequire'); 
								$discriptionrequire = get_option('discriptionrequire'); 
								$categoryrequire = get_option('categoryrequire'); 
								$featurerequire = get_option('featurerequire'); 
								$galleryrequire = get_option('galleryrequire'); 
								$tagsrequire = get_option('tagsrequire'); 
								$expertrequire = get_option('expertrequire'); 
								$downloadablerequire = get_option('downloadablerequire'); 
                                $ecommerce = get_option('ecommerce'); 
								



								?>

        <input type="hidden" name="ecommerce" value="marketpress"/>
              
                
                  <table class="form-table">
                <br/> 
                                <b>  Select Post Type and taxnomy </b><p>where you want to post to publish<br/>(Note* For MarketPress select "product", "product_category"  and "product_tag"</p>
                <tr valign="top">
                        <th scope="row">Product Post Type:</th>
                    <td><select name="posttype"> 
					<?php 
$post_types=get_post_types('','names'); 
foreach ($post_types as $post_type ) {
	?><option <?php if ($posttype == $post_type) echo 'selected="selected"'; ?> value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option> <?php
 
}
?>
</select></td>
                </tr>
                 <tr valign="top">
                        <th scope="row">Product category:</th>
                    <td><select name="posttaxonomies"> 
                <?php 
$taxonomies=get_taxonomies('','names'); 
foreach ($taxonomies as $taxonomy ) { ?>

<option <?php if ($posttaxonomies == $taxonomy) echo 'selected="selected"'; ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomy; ?></option> <?php
 
}
?>
</select></td>
                </tr>
                
                  <tr valign="top">
                        <th scope="row">Product tags:</th>
                    <td><select name="posttags"> 
                <?php 
$taxonomies=get_taxonomies('','names'); 
foreach ($taxonomies as $taxonomy ) { ?>

<option <?php if ($posttags == $taxonomy) echo 'selected="selected"'; ?> value="<?php echo $taxonomy; ?>"><?php echo $taxonomy; ?></option> <?php
 
}
?>
</select></td>
                </tr>
                
                 <tr valign="top">
                    <th scope="row">Auto Publish?:</th>
                    <td><select name="autopublish">
										<option <?php if ($autopublish == 'publish') echo 'selected="selected"'; ?> value="publish"><?php _e('Publish'); ?></option>
										<option <?php if ($autopublish == 'pending') echo 'selected="selected"'; ?> value="pending"><?php _e('Pending'); ?></option>
									</select></td>
                </tr>

</table>

<table class="form-table">
            
    <br/> <br/> <br/>
                                <b>  enable or disable option which you don't want in front page: </b>
                                
                                
                                             <tr valign="top">
                    <th scope="row">Post Title:</th>
                    <td><select name="posttitleenabledisables">
										<option <?php if ($posttitleenabledisables == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($posttitleenabledisables == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
                
                                                             <tr valign="top">
                    <th scope="row">Post Discription:</th>
                    <td><select name="postdiscriptionenabledisable">
										<option <?php if ($postdiscriptionenabledisable == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($postdiscriptionenabledisable == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
 
                
                                                             <tr valign="top">
                    <th scope="row">Post Category:</th>
                    <td><select name="postcategoryenabledisable">
										<option <?php if ($postcategoryenabledisable == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($postcategoryenabledisable == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
                
                
                                                             <tr valign="top">
                    <th scope="row">Feature Image:</th>
                    <td><select name="uploadimageenabledisable">
										<option <?php if ($uploadimageenabledisable == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($uploadimageenabledisable == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
                
                
                             <th scope="row">Tags:</th>
                    <td><select name="tagsenabledisable">
										<option <?php if ($tagsenabledisable == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($tagsenabledisable == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
                
                             <th scope="row">Excerpt Post:</th>
                    <td><select name="expertsenabledisable">
										<option <?php if ($expertsenabledisable == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($expertsenabledisable == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
                
                                     <th scope="row">Downloadable:</th>
                    <td><select name="downloadableenabledisable">
										<option <?php if ($downloadableenabledisable == 'enable') echo 'selected="selected"'; ?> value="enable"><?php _e('enable'); ?></option>
										<option <?php if ($downloadableenabledisable == 'disable') echo 'selected="selected"'; ?> value="disable"><?php _e('disable'); ?></option>
									</select></td>
                </tr>
                
                   
            </table>
            
            
            <table class="form-table">
            
    <br/> <br/> <br/>
                                <b> Create field required(tick checkbox which filed you want require): </b>
                                
                                
                                             <tr valign="top">
                    <th scope="row">Post Title:</th>
                    <td><input type="checkbox" name="titlerequire" value="require" <?php if ( 'require' == $titlerequire ) echo 'checked="checked"'; ?> /></td>
                </tr>
                                                             <tr valign="top">
                    <th scope="row">Post Discription:</th>
                    <td><input type="checkbox" name="discriptionrequire" value="require" <?php if ( 'require' == $discriptionrequire ) echo 'checked="checked"'; ?> />(enable only if WP visual editor disable from Other Setting tab)</td>
                </tr>
                
                
                              
                                                             <tr valign="top">
                    <th scope="row">Post Category:</th>
                    <td><input type="checkbox" name="categoryrequire" value="require" <?php if ( 'require' == $categoryrequire ) echo 'checked="checked"'; ?> /></td>
                </tr>
                                            
                
                                                             <tr valign="top">
                    <th scope="row">Feature Image:</th>
                    <td><input type="checkbox" name="featurerequire" value="require" <?php if ( 'require' == $featurerequire ) echo 'checked="checked"'; ?> /></td>
                </tr>
                
           
                
                
                             <th scope="row">Tags:</th>
                    <td><input type="checkbox" name="tagsrequire" value="require" <?php if ( 'require' == $tagsrequire ) echo 'checked="checked"'; ?> /></td>
                </tr>
                
                
                             <th scope="row">Excerpt Post:</th>
                    <td><input type="checkbox" name="expertrequire" value="require" <?php if ( 'require' == $expertrequire ) echo 'checked="checked"'; ?> /></td>
                </tr>
                
                
                                     <th scope="row">Downloadable:</th>
                    <td><input type="checkbox" name="downloadablerequire" value="require" <?php if ( 'require' == $downloadablerequire ) echo 'checked="checked"'; ?> /></td>
                </tr>
                
                
                   
            </table>

	<?php submit_button(); ?>
            </form>
</div></div></div>
</div></div>