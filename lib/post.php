
<?php $concat= get_option("permalink_structure")?"?":"&"; 
    global $current_user;
	$posttype = get_option('posttype'); 
    $user_posts=get_posts('author='.$current_user->ID.'&post_type='.$posttype.'&post_status=publish,draft&numberposts=-1&orderby=date&order=DESC');
	   ?> 

<div class="wrap"> 
<table class="post" id="user_post_list" border="0" width="100%" cellspacing="0" style="clear: both;">
 
<thead>
   <tr>
      <th class="title">
         Title
      </th>
      
      <th class="nosort">
         Category  
      </th>
      <th class="nosort">
         Action  
      </th>
   </tr>
   </thead> 
   <tbody>
   <?php foreach($user_posts as $upost){?>
   <tr>
      <td>
         <a target="_new" href="<?php echo get_permalink($upost->ID); ?>"><?php echo $upost->post_title; ?></a>     
      </td>
    
   <td>
      <?php 
		$posttaxonomies = get_option('posttaxonomies');
		$terms = get_the_terms( $upost->ID, $posttaxonomies);
		if ( $terms && ! is_wp_error( $terms ) ) : 
		 
	$cat_links = array();

	foreach ( $terms as $term ) {
		$cat_links[] = $term->name;
	}
						
	$on_draught = join( ", ", $cat_links );
	echo $on_draught;

?><?php endif; ?>
      </td>
      <td>
      <?php 
	  $url = get_bloginfo('url');
	 ?>
 
    <a href="?status=edit&postid=<?php echo $upost->ID; ?>">Edit Post</a> /
	<a href="<?php echo get_delete_post_link($upost->ID); ?>">Delete Post</a>
 <?php
 ?>

      </td>
   </tr><?php } ?>
   </tbody>
</table>
</div>
</div> <!-- ending div for wrapper-->  

<script language="JavaScript">
<!--
  jQuery(document).ready(function() {
    jQuery('#user_post_list').dataTable({
              
                    "sPaginationType": "full_numbers"
                });
                
   jQuery('.nosort').unbind('click');
} );
//-->
</script>