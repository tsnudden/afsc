$(function() {
	
	/*
		Binds keyword search functionality to a table using the following arguments:
		
		Argument 1: jQuery object of keyword input
		Argument 2: rows to search for highlighting
		
	*/
	function bindKeywordSearch(input, tbody) {
		
		var myHilitor = new Hilitor(tbody);
		myHilitor.setMatchType("open");
		
		input.keyup(function() {
			
			// Keyword highlighting
			var v = $(this).val().toLowerCase(),
				d, t;
			
			myHilitor.remove();
			myHilitor.apply(v);
			
			// Search for highlighting
			$("#" + tbody + " tr").show().hide().each(function() {
				d = $(this).data();
				t = $(this);
				$.each(d, function(key, value) {
					if(value.toLowerCase().indexOf(v) != -1) {
						t.show();
					}
				});
			});
			
			// get visible rows
			var visible_rows = $("#" + tbody + " tr:visible");
			
			// get terms of checked boxes and add terms to string
			var allowed = "";
			$(".data-search-term:checked").each(function() {
				allowed += $(this).data("term") + " ";
			});
			visible_rows.each(function() {
				if(allowed.indexOf($(this).data("check-term").toLowerCase()) == -1) {
					$(this).hide();
				}
			});
			
		});
		
		$(".data-search-term").change(function() {
			$("#keyword").trigger("keyup");
		});
		
		// if($(".data-search-term").length > 0) {
			// $(".data-search-term").each(function() {
				// bindCheckboxSearch($(this), $(".table.search-table tbody").prop("id"));
			// });
		// }
		
		
		// rows = $("#" + tbody + " tr:visible").hide().each(function() {
			// console.log(input.data("term"), $(this).data("search-term"));
			// if($(this).data("search-term") == input.data("term")) {
				// t.show();
			// }
		// });
	}
	
	
	if($(".table.search-table").length > 0) {
		bindKeywordSearch($("#keyword"), $(".table.search-table tbody").prop("id"));
	}
	
	$(".datepicker-input").datepicker({
		dateFormat: "dd/mm/yy"
	});
	
});