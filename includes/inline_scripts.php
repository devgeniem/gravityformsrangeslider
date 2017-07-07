<?php
	
/**
 * generate_slider_html function.
 * 
 * @access public
 * @param mixed $field
 * @param string $value (default: '')
 * @return void
 */
function generate_slider_html($field, $value = null){
	
	
	$id       = intval( $field['id'] );
	$formid	  = $field['formId'];
	$field_id =  "input_".$formid."_{$id}" ;
	$size          = $field['size'];
	$class         = $field['type'] . ' ' .$size;
	
	$display = '';
	$min_val = '';
	$max_val = '';
	
	$betweenText 	= $field['betweenText'];
	
	if(is_array($value)) {		
		$field['defaultMin']  	= $value['1'];
		$field['defaultMax'] 	= $value['2'];
	} elseif ($value != null){
		
		$new_values = explode(" $betweenText ", $value);
		
		$field['defaultMin']  	= (isset($new_values[0]))?preg_replace('/\D/', '', $new_values[0]):null;
		$field['defaultMax'] 	= (isset($new_values[1]))?preg_replace('/\D/', '', $new_values[1]):0;
		
		
	}

	$rs_var = 'rangeslider_'.$field['id'];
   	$rs_var_display = $rs_var.'_display';
   	$in_var = 	  'input_'.$formid.'_'.$field['id'];
   	$in_var_min = 'input_'.$formid.'_'.$field['id'].'_1';
   	$in_var_max = 'input_'.$formid.'_'.$field['id'].'_2';
	
	$sliderType 	= $field['sliderType'];
	$rangeMin 		= $field['rangeMin'];
	$rangeMax 		= $field['rangeMax'];
	$defaultMin	 	= (isset($value['1']))?$value['1']:$field['defaultMin'];
	$defaultMax 	= (isset($value['2']))?$value['2']:$field['defaultMax'];
	$rangeslider_step=$field['rangeslider_step'];
	$prefix 		= $field['prefix'];
	$thousand		= $field['thousand'];
	
	$postfix 		= $field['postfix'];
	$decimals 		= $field['decimals'];
	$showTooltip 	= $field['showTooltip'];
	$showTextDisplay= ($field['showTextDisplay'])?'true':'false';
	$required 		= $field['required'];
	

	if($showTooltip == true) {
		$tooltip = ($sliderType == true)?"true":"[true, wNumb({
					decimals: $decimals,
					prefix: '$prefix',
					postfix: '$postfix',
					thousand: '$thousand'
				})]";
	} else {
		$tooltip = 'false';	
	}
	
	$connect = ($sliderType == true)?'[true,false]':'true';
	$start = ($sliderType == true)?$defaultMin:"[$defaultMin, $defaultMax]";
	$inputValue = ($sliderType == true)?"minValue":"'' + minValue + ' $betweenText ' + maxValue;";
	
	$display_val = ($sliderType == true)?$prefix.$defaultMin.$postfix:$prefix.$defaultMin.$postfix.' '.$betweenText.' '. $prefix.$defaultMax.$postfix;
	
	
	$html_input_type = 'hidden';
	$logic_event = $field->get_conditional_logic_event( 'change' );
	
	$html = "<div class='ginput_container'>";
	$html .= "<div id='rangeslider_$id'></div>";
	$html .= "<div id='rangeslider_{$id}_display' class='rangeslider_display'></div>";
	$html .= "<input name='input_{$id}' id='{$field_id}' type='{$html_input_type}' value='$display_val' class='$class' style='display:none' />";
	$html .= "<input name='input_{$id}.1' id='{$field_id}_1' type='{$html_input_type}' value='$defaultMin' class='$class' {$logic_event}/>";
	$html .= "<input name='input_{$id}.2' id='{$field_id}_2' type='{$html_input_type}' value='$defaultMax'  class='$class' {$logic_event}/>";
	$html .= "</div>";
	
	return $html;
}


/**
 * generate_slider_script function.
 * 
 * @access public
 * @param mixed $field
 * @param string $value (default: '')
 * @return void
 */
function generate_slider_script($field, $value = ''){
	
	$id       = intval( $field['id'] );
	$formid	  = $field['formId'];
	$field_id =  "input_".$formid."_{$id}" ;
	$size          = $field['size'];
	$class         = $field['type'] . ' ' .$size;
	
	$rs_var = 'rangeslider_'.$field['id'];
   	$rs_var_display = $rs_var.'_display';
   	$in_var = 	  'input_'.$formid.'_'.$field['id'];
   	$in_var_min = 'input_'.$formid.'_'.$field['id'].'_1';
   	$in_var_max = 'input_'.$formid.'_'.$field['id'].'_2';
	
	if(is_array($value)) {		
		$field['defaultMin']  	= (isset($value['1']))?preg_replace('/\D/', '', $value['1']):0;
		$field['defaultMax'] 	= (isset($value['2']))?preg_replace('/\D/', '', $value['2']):0;
	} elseif ($value != null){
		
		$new_values = explode(" $betweenText ", $value);
		
		$field['defaultMin']  	= (isset($new_values[0]))?preg_replace('/\D/', '', $new_values[0]):0;
		$field['defaultMax'] 	= (isset($new_values[1]))?preg_replace('/\D/', '', $new_values[1]):0;
	} else {
		$field['defaultMin'] = preg_replace('/\D/', '', $field['defaultMin']);
		$field['defaultMax'] = preg_replace('/\D/', '', $field['defaultMax']);
	}
	$sliderType 	= $field['sliderType'];
	$rangeMin 		= $field['rangeMin'];
	$rangeMax 		= $field['rangeMax'];
	$defaultMin	 	= (isset($value['1']))?$value['1']:$field['defaultMin'];
	$defaultMax 	= (isset($value['2']))?$value['2']:$field['defaultMax'];
	$rangeslider_step=$field['rangeslider_step'];
	$prefix 		= $field['prefix'];
	$thousand		= $field['thousand'];
	$betweenText 	= $field['betweenText'];
	$postfix 		= $field['postfix'];
	$decimals 		= $field['decimals'];
	$showTooltip 	= $field['showTooltip'];
	$showTextDisplay= ($field['showTextDisplay'])?'true':'false';
	$required 		= $field['required'];
	

	if($showTooltip == true) {
		$tooltip = ($sliderType == true)?"true":"[true, wNumb({
					decimals: $decimals,
					prefix: '$prefix',
					postfix: ' $postfix',
					thousand: '$thousand'
				})]";
	} else {
		$tooltip = 'false';	
	}
	
	$connect = ($sliderType == true)?'[true,false]':'true';
	$start = ($sliderType == true)?$defaultMin:"[$defaultMin, $defaultMax]";
	$inputValue = ($sliderType == true)?"minValue":"'' + minValue + ' $betweenText ' + maxValue;";
	$value = ($sliderType == true)?$prefix.$rangeMin.$postfix:$prefix.$rangeMin.$postfix.' '.$betweenText.' '. $prefix.$rangeMax.$postfix;
	
	
	$script = "
	function hii_range_slider_init_$field_id(){
		var $rs_var = document.getElementById('$rs_var'),
			in_var_min = document.getElementById('$in_var_min'),
			in_var_max = document.getElementById('$in_var_max'),
			inputNumber = document.getElementById('$in_var'),
			showTextDisplay = $showTextDisplay,
			displayNumber = document.getElementById('$rs_var_display');
			noUiSlider.create($rs_var, {
				start: $start,
				connect: $connect,
				step: $rangeslider_step,
				tooltips: $tooltip,
				range: {
					'min': $rangeMin,
					'max': $rangeMax
				},
				format: wNumb({
					decimals: $decimals,
					prefix: '$prefix',
					postfix: '$postfix',
					thousand: '$thousand'
				})
				
			});
			var minValue = $defaultMin,
				maxValue = $defaultMax;
			$rs_var.noUiSlider.on('update', function( values, handle ) {

				var value = values[handle];
			
				if ( handle ) {
					maxValue = value;
				} else {
					minValue = value;
				}
				inputNumber.value = $inputValue;
				in_var_min.value = minValue;
				in_var_max.value = maxValue;
				fireEvent(in_var_min, 'change');
				if($showTextDisplay == true)displayNumber.innerHTML = $inputValue;
			});
	} 
	hii_range_slider_init_$field_id();";

	if($required == true)
	{
		$script .= "inputNumber.setAttribute('aria-required', 'true');";	
	}
	
	return $script;
}
		?>