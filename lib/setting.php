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
                  <form method="post" action="options.php">
						 <p><b>labale Name:</b></p>
                                <?php              
			                    settings_fields('wpmpf-settings-group'); 
			                    register_wpmpf_settings('wpmpf-settings-group');
								$posttitleenabledisables = get_option('posttitleenabledisables'); 
								$postdiscriptionenabledisable = get_option('postdiscriptionenabledisable');
								$postauthorenabledisable  = get_option('postauthorenabledisable');
								$postcategoryenabledisable = get_option('postcategoryenabledisable');
								$uploadimageenabledisable = get_option('uploadimageenabledisable');
								$posttype = get_option('posttype'); 
								$posttaxonomies = get_option('posttaxonomies'); 
								$autopublish = get_option('autopublish'); 
								$enablecaptcha = get_option('enablecaptcha');
								$captchaprivatekey = get_option('captchaprivatekey');
								$guestpost = get_option('guestpost'); 
								$successmessage = get_option('successmessage'); 
								$imagesize = get_option('imagesize');
								$productprice = get_option('productprice'); 
								$productsaleprice = get_option('productsaleprice');
								$downloadfile = get_option('downloadfile');
								$productshortdiscription = get_option('productshortdiscription');
								$productshortdiscription = get_option('producttags');
								$taghelp = get_option('taghelp'); 
	                            $addnew = get_option('addnew'); 
								$mypost = get_option('mypost'); 
								$submitbutton = get_option('submitbutton'); 
								$uploadfeaturebutton = get_option('uploadfeaturebutton'); 
								$uploadgallerybutton = get_option('uploadgallerybutton'); 
								$uploaddownloadbutton = get_option('uploaddownloadbutton'); 
								$updatesuccessmessage = get_option('updatesuccessmessage'); 
								?>
								           <table class="form-table">
                <tr valign="top">
                    <th scope="row">Product Title:</th>
                    <td><input type="text" name="posttitle" value="<?php if(get_option('posttitle') < '1'){ echo 'Product Title';  } else { echo get_option('posttitle'); }; ?>" /> </td>
               
                </tr>

             <tr valign="top">
                    <th scope="row">Product Discription:</th>
                    <td><input type="text" name="postdiscription" value="<?php if(get_option('postdiscription') < '1'){ echo 'Product Discription';  } else { echo get_option('postdiscription'); };?>" /> </td>
                </tr>
                
                   <tr valign="top">
                    <th scope="row">Product Author:</th>
                    <td><input type="text" name="postauthor" value="<?php if(get_option('postauthor') < '1'){ echo 'Product Author';  } else { echo get_option('postauthor'); };?>" /> </td>
                </tr>
 
                   <tr valign="top">
                    <th scope="row">Product Category:</th>
                    <td><input type="text" name="postcategory" value="<?php if(get_option('postcategory')  < '1'){ echo 'Product Category';  } else { echo get_option('postcategory'); };?>" /></td>
                </tr>

                   <tr valign="top">
                    <th scope="row">Product Tags:</th>
                    <td><input type="text" name="producttags" value="<?php if(get_option('producttags')  < '1'){ echo 'Product Tags';  } else { echo get_option('producttags'); };?>" /></td>
                </tr>                
                
                     <tr valign="top">
                    <th scope="row">Product Featured Image:</th>
                    <td><input type="text" name="uploadimage" value="<?php if(get_option('uploadimage')  < '1'){ echo 'Product Image';  } else { echo get_option('uploadimage'); };?>" /></td>
                </tr> 
                
                  <tr valign="top">
                    <th scope="row">Product Gallery Image:</th>
                    <td><input type="text" name="galleryimage" value="<?php if(get_option('galleryimage')  < '1'){ echo 'Gallery Image';  } else { echo get_option('galleryimage'); };?>" /></td>
                </tr> 
                     <tr valign="top">
                    <th scope="row">Product Price:</th>
                    <td><input type="text" name="productprice" value="<?php if(get_option('productprice')  < '1'){ echo 'Product Price';  } else { echo get_option('uploadimage'); };?>" /></td>
                </tr>

                     <tr valign="top">
                    <th scope="row">Product Sale Price:</th>
                    <td><input type="text" name="productsaleprice" value="<?php if(get_option('productsaleprice')  < '1'){ echo 'Sale Price';  } else { echo get_option('productsaleprice'); };?>" /></td>
                </tr>
                
                     <tr valign="top">
                    <th scope="row">Upload File:</th>
                    <td><input type="text" name="downloadfile" value="<?php if(get_option('downloadfile')  < '1'){ echo 'Upload File';  } else { echo get_option('downloadfile'); };?>" /></td>
                </tr>
                
                     <tr valign="top">
                    <th scope="row">Product Short Description:</th>
                    <td><input type="text" name="productshortdiscription" value="<?php if(get_option('productshortdiscription')  < '1'){ echo 'Short Description';  } else { echo get_option('productshortdiscription'); };?>" /></td>
                </tr>
                                <tr valign="top">
                    <th scope="row">Add New Label:</th>
                    <td><input type="text" name="addnew" value="<?php if(get_option('addnew')  < '1'){ echo 'Add New';  } else { echo get_option('addnew'); };?>" /></td>
               
                </tr>
                  <tr valign="top">
                    <th scope="row">My Post Label:</th>
                    <td><input type="text" name="mypost" value="<?php if(get_option('mypost')  < '1'){ echo 'My Post';  } else { echo get_option('mypost'); };?>" /></td>
               
                </tr>
                       <tr valign="top">
                    <th scope="row">Tag Help Text:</th>
                    <td><input type="text" name="taghelp" value="<?php if(get_option('taghelp')  < '1'){ echo 'Separate Tags with Commas';  } else { echo get_option('taghelp'); };?>" /></td></tr>
                
                                  <tr valign="top">
                    <th scope="row">Success Message:</th>
                    <td><input type="text" name="successmessage" value="<?php if(get_option('successmessage')  < '1'){ echo 'Product published';  } else { echo get_option('successmessage'); };?>"/></td>
            
                </tr>
                
                                                  <tr valign="top">
                    <th scope="row">Update Success Message:</th>
                    <td><input type="text" name="updatesuccessmessage" value="<?php if(get_option('updatesuccessmessage')  < '1'){ echo 'Product Updated';  } else { echo get_option('updatesuccessmessage'); };?>"/></td>
            
                </tr>
                                         <tr valign="top">
                    <th scope="row">Submit Button:</th>
                    <td><input type="text" name="submitbutton" value="<?php if(get_option('submitbutton')  < '1'){ echo 'Publish';  } else { echo get_option('submitbutton'); };?>"/>(Submit Product Button Text)</td>
            
                </tr>   
                
                                                         <tr valign="top">
                    <th scope="row">Update Button:</th>
                    <td><input type="text" name="updatebutton" value="<?php if(get_option('updatebutton')  < '1'){ echo 'Update';  } else { echo get_option('updatebutton'); };?>"/>(Update Product Button Text)</td>
            
                </tr> 
            
                                         <tr valign="top">
                    <th scope="row">Feature Image Button:</th>
                    <td><input type="text" name="uploadfeaturebutton" value="<?php if(get_option('uploadfeaturebutton')  < '1'){ echo 'Upload Feature';  } else { echo get_option('uploadfeaturebutton'); };?>"/>(Upload Feature Image Button Text)</td>
            
                </tr>
                
                                                         <tr valign="top">
                    <th scope="row">Gallery Image Button:</th>
                    <td><input type="text" name="uploadgallerybutton" value="<?php if(get_option('uploadgallerybutton')  < '1'){ echo 'Upload Gallery';  } else { echo get_option('uploadgallerybutton'); };?>"/>(Upload Gallery Image Button Text)</td>
            
                </tr>
                
                                                         <tr valign="top">
                    <th scope="row">Download File Button:</th>
                    <td><input type="text" name="uploaddownloadbutton" value="<?php if(get_option('uploaddownloadbutton')  < '1'){ echo 'Upload Downloadable';  } else { echo get_option('uploaddownloadbutton'); };?>"/>(Upload Download File Button Text)</td>
            
                </tr>
                            </table>
                     
			<?php submit_button(); ?>
            </form>
							</div>
                            
					      </div>
 
                   </div>
            </div>
                