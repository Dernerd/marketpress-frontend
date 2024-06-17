<div id="loginform">
<?php $reset = $_GET['reset']; if($reset == true) { echo '<div class="forgetsuccess">A message will be sent to your email address.</div>'; } ?>
			<form method="post" id="forget" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields" style="margin-top:5px;">
					<?php do_action('login_form', 'resetpass'); ?>
					<input id="loginsubmit" type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>&reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
                <a class="lost" href="?action=login">Login</a>
                
			</form>
            </div>