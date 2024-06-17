<?php    
     $out = '';  
	    $out .= '<div id="loginform">';
	    $out .= '<p class="status"></p>';
		$out .= '<div class="loginerror"></div>';
		$out .= '<div class="loginsuccess"></div>';
        $out .= '<form id="login" action="login" method="post">';
        $out .= '<label for="username">Username:</label>';
        $out .= '<input id="username" type="text" name="username">';
		$out .= '<br/><br/>';
        $out .= '<label for="password">Password:</label>';
        $out .= '<input id="password" type="password" name="password">';
		$out .= '<br/><br/>';
        $out .= ' <a class="lost" href="'.wp_lostpassword_url().'">Lost your password?</a>';
		$out .= '<br/>';
        $out .= '<input id="loginsubmit" type="submit" value="Login" name="submit">';
        $out .= ''.wp_nonce_field( 'ajax-login-nonce', 'security' ).'';
        $out .= ' </form>';
		$out .= '</div>';
		
		
    ?>