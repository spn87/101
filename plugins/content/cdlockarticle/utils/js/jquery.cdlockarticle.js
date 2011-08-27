/**
 * Application - Core Design Lock Article plugin
 */

(function($) {
	$.cdlockarticle = {
		
		// Init application
		initiator: function() {
		
			$.cdlockarticle.formRoutine();
			
			container = $('div.lockarticle');
			container.addClass($.cdlockarticle.settings.theme);
			
			$.cdlockarticle.buttonRoutine(container); // style button
			
			container.find('button').click(function() {
				
				// unlock article
				if($(this).children('span').hasClass('ui-icon-unlocked')) {
					$.cdlockarticle.unlockArticle();
					return false;
				}
				
				// unlock article
				if($(this).children('span').hasClass('ui-icon-locked')) {
					$.cdlockarticle.lockArticle();
					return false;
				}
				
				return true;					
			});
		},
		
		// Focus form
		formRoutine: function() {
			var form = $('form[name="checkarticlepassword"]');
			
			var input_password = form.find('input[name="articlepassword"]');
			
			input_password.attr('autocomplete', 'off');
			
			input_password.focus();
			$.cdlockarticle.buttonRoutine(form);
			
			form.submit(function(e){
				e.preventDefault();
				
				if ($.trim(input_password.val()) == '' || $.trim(input_password.val()).length > 255) {
					// prevent emtpy password or password max lenght value (255)
					return false;
				} else {
					var data = form.serialize();
					$.ajax({
						type: 'POST',				
						dataType: 'html',
						cache: true,
						data: data,
						beforeSend: function() { $.cdlockarticle.loading(); },
						success: function(msg) {
							if (msg) {
								alert(msg);
								input_password.val('');
								return false;
							}
							window.location.reload(); // refresh page
							return true;
						},
						complete: function() { $.cdlockarticle.loading(); }
					});
					return true;
				}
			});
		},
		
		// Button routine
		buttonRoutine: function(container) {
			if (typeof container === 'undefined') return false;
			
			container.find('button').addClass('ui-state-default ui-corner-all').hover(
					function(){ 
						$(this).addClass('ui-state-hover');
						$(this).click(function() {
							$(this).removeClass('ui-state-hover');
						});
					},
					function(){ 
						$(this).removeClass('ui-state-hover'); 
					}
				);
		},
		
		// Lock article
		lockArticle: function() {
			var password = $.trim(prompt($.cdlockarticle.language.CDLOCKARTICLE_PASSWORD, ''));
			if (password) {
				var password2 = $.trim(prompt($.cdlockarticle.language.CDLOCKARTICLE_PASSWORD2, '')); 
				if (password2) {
					if (password != password2) {
						alert($.cdlockarticle.language.CDLOCKARTICLE_PASSWORD_DO_NOT_MATCH);
						return false;
					} else {
						
						var form = $('form[name="lockArticle"]');
						
						var headertext = prompt($.cdlockarticle.language.CDLOCKARTICLE_HEADER, '');
						
						if (headertext) form.find('input[name="headertext"]').val(headertext);
						
						form.find('input[name="password"]').val(password);
						
						var data = form.serialize();
						
						$.ajax({
							type: 'POST',				
							dataType: 'html',
							cache: true,
							data: data,
							beforeSend: function() { $.cdlockarticle.buttonState('enable', container); },
							success: function(msg) {
								if (msg) {
									alert(msg);
									return false;
								}
								$('div.lockarticle').find('button').children('span').removeClass('ui-icon-locked').addClass('ui-icon-unlocked');
								form.find('input[name="cdlockarticleaction"]').val('unlockArticle');
								return true;
							},
							complete: function() {
								$.cdlockarticle.buttonState('disable', container);
							}
						});
					}
				}
			} else {
				return false;
			}
			return false;
		},
		
		// Unlock article
		unlockArticle: function() {
			var form = $('form[name="lockArticle"]');
			
			// check if user is admin
			if (!$.cdlockarticle.settings.isAdmin) {
				var password = $.trim(prompt($.cdlockarticle.language.CDLOCKARTICLE_PASSWORD_TO_UNLOCK, ''));
				if (!password) return false;
				
				// set password to form
				form.find('input[name="password"]').val(password);
			}
			
			var data = form.serialize();
			
			$.ajax({
				type: 'POST',				
				dataType: 'html',
				cache: true,
				data: data,
				beforeSend: function() { $.cdlockarticle.buttonState('enable', container); },
				success: function(msg) {
					if (msg) {
						alert(msg);
						return false;
					}
					
					$('div.lockarticle').find('button').children('span').removeClass('ui-icon-unlocked').addClass('ui-icon-locked');
					form.find('input[name="cdlockarticleaction"]').val('lockArticle');
					return true;
				},
				complete: function() { $.cdlockarticle.buttonState('disable', container); }
			});
			return true;
		},
		
		// Button state
		buttonState: function(state, element) {
			if (typeof state === 'undefined') state = 'disable';
			
			if (state == 'enable') {
				element.find('button').addClass('ui-state-disabled').attr('disabled', true);
			} else {
				element.find('button').removeClass('ui-state-disabled').attr('disabled', false);
			}
			
			return true;
		},
		
		// loading image
		loading: function() {
			var form = $('form[name="checkarticlepassword"]');
			
			if (form.find('div.loading').length > 0) {
				form.find('div.loading').remove();
			} else {
				form.find('input[name="articlepassword"]').after('<div class="loading" title="Loading..."></div>');
			}
			return false;
		}
		
		
	};
})(jQuery);