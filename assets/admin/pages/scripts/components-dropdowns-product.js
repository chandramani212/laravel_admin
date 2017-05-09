var ComponentsDropdowns = function () {

    var handleSelect2 = function () {

        $('#select2_sample1').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $('#select2_sample2').select2({
            placeholder: "Select a State",
            allowClear: true
        });

        $("#select2_sample3").select2({
            placeholder: "Select...",
            allowClear: true,
            minimumInputLength: 1,
            query: function (query) {
                var data = {
                    results: []
                }, i, j, s;
                for (i = 1; i < 5; i++) {
                    s = "";
                    for (j = 0; j < i; j++) {
                        s = s + query.term;
                    }
                    data.results.push({
                        id: query.term + i,
                        text: s
                    });
                }
                query.callback(data);
            }
        });

        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='" + Metronic.getGlobalImgPath() + "flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }
        $("#select2_sample4").select2({
            placeholder: "Select a Country",
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });

        $("#select2_sample5").select2({
            tags: ["red", "green", "blue", "yellow", "pink"]
        });


        function movieFormatResult(movie) {
            var markup = "<table class='movie-result'><tr>";
            if (movie.posters !== undefined && movie.posters.thumbnail !== undefined) {
                markup += "<td valign='top'><img src='" + movie.posters.thumbnail + "'/></td>";
            }
            markup += "<td valign='top'><h5>" + movie.title + "</h5>";
            if (movie.critics_consensus !== undefined) {
                markup += "<div class='movie-synopsis'>" + movie.critics_consensus + "</div>";
            } else if (movie.synopsis !== undefined) {
                markup += "<div class='movie-synopsis'>" + movie.synopsis + "</div>";
            }
            markup += "</td></tr></table>"
            return markup;
        }

        function movieFormatSelection(movie) {
            return movie.title;
        }

        $("#select2_sample6").select2({
            placeholder: "Search for a movie",
            minimumInputLength: 1,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "http://api.rottentomatoes.com/api/public/v1.0/movies.json",
                dataType: 'jsonp',
                data: function (term, page) {
                    return {
                        q: term, // search term
                        page_limit: 10,
                        apikey: "ju6z9mjyajq2djue3gbvv26t" // please do not use so this example keeps working
                    };
                },
                results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    return {
                        results: data.movies
                    };
                }
            },
            initSelection: function (element, callback) {
                // the input tag has a value attribute preloaded that points to a preselected movie's id
                // this function resolves that id attribute to an object that select2 can render
                // using its formatResult renderer - that way the movie name is shown preselected
                var id = $(element).val();
                if (id !== "") {
                    $.ajax("http://api.rottentomatoes.com/api/public/v1.0/movies/" + id + ".json", {
                        data: {
                            apikey: "ju6z9mjyajq2djue3gbvv26t"
                        },
                        dataType: "jsonp"
                    }).done(function (data) {
                        callback(data);
                    });
                }
            },
            formatResult: movieFormatResult, // omitted for brevity, see the source of this page
            formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) {
                return m;
            } // we do not want to escape markup since we are displaying html in results
        });
    }

    var handleSelect2Modal = function () {

        $('#select2_sample_modal_1').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $('.select2_sample_modal_2').select2({
            placeholder: "Select option",
            allowClear: true
        });

        $("#select2_sample_modal_3").select2({
            allowClear: true,
            minimumInputLength: 1,
            query: function (query) {
                var data = {
                    results: []
                }, i, j, s;
                for (i = 1; i < 5; i++) {
                    s = "";
                    for (j = 0; j < i; j++) {
                        s = s + query.term;
                    }
                    data.results.push({
                        id: query.term + i,
                        text: s
                    });
                }
                query.callback(data);
            }
        });

        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='" + Metronic.getGlobalImgPath() + "flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }
        $("#select2_sample_modal_4").select2({
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });

        $("#select2_sample_modal_5").select2({
            tags: ["red", "green", "blue", "yellow", "pink"]
        });


        function movieFormatResult(record) {
            var markup = "<table class='movie-result'><tr>";
            if (record.posters !== undefined && record.posters.thumbnail !== undefined) {
                markup += "<td valign='top'><img src='" + record.posters.thumbnail + "'/></td>";
            }
            markup += "<td valign='top'><h5>" + record.product_name + "</h5>";
            if (record.critics_consensus !== undefined) {
                markup += "<div class='movie-synopsis'>" + record.critics_consensus + "</div>";
            } else if (record.synopsis !== undefined) {
                markup += "<div class='movie-synopsis'>" + record.synopsis + "</div>";
            }
            markup += "</td></tr></table>"
            return markup;
        }

		
        function movieFormatSelection(record) {
			//console.log(record);
			//console.log(record);
			
            return record.product_name;
			//alert('selection');
			
        }
		
		function changeAttribute(elem,record){
			
			//console.log(record);
			$(elem).parent('td').find('.product_name').val(record.product_name);
			getAttribute(elem, record.id);
			
		}

		function getAttribute(elem,product_id){
			//alert('this is data');
			//$('#product_id').val(product_id);
			var selected_attribute_id = $('#selected_attribute_id').val();
			
			var token,url,customer_id;
			token = $('input[name=_token]').val();
            url = $('#controller_url_path').val();
			url += '/attribute/'+product_id;
			customer_id = $('#customer_select').val();
			address_id = $('#address_id').val();
			if(selected_attribute_id > 0){
				url += '/'+selected_attribute_id;
			}else{
				url += '/0';
			}
			
			if(customer_id > 0){
				url += '/'+customer_id;
			}else{
				url += '/0';
			}
			
			if(address_id > 0){
				url += '/'+address_id;
			}else{
				url += '/0';
			}
			
			data = {product_id: product_id};

			$.ajax({

				headers: {'X-CSRF-TOKEN': token},
				url:url,
				type:'POST',
				data:data,
				beforeSend:function(){
					$('#attribute_loader').html('Loading....');
				},
				success:function(data){
					var response = $.parseJSON(data);
					if(response.error_code == 0){
						var responseView = response.view;
						var prices = response.price;
						var default_attr_name = response.default_attr_name;
						viewData = responseView.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"');
									
						//$('#searched_attribute_id').html(data);
						var idd = $(elem).parent('td').parent('tr').attr('id');
								//console.log(idd);
						$(elem).parent('td').parent('tr').find('.attribute_id').html(viewData);
						$(elem).parent('td').parent('tr').find('.attribute_name').val(default_attr_name);
						
						//setting price default attribute price for default attribute start
						$(elem).parent('td').parent('tr').find('.base_price input').val(prices.price);
						$(elem).parent('td').parent('tr').find('.base_price input.base_price').html(prices.price);
						
						if(prices.specific_price > 0  ){
							if(prices.default_customer_specific_price == 'CUSTOM_PRICE'){
								$(elem).parent('td').parent('tr').find('.merchant_price input').attr('checked',true);
								$(elem).parent('td').parent('tr').find('.merchant_price input').val(prices.specific_price);
					
								$(elem).parent('td').parent('tr').find('.custom_merchant_price').val(prices.specific_price);

							}else{
								$(elem).parent('td').parent('tr').find('.specific_price input').attr('checked',true);
								$(elem).parent('td').parent('tr').find('.specific_price input').val(prices.specific_price);
								$(elem).parent('td').parent('tr').find('.specific_price input.specific_price').val(prices.specific_price);
							}
						}
					
					}else if(response.error_code ==1){
						
						alert('Unable to find Attribtues');
					}else{
						alert('Error in finding atributes contact to your adminsitrator ');
					}
				},
				complete:function(){
					$('#attribute_loader').html('');
					
				},
				failure:function(){
					alert('Unable to find Attributes');
				}
			});
		}
		
		$(".product_id").select2({
            placeholder: "Search Products",
            minimumInputLength: 1,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url:  $('#controller_url_path').val()+'/search',
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term, // search term
                        //page_limit: 10,
                       // apikey: "ju6z9mjyajq2djue3gbvv26t" // please do not use so this example keeps working
                    };
                },
                results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    return {
                        results: data
                    };
                }
            },
            initSelection: function (element, callback) {
                // the input tag has a value attribute preloaded that points to a preselected movie's id
                // this function resolves that id attribute to an object that select2 can render
                // using its formatResult renderer - that way the movie name is shown preselected
                var id = $(element).val();
                if (id !== "") {
                    $.ajax($('#controller_url_path').val()+'/search', {
                        data: {
							initial_selected_id: id
                            //apikey: "ju6z9mjyajq2djue3gbvv26t"
                        },
                        dataType: "json"
                    }).done(function (data) {
                        callback(data);
                    });
                }
            },
            formatResult: movieFormatResult, // omitted for brevity, see the source of this page
            formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) {
                return m;
            } // we do not want to escape markup since we are displaying html in results
        }).on('change', function(){
			
			 changeAttribute(this,$(this).select2('data'));
			//var idd = $(this).parent('td').parent('tr').attr('id');
			//console.log(idd);
    				//console.log($(this).select2('data'));
        });
		
    }

    var handleBootstrapSelect = function() {
        $('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
    }

    var handleMultiSelect = function () {
        $('#my_multi_select1').multiSelect();
        $('#my_multi_select2').multiSelect({
            selectableOptgroup: true
        });
    }

    return {
        //main function to initiate the module
        init: function () {            
            handleSelect2();
            handleSelect2Modal();
            handleMultiSelect();
            handleBootstrapSelect();
        }
    };

}();