(function($) {
	$(document).ready(function() {
		
		$.viewImage = function(gid, imgid, layovertemp) {
			
			var img = {
				gid:gid, imgid:imgid, layovertemp: layovertemp
			};
			$.post(imagineajax.ajaxurl, {
				viewimage: img,
				action : 'imagine-ajaxsubmit',
				dataType: 'html'
			}, function(response, data, xhr) {
				console.log(response);
				$('body').append(response);
			});
		};
		$(document).on('click', '.close-imagine-layover', function() {
			$('#imagine-layover').remove();
		});
		$(document).on('click', '.imagine-thumbnail-wrap', function() {
			var imgid = $(this).attr('imgid');
			var gid = $(this).attr('gid');
			var layovertemp = $(this).parent('.imagine').attr('layovertemp');
			$.viewImage(gid, imgid, layovertemp);
		});
		
		$(document).on('change', '.tempselect', function() {
			var input = $(this).val();
			var imagine = $(this).closest('.imagine');
			$(imagine).attr('template', input);
			$.imagine(true);
		});
		
		$.imagineAlbum = function (id, temp, ltemp, tselect) {
			var imagine = $('.imagine[type="album"]');
			if(imagine.length > 0) {
				
					imagine.each( function() {
							$(this).hide();
							
							
							
							
							if ( temp == undefined ) {
								var temp = $(this).attr('template');
								
							}
							
							if ( ltemp == undefined ) {
								var layovertemp = $(this).attr('layovertemp');
							}
							
							if (tselect == undefined) {
								tselect = $(this).attr('tempselect');
								if (tselect == undefined) {
									tselect = false;
								}
							}
							
							if ( type == undefined ) {
								var type = 'album'; 
							}
							
							
							
							if ( id == undefined ) {
								var aid = $(this).attr('aid');
							} else {
								var aid = id;
							}
								
							var data = Array();
							data.push( {
								album:aid, 
								type: type, 
								template: temp, 
								ltemp: layovertemp, 
								tselect: tselect
							});
							
							
								
							$.get(imagineajax.ajaxurl, {
								imagine : data,
								action : 'imagine-ajaxsubmit',
								dataType: 'html',
							}, function(response, data, xhr) {
								
								
									
									$('.imagine[aid="'+aid+'"][type="album"]').fadeIn(1000).html(response);
									
									
							});
								
		
						
					});
					
			
			}
		};
		
		
		
		
		
		/* imagineGallery function */
		$.imagineGallery = function (inside, id, temp, ltemp, tselect) {
            /* select imagine galleries to load, can be multiple */
			var imagine = $('.imagine[type="gallery"]');
            /* if overwritten only one instance of .imagine is loaded. */
            if ( id !== undefined ) {
                var imagine = $('.imagine[type="gallery"][gid="'+id+'"]');
            };
			if(imagine.length > 0) {

                imagine.each( function() {
                    /* hide .imagine */
                    $(this).hide();
                    /* use the inline set attribute template if not overwritten at function call, if not set will use default template -> imagine.ajax.php */
                    if ( temp == undefined ) {
                        var temp = $(this).attr('template');
                    }
                    /* use the inline set attribute layovertemplate if not overwritten at function call, if not set will use default layovertemplate -> imagine.ajax.php */
                    if ( ltemp == undefined ) {
                        var layovertemp = $(this).attr('layovertemp');
                    }
                    /* include a template picker, not fully functional yet. */
                    if (tselect == undefined) {
                        tselect = $(this).attr('tempselect');
                        if (tselect == undefined) {
                            tselect = false;
                        }
                    }
                    /* sets the correct type if none set as inline attribute */
                    if ( type == undefined ) {
                        var type = 'gallery'; 
                    }
                    /* sets the correct id if none set at function call - ie. $.imagineGallery('12') */
                    if ( id == undefined ) {
                        /* use inline */
                        var gid = $(this).attr('gid');
                    } else {
                        /* use function call id */
                        var gid = id;
                    }
                    if ( inside == 'true' ) {
                        var ins = 'true';
                    }
                    
                    
                    /* push some data for imagine-ajaxsubmit */
                    var data = Array();
                    data.push( {
                        gallery:gid, 
                        type: type, 
                        template: temp, 
                        ltemp: layovertemp, 
                        tselect: tselect,
                        inside: ins
                    });
                    
                    
                    
                    /* send the data to admin-ajax.php */
                    $.get(imagineajax.ajaxurl, {
                        imagine : data,
                        action : 'imagine-ajaxsubmit',
                        dataType: 'html',
                    }, function(response, data, xhr) {
                        /* append the response to the correct gallery */
                        $('.imagine[gid="'+gid+'"][type="gallery"]').fadeIn(1000).html(response);
                    });
				});	
			}
		};
		
        /* Album overview gallery wrap click event */
		$(document).on('click', '.imagine-gallery-wrap', function() {
            /* hide all galleries */
            $('.imagine[type="gallery"]').hide();
            /* get id clicked gal */
            var gid = $(this).attr('gid');
            /* check to see if contains .imagine already. */
			var content = $(this).find('.imagine');
            /* if not found append new .imagine[type=gallery] div and load the gallery into it */
			if ( content.length == false ) {
                $(this).append('<div gid="'+gid+'" type="gallery" class="imagine"></div>');
                /* let $.imagineGallery run on one instance only. OVERRIDING the GID */
                $.imagineGallery('true', gid);
            /* if found just show the gallery */
			} else if ( content.length == true ) {
                $('.imagine[type="gallery"][gid="'+gid+'"]').fadeIn(1000);
            }
		});
		
	/*	
		$.setAspectRatio = function(width, height) {
			
			var target = $('.imagine-thumbnail-wrap img');
			$(target).each( function() {
				
				var img = $(this);
				img.load(function() {
					var cwidth  = $(img).width();
					var cheight = $(img).height();
					
					var cperc = cheight / cwidth;
					cperc = cperc.toFixed(2);
					
				
					
					
					var perc = height / width;
					perc = perc.toFixed(2);
				
					
				
					
				
					// Resize only aspect ratio does not meet requirements of input
					if ( cperc != perc ) { 
						// img aspect ratio height is lower
						if ( cperc < perc ) { 
							console.log('imgs perc: '+cperc+' and ratio perc: '+perc);
							
							var calcwidth = cwidth / width;
							var calcheight = cheight / width;	
			
							var newwidth = (calcwidth * width) * 3.16;
							var newheight = (calcheight * height) * 3.16;
							
							console.log(newwidth+':'+newheight);
							
							img.parent().css({height: newheight, overflow:'hidden', borderBottom: '2% solid rgba(255,255,255,0.6)'});
						// img aspect ratio height is higher
						} else { 
							
						
							var calcwidth = cwidth / width;
							var calcheight = cheight / width;	
			
							var newwidth = calcwidth * width;
							var newheight = calcheight * height;
							
							console.log(newwidth+':'+newheight);
							
							img.parent().css({height: newheight, overflow:'hidden', borderBottom: '2% solid rgba(255,255,255,0.6)'});
						}
					} 
				
				
				});
			});
		
		
			
		};
		*/
		$.imagineAlbum();
		$.imagineGallery();
	});
	
	
	
	
})(jQuery); 