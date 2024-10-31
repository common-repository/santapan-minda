<?php

/*
Plugin Name: Santapan Minda
Plugin URI: http://www.santapanminda.com/
Description: Pelbagai Mutiara Kata untuk kegunaan harian, digunakan sebagai widget.
Version: 1.2.0
Author: Mohd Hadihaizil Din
Author URI: http://www.eizil.com
License: GPL2
*/

/*  Copyright 2011  MOHD HADIHAIZIL DIN  (email : eizil@eizil.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
error_reporting(0);

class SantapanMindaWidget extends WP_Widget {
    /** constructor */
    function SantapanMindaWidget() {
        parent::WP_Widget(false, $name = 'Santapan Minda Widget');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
<?php       
			$xml = simplexml_load_file("http://santapanminda.com/api.php?format=xml");
			if($xml) :	
				$quote=$xml->content[0]->content_string;
				$quote = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '', $quote);
				echo "<em>" . $quote . "</em><br /><span style='float:right; font-size:9px;'> via <a href='http://santapanminda.com' title='Santapan Minda Percuma' target='_blank'>SM</a></span>";
			else:
				echo "<em>Melakukan kesilapan itu manusia dan memaafkan kesilapan itu ialah kemanusiaan.</em><br /><span style='float:right; font-size:9px;'> via <a href='http://santapanminda.com' title='Santapan Minda Percuma' target='_blank'>SM</a></span>";
			endif;
?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php 
    }

} // class SantapanMindaWidget

add_action('widgets_init', create_function('', 'return register_widget("SantapanMindaWidget");'));
