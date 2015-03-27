<?php
/*
 * Plugin Name: A Cake Plugin
 * Plugin URI: http://phoenix.sheridanc.on.ca/~ccit2672
  * Description: Options plugin that will allow client to change background
 * Author: Gabriela Rojas
 * Version: 1.0
 * Author URI: http://phoenix.sheridanc.on.ca/~ccit2672
  */


function cd_awesome_add_admin_menu(  ) { 

	add_menu_page( 'An Cake Plugin', 'An Options Plugin', 'manage_options', 'an_options_plugin', 'my_awesome_plugin_options_page', 'dashicons-hammer', 66 );

}


function cd_awesome_settings_init(  ) { 

	register_setting( 'plugin_page', 'cd_awesome_settings' );
	
	add_settings_section(
		'cd_awesome_plugin_page_section', 
		__( 'Description for the section', 'codediva' ), 
		'cd_awesome_settings_section_callback', 
		'plugin_page'
	);

	

	

	

	add_settings_field( 
		'cd_awesome_select_field_4', 
		__( 'Choose from the dropdown', 'codediva' ), 
		'cd_awesome_select_field_4_render', 
		'plugin_page', 
		'cd_awesome_plugin_page_section' 
	);


}



function cd_awesome_select_field_4_render() { 
	$options = get_option( 'cd_awesome_settings' );
	?>
	<select name="cd_awesome_settings[cd_awesome_select_field_4]">
		<option value="white" <?php if (isset($options['cd_awesome_select_field_4'])) selected( $options['cd_awesome_select_field_4'], 1 ); ?>>White Background</option>
		<option value="pink" <?php if (isset($options['cd_awesome_select_field_4'])) selected( $options['cd_awesome_select_field_4'], 2 ); ?>>Pink Background</option>
	</select>
	<?php echo $options['cd_awesome_select_field_4'];?>
<?php
}


function cd_awesome_settings_section_callback() { 
	echo __( 'More of a description and detail about the section.', 'codediva' );
}


function my_awesome_plugin_options_page() { 
	?>
	<form action="options.php" method="post">
		
		<h2>My Awesome Plugin</h2>
		
		<?php
		settings_fields( 'plugin_page' );
		do_settings_sections( 'plugin_page' );
		submit_button();
		?>
		
	</form>
	<?php

}

add_action( 'admin_menu', 'cd_awesome_add_admin_menu' );
add_action( 'admin_init', 'cd_awesome_settings_init' );	



function my_awesome_plugin_callit(){
	$options = get_option( 'cd_awesome_settings' );
	
	
	echo '<p>Select: ' . $options['cd_awesome_select_field_4'] . '</p>';
}	

add_filter('the_content', 'my_awesome_plugin_callit');	


?>