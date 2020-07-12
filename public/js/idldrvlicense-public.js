(function( $ ) {
	'use strict';

		var current_fs, next_fs, previous_fs; //.body-panels
	var left, opacity, scale; //.body-panel properties which we will animate
	var animating=false; //flag to prevent quick multi-click glitches
	$(function(){
		var txtbox = $('input[type="text"]');
	    txtbox.removeAttr('placeholder');
		//jQuery('#preferred_day').multiSelect();
		$("#postcode").inputmask("9999 AA");
		$('#preferred_day').multiselect();
		$('#preferred_time').multiselect();
		$('#dob').datepicker({format:'dd/MM/yyyy'});
		var dataid = $('#dataid').val();
		var cookieValue = $.cookie("idlhandle");
		if(!cookieValue)
			$.cookie("idlhandle", dataid, { expires : 10 });
		var $form = $("#msform");
		var btnsbm = $("#submit_form");
		var validator = $form.validate({
			// Specify validation rules
			ignore: ':not(:visible)',
			rules: {
				agreeterms: "required",
				first_name: "required",
				last_name: "required",
				dob:"required",
				acceptit:"required",
				screen_text:"required",
				phone_number:"number",
				preferred_day:"required",
				preferred_time:"required",
				phone_number:"required",
				postcode:"required",
				house_number:"required",
				email: {
					required: true,
					email: true
				  },
			},
			// Specify validation error messages
			messages: {
				agreeterms: "",
				first_name: "Dit veld is verplicht",
				last_name: "Dit veld is verplicht",
				dob:"Dit veld is verplicht",
				acceptit:"Dit veld is verplicht",
				screen_text:"Dit veld is verplicht",
				phone_number:"Dit veld is verplicht",
				preferred_day:"Dit veld is verplicht",
				preferred_time:"Dit veld is verplicht",
				email:"Dit veld is verplicht",
				postcode:"Dit veld is verplicht",
				house_number:"Dit veld is verplicht",

				/*first_name: "Please enter your first name",
				last_name: "Please enter your last name",*/
				acceptit: "Kindly accept terms and conditions",
			},
			errorPlacement: function(error, element) {
				if (element.attr("type") == "radio") {
					error.insertBefore(element);
				} else {
					error.insertAfter(element);
				}
			},
			focusInvalid: false,
			invalidHandler: function(form, validator) {

				if (!validator.numberOfInvalids())
					return;

				//animate($(validator.errorList[0].element).offset().top-60);
			},
			// Make sure the form is submitted to the destination defined
			// in the "action" attribute of the form when valid
			submitHandler: function(form) {
			  //form.submit();
			}
		});

		if(goto3 === true) {
			$( ".next" ).on( "click", function() {
			   gonext($(this));
			});
			$('.next').trigger("click");
		}
		

		$(".next").click(function(){

			if (!validator.form()) { // Not Valid
                return false;
            } else {
            	var preferred_dayarray = $("#preferred_day").val();
            	var preferred_timearray = $("#preferred_time").val();
            	var serialize = $("#msform").serialize();
                $.ajax({
                    url: idlajax.ajax_url, 
                    data: serialize+'&prefdat='+preferred_dayarray+'&preftime='+preferred_timearray+'&action=savelicense',
                    method:'post',
                    dataType: 'json',
                    success: function(result){						
                    }
				});
				
				gonext($(this));
			}
		});

		$(".previous").click(function(){
			goprevious($(this));
		});

		$(".idlsubmit").click(function(){
			if (!validator.form()) { // Not Valid
                return false;
            } else {
				$(this).html("Working...").attr('disabled', true);
                $.ajax({
                    url: idlajax.ajax_url, 
                    data: $("#msform").serialize()+'&action=paynow',
                    method:'post',
                    dataType: 'json',
                    success: function(res){	
						if(res.status == 'success')	
							window.location.href = res.url;	
						else if(res.status == 'error')
							$.notify(res.error, "error");				
                    }
				});
			}
		})

		$(".jchange").each(function() {

			let id = $(this).attr('id');
			let val = $(this).val();
			if (id == "preferred_day") {
				var selMulti = $.map($("#preferred_day option:selected"), function (el, i) {
		         return $(el).text();
		     });
		     	val = selMulti.join(", ");
			}
			$("#d_"+id).html(val);

		  });
		$(".jchange").change(function(){
			let id = $(this).attr('id');
			let val = $(this).val();
			if (id == "preferred_day") {
				var selMulti = $.map($("#preferred_day option:selected"), function (el, i) {
		         return $(el).text();
		     });
		     	val = selMulti.join(", ");
			}

			else if (id == "preferred_time") {
				var selMulti = $.map($("#preferred_time option:selected"), function (el, i) {
		         return $(el).text();
		     });
		     	val = selMulti.join(", ");
			}
			$("#d_"+id).html(val);
		})
	});
	function gonext(thisObj) {

		if(animating) return false;
		animating = true;
		
		current_fs = thisObj.parent();
		next_fs = thisObj.parent().next();
		
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($(".body-panel").index(next_fs)).addClass("active");
		
		//show the next .body-panel
		next_fs.show(); 
		//hide the current .body-panel with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({
			'transform': 'scale('+scale+')',
			'position': 'absolute'
		  });
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 0, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	}

	function goprevious(thisObj) {
		if(animating) return false;
		animating = true;
		
		current_fs = thisObj.parent();
		previous_fs = thisObj.parent().prev();
		
		//de-activate current step on progressbar
		$("#progressbar li").eq($(".body-panel").index(current_fs)).removeClass("active");
		
		//show the previous .body-panel
		previous_fs.show(); 
		//hide the current .body-panel with style
		current_fs.hide();
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale previous_fs from 80% to 100%
				scale = 0.8 + (1 - now) * 0.2;
				//2. take current_fs to the right(50%) - from 0%
				left = ((1-now) * 50)+"%";
				//3. increase opacity of previous_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({'left': left});
				previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
			}, 
			duration: 0, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	}
})( jQuery );
