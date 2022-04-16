(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write $ code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	var XSRF = (document.cookie.match('(^|; )_sfm_xsrf=([^;]*)')||0)[2];

	$(window).on('hashchange',list).trigger('hashchange');
	$(window).on('load',list);

	function list() {

		var hashval = window.location.hash.substr(1);

		$.get('?page=simple-file-manager&do=list&file='+ hashval,function(data) {

			$('#list').empty();
			$('#breadcrumb').empty().html(renderBreadcrumbs(hashval,data.abspath_hash));

			if(data.success) {
				$.each(data.results,function(k,v){
					$('#list').append(renderFileRow(v));
				});
				!data.results.length && $('#list').append('<tr><td class="empty" colspan=5>This folder is empty</td></tr>')
				data.is_writable ? $('.fmbody .csf-fieldset').removeClass('no_write') : $('.fmbody .csf-fieldset').addClass('no_write');
			} else {
				console.warn(data.error.msg);
			}

		},'json');
	}

	function renderFileRow(data) {

		// var $dl_link = $('<a/>').attr('href','?page=simple-file-manager&do=download&file='+ encodeURIComponent(data.path))
			// .addClass('download').text('Download');

		var $filename_view_link = $('<a class="name" />')
			.attr('href', data.is_dir ? '#' + encodeURIComponent(data.path) : ( data.is_viewable ? '?page=simple-file-manager&do=view&file='+ encodeURIComponent(data.path) : '../' + data.relpath ) )
			.text(data.name);
		var $view_link = '<a href="?page=simple-file-manager&amp;do=view&amp;file=' + encodeURIComponent(data.path) + '" class="view">View</a>';			
		var $edit_link = '<a href="?page=simple-file-manager&amp;do=edit&amp;file='+ encodeURIComponent(data.path) + '" class="edit">Edit</a>';
		var $delete_link = '<a href="#" data-file="license.txt" class="delete">Delete</a>';
		var $view_edit = $view_link + $edit_link;

		var $action_links = '';

		if ( data.is_viewable ) {
			$action_links += $view_edit;
		}

		if ( data.is_deletable ) {
			$action_links += $delete_link;			
		}

		var perms = [];

		if(data.is_readable) perms.push('Read');
		if(data.is_writable) perms.push('Write');
		if(data.is_executable) perms.push('Exec');

		var $html = $('<tr />')
			.addClass(data.is_dir ? 'is_dir' : '')
			.append( $('<td class="first" />').append($filename_view_link) )
			.append( $('<td/>').append( $action_links ) )
			.append( $('<td/>').html($('<span class="size" />').text(formatFileSize(data.size))) )
			.append( $('<td/>').text(formatTimestamp(data.mtime)) )
			.append( $('<td/>').text(perms.join('+')) )
		return $html;

	}

	function renderBreadcrumbs(path,abspath) {

		var base = "%2F",
			relPath = path.replace( abspath, "" ),
			pathArr = relPath.split('%2F'),
			currentLocation = pathArr.slice(-1)[0];

		// if ( path ) {

			var $html = $('<div/>').addClass('breadcrumb-links').append( $('<a href=#>Home</a></div>') );

		// } else {

			// var $html = '<div class="breadcrumb-links">&nbsp;</div>';

		// }

		$.each(pathArr,function(k,v){
			if(v) {
				var v_as_text = decodeURIComponent(v);

				$html.append( $('<span/>').text(' ▸ ') )
					.append( $('<a/>').attr('href','#'+abspath+base+v).text(v_as_text) );

				base += v + '%2F';
			}
		});

		return $html;

	}

	function formatTimestamp(unix_timestamp) {
		var m = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var d = new Date(unix_timestamp*1000);
		return [m[d.getMonth()],' ',d.getDate(),', ',d.getFullYear()," ",
			(d.getHours() % 12 || 12),":",(d.getMinutes() < 10 ? '0' : '')+d.getMinutes(),
			" ",d.getHours() >= 12 ? 'PM' : 'AM'].join('');
	}

	function formatFileSize(bytes) {
		var s = ['bytes', 'KB','MB','GB','TB','PB','EB'];
		for(var pos = 0;bytes >= 1000; pos++,bytes /= 1024);
		var d = Math.round(bytes*10);
		return pos ? [parseInt(d/10),".",d%10," ",s[pos]].join('') : bytes + ' bytes';
	}

	function createFile(fileName) {

		var hashval = window.location.hash.substr(1);

		$.get('?page=simple-file-manager&do=createfile&file='+ hashval + '%2F' + fileName,function(data) {

			if(data.success) {
				$('.cancel-newfile').click();
				$('#new-filename').val('');
				list();
			} else {
				alert(data.message);
			}

		},'json');
	}

	function createFolder(folderName) {

		var hashval = window.location.hash.substr(1);

		$.get('?page=simple-file-manager&do=createfolder&file='+ hashval + '%2F' + folderName,function(data) {

			if(data.success) {
				$('.cancel-newfolder').click();
				$('#new-foldername').val('');
				list();
			} else {
				alert(data.message);
			}

		},'json');
	}

	$(document).ready( function() {

		// Remove default CodeStar buttons
		$('.csf-form-result').remove();
		$('.csf-buttons').remove();

        var addReview = '<a href="https://wordpress.org/plugins/simple-file-manager/#reviews" target="_blank" class="header-action"><span>&starf;</span> Review</a>';
        var giveFeedback = '<a href="https://wordpress.org/support/plugin/simple-file-manager/" target="_blank" class="header-action">&#10010; Feedback</a>';
        var donate = '<a href="https://paypal.me/qriouslad" target="_blank" class="header-action">&#10084; Donate</a>';

        $(donate).prependTo('.sfm .csf-header-right');
        $(giveFeedback).prependTo('.sfm .csf-header-right');
        $(addReview).prependTo('.sfm .csf-header-right');

		setTimeout(function(){
		  $('.edit-success').fadeOut( 1000 );
		}, 2000);

		$('.upload-button').on('click', function(e) {

			e.preventDefault();

			$('.action-inputs').css("position","initial");
			$('.action-inputs').css("left","unset");
			$('.action-upload').css("visibility","visible");
			$('.action-upload').css("height","auto");

			$('.action-newfile').css("visibility","hidden");
			$('.action-newfile').css("height","0px");
			$('.action-newfolder').css("visibility","hidden");
			$('.action-newfolder').css("height","0px");

		});

		$('.newfile-button').on('click', function(e) {

			e.preventDefault();

			$('.action-inputs').css("position","initial");
			$('.action-inputs').css("left","unset");
			$('.action-newfile').css("visibility","visible");
			$('.action-newfile').css("height","auto");

			$('.action-upload').css("visibility","hidden");
			$('.action-upload').css("height","0px");
			$('.action-newfolder').css("visibility","hidden");
			$('.action-newfolder').css("height","0px");

		});

		$('.newfolder-button').on('click', function(e) {

			e.preventDefault();

			$('.action-inputs').css("position","initial");
			$('.action-inputs').css("left","unset");
			$('.action-newfolder').css("visibility","visible");
			$('.action-newfolder').css("height","auto");

			$('.action-upload').css("visibility","hidden");
			$('.action-upload').css("height","0px");
			$('.action-newfile').css("visibility","hidden");
			$('.action-newfile').css("height","0px");

		});

		$('.cancel-action').on('click', function(e) {

			e.preventDefault();

			$('.action-inputs').css("position","absolute");
			$('.action-inputs').css("left","-1000vw");

			$('.action-upload').css("visibility","hidden");
			$('.action-upload').css("height","0px");
			$('.action-newfile').css("visibility","hidden");
			$('.action-newfile').css("height","0px");
			$('.action-newfolder').css("visibility","hidden");
			$('.action-newfolder').css("height","0px");

		});

		// Create file

		$('#create-file').on('click', function(e) {
			var fileName = document.getElementById("new-filename").value;

			if (fileName === "") {
				alert("Please enter the file name first.");
				e.preventDefault();
			} else {
				createFile(fileName);
				e.preventDefault();
			}
		});

		var filenameInput = document.getElementById("new-filename");

		// Execute a function when the user releases a key on the keyboard
		filenameInput.addEventListener("keyup", function(e) {

			// Number 13 is the "Enter" key on the keyboard
			if (e.keyCode == 13 ) {

				e.preventDefault();

				document.getElementById("create-file").click();

			}

		});

		// Create folder

		$('#create-folder').on('click', function(e) {
			var folderName = document.getElementById("new-foldername").value;

			if (folderName === "") {
				alert("Please enter the folder name first.");
				e.preventDefault();
			} else {
				createFolder(folderName);
				e.preventDefault();
			}
		});

		var foldernameInput = document.getElementById("new-foldername");

		// Execute a function when the user releases a key on the keyboard
		foldernameInput.addEventListener("keyup", function(e) {

			// Number 13 is the "Enter" key on the keyboard
			if (e.keyCode == 13 ) {

				e.preventDefault();

				document.getElementById("create-folder").click();

			}

		});

		// Upload file

		// Get URL hash and pass to file upload submit's formaction parameter

		var hash = window.location.hash;

		$('#upload-file-url-hash').val(hash);

		$('#upload-file').on('click', function(e) {
			var uploadFileName = document.getElementById("new-upload").value;

			if (uploadFileName === "") {
				alert("Please choose a file first.");
				e.preventDefault();
			}

		});

		// Delete file / folder

		$('#table').on('click','.delete',function(data) {
			$.post("",{'do':'delete',file:$(this).attr('data-file'),xsrf:XSRF},function(response){
				list();
			},'json');
			return false;
		});

	});

})( jQuery );