<div class="wrap">
  <div class="metabox-holder">
    <?php
function admin_tabs($tabs, $current = NULL)
{
	if (is_null($current))
	{
		if (isset($_GET['tab']))
		{
			$current = $_GET['tab'];
		}
	}
	$content = '';
	$content.= '<h2 class="nav-tab-wrapper">';
	foreach($tabs as $location => $tabname)
	{
		if ($current == $location)
		{
			$class = ' nav-tab-active';
		}
		else
		{
			$class = '';
		}
		$content.= '<a class="nav-tab' . $class . '" href="?page=wp-mp-frontend-post&tab=' . $location . '">' . $tabname . '</a>';
	}
	$content.= '</h2>';
	return $content;
}
$my_plugin_tabs = array(
	'wp-mp-frontend-post' => 'Labels',
	'wpmpf-presentation-setting' => 'Presentation',
	'wpmpf-payment-setting' => 'Membership',
	'wpmpf-other-setting' => 'Other',
	'wpmpf-custom-field-setting' => 'Custom Field',
	'wpmpf-help' => 'Help'
);
echo admin_tabs($my_plugin_tabs);
?>
    <?php
settings_errors(); ?>
    <div id="mm-panel-overview" class="postbox">
      <div class="toggle default-hidden">
        <div id="mm-panel-options-wp-store">
          <form method="post" action="options.php">
            <?php
settings_fields('wpmpf-other-group');
register_wpmpf_woosettings('wpmpf-other-group');
$enablecaptcha = get_option('enablecaptcha');
$captchaprivatekey = get_option('captchaprivatekey');
$imagesize = get_option('imagesize');
$wpeditordisable = get_option('wpeditordisable');
$wpeditorenable = get_option('wpeditorenable');
$enablepostlimit = get_option('enablepostlimit');
$numberofpost = get_option('numberofpost');
$errornoofpost = get_option('errornoofpost');
?>
            <table class="form-table">
              <b>Other setting: </b>
              <p>(get captcha public key from here http://www.google.com/recaptcha)</p>
              <tr valign="top">
                <th scope="row">Enable/disable Captcha:</th>
                <td><select name="enablecaptcha">
                    <option <?php
if ($enablecaptcha == 'disable') echo 'selected="selected"'; ?> value="disable">
                    <?php
_e('disable'); ?>
                    </option>
                    <option <?php
if ($enablecaptcha == 'enable') echo 'selected="selected"'; ?> value="enable">
                    <?php
_e('enable'); ?>
                    </option>
                  </select></td>
              </tr>
              <tr valign="top">
                <th scope="row">Captcha Public Key:</th>
                <td><input type="text" name="captchapublickey" value="<?php
echo get_option('captchapublickey'); ?>" />
                  (default none)</td>
              </tr>
              <tr valign="top">
                <th scope="row">Captcha Private Key:</th>
                <td><input type="text" name="captchaprivatekey" value="<?php
echo get_option('captchaprivatekey'); ?>" />
                  (default none)</td>
              </tr>
              <tr valign="top">
                <th scope="row">Image Size:</th>
                <td><input type="text" name="imagesize" value="<?php
echo get_option('imagesize'); ?>" />
                  (defult 2mb use only value ex: "2")</td>
              </tr>
              <tr valign="top">
                <th scope="row">disable Visual editor for content:</th>
                <td><input type="checkbox" name="wpeditordisable" value="disable" <?php
if ('disable' == $wpeditordisable) echo 'checked="checked"'; ?> /></td>
              </tr>
              <tr valign="top">
                <th scope="row">enable Visual editor for excerpt:</th>
                <td><input type="checkbox" name="wpeditorenable" value="enable" <?php
if ('enable' == $wpeditorenable) echo 'checked="checked"'; ?> /></td>
              </tr>
              <tr valign="top">
                <th scope="row">enable Limit Post/month:</th>
                <td><select name="enablepostlimit">
                    <option <?php
if ($enablepostlimit == 'disable') echo 'selected="selected"'; ?> value="disable">
                    <?php
_e('Disable'); ?>
                    </option>
                    <option <?php
if ($enablepostlimit == 'enable') echo 'selected="selected"'; ?> value="enable">
                    <?php
_e('Enable'); ?>
                    </option>
                  </select></td>
              </tr>
              <tr valign="top">
                <th scope="row">Number of Post/month:</th>
                <td><input type="text" name="numberofpost" value="<?php
echo get_option('numberofpost'); ?>" />
                  (default "5")</td>
              </tr>
              <tr valign="top">
                <th scope="row">Error Message If Exceed</th>
                <td><textarea type="text" style="width:300px;" name="errornoofpost" value="<?php
echo get_option('errornoofpost'); ?>" ><?php
echo get_option('errornoofpost'); ?>
</textarea>
                  <p> //Error Message If Number Of Post Exceed</p></td>
              </tr>
            </table>
            <?php
submit_button(); ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
