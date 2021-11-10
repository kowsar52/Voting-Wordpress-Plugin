<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://clevpro.com/
 * @since      1.0.0
 *
 * @package    Kk_voting
 * @subpackage Kk_voting/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kk_voting
 * @subpackage Kk_voting/public
 * @author     Kowsar Hossen <mdkowsar5252@gmail.com>
 */
class Kk_voting_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kk_voting_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kk_voting_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kk_voting-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kk_voting_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kk_voting_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kk_voting-public.js', array( 'jquery' ), $this->version, false );

	}


		//add shortcode   [voting-count]
		function kk_custom_function(){
			add_shortcode( 'voting-form', array($this, 'kk_form_shortcode') );
			add_shortcode( 'voting-output', array($this, 'kk_output_shortcode') );
		}
	
		function kk_form_shortcode( $atts) {
			ob_start();
			global $wpdb;
			if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
	
			$table2 = $wpdb->prefix.'voting_data';
			$s_ip = (string)$ip; 
			$old_data = $wpdb->get_row("SELECT * FROM $table2 WHERE `ip_address` = '$ip'");


			
			$options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}voting_settings ORDER BY `id` ASC", OBJECT );
			$question = get_option('voting_question');

			include(plugin_dir_path( __FILE__ ) . 'partials/form.php');
			$shorcode_php_function = ob_get_clean();
		
			return $shorcode_php_function;
		}


		function kk_output_shortcode( $atts) {
			ob_start();
			global $wpdb;
			if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
	
			$table2 = $wpdb->prefix.'voting_data';
			$s_ip = (string)$ip; 
			$old_data = $wpdb->get_row("SELECT * FROM $table2 WHERE `ip_address` = '$ip'");


			
			$options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}voting_settings ORDER BY `id` ASC", OBJECT );
			$question = get_option('voting_question');

			include(plugin_dir_path( __FILE__ ) . 'partials/output.php');
			$shorcode_php_function = ob_get_clean();
		
			return $shorcode_php_function;
		}



	//ajax form submit code 
	public function kk_count_form_submit(){

		if ( 
			! isset( $_POST['kk_count_form_submit_nonce_field'] ) 
			|| ! wp_verify_nonce( $_POST['kk_count_form_submit_nonce_field'], 'kk_count_form_submit_nonce') 
		) {
		
			exit('The form is not valid');
		
		}

		
		global $wpdb;
	
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$table2 = $wpdb->prefix.'voting_data';
		$s_ip = (string)$ip; 
		$old_data = $wpdb->get_row("SELECT * FROM $table2 WHERE `ip_address` = '$ip'");

		if(empty($old_data)){
			$table = $wpdb->prefix.'voting_settings';
			$id = $_POST['id'];
			$option = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}voting_settings WHERE `id` = $id ", OBJECT);
			$data = array('count' => (int)$option->count + 1);
			$where = [ 'id' => $id ];
			$wpdb->update($table,$data,$where);


			$insert_data = array('ip_address' => $ip, 'option_id' => $id);
			$format = array('%s','%d');
			$wpdb->insert($table2,$insert_data,$format);
					
		$response = array(
			'success' => 'Thanks For Submit You Data!',
		);
		
		}else{
		  	$response = array(
			'error2' => 'Thanks! You Already Submit It!',
		    );
		
		}

		
			

		exit(json_encode($response));

		}

}
