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

		var $filename_link = $('<a class="name" />')
			.attr('href', data.is_dir ? '#' + encodeURIComponent(data.path) : '../' + data.relpath)
			.text(data.name);
		var allow_direct_link = true;
	    	if (!data.is_dir && !allow_direct_link)  $link.css('pointer-events','none');
		var $dl_link = $('<a/>').attr('href','?page=simple-file-manager&do=download&file='+ encodeURIComponent(data.path))
			.addClass('download').text('Download');
		// var $view_link = $('<a/>').attr('href','?page=simple-file-manager&do=view&file='+ encodeURIComponent(data.path))
			// .addClass('view').text('View');
		var $filename_view_link = $('<a class="name" />')
			.attr('href', data.is_dir ? '#' + encodeURIComponent(data.path) : ( data.is_viewable ? '?page=simple-file-manager&do=view&file='+ encodeURIComponent(data.path) : '../' + data.relpath ) )
			.text(data.name);
		var perms = [];
		if(data.is_readable) perms.push('Read');
		if(data.is_writable) perms.push('Write');
		if(data.is_executable) perms.push('Exec');
		var $html = $('<tr />')
			.addClass(data.is_dir ? 'is_dir' : '')
			.append( $('<td class="first" />').append($filename_view_link) )
			.append( $('<td/>').attr('data-sort',data.is_dir ? -1 : data.size)
				.html($('<span class="size" />').text(formatFileSize(data.size))) )
			.append( $('<td/>').attr('data-sort',data.mtime).text(formatTimestamp(data.mtime)) )
			.append( $('<td/>').text(perms.join('+')) )
			.append( $('<td/>').append($dl_link) )
			// .append( $('<td/>').append($dl_link).append( data.is_viewable ? $view_link : '' ) )
		return $html;

	}

	function renderBreadcrumbs(path,abspath) {

		var base = "%2F",
			relPath = path.replace( abspath, "" ),
			pathArr = relPath.split('%2F'),
			currentLocation = pathArr.slice(-1)[0];

		if ( path ) {

			// var $html = '<div id="breadcrumb-links"><a href="#" class="back-home"><span>&#8962;</span>Home</a><a href="#" class="back-step" onclick="window.history.back()"><span>&#10132;</span>Back</a><div class="current-location"><span>/' + currentLocation + ' - ' + abspath + '</span></div></div>';

			var $html = $('<div/>').addClass('breadcrumb-links').append( $('<a href=#>Home</a></div>') );

		} else {

			var $html = '<div class="breadcrumb-links">&nbsp;</div>';

		}

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

	$(document).ready( function() {

        var addReview = '<a href="https://wordpress.org/plugins/simple-file-manager/#reviews" target="_blank" class="header-action"><span>&starf;</span> Review</a>';
        var giveFeedback = '<a href="https://wordpress.org/support/plugin/simple-file-manager/" target="_blank" class="header-action">&#10010; Feedback</a>';
        var donate = '<a href="https://paypal.me/qriouslad" target="_blank" class="header-action">&#10084; Donate</a>';

        $(donate).prependTo('.csf-header-right');
        $(giveFeedback).prependTo('.csf-header-right');
        $(addReview).prependTo('.csf-header-right');

	});

})( jQuery );