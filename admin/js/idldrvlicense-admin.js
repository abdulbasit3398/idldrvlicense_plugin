(function( $ ) {
	'use strict';
	$(document).ready(function(){
	
		$(".idltable_submitclass").click(function(){
		    var city = $("#city").val();
		    var zipcode = $("#zipcode").val();
		    if (!city || !zipcode) {
		    	alert("city & zipcode cannot be empty");
		    	return false;
		    }
	    });

		$(".sure_deleteclass").click(function(){
		    var txt;
			var r = confirm("Are you sure to delete this item");
			if (r == true) {
				return true;
			} else {
				return false;
			}
		});

	    $(".idltable_submitforms_class").click(function(){
		    var first_name = $("#first_name").val();
		    var last_name = $("#last_name").val();
			var email = $("#email").val();
			var phone_number = $("#phone_number").val();
			var postcode = $("#postcode").val();
			var house_number = $("#house_number").val();
			var dob = $("#dob").val();

		    if (!first_name || !last_name || !email || !phone_number || !postcode || !house_number || !dob) {
		    	alert("All Fields are required");
		    	 return false;
		    }
	 	});

	 	
  		
	});
})( jQuery );
