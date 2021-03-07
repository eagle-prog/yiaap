/**
 * jquery.plupload.queue.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

/* global jQuery:true, alert:true */

/**
jQuery based implementation of the Plupload API - multi-runtime file uploading API.

To use the widget you must include _jQuery_. It is not meant to be extended in any way and is provided to be
used as it is.

@example
	<!-- Instantiating: -->
	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</div>

	<script>
		$('#uploader').pluploadQueue({
			url : '../upload.php',
			filters : [
				{title : "Image files", extensions : "jpg,gif,png"}
			],
			rename: true,
			flash_swf_url : '../../js/Moxie.swf',
			silverlight_xap_url : '../../js/Moxie.xap',
		});
	</script>

@example
	// Retrieving a reference to plupload.Uploader object
	var uploader = $('#uploader').pluploadQueue();

	uploader.bind('FilesAdded', function() {
		
		// Autostart
		setTimeout(uploader.start, 1); // "detach" from the main thread
	});

@class pluploadQueue
@constructor
@param {Object} settings For detailed information about each option check documentation.
	@param {String} settings.url URL of the server-side upload handler.
	@param {Number|String} [settings.chunk_size=0] Chunk size in bytes to slice the file into. Shorcuts with b, kb, mb, gb, tb suffixes also supported. `e.g. 204800 or "204800b" or "200kb"`. By default - disabled.
	@param {String} [settings.file_data_name="file"] Name for the file field in Multipart formated message.
	@param {Array} [settings.filters=[]] Set of file type filters, each one defined by hash of title and extensions. `e.g. {title : "Image files", extensions : "jpg,jpeg,gif,png"}`. Dispatches `plupload.FILE_EXTENSION_ERROR`
	@param {String} [settings.flash_swf_url] URL of the Flash swf.
	@param {Object} [settings.headers] Custom headers to send with the upload. Hash of name/value pairs.
	@param {Number|String} [settings.max_file_size] Maximum file size that the user can pick, in bytes. Optionally supports b, kb, mb, gb, tb suffixes. `e.g. "10mb" or "1gb"`. By default - not set. Dispatches `plupload.FILE_SIZE_ERROR`.
	@param {Number} [settings.max_retries=0] How many times to retry the chunk or file, before triggering Error event.
	@param {Boolean} [settings.multipart=true] Whether to send file and additional parameters as Multipart formated message.
	@param {Object} [settings.multipart_params] Hash of key/value pairs to send with every file upload.
	@param {Boolean} [settings.multi_selection=true] Enable ability to select multiple files at once in file dialog.
	@param {Boolean} [settings.prevent_duplicates=false] Do not let duplicates into the queue. Dispatches `plupload.FILE_DUPLICATE_ERROR`.
	@param {String|Object} [settings.required_features] Either comma-separated list or hash of required features that chosen runtime should absolutely possess.
	@param {Object} [settings.resize] Enable resizng of images on client-side. Applies to `image/jpeg` and `image/png` only. `e.g. {width : 200, height : 200, quality : 90, crop: true}`
		@param {Number} [settings.resize.width] If image is bigger, it will be resized.
		@param {Number} [settings.resize.height] If image is bigger, it will be resized.
		@param {Number} [settings.resize.quality=90] Compression quality for jpegs (1-100).
		@param {Boolean} [settings.resize.crop=false] Whether to crop images to exact dimensions. By default they will be resized proportionally.
	@param {String} [settings.runtimes="html5,flash,silverlight,html4"] Comma separated list of runtimes, that Plupload will try in turn, moving to the next if previous fails.
	@param {String} [settings.silverlight_xap_url] URL of the Silverlight xap.
	@param {Boolean} [settings.unique_names=false] If true will generate unique filenames for uploaded files.

	@param {Boolean} [settings.dragdrop=true] Enable ability to add file to the queue by drag'n'dropping them from the desktop.
	@param {Boolean} [settings.rename=false] Enable ability to rename files in the queue.
	@param {Boolean} [settings.multiple_queues=true] Re-activate the widget after each upload procedure.
*/
function doinput(type, id, filename, value) {
	if (typeof($("#"+id+"-form-c").html()) == 'undefined') {
		f = '<form id="' + id + '-form-c" method="post" action="" class="entry-form-class c-entry-form-edit" style="display: none;"><input type="hidden" name="ekey[]" value="'+id+'"><input type="hidden" name="efile[]" value="'+filename+'"><input type="text" name="ename[]" value="'+$("input[name='entry_name_"+id+"']").val()+'"></form>';
		$("#upload-wrapper:first").append(f);
	}

	if (type == 'description') {
		ht = '<textarea name="c_entry_description['+id+']">'+value+'</textarea>';

		if ( typeof($("textarea[name='c_entry_"+type+"["+id+"]']").html()) == 'undefined' ) {
			$("#"+id+"-form-c").append(ht);
		} else {
			$("textarea[name='c_entry_"+type+"["+id+"]']").val(value);
		}
	} else if (type == "size") {
		ht = '<input type="text" name="ename[]" value="'+value+'">';

		if ( typeof($("input[name='c_entry_"+type+"["+id+"]']").html()) == 'undefined' ) {
			$("#"+id+"-form-c").append(ht);
		} else {
			$("input[name='c_entry_"+type+"["+id+"]']").val(value);
		}
	} else {
		ht = '<input type="text" name="c_entry_'+type+'['+id+']" value="'+value+'">';

		if ( typeof($("input[name='c_entry_"+type+"["+id+"]']").html()) == 'undefined' ) {
			$("#"+id+"-form-c").append(ht);
		} else {
			$("input[name='c_entry_"+type+"["+id+"]']").val(value);
		}
	}
}

(function($, o) {
	var uploaders = {};

	function _(str) {
		return plupload.translate(str) || str;
	}

	function renderUI(id, target) {
		var section = "fe";
		target.contents().each(function(i, node) {
			node = $(node);

			if (!node.is('.plupload')) {
				node.remove();
			}
		});
		
	var browse_class = '';
	
	if ($("#UFBE").val() == "1") {
		browse_class = ' off';
	}
		
		var cat = $("#upload_category").parent().html();
		$("#upload_category").detach();
		var categ_select = $("#upload-category").text();
		var categ_class = categ_select == 'auto' ? ' no-display' : '';

		var categ = '<div class="selector entry-form-class' + categ_class + '">' + cat + '</div>';
        var browse   = '<div id="dobrowse" style="display: block;"><a href="#" class="plupload_button browse' + browse_class + '" id="' + id + '_browse"><i rel="tooltip" title="' + upload_lang["select"] + '" class="iconBe-plus' + (categ_select == 'auto' ? ' no-categ' : '') +'"></i></a><a href="#" class="plupload_button plupload_start start off"><i rel="tooltip" title="' + upload_lang["start"] + '" class="iconBe-upload"></i></a></div>';
        var thebrowse = browse;
	var search = '<div id="sb-search" class="sb-search sb-search-open"><div><input class="sb-search-input" type="text" value="" name="sq" id="sq" placeholder="Assign Username"><input type="hidden" name="assign_username" id="assign-username" value="" size="10"><input class="sb-search-submit file-search" id="file-search-button" type="button" value="" rel="tooltip" title="' + upload_lang["assign"] + '"><span class="sb-icon-search"></span></div></div>';

	if ($("#UFBE").val() != "1") {
		search = '';
	}

        var elem = '<div class="upload-buttons' + (categ_select == 'auto' ? ' no-categ' : '') +'">' + search + thebrowse + ' </div>';
        
		var progress = '<div class="plupload_progress"><div class="plupload_progress_container"><span class="plupload_total_status">0%</span><span class="plupload_total_file_size">&nbsp;</span><span class="plupload_progress_bar" style="width: 0%;"></span></div></div>';

		var right = '<div class="vs-column full">' + progress + '</div>';

		target.prepend('<div id="ct-wrapper" class="wdmax entry-list"><div class="section-top-bar"><div class="vs-column half upload-left-fix">' + categ + elem + '</div><div class="vs-column half fit upload-right-fix">' + right + '</div><div class="clearfix"></div></div></div>' +

			'<div class="plupload_wrapper plupload_scroll">' +
				'<div id="' + id + '_container" class="plupload_container">' +
					'<div class="plupload">' +
						'<div class="plupload_header" style="display: none;">' +
							'<div class="plupload_header_content">' +
								'<div class="plupload_header_title">' + upload_lang["h1"] + '</div>' +
								'<div class="plupload_header_text">' + upload_lang["h2"] + '</div>' +
							'</div>' +
						'</div>' +

						'<div class="plupload_content">' +
							'<div class="plupload_filelist_header">' +
								'<div class="plupload_file_name">' + upload_lang["filename"] + '</div>' +
								'<div class="plupload_file_action">Remove</div>' +
								'<div class="plupload_file_status"><span>' + upload_lang["status"] + '</span></div>' +
								'<div class="plupload_file_size">' + upload_lang["size"] + '</div>' +
								'<div class="plupload_clearer">&nbsp;</div>' +
							'</div>' +
							'<ul id="' + id + '_filelist" class="plupload_filelist"></ul>' +
						'</div>' +
					'</div>' +
				'</div>' +
				'<input type="hidden" id="' + id + '_count" name="' + id + '_count" value="0" />' +
			'</div>'
		);
	}

	$.fn.pluploadQueue = function(settings) {
		if (settings) {
			this.each(function() {
				var uploader, target, id, contents_bak;

				target = $(this);
				id = target.attr('id');

				if (!id) {
					id = plupload.guid();
					target.attr('id', id);
				}

				contents_bak = target.html();
				renderUI(id, target);

				settings = $.extend({
					dragdrop : true,
					browse_button : id + '_browse',
					container : id
				}, settings);

				if (settings.dragdrop) {
					settings.drop_element = id + '_filelist';
				}

				uploader = new plupload.Uploader(settings);

				uploaders[id] = uploader;

				function handleStatus(file) {
					var actionClass;
					var iClass;

					if (file.status == plupload.DONE) {
						actionClass = 'plupload_done';
						iClass = 'icon-check';
					}

					if (file.status == plupload.FAILED) {
						actionClass = 'plupload_failed';
						iClass = 'iconBe-info';
					}

					if (file.status == plupload.QUEUED) {
						actionClass = 'plupload_delete';
						iClass = 'icon-times';
					}

					if (file.status == plupload.UPLOADING) {
						actionClass = 'plupload_uploading';
					}

					var icon = $('#' + file.id).attr('class', actionClass).find('a').css('display', 'block');
					$('#' + file.id).find("i.pl_status").attr('class', iClass);
					if (file.hint) {
						icon.attr('title', file.hint);
					}
				}

				function updateTotalProgress() {
					$('span.plupload_total_status', target).html(uploader.total.percent + '%');
					$('span.plupload_progress_bar', target).css('width', uploader.total.percent + '%');
					$('span.plupload_upload_status', target).html(
						o.sprintf(_('Uploaded %d/%d files'), uploader.total.uploaded, uploader.files.length)
					);
					
					if (uploader.total.percent > 52) {
						$(".plupload_total_status").css("color", "white");
					} else {
						$(".plupload_total_status").css("color", "black");
					}
				}

				function updateList() {
					var fileList = $('ul.plupload_filelist', target).html(''), inputCount = 0, inputHTML;

					$.each(uploader.files, function(i, file) {
						inputHTML = '';

						if (file.status == plupload.DONE) {
							if (file.target_name) {
								inputHTML += '<input type="hidden" name="' + id + '_' + inputCount + '_tmpname" value="' + plupload.xmlEncode(file.target_name) + '" />';
							}

							inputHTML += '<input type="hidden" name="' + id + '_' + inputCount + '_name" value="' + plupload.xmlEncode(file.name) + '" />';
							inputHTML += '<input type="hidden" name="' + id + '_' + inputCount + '_status" value="' + (file.status == plupload.DONE ? 'done' : 'failed') + '" />';
	
							inputCount++;

							$('#' + id + '_count').val(inputCount);
						}

		var cat = $("#upload_category").parent().html().replace(/upload_category/g, 'upload_category_'+file.id).replace(/file_category_0/g, 'upload_category_'+file.id).replace(/file_category_sel/g, 'upload_category_'+file.id);
		var categ_select = $("#upload-category").text();
		var categ_class = categ_select == 'auto' ? ' no-display-off' : '';
		var categ = '<div class="selector entry-form-class' + categ_class + '">' + cat + '</div>';

						fileList.append(
							'<li id="' + file.id + '">' +
								'<div class="plupload_file_name"><span>' + file.name + '</span><i class="icon-pencil entry-edit-icon" rel="tooltip" title="Edit file details" onclick=\'$("#' + file.id + '-edit").stop().slideToggle("fast")\'></i></div>' +
								'<div class="plupload_file_action"><a href="javascript:;"><i class="pl_status"></i></a></div>' +
								'<div class="plupload_file_status">' + file.percent + '%</div>' +
								'<div class="plupload_file_size">' + plupload.formatSize(file.size) + '</div>' +
								'<div class="plupload_clearer">&nbsp;</div>' +
								inputHTML +
							'</li>' +
							'<li id="' + file.id + '-edit" class="pl-entry-edit" style="display: block;">' +
								'<form id="' + file.id + '-form" method="post" action="" class="entry-form-class entry-form-edit">' +
									'<div class="plupload_file_name_off">' +
										'<label>Title: </label><input type="text" name="entry_title_'+file.id+'" onkeyup="doinput(\'title\', \''+file.id+'\', \''+file.name+'\', this.value)" value="' + (( typeof($("input[name='c_entry_title["+file.id+"]']").html()) == 'undefined' ) ? file.name.replace(/\.[^/.]+$/, "") : $("input[name='c_entry_title["+file.id+"]']").val() ) + '"><br>' +
										'<label>Description: </label><textarea name="entry_description_'+file.id+'" onkeyup="doinput(\'description\', \''+file.id+'\', \''+file.name+'\', this.value)">' + (( typeof($("textarea[name='c_entry_description["+file.id+"]']").html()) == 'undefined' ) ? file.name.replace(/\.[^/.]+$/, "") : $("textarea[name='c_entry_description["+file.id+"]']").val() ) + '</textarea><br>' +
										'<label>Tags: </label><input type="text" name="entry_tags_'+file.id+'" onkeyup="doinput(\'tags\', \''+file.id+'\', \''+file.name+'\', this.value)" value="' + (( typeof($("input[name='c_entry_tags["+file.id+"]']").html()) == 'undefined' ) ? file.name.replace(/\.[^/.]+$/, "") : $("input[name='c_entry_tags["+file.id+"]']").val() ) + '"><br>' +
										'<input type="hidden" name="entry_name_'+file.id+'" value="' + file.size + '">' +
										'<label>Category: </label><br>' + categ +
									'</div>' +
									'<div class="plupload_clearer">&nbsp;</div>' +
								'</form><div class="clearfix"></div>' +
							'</li>'
						);

						handleStatus(file);
						$('#select-box-upload_category_'+file.id+':last').detach();
						SelectList.init($('#upload_category_'+file.id).attr("name"));

						$('#upload_category_'+file.id).change(function() {
							doinput('category', file.id, file.name, this.value);
						});

						$('#' + file.id + '.plupload_delete a').click(function(e) {
							$('#' + file.id + '-form-c').detach();
							$('#' + file.id).remove();
							uploader.removeFile(file);

							e.preventDefault();
						});
					});

					$('a.plupload_start', target).toggleClass('plupload_disabled', uploader.files.length == (uploader.total.uploaded + uploader.total.failed));

					fileList[0].scrollTop = fileList[0].scrollHeight;

					updateTotalProgress();

					if (!uploader.files.length && uploader.features.dragdrop && uploader.settings.dragdrop) {
						$('#' + id + '_filelist').append('<li class="plupload_droptext">' + upload_lang["drag"].replace("##", uploader.settings.max_files) + '</li>');
					}
				}

				function destroy() {
					delete uploaders[id];
					uploader.destroy();
					target.html(contents_bak);
					uploader = target = contents_bak = null;
				}

				uploader.bind("UploadFile", function(up, file) {
					$('#' + file.id).addClass('plupload_current_file');
				});

				uploader.bind('Init', function(up, res) {
					if (!settings.unique_names && settings.rename) {
						target.on('click', '#' + id + '_filelist div.plupload_file_name span', function(e) {
							var targetSpan = $(e.target), file, parts, name, ext = "";

							file = up.getFile(targetSpan.parents('li')[0].id);
							name = file.name;
							parts = /^(.+)(\.[^.]+)$/.exec(name);
							if (parts) {
								name = parts[1];
								ext = parts[2];
							}

							targetSpan.hide().after('<input type="text" />');
							targetSpan.next().val(name).focus().blur(function() {
								targetSpan.show().next().remove();
							}).keydown(function(e) {
								var targetInput = $(this);

								if (e.keyCode == 13) {
									e.preventDefault();

									file.name = targetInput.val() + ext;
									targetSpan.html(file.name);
									targetInput.blur();
								}
							});
						});
					}


					$('a.plupload_start', target).click(function(e) {
						if (!$(this).hasClass('plupload_disabled')) {
							uploader.start();
						}

						e.preventDefault();
					});

					$('a.plupload_stop', target).click(function(e) {
						e.preventDefault();
						uploader.stop();
					});

					$('a.plupload_start', target).addClass('plupload_disabled');
				});

				uploader.bind("Error", function(up, err) {
					var file = err.file, message;

					if (file) {
						message = err.message;

						if (err.details) {
							message += " (" + err.details + ")";
						}

						if (err.code == plupload.FILE_SIZE_ERROR) {
							alert(_("Error: File too large:") + " " + file.name);
						}

						if (err.code == plupload.FILE_EXTENSION_ERROR) {
							alert(_("Error: Invalid file extension:") + " " + file.name);
						}
						
						file.hint = message;
						$('#' + file.id).attr('class', 'plupload_failed').find('a').css('display', 'block').attr('title', message);
					}

					if (err.code === plupload.INIT_ERROR) {
						setTimeout(function() {
							destroy();
						}, 1);
					}
				});

				uploader.bind("PostInit", function(up) {
					if (up.settings.dragdrop && up.features.dragdrop) {
						$('#' + id + '_filelist').append('<li class="plupload_droptext">' + upload_lang["drag"].replace("##", up.settings.max_files) + '</li>');
					}
				});

				uploader.init();

				uploader.bind('StateChanged', function() {
					if (uploader.state === plupload.STARTED) {
						$('li.plupload_delete a,div.plupload_buttons', target).hide();
						$('span.plupload_upload_status,div.plupload_progress,a.plupload_stop', target).css('display', 'block');

						if (settings.multiple_queues) {
						}
					} else {
						updateList();
						$('a.plupload_delete', target).css('display', 'block');

						if (settings.multiple_queues && uploader.total.uploaded + uploader.total.failed == uploader.files.length) {
							$(".plupload_buttons,.plupload_upload_status", target).css("display", "inline");
							$(".plupload_start", target).addClass("plupload_disabled");
						}
					}
				});

				uploader.bind('FilesAdded', updateList);

				uploader.bind('FilesRemoved', function() {
					var scrollTop = $('#' + id + '_filelist').scrollTop();
					updateList();
					$('#' + id + '_filelist').scrollTop(scrollTop);
				});

				uploader.bind('FileUploaded', function(up, file) {
					handleStatus(file);
				});

				uploader.bind("UploadProgress", function(up, file) {
					$('#' + file.id + ' div.plupload_file_status', target).html(file.percent + '%');

					handleStatus(file);
					updateTotalProgress();
				});

				if (settings.setup) {
					settings.setup(uploader);
				}
			});

			return this;
		} else {
			return uploaders[$(this[0]).attr('id')];
		}
	};
})(jQuery, mOxie);
