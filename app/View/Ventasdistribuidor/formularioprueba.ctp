<script type="text/javascript">

	var bIsFirebugReady = (!!window.console && !!window.console.log);



	jQuery(document).ready(

		function (){

			// update the plug-in version

			jQuery("#idPluginVersion").text(jQuery.Calculation.version);

/*			
			$.Calculation.setDefaults({
				onParseError: function(){
					this.css("backgroundColor", "#cc0000")
				}
				, onParseClear: function (){
					this.css("backgroundColor", "");
				}
			});
*/
			
			// bind the recalc function to the quantity fields
			jQuery("input[id^=qty_item_]").bind("keyup", recalc);
			// run the calculation function now
			recalc();


			// automatically update the "#totalSum" field every time
			// the values are changes via the keyup event

			jQuery("input[name^=sum]").sum("keyup", "#totalSum");
			
			// automatically update the "#totalAvg" field every time
			// the values are changes via the keyup event
			jQuery("input[name^=avg]").avg({
				bind:"keyup"
				, selector: "#totalAvg"
				// if an invalid character is found, change the background color
				, onParseError: function(){
					this.css("backgroundColor", "#cc0000")
				}
				// if the error has been cleared, reset the bgcolor
				, onParseClear: function (){
					this.css("backgroundColor", "");
				}
			});


			// automatically update the "#minNumber" field every time
			// the values are changes via the keyup event
			jQuery("input[name^=min]").min("keyup", "#numberMin");

			// automatically update the "#minNumber" field every time
			// the values are changes via the keyup event
			jQuery("input[name^=max]").max("keyup", {
				selector: "#numberMax"
				, oncalc: function (value, options){
					// you can use this to format the value
					jQuery(options.selector).val(value);
				}
			});

			// this calculates the sum for some text nodes

			jQuery("#idTotalTextSum").click(

				function (){
					// get the sum of the elements

					var sum = jQuery(".textSum").sum();



					// update the total
					jQuery("#totalTextSum").text("$" + sum.toString());

				}

			);



			// this calculates the average for some text nodes

			jQuery("#idTotalTextAvg").click(

				function (){

					// get the average of the elements
					var avg = jQuery(".textAvg").avg();



					// update the total
					jQuery("#totalTextAvg").text(avg.toString());

				}

			);

		}

	);
	
	function recalc(){
		jQuery("[id^=total_item]").calc(
			// the equation to use for the calculation
			"qty * price",
			// define the variables used in the equation, these can be a jQuery object
			{
				qty: jQuery("input[id^=qty_item_]"),
				price: jQuery("[id^=price_item_]")
			},
			// define the formatting callback, the results of the calculation are passed to this function
			function (s){
				// return the number as a dollar amount
				return "$" + s.toFixed(2);
			},
			// define the finish callback, this runs after the calculation has been complete
			function ($this){
				// sum the total of the $("[id^=total_item]") selector
				var sum = $this.sum();
				
				jQuery("#grandTotal").text(
					// round the results to 2 digits
					"$" + sum.toFixed(2)
				);
			}
		);
	}

	</script>
<?php echo $this->Html->script('jquery.calculation'); ?>
<table width="500">

				<col style="width: 50px;" />

				<col />

				<col style="width: 60px;" />

				<col style="width: 110px;" />

				<tr>

					<th>

						Qty

					</th>

					<th align="left">

						Product

					</th>

					<th>

						Price

					</th>

					<th>

						Total

					</th>

				</tr>

				<tr>

					<td align="center">

						<input type="text"  id="qty_item_1" value="1" size="2" />

					</td>

					<td>

						<a href="http://www.packtpub.com/jQuery/book">Learning jQuery</a>

					</td>

					<td align="center" id="price_item_1">

						$39.99

					</td>

					<td align="center" id="total_item_1">

						$39.99

					</td>

				</tr>

				<tr>

					<td align="center">

						<input type="text"  id="qty_item_2" value="1" size="2" />

					</td>

					<td>

						<a href="http://jquery.com/">jQuery Donation</a>

					</td>

					<td align="center" id="price_item_2">

						$14.99

					</td>

					<td align="center" id="total_item_2">

						$14.99

					</td>

				</tr>

				<tr>

					<td colspan="3" align="right">

						<strong>Grand Total:</strong>

					</td>

					<td align="center" id="grandTotal">

					</td>

				</tr>

			</table>

