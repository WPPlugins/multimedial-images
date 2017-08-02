<?php
/*
Plugin Name: Multimedial Imagenes
Plugin URI: http://www.multimedial.cl/multimedial-imagenes-plugin-for-wordpress/
Description: Permite Administrar imagenes  para ser puestas en el Theme
Version: 1.0b
Author: Sergio Toro Diaz
Author URI: http://www.multimedial.cl/
*/

/*  Copyright 2009  Scott Nellé  (email : theguy@scottnelle.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	if (!class_exists("MultimedialImagenes")) {
		class MultimedialImagenes {
			
			function create_menu(){
			  	add_options_page('Multimedial Images', 'Multimedial Images', 10, 'mmi', array($this,'options_page'));
			}
			
			function get_admin_backgrounds(){
				global $wpdb;
				
				$bgs = $wpdb->get_results("SELECT * FROM mmi_images WHERE type = 'bg';");
				
				include 'template/backgrounds.php';
			}
			
			function get_admin_sliders(){
				global $wpdb;
				
				$sliders = $wpdb->get_results("SELECT * FROM mmi_images WHERE type= 'slider'; ");
				
				include 'template/sliders.php';
			}
			
			
			
			function options_page()
			{
			?>
			<div class="wrap">
				<h2>Multimedial Images</h2>

				<h3><?php _e('Backgrounds');?></h3>
				<?php $this->get_admin_backgrounds();?>
				<h3><?php _e('Slider');?></h3>
				<p><? _e('This images go into the slider on every page in the site, the order is relevant.');?></p>	
				<?php $this->get_admin_sliders();?>
			</div>
			<?php
			}
			
			function get_slider(){
				global $wpdb;
				$sliders = $wpdb->get_results("SELECT * FROM mmi_images WHERE type= 'slider'; ");
				return $sliders;
			}
			
			function get_bg(){
				global $wpdb;
				$bg = $wpdb->get_results("SELECT * FROM mmi_images WHERE type= 'bg'; ");
				return $bg;
			}
			
			function save_background($bg = null){
				global $wpdb;
				$wpdb->query("INSERT INTO mmi_images (id, attachment_id, thumb, type) VALUES(NULL,{$bg['id']},'{$bg['thumb']}', 'bg')");
			}
			
			function save_slider($bg = null){
				global $wpdb;
				$wpdb->query("INSERT INTO mmi_images (id, attachment_id, thumb, type) VALUES(NULL,{$bg['id']},'{$bg['thumb']}', 'slider')");
			}
			function del_background($id = null){
				global $wpdb;
				$wpdb->query("DELETE FROM  mmi_images  WHERE id = $id");
			}
		}
		
		
		
		
		$mmi_plugin = new MultimedialImagenes();
		if (isset($mmi_plugin)) {
			if(isset($_GET['a']) && $_GET['a'] == 'delbg'){
				$mmi_plugin->del_background($_GET['id']);
			}
		
			if (isset($_POST['submit_bg'])) {
				$mmi_plugin->save_background(array('id' => $_POST['upload_id'], 'thumb' => $_POST['upload_image']));
			}
			
			if (isset($_POST['submit_sl'])) {
				$mmi_plugin->save_slider(array('id' => $_POST['upload_id2'], 'thumb' => $_POST['upload_image2']));
			}
			
			add_action('init', array($mmi_plugin,'redirect'), 1);
			add_action('admin_menu', array($mmi_plugin,'create_menu'));

			function mmi_activate() {
				global $wpdb;
				$wpdb->query("CREATE TABLE `mmi_images` (
				`id` INT( 16 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`attachment_id` INT( 16 ) NOT NULL ,
				`thumb` VARCHAR( 255 ) NOT NULL,
				`type` VARCHAR( 16 ) NOT NULL 
				) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;");
			}
			add_action('activate_' . plugin_basename(__FILE__), 'mmi_activate' );
			
			function my_admin_scripts() {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
			}

			function my_admin_styles() {
				wp_enqueue_style('thickbox');
			}

			if (isset($_GET['page']) && $_GET['page'] == 'mmi') {
				add_action('admin_print_scripts', 'my_admin_scripts');
				add_action('admin_print_styles', 'my_admin_styles');
			}
			
		}
		
		
		
		
	}
?>