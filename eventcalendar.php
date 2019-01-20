<?php
/*
Plugin Name: EventCalendar
Description: Event Calendar plugin to Lottaleben 
Version: 1.0
Author: Paulo Vitor Cruz (paulocsvitor@gmail.com)
*/

class EventCalendar {
    function __construct() {
        add_action('init', array($this, 'createPostType'));
        add_action('wp_enqueue_scripts', array($this, 'stylesAndScripts'));
        add_filter('rwmb_meta_boxes', array($this, 'registerMetaBoxes'));
        add_filter('single_template', array($this, 'customEventSingleTemplate'));
        add_filter('page_template', array($this, 'customEventPageTemplate'));
        add_shortcode('eventcalendar_shortcode', array($this, 'generateShortCode'));
        add_theme_support('post-thumbnails');
    }

    function stylesAndScripts() {
        wp_enqueue_style('css:mainplugin', '/wp-content/plugins/eventcalendar/main.scss', false, false);
        wp_enqueue_style('css:fullcalendar', '/wp-content/plugins/eventcalendar/bower_components/fullcalendar/dist/fullcalendar.css', false, false);
        wp_enqueue_script('js:jquery', '/wp-content/plugins/eventcalendar/bower_components/jquery/dist/jquery.min.js', array('jquery'), 1.1, true);
        wp_enqueue_script('js:moment', '/wp-content/plugins/eventcalendar/bower_components/moment/min/moment.min.js', array('jquery'), 1.1, true);
        wp_enqueue_script('js:fullcalendar', '/wp-content/plugins/eventcalendar/bower_components/fullcalendar/dist/fullcalendar.js', array('jquery'), 1.1, true);
    }
    
    /*
    To display all the events on an overview archive, I choose to use shortcodes Wordpress Tool. With that, it will be
    easy to set it in a page, a post or even in a widget.
    */
    function generateShortCode() {
        $shortcode_template = dirname(__FILE__) . '/shortcode-events.php';
        
        include($shortcode_template);
    }

    function customEventPageTemplate() {
        if (is_page('event')) {
            $page_template = dirname( __FILE__ ) . '/.php';
        }
        return $page_template;
    }

    function customEventSingleTemplate() {
        global $post;

        $file = dirname(__FILE__) .'/single-'. $post->post_type .'.php';
    
        if(file_exists($file)) $single_template = $file;
    
        return $single_template;
    }

    function createPostType() {
        register_post_type('events',
            array(
                'labels' => array(
                    'name' => __( 'Events' ),
                    'singular_name' => __( 'Events' )
                ),
                'public' => true,
                'query_var' => 'Events',
                'menu_position' => 5,
                'rewrite' => array('slug' => 'Events'),
                'supports' => array('')
            )
        );
    }

    function registerMetaBoxes($meta_boxes) {
        $meta_boxes[] = array(
            'title'  => 'Events Data',
            'fields' => array(
                array(
                    'id' => 'title',
                    'type' => 'text',
                    'name' => esc_html__( 'Title', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'description',
                    'type' => 'textarea',
                    'name' => esc_html__( 'Description', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'featuredimage',
                    'type' => 'file_input',
                    'name' => esc_html__( 'Featured Image', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'start',
                    'type' => 'datetime',
                    'name' => esc_html__( 'Start', 'metabox-online-generator' ),
                    'attributes' => array(
                        'All Day' => 'allday',
                    ),
                ),
                array(
                    'id' => 'end',
                    'type' => 'datetime',
                    'name' => esc_html__( 'End', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'allday',
                    'name' => esc_html__( 'All Day', 'metabox-online-generator' ),
                    'type' => 'checkbox',
                    'desc' => esc_html__( 'All day', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'recurrence',
                    'name' => esc_html__( 'Recurrence', 'metabox-online-generator' ),
                    'type' => 'select',
                    'placeholder' => esc_html__( 'Select an Item', 'metabox-online-generator' ),
                    'options' => array(
                        'None' => 'None',
                        'Daily' => 'Daily',
                        'Monthly' => 'Monthly',
                        'Yearly' => 'Yearly',
                    ),
                    'std' => 'None',
                ),
                array(
                    'id' => 'recurrence_limit',
                    'type' => 'datetime',
                    'name' => esc_html__( 'Recurrence Limit', 'metabox-online-generator' ),
                    'std' => '2050-12-31 00:00',
                ),
                array(
                    'id' => 'costs',
                    'type' => 'number',
                    'name' => esc_html__( 'Costs/Entrance Fees', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'externallink',
                    'type' => 'url',
                    'name' => esc_html__( 'External Link', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'address',
                    'type' => 'text',
                    'name' => esc_html__( 'Name + Address', 'metabox-online-generator' ),
                ),
                array(
                    'id' => 'category',
                    'type' => 'taxonomy',
                    'name' => esc_html__( 'Category', 'metabox-online-generator' ),
                    'taxonomy' => 'category',
                    'field_type' => 'select',
                ),
            ),
            'post_types' => array('events')
        );
    
        return $meta_boxes;
    }
}

require plugin_dir_path( __FILE__) . 'vendor/autoload.php';

$eventcalendar = new EventCalendar();



