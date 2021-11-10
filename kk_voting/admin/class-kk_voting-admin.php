<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://clevpro.com/
 * @since      1.0.0
 *
 * @package    Kk_voting
 * @subpackage Kk_voting/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kk_voting
 * @subpackage Kk_voting/admin
 * @author     Kowsar Hossen <mdkowsar5252@gmail.com>
 */
class Kk_voting_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kk_voting-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kk_voting-admin.js', array( 'jquery' ), $this->version, false );

	}

	//register admin  menu
	function kk_register_my_custom_menu_page() {
		add_menu_page(
			__( 'Voting', 'textdomain' ),
			'Add Question (Voting)',
			'manage_options',
			'kk-custom-page',
			array( $this, 'kk_custom_page' ),
			'dashicons-admin-post',
			6
		);
	}

	//custom page template
	function kk_custom_page(){
		global $wpdb;
		$options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}voting_settings ORDER BY `id` ASC", OBJECT );
		$question = get_option('voting_question');
		include(plugin_dir_path( __FILE__ ) . 'partials/page.php'); //include page
	}



		//ajax form submit code 
		public function kk_question_form_submit(){
		
			if ( 
				! isset( $_POST['kk_custom_form_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['kk_custom_form_nonce_field'], 'kk_question_form_submit_nonce') 
			) {
		 
				exit('The form is not valid');
		 
			}

			if(!get_option('voting_question')){
				add_option('voting_question', $_POST['question']);
			}else{
				update_option('voting_question', $_POST['question']);
			}

			global $wpdb;
			$table = $wpdb->prefix.'voting_settings';
			$data = array('option_name' => $_POST['option_name1'], 'count' => $_POST['option_count1'], 'output_text' =>  $_POST['output_text1']);
			$where = [ 'id' => 1 ];
			$wpdb->update($table,$data,$where);

			$data = array('option_name' => $_POST['option_name2'], 'count' => $_POST['option_count2'], 'output_text' =>  $_POST['output_text2']);
			$where = [ 'id' => 2 ];
			$wpdb->update($table,$data,$where);
			
			$data = array('option_name' => $_POST['option_name3'], 'count' => $_POST['option_count3'], 'output_text' =>  $_POST['output_text3']);
			$where = [ 'id' => 3 ];
			$wpdb->update($table,$data,$where);
	
	

	
			$response = array(
				'success' => 'Data Updated SuccessFully!',
			);
			exit(json_encode($response));
		}
		
		//kk_export_excel
		public function kk_export_excel(){
		

            
            $isPrintHeader = false;
            global $wpdb;
    		$data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}voting_data GROUP BY `ip_address` ORDER BY `id` ASC", OBJECT );


            $columnHeader = '';  
            $columnHeader = "IP Address". "\t";  
            $setData = '';  
         
                $rowData = '';  
                foreach ($data as $value) {  
                    $value = '"' . $value->ip_address . '"' . "\n";  
                    $rowData .= $value;  
                }  
                $setData .= trim($rowData);  
  
              
            header("Content-type: application/octet-stream");  
            header("Content-Disposition: attachment; filename=ip_addresses.xls");  
            header("Pragma: no-cache");
            header("Expires: 0"); 
            
              echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  

		}


}
