<script>

function fill_info_icon() {

	var task_type_array = ['send_email', 'php_custom', 'continue', 'end', 'call_process'];
	var lbl_asol_info_icon_array = [];
	for (var i in task_type_array) {
		lbl_asol_info_icon_array[task_type_array[i]] = SUGAR.language.get('asol_Task', 'LBL_ASOL_INFO_ICON_'+task_type_array[i].toUpperCase());
	}

	$("#info_icon").attr("qtip_info", lbl_asol_info_icon_array[$("#task_type").val()]);

	
	$('#info_icon').qtip({
		content: {
			attr: 'qtip_info'
		},
		style: {
			classes: 'ui-tooltip-rounded ui-tooltip-shadow myTooltip'
		},
		position: {
			my: 'bottom right',
			at: 'top left'
		}
	});
}

function onClick_showRelated_button(button) {
	window.onbeforeunload = function () {
		return;
	};

	var fields_dropdown = document.getElementById('fields');
	if ((fields_dropdown.options[fields_dropdown.selectedIndex].style.color == 'blue')) {
		button.form.action.value = asol_var['_REQUEST']['action'];
		button.form.rhs_key.value = fields_dropdown.value;

		if (button.form.scheduled_tasks_hidden !== undefined)  {
			button.form.scheduled_tasks_hidden.value = format_tasks();
		}
		if (button.form.conditions !== undefined) {
			button.form.conditions.value = format_conditions('conditions_Table');
		}
		button.form.submit();
	} 
}

</script>