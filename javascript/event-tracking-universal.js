(function($) {

	// add window.location.origin for browsers that don't support it yet
	if (!window.location.origin) {
		window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
	}

	$(document).ready(function() {
		
		var filetypes = /\.(js|css|bmp|png|gif|jpg|jpeg|ico|pcx|tif|tiff|au|mid|midi|mpa|mp3|ogg|m4a|ra|wma|wav|cda|avi|mpg|mpeg|asf|wmv|m4v|mov|mkv|mp4|ogv|webm|swf|flv|ram|rm|doc|docx|txt|rtf|xls|xlsx|pages|ppt|pptx|pps|csv|cab|arj|tar|zip|zipx|sit|sitx|gz|tgz|bz2|ace|arc|pkg|dmg|hqx|jar|xml|pdf|gpx|kml)$/i;
		var baseHref = ($('base').attr('href') != undefined) ? $('base').attr('href') : document.location.origin;
		var hrefRedirect = '';
	 
		$('body').on('click', 'a', function(event) {
			var el = $(this);
			var track = true;
			var href = (typeof(el.attr('href')) != 'undefined' ) ? el.attr('href') : '';
			var isExternal = href.match(/^https?\:/i) && href.indexOf(baseHref) < 0;
			if (!href.match(/^javascript:/i)) {
				var elEv = []; elEv.value=0, elEv.non_i=false;
				if (href.match(/^mailto\:/i)) {
					elEv.category = 'email';
					elEv.action = 'click';
					elEv.label = href.replace(/^mailto\:/i, '');
					elEv.loc = href;
				}
				else if (href.match(/^tel\:/i)) {
					elEv.category = 'telephone';
					elEv.action = 'click';
					elEv.label = href.replace(/^tel\:/i, '');
					elEv.loc = href;
				}
				else if (href.match(filetypes)) {
					var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
					elEv.category = 'download';
					elEv.action = 'click-' + extension[0];
					elEv.label = href.replace(/ /g,'-');
					elEv.loc = ((!isExternal && !href.match(/^https?\:/i)) ? baseHref : '') + href;
				}
				else if (el.hasClass('download')) { 
					// extra for dms module. 
					// download links need to have the following attributes:
					// class="download" data-extension="$Extension" data-filename="$FilenameWithoutID"
					elEv.category = 'download';
					elEv.action = 'click-' + el.data('extension');
					elEv.label = el.data('filename');
					elEv.loc = ((!isExternal && !href.match(/^https?\:/i)) ? baseHref : '') + href;
				}
				else if (isExternal) {
					elEv.category = 'external';
					elEv.action = 'click';
					elEv.label = href.replace(/^https?\:\/\//i, '');
					elEv.non_i = true;
					elEv.loc = href;
				}
				else track = false;
	 
				if (track) {
					var ret = true;
					//alert(elEv.category.toLowerCase()+" - "+elEv.action.toLowerCase()+" - "+elEv.label.toLowerCase());
					if((elEv.category == 'external' || elEv.category == 'download') && (el.attr('target') == undefined || el.attr('target').toLowerCase() != '_blank') ) {
						hrefRedirect = elEv.loc;
	 
						ga('send','event', elEv.category.toLowerCase(),elEv.action.toLowerCase(),elEv.label.toLowerCase(),elEv.value,{
							'nonInteraction': elEv.non_i ,
							'hitCallback':gaHitCallbackHandler
						});
	 
						ret = false;
					}
					else {
						ga('send','event', elEv.category.toLowerCase(),elEv.action.toLowerCase(),elEv.label.toLowerCase(),elEv.value,{
							'nonInteraction': elEv.non_i
						});
					}
	 
					return ret;
				}
			}
		});
	 
		gaHitCallbackHandler = function() {
			window.location.href = hrefRedirect;
		}
		
	});
	
}(jQuery));