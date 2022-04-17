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

		if ( ( isset( $_GET['do'] ) ) && ( ( $_GET['do'] == 'view' ) || ( $_GET['do'] == 'edit' ) ) ) {

			wp_enqueue_style( $this->plugin_name . '-codemirror', plugin_dir_url( __FILE__ ) . 'css/codemirror/codemirror.css', array(), $this->version, 'all' );

			// wp_enqueue_style( $this->plugin_name . '-codemirror-theme-lesser-dark', plugin_dir_url( __FILE__ ) . 'css/codemirror/theme/lesser-dark.css', array(), $this->version, 'all' );

			wp_enqueue_style( $this->plugin_name . '-codemirror-theme-material-ocean', plugin_dir_url( __FILE__ ) . 'css/codemirror/theme/material-ocean.css', array(), $this->version, 'all' );

			wp_enqueue_style( $this->plugin_name . '-codemirror-addon-foldgutter', plugin_dir_url( __FILE__ ) . 'css/codemirror/addon/foldgutter.css', array(), $this->version, 'all' );

		}

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

		if ( ( isset( $_GET['do'] ) ) && ( ( $_GET['do'] == 'view' ) || ( $_GET['do'] == 'edit' ) ) ) {

			wp_enqueue_script( $this->plugin_name . '-codemirror', plugin_dir_url( __FILE__ ) . 'js/codemirror/codemirror.min.js', array( 'jquery' ), $this->version, false );

			// Modes - Languages

			wp_enqueue_script( $this->plugin_name . '-codemirror-htmlmixed', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/htmlmixed.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-xml', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/xml.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-javascript', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/javascript.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-css', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/css.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-markdown', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/markdown.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-clike', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/clike.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-php', plugin_dir_url( __FILE__ ) . 'js/codemirror/mode/php.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			// Addon - Fold

			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-brace-fold', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/brace-fold.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-comment-fold', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/comment-fold.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-foldcode', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/foldcode.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );
			
			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-foldgutter', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/foldgutter.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-indent-fold', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/indent-fold.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-markdown-fold', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/markdown-fold.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name . '-codemirror-fold-xml-fold', plugin_dir_url( __FILE__ ) . 'js/codemirror/addon/fold/xml-fold.js', array( $this->plugin_name . '-codemirror' ), $this->version, false );

		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-file-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Embed the Simple File Manager library
	 *
	 * @link https://github.com/jcampbell1/simple-file-manager
	 * @since 1.0.0
	 */
	public function sfm_index() {

		// Limit file manager access only to site admins
		if ( current_user_can( 'manage_options' ) ) {

			//Disable error report for undefined superglobals
			error_reporting( error_reporting() & ~E_NOTICE );

			// Security options
			$allow_show_folders = true; // Set to false to hide all subdirectories

			// Deletion options
			$allow_delete = true; // Allow deletion of folders and files

			// Matching files not allowed to be uploaded. Must be an array.
			$disallowed_patterns = []; // e.g. ['*.php']  

			// Matching files hidden in directory index
			$hidden_patterns = []; // e.g. ['*.php','.*']

			// must be in UTF-8 or `basename` doesn't work
			setlocale(LC_ALL,'en_US.UTF-8');

			if( !$_COOKIE['_sfm_xsrf'] ) {
				setcookie( '_sfm_xsrf', bin2hex( openssl_random_pseudo_bytes( 16 ) ) );
			}

			// Set WordPress root path

			$abspath = rtrim( ABSPATH, '/' ); // remove trailing slash
			$abspath_hash = urlencode( $abspath );

			// Set the directory/file path

			if ( isset( $_REQUEST['file'] ) ) {

				$file_path = sanitize_text_field( $_REQUEST['file'] );

				$file = $file_path ? $file_path : $abspath;

			}

			if ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'list' ) ) {

			// Return list of directories and files data for frontend AJAX request

				if ( is_dir( $file ) ) {

					$directory = $file;
					$result = [];
					$files = array_diff(scandir($directory), ['.','..']);

					$n = 0;

					foreach ($files as $entry) if (!$this->sfm_is_entry_ignored($entry, $allow_show_folders, $hidden_patterns)) {

						$i = $directory . '/' . $entry;
						$path = preg_replace('@^\./@', '', $i);
						$mime_type = $this->sfm_mime_type( $path );

						// Check if $path is editable or not

						if ( ( strpos( $mime_type, 'text' ) !== false ) || ( strpos( $mime_type, 'php' ) !== false ) || ( strpos( $mime_type, 'json' ) !== false ) || ( strpos( $mime_type, 'html' ) !== false ) || ( strpos( $mime_type, 'empty' ) !== false ) ) {
							$is_viewable = true;

							if ( $this->sfm_is_wpcore_path( $path ) ) {

								if ( strpos( $path, 'wp-config.php' ) !== false ) {

									$is_editable = true;

								} else {

									$is_editable = false;

								}

							} else {

								$is_editable = true;

							}

						} else {
							$is_viewable = false;						
							$is_editable = false;
						}

						// Check if $path is deletable or not

						if ( ( strpos( $path, 'index.php' ) !== false ) && ( strpos( $path, 'wp-content' ) === false ) ) {

							$is_deletable = false;

						} elseif ( ( strpos( $path, 'index.php' ) !== false ) && ( strpos( $path, 'wp-content' ) !== false ) ) {

							$is_deletable = true;

						} elseif ( $this->sfm_is_wpcore_path( $path ) === false ) {

							$is_deletable = true;

						} else {

							$is_deletable = false;

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
							'is_editable' => $is_editable,
							'is_dir' => is_dir($i),
							'is_deletable' => $allow_delete && ( (!is_dir($i) && is_writable( $directory ) ) || ( is_dir($i) && is_writable($directory) && $this->sfm_is_recursively_deleteable($i) ) ) && $is_deletable,
							'is_readable' => is_readable($i),
							'is_writable' => is_writable($i),
							'is_executable' => is_executable($i),
						];

						$n++;

					}

					usort($result,function($f1,$f2){
						$f1_key = ($f1['is_dir']?:2) . $f1['name'];
						$f2_key = ($f2['is_dir']?:2) . $f2['name'];
						return $f1_key > $f2_key;
					});

				} else {

					$this->sfm_err(412,"Not a Directory");

				}

				echo json_encode([
					'success' => true, 
					'is_writable' => is_writable($file), 
					'abspath' => $abspath,
					'abspath_hash' => $abspath_hash,
					'results' =>$result
				]);
				exit;

			} elseif ( ( isset( $_GET['do'] ) ) && ( ( $_GET['do'] == 'view' ) || ( $_GET['do'] == 'edit' ) ) ) {

				// Save edits and return message

				if ( isset( $_POST['submit'] ) ) {

					$current_content = file_get_contents( $file );

					$new_content = wp_unslash( $_POST['editor-content'] );

					file_put_contents( $file, $new_content );

					$success_message = '<div class="edit-success"><p>File edited successfully. You can continue editing.</p></div>';

				} else {

					$success_message = '';

				}

				// Get file content and return default content when file is empty

				if ( empty( file_get_contents( $file ) ) ) {

					if ( $_GET['do'] == 'view' ) {

						$editor_content = 'This file is empty';

					} elseif ( $_GET['do'] == 'edit' ) {

				        $editor_content = 'Start editing here...';

					}

				} else {

			        $editor_content = esc_textarea( file_get_contents( $file ) );

				}

		        $filename = '/' . str_replace( ABSPATH, '', $file );
		        $file_extension = pathinfo( $file, PATHINFO_EXTENSION );

		        // Set CodeMirror mode based on file extension

		        if ( $file_extension == 'php' ) {
	        		$mode = 'application/x-httpd-php';
		        } elseif ( $file_extension == 'html' ) {
	        		$mode = 'text/html';
		        } elseif ( $file_extension == 'xml' ) {
	        		$mode = 'application/xml';
		        } elseif ( $file_extension == 'svg' ) {
	        		$mode = 'application/xml';
		        } elseif ( $file_extension == 'js' ) {
	        		$mode = 'application/javascript';
		        } elseif ( $file_extension == 'css' ) {
	        		$mode = 'text/css';
		        } elseif ( $file_extension == 'md' ) {
	        		$mode = 'text/x-markdown';
		        } elseif ( $file_extension == 'json' ) {
	        		$mode = 'application/json';
		        } elseif ( $file_extension == 'lock' ) {
	        		$mode = 'application/json';
		        } elseif ( $file_extension == 'txt' ) {
	        		$mode = 'text/plain';
		        } elseif ( $file_extension == 'htaccess' ) {
	        		$mode = '.htaccess';
		        } else {
	        		$mode = 'text/plain';
		        }

			} elseif ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'download' ) ) {

				// Process file download

				foreach( $disallowed_patterns as $pattern ) {

					if(fnmatch($pattern, $file)) {

						$this->sfm_err(403,"Files of this type are not allowed.");

					}

				}

				$filename = basename($file);
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$http_referer = sanitize_url( $_SERVER['HTTP_REFERER'] );

				header('Content-Type: ' . finfo_file($finfo, $file));
				header('Content-Length: '. filesize($file));
				header(sprintf('Content-Disposition: attachment; filename=%s',
					strpos('MSIE',$http_referer) ? rawurlencode($filename) : "\"$filename\"" ));
				ob_flush();
				readfile($file);

				exit;

			} elseif ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'createfile' ) ) {

				// Create new file

				if ( ! is_file( $file ) ) {

					$result = file_put_contents( $file, '' );

					if ( $result !== false ) {

						echo json_encode([
							'success' => true,
							'message' => 'File has been created.'
						]);

					} else {

						echo json_encode([
							'success' => false,
							'message' => 'File was not created.'
						]);

					}

				} else {

					$file_array = explode('/', $file);

					$new_file_name = array_pop( $file_array ); 

					echo json_encode([
						'success' => false,
						'message' => 'The file \'' . $new_file_name . '\' already exists. Please pick another file name.'
					]);

				}

				exit;

			} elseif ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'createfolder' ) ) {

				// Create new folder

				if ( ! is_dir( $file ) ) {

					mkdir( $file );

					echo json_encode([
						'success' => true,
						'message' => 'Folder has been created.'
					]);

				} else {

					$file_array = explode('/', $file);

					$new_folder_name = array_pop( $file_array ); 

					echo json_encode([
						'success' => false,
						'message' => 'The \'' . $new_folder_name . '\' folder already exists. Please pick another folder name.'
					]);

				}

				exit;

			} elseif ( ( isset( $_GET['do'] ) ) && ( $_GET['do'] == 'uploadfile' ) ) {

				// Upload file

				$file_name = basename( $_FILES['new-upload']['name'] );

				// Hash of folder location where file upload was initiated
				// Includes the '#' symbol in front
				$origin_hash = $_POST['url-hash'];

				// e.g. /home/root/path/wp-content/uploads/temp/
				$upload_dir = urldecode( str_replace( '#', '', $origin_hash ) ) . '/';

				// e.g. /home/root/path/wp-content/uploads/temp/filename.jpg
				$new_file_path = $upload_dir . $file_name;

				// Move file from temporary storage to the new path
				move_uploaded_file( $_FILES['new-upload']['tmp_name'], $new_file_path );

				$redirect_url = get_site_url() . '/wp-admin/tools.php?page=' . $this->plugin_name . $origin_hash;

				wp_safe_redirect( $redirect_url );
				exit;

			} elseif ( ( isset( $_POST['do'] ) ) && ( $_POST['do'] == 'delete' ) ) {

				// Delete file or folder (recursively)

				if( $allow_delete ) {

					$this->sfm_delete_recursively( $file );

					echo json_encode([
						'success' => true,
						'message' => 'Deletion was successful.'
					]);

				}

				exit;

			} else {}

			// Output HTML

			$html_output = '';

			if ( ! isset( $_GET['do'] ) ) {

				// Output default list view with action buttons

				$html_output .= '<div id="top">
									<div id="breadcrumb">&nbsp;</div>
									<div class="action-buttons">
										<button class="button action upload-button"><span class="icon-upload">&#10132;</span> Upload</button><button class="button action newfile-button">&#10010; File</button><button class="button action newfolder-button">&#10010; Folder</button>
									</div>
								</div> 
								<div class="action-inputs">
									<div class="action-upload">
											<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
											<input type="hidden" name="url-hash" id="upload-file-url-hash" value="" />
											<input type="file" name="new-upload" id="new-upload">
											<input type="submit" id="upload-file" class="button action button-primary upload-file" value="Upload Now" formaction="'. get_site_url() .'/wp-admin/tools.php?page=simple-file-manager&do=uploadfile" />
											<button class="button action cancel-action cancel-upload">Cancel</button>
									</div>
									<div class="action-newfile">
										<input type="text" name="new-filename" id="new-filename" value="" placeholder="e.g. filename.php"><button id="create-file" class="button action button-primary create-file">Create File</button><button class="button action cancel-action cancel-newfile">Cancel</button>
									</div>
									<div class="action-newfolder">
										<input type="text" name="new-foldername" id="new-foldername" value="" placeholder="e.g. folder-name"><button  id="create-folder" class="button action button-primary create-folder">Create Folder</button><button class="button action cancel-action cancel-newfolder">Cancel</button>
									</div>
								</div>
								<table id="table"><thead><tr>
									<th><span>Name</span></th>
									<th class="th-actions"><span>Actions</span></th>
									<th><span>Size</span></th>
									<th><span>Modified</span></th>
									<th><span>Permissions</span></th>
								</tr></thead><tbody id="list"></tbody></table>';

			} elseif ( ( isset( $_GET['do'] ) ) && ( ( $_GET['do'] == 'view' ) || ( $_GET['do'] == 'edit' ) ) ) {

				if ( $_GET['do'] == 'view' ) {

					// Set CodeMirror to read only mode

					$read_only = 'readOnly: true,';
					$do_is = 'viewing';

				} elseif ( $_GET['do'] == 'edit' ) {

					// Set CodeMirror to edit mode

					$read_only = 'readOnly: false,';
					$do_is = 'editing';

				}

				if ( !empty( $success_message ) ) {

					$html_output .= $success_message;

				}

				// Top part of file content

				$html_output .= '<div class="viewer-nav viewer-top">
									<a href="#" class="back-step" onclick="window.history.back()"><span>&#10132;</span>Back</a><span class="viewing">You are ' . $do_is . ' <span class="filename">' . $filename . '</span></span>
								</div>';

				// Output file content in view / edit mode

				if ( $_GET['do'] == 'view' ) {

					$html_output .= '<div id="editor-content"><textarea id="codemirror" rows="25">' . $editor_content . '</textarea></div>';

				} elseif ( $_GET['do'] == 'edit' ) {

					$html_output .= '<div id="editor-content"><form method="post">
										<textarea id="codemirror" name="editor-content" rows="25">' . $editor_content . '</textarea>
										<input type="submit" name="submit" value="Update File" class="button button-primary" />
									</form></div>';

				}

				$html_output .= '<div class="viewer-nav viewer-bottom">
										<a href="#" class="back-step" onclick="window.history.back()"><span>&#10132;</span>Back</a>
								</div>';

				// Script to handle CodeMirror behaviour

				$html_output .= '<script>
									jQuery(document).ready( function() {
								        // CodeMirror editor
								        var code = document.getElementById("codemirror");
								        var editor = CodeMirror.fromTextArea(code, {
								        	'.$read_only.'
								        	mode: "'.$mode.'",
								        	theme: "material-ocean",
								        	lineNumbers: true,
								        	lineWrapping: true,
								        	extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
								        	foldGutter: true,
								        	gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
								        });
									});
								</script>';

			} else {}

			return $html_output;

		}

	}

	/**
	 * Get absolute path
	 *
	 * @link http://php.net/manual/en/function.realpath.php#84012
	 * @since 1.0.0
	 */
	public function sfm_get_absolute_path( $path ) {

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
	public function sfm_is_entry_ignored($entry, $allow_show_folders, $hidden_patterns) {

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
	public function sfm_err($code,$msg) {
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
	public function sfm_as_bytes($ini_v) {

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
	public function sfm_mime_type( $file_path ) {

	    if ( function_exists('finfo_open') ) {

	        $finfo = finfo_open( FILEINFO_MIME_TYPE );
	        $mime = finfo_file( $finfo, $file_path );
	        finfo_close( $finfo );
	        return $mime;

	    } elseif ( function_exists( 'mime_content_type' ) ) {

	        return mime_content_type( $file_path );

	    } else {

	        return '--';

	    }

	}

	/** 
	 * Check if directory is recursively deletable
	 *
	 * @since 1.3.0
	 */
	public function sfm_is_recursively_deleteable($d) {
		$stack = [$d];
		while($dir = array_pop($stack)) {
			if(!is_readable($dir) || !is_writable($dir))
				return false;
			$files = array_diff(scandir($dir), ['.','..']);
			foreach($files as $file) if(is_dir($file)) {
				$stack[] = "$dir/$file";
			}
		}
		return true;
	}

	/**
	 * Delete file or folder recursively
	 *
	 * @since 1.3.0
	 */
	public function sfm_delete_recursively( $dir ) {

		if ( is_dir( $dir ) ) {

			$files = array_diff( scandir( $dir ), ['.','..'] );

			foreach ( $files as $file ) {

				self::sfm_delete_recursively( "$dir/$file" );

			}

			rmdir( $dir );

		} else {

			unlink($dir);
		}

	}

	/** 
	 * Check if path is part of WP core folders and files
	 *
	 * @since 1.3.0
	 */
	public function sfm_is_wpcore_path( $path ) {

		$disallowed_paths = array(
			ABSPATH . 'wp-admin',
			ABSPATH . 'wp-content',
			ABSPATH . 'wp-includes',
			ABSPATH . 'wp-content/plugins',
			ABSPATH . 'wp-content/themes',
			ABSPATH . 'wp-content/uploads',
			ABSPATH . 'wp-activate.php',
			ABSPATH . 'wp-blog-header.php',
			ABSPATH . 'wp-comments-post.php',
			ABSPATH . 'wp-config.php',
			ABSPATH . 'wp-cron.php',
			ABSPATH . 'wp-links-opml.php',
			ABSPATH . 'wp-load.php',
			ABSPATH . 'wp-login.php',
			ABSPATH . 'wp-mail.php',
			ABSPATH . 'wp-settings.php',
			ABSPATH . 'wp-signup.php',
			ABSPATH . 'wp-trackback.php',
			ABSPATH . 'xmlrpc.php',
		);

		if ( ( strpos( $path, 'wp-admin' ) !== false ) || ( strpos( $path, 'wp-includes' ) !== false ) || in_array( $path, $disallowed_paths ) ) {

			return true; // $path is part of WP core

		} else {

			return false; // $path is NOT part of WP core

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
				'framework_class' 	=> 'sfm',
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
