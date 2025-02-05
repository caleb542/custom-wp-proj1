<?php

/*
Plugin Name: Our Word Filter Plugin
Description:: Replaces a list of words.
Version 1.0
Author: Caleb
Author URI: https://www.calebhamilton.com
*/

if( ! defined( 'ABSPATH' ) ) EXIT; // Exit if accessed directly.

class OurWordFilterPlugin {

        function __construct() {

            add_action('admin_menu', array($this, 'ourMenu'));
        }

        function ourMenu() {
            add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordfilterpage'), 'dashicons-smiley', 100);

            add_submenu_page('ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
        }

        function wordfilterpage() {
            ?>
            <div style="box-shadow:0 0 200px 30px rgba(0,0,0,0.5);position:absolute;width:100%;top:50vh;transform:translateY(-50%);align-content:center;min-height:500px;background:red;"><h1 style="display:block;align-content:center;text-align:center;color:#fff;">HELLO WORLD THIS IS OUR WORD FILTER PLUGIN</h1></div>
            <?php
        }

        function optionsSubPage() { ?>
            <div style="box-shadow:0 0 200px 30px rgba(0,0,0,0.5);position:absolute;width:100%;top:50vh;transform:translateY(-50%);align-content:center;min-height:500px;background:LIGHTBLUE;"><h1 style="display:block;align-content:center;text-align:center;color:#333;">HELLO WORLD FROM THE OPTIONS SUBPAGE</h1></div>
        <?php
        }
}

$ourWordFilterPlugin = new OurWordFilterPlugin();