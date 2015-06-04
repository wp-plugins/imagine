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
							
							var eid = $(this).attr('identity');
							
							
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
								
								
									
									$('.imagine[aid="'+aid+'"][type="album"][identity="'+eid+'"]').fadeIn(1000).html(response);
									
									
							});
								
		
						
					});
					
			
			}
		};
		
		
		$.imagineImage = function (id, temp, ltemp, tselect, width, height) {
            
            /* to add:
            * width and height overwrite
            */
            
			var imagine = $('.imagine[type="image"]');
			if(imagine.length > 0) {
				
					imagine.each( function() {
							$(this).hide();
							
							var eid = $(this).attr('identity');
							
							
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
								var type = 'image'; 
							}
							
							
							
							if ( id == undefined ) {
								var iid = $(this).attr('iid');
							} else {
								var iid = id;
							}
								
							var data = Array();
							data.push( {
								image:iid, 
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
								
								
									
									$('.imagine[iid="'+iid+'"][type="image"][identity="'+eid+'"]').fadeIn(1000).html(response);
									
									
							});
								
		
						
					});
					
			
			}
		};
		
		/* imagineGallery function */
		$.imagineGallery = function (inside, aeid, id, temp, ltemp, tselect) {
            /* select imagine galleries to load, can be multiple */
			var imagine = $('.imagine[type="gallery"]');
            /* if overwritten only one instance of .imagine is loaded. */
            if ( id !== undefined ) {
                // console.log('ran');
                var imagine = $('.imagine[type="gallery"][gid="'+id+'"]');
            };
            if ( id !== undefined && aeid !== undefined) {
                // console.log('ran');
                var imagine = $('[type="album"][identity="'+aeid+'"] .imagine[type="gallery"][gid="'+id+'"]');
            };
			if(imagine.length > 0) {

                imagine.each( function() {
                    /* hide .imagine */
                    $(this).hide();
                    /* get elem identity */
                    // console.log(imagine.length);
                    var eid = $(this).attr('identity');
                    
                    // console.log('aid: ' + aid + '- aeid: ' + aeid + '- eid: ' + eid);
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
                        var aid = imagine.closest('[type="album"]').attr('aid');
                        var aeid = imagine.closest('[type="album"]').attr('identity');
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
                    
                    // check to see if imagine container has an album parent.
                    
                    
                    /* send the data to admin-ajax.php */
                    $.get(imagineajax.ajaxurl, {
                        imagine : data,
                        action : 'imagine-ajaxsubmit',
                        dataType: 'html',
                    }, function(response, data, xhr) {
                        /* append the response to the correct gallery */
                        if ( aid != undefined ) {
                            $('[aid="'+aid+'"][identity="'+aeid+'"] .imagine[gid="'+gid+'"][type="gallery"][identity="'+eid+'"]').fadeIn(1000).html(response);
                            
                        } else {
                            $('.imagine[gid="'+gid+'"][type="gallery"][identity="'+eid+'"]').fadeIn(1000).html(response);
                            
                        }
                    });
				});	
			}
		};
        
        /* Album overview gallery wrap click event */
		$(document).on('click', '.imagine-gallery-wrap', function() {
            
            /* hide all galleries */
            var aid = $(this).closest('[type="album"]').attr('aid');
            $('[type="album"] .imagine[type="gallery"]').hide();
            var aeid = $(this).closest('[type="album"]').attr('identity');
            
            
            /* get id clicked gal */
            var gid = $(this).attr('gid');
            /* check to see if contains .imagine already. */
			var content = $(this).find('.imagine');
            /* if not found append new .imagine[type=gallery] div and load the gallery into it */
			if ( content.length == false ) {
                console.log('did not find content');
                $(this).append('<div gid="'+gid+'" type="gallery" class="imagine"></div>');
                $.identifyImagine();
                /* let $.imagineGallery run on one instance only. OVERRIDING the GID */
                $.imagineGallery('true', aeid, gid);
            /* if found just show the gallery */
			} else if ( content.length == true ) {
                console.log('found content');
                $('[aid="'+aid+'"][identity="'+aeid+'"] .imagine[type="gallery"][gid="'+gid+'"]').fadeIn(1000);
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
        
        $.identifyImagine = function(id) { 
                var elements = $('.imagine');
                var identity = $('.imagine[identity]').length;
                elements.each( function() {
                    if ( $(this).attr('identity') == undefined ) {
                        $(this).attr('identity', identity);
                        identity++;
                    }
                });
            
            
        }
        
        $.identifyImagine();
		$.imagineAlbum();
		$.imagineGallery();
        $.imagineImage();
	});
	
	
	
	
})(jQuery); 