(function ($) {
	$(document).ready(function () {
		
		
		function createWrap(elem) {
			var element = $('.' + elem);
			if (element.length === false) {
				$('.imagine-wrap').append('<div class="'+elem+'"></div>');
			}
		};
		
		createWrap('imagine-formtable-wrap');
		
		$(document).on('click','#add-gallery', function() {

			var gallery = $('[name="add-gallery"]').val();
			
			var postData = Array();
			
			var galleryName = gallery;
			var gallerySlug = gallery.toLowerCase();
			
			var gal = {
				galName: galleryName,
				galSlug: gallerySlug,
			};
			
			postData.push(gal);
			console.log(postData);
			
			$.post(imagineajax.ajaxurl, {
				addgallery : postData,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('.imagine-gallery-overview-wrap').html(response);
				loadjs();
			});

		});
		
		$(document).on('click','#add-album', function() {

			var album = $('[name="add-album"]').val();
			
			var postData = Array();
			
			var albumName = album;
			var albumSlug = album.toLowerCase();
			
			var album = {
				albumName: albumName,
				albumSlug: albumSlug,
			};
			
			postData.push(album);
			console.log(postData);
			
			$.post(imagineajax.ajaxurl, {
				addalbum : postData,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('.imagine-wrap').html(response);
				loadjs();
			});

		});
		
		$(document).on('click','#add-template', function() {

			var template = $('[name="add-template"]').val();
			var tempType = $('[name="tempType"]').val();
			var tid = $('.admin-imagine-template-box').attr('templateid');
			var postData = Array();
			
			var templateName = template;
			
			var tmp = {
				tmpId: tid,
				tmpName: templateName,
				tmpType: tempType
			};
			
			postData.push(tmp);
			console.log(postData);
			
			$.post(imagineajax.ajaxurl, {
				addtemplate : postData,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('.imagine-wrap').html(response);
				loadjs();
			});

		});
		
		$(document).on('click','[type="edit-gallery"]', function() {
			var gid = $(this).attr('gid');
			
			$.post(imagineajax.ajaxurl, {
				gedit : gid,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				
				$('.imagine-formtable-wrap').html(response);
				$('[row="gallery"]').removeClass('highlight');
				$('[row="gallery"][gid="'+gid+'"]').addClass('highlight');
				loadjs();
			});
		});
		
		$(document).on('click','[type="edit-album"]', function() {
			var aid = $(this).attr('aid');
			
			$.post(imagineajax.ajaxurl, {
				albumedit : aid,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				
				$('.imagine-formtable-wrap').html(response);
				$('[row="album"]').removeClass('highlight');
				$('[row="album"][aid="'+aid+'"]').addClass('highlight');
				loadjs();
			});
		});
		$(document).on('click','[type="delete-gallery"]', function() {
			var gid = $(this).attr('gid');
			$.post(imagineajax.ajaxurl, {
				gdel : gid,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				
				$('.imagine-wrap').html(response);
				$('[row="gallery"]').removeClass('highlight');
				loadjs();
			});
		});
        
        $(document).on('click','[type="delete-image"]', function() {
			var iid = $(this).attr('iid');
			$.post(imagineajax.ajaxurl, {
				imgdel : iid,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				
				$('.imagine-wrap').html(response);
				$('[row="gallery"]').removeClass('highlight');
				loadjs();
			});
		});
		
		$(document).on('click', 'thead', function() {
			var tbody = $(this).parent().find('tbody');
			if (tbody.is(':visible')) {
				tbody.hide();
			} else {
				tbody.show();
			}
		});
		
		$(document).on('click','[type="edit-template"]', function() {
			var tid = $(this).attr('tid');
			
			$.post(imagineajax.ajaxurl, {
				tmpedit : tid,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				
				$('.imagine-formtable-wrap').html(response);
				loadjs();
			});
		});
		
		
		$(document).on('click','#edit-gallery', function() {

			var gallery = $('.admin_imagine_gallery_box').attr('galleryname');
			var postData = Array();
			var galleryId = $('[galleryname="'+gallery+'"]').attr('galleryid');
			var galleryName = $('[name="galtitle"]').val();
			var gallerySlug = galleryName.toLowerCase();
			var galleryPath = gallerySlug;
			var galleryDesc = $('[name="galdesc"]').val();
			
			var gal = {
				galName: galleryName,
				galSlug: gallerySlug,
				galPath: '/wp-content/'+galleryPath,
				galDesc: galleryDesc,
				galId: galleryId,
			};
			
			postData.push(gal);
			console.log(postData);
			
			$.post(imagineajax.ajaxurl, {
				addgallery : postData,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('.imagine-gallery-overview-wrap').html(response);
				loadjs();
			});

		});
		
		$(document).on('click','#edit-template', function() {

			var template = $('.admin_imagine_template_box').attr('templatename');
			var postData = Array();
			var templateId = $('[templatename="'+template+'"]').attr('templateid');
			var templateName = $('[name="tmptitle"]').val();
			var templateDesc = $('[name="tmpdesc"]').val();
			
			var tmp = {
				tmpName: templateName,
				tmpDesc: templateDesc,
				tmpId: templateId,
			};
			
			postData.push(tmp);
			console.log(postData);
			
			$.post(imagineajax.ajaxurl, {
				addtemplate : postData,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('.imagine-template-overview-wrap').html(response);
				
				loadjs();
			});

		});
		
		
		
		$(document).on('click','#option-submit', function() {
			var options = Array();
			$('input').each( function() {
				var input = $(this).attr('name');
				var value = $(this).val();
				var data = {
					input: input,
					value: value
				};
				options.push(data);
			});
			$('select').each( function() {
				var input = $(this).attr('name');
				var value = $(this).val();
				var data = {
					input: input,
					value: value
				};
				options.push(data);
			});
			console.log(options);
			$.post(imagineajax.ajaxurl, {
				optionsubmit: options,
				action: 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('.imagine-wrap').html(response);
			});
		});
		
		$(document).on('click', '#viewexample', function() {
			$('.template-example').fadeIn(1000);
		});
		
		$(document).on('click','#edit-images', function() {
			var images = Array();
			var tablepos = $('.imagine-formtable-wrap .wp-list-table').offset().left;
			console.log(tablepos);
			$('[row="image"]').each( function() {
				var gid = $(this).attr('gid');
				var imgid = $(this).attr('imgid');
				var imgdesc = $(this).find('[name="imgDesc"]').val();
				if (imgdesc == undefined) {
					imgdesc = $(this).find('[col="imgdesc"]').text();
				}
				var imgtitle = $(this).find('[name="imgAltTitle"]').val();
				if (imgtitle == undefined) {
					imgtitle = $(this).find('[col="imgtitle"]').text();
				}
				var img = {
					gid: gid,
					imgid: imgid,
					imgDesc: imgdesc,
					imgAltTitle: imgtitle
				};
				images.push(img);
			});
			console.log(images);
			$.post(imagineajax.ajaxurl, {
				editimages : images,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				tablepos -= 180;
				tablepos = -Math.abs(tablepos);
				$('.imagine-formtable-wrap').html(response);
				console.log(tablepos);
				$('.imagine-formtable-wrap .wp-list-table').animate({'left': tablepos});
				loadjs();
			});
		});
		
		$(document).on('click','#update-gallery', function() {
			var gallery = Array();
			var curgal = $('.highlight').attr('gid');
			var tablepos = $('.imagine-gallery-overview-wrap .wp-list-table').offset().left;
			$('[row="gallery"]').each( function() {
				var gid = $(this).attr('gid');
				var galdesc = $(this).find('[name="galleryDesc"]').val();
                var galpreview = $(this).find('[name="galleryPreview"]').val();
                var galtemp = $(this).find('[name="galleryTemplate"]').val();
				if (galdesc == undefined) {
					galdesc = $(this).find('[col="gdesc"]').text();
				}
				var gname = $(this).find('[name="galleryName"]').val();
				if (gname != undefined) {
					var notice = '<p class="imagine-notice">Changing your galleryname will not affect the gallery path. If you want your images to upload somewhere else, please create a new gallery.</p>';
					$('.imagine-wrap').prepend(notice);
					notice = undefined;
					
				} else if (gname == undefined) {
					gname = $(this).find('[col="gname"]').text();
				}
				var gal = {
					galId: gid,
					galDesc: galdesc,
					galName: gname,
                    galPreview: galpreview,
                    galTemplate: galtemp
				};
				gallery.push(gal);
			});
			console.log(gallery);
			$.post(imagineajax.ajaxurl, {
				updategallery : gallery,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				tablepos -= 180;
				tablepos = -Math.abs(tablepos);
				$('.imagine-gallery-overview-wrap').html(response);
				console.log(response);
				$('.imagine-gallery-overview-wrap .wp-list-table').animate({'left': tablepos});
				if (curgal != undefined) {
					$('[row="gallery"]').removeClass('highlight');
					$('[row="gallery"][gid="'+curgal+'"]').addClass('highlight');
				}
				
				loadjs();
			});
		});
        
        $(document).on('click','#update-album', function() {
			var album = Array();
			var curalbum = $('.highlight').attr('aid');
			var tablepos = $('.imagine-album-overview-wrap .wp-list-table').offset().left;
			$('[row="album"]').each( function() {
				var aid = $(this).attr('aid');
				var albumdesc = $(this).find('[name="albumDesc"]').val();
                var albumtemp = $(this).find('[name="albumTemplate"]').val();
				if (albumdesc == undefined) {
					albumdesc = $(this).find('[col="adesc"]').text();
				}
				var aname = $(this).find('[name="albumName"]').val();
				if (aname == undefined) {
					aname = $(this).find('[col="aname"]').text();
				}
                var apreview = $(this).find('[name="albumPreview"]').val();
				var alb = {
					albumId: aid,
					albumDesc: albumdesc,
					albumName: aname,
                    albumPreview: apreview,
                    albumTemp: albumtemp
				};
				album.push(alb);
			});
			console.log(album);
			$.post(imagineajax.ajaxurl, {
				updatealbum : album,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				tablepos -= 180;
				tablepos = -Math.abs(tablepos);
				$('.imagine-album-overview-wrap').html(response);
                
				$('.imagine-album-overview-wrap .wp-list-table').animate({'left': tablepos});
				if (curalbum != undefined) {
					$('[row="album"]').removeClass('highlight');
					$('[row="album"][aid="'+curalbum+'"]').addClass('highlight');
				}
				
				loadjs();
			});
		});
		
		$(document).on('click', '[name="upload-template"]', function() {
			var tid = $('.template-preview-wrap').attr('tid');
			$.post(imagineajax.ajaxurl, {
				uploadtemplate : {
					tid: tid,
					wrap: {
						name: 'wrap',
						show: true,
						width: '100%',
						height: 'auto',
						background: 'rgba(255,255,255,0.2)',
					},
					title: {
						name: 'title',
						order: '2',
						show:true, 
						color:'blue',
						fontsize: '1.2em'
					},
					desc: {
						name: 'desc',
						order: '1',
						show: true,
						color: 'red',
						fontsize: '0.9em'
					}
				},
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
			});
		});
        
        $(document).on('click', '#saveAlbum', function() {
        
            var content = [];
            var aid = $('h3.formhead').attr('aid');
            $('.aContain .gal').each( function() {
                var gid = $(this).attr('gid');
                content.push(gid);
            });
            content = content.join();
            console.log(content);
            
            $.post(imagineajax.ajaxurl, {
                savealbum: {aedit: aid, aid: aid, content: content},
                action: 'imagine-ajaxsubmit'
            }, function(response) {
                console.log(response);
                $('.imagine-formtable-wrap').html(response);
                loadjs();
            });
        });
		
        $(document).on('click','[type="delete-album"]', function() {
			var aid = $(this).attr('aid');
			$.post(imagineajax.ajaxurl, {
				adel : aid,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				
				$('.imagine-wrap').html(response);
				$('[row="gallery"]').removeClass('highlight');
				loadjs();
			});
		});
		
		$(document).on('click','#update-template', function() {
			var template = Array();
			var curtmp = $('.highlight').attr('tid');
			var tablepos = $('.imagine-template-overview-wrap .wp-list-table').offset().left;
			$('[row="template"]').each( function() {
				var tid = $(this).attr('tid');
				var tmpdesc = $(this).find('[name="tempDesc"]').val();
				if (tmpdesc == undefined) {
					tmpdesc = $(this).find('[col="tdesc"]').text();
				}
				var tname = $(this).find('[name="tempName"]').val();
				if (tname == undefined) {
					tname = $(this).find('[col="tname"]').text();
				}
				var tmp = {
					tmpId: tid,
					tmpDesc: tmpdesc,
					tmpName: tname
				};
				template.push(tmp);
			});
			console.log(template);
			$.post(imagineajax.ajaxurl, {
				updatetemplate : template,
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				tablepos -= 180;
				tablepos = -Math.abs(tablepos);
				$('.imagine-template-overview-wrap').html(response);
				console.log(response);
				$('.imagine-template-overview-wrap .wp-list-table').animate({'left': tablepos});
				if (curtmp != undefined) {
					$('[row="template"]').removeClass('highlight');
					$('[row="template"][tid="'+curtmp+'"]').addClass('highlight');
				}
				
				loadjs();
			});
		});
		
		function loadjs() {
			$('[col="imgdesc"]').on('click', function() {
				var text = $(this).text();
				var gid = $(this).closest('[row="image"]').attr('gid');
				var imgid = $(this).closest('[row="image"]').attr('imgid');
				if ($(this).find('input').length == false) {
					$(this).html('<input gid="'+gid+'" imgid="'+imgid+'" type="text" name="imgDesc" class="regular-text" value="'+text+'">');
				}
			});
			$('[col="imgtitle"]').on('click', function() {
				var text = $(this).text();
				var gid = $(this).closest('[row="image"]').attr('gid');
				var imgid = $(this).closest('[row="image"]').attr('imgid');
				if ($(this).find('input').length == false) {
					$(this).html('<input gid="'+gid+'" imgid="'+imgid+'" type="text" name="imgAltTitle" class="regular-text" value="'+text+'">');
				}
			});
			
			
			$('[col="gdesc"]').on('click', function() {
				var text = $(this).text();
				var gid = $(this).closest('[row="gallery"]').attr('gid');
				if ($(this).find('input').length == false) {
					$(this).html('<input gid="'+gid+'" type="text" name="galleryDesc" class="regular-text" value="'+text+'">');
				}
			});
			$('[col="gname"]').on('click', function() {
				var text = $(this).text();
				var gid = $(this).closest('[row="gallery"]').attr('gid');
				if ($(this).find('input').length == false) {
					$(this).html('<input gid="'+gid+'" type="text" name="galleryName" class="regular-text" value="'+text+'">');
				}
			});
            
            
			
			$('[col="tdesc"]').on('click', function() {
				var text = $(this).text();
				var tid = $(this).closest('[row="template"]').attr('tid');
				if ($(this).find('input').length == false) {
					$(this).html('<input tid="'+tid+'" type="text" name="tempDesc" class="regular-text" value="'+text+'">');
				}
			});
			$('[col="tname"]').on('click', function() {
				var text = $(this).text();
				var tid = $(this).closest('[row="template"]').attr('tid');
				if ($(this).find('input').length == false) {
					$(this).html('<input tid="'+tid+'" type="text" name="tempName" class="regular-text" value="'+text+'">');
				}
			});
            
            $('[col="adesc"]').on('click', function() {
				var text = $(this).text();
				var aid = $(this).closest('[row="album"]').attr('aid');
				if ($(this).find('input').length == false) {
					$(this).html('<input aid="'+aid+'" type="text" name="albumDesc" class="regular-text" value="'+text+'">');
				}
			});
			$('[col="aname"]').on('click', function() {
				var text = $(this).text();
				var aid = $(this).closest('[row="album"]').attr('aid');
				if ($(this).find('input').length == false) {
					$(this).html('<input aid="'+aid+'" type="text" name="albumName" class="regular-text" value="'+text+'">');
				}
			});
			
            $('.addGal .gal').draggable({
                drag: function( event, ui ) {
                    ui.helper.css({zIndex: 999});
                },
                stop: function( event, ui ) {
                    ui.helper.css({left:0, top: 0, width: '100%'});
                }
            });
            $('.aContain').droppable({
                accept: '.gal',
                drop: function( event, ui ) {
                    var gid = ui.draggable.attr('gid');
                    if ( $(this).find('[gid="'+gid+'"]').length == false ) {
                        
                        ui.draggable.css({left:0, top: 0, width: '100%'});
                        ui.draggable.clone().css({
                            left: 0,
                            top: 0,
                            width: '100%'
                        }).appendTo($(this)).destroy();
                    } else {
                        ui.draggable.css({left:0, top: 0, width: '100%'});
                        $('.aContain [gid="'+gid+'"]').css({backgroundColor: 'white'});
                        setTimeout( function() {
                        $('.aContain [gid="'+gid+'"]').css({backgroundColor: '#E4F2FD'});
                        }, 1000);
                    }
                }
            });
            
            $(document).on('click', '.aContain .gal [ref="del"]', function() {
                console.log('del');
                var gid = $(this).parent().attr('gid');
                $(this).parent().remove();
            });
			
			$('.imagine-wrap table').draggable({ 
				axis:'x', 
				drag: function(event, ui) {
					var leftpos = ui.position.left;
					var uiwidth = $(this).width();
					var pwidth = $(this).parent().width();
					var offsetright = $(this).offset().left;
					
					var offset = -Math.abs(uiwidth-pwidth);
					if (leftpos > 5) {
						ui.position.left = '0';
					}
					if (leftpos < offset) {
						pwidth = -Math.abs(pwidth);
						ui.position.left = offset;
					}
				}
			});
		}
		loadjs();
		
        $('#imagine_sectionid h3').click( function() {
            var rel = $(this).attr('rel');
            $('.form').hide();
            $('.response').hide();
           $('div[rel="'+rel+'"]').fadeIn(); 
        });
        
		$('[name="metabox-option-gallery"],[name="metabox-option-template"],[name="metabox-option-layovertemplate"]').on( 'change', function() {
			
			var metaboxData = Array();
			var gal = $("[name='metabox-option-gallery']").val();
			var temp = $("[name='metabox-option-template']").val();
			var layovertemp = $("[name='metabox-option-layovertemplate']").val();
			
			
			metaboxData.push({gid: gal, template: temp, layovertemplate: layovertemp});
    		console.log(metaboxData);
			$.post(imagineajax.ajaxurl, {
				metaboxgallery : metaboxData,
				dataType:"html",
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('#imagine_sectionid .inside .response').html('<span style="color: #a8a8a8">// please copy the following code to your content</span></br>').append(response).fadeIn();
			});
		});
        
        
        $('[name="metabox-option-album"],[name="metabox-option-album-template"]').on( 'change', function() {
			
			var metaboxData = Array();
			var alb = $("[name='metabox-option-album']").val();
			var temp = $("[name='metabox-option-album-template']").val();
			
			
			metaboxData.push({aid: alb, template: temp});
    		console.log(metaboxData);
			$.post(imagineajax.ajaxurl, {
				metaboxalbum : metaboxData,
				dataType:"html",
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('#imagine_sectionid .inside .response').html('<span style="color: #a8a8a8">// please copy the following code to your content</span></br>').append(response).fadeIn();
			});
		});
        
        $('[name="metabox-option-image"]').on( 'change', function() {
			
			var metaboxData = Array();
			var img = $("[name='metabox-option-image']").val();
			var temp = $("[name='metabox-option-image-template']").val();
			
			metaboxData.push({iid: img, template: temp});
    		console.log(metaboxData);
			$.post(imagineajax.ajaxurl, {
				metaboximage : metaboxData,
				dataType:"html",
				action : 'imagine-ajaxsubmit'
			}, function(response) {
				console.log(response);
				$('#imagine_sectionid .inside .response').html('<span style="color: #a8a8a8">// please copy the following code to your content</span></br>').append(response).fadeIn();
			});
		});
		
	});
})(jQuery);
