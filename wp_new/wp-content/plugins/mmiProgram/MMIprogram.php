<?php
/*
Plugin Name: MMI programs
Plugin URI: 
Description: Functionality to Save Programs and Segments/Modules.
Version: 1.0
Author: Developer-G0947
Author URI: 
License:
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class MMIprograms {

	//** Constructor **//
	function __construct() {

		//** Action to load Assets Css **//
		add_action( 'wp_enqueue_scripts',  array(&$this, 'loadAssectCss') );
		add_action( 'admin_enqueue_scripts',  array(&$this, 'loadAdminAssects') );

		//** Register menu. **//
        add_action('admin_menu', array(&$this, 'register_awcustomizer_plugin_menu') );
	}

	function loadAdminAssects( $hook ){
		$plugin_url = plugin_dir_url( __FILE__ );
		if ( !('toplevel_page_mmiprogram' == $hook || 'mmi-program_page_mmi-modules' == $hook )) {
        	return;
    	}

		//** Load  Styling. **//
	    wp_enqueue_style( 'mmiprogram-datatables-css', 'https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css' );
	    wp_enqueue_script('mmiprogram-datatables','https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js',array('jquery'), '1.0.0', true );
	    wp_enqueue_script( 'mmiprogram-custom -js', plugin_dir_url( __FILE__ ) . '/js/aw_custom_script.js' );	    
	}

	function loadAssectCss(){
		$plugin_url = plugin_dir_url( __FILE__ );

		//** Load  Styling. **//
	    //wp_enqueue_style( 'aw_MMI_style', $plugin_url . 'css/mmi_search_style.css' );	  
	    wp_enqueue_script('mmiprogram-datatables','https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js',array('jquery'), '1.0.0', true );
	    
	}

	//** Register menu Item. **//
    function register_awcustomizer_plugin_menu(){
            add_menu_page( 'mmiprogram', 'MMI Program', 'manage_options', 'mmiprogram', array(&$this, 'mmi_program_page'), '', 26 );
            add_submenu_page('mmiprogram', 'add-program', 'Add Program', 'manage_options','add-program', array(&$this, 'add_program_page'));
            
            add_submenu_page('mmiprogram', 'mmi-module', 'MMI modules', 'manage_options','mmi-modules', array(&$this, 'mmi_modules_page'));
            add_submenu_page('mmiprogram', 'add-module', 'Add Modules', 'manage_options','add-modules', array(&$this, 'add_modules_page'));
    }


    /*function to show the page. */
    function mmi_program_page(){

    	global $wpdb;

    	$results = $wpdb->get_results("SELECT * FROM wp_mmi_programs");
    	$delUrl = site_url()."/wp-admin/admin.php?page=mmiprogram";


    	/* code block to delete the Program */
    	if (isset($_GET['delete'])) {
			$id     = trim($_GET['delete']);
			
			$delSqlProgram = "DELETE FROM wp_mmi_programs WHERE ID = $id";
			$wpdb->query( $delSqlProgram );

			$delSqlSegment = "DELETE FROM wp_mmi_segment WHERE `wp_mmi_segment`.`program_ID` = $id";
			$wpdb->query( $delSqlSegment );

    		echo "<script> window.location = '".$delUrl."'</script>";
    	}

    	echo '<div class="wrap">
    				<h1>MMI Programs</h1>
    				<div>
	    				<table id="mmiprogram_table" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Program Name</th>
									<th>Description</th>
									<th>Action</th>
								</tr>
								<tbody>';
								foreach ($results as $row){
									echo '<tr>
											<td>'.$row->ID.'</td>
											<td>'.$row->program_name.'</td>
											<td>'.$row->program_description.'</td>
											<td><a href="'.$delUrl.'&delete='.$row->ID.'" onclick="return confirm(\'Are you sure you want to Delete Program? \n Note: All Segments/modules of this Program will be deleted. \')">Delete</a></</td>
										</tr>';

								}
						echo	'</tbody>
							</thead>
						</table>
					<div>	
    		  </div>';
    }

    /*function to show the page. */
    function add_program_page(){

    	global $wpdb;

    	$message = "";

    	if(isset($_POST['mmiProgram'])){
			$program_name        = trim($_POST['program_name']);
			$program_description = trim($_POST['program_description']);

			/*$sqlInsert 	= "INSERT INTO wp_mmi_programs (`program_name`,`program_description`) values(, $program_description)";
    		$result  	= $wpdb->query($sqlInsert);*/

    		$result  	= $wpdb->insert(
				'wp_mmi_programs',
				array(
					'program_name'        => $program_name,
					'program_description' => $program_description
				),
				array(
					'%s',
					'%s'
				)
			);



    		if( $result){
    			$message = '<h2 style="color: #0DCA00;">Program added successfully.</h2>';
    		}

    	}

    	echo '<div class="wrap">
    				<h1>Add New Program</h1>
    				'.$message.'
    				<form id="post" method="post" action="" name="post">
						<div id="poststuff">
							<div class="metabox-holder columns-2" id="post-body">
								<div id="post-body-content" style="position: relative;">
									<div id="titlediv">
										<div id="titlewrap">											
											<input type="text" autocomplete="off" spellcheck="true" id="title" value="" size="30" name="program_name" placeholder="Enter program name"  required/>
										</div>
										<div id="titlewrap">											
											<textarea name="program_description" id="" style="width: 100%; height: 200px; font-size: 1.7em;" placeholder="Enter description here"></textarea>
										</div>
										<br  />	
										<div id="titlewrap">
											<input type="hidden" name="mmiProgram" value="1"/>
											<input type="submit" class="button button-primary button-large" value="Save Program"/>
										</div>
									</div>	
								</div>
							</div>
						<br class="clear">
						</div><!-- /poststuff -->
					</form>
    		  </div>';
    }

    /* function to show the page. */
    function mmi_modules_page(){
    	global $wpdb;

    	$delUrl = site_url()."/wp-admin/admin.php?page=mmi-modules";


    	/* code block to delete the Program */
    	if (isset($_GET['delete'])) {
			$id     = trim($_GET['delete']);
			$delSql = "DELETE FROM wp_mmi_segment WHERE ID = $id";
    		
    		$wpdb->query($delSql);

    		echo "<script> window.location = '".$delUrl."'</script>";
    	}


    	$sql = "SELECT `wp_mmi_segment`.`ID`, segment_name, segment_description, program_name FROM wp_mmi_segment, wp_mmi_programs WHERE `wp_mmi_segment`.`program_ID` = `wp_mmi_programs`.`ID`";
	   	$results = $wpdb->get_results($sql);



    	echo '<div class="wrap">
    				<h1>MMI Programs</h1>
    				<div>
	    				<table id="mmiprogram_table" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Program name</th>
									<th>Segement name</th>
									<th>Segement description</th>
									<th>Action</th>
								</tr>
								<tbody>';
								foreach ($results as $row){
									echo '<tr>
											<td>'.$row->ID.'</td>
											<td>'.$row->program_name.'</td>
											<td>'.$row->segment_name.'</td>
											<td>'.$row->segment_description.'</td>
											<td><a href="'.$delUrl.'&delete='.$row->ID.'" onclick="return confirm(\'Are you sure you want to Delete Segment/Module?\')">Delete</a></</td>
										</tr>';

								}
						echo	'</tbody>
							</thead>
						</table>
					<div>	
    		  </div>';
    }

    /* function to show the page. */
    function add_modules_page(){
    	global $wpdb;
    	
    	$message = "";

    	if(isset($_POST['mmiSegment'])){

			$program_ID          = trim($_POST['program_ID']);
			$segment_name        = trim($_POST['segment_name']);
			$segment_description = trim($_POST['segment_description']);

    		$result  	= $wpdb->insert(
				'wp_mmi_segment',
				array(
					'program_ID'          => $program_ID,
					'segment_name'        => $segment_name,
					'segment_description' => $segment_description
				),
				array(
					'%s',
					'%s',
					'%s'
				)
			);



    		if( $result){
    			$message = '<h2 style="color: #0DCA00;">Segment added successfully.</h2>';
    		}

    	}

    	$selectOptions = $wpdb->get_results("SELECT * FROM wp_mmi_programs");

    	$options = '';
    	foreach ($selectOptions as $row){
    		$options .= '<option value="'.$row->ID.'">'.$row->program_name.'</option>';
    	}

    	
    	echo '<div class="wrap">
    				<h1>Add New Segment</h1>
    				'.$message.'
    				<form id="post" method="post" action="" name="post">
						<div id="poststuff">
							<div class="metabox-holder columns-2" id="post-body">
								<div id="post-body-content" style="position: relative;">
									<div id="titlediv">
										<div id="titlewrap">													
											<input type="text" autocomplete="off" spellcheck="true" id="title" value="" size="30" name="segment_name" placeholder="Enter segment/module name"  required/>
										</div>										
										<div id="titleProgramID">											
											<select name="program_ID" style="background-color: #fff; font-size: 1.6em; height: 1.9em; line-height: 100%;margin: 0 0 3px;outline: 0 none;padding: 3px 8px;width: 100%;" required>
												<option value="">Select program</option>
												'.$options.'
											</select>
										</div>
										<div id="titleProgramDescriptio">											
											<textarea name="segment_description" id="" style="width: 100%; height: 200px; font-size: 1.7em;" placeholder="Enter description here"></textarea>
										</div>
										<br>										
										<div id="titlewrap">
											<input type="hidden" name="mmiSegment" value="1"/>
											<input type="submit" class="button button-primary button-large" value="Save Segment/Module"/>
										</div>
									</div>	
								</div>
							</div>
						<br class="clear">
						</div><!-- /poststuff -->
					</form>
    		  </div>';
    }




}

$MMIprograms = new MMIprograms;

?>