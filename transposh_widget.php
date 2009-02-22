<?php

/*
 * Provides the following:
 * 1. Widget for sidebar for selecting a language and switching between edit/view
 * mode.
 * 2. Admin page for configuring language selection and other configuration settings.
 *
 */
require_once("logging.php");
require_once("constants.php");
require_once("transposh.php");

/*
 * Intercept init calls to see if it was posted by the widget. 
 *
 */
function init_transposh()
{
    if ($_POST['transposh_widget_posted'])
    {
        logger("Enter " . __METHOD__, 4);

        global $wp_rewrite, $home_url, $home_url_quoted;
        $ref=getenv('HTTP_REFERER');
        $lang = $_POST[LANG_PARAM];

        //cleanup previous lang & edit parameter from url
        $ref = preg_replace("/(" . LANG_PARAM . "|" . EDIT_PARAM . ")=[^&]*/i", "", $ref);


        if(!$home_url)
        {
            //make sure required home urls are fetched - as they are need now
            init_global_vars();
        }
        
        //cleanup lang identifier in permalinks
        $ref = preg_replace("/$home_url_quoted\/(..\/)/", "$home_url/",  $ref);

        if($lang != "none")
        {
            $use_params_only = !$wp_rewrite->using_permalinks();
            $is_edit = $_POST[EDIT_PARAM];

            $ref = rewrite_url_lang_param($ref, $lang, $is_edit, $use_params_only);
        }

        logger("Widget redirect url: $ref", 3);
                
        wp_redirect($ref);
        exit;
    }
}

/*
 * Register the widget. 
 */
function transposh_widget_init()
{
    logger("Enter " . __METHOD__, 4);
    if (!function_exists('register_sidebar_widget'))
    {
        return;
    }
    
	// Register widget
    register_sidebar_widget(array('Transposh', 'widgets'), 'transposh_widget');
	// Register widget control
    register_widget_control("Transposh",'transposh_widget_control');
}


/*
 * The actual widget implementation.
 */
function transposh_widget($args)
{
    logger("Enter " . __METHOD__, 4);
    global $languages, $wp_query; 
    extract($args);
    
    $page_url =  ($_SERVER['HTTPS'] == 'on' ?
                  'https://' : 'http://') . $_SERVER["SERVER_NAME"];
    $page_url .= ($_SERVER["SERVER_PORT"] != "80" ? ":" .$_SERVER["SERVER_PORT"] : "");
    $page_url .= $_SERVER["REQUEST_URI"];

    $is_edit = ($wp_query->query_vars[EDIT_PARAM] == "1" ? true : false);
    $lang = $wp_query->query_vars[LANG_PARAM];

    $options = get_option('widget_transposh');
    
    echo $before_widget . $before_title . __(no_translate("Transposh")) . $after_title;
	switch ($options['style']) {
		case 1: // flags
			global $plugin_url;
			// TODO - fix the following links...
			?>
		<a href="<?=$page_url?>"><img src="<?=$plugin_url;?>/flags/us.png"/></a>
		<a href="<?=$page_url?>"><img src="<?=$plugin_url;?>/flags/il.png"/></a>
		<?php 
			break;
		default: // language list
    ?>
    <form action="<?php echo $page_url ?>" method="post">
         <select name="lang" id="lang" onchange="Javascript:this.form.submit();">
         <option value="none">[Language]</option>

         <?php

         foreach($languages as $code => $language)
         {
             $is_selected = ($lang == $code ? "selected=\"selected\"" : "" );
             echo "<option value=\"$code\" $is_selected>" . no_translate($language) . "</option>";
         }
    
         ?>

         </select>
         <br/>
         <?php echo "<input type=\"checkbox\" name=\"" . EDIT_PARAM . "\" value=\"1\"" .
               ($is_edit ? "checked=\"1\"" : "0") .
                "\" onchange=\"Javascript:this.form.submit();\"/>Edit Translation<br/>";
         ?>
         <input type="hidden" name="transposh_widget_posted" value="1" />
    </form> 
         
<?php
	}
    echo $after_widget;
}


/*
 * Mark the given text so it will not subject to translation. 
 * Return the text with the required tags 
 */
function no_translate($text)
{
    return "<span class=\"" . NO_TRANSLATE_CLASS . "\">$text</span>";
}

/*
 * This is the widget control, allowing the selection of presentation type.
 */
function transposh_widget_control() {
	$options = $newoptions = get_option('widget_transposh');

	if ( isset($_POST['transposh-submit']) ) {
		$newoptions['style'] = $_POST['transposh-style'];
	}

	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_transposh', $options);
	}

	$style = $options['style'];
?>
	<p><label for="transposh-style">
	<?php _e('Style:') ?> <br/>
         
	<select id="transposh-style" name="transposh-style">
		<option <?php if ($style ==0) {?>selected="selected" <?php }?>value="0">Language list</option>
		<option <?php if ($style ==1) {?>selected="selected" <?php }?>value="1">Flags</option>
		<option <?php if ($style ==2) {?>selected="selected" <?php }?>value="2">Corner flag</option>
		<option <?php if ($style ==3) {?>selected="selected" <?php }?>value="3">Floating corner flag</option>
	</select></label>
	</p>
	<input type="hidden" name="transposh-submit" id="transposh-submit" value="1" />
<?php
}

/*
 *
 */
function transposh_admin_menu()
{
    logger("Enter " . __METHOD__, 4);
}

//Register callback for WordPress events
add_action('init', 'init_transposh',0);
add_action('widgets_init', 'transposh_widget_init');
add_action('admin_menu', 'transposh_admin_menu');

?>