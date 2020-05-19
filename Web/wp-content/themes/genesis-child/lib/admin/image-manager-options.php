<?php
/**
 * Builds the Image Manager admin page.
 *
 * @package Dynamik
 */
 
/**
 * Build the Dynamik Image Manager admin page.
 *
 * @since 2.4.0
 */
function dynamik_image_manager() {

$child_images = dynamik_get_stylesheet_location( 'path' ) . 'images/';
$child_images_url = dynamik_get_stylesheet_location( 'url' ) . 'images';
?>
	<div class="wrap">
		
		<div id="icon-options-general" class="icon32"></div>
		
		<h2 id="dynamik-admin-heading"><?php _e( 'Dynamik - Image Manager', 'dynamik' ); ?></h2>
		
		<div id="dynamik-admin-wrap">
			
			<div class="dynamik-settings-wrap">
				<?php require_once( CHILD_DIR . '/lib/admin/boxes/image-manager.php' ); ?>
			</div>
			
		</div>
	</div> <!-- Close Wrap -->
<?php

}

add_action( 'wp_ajax_dynamik_image_file_control_save', 'dynamik_image_file_control_save' );
/**
 * Use ajax to rename/delete Dynamik image files.
 *
 * @since 2.4.0
 */
function dynamik_image_file_control_save() {
	
	check_ajax_referer( 'dynamik-ajax-nonce', 'security' );
	
	if ( $_POST['action_type'] == 'rename' ) {
		
		$image_path = dynamik_get_stylesheet_location( 'path' ) . 'images/';
		$image_file = $image_path . $_POST['name'];
		
		$supported_extensions = array( 'jpg', 'png', 'gif', 'ico' );
		$old_file_ext = substr( $_POST['name'], strrpos( $_POST['name'], '.' ) + 1 );
		$new_file_ext = substr( $_POST['new_name'], strrpos( $_POST['new_name'], '.' ) + 1 );
		
		if ( in_array( $new_file_ext, $supported_extensions ) ) {
		
			if ( file_exists( $image_file ) && $old_file_ext == $new_file_ext ) {
				
				rename( $image_file, $image_path . $_POST['new_name'] );
				echo 'Image Renamed';
				
			} elseif ( file_exists( $image_file ) && $old_file_ext != $new_file_ext ) {
				
				echo 'Error: File Extension Mismatch';

			} else {
				
				echo 'Error: Image File Does Not Exist';
				
			}
			
		} else {
			
			echo 'Error: Unsupported File Extension';
			
		}
		
	} elseif ( $_POST['action_type'] == 'delete' ) {
		
		$image_path = dynamik_get_stylesheet_location( 'path' ) . 'images/' . $_POST['name'];
		
		if ( file_exists( $image_path ) ) {

			unlink( $image_path );
			echo 'Image Deleted';
			
		} else {
			
			echo 'Error: Image File Does Not Exist';
			
		}		
		
	} elseif ( $_POST['action_type'] == 'delete_all' ) {
		
		$images_folder_path = dynamik_get_stylesheet_location( 'path' ) . 'images/';
		$images_exist = false;
		
		foreach( glob( $images_folder_path . '*' ) as $filename ) {
			
			if ( file_exists( $images_folder_path . basename( $filename ) ) )
				unlink( $images_folder_path . basename( $filename ) );
				
			$images_exist = true;
		    
		}
		
		if ( false != $images_exist )
			echo 'All Images Deleted';
		else
			echo 'Error: No Images To Delete';
		
	}
	
	exit();
	
}
