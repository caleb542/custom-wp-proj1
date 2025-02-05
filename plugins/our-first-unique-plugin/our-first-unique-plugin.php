<?php
/*
    Plugin Name: Our Test Plugin
    Description: A truly amazing plugin.
    Version: 1.0
    Author: Caleb
    Author URI: https://calebhamilton.com
    Text Domain: wcpdomain
    Domain Path: /languages 
*/

class WordCountAndTimePlugin {
    function __construct() {
        add_action('admin_menu' , array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'ifWrap'));
        add_action('init', array($this, 'languages'));
      
    }
function languages() {
    load_plugin_textdomain('wcpdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

function ifWrap($content) {
    if ((is_main_query() AND is_single()) AND 
    (
        get_option('wcp_wordcount', '1') OR 
        get_option('wcp_charactercount','1') OR 
        get_option('wcp_readtime', '1')
    )) {
        return $this->createHTML($content);
    } else {
        return $content;
    }
}

function createHTML($content) {
    $html = '<div class="word-count-container"><h3>' . esc_html(get_option('wcp_headline', 'Post Statistics')) . '</h3><p>' . esc_html__('This post has', 'wcpdomain') .  ' ';
    // Get Wordcount in to variable
    if (get_option('wcp_wordcount', '1') OR get_option('wcp_readtime', '1')) {
        $wordcount = str_word_count(strip_tags($content));    
    }

    if (get_option('wcp_wordcount', '1')) {
        $html .= '&nbsp;&nbsp;&bull; ' . $wordcount . ' ' . esc_html__('words','wcpdomain');
    }

    if (get_option('wcp_charactercount', '1')) {
        $html .=  '&nbsp;&nbsp;&bull; ' . strlen(strip_tags($content)) . ' characters <br> ';
    }

    if (get_option('wcp_readtime', '1')) {
        $value =  round($wordcount/225) <= 1 ? ' 1 minute to read' : ' ' .  round($wordcount/225) . ' minutes to read.';
        $html .= 'It will take about ' . $value . '</p></div>';
    }

    if ( get_option('wcp_location', '0') == '0') {
        return $html . $content ;
    }   
    return $content . $html;
}
    // 4. Name, subtitle, args, descriptive html, page_slug
function settings() {
    add_settings_section('wcp_first_section','Check boxes and stuff', null, 'word-count-settings-page');
       
    // Location
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'),'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin','wcp_location', array('sanitized_callback' => array($this, 'sanitizeLocation'),'default' => '0'));

    // Headline
    add_settings_field('wcp_heading', 'Headline Text', array($this, 'headlineHTML'),'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin','wcp_headline', array('sanitized_callback => sanitize_text_field','default' => 'Post Statistics'));
    

    // Checkbox: wordcount
    // Headline
    add_settings_field('wcp_wordcount', 'Word Count', array($this, 'wordcountHTML'),'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin','wcp_wordcount', array('sanitized_callback => sanitize_text_field','default' => '1'));
    

    // Checkbox: charactercount
    // Headline
    add_settings_field('wcp_charactercount', 'Character Count', array($this, 'charactercountHTML'),'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin','wcp_charactercount', array('sanitized_callback => sanitize_text_field','default' => '1'));
    


    // Checkbox: readtime
    // Headline
    add_settings_field('wcp_readtime', 'Read time', array($this, 'readtimeHTML'),'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin','wcp_readtime', array('sanitized_callback => sanitize_text_field','default' => '1'));
    
}

    function sanitizeLocation($input) {
        if ($input != '0' AND $input != '1') {
            add_settings_error('wcp_location', 'wcp_location_error','Display Location must be either beginning or end.');
            return get_option('wcp_location');
        }; 
        return $input;
    }

    function readtimeHTML() {
        ?>
        <input type="checkbox" name="wcp_readtime" value="1"
        <?php checked(get_option('wcp_readtime'), '1') ?>>

        <?php
    }

    function charactercountHTML() {
        ?>
        <input type="checkbox" name="wcp_charactercount" value="1"
        <?php checked(get_option('wcp_charactercount'), '1') ?>>

        <?php
    }
    
    function wordcountHTML() {
        ?>
        <input type="checkbox" name="wcp_wordcount" value="1" 
        <?php checked(get_option('wcp_wordcount'), '1') ?>>

        <?php
    }

    function headlineHTML() {
        ?>
        <input type="text" name="wcp_headline" placeholder="" 
        value="<?php echo esc_attr(get_option('wcp_headline'))?>">

        <?php
    }
    function locationHTML() {
        ?>
        <select name="wcp_location" id="">
            <option value="0" <?php selected(get_option('wcp_location'), '0') ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('wcp_location'), '1') ?>>End of post</option>
        </select>

        <?php
    }
    
    function adminPage() {add_options_page('Word Count Settings', __('Word Count', 'wcpdomain'),'manage_options','word-count-settings-page', array($this, 'ourHTML'));
        // args:  a:title, b:text label in settings menu,c:capabilities, 
        // d: slug or shortname, e: function name
    }
        function ourHTML() { ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php 
                    settings_fields('wordcountplugin');
                    do_settings_sections('word-count-settings-page');
                    submit_button();
                ?>
            </form>
        </div>
            
        <?php }
    }

$wordCountAndTimePlugin = new WordCountAndTimePlugin();






/*
add a sentence to the end of a single post content
//add_filter(a, b)  a -> do something with the_content
//                  b -> function doSomething()
add_filter('the_content', 'addToEndOfPost');

function addToEndOfPost($content) {

if (is_single() && is_main_query()) {

    return $content . '<p style="display:flex;flex-shrink:1;align-items:center;padding:10px;background:rgba(200,50,50,0.3);border-radius:6px;"><em>Posted by Caleb.</em></p>' ;
} 

    return  $content; 

}
*/