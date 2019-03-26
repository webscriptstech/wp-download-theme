<?php

defined( 'ABSPATH' ) or die();


/**
 * Enqueue styles/scripts on admin side
 *
 * @package WP Download Theme
 * @since 1.0.0
 */
function WPDT_SCRIPTS( $hook ){

	if( $hook == 'themes.php' ){

		wp_register_style(
			'wpdt-admin-style',
			WP_DOWNLOAD_THEME_URL.'includes/css/wpdt-layout.css',
			array(),
			'1.0.0'
		);
		wp_enqueue_style( 'wpdt-admin-style' );

		wp_register_script(
			'wpdt-admin-script',
			WP_DOWNLOAD_THEME_URL.'includes/js/wpdt-scripts.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		wp_enqueue_script( 'wpdt-admin-script' );

		wp_localize_script(
			'wpdt-admin-script',
			'wpdt',
			array('download_title' => __( 'Download', 'wp-download-theme' ))
		);
	}
}

add_action( 'admin_enqueue_scripts', 'WPDT_SCRIPTS' );


/**
 * Download of zip theme
 *
 * @package WP Download Theme
 * @since 1.0.0
 */
function WPDT_DOWNLOADS(){

	$themes = wp_get_themes();

	if( is_user_logged_in()
		&& current_user_can( 'switch_themes' )
		&& isset( $_GET['wpdt_download'] )
		&& !empty( $_GET['wpdt_download'] )
		&& array_key_exists( $_GET['wpdt_download'], $themes ) )
		{

		$wpdt_download = $_GET['wpdt_download'];
		$folder_path    = get_theme_root( $wpdt_downloadd ).'/'.$wpdt_download;
		$root_path      = realpath( $folder_path );

		$zip = new ZipArchive();
		$zip->open( $folder_path.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE );

		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator( $root_path ),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach( $files as $name=>$file ){

			if ( !$file->isDir() ){

				$file_path	   = $file->getRealPath();
		        $relative_path = $wpdt_download.'\\'.substr( $file_path, strlen( $root_path ) + 1 );

		        $zip->addFile( $file_path, $relative_path );
		    }
		}

		$zip->close();

		// Download Zip
		$zip_file = $folder_path.'.zip';

		if( file_exists( $zip_file ) ) {

		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($zip_file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($zip_file));
		    header('Set-Cookie:fileLoading=true');
		    readfile($zip_file);
		    unlink($zip_file);
		    exit;
		}
	}
}
add_action( 'admin_init', 'WPDT_DOWNLOADS' );
