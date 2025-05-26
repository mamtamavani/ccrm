var url;

if (PM_absoluteUrlForAjaxRequests) {
	console.log('Ajax requests: absolute urls');
	url = site_url + "/index.php?entryPoint=" + entryPoint;
} else {
	console.log('Ajax requests: relative urls');
	// url = parent.document.location.pathname + "?entryPoint=" + entryPoint;
	url = "index.php?entryPoint=" + entryPoint;
}

function initializeGantt() {

	$(function() {

		console.log(parent.SUGAR.language.get('app_list_strings', 'moduleList'));

		splitDropdown();

		// load templates
		$("#ganttemplates").loadTemplates();

		// here starts gantt initialization
		ge = new GanttMaster();
		var workSpace = $("#workSpace");
		workSpace.css({
			width : $(window).width() - 10,
			height : $(window).height() - 50
		});
		ge.init(workSpace);

		// inject some buttons (for this demo only)
		// $(".ganttButtonBar div").append("");
		// $(".ganttButtonBar div").addClass('buttons');

		// overwrite with localized ones
		loadI18n();

		loadGanttFromServer('read_mode');
		$('#button_actions').html(lang('GANTT_LBL_EXPORT'));
		$('#button_actions').attr('onclick', "exportGantt();");

		// fill default Teamwork roles if any
		if (!ge.roles || ge.roles.length == 0) {
			setRoles();
		}

		// fill default Resources roles if any
		if (!ge.resources || ge.resources.length == 0) {
			setResource();
		}

		/*/debug time scale
		 $(".splitBox2").mousemove(function(e){
		 var x=e.clientX-$(this).offset().left;
		 var mill=Math.round(x/(ge.gantt.fx) + ge.gantt.startMillis)
		 $("#ndo").html(x+" "+new Date(mill))
		 });*/

		setImportGanttOnServer();

		setDialogForCreateBaseline();

		$(window).resize(function() {
			workSpace.css({
				width : $(window).width() - 10,
				height : $(window).height() - 50
			});
			workSpace.trigger("resize.gantt");
		});

	});
}

function loadGanttFromServer(mode) {
	asolConsoleLog('loadGanttFromServer');

	blockUI_type('load');

	var connectionError = false;

	try {
		var selectedRow = 0;
		if (ge.currentTask) {
			selectedRow = (ge.currentTask.getRow()) ? ge.currentTask.getRow() : 0;
		}

		$.ajax({
			url : url,
			type : "POST",
			async : false,
			cache : false,
			dataType : "json",
			data : {
				action : "load",
				mode : mode,
				asolProjectId : asolProjectId,
				asolProjectVersionId : asolProjectVersionId,
				selectedRow : selectedRow
			},
			beforeSend : function() {
			},
			success : function(response) {

				asolConsoleLog(response);
				if (response.ok) {

					setAsolProjectInfo(response.jsonGanttProject.projectInfo.asolProjectName, response.jsonGanttProject.projectInfo.asolProjectVersionNumber, response.jsonGanttProject.projectInfo.asolProjectVersionName);

					if (!response.jsonGanttProject.canWrite) {
						inactivateAutosave();
						$('#button_save').hide();
						$('#button_autosave').hide();
						$('#button_clearGantt').hide();
						$('#button_importGantt').hide();
					} else {
						$('#button_save').show();
						$('#button_autosave').show();
						$('#button_clearGantt').show();
						$('#button_importGantt').show();
					}

					if (response.jsonGanttProject.projectInfo.asolProjectVersionType == 'working_version') {
						if (isEnterpriseEdition) {
							$('#button_createBaseline').show();
						}
						$('#button_publish').show();
						$('#button_exportGantt').show();
					}

					if (response.jsonGanttProject.projectInfo.asolProjectVersionType == 'baseline') {
						$('#button_publish').show();
						$('#button_editAsWorkingVersion').show();
						$('#button_exportGantt').show();
					}

					if (response.jsonGanttProject.projectInfo.asolProjectVersionType == 'last_published_version') {
						$('#button_editAsWorkingVersion').show();
						$('#button_exportGantt').show();
					}

					ge.loadProject(response.jsonGanttProject);
					ge.checkpoint(); // empty the undo stack

				} else {
					alert('loadGanttFromServer: success -> response.ok==false');
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server

				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				console.error("loadGanttFromServer: error -> " + errorMessage);

				throw new ConnectionError();
			},
			complete : function(response) {
			}
		});

	} catch (exception) {
		if (exception instanceof ConnectionError) {
			connectionError = true;
			alert(exception);
		} else {
			throw exception;
		}
	} finally {
		$.unblockUI();
		return connectionError;
	}

}

var newAsolProjectVersionName = null;
var newAsolProjectVersionDescription = null;

function saveGanttOnServer(action, mode) {
	asolConsoleLog('saveGanttOnServer');

	asolConsoleLog('action=[' + action + ']');

	blockUI_type(action);

	if (!ge.canEditMode)
		return;

	var connectionError = false;

	var ganttProject = ge.saveProject();

	try {

		$.ajax({
			url : url,
			async : false,
			cache : false,
			dataType : "json",
			type : "POST",
			data : {
				action : action,
				mode : mode,
				asolProjectId : asolProjectId,
				asolProjectVersionId : asolProjectVersionId,
				newAsolProjectVersionName : newAsolProjectVersionName,
				newAsolProjectVersionDescription : newAsolProjectVersionDescription,
				jsonGanttProject : JSON.stringify(ganttProject)
			},
			beforeSend : function() {
			},
			success : function(response) {

				if (response.ok) {
					if (response.jsonGanttProject) {

						setAsolProjectInfo(response.jsonGanttProject.projectInfo.asolProjectName, response.jsonGanttProject.projectInfo.asolProjectVersionNumber, response.jsonGanttProject.projectInfo.asolProjectVersionName);

						if (!response.jsonGanttProject.canWrite) {
							inactivateAutosave();
							$('#button_save').hide();
							$('#button_autosave').hide();
							$('#button_clearGantt').hide();
							$('#button_importGantt').hide();
						} else {
							$('#button_save').show();
							$('#button_autosave').show();
							$('#button_clearGantt').show();
							$('#button_importGantt').show();
						}

						$('#button_exportGantt').show();
						if (isEnterpriseEdition) {
							$('#button_createBaseline').show();
						}
						$('#button_publish').show();

						ge.loadProject(response.jsonGanttProject);
						ge.checkpoint(); // empty the undo stack

					} else {
						ge.reset();
						alert('saveGanttOnServer: success -> response.jsonGanttProject==false');
					}
				} else {
					alert('saveGanttOnServer: success -> response.ok==false');
				}
			},
			error : function(xhr, errorType, exception) { // Triggered if an error communicating with server

				var errorMessage = exception || xhr.statusText; // If exception null, then default to xhr.statusText
				console.error("saveGanttOnServer: error -> " + errorMessage);

				throw new ConnectionError();
			},
			complete : function(response) {
			}
		});

	} catch (exception) {
		if (exception instanceof ConnectionError) {
			connectionError = true;
			alert(exception);
		} else {
			throw exception;
		}
	} finally {
		$.unblockUI();
		return connectionError;
	}
}

function clearGantt() {
	ge.reset();
	saveGanttOnServer('clear', 'edit_mode');
}

function exportGantt() {

	if ((ge.__undoStack.length > 0) || (ge.__redoStack.length > 0)) { // Gantt has changes
		alert(lang('GANTT_LBL_GANTT_HAS_CHANGES_FIRST_YOU_MUST_PERFORM_A_SAVE'));
		return false;
	}

	$.exportGantt({
		url : url,
		asolProjectId : asolProjectId,
		asolProjectVersionId : asolProjectVersionId,
		jsonGanttProject : ge.saveProject()
	});

	/*
	$('#exportIframe').contents().find("#gimmeBack_jsonGanttProject").val(JSON.stringify(ge.saveProject()));
	$('#exportIframe').contents().find("#gimmeBack_asolProjectId").val(asolProjectId);
	$('#exportIframe').contents().find("#gimmeBack_asolProjectVersionId").val(asolProjectVersionId);
	$('#exportIframe').contents().find("#gimmeBack").submit();
	$('#exportIframe').contents().find("#gimmeBack_jsonGanttProject").val("");
	*/

	/*  var uriContent = "data:text/html;charset=utf-8," + encodeURIComponent(JSON.stringify(prj));
	 neww=window.open(uriContent,"dl");*/
}

function loadI18n() {

	GanttMaster.messages = {
		"CANNOT_WRITE" : lang("GANTT_LBL_CANNOT_WRITE"),
		"CHANGE_OUT_OF_SCOPE" : lang("GANTT_LBL_NO_RIGHTS_FOR_UPDATE_PARENTS_OUT_OF_EDITOR_SCOPE"),
		"START_IS_MILESTONE" : lang("GANTT_LBL_START_IS_MILESTONE"),
		"END_IS_MILESTONE" : lang("GANTT_LBL_END_IS_MILESTONE"),
		"TASK_HAS_CONSTRAINTS" : lang("GANTT_LBL_TASK_HAS_CONSTRAINTS"),
		"GANTT_ERROR_DEPENDS_ON_OPEN_TASK" : lang("GANTT_LBL_GANTT_ERROR_DEPENDS_ON_OPEN_TASK"),
		"GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK" : lang("GANTT_LBL_GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK"),
		"TASK_HAS_EXTERNAL_DEPS" : lang("GANTT_LBL_TASK_HAS_EXTERNAL_DEPS"),
		"GANTT_ERROR_LOADING_DATA_TASK_REMOVED" : lang("GANTT_LBL_GANTT_ERROR_LOADING_DATA_TASK_REMOVED"),
		"ERROR_SETTING_DATES" : lang("GANTT_LBL_ERROR_SETTING_DATES"),
		"CIRCULAR_REFERENCE" : lang("GANTT_LBL_CIRCULAR_REFERENCE"),
		"CANNOT_DEPENDS_ON_ANCESTORS" : lang("GANTT_LBL_CANNOT_DEPENDS_ON_ANCESTORS"),
		"CANNOT_DEPENDS_ON_DESCENDANTS" : lang("GANTT_LBL_CANNOT_DEPENDS_ON_DESCENDANTS"),
		"INVALID_DATE_FORMAT" : lang("GANTT_LBL_INVALID_DATE_FORMAT"),
		"TASK_MOVE_INCONSISTENT_LEVEL" : lang("GANTT_LBL_TASK_MOVE_INCONSISTENT_LEVEL"),
		"CANNOT_CLOSE_TASK_IF_OPEN_ISSUE" : lang("GANTT_LBL_CANNOT_CLOSE_TASK_IF_OPEN_ISSUE"),
		"GANTT_QUARTER_SHORT" : lang("GANTT_LBL_GANTT_QUARTER_SHORT"),
		"GANTT_SEMESTER_SHORT" : lang("GANTT_LBL_GANTT_SEMESTER_SHORT")
	};
}

function lang(lbl) {

	return parent.SUGAR.language.get('asol_Project', lbl);
}

function statusLang(status) {

	return parent.SUGAR.language.get('app_list_strings', 'asol_projecttask_status_list')[status];
}
