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
    <div id="mm-panel-overview" class="postbox">
      <div class="toggle default-hidden">
        <div id="mm-panel-options-wp-store">
          <div class="shortcode-wp-store">
            <h4>Shortcode</h4>
            <p>Use this shortcode to display the wp store frontend Form on any post or page:</p>
            <p>[wp_store_frontend]</p>
          </div>
          <div class="tab1-wp-store">
            <h2>Tab 1 Labels</h2>
            <ul>
              <li>
                <p>Tab First is for label for frontend form so change all text language easily if i miss any label there you can contact we will update it as soon as possible</p>
              </li>
            </ul>
          </div>
          <div class="tab2-wp-store">
            <h2>Tab 2 Presentation</h2>
            <ul>
              <li>
                <p>Presentation tab is very important tab so we need to setup this tab one by one step there are 4 different setting in this tab - ecommerce Plugin, Post Type and taxnomy, Hide Option From Frontend and last required field</p>
              </li>
        
              <li>
                <p> <b>Option 1 (Post Type and taxnomy) :-</b>as you know all three ecommerce plugin have there own post type, taxnomy and tag so you need to select option according it.<br/>
                  <br/>
    
                  <b>for MarketPress</b><br/>
                  Product Post Type:- "product"<br/>
                  Product category:- "product_category"<br/>
                  Product tags:- "product_tag" </p>
              </li>
              <li>
                <p> <b>Option 2(Hide Option From Frontend):-</b> with this option you can hide any field from frontend.</p>
              </li>
              <li>
                <p> <b>Option 3 (required field):-</b> Create any field required like price, images, title etc. so if they submit empty form they receive error message</p>
              </li>
            </ul>
          </div>
          <div class="tab3-wp-store">
            <h2>Tab 3 Membership</h2>
            <ul>
              <li>
                <p>This tab is for protect access to your post submission form. if user to don't have membership level then he/she can't add new product from frontend</p>
              </li>
              <li>
                <p><b>Option 1 :-</b>Inatall membership plugin of wpmu dev and create level and select from here.</p>
              </li>
              <li>
                <p><b>Option 2 :-</b>Change error which appear if membership level not found for current user after login</p>
               </li>
              
            </ul>
          </div>
          <div class="tab4-wp-store">
            <h2>Tab 3 Other</h2>
            <ul>
              <li>
                <p>This tab is for other simple setting's like enable google Captcha, image size enable or disable visual editor for discription and excerpt and new option with that you can limit post per month</p>
              </li>
            </ul>
          </div>
          <div class="tab5-wp-store">
            <h2>Tab 4 Custom Field</h2>
            <ul>
              <li>
                <p>This tab is for add custom field in frontend form.</p>
              </li>
              <li>
                <p>Before you add custom field in WP store frontend you need to custom field into your wordpress site. You can add custom field with plugin or manually. Plugin is the simplest way where you don't need any php codeing knowlege.</p>
                <p>for plugin you need to download "<a target="_new" href="http://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a>" which the best plugin for create custom field or search from add new plugin from wordpress dashboard.</p>
                <p>after activate plugin just go to custom field option settings page and create your first Custom Field Group. Your custom field group will now appear on the page / post / template you specified in the field group's location rules. For more information please visit to plugin author site (http://www.advancedcustomfields.com/resources/).</p>
                <p> for manual method please read this article :- <a target="_new" href="http://wordpress.org/plugins/advanced-custom-fields/">http://buykodo.com/learn/add-custom-field-wp-mp-frontend/</a></p>
              </li>
              <p>If you have any other question you can contact us <a target="_new" href="http://buykodo.com/contact-us/">http://buykodo.com/contact-us/</a></p>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>