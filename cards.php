<?php
/**
 * Plugin Name: Andimar Decks
 * Plugin URI: 
 * Description: A simple cards plugin for wordpress.
 * Version: 1.1.0
 * Author: Andrea Marzilli
 * Author URI: https://andimar.net
 * License: http://www.apache.org/licenses/LICENSE-2.0
 * Text Domain: 
 * Network: false
 *
 * @package andimar-cards
 *
 * Copyright 2023 Andrea Marzilli (email: andimar@gmail.com)
 *
 */
define( 'ANDIMAR_CARDS_PATH'   , plugin_dir_path( __FILE__ ) );
define( 'ANDIMAR_CARDS_URI'    , plugin_dir_url( __FILE__ ) );
define( 'ANDIMAR_CARDS_VERSION', "1.1.0");

// if( defined('DOING_CRON') ) return;

class CardsTemplate {

    function __construct() {

        add_filter('theme_page_templates',         [ $this, 'enableTemplate' ] );
        add_filter('template_include',             [ $this, 'loadTemplate'   ] );
        add_filter('autoptimize_filter_noptimize', [ $this, 'noOptimize'   ] ,10,0);
    }
        
    /**
     * Stop autoptimize from optimizing, e.g. based on URL as in example.
     *
     * @return: boolean, true or false
     */
    function noOptimize() {

        return is_page();        
    }

    function enableTemplate() {

        // Aggiungi il tuo template all'array dei template
        $templates['cards/templates/cards-template.php'] = 'Template per le cards';
        $templates['cards/templates/cards-fields-template.php'] = 'Template per le cards con campi';

        return $templates;
    }

    
    function loadTemplate( $template ) {

        if( !is_page() ) return $template;

        $current_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

        switch( $current_template ) {

            case 'cards/templates/cards-template.php': 
                $template = plugin_dir_path(__FILE__) . 'templates/cards-template.php';
                break;


            case 'cards/templates/cards-fields-template.php': 
                $template = plugin_dir_path(__FILE__) . 'templates/cards-fields-template.php';
                break;
        }
        
        return $template;
    }

    

}

new CardsTemplate;


