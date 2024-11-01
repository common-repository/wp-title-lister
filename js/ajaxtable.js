(function($){
	$.fn.ajaxtable = function(custom) {
	
		// Default configuration
		var defaults = {
		  	rowsPerPage: 10,
			currentPage: 1,
			searchField: "",
			searchColumns: "",
			loadElement: "",
			sortColumnDefault: "",
			sortDefault: "asc",
			sortHandlers: true,
			columnWidth: "10%",
			nextPrev: false
		};

		// Combine user and default configuration
		var settings = $.extend({}, defaults, custom);

		// Variable declarations
		var table = $(this);
		var currentPage = 0;
		var searchText;
		var sortColumn;
		var sortAsc = true;
		
		if(settings.sortDefault == "asc"){
			sortAsc = true;	
		}else{
			sortAsc  = false;
		}
		
		// Trigger init
		init();
		
		// Define searchfield if needed
		if(settings.searchField != ""){	
			$(settings.searchField).show();
			$(settings.searchField).keyup(function(){
				searchText = this.value;
				page(1);
			});
		}
		
		/**
		 * Load page
		 *
		 * @param int number
		 */
		 function page(number){

			 if(number == "&lt;"){
				 current = table.find(".tablenavigation li.active a").html();
				 number = parseInt(current) - 1;
			 }else if(number == "&gt;"){
				 current = table.find(".tablenavigation li.active a").html();
				 number = parseInt(current) + 1;
			 }else{
				number = parseInt(number); 
			 }
			 
			 // Show loader
			showLoadElement(true);
			
			// Default search
			if((!table.hasClass("prepared") == true) && (settings.sortColumnDefault != "")){
				sortColumn = settings.sortColumnDefault;
			}
			
			$.post( settings.source, {action: "page", page: number, rowspp: settings.rowsPerPage, searchtext: searchText, searchcolumns: settings.searchColumns, sortcolumn: sortColumn, sortasc: sortAsc, nextPrev: settings.nextPrev}, function(response){
																																										
				if(response.code == 200){
					
					// Number of columns
					var number_columns = response.extra.columns.length;
					
					// Column array
					var array_columns = new Array(number_columns);
					array_columns = response.extra.columns;
					
					// Set current page
					currentPage = response.extra.currentpage;
					
					// Check if the table is prepared
					if(!table.hasClass("prepared") == true){
						prepare(array_columns, response.extra);
					}
					
					// Fill class vars
					fillClassVars(response.extra, response.navigation);
					
					var row = "";
					$.each(response.data, function(i, val){
						if(response.data[i]['class_name'] != "" && response.data[i]['class_name'] != undefined){
							row += '<tr class="' + response.data[i]['class_name'] + '">';
						}else{
							row += '<tr>';	
						}
						for(j=0;j < number_columns; j++){
							classvar = '';
							if(j == (number_columns-1)){
								classvar = ' class="last"';	
							}
							
							row += '<td' + classvar + '>' + response.data[i][array_columns[j]] + '</td>';
						}
						row += '</tr>';
					});
					table.find("tbody").html(row);
					
					// Add table stripes
					table.find("tbody tr:visible:even").addClass("even");
					table.find("tbody tr:visible:odd").addClass("odd");
					
					// Hide loader
					showLoadElement(false);
				}else{
					showError(response.message);	
					showLoadElement(false);
				}
			}, "json" );
		 }
		
		/**
		 * Initialize table
		 */
		function init(){
			showLoadElement(false);
			table.find("tbody").html("");
			page(settings.currentPage);
		}
		
		/**
		 * Prepare table
		 * Add thead/tbody/tfoot to the table
		 *
		 * @param array columns
		 * @param object extra
		 */
		function prepare(columns, extra){
			
			// Add head
			var thead = '<tr>';
			$.each(columns, function(i, val){
						 
				var width;
				if(typeof(settings.columnWidth) == "string"){
					width = settings.columnWidth;
				}else{
					width = settings.columnWidth[i];
				}
				
				classvar = '';
				if(i == 0){
					classvar = ' class="first"';
				}
				
				if(typeof(settings.sortHandlers) == "boolean"){
					if(settings.sortHandlers){
					thead += '<th width="' + width + '"' + classvar + '><a href="#" onclick="return false;">' + columns[i] + '</a><span class="sorthandle"></span></th>';
					}else{
						thead += '<th width="' + width + '"' + classvar + '>' + columns[i] + '<span class="sorthandle"></span></th>';
					}
				}
				if((typeof(settings.sortHandlers) == "object")){
					if(columns.length==settings.sortHandlers.length && settings.sortHandlers[i]){
						thead += '<th width="' + width + '"' + classvar + '><a href="#" onclick="return false;">' + columns[i] + '</a><span class="sorthandle"></span></th>';
					}else{
						thead += '<th width="' + width + '"' + classvar + '>' + columns[i] + '<span class="sorthandle"></span></th>';
					}
				}
				
			});

			thead += '</tr>';
			table.find("thead").html(thead);
			
			// Add sort handler
			table.find("thead th a").bind('click', function(){
				sortColumn = $(this).html();
				var head = $(this).parent().find("span");
				var setted = false;
				$(this).parent().siblings().find("span").removeClass("desc");
				$(this).parent().siblings().find("span").removeClass("asc");
				
				// If has class desc
				if(head.hasClass("desc")){
					sortAsc = true	
					head.removeClass("desc");
					head.addClass("asc");
					setted  = true;
				}
				
				// If has class asc
				if(head.hasClass("asc") && !setted){
					sortAsc = false;
					head.removeClass("asc");
					head.addClass("desc");
					setted  = true;
				}
				
				// Set default
				if(!setted){
					if(settings.sortDefault == "asc"){
						head.addClass("asc");
						sortAsc = true;	
					}else{
						head.addClass("desc");
						sortAsc  = false;
					}
				}
				
				page(1);						   
			});

			// Add prepared class
			table.addClass("prepared");
		}
		
		/**
		 *
		 *
		 */
		function showError(message){
			 table.find("thead").html('<th class="error">Data error</th>');
			 table.find("tbody").html('<tr><td class="error">' + message + '</td><tr>');
			 table.find("tfoot").html('');
		}
		
		
		/**
		 * Set page x is active
		 *
		 * @param int number
		 */
		function setActivePage(number){
			table.find('.tablenavigation li').removeClass("active");
			table.find('.tablenavigation li:eq(' + number + ')').addClass("active");	
		}
		
		/**
		 * Generate html for the navigation
		 *
		 * @param object extra
		 * @param object navigation
		 */
		function fillClassVars(extra, navigation){
			table.find("tfoot tr td").attr("colspan", extra.columns.length);
			table.find("tfoot .firstrow").html(extra.beginrow+1);
			table.find("tfoot .lastrow").html(extra.endrow+1);
			table.find("tfoot .totalrows").html(extra.numberrows);
			table.find("tfoot .tablenavigation").html(navigation);
			
			// Add navigation handlers
			table.find('.tablenavigation li').bind('click', function() {
				page(($(this).find("a").html()));										 
			});
			
		}
		
		function showLoadElement(visible){
			if(settings.loadElement != ""){
				if(visible){
					$(settings.loadElement).show();	
				}else{
					$(settings.loadElement).hide();	
				}
			}
		}
		
		// Return the jQuery object to allow for chainability.
		return this;
		
	}
	
})(jQuery);

