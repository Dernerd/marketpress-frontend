<?php

//size of image
$imagesize = get_option('imagesize');
if (isset($imagesize[0])) {
    define('MAX_UPLOAD_SIZE', '' . $imagesize . '000000');
} else {
    define('MAX_UPLOAD_SIZE', 2000000);
}

define('TYPE_WHITELIST', serialize(array(
    'image/jpeg',
    'image/png',
    'image/gif'
)));


//shortocde for the plugin
add_shortcode('wp_store_frontend', 'wpmpf_form_shortcode');

//shortocde function
function wpmpf_form_shortcode()
{
    
    $ecommerce           = get_option('ecommerce');
    $woovendor           = get_option('woovendor');
    $ecomemrcevendor     = get_option('ecomemrcevendor');
    $ecommercevendorrate = get_option('ecommercevendorrate');
    $woocommercevendor   = get_option('woocommercevendor');
 if ($ecommerce == 'marketpress') {
	 	
		$accesslevel = get_option('accesslevels');
        if (!is_user_logged_in()) {
            
            include('login.php');
            return $out;
            
        }
		if ($accesslevel != '0') {
					 if( ( is_admin() && class_exists('membershipadmin') ) || ( !is_admin() && class_exists('membershippublic') ) ) {
                   
					 $user_id = get_current_user_id();
					
					$member = current_member();
					$rels = $member->get_relationships();
		
					if (!empty($rels)) {	
						foreach( (array) $rels as $rel ) {
							$sub = new M_Subscription( $rel->sub_id );
							$member = new M_Membership( $user_id );
							$level = new M_Level ( $rel->level_id);
			
		if ($level->level_title() == $accesslevel) {
			$accessgrant = 'true';
		}

		}
		}
		
		if( current_user_can('administrator') ) {
			
		}
		elseif(is_super_admin($user_id)) {
			
		}
		elseif($accessgrant == 'true') {


		}
		else {
			$accesslevelserror = get_option('accesslevelserror');
			if(empty($accesslevelserror)) {
			return "You don't have required access upgrade your account";
			}
			else {
				return $accesslevelserror;
			}
		}
		}
		}
    } else {
        
        if (!is_user_logged_in()) {
            
            include('login.php');
            return $out;
            
        }
        
    }
    global $current_user;
    
    if (isset($_POST['wpmpf_upload_image_form_submitted']) && wp_verify_nonce($_POST['wpmpf_upload_image_form_submitted'], 'wpmpf_upload_image_form')) {
        
        $result = wpmpf_parse_file_errors($_POST['wpmpf_caption'], $_POST['wpmpf_content'], $_POST['wpmpf_regular_price'], $_POST['wpmpf_sales_price'], $_POST['excerpt'], $_POST['tags']);
        
        if ($result['error']) {
            
            echo '<div class="error">';
            echo '<p>ERROR: ' . $result['error'] . '</p>';
            echo '</div>';
            
        } else {
            //post type, title, content, status,author submition process
            $enablecaptcha = get_option('enablecaptcha');
            if ($enablecaptcha == 'disable') {
               
				
				if (isset($_GET["status"]) AND $_GET["status"] == "edit") {
				$updatesuccessmessage = get_option('updatesuccessmessage');
                echo '<div class="success">';
                echo $updatesuccessmessage;
                echo '</div>';
				}
				else {
				$successmessage = get_option('successmessage');
		        echo '<div class="success">';
                echo $successmessage;
                echo '</div>';
				}
                $posttype    = get_option('posttype');
                $autopublish = get_option('autopublish');
                
                if (isset($_GET["status"]) AND $_GET["status"] == "edit") {
                    $id                = $_GET["postid"];
                    $user_image_update = array(
                        'ID' => $id,
                        'post_title' => sanitize_title($_POST['wpmpf_caption']),
                        'post_content' => $_POST['wpmpf_content'],
                        'post_excerpt' => $_POST['excerpt'],
                        'post_status' => $autopublish,
                        'post_author' => $current_user->ID,
                        'tags_input' => sanitize_title($_POST['tags']),
                        'post_type' => $posttype
                    );
                }
                
                else {
                    $user_image_data = array(
                        'post_title' => sanitize_title($_POST['wpmpf_caption']),
                        'post_content' => $_POST['wpmpf_content'],
                        'post_excerpt' => $_POST['excerpt'],
                        'post_status' => $autopublish,
                        'post_author' => $current_user->ID,
                        'tags_input' => sanitize_title($_POST['tags']),
                        'post_type' => $posttype
                    );
                }
                
                // What happens when the CAPTCHA was entered incorrectly
                if (isset($_GET["status"]) AND $_GET["status"] == "edit") {
                    $user_image_update['ID'] = $_REQUEST['postid'];
                    $post_id                 = $_REQUEST['postid'];
                    
                    if ($post_id = wp_update_post($user_image_update)) {
                        
                        
                            include('support/marketpress.php');
                    
                        
                    }
                } elseif ($post_id = wp_insert_post($user_image_data)) {
                    
                 
                        
                        include('support/marketpress.php');
           
                }
            } else {
                require_once('recaptchalib.php');
                $captchaprivatekey = get_option('captchaprivatekey');
                $privatekey        = $captchaprivatekey;
                $resp              = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                
                if (!$resp->is_valid) {
                    // What happens when the CAPTCHA was entered incorrectly
                    echo '<div class="error">';
                    echo "The reCAPTCHA wasn't entered correctly. try it again.";
                    echo '</div>';
                } else {
				if (isset($_GET["status"]) AND $_GET["status"] == "edit") {
				$updatesuccessmessage = get_option('updatesuccessmessage');
                echo '<div class="success">';
                echo $updatesuccessmessage;
                echo '</div>';
				}
				else {
				$successmessage = get_option('successmessage');
		        echo '<div class="success">';
                echo $successmessage;
                echo '</div>';
				}
                    $posttype        = get_option('posttype');
                    $autopublish     = get_option('autopublish');
                    $user_image_data = array(
                        'post_title' => sanitize_title($_POST['wpmpf_caption']),
                        'post_content' => $_POST['wpmpf_content'],
                        'post_excerpt' => $_POST['excerpt'],
                        'post_status' => $autopublish,
                        'post_author' => $current_user->ID,
                        'tags_input' => sanitize_title($_POST['tags']),
                        'post_type' => $posttype
                    );
                    
                    
                    // What happens when the CAPTCHA was entered incorrectly
                    
                    if ($post_id = wp_insert_post($user_image_data)) {
                        
              
                            include('support/marketpress.php');

                    }
                }
            }
        }
        
    }
    
    if (isset($_POST['wpmpf_form_delete_submitted']) && wp_verify_nonce($_POST['wpmpf_form_delete_submitted'], 'wpmpf_form_delete')) {
        
        if (isset($_POST['wpmpf_delete_id'])) {
            
            if ($post_deleted = wpmpf_delete_post($_POST['wpmpf_delete_id'])) {
                
                echo '<p>' . $post_deleted . ' images(s) deleted!</p>';
                
            }
        }
    }
    ob_start();
    wpmpf_get_upload_image_form();
    $editor_contents = ob_get_clean();
    
    // Return the content you want to the calling function
    return $editor_contents;
    
}


//this is error when any filed are empty

function wpmpf_parse_file_errors($file = '', $image_caption, $image_content)
{

    $posttile                = get_option('posttitle');
    $postdiscription         = get_option('postdiscription');
    $postcategory            = get_option('postcategory');
    $uploadimage             = get_option('uploadimage');
    $producttags             = get_option('producttags');
    $downloadfile            = get_option('downloadfile');
    $productshortdiscription = get_option('productshortdiscription');
    $galleryimage            = get_option('galleryimage');
   
}


//this code help to show form in front end 

function wpmpf_get_upload_image_form($wpmpf_caption = '', $category = 0)
{
    $userid    = get_current_user_id();
    $post_type = get_option('posttype');
    function count_user_posts_by_type($userid, $post_type)
    {
        global $wpdb;
        $where                     = get_posts_by_author_sql($post_type, true, $userid);
        $current_month             = date('m');
        $current_year              = date('Y');
        $last_day_of_current_month = date('t');
        $userid                    = get_current_user_id();
        //start date begins on the first with the timestamp at 00:00:00
        $start_date                = date('Y-m-d H:i:s', strtotime($current_year . '-' . $current_month . '-01'));
        //end date ends at midnight with a timestamp at 23:59:59 to get all posts in the month
        $end_date                  = date('Y-m-d', strtotime($current_year . '-' . $current_month . '-' . $last_day_of_current_month)) . ' 23:59:59';
        //echo "$start_date - $end_date\n";
        $count                     = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = '$post_type' AND post_status = 'publish' AND post_author='$userid' AND post_date >= '$start_date' AND post_date <= '$end_date'");
        
        return apply_filters('get_usernumposts', $count, $userid);
    }
    
    $user_post_count = count_user_posts_by_type($userid, $post_type);
    $enablepostlimit = get_option('enablepostlimit');
    
    
    
    $addnew = get_option('addnew');
    $mypost = get_option('mypost');
?>

<div class="wrap">
  <h2 class="nav-tab-wrapper"><a class="nav-tab <?php
    if (isset($_GET["status"]) AND $_GET["status"] == "post") {
        echo "nav-tab-active";
    }
?>" href="?status=post">
    <?php
    if (isset($mypost[0])) {
        echo get_option('mypost');
    } else {
        echo 'My Post';
    }
?>
    </a><a class="nav-tab <?php
    if (isset($_GET["status"]) AND $_GET["status"] == "addnew") {
        echo "nav-tab-active";
    }
?>" href="?status=addnew">
    <?php
    if (isset($addnew[0])) {
        echo get_option('addnew');
    } else {
        echo 'Add New';
    }
?>
    </a></h2>
</div>
<?php
    
    if (isset($_GET["status"]) AND $_GET["status"] == "post") {
        include('post.php');
    } elseif (isset($_GET["status"]) AND $_GET["status"] == "edit") {
        include('edit_post.php');
    } else {
        $numberofposts   = get_option('numberofpost');
        $enablepostlimit = get_option('enablepostlimit');
        if ($enablepostlimit == 'disable') {
            
            include('form.php');
        } else if ($user_post_count > $numberofposts) {
            $errornoofpost = get_option('errornoofpost');
            echo $errornoofpost;
        } else {
            
            include('form.php');
        }
        
    }
    
    
    
}
//above category dropdown from custom post type
function wpmpf_get_image_categories_dropdown($posttaxonomies, $selected)
{
    
    return wp_terms_checklist($post_id = 0, array(
        'taxonomy' => $posttaxonomies,
        'name' => 'category',
        'selected' => $selected,
        'hide_empty' => 0,
        'echo' => 0
    ));
    
}

?>