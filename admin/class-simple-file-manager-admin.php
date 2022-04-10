<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Simple_File_Manager
 * @subpackage Simple_File_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_File_Manager
 * @subpackage Simple_File_Manager/admin
 * @author     Bowo <hello@bowo.io>
 */
class Simple_File_Manager_Admin {

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
		 * defined in Simple_File_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_File_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-file-manager-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . '-prism', plugin_dir_url( __FILE__ ) . 'css/prism.css', array(), $this->version, 'all' );

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
		 * defined in Simple_File_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_File_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . '-prism', plugin_dir_url( __FILE__ ) . 'js/prism.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-file-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Embed the Simple File Manager library
	 *
	 * @link https://github.com/jcampbell1/simple-file-manager
	 * @since 1.0.0
	 */
	public function sfm_index() {

		//Disable error report for undefined superglobals
		error_reporting( error_reporting() & ~E_NOTICE );

		// Security options
		$allow_show_folders = true; // Set to false to hide all subdirectories

		// Matching files not allowed to be uploaded. Must be an array.
		$disallowed_patterns = []; // e.g. ['*.php']  

		// Matching files hidden in directory index
		$hidden_patterns = []; // e.g. ['*.php','.*']

		// must be in UTF-8 or `basename` doesn't work
		setlocale(LC_ALL,'en_US.UTF-8');

		if(!$_COOKIE['_sfm_xsrf'])
			setcookie('_sfm_xsrf',bin2hex(openssl_random_pseudo_bytes(16)));
		if($_POST) {
			if($_COOKIE['_sfm_xsrf'] !== $_POST['xsrf'] || !$_POST['xsrf'])
				$this->err(403,"XSRF Failure");
		}

		if ( isset( $_REQUEST['file'] ) ) {

			$abspath = rtrim( ABSPATH, '/' );
			$abspath_hash = urlencode( $abspath );
			$file = $_REQUEST['file'] ? $_REQUEST['file'] : $abspath;

		}

		if ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'list' ) ) {

			if ( is_dir( $file ) ) {

				$directory = $file;
				$result = [];
				$files = array_diff(scandir($directory), ['.','..']);

				foreach ($files as $entry) if (!$this->is_entry_ignored($entry, $allow_show_folders, $hidden_patterns)) {

					$i = $directory . '/' . $entry;
					$path = preg_replace('@^\./@', '', $i);
					$mime_type = $this->get_mime_type( $path );

					if ( ( strpos( $mime_type, 'text' ) !== false ) || ( strpos( $mime_type, 'php' ) !== false ) || ( strpos( $mime_type, 'json' ) !== false ) || ( strpos( $mime_type, 'html' ) !== false ) ) {
						$is_viewable = true;
					} else {
						$is_viewable = false;						
					}

					$relpath = str_replace( ABSPATH, '', $i );
					$stat = stat($i);

					$result[] = [
						'mtime' => $stat['mtime'],
						'size' => $stat['size'],
						'name' => basename($i),
						'path' => $path,
						'relpath'	=> $relpath,
						'mime_type'	=> $mime_type,
						'is_viewable' => $is_viewable,
						'is_dir' => is_dir($i),
						'is_readable' => is_readable($i),
						'is_writable' => is_writable($i),
						'is_executable' => is_executable($i),
					];

				}

				usort($result,function($f1,$f2){
					$f1_key = ($f1['is_dir']?:2) . $f1['name'];
					$f2_key = ($f2['is_dir']?:2) . $f2['name'];
					return $f1_key > $f2_key;
				});

			} else {

				$this->err(412,"Not a Directory");

			}

			echo json_encode([
				'success' => true, 
				'is_writable' => is_writable($file), 
				'abspath' => $abspath,
				'abspath_hash' => $abspath_hash,
				'results' =>$result
			]);
			exit;

		} elseif ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'download' ) ) {

			foreach( $disallowed_patterns as $pattern ) {

				if(fnmatch($pattern, $file)) {

					$this->err(403,"Files of this type are not allowed.");

				}

			}

			$filename = basename($file);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);

			header('Content-Type: ' . finfo_file($finfo, $file));
			header('Content-Length: '. filesize($file));
			header(sprintf('Content-Disposition: attachment; filename=%s',
				strpos('MSIE',$_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
			ob_flush();
			readfile($file);

			exit;

		} elseif ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'view' ) ) {

	        $content = htmlentities( file_get_contents( $file ) );

	        $filename = '/' . str_replace( ABSPATH, '', $file );
	        $file_extension = pathinfo( $file, PATHINFO_EXTENSION );

	        switch ( $file_extension ) {

	        	case 'php':
	        		$language = 'php';
	        		break;

	        	case 'html':
	        		$language = 'markup';
	        		break;

	        	case 'xml':
	        		$language = 'markup';
	        		break;

	        	case 'svg':
	        		$language = 'markup';
	        		break;

	        	case 'js':
	        		$language = 'javascript';
	        		break;

	        	case 'css':
	        		$language = 'css';
	        		break;

	        	case 'md':
	        		$language = 'markdown';
	        		break;

	        	case 'json':
	        		$language = 'json';
	        		break;

	        	case 'lock':
	        		$language = 'json';
	        		break;

	        	case 'po':
	        		$language = 'markup';
	        		break;

	        	case 'txt':
	        		$language = 'markup';
	        		break;

	        	case '':
	        		$language = 'markup';
	        		break;

	        }

	        if ( isset( $language ) ) {

	        	$code_class = ' class="language-' . $language . ' match-braces"';

	        } else {

	        	$code_class = ' class="match-braces"';

	        }

		} else {}

		$html_output = '';

		if ( empty( $content ) ) {

			$html_output .= '<div id="top">
								<div id="breadcrumb">&nbsp;</div>
							</div>
							<table id="table"><thead><tr>
								<th>Name</th>
								<th>Size</th>
								<th>Modified</th>
								<th>Permissions</th>
								<th>Actions</th>
							</tr></thead><tbody id="list"></tbody></table>';

		} else {

			$html_output .= '<div class="viewer-nav viewer-top">
									<a href="#" class="back-step" onclick="window.history.back()"><span>&#10132;</span>Back</a><span class="viewing">You are viewing <span class="filename">' . $filename . '</span></span>
							</div>';

			$html_output .= '<div id="viewer-content"><pre class="line-numbers"><code' . $code_class . '>'. $content .'</code></pre></div>';

			$html_output .= '<div class="viewer-nav viewer-bottom">
									<a href="#" class="back-step" onclick="window.history.back()"><span>&#10132;</span>Back</a>
							</div>';

		}

		return $html_output;

	}

	/**
	 * Get absolute path
	 *
	 * @link http://php.net/manual/en/function.realpath.php#84012
	 * @since 1.0.0
	 */
	public function get_absolute_path( $path ) {

		$path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
		$parts = explode(DIRECTORY_SEPARATOR, $path);
		$absolutes = [];

		foreach ($parts as $part) {

		    if ('.' == $part) continue;

		    if ('..' == $part) {
		        array_pop($absolutes);
		    } else {
		        $absolutes[] = $part;
		    }

		}

		return implode(DIRECTORY_SEPARATOR, $absolutes);

	}

	/**
	 *	Check if entry is ignored
	 * 
	 * @since 1.0.0
	 */
	public function is_entry_ignored($entry, $allow_show_folders, $hidden_patterns) {

		if ($entry === basename(__FILE__)) {
			return true;
		}

		if (is_dir($entry) && !$allow_show_folders) {
			return true;
		}

		foreach($hidden_patterns as $pattern) {

			if(fnmatch($pattern,$entry)) {
				return true;
			}

		}

		return false;

	}

	/**
	 * Output error message
	 *
	 * @since 1.0.0
	 */
	public function err($code,$msg) {
		// http_response_code($code);
		// header("Content-Type: application/json");
		// echo json_encode(['error' => ['code'=>intval($code), 'msg' => $msg]]);
		// exit;
		return 'Code: ' . $code . ' | Message: ' . $msg;
	}

	/**
	 * Output as Bytes
	 *
	 * @since 1.0.0
	 */
	public function asBytes($ini_v) {

		$ini_v = trim($ini_v);
		$s = ['g'=> 1<<30, 'm' => 1<<20, 'k' => 1<<10];

		return intval($ini_v) * ($s[strtolower(substr($ini_v,-1))] ?: 1);

	}

	/**
	 * Get mime type of file
	 *
	 * @link https://github.com/prasathmani/tinyfilemanager
	 * @since 1.0.0
	 */
	public function get_mime_type( $file_path ) {

	    if (function_exists('finfo_open')) {

	        $finfo = finfo_open(FILEINFO_MIME_TYPE);
	        $mime = finfo_file($finfo, $file_path);
	        finfo_close($finfo);
	        return $mime;

	    } elseif (function_exists('mime_content_type')) {

	        return mime_content_type($file_path);

	    } elseif (!stristr(ini_get('disable_functions'), 'shell_exec')) {

	        $file = escapeshellarg($file_path);
	        $mime = shell_exec('file -bi ' . $file);
	        return $mime;

	    } else {

	        return '--';

	    }

	}

	/**
	 * Add file manager page in wp-admin
	 *
	 * @since 1.0.0
	 */
	public function sfm_main_page() {

		if ( class_exists( 'CSF' ) ) {

			// Set a unique slug-like ID

			$prefix = 'simple-file-manager';

			CSF::createOptions ( $prefix, array(

				'menu_title' 		=> 'Simple File Manager',
				'menu_slug' 		=> 'simple-file-manager',
				'menu_type'			=> 'submenu',
				'menu_parent'		=> 'tools.php',
				'menu_position'		=> 1,
				'framework_title' 	=> 'Simple File Manager <small>by <a href="https://bowo.io" target="_blank">bowo.io</a></small>',
				'framework_class' 	=> 'sfm-options',
				'show_bar_menu' 	=> false,
				'show_search' 		=> false,
				'show_reset_all' 	=> false,
				'show_reset_section' => false,
				'show_form_warning' => false,
				'sticky_header'		=> true,
				'save_defaults'		=> true,
				'show_footer' 		=> false,
				'footer_credit'		=> '<a href="https://wordpress.org/plugins/simple-file-manager/" target="_blank">Simple File Manager</a> (<a href="https://github.com/qriouslad/simple-file-manager" target="_blank">github</a>) is built with the <a href="https://github.com/devinvinson/WordPress-Plugin-Boilerplate/" target="_blank">WordPress Plugin Boilerplate</a>, <a href="https://wppb.me" target="_blank">wppb.me</a> and <a href="https://github.com/Codestar/codestar-framework" target="_blank">CodeStar</a>.',

			) );

			CSF::createSection( $prefix, array(

				'title'		=> 'The File Manager',
				'fields'	=> array(

					array(
						'type'	=> 'content',
						'title'	=> '',
						'class'	=> 'fmbody',
						'content'	=> $this->sfm_index(),
					),

				),

			) );

		}

	}

	/**
	 * Add "Access Now" plugin action link
	 *
	 * @since 1.0.0
	 */
	public function sfm_plugin_action_links( $links ) {

		$action_link = '<a href="tools.php?page=' . $this->plugin_name . '">Access Now</a>';

		array_unshift( $links, $action_link );

		return $links;

	}

	/**
	 * Register a submenu directly with WP core function
	 *
	 * @since 1.0.0
	 */
	public function sfm_register_submenu() {

		add_submenu_page(
			'tools.php',
			'File Manager',
			'File Manager',
			'manage_options',
			'simple-file-manager',
			'sfm_register_submenu_callback'
		);
	}

	/**
	 * Skeleton callback function for submenu registration
	 *
	 * @since 1.0.0
	 */
	public function sfm_register_submenu_callback() {

		echo 'Nothing to show here...';

	}

	/**
	 * Remove CodeStar framework welcome / ads page
	 *
	 * @since 1.0.0
	 */
	public function sfm_remove_codestar_submenu() {

		remove_submenu_page( 'tools.php', 'csf-welcome' );

	}

}
