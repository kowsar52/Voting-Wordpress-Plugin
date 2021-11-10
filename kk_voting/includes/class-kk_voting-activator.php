<?php

/**
 * Fired during plugin activation
 *
 * @link       https://clevpro.com/
 * @since      1.0.0
 *
 * @package    Kk_voting
 * @subpackage Kk_voting/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Kk_voting
 * @subpackage Kk_voting/includes
 * @author     Kowsar Hossen <mdkowsar5252@gmail.com>
 */
class Kk_voting_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		
		
		$sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}voting_data` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
				`ip_address` varchar(100) NOT NULL,
				`option_id` int(10) NOT NULL,
		  	PRIMARY KEY  (id)
		) $charset_collate;";

		$sql2 = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}voting_settings` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
				`option_name` varchar(300) NOT NULL,
				`output_text` varchar(300) NOT NULL,
				`count` int(10) NOT NULL,
				`status` int(2) NOT NULL DEFAULT 1,
		  	PRIMARY KEY  (id)
		) $charset_collate;";
		
		

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		dbDelta($sql2);
				$wpdb->insert( 
			$wpdb->base_prefix.'voting_settings', 
			array( 
				'id' => 1, 
				'option_name' => 'option_name1',
				'output_text' => 'People Saved',
				'count' => 0, 
				'status' => 1, 
			) 
		);
		$wpdb->insert( 
			$wpdb->base_prefix.'voting_settings', 
			array( 
				'id' => 2, 
				'option_name' => 'option_name2',
				'output_text' => 'Received Holy Spirit',
				'count' => 0, 
				'status' => 1, 
			) 
		);
		$wpdb->insert( 
			$wpdb->base_prefix.'voting_settings', 
			array( 
				'id' => 3, 
				'option_name' => 'option_name3',
				'output_text' => 'Recommitted to Christ',
				'count' => 0, 
				'status' => 1, 
			) 
		);
	}

}
