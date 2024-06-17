<?php 

global $custom_field_db_version;
$custom_field_db_version = '1.1'; // version changed from 1.0 to 1.1

/**
 * register_activation_hook implementation
 *
 * will be called when user activates plugin first time
 * must create needed database tables
 */

/**
 * PART 2. Defining Custom Table List
 * ============================================================================
 *
 * In this part you are going to define custom table list class,
 * that will display your database records in nice looking table
 *
 * http://codex.wordpress.org/Class_Reference/WP_List_Table
 * http://wordpress.org/extend/plugins/custom-list-table-example/
 */

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * custom_field_List_Table class that will display our custom table
 * records in nice table
 */
class custom_field_List_Table extends WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'person',
            'plural' => 'persons',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_customlabel($item)
    {
        return '<em>' . $item['customlabel'] . '</em>';
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_customfield($item)
    {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=wp-mp-frontend-post&tab=wpmpf-custom-field-setting&id=%s">%s</a>', $item['id'], __('Edit', 'custom_field')),
            'delete' => sprintf('<a href="?page=%s&tab=wpmpf-custom-field-setting&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'custom_field')),
        );

        return sprintf('%s %s',
            $item['customfield'],
            $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'customfield' => __('Field Name', 'custom_field'),
            'customlabel' => __('Label', 'custom_field'),
            'customhelp' => __('Help Text', 'custom_field'),
        );
        return $columns;
    }

    /**
     * [OPTIONAL] This method return columns that may be used to sort table
     * all strings in array - is column names
     * notice that true on name column means that its default sort
     *
     * @return array
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'customfield' => array('customfield', true),
            'customlabel' => array('customlabel', false),
            'customhelp' => array('customhelp', false),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'customfield';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}


function custom_field_persons_form_meta_box_handler($item)
{
    ?>
<script type="text/javascript">
        function select_show(el){

            var d = jQuery('#select_show_field'),
                val = jQuery(el).val();
                
            if(val === 'select' || val === 'checkbox') {
                d.show();
            } else {
                d.hide();
            }
        }

    </script>

<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
  <tbody>
    <tr valign="top">
      <td scope="row" class="label"><label for="field">Field Name</label></td>
      <td><input size="25" style="" id="customfield" value="<?php echo esc_attr($item['customfield'])?>" name="customfield" type="text" placeholder="<?php _e('Field Name', 'custom_field')?>">
        <span>Custom Field Value (<a target="_new" href="http://buykodo.com/learn/add-custom-field-wp-mp-frontend/">Help</a>)</span></td>
    </tr>
    <tr valign="top">
      <td scope="row" class="label"><label for="label">Label</label></td>
      <td><input size="25" style="" id="label" value="<?php echo esc_attr($item['customlabel'])?>" name="customlabel" type="text" placeholder="<?php _e('Label Name', 'custom_field')?>">
        <span>Input field title</span></td>
    </tr>
    <tr valign="top">
      <td scope="row" class="label"><label for="help">Help Text</label></td>
      <td><input size="25" style="" id="help" value="<?php echo esc_attr($item['customhelp'])?>" name="customhelp" type="text" placeholder="<?php _e('Help Text', 'custom_field')?>">
        <span>Help Text Will Show after the input field</span></td>
    </tr>
    <tr valign="top">
      <td scope="row" class="label"><label for="required">Required</label></td>
      <td><select id="required" name="customrequire">
          <option <?php if (esc_attr($item['customrequire']) == 'no') echo 'selected="selected"'; ?> value="no">No</option>
          <option <?php if (esc_attr($item['customrequire']) == 'yes') echo 'selected="selected"'; ?> value="yes">Yes</option>
        </select>
        <span>Create Field Require for user</span></td>
    </tr>
    <tr valign="top">
      <td scope="row" class="label"><label for="region">Position</label></td>
      <td><select id="region" name="customposition">
          <option <?php if (esc_attr($item['customposition']) == 'top') echo 'selected="selected"'; ?> value="top">After Title</option>
          <option <?php if (esc_attr($item['customposition']) == 'description') echo 'selected="selected"'; ?> value="description">After Description</option>
          <option <?php if (esc_attr($item['customposition']) == 'bottom') echo 'selected="selected"'; ?> value="bottom">Bottom</option>
          <option <?php if (esc_attr($item['customposition']) == 'tag') echo 'selected="selected"'; ?> value="tag">After Tag</option>
        </select>
        <span>Location Of your input Field</span></td>
    </tr>
    <tr valign="top">
      <td scope="row" class="label"><label for="type">Type</label></td>
      <td><select name="type" id="type" onchange="select_show(this)">
          <option <?php if (esc_attr($item['type']) == 'text') echo 'selected="selected"'; ?> value="text">Text Box</option>
          <option <?php if (esc_attr($item['type']) == 'textarea') echo 'selected="selected"'; ?> value="textarea">Text Area</option>
          <option <?php if (esc_attr($item['type']) == 'select') echo 'selected="selected"'; ?> value="select">Dropdown</option>
          <option <?php if (esc_attr($item['type']) == 'checkbox') echo 'selected="selected"'; ?> value="checkbox">Checkbox</option>
        </select>
        <span></span></td>
    </tr>
    <tr id="select_show_field" <?php if (esc_attr($item['type']) == 'checkbox') { echo ''; } elseif(esc_attr($item['type']) == 'select') { echo''; } else { echo 'style="display: none;"'; }?> valign="top">
      <td scope="row" class="label"><label for="field_values">Values</label></td>
      <td><textarea name="customvalue" id="field_values" cols="30"><?php echo esc_attr($item['customvalue'])?></textarea>
        <span><br>
        Option fields (Please separate values with comma)</span></td>
    </tr>
  </tbody>
</table>
<?php
}

/**
 * Simple function that validates data and retrieve bool on success
 * and error message(s) on error
 *
 * @param $item
 * @return bool|string
 */
function custom_field_validate_person($item)
{
    $messages = array();

    if (empty($item['customfield'])) $messages[] = __('Name is required', 'custom_field');
	if (empty($item['customlabel'])) $messages[] = __('Label is required', 'custom_field');
    //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
    //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
    //...

    if (empty($messages)) return true;
    return implode('<br />', $messages);
}

/**
 * Do not forget about translating your plugin, use __('english string', 'your_uniq_plugin_name') to retrieve translated string
 * and _e('english string', 'your_uniq_plugin_name') to echo it
 * in this example plugin your_uniq_plugin_name == custom_field
 *
 * to create translation file, use poedit FileNew catalog...
 * Fill name of project, add "." to path (ENSURE that it was added - must be in list)
 * and on last tab add "__" and "_e"
 *
 * Name your file like this: [my_plugin]-[ru_RU].po
 *
 * http://codex.wordpress.org/Writing_a_Plugin#Internationalizing_Your_Plugin
 * http://codex.wordpress.org/I18n_for_WordPress_Developers
 */
function custom_field_languages()
{
    load_plugin_textdomain('custom_field', false, dirname(plugin_basename(__FILE__)));
}

add_action('init', 'custom_field_languages');
