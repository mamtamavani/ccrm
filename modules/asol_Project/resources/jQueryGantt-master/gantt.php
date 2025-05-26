<?php
require_once("modules/asol_Project/asolProjectUtils.php");

$pathGantt = "modules/asol_Project/resources/jQueryGantt-master/";
?>

<!DOCTYPE HTML>
<html>
	
<head>
	
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Gantt</title>
	
	<script>
		// Mandatory for not-crm access
		var PM_absoluteUrlForAjaxRequests = (typeof parent.PM_absoluteUrlForAjaxRequests === 'undefined') ? false : parent.PM_absoluteUrlForAjaxRequests;
		var site_url = parent.site_url;
		var asolProjectId = parent.asolProjectId;
		var asolProjectVersionId = parent.asolProjectVersionId;
		// Not-mandatory for not-crm access
		var entryPoint = (typeof parent.entryPoint === 'undefined') ? 'ganttServer' : parent.entryPoint;
		var intervalMinutesAutosave = (typeof parent.intervalMinutesAutosave === 'undefined') ? 5 : parent.intervalMinutesAutosave;
		var intervalMinutesKeepAliveEditMode = (typeof parent.intervalMinutesKeepAliveEditMode === 'undefined') ? 1 : parent.intervalMinutesKeepAliveEditMode;
		var Date_defaultFormat = (typeof parent.Date_defaultFormat === 'undefined') ? 'dd/MM/yyyy' : parent.Date_defaultFormat;
		var Date_firstDayOfWeek = (typeof parent.Date_firstDayOfWeek === 'undefined') ? 1 : parent.Date_firstDayOfWeek;
		// Not-mandatory
		var adjustParentToChildrenDuration = (typeof parent.adjustParentToChildrenDuration === 'undefined') ? false : parent.adjustParentToChildrenDuration;
		var isEnterpriseEdition = (typeof parent.isEnterpriseEdition === 'undefined') ? false : parent.isEnterpriseEdition;
		var PM_holidays = (typeof parent.PM_holidays === 'undefined') ? undefined : parent.PM_holidays;
		// Not-needed
		var currentUserId = null;
		var Number_decimalSeparator = (typeof parent.Number_decimalSeparator === 'undefined') ? '.' : parent.Number_decimalSeparator;
		var Number_groupingSeparator = (typeof parent.Number_groupingSeparator === 'undefined') ? ',' : parent.Number_groupingSeparator;

	</script>

	<link href="<?php echo $pathGantt; ?>libs/jquery.ui/css/jquery-ui.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel=stylesheet type="text/css">

	<link href="<?php echo $pathGantt; ?>platform.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel=stylesheet type="text/css">
	<link href="<?php echo $pathGantt; ?>libs/dateField/jquery.dateField.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel="stylesheet"type="text/css">

	<link href="<?php echo $pathGantt; ?>gantt.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel=stylesheet type="text/css">
	<link href="<?php echo $pathGantt; ?>print.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel=stylesheet type="text/css" media="print">

	<script src="<?php echo $pathGantt; ?>libs/jquery.min.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/jquery.ui/js/jquery-ui.min.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>

	<script src="<?php echo $pathGantt; ?>libs/jquery.livequery.min.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/jquery.timers.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/platform.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/date.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/i18nJs.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/dateField/jquery.dateField.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/JST/jquery.JST.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	
	<link href="<?php echo $pathGantt; ?>libs/jquery.svg.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel="stylesheet" type="text/css" >
	<script src="<?php echo $pathGantt; ?>libs/jquery.svg.min.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/jquery.svgdom.1.8.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>

	<script src="<?php echo $pathGantt; ?>libs/jquery.blockUI.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>libs/upclick.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>jquery.exportGantt.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>

	<script src="<?php echo $pathGantt; ?>ganttUtilities.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>ganttTask.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>ganttDrawerSVG.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>ganttGridEditor.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>ganttMaster.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>

	<script src="<?php echo $pathGantt; ?>gantt.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<script src="<?php echo $pathGantt; ?>alineasol.js?version=<?php asolProjectUtils::echoVersion(); ?>"></script>
	<link href="<?php echo $pathGantt; ?>alineasol.css?version=<?php asolProjectUtils::echoVersion(); ?>" rel=stylesheet type="text/css">
	
</head>

<body style="background-color: #fff;">

<div id="workSpace" style="padding:0px; overflow-y:auto; overflow-x:hidden;border:1px solid #e5e5e5;position:relative;margin:0 5px;clear:both"></div>

<style>
  .resEdit {
    padding: 15px;
  }

  .resLine {
    width: 95%;
    padding: 3px;
    margin: 5px;
    border: 1px solid #d0d0d0;
  }

  body {
    overflow: hidden;
  }
  
  /*
  .ganttButtonBar h1{
    color: #000000;
    font-weight: bold;
    font-size: 28px;
    margin-left: 10px;
    margin-top: 15px;

  }
  */
  
</style>

<iframe id="exportIframe" style="display:none" width="1" height="1" frameborder="0">
</iframe>


<div id="dialog-form" title="Create new ProjVersion">
	<form>
		<fieldset>
			<table>
				<tr>
					<td>
						<label id="labelName" for="name">Name</label>
					</td>
					<td>
						<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" style="width: 100%">
					</td>
				</tr>
				<tr>
					<td>
						<label id="labelDescription" for="description">Description</label>
					</td>
					<td>
						<textarea name="description" id="description" class="text ui-widget-content ui-corner-all" cols="40"></textarea>
					</td>
				</tr>
			</table>
		</fieldset>
	</form>
</div>

<script >

//**  initializeGantt **//
var ge;
var uploader;

initializeGantt();
//**  initializeGantt **//

//-------------------------------------------  Create some demo data ------------------------------------------------------
function setRoles() {
    ge.roles = [{
        id : "tmp_1",
        name : "Project Manager"
    }, {
        id : "tmp_2",
        name : "Worker"
    }, {
        id : "tmp_3",
        name : "Stakeholder/Customer"
    }];
}

function setResource() {
    var res = [];
    for (var i = 1; i <= 10; i++) {
        res.push({
            id : "tmp_" + i,
            name : "Resource " + i
        });
    }
    ge.resources = res;
}



//-------------------------------------------  Open a black popup for managing resources. This is only an axample of implementation (usually resources come from server) ------------------------------------------------------
function openResourceEditor() {
    var editor = $("<div>");
    editor.append("<h2>Resource editor</h2>");
    editor.addClass("resEdit");

    for (var i in ge.resources) {
        var res = ge.resources[i];
        var inp = $("<input type='text'>").attr("pos", i).addClass("resLine").val(res.name);
        editor.append(inp).append("<br>");
    }

    var sv = $("<div>save</div>").css("float", "right").addClass("button").click(function() {
        $(this).closest(".resEdit").find("input").each(function() {
            var el = $(this);
            var pos = el.attr("pos");
            ge.resources[pos].name = el.val();
        });
        ge.editor.redraw();
        closeBlackPopup();
    });
    editor.append(sv);

    var ndo = createBlackPage(800, 500).append(editor);
}

//-------------------------------------------  LOCAL STORAGE MANAGEMENT (for this demo only) ------------------------------------------------------
Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
};

Storage.prototype.getObject = function(key) {
    return this.getItem(key) && JSON.parse(this.getItem(key));
};

function loadFromLocalStorage() {
    var ret;
    if (localStorage) {
        if (localStorage.getObject("teamworkGantDemo")) {
            ret = localStorage.getObject("teamworkGantDemo");
        }
    } else {
        $("#taZone").show();
    }
    if (!ret || !ret.tasks || ret.tasks.length == 0) {
        ret = JSON.parse($("#ta").val());

        //actualiza data
        var offset = new Date().getTime() - ret.tasks[0].start;
        for (var i = 0; i < ret.tasks.length; i++)
            ret.tasks[i].start = ret.tasks[i].start + offset;

    }
    ge.loadProject(ret);
    ge.checkpoint();
    //empty the undo stack
}

function saveInLocalStorage() {
    var prj = ge.saveProject();
    if (localStorage) {
        localStorage.setObject("teamworkGantDemo", prj);
    } else {
        $("#ta").val(JSON.stringify(prj));
    }
}

</script>

<div id="gantEditorTemplates" style="display:none;">
  <div class="__template__" type="GANTBUTTONS"><!--
  
<div class="projectInfo">
	<h1 id="projectName" class="projectName">Project name</h1>
	<h2 id="projectVersion" class="projectVersion">Version name</h2>
</div>

<div class="ganttButtonBar noprint">
	
	<span class="mode">
		<img id="edit_mode" title="(#=lang('GANTT_LBL_SWITCH_TO_READ_MODE')#)" src="<?php echo $pathGantt; ?>edit_mode.png" onclick='inactivateEditMode();' class="edit_mode" /> 
		<img id="read_mode" title="(#=lang('GANTT_LBL_SWITCH_TO_EDIT_MODE')#)" src="<?php echo $pathGantt; ?>read_mode.png" onclick='activateEditMode();' class="read_mode" /> 
	</span>
	
	<span class="buttons_left">
		<button onclick="$('#workSpace').trigger('undo.gantt');" class="button textual" title="(#=lang('GANTT_LBL_UNDO')#)">
			<span id="undo" class="teamworkIcon">&#39;</span>
		</button>
		<button onclick="$('#workSpace').trigger('redo.gantt');" class="button textual" title="(#=lang('GANTT_LBL_REDO')#)">
			<span id="redo" class="teamworkIcon">&middot;</span>
		</button>
		<span class="ganttButtonSeparator"></span>
		<button onclick="$('#workSpace').trigger('addAboveCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_INSERT_ABOVE')#)">
			<span id="addAboveCurrentTask" class="teamworkIcon">l</span>
		</button>
		<button onclick="$('#workSpace').trigger('addBelowCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_INSERT_BELOW')#)">
			<span id="addBelowCurrentTask" class="teamworkIcon">X</span>
		</button>
		<span class="ganttButtonSeparator"></span>
		<button onclick="$('#workSpace').trigger('indentCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_INDENT_TASK')#)">
			<span id="indentCurrentTask" class="teamworkIcon">.</span>
		</button>
		<button onclick="$('#workSpace').trigger('outdentCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_UNINDENT_TASK')#)">
			<span id="outdentCurrentTask" class="teamworkIcon">:</span>
		</button>
		<span class="ganttButtonSeparator"></span>
		<button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_MOVE_UP')#)">
			<span id="moveUpCurrentTask" class="teamworkIcon">k</span>
		</button>
		<button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_MOVE_DOWN')#)">
			<span id="moveDownCurrentTask" class="teamworkIcon">j</span>
		</button>
		<span class="ganttButtonSeparator"></span>
		<button onclick="$('#workSpace').trigger('zoomMinus.gantt');" class="button textual" title="(#=lang('GANTT_LBL_ZOOM_OUT')#)">
			<span id="zoomMinus" class="teamworkIcon">)</span>
		</button>
		<button onclick="$('#workSpace').trigger('zoomPlus.gantt');" class="button textual" title="(#=lang('GANTT_LBL_ZOOM_IN')#)">
			<span id="zoomPlus" class="teamworkIcon">(</span>
		</button>
		<span class="ganttButtonSeparator"></span>
		<button onclick="$('#workSpace').trigger('deleteCurrentTask.gantt');" class="button textual" title="(#=lang('GANTT_LBL_DELETE')#)">
			<span id="deleteCurrentTask" class="teamworkIcon">&cent;</span>
		</button>
		<span class="ganttButtonSeparator"></span>
    	<button onclick="print();" class="button textual" title="(#=lang('GANTT_LBL_PRINT')#)">
    		<span class="teamworkIcon">p</span>
    	</button>
    	<span class="ganttButtonSeparator"></span>
    	<button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();" class="button textual" title="(#=lang('GANTT_LBL_CRITICAL_PATH')#)">
    		<span class="teamworkIcon">&pound;</span>
    	</button>

	</span>


	<span id="max_min" class="noprint">
	 	<img title="(#=lang('GANTT_LBL_MAXIMIZE')#)" id="maximize" src='<?php echo $pathGantt; ?>maximize.png' onclick="resizeFramesetFull();"/>
	  	<img title="(#=lang('GANTT_LBL_MINIMIZE')#)" id="minimize" src='<?php echo $pathGantt; ?>minimize.png' onclick="resetFrameset();"/>
	</span>

	<div id="buttons_right">
		
		<div id="buttons_actions">
			<div>
			 	<span id="button_actions" style="visibility: hidden">Actions</span>
				<span id="select_action" style="visibility: hidden">Select Action</span>
			</div>
			<ul>
				<li id="button_createBaseline" ><a href="#" onclick="createBaseline();" >(#=lang('GANTT_LBL_CREATE_BASELINE')#)</a></li>
				<li id="button_publish" ><a href="#" onclick="publish();" >(#=lang('GANTT_LBL_PUBLISH')#)</a></li>
				<li id="button_editAsWorkingVersion" ><a href="#" onclick="editAsWorkingVersion();" >(#=lang('GANTT_LBL_EDIT_AS_W_V')#)</a></li>
				<li id="button_exportGantt" ><a href="#" onclick="exportGantt();" >(#=lang('GANTT_LBL_EXPORT')#)</a></li>
				
				<input type="button" id="uploader" value="Upload" style="display:none;">
				<li id="button_importGantt" ><a href="#" onclick='importGantt();' >(#=lang('GANTT_LBL_IMPORT')#)</a></li>
				<li id="button_clearGantt" ><a href="#" onclick="if (confirm('(#=lang('GANTT_LBL_CLEAR_GANTT')#)')) {clearGantt();} else {return false;}" >(#=lang('GANTT_LBL_CLEAR')#)</a></li>
				<li id="button_save" ><a href="#" onclick="saveGanttOnServer('save', 'edit_mode');" >(#=lang('GANTT_LBL_SAVE')#)</a></li>
			</ul>
		</div>
		
		<span id="button_autosave">
			<img id="autosave_active" title="(#=lang('GANTT_LBL_INACTIVATE_AUTOSAVE')#)" src="<?php echo $pathGantt; ?>autosave_active.png" onclick='inactivateAutosave();' class="autosave autosave_active" /> 
			<img id="autosave_inactive" title="(#=lang('GANTT_LBL_ACTIVATE_AUTOSAVE')#)" src="<?php echo $pathGantt; ?>autosave_inactive.png" onclick='activateAutosave();' class="autosave autosave_inactive" /> 
		</span>
		
	</div>
	
</div>

  --></div>

  <div class="__template__" type="TASKSEDITHEAD"><!--
  <table class="gdfTable" cellspacing="0" cellpadding="0">
    <thead>
    <tr style="height:40px">
      <th class="gdfColHeader" style="width:50px;"></th>
      <th class="gdfColHeader" style="width:25px;"></th>
      <th class="gdfColHeader gdfResizable code" style="width:30px;">code/short name</th>
      <th class="gdfColHeader gdfResizable" style="width:300px;">(#=lang('GANTT_LBL_NAME')#)</th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">(#=lang('GANTT_LBL_START')#)</th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">(#=lang('GANTT_LBL_END')#)</th>
      <th class="gdfColHeader gdfResizable" style="width:50px;">(#=lang('GANTT_LBL_DURATION_DAYS')#)</th>
      <th class="gdfColHeader gdfResizable" style="width:50px;">(#=lang('GANTT_LBL_DEPENDENCIES')#)</th>
      <th class="gdfColHeader gdfResizable" style="width:200px;">(#=lang('GANTT_LBL_ASSIGNEES')#)</th>
    </tr>
    </thead>
  </table>
  --></div>

  <div class="__template__" type="TASKROW"><!--
  <tr taskId="(#=obj.id#)" class="taskEditRow" level="(#=level#)">
    <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span> <span class="teamworkIcon" style="font-size:12px;" >e</span></th>
    <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>
    <td class="gdfCell code"><input type="text" name="code" value="(#=obj.code?obj.code:''#)"></td>
    <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10#)px;">
      <div class="(#=obj.isParent()?'exp-controller expcoll exp':'exp-controller'#)" align="center"></div>
      <input type="text" name="name" value="(#=obj.name#)">
    </td>

    <td class="gdfCell"><input type="text" name="start"  value="" class="date"></td>
    <td class="gdfCell"><input type="text" name="end" value="" class="date"></td>
    <td class="gdfCell"><input type="text" name="duration" value="(#=obj.duration#)"></td>
    <td class="gdfCell"><input type="text" name="depends" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>
    <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
  </tr>

  --></div>


  <div class="__template__" type="TASKEMPTYROW"><!--
  <tr class="taskEditRow emptyRow" >
    <th class="gdfCell" align="right"></th>
    <td class="gdfCell noClip" align="center"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
  </tr>
  --></div>

  <div class="__template__" type="TASKBAR"><!--
  	
<div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" title="Parent=[(#= (obj.getRow()!=0) ? (obj.getParent().getRow()+1) + ',' + obj.getParent().name : 'No parent' #)]">
	<div class="layout (#=obj.hasExternalDep?'extDep':''#)" >
		<div class="taskStatus" status="(#=obj.status#)"></div>
		<div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
		<div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>
		<div class="taskLabel"></div>
		<div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
	</div>
</div>
  
  --></div>


  <div class="__template__" type="CHANGE_STATUS"><!--
    <div class="taskStatusBox">
      <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="(#=statusLang('STATUS_ACTIVE')#)"></div>
      <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="(#=statusLang('STATUS_DONE')#)"></div>
      <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="(#=statusLang('STATUS_FAILED')#)"></div>
      <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="(#=statusLang('STATUS_SUSPENDED')#)"></div>
      <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="(#=statusLang('STATUS_UNDEFINED')#)"></div>
    </div>
  --></div>


  <div class="__template__" type="TASK_EDITOR"><!--

<div class="ganttTaskEditor">
	<table width="100%">
		<tr>
			<td>
				<table cellpadding="5">
					<tr>
						<td class="code"><label for="code">code/short name</label><br><input type="text" name="code" id="code" value="" class="formElements"></td>
					</tr>
					<tr>
						<td><label for="name">(#=lang('GANTT_LBL_NAME')#)</label><br><input type="text" name="name" id="name" value=""  size="35" class="formElements"></td>
					</tr>
					<tr></tr>
					<td>
						<label for="description">(#=lang('GANTT_LBL_DESCRIPTION')#)</label><br>
						<textarea rows="5" cols="30" id="description" name="description" class="formElements"></textarea>
					</td>
					</tr>
				</table>
			</td>
			<td valign="top">
				<table cellpadding="5">
					<tr>
						<td colspan="2">
							<label for="status">(#=lang('GANTT_LBL_STATUS')#)</label><br>
							<div id="status" class="taskStatus" status=""></div>
						</td>
					<tr>
						<td colspan="2">
							<label for="progress">(#=lang('GANTT_LBL_PROGRESS')#)</label>
							<br>
							<input type="text" name="progress" id="progress" value="" size="3" class="formElements">
						</td>
					</tr>
					<tr>
						<td>
							<table>
								<tr>
									<td>
										<label for="start">(#=lang('GANTT_LBL_START')#)</label>
										<br>
										<input type="text" name="start" id="start" value="" class="date"  size="10" class="formElements">
									</td>
									<td>
										<img src="modules/asol_Project/resources/jQueryGantt-master/res/milestone.png" style="padding: 1px;" title="(#=lang('GANTT_LBL_MILESTONE')#)">
										<br>
										<input type="checkbox" id="startIsMilestone">
									</td>
								</tr>
							</table>
						</td>
						<td rowspan="2" class="graph" style="padding-left:50px">
							<label for="duration">(#=lang('GANTT_LBL_DURATION_DAYS')#)</label>
							<br>
							<input type="text" name="duration" id="duration" value=""  size="5" class="formElements">
						</td>
					</tr>
					<tr>
						<td>
							<table>
								<tr>
									<td>
										<label for="end">(#=lang('GANTT_LBL_END')#)</label>
										<br>
										<input type="text" name="end" id="end" value="" class="date"  size="10" class="formElements">
									</td>
									<td>
										<img src="modules/asol_Project/resources/jQueryGantt-master/res/milestone.png" style="padding: 1px;" title="(#=lang('GANTT_LBL_MILESTONE')#)">
										<br>
										<input type="checkbox" id="endIsMilestone">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<h2>(#=lang('GANTT_LBL_ASSIGNMENTS')#)</h2>
	<table  cellspacing="1" cellpadding="0" width="100%" id="assigsTable">
		<tr>
			<th style="width:100px;">(#=lang('GANTT_LBL_NAME')#)</th>
			<th style="width:70px;">(#=lang('GANTT_LBL_ROLE')#)</th>
			<th style="width:30px;">(#=lang('GANTT_ESTIMATED_WORK_EFFORT_HOURS')#)</th>
			<th style="width:30px;" id="addAssig"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
		</tr>
	</table>
	<div style="text-align: right; padding-top: 20px"><button id="saveButton" class="button big">(#=lang('GANTT_LBL_SAVE')#)</button></div>
</div>

  --></div>


  <div class="__template__" type="ASSIGNMENT_ROW"><!--
  <tr taskId="(#=obj.task.id#)" assigId="(#=obj.assig.id#)" class="assigEditRow" >
    <td ><select name="resourceId"  class="formElements" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
    <td ><select type="select" name="roleId"  class="formElements"></select></td>
    <td ><input type="text" name="effort" value="(#=getMillisInHoursMinutes(obj.assig.effort)#)" size="5" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delAssig" style="cursor: pointer">d</span></td>
  </tr>
  --></div>

</div>

<script >
    $.JST.loadDecorator("ASSIGNMENT_ROW", function(assigTr, taskAssig) {

        var resEl = assigTr.find("[name=resourceId]");
        for (var i in taskAssig.task.master.resources) {
            var res = taskAssig.task.master.resources[i];
            var opt = $("<option>");
            opt.val(res.id).html(res.name);
            if (taskAssig.assig.resourceId == res.id)
                opt.attr("selected", "true");
            resEl.append(opt);
        }

        var roleEl = assigTr.find("[name=roleId]");
        for (var i in taskAssig.task.master.roles) {
            var role = taskAssig.task.master.roles[i];
            var optr = $("<option>");
            optr.val(role.id).html(role.name);
            if (taskAssig.assig.roleId == role.id)
                optr.attr("selected", "true");
            roleEl.append(optr);
        }

        if(taskAssig.task.master.canWrite && taskAssig.task.canWrite){
	      assigTr.find(".delAssig").click(function() {
	        var tr = $(this).closest("[assigId]").fadeOut(200, function() {
	          $(this).remove();
	        });
	      });
	    }


    });
</script>

</body>
</html>