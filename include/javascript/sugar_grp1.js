/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
if(typeof(SUGAR)=="undefined"){SUGAR={namespace:function(ns){SUGAR[ns]=SUGAR[ns]||{};return((typeof SUGAR[ns]==="object")&&(SUGAR[ns]!==null))?SUGAR[ns]:false;},append:function(target,obj){for(var prop in obj){if(obj[prop]!==void 0)target[prop]=obj[prop];}
return target;}};}
SUGAR.namespace("themes");SUGAR.namespace("sugarHome");SUGAR.namespace("subpanelUtils");SUGAR.namespace("ajaxStatusClass");SUGAR.namespace("tabChooser");SUGAR.namespace("utils");SUGAR.namespace("savedViews");SUGAR.namespace("dashlets");SUGAR.namespace("unifiedSearchAdvanced");SUGAR.namespace("searchForm");SUGAR.namespace("language");SUGAR.namespace("Studio");SUGAR.namespace("contextMenu");SUGAR.namespace("config");var nameIndex=0;var typeIndex=1;var requiredIndex=2;var msgIndex=3;var jstypeIndex=5;var minIndex=10;var maxIndex=11;var altMsgIndex=15;var compareToIndex=7;var arrIndex=12;var operatorIndex=13;var allowblank=8;var validate=new Array();var maxHours=24;var requiredTxt='Missing Required Field:'
var invalidTxt='Invalid Value:'
var secondsSinceLoad=0;var inputsWithErrors=new Array();var tabsWithErrors=new Array();var lastSubmitTime=0;var alertList=new Array();var oldStartsWith='';function isSupportedIE(){var userAgent=navigator.userAgent.toLowerCase();if(userAgent.indexOf("msie")!=-1&&userAgent.indexOf("mac")==-1&&userAgent.indexOf("opera")==-1){var version=navigator.appVersion.match(/MSIE (.\..)/)[1];if(version>=5.5&&version<10){return true;}else{return false;}}}
SUGAR.isIE=isSupportedIE();var isSafari=(navigator.userAgent.toLowerCase().indexOf('safari')!=-1);RegExp.escape=function(text){if(!arguments.callee.sRE){var specials=['/','.','*','+','?','|','(',')','[',']','{','}','\\'];arguments.callee.sRE=new RegExp('(\\'+specials.join('|\\')+')','g');}
return text.replace(arguments.callee.sRE,'\\$1');}
function addAlert(type,name,subtitle,description,time,redirect){var addIndex=alertList.length;alertList[addIndex]=new Array();alertList[addIndex]['name']=name;alertList[addIndex]['type']=type;alertList[addIndex]['subtitle']=subtitle;alertList[addIndex]['description']=description.replace(/<br>/gi,"\n").replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');alertList[addIndex]['time']=time;alertList[addIndex]['done']=0;alertList[addIndex]['redirect']=redirect;}
function checkAlerts(){secondsSinceLoad+=1;var mj=0;var alertmsg='';for(mj=0;mj<alertList.length;mj++){if(alertList[mj]['done']==0){if(alertList[mj]['time']<secondsSinceLoad&&alertList[mj]['time']>-1){alertmsg=alertList[mj]['type']+":"+alertList[mj]['name']+"\n"+alertList[mj]['subtitle']+"\n"+alertList[mj]['description']+"\n\n";alertList[mj]['done']=1;if(alertList[mj]['redirect']==''){alert(alertmsg);}
else if(confirm(alertmsg)){window.location=alertList[mj]['redirect'];}}}}
setTimeout("checkAlerts()",1000);}
function toggleDisplay(id){if(this.document.getElementById(id).style.display=='none'){this.document.getElementById(id).style.display='';if(this.document.getElementById(id+"link")!=undefined){this.document.getElementById(id+"link").style.display='none';}
if(this.document.getElementById(id+"_anchor")!=undefined)
this.document.getElementById(id+"_anchor").innerHTML='[ - ]';}
else{this.document.getElementById(id).style.display='none'
if(this.document.getElementById(id+"link")!=undefined){this.document.getElementById(id+"link").style.display='';}
if(this.document.getElementById(id+"_anchor")!=undefined)
this.document.getElementById(id+"_anchor").innerHTML='[+]';}}
function checkAll(form,field,value){for(i=0;i<form.elements.length;i++){if(form.elements[i].name==field)
form.elements[i].checked=value;}}
function replaceAll(text,src,rep){offset=text.toLowerCase().indexOf(src.toLowerCase());while(offset!=-1){text=text.substring(0,offset)+rep+text.substring(offset+src.length,text.length);offset=text.indexOf(src,offset+rep.length+1);}
return text;}
function addForm(formname){validate[formname]=new Array();}
function addToValidate(formname,name,type,required,msg){if(typeof validate[formname]=='undefined'){addForm(formname);}
validate[formname][validate[formname].length]=new Array(name,type,required,msg);}
function addToValidateRange(formname,name,type,required,msg,min,max){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='range'
validate[formname][validate[formname].length-1][minIndex]=min;validate[formname][validate[formname].length-1][maxIndex]=max;}
function addToValidateIsValidDate(formname,name,type,required,msg){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='date'}
function addToValidateIsValidTime(formname,name,type,required,msg){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='time'}
function addToValidateDateBefore(formname,name,type,required,msg,compareTo){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='isbefore'
validate[formname][validate[formname].length-1][compareToIndex]=compareTo;}
function addToValidateDateBeforeAllowBlank(formname,name,type,required,msg,compareTo,allowBlank){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='isbefore'
validate[formname][validate[formname].length-1][compareToIndex]=compareTo;validate[formname][validate[formname].length-1][allowblank]=allowBlank;}
function addToValidateBinaryDependency(formname,name,type,required,msg,compareTo){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='binarydep';validate[formname][validate[formname].length-1][compareToIndex]=compareTo;}
function addToValidateComparison(formname,name,type,required,msg,compareTo){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='comparison';validate[formname][validate[formname].length-1][compareToIndex]=compareTo;}
function addToValidateIsInArray(formname,name,type,required,msg,arr,operator){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='in_array';validate[formname][validate[formname].length-1][arrIndex]=arr;validate[formname][validate[formname].length-1][operatorIndex]=operator;}
function addToValidateVerified(formname,name,type,required,msg,arr,operator){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='verified';}
function addToValidateLessThan(formname,name,type,required,msg,max,max_field_msg){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='less';validate[formname][validate[formname].length-1][maxIndex]=max;validate[formname][validate[formname].length-1][altMsgIndex]=max_field_msg;}
function addToValidateMoreThan(formname,name,type,required,msg,min){addToValidate(formname,name,type,required,msg);validate[formname][validate[formname].length-1][jstypeIndex]='more';validate[formname][validate[formname].length-1][minIndex]=min;}
function removeFromValidate(formname,name){for(i=0;i<validate[formname].length;i++)
{if(validate[formname][i][nameIndex]==name)
{validate[formname].splice(i--,1);}}}
function checkValidate(formname,name){if(validate[formname]){for(i=0;i<validate[formname].length;i++){if(validate[formname][i][nameIndex]==name){return true;}}}
return false;}
var formsWithFieldLogic=null;var formWithPrecision=null;function addToValidateFieldLogic(formId,minFieldId,maxFieldId,defaultFieldId,lenFieldId,type,msg){this.formId=document.getElementById(formId);this.min=document.getElementById(minFieldId);this.max=document.getElementById(maxFieldId);this._default=document.getElementById(defaultFieldId);this.len=document.getElementById(lenFieldId);this.msg=msg;this.type=type;}
function addToValidatePrecision(formId,valueId,precisionId){this.form=document.getElementById(formId);this.float=document.getElementById(valueId);this.precision=document.getElementById(precisionId);}
function isValidPrecision(value,precision){value=trim(value.toString());if(precision=='')
return true;if(value=='')
return true;if((precision=="0")){if(value.indexOf(dec_sep)==-1){return true;}else{return false;}}
if(value.charAt(value.length-precision-1)==num_grp_sep){if(value.substr(value.indexOf(dec_sep),1)==dec_sep){return false;}
returntrue;}
var actualPrecision=value.substr(value.indexOf(dec_sep)+1,value.length).length;return actualPrecision==precision;}
function toDecimal(original,precision){precision=(precision==null)?2:precision;num=Math.pow(10,precision);temp=Math.round(original*num)/num;if((temp*100)%100==0)
return temp+'.00';if((temp*10)%10==0)
return temp+'0';return temp}
function isInteger(s){if(typeof num_grp_sep!='undefined'&&typeof dec_sep!='undefined')
{s=unformatNumberNoParse(s,num_grp_sep,dec_sep).toString();}
return /^[+-]?[0-9]*$/.test(s);}
function isDecimal(s){if(typeof s=="string"&&s=="")
return true;if(typeof num_grp_sep!='undefined'&&typeof dec_sep!='undefined')
{s=unformatNumberNoParse(s,num_grp_sep,dec_sep).toString();}
return/^[+-]?[0-9]+\.?[0-9]*$/.test(s);}
function isNumeric(s){return isDecimal(s);}
var date_reg_positions={'Y':1,'m':2,'d':3};var date_reg_format='([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})'
function isDate(dtStr){if(dtStr.length==0){return true;}
myregexp=new RegExp(date_reg_format)
if(!myregexp.test(dtStr))
return false
m='';d='';y='';var dateParts=dtStr.match(date_reg_format);for(key in date_reg_positions){index=date_reg_positions[key];if(key=='m'){m=dateParts[index];}else if(key=='d'){d=dateParts[index];}else{y=dateParts[index];}}
var dd=new Date(y,m,0);if(y<1)
return false;if(m>12||m<1)
return false;if(d<1||d>dd.getDate())
return false;return true;}
function getDateObject(dtStr){if(dtStr.length==0){return true;}
myregexp=new RegExp(date_reg_format)
if(myregexp.exec(dtStr))var dt=myregexp.exec(dtStr)
else return false;var yr=dt[date_reg_positions['Y']];var mh=dt[date_reg_positions['m']];var dy=dt[date_reg_positions['d']];var dtar=dtStr.split(' ');if(typeof(dtar[1])!='undefined'&&isTime(dtar[1])){var t1=dtar[1].replace(/am/i,' AM');var t1=t1.replace(/pm/i,' PM');t1=t1.replace(/\./,':');date1=new Date(Date.parse(mh+'/'+dy+'/'+yr+' '+t1));}
else
{var date1=new Date();date1.setFullYear(yr);date1.setMonth(mh-1);date1.setDate(dy);}
return date1;}
function isBefore(value1,value2){var d1=getDateObject(value1);var d2=getDateObject(value2);if(typeof(d2)=='boolean'){return true;}
return d2>=d1;}
function isValidEmail(emailStr){if(emailStr.length==0){return true;}
var lastChar=emailStr.charAt(emailStr.length-1);if(!lastChar.match(/[^\.]/i)){return false;}
var firstLocalChar=emailStr.charAt(0);if(firstLocalChar.match(/\./)){return false;}
var pos=emailStr.lastIndexOf("@");var localPart=emailStr.substr(0,pos);var lastLocalChar=localPart.charAt(localPart.length-1);if(lastLocalChar.match(/\./)){return false;}
var reg=/@.*?;/g;var results;while((results=reg.exec(emailStr))!=null){var original=results[0];parsedResult=results[0].replace(';','::;::');emailStr=emailStr.replace(original,parsedResult);}
reg=/.@.*?,/g;while((results=reg.exec(emailStr))!=null){var original=results[0];if(original.indexOf("::;::")==-1){var parsedResult=results[0].replace(',','::;::');emailStr=emailStr.replace(original,parsedResult);}}
var emailArr=emailStr.split(/::;::/);for(var i=0;i<emailArr.length;i++){var emailAddress=emailArr[i];if(trim(emailAddress)!=''){if(!/^\s*[\w.%+\-&'#!\$\*=\?\^_`\{\}~\/]+@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[\w-]{2,}\s*$/i.test(emailAddress)&&!/^.*<[A-Z0-9._%+\-&'#!\$\*=\?\^_`\{\}~]+?@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[\w-]{2,}>\s*$/i.test(emailAddress)){return false;}}}
return true;}
function isValidPhone(phoneStr){if(phoneStr.length==0){return true;}
if(!/^[0-9\-\(\)\s]+$/.test(phoneStr))
return false
return true}
function isFloat(floatStr){if(floatStr.length==0){return true;}
if(!(typeof(num_grp_sep)=='undefined'||typeof(dec_sep)=='undefined')){floatStr=unformatNumberNoParse(floatStr,num_grp_sep,dec_sep).toString();}
return /^(-)?[0-9\.]+$/.test(floatStr);}
function isDBName(str){if(str.length==0){return true;}
if(!/^[a-zA-Z][a-zA-Z\_0-9]*$/.test(str))
return false
return true}
var time_reg_format="[0-9]{1,2}\:[0-9]{2}";function isTime(timeStr){var time_reg_format="[0-9]{1,2}\:[0-9]{2}";time_reg_format=time_reg_format.replace('([ap]m)','');time_reg_format=time_reg_format.replace('([AP]M)','');if(timeStr.length==0){return true;}
myregexp=new RegExp(time_reg_format)
if(!myregexp.test(timeStr))
return false
return true;}
function inRange(value,min,max){if(typeof num_grp_sep!='undefined'&&typeof dec_sep!='undefined')
value=unformatNumberNoParse(value,num_grp_sep,dec_sep).toString();return value>=min&&value<=max;}
function bothExist(item1,item2){if(typeof item1=='undefined'){return false;}
if(typeof item2=='undefined'){return false;}
if((item1==''&&item2!='')||(item1!=''&&item2=='')){return false;}
return true;}
trim=YAHOO.lang.trim;function check_form(formname){if(typeof(siw)!='undefined'&&siw&&typeof(siw.selectingSomething)!='undefined'&&siw.selectingSomething)
return false;return validate_form(formname,'');}
function add_error_style(formname,input,txt,flash){var raiseFlag=false;if(typeof flash=="undefined")
flash=true;try{inputHandle=typeof input=="object"?input:document.forms[formname][input];style=get_current_bgcolor(inputHandle);if(txt.substring(txt.length-1)==':')
txt=txt.substring(0,txt.length-1)
requiredTxt=SUGAR.language.get('app_strings','ERR_MISSING_REQUIRED_FIELDS');invalidTxt=SUGAR.language.get('app_strings','ERR_INVALID_VALUE');nomatchTxt=SUGAR.language.get('app_strings','ERR_SQS_NO_MATCH_FIELD');matchTxt=txt.replace(requiredTxt,'').replace(invalidTxt,'').replace(nomatchTxt,'');YUI().use('node',function(Y){Y.one(inputHandle).get('parentNode').get('children').each(function(node,index,nodeList){if(node.hasClass('validation-message')&&node.get('text').search(matchTxt)){raiseFlag=true;}});});if(!raiseFlag){errorTextNode=document.createElement('div');errorTextNode.className='required validation-message';errorTextNode.innerHTML=txt;if(inputHandle.parentNode.className.indexOf('x-form-field-wrap')!=-1){inputHandle.parentNode.parentNode.appendChild(errorTextNode);}
else{inputHandle.parentNode.appendChild(errorTextNode);}
if(flash)
inputHandle.style.backgroundColor="#FF0000";inputsWithErrors.push(inputHandle);}
if(flash)
{if(inputsWithErrors.length==1){for(wp=1;wp<=10;wp++){window.setTimeout('fade_error_style(style, '+wp*10+')',1000+(wp*50));}}
if(typeof(window[formname+"_tabs"])!="undefined"){var tabView=window[formname+"_tabs"];var parentDiv=YAHOO.util.Dom.getAncestorByTagName(inputHandle,"div");if(tabView.get){var tabs=tabView.get("tabs");for(var i in tabs){if(tabs[i].get("contentEl")==parentDiv||YAHOO.util.Dom.isAncestor(tabs[i].get("contentEl"),inputHandle))
{tabs[i].get("labelEl").style.color="red";if(inputsWithErrors.length==1)
tabView.selectTab(i);}}}}
window.setTimeout("inputsWithErrors["+(inputsWithErrors.length-1)+"].style.backgroundColor = '';",2000);}}catch(e){}}
function clear_all_errors(){for(var wp=0;wp<inputsWithErrors.length;wp++){if(typeof(inputsWithErrors[wp])!='undefined'&&typeof inputsWithErrors[wp].parentNode!='undefined'&&inputsWithErrors[wp].parentNode!=null){if(inputsWithErrors[wp].parentNode.className.indexOf('x-form-field-wrap')!=-1)
{inputsWithErrors[wp].parentNode.parentNode.removeChild(inputsWithErrors[wp].parentNode.parentNode.lastChild);}
else
{inputsWithErrors[wp].parentNode.removeChild(inputsWithErrors[wp].parentNode.lastChild);}}}
if(inputsWithErrors.length==0)return;if(YAHOO.util.Dom.getAncestorByTagName(inputsWithErrors[0],"form")){var formname=YAHOO.util.Dom.getAncestorByTagName(inputsWithErrors[0],"form").getAttribute("name");if(typeof(window[formname+"_tabs"])!="undefined"){var tabView=window[formname+"_tabs"];if(tabView.get){var tabs=tabView.get("tabs");for(var i in tabs){if(typeof tabs[i]=="object")
tabs[i].get("labelEl").style.color="";}}}
inputsWithErrors=new Array();}}
function get_current_bgcolor(input){if(input.currentStyle){style=input.currentStyle.backgroundColor;return style.substring(1,7);}
else{style='';styleRGB=document.defaultView.getComputedStyle(input,'').getPropertyValue("background-color");comma=styleRGB.indexOf(',');style+=dec2hex(styleRGB.substring(4,comma));commaPrevious=comma;comma=styleRGB.indexOf(',',commaPrevious+1);style+=dec2hex(styleRGB.substring(commaPrevious+2,comma));style+=dec2hex(styleRGB.substring(comma+2,styleRGB.lastIndexOf(')')));return style;}}
function hex2dec(hex){return(parseInt(hex,16));}
var hexDigit=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");function dec2hex(dec){return(hexDigit[dec>>4]+hexDigit[dec&15]);}
function fade_error_style(normalStyle,percent){errorStyle='c60c30';var r1=hex2dec(errorStyle.slice(0,2));var g1=hex2dec(errorStyle.slice(2,4));var b1=hex2dec(errorStyle.slice(4,6));var r2=hex2dec(normalStyle.slice(0,2));var g2=hex2dec(normalStyle.slice(2,4));var b2=hex2dec(normalStyle.slice(4,6));var pc=percent / 100;r=Math.floor(r1+(pc*(r2-r1))+.5);g=Math.floor(g1+(pc*(g2-g1))+.5);b=Math.floor(b1+(pc*(b2-b1))+.5);for(var wp=0;wp<inputsWithErrors.length;wp++){inputsWithErrors[wp].style.backgroundColor="#"+dec2hex(r)+dec2hex(g)+dec2hex(b);}}
function isFieldTypeExceptFromEmptyCheck(fieldType)
{var results=false;var exemptList=['bool','file'];for(var i=0;i<exemptList.length;i++)
{if(fieldType==exemptList[i])
return true;}
return results;}
function validate_form(formname,startsWith){requiredTxt=SUGAR.language.get('app_strings','ERR_MISSING_REQUIRED_FIELDS');invalidTxt=SUGAR.language.get('app_strings','ERR_INVALID_VALUE');if(typeof(formname)=='undefined')
{return false;}
if(typeof(validate[formname])=='undefined')
{disableOnUnloadEditView(document.forms[formname]);return true;}
var form=document.forms[formname];var isError=false;var errorMsg="";var _date=new Date();if(_date.getTime()<(lastSubmitTime+2000)&&startsWith==oldStartsWith){return false;}
lastSubmitTime=_date.getTime();oldStartsWith=startsWith;clear_all_errors();inputsWithErrors=new Array();for(var i=0;i<validate[formname].length;i++){if(validate[formname][i][nameIndex].indexOf(startsWith)==0){if(typeof form[validate[formname][i][nameIndex]]!='undefined'&&typeof form[validate[formname][i][nameIndex]].value!='undefined'){var bail=false;if(!validate[formname][i][requiredIndex]&&trim(form[validate[formname][i][nameIndex]].value)==''&&(typeof(validate[formname][i][jstypeIndex])!='undefined'&&validate[formname][i][jstypeIndex]!='binarydep'))
{continue;}
if(validate[formname][i][requiredIndex]&&!isFieldTypeExceptFromEmptyCheck(validate[formname][i][typeIndex])){if(typeof form[validate[formname][i][nameIndex]]=='undefined'||trim(form[validate[formname][i][nameIndex]].value)==""){add_error_style(formname,validate[formname][i][nameIndex],requiredTxt+' '+validate[formname][i][msgIndex]);isError=true;}}
if(!bail){switch(validate[formname][i][typeIndex]){case'email':if(!isValidEmail(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}
break;case'time':if(!isTime(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}break;case'date':if(!isDate(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}break;case'alpha':break;case'DBName':if(!isDBName(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}
break;case'alphanumeric':break;case'file':var file_input=form[validate[formname][i][nameIndex]+'_file'];if(file_input&&validate[formname][i][requiredIndex]&&trim(file_input.value)==""&&!file_input.disabled){isError=true;add_error_style(formname,validate[formname][i][nameIndex],requiredTxt+" "+validate[formname][i][msgIndex]);}
break;case'int':if(!isInteger(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}
break;case'decimal':if(!isDecimal(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}
break;case'currency':case'float':if(!isFloat(trim(form[validate[formname][i][nameIndex]].value))){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}
break;case'teamset_mass':var div_element_id=formname+'_'+form[validate[formname][i][nameIndex]].name+'_operation_div';var input_elements=YAHOO.util.Selector.query('input',document.getElementById(div_element_id));var primary_field_id='';var validation_passed=false;var replace_selected=false;for(t in input_elements){if(input_elements[t].type&&input_elements[t].type=='radio'&&input_elements[t].checked==true&&input_elements[t].value=='replace'){var radio_elements=YAHOO.util.Selector.query('input[type=radio]',document.getElementById(formname+'_team_name_table'));for(var x=0;x<radio_elements.length;x++){if(radio_elements[x].name!='team_name_type'){primary_field_id='team_name_collection_'+radio_elements[x].value;if(radio_elements[x].checked){replace_selected=true;if(trim(document.forms[formname].elements[primary_field_id].value)!=''){validation_passed=true;break;}}else if(trim(document.forms[formname].elements[primary_field_id].value)!=''){replace_selected=true;}}}}}
if(replace_selected&&!validation_passed){add_error_style(formname,primary_field_id,SUGAR.language.get('app_strings','ERR_NO_PRIMARY_TEAM_SPECIFIED'));isError=true;}
break;case'teamset':var table_element_id=formname+'_'+form[validate[formname][i][nameIndex]].name+'_table';if(document.getElementById(table_element_id)){var input_elements=YAHOO.util.Selector.query('input[type=radio]',document.getElementById(table_element_id));var has_primary=false;var primary_field_id=form[validate[formname][i][nameIndex]].name+'_collection_0';for(t in input_elements){primary_field_id=form[validate[formname][i][nameIndex]].name+'_collection_'+input_elements[t].value;if(input_elements[t].type&&input_elements[t].type=='radio'&&input_elements[t].checked==true){if(document.forms[formname].elements[primary_field_id].value!=''){has_primary=true;}
break;}}
if(!has_primary){isError=true;var field_id=form[validate[formname][i][nameIndex]].name+'_collection_'+input_elements[0].value;add_error_style(formname,field_id,SUGAR.language.get('app_strings','ERR_NO_PRIMARY_TEAM_SPECIFIED'));}}
break;case'error':isError=true;add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]);break;}
if(typeof validate[formname][i][jstypeIndex]!='undefined'){switch(validate[formname][i][jstypeIndex]){case'range':if(!inRange(trim(form[validate[formname][i][nameIndex]].value),validate[formname][i][minIndex],validate[formname][i][maxIndex])){isError=true;var lbl_validate_range=SUGAR.language.get('app_strings','LBL_VALIDATE_RANGE');add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]+" value "+form[validate[formname][i][nameIndex]].value+" "+lbl_validate_range+" ("+validate[formname][i][minIndex]+" - "+validate[formname][i][maxIndex]+") ");}
break;case'isbefore':compareTo=form[validate[formname][i][compareToIndex]];if(typeof compareTo!='undefined'){if(trim(compareTo.value)!=''||(validate[formname][i][allowblank]!='true')){date2=trim(compareTo.value);date1=trim(form[validate[formname][i][nameIndex]].value);if(trim(date1).length!=0&&!isBefore(date1,date2)){isError=true;add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]+"("+date1+") "+SUGAR.language.get('app_strings','MSG_IS_NOT_BEFORE')+' '+date2);}}}
break;case'less':value=unformatNumber(trim(form[validate[formname][i][nameIndex]].value),num_grp_sep,dec_sep);maximum=parseFloat(validate[formname][i][maxIndex]);if(typeof maximum!='undefined'){if(value>maximum){isError=true;add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]+" "+SUGAR.language.get('app_strings','MSG_IS_MORE_THAN')+' '+validate[formname][i][altMsgIndex]);}}
break;case'more':value=unformatNumber(trim(form[validate[formname][i][nameIndex]].value),num_grp_sep,dec_sep);minimum=parseFloat(validate[formname][i][minIndex]);if(typeof minimum!='undefined'){if(value<minimum){isError=true;add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]+" "+SUGAR.language.get('app_strings','MSG_SHOULD_BE')+' '+minimum+' '+SUGAR.language.get('app_strings','MSG_OR_GREATER'));}}
break;case'binarydep':compareTo=form[validate[formname][i][compareToIndex]];if(typeof compareTo!='undefined'){item1=trim(form[validate[formname][i][nameIndex]].value);item2=trim(compareTo.value);if(!bothExist(item1,item2)){isError=true;add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]);}}
break;case'comparison':compareTo=form[validate[formname][i][compareToIndex]];if(typeof compareTo!='undefined'){item1=trim(form[validate[formname][i][nameIndex]].value);item2=trim(compareTo.value);if(!bothExist(item1,item2)||item1!=item2){isError=true;add_error_style(formname,validate[formname][i][nameIndex],validate[formname][i][msgIndex]);}}
break;case'in_array':arr=eval(validate[formname][i][arrIndex]);operator=validate[formname][i][operatorIndex];item1=trim(form[validate[formname][i][nameIndex]].value);if(operator.charAt(0)=='u'){item1=item1.toUpperCase();operator=operator.substring(1);}else if(operator.charAt(0)=='l'){item1=item1.toLowerCase();operator=operator.substring(1);}
for(j=0;j<arr.length;j++){val=arr[j];if((operator=="=="&&val==item1)||(operator=="!="&&val!=item1)){isError=true;add_error_style(formname,validate[formname][i][nameIndex],invalidTxt+" "+validate[formname][i][msgIndex]);}}
break;case'verified':if(trim(form[validate[formname][i][nameIndex]].value)=='false'){isError=true;}
break;}}}}}}
if(formsWithFieldLogic){var invalidLogic=false;if(formsWithFieldLogic.min&&formsWithFieldLogic.max&&formsWithFieldLogic._default){var showErrorsOn={min:{value:'min',show:false,obj:formsWithFieldLogic.min.value},max:{value:'max',show:false,obj:formsWithFieldLogic.max.value},_default:{value:'default',show:false,obj:formsWithFieldLogic._default.value},len:{value:'len',show:false,obj:parseInt(formsWithFieldLogic.len.value,10)}};var min=(formsWithFieldLogic.min.value!='')?parseFloat(formsWithFieldLogic.min.value):'undef';var max=(formsWithFieldLogic.max.value!='')?parseFloat(formsWithFieldLogic.max.value):'undef';var _default=(formsWithFieldLogic._default.value!='')?parseFloat(formsWithFieldLogic._default.value):'undef';for(var i in showErrorsOn){if(showErrorsOn[i].value!='len'&&showErrorsOn[i].obj.length>showErrorsOn.len.obj){invalidLogic=true;showErrorsOn[i].show=true;showErrorsOn.len.show=true;}}
if(min!='undef'&&max!='undef'&&_default!='undef'){if(!inRange(_default,min,max)){invalidLogic=true;showErrorsOn.min.show=true;showErrorsOn.max.show=true;showErrorsOn._default.show=true;}}
if(min!='undef'&&max!='undef'&&min>max){invalidLogic=true;showErrorsOn.min.show=true;showErrorsOn.max.show=true;}
if(min!='undef'&&_default!='undef'&&_default<min){invalidLogic=true;showErrorsOn.min.show=true;showErrorsOn._default.show=true;}
if(max!='undef'&&_default!='undef'&&_default>max){invalidLogic=true;showErrorsOn.max.show=true;showErrorsOn._default.show=true;}
if(invalidLogic){isError=true;for(var error in showErrorsOn)
if(showErrorsOn[error].show)
add_error_style(formname,showErrorsOn[error].value,formsWithFieldLogic.msg);}
else if(!isError)
formsWithFieldLogic=null;}}
if(formWithPrecision){if(!isValidPrecision(formWithPrecision.float.value,formWithPrecision.precision.value)){isError=true;add_error_style(formname,'default',SUGAR.language.get('app_strings','ERR_COMPATIBLE_PRECISION_VALUE'));}else if(!isError){isError=false;}}
if(isError==true){var nw,ne,sw,se;if(self.pageYOffset)
{nwX=self.pageXOffset;seX=self.innerWidth;nwY=self.pageYOffset;seY=self.innerHeight;}
else if(document.documentElement&&document.documentElement.scrollTop)
{nwX=document.documentElement.scrollLeft;seX=document.documentElement.clientWidth;nwY=document.documentElement.scrollTop;seY=document.documentElement.clientHeight;}
else if(document.body)
{nwX=document.body.scrollLeft;seX=document.body.clientWidth;nwY=document.body.scrollTop;seY=document.body.clientHeight;}
var inView=true;for(var wp=0;wp<inputsWithErrors.length;wp++){var elementCoor=findElementPos(inputsWithErrors[wp]);if(!(elementCoor.x>=nwX&&elementCoor.y>=nwY&&elementCoor.x<=seX&&elementCoor.y<=seY)){inView=false;scrollToTop=elementCoor.y-75;scrollToLeft=elementCoor.x-75;}
else{break;}}
if(!inView)window.scrollTo(scrollToLeft,scrollToTop);return false;}
disableOnUnloadEditView(form);return true;}
var marked_row=new Array;function setPointer(theRow,theRowNum,theAction,theDefaultColor,thePointerColor,theMarkColor){var theCells=null;if((thePointerColor==''&&theMarkColor=='')||typeof(theRow.style)=='undefined'){return false;}
if(typeof(document.getElementsByTagName)!='undefined'){theCells=theRow.getElementsByTagName('td');}
else if(typeof(theRow.cells)!='undefined'){theCells=theRow.cells;}
else{return false;}
var rowCellsCnt=theCells.length;var domDetect=null;var currentColor=null;var newColor=null;if(typeof(window.opera)=='undefined'&&typeof(theCells[0].getAttribute)!='undefined'){currentColor=theCells[0].getAttribute('bgcolor');domDetect=true;}
else{currentColor=theCells[0].style.backgroundColor;domDetect=false;}
if(currentColor==''||(currentColor!=null&&(currentColor.toLowerCase()==theDefaultColor.toLowerCase()))){if(theAction=='over'&&thePointerColor!=''){newColor=thePointerColor;}
else if(theAction=='click'&&theMarkColor!=''){newColor=theMarkColor;marked_row[theRowNum]=true;}}
else if(currentColor!=null&&(currentColor.toLowerCase()==thePointerColor.toLowerCase())&&(typeof(marked_row[theRowNum])=='undefined'||!marked_row[theRowNum])){if(theAction=='out'){newColor=theDefaultColor;}
else if(theAction=='click'&&theMarkColor!=''){newColor=theMarkColor;marked_row[theRowNum]=true;}}
else if(currentColor!=null&&(currentColor.toLowerCase()==theMarkColor.toLowerCase())){if(theAction=='click'){newColor=(thePointerColor!='')?thePointerColor:theDefaultColor;marked_row[theRowNum]=(typeof(marked_row[theRowNum])=='undefined'||!marked_row[theRowNum])?true:null;}}
if(newColor){var c=null;if(domDetect){for(c=0;c<rowCellsCnt;c++){theCells[c].setAttribute('bgcolor',newColor,0);}}
else{for(c=0;c<rowCellsCnt;c++){theCells[c].style.backgroundColor=newColor;}}}
return true;}
function goToUrl(selObj,goToLocation){eval("document.location.href = '"+goToLocation+"pos="+selObj.options[selObj.selectedIndex].value+"'");}
var json_objects=new Object();function getXMLHTTPinstance(){var xmlhttp=false;var userAgent=navigator.userAgent.toLowerCase();if(userAgent.indexOf("msie")!=-1&&userAgent.indexOf("mac")==-1&&userAgent.indexOf("opera")==-1){var version=navigator.appVersion.match(/MSIE (.\..)/)[1];if(version>=5.5){try{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}
catch(e){try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
catch(E){xmlhttp=false;}}}}
if(!xmlhttp&&typeof XMLHttpRequest!='undefined'){xmlhttp=new XMLHttpRequest();}
return xmlhttp;}
var global_xmlhttp=getXMLHTTPinstance();function http_fetch_sync(url,post_data){global_xmlhttp=getXMLHTTPinstance();var method='GET';if(typeof(post_data)!='undefined')method='POST';try{global_xmlhttp.open(method,url,false);}
catch(e){alert('message:'+e.message+":url:"+url);}
if(method=='POST'){global_xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}
global_xmlhttp.send(post_data);if(SUGAR.util.isLoginPage(global_xmlhttp.responseText))
return false;var args={"responseText":global_xmlhttp.responseText,"responseXML":global_xmlhttp.responseXML,"request_id":typeof(request_id)!="undefined"?request_id:0};return args;}
function http_fetch_async(url,callback,request_id,post_data){var method='GET';if(typeof(post_data)!='undefined'){method='POST';}
try{global_xmlhttp.open(method,url,true);}
catch(e){alert('message:'+e.message+":url:"+url);}
if(method=='POST'){global_xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}
global_xmlhttp.onreadystatechange=function(){if(global_xmlhttp.readyState==4){if(global_xmlhttp.status==200){if(SUGAR.util.isLoginPage(global_xmlhttp.responseText))
return false;var args={"responseText":global_xmlhttp.responseText,"responseXML":global_xmlhttp.responseXML,"request_id":request_id};callback.call(document,args);}
else{alert("There was a problem retrieving the XML data:\n"+global_xmlhttp.statusText);}}}
global_xmlhttp.send(post_data);}
function insert_at_cursor(field,value){if(document.selection){field.focus();sel=document.selection.createRange();sel.text=value;}
else if(field.selectionStart||field.selectionStart=='0'){var start_pos=field.selectionStart;var end_pos=field.selectionEnd;field.value=field.value.substring(0,start_pos)+value+field.value.substring(end_pos,field.value.length);}
else{field.value+=value;}}
function checkParentType(type,button){if(button==null){return;}
if(typeof disabledModules!='undefined'&&typeof(disabledModules[type])!='undefined'){button.disabled='disabled';}
else{button.disabled=false;}}
function parseDate(input,format){date=input.value;format=format.replace(/%/g,'');sep=format.charAt(1);yAt=format.indexOf('Y')
if(date.match(/^\d{1,2}[\/-]\d{1,2}[\/-]\d{2,4}$/)&&yAt==4){if(date.match(/^\d{1}[\/-].*$/))date='0'+date;if(date.match(/^\d{2}[\/-]\d{1}[\/-].*$/))date=date.substring(0,3)+'0'+date.substring(3,date.length);if(date.match(/^\d{2}[\/-]\d{2}[\/-]\d{2}$/))date=date.substring(0,6)+'20'+date.substring(6,date.length);}
else if(date.match(/^\d{2,4}[\/-]\d{1,2}[\/-]\d{1,2}$/)){if(date.match(/^\d{2}[\/-].*$/))date='20'+date;if(date.match(/^\d{4}[\/-]\d{1}[\/-].*$/))date=date.substring(0,5)+'0'+date.substring(5,date.length);if(date.match(/^\d{4}[\/-]\d{2}[\/-]\d{1}$/))date=date.substring(0,8)+'0'+date.substring(8,date.length);}
else if(date.match(/^\d{4,8}$/)){digits=0;if(date.match(/^\d{8}$/))digits=8;else if(date.match(/\d{6}/))digits=6;else if(date.match(/\d{4}/))digits=4;else if(date.match(/\d{5}/))digits=5;switch(yAt){case 0:switch(digits){case 4:date='20'+date.substring(0,2)+sep+'0'+date.substring(2,3)+sep+'0'+date.substring(3,4);break;case 5:date='20'+date.substring(0,2)+sep+date.substring(2,4)+sep+'0'+date.substring(4,5);break;case 6:date='20'+date.substring(0,2)+sep+date.substring(2,4)+sep+date.substring(4,6);break;case 8:date=date.substring(0,4)+sep+date.substring(4,6)+sep+date.substring(6,8);break;}
break;case 2:switch(digits){case 4:date='0'+date.substring(0,1)+sep+'20'+date.substring(1,3)+sep+'0'+date.substring(3,4);break;case 5:date=date.substring(0,2)+sep+'20'+date.substring(2,4)+sep+'0'+date.substring(4,5);break;case 6:date=date.substring(0,2)+sep+'20'+date.substring(2,4)+sep+date.substring(4,6);break;case 8:date=date.substring(0,2)+sep+date.substring(2,6)+sep+date.substring(6,8);break;}
case 4:switch(digits){case 4:date='0'+date.substring(0,1)+sep+'0'+date.substring(1,2)+sep+'20'+date.substring(2,4);break;case 5:date='0'+date.substring(0,1)+sep+date.substring(1,3)+sep+'20'+date.substring(3,5);break;case 6:date=date.substring(0,2)+sep+date.substring(2,4)+sep+'20'+date.substring(4,6);break;case 8:date=date.substring(0,2)+sep+date.substring(2,4)+sep+date.substring(4,8);break;}
break;}}
date=date.replace(/[\/-]/g,sep);input.value=date;}
function findElementPos(obj){var x=0;var y=0;if(obj.offsetParent){while(obj.offsetParent){x+=obj.offsetLeft;y+=obj.offsetTop;obj=obj.offsetParent;}}
else if(obj.x&&obj.y){y+=obj.y
x+=obj.x}
return new coordinate(x,y);}
function getClientDim(){var nwX,nwY,seX,seY;if(self.pageYOffset)
{nwX=self.pageXOffset;seX=self.innerWidth+nwX;nwY=self.pageYOffset;seY=self.innerHeight+nwY;}
else if(document.documentElement&&document.documentElement.scrollTop)
{nwX=document.documentElement.scrollLeft;seX=document.documentElement.clientWidth+nwX;nwY=document.documentElement.scrollTop;seY=document.documentElement.clientHeight+nwY;}
else if(document.body)
{nwX=document.body.scrollLeft;seX=document.body.clientWidth+nwX;nwY=document.body.scrollTop;seY=document.body.clientHeight+nwY;}
return{'nw':new coordinate(nwX,nwY),'se':new coordinate(seX,seY)};}
function freezeEvent(e){if(e){if(e.preventDefault)e.preventDefault();e.returnValue=false;e.cancelBubble=true;if(e.stopPropagation)e.stopPropagation();return false;}}
function coordinate(_x,_y){var x=_x;var y=_y;this.add=add;this.sub=sub;this.x=x;this.y=y;function add(rh){return new position(this.x+rh.x,this.y+rh.y);}
function sub(rh){return new position(this.x+rh.x,this.y+rh.y);}}
function sendAndRetrieve(theForm,theDiv,loadingStr){function success(data){document.getElementById(theDiv).innerHTML=data.responseText;ajaxStatus.hideStatus();}
if(typeof loadingStr=='undefined')SUGAR.language.get('app_strings','LBL_LOADING');ajaxStatus.showStatus(loadingStr);YAHOO.util.Connect.setForm(theForm);var cObj=YAHOO.util.Connect.asyncRequest('POST','index.php',{success:success,failure:success});return false;}
function sendAndRedirect(theForm,loadingStr,redirect_location){function success(data){if(redirect_location){location.href=redirect_location;}
ajaxStatus.hideStatus();}
if(typeof loadingStr=='undefined')SUGAR.language.get('app_strings','LBL_LOADING');ajaxStatus.showStatus(loadingStr);YAHOO.util.Connect.setForm(theForm);var cObj=YAHOO.util.Connect.asyncRequest('POST','index.php',{success:success,failure:success});return false;}
function saveForm(theForm,theDiv,loadingStr){if(check_form(theForm)){for(i=0;i<ajaxFormArray.length;i++){if(ajaxFormArray[i]==theForm){ajaxFormArray.splice(i,1);}}
return sendAndRetrieve(theForm,loadingStr,theDiv);}
else
return false;}
function snapshotForm(theForm){var snapshotTxt='';var elemList=theForm.elements;var elem;var elemType;for(var i=0;i<elemList.length;i++){elem=elemList[i];if(typeof(elem.type)=='undefined'){continue;}
elemType=elem.type.toLowerCase();snapshotTxt=snapshotTxt+elem.name;if(elemType=='text'||elemType=='textarea'||elemType=='password'){snapshotTxt=snapshotTxt+elem.value;}
else if(elemType=='select'||elemType=='select-one'||elemType=='select-multiple'){var optionList=elem.options;for(var ii=0;ii<optionList.length;ii++){if(optionList[ii].selected){snapshotTxt=snapshotTxt+optionList[ii].value;}}}
else if(elemType=='radio'||elemType=='checkbox'){if(elem.selected){snapshotTxt=snapshotTxt+'checked';}}
else if(elemType=='hidden'){snapshotTxt=snapshotTxt+elem.value;}}
return snapshotTxt;}
function initEditView(theForm){if(SUGAR.util.ajaxCallInProgress()){window.setTimeout(function(){initEditView(theForm);},100);return;}
if(theForm==null||theForm.id==null){return;}
if(theForm.id=='popup_query_form'||theForm.id=='MassUpdate'){return;}
if(typeof editViewSnapshots=='undefined'||editViewSnapshots==null){editViewSnapshots=new Object();}
if(typeof SUGAR.loadedForms=='undefined'||SUGAR.loadedForms==null){SUGAR.loadedForms=new Object();}
editViewSnapshots[theForm.id]=snapshotForm(theForm);SUGAR.loadedForms[theForm.id]=true;}
function onUnloadEditView(theForm){var dataHasChanged=false;if(typeof editViewSnapshots=='undefined'){return;}
if(typeof theForm=='undefined'){for(var idx in editViewSnapshots){theForm=document.getElementById(idx);if(theForm==null||typeof editViewSnapshots[theForm.id]=='undefined'||editViewSnapshots[theForm.id]==null||!SUGAR.loadedForms[theForm.id]){continue;}
var snap=snapshotForm(theForm);if(editViewSnapshots[theForm.id]!=snap){dataHasChanged=true;}}}else{if(editViewSnapshots==null||typeof theForm.id=='undefined'||typeof editViewSnapshots[theForm.id]=='undefined'||editViewSnapshots[theForm.id]==null){return;}
if(editViewSnapshots[theForm.id]!=snapshotForm(theForm)){dataHasChanged=true;}}
if(dataHasChanged==true){return SUGAR.language.get('app_strings','WARN_UNSAVED_CHANGES');}else{return;}}
function disableOnUnloadEditView(theForm){if(typeof theForm=='undefined'||typeof editViewSnapshots=='undefined'||theForm==null||editViewSnapshots==null){window.onbeforeunload=null;editViewSnapshots=null;}else{if(typeof(theForm.id)!='undefined'&&typeof(editViewSnapshots[theForm.id])!='undefined'){editViewSnapshots[theForm.id]=null;}}}
function saveForms(savingStr,completeStr){index=0;theForms=ajaxFormArray;function success(data){var theForm=document.getElementById(ajaxFormArray[0]);document.getElementById('multiedit_'+theForm.id).innerHTML=data.responseText;var saveAllButton=document.getElementById('ajaxsaveall');ajaxFormArray.splice(index,1);if(saveAllButton&&ajaxFormArray.length<=1){saveAllButton.style.visibility='hidden';}
index++;if(index==theForms.length){ajaxStatus.showStatus(completeStr);window.setTimeout('ajaxStatus.hideStatus();',2000);if(saveAllButton)
saveAllButton.style.visibility='hidden';}}
if(typeof savingStr=='undefined')SUGAR.language.get('app_strings','LBL_LOADING');ajaxStatus.showStatus(savingStr);for(i=0;i<theForms.length;i++){var theForm=document.getElementById(theForms[i]);if(check_form(theForm.id)){theForm.action.value='AjaxFormSave';YAHOO.util.Connect.setForm(theForm);var cObj=YAHOO.util.Connect.asyncRequest('POST','index.php',{success:success,failure:success});}else{ajaxStatus.hideStatus();}
lastSubmitTime=lastSubmitTime-2000;}
return false;}
function sugarListView(){}
sugarListView.prototype.confirm_action=function(del){if(del==1){return confirm(SUGAR.language.get('app_strings','NTC_DELETE_CONFIRMATION_NUM')+sugarListView.get_num_selected()+SUGAR.language.get('app_strings','NTC_DELETE_SELECTED_RECORDS'));}
else{return confirm(SUGAR.language.get('app_strings','NTC_UPDATE_CONFIRMATION_NUM')+sugarListView.get_num_selected()+SUGAR.language.get('app_strings','NTC_DELETE_SELECTED_RECORDS'));}}
sugarListView.get_num_selected=function(){if(typeof document.MassUpdate!='undefined'){the_form=document.MassUpdate;for(wp=0;wp<the_form.elements.length;wp++){if(typeof the_form.elements[wp].name!='undefined'&&the_form.elements[wp].name=='selectCount[]'){return the_form.elements[wp].value;}}}
return 0;}
sugarListView.update_count=function(count,add){if(typeof document.MassUpdate!='undefined'){the_form=document.MassUpdate;for(wp=0;wp<the_form.elements.length;wp++){if(typeof the_form.elements[wp].name!='undefined'&&the_form.elements[wp].name=='selectCount[]'){if(add){the_form.elements[wp].value=parseInt(the_form.elements[wp].value,10)+count;if(the_form.select_entire_list.value==1&&the_form.show_plus.value){the_form.elements[wp].value+='+';}}else{if(the_form.select_entire_list.value==1&&the_form.show_plus.value){the_form.elements[wp].value=count+'+';}else{the_form.elements[wp].value=count;}}}}}}
sugarListView.prototype.use_external_mail_client=function(no_record_txt,module){selected_records=sugarListView.get_checks_count();if(selected_records<1){alert(no_record_txt);return false;}
if(document.MassUpdate.select_entire_list.value==1){if(totalCount>10){alert(totalCountError);return;}
select=false;}
else if(document.MassUpdate.massall.checked==true)
select=false;else
select=true;sugarListView.get_checks();var ids="";if(select){ids=document.MassUpdate.uid.value;}
else{inputs=document.MassUpdate.elements;ar=new Array();for(i=0;i<inputs.length;i++){if(inputs[i].name=='mass[]'&&inputs[i].checked&&typeof(inputs[i].value)!='function'){ar.push(inputs[i].value);}}
ids=ar.join(',');}
YAHOO.util.Connect.asyncRequest("POST","index.php?",{success:this.use_external_mail_client_callback},SUGAR.util.paramsToUrl({module:"Emails",action:"Compose",listViewExternalClient:1,action_module:module,uid:ids,to_pdf:1}));return false;}
sugarListView.prototype.use_external_mail_client_callback=function(o)
{if(o.responseText)
location.href='mailto:'+o.responseText;}
sugarListView.prototype.send_form_for_emails=function(select,currentModule,action,no_record_txt,action_module,totalCount,totalCountError){if(typeof(SUGAR.config.email_sugarclient_listviewmaxselect)!='undefined'){maxCount=10;}
else{maxCount=SUGAR.config.email_sugarclient_listviewmaxselect;}
if(document.MassUpdate.select_entire_list.value==1){if(totalCount>maxCount){alert(totalCountError);return;}
select=false;}
else if(document.MassUpdate.massall.checked==true)
select=false;else
select=true;sugarListView.get_checks();var newForm=document.createElement('form');newForm.method='post';newForm.action=action;newForm.name='newForm';newForm.id='newForm';var uidTa=document.createElement('textarea');uidTa.name='uid';uidTa.style.display='none';if(select){uidTa.value=document.MassUpdate.uid.value;}
else{inputs=document.MassUpdate.elements;ar=new Array();for(i=0;i<inputs.length;i++){if(inputs[i].name=='mass[]'&&inputs[i].checked&&typeof(inputs[i].value)!='function'){ar.push(inputs[i].value);}}
uidTa.value=ar.join(',');}
if(uidTa.value==''){alert(no_record_txt);return false;}
var selectedArray=uidTa.value.split(",");if(selectedArray.length>maxCount){alert(totalCountError);return;}
newForm.appendChild(uidTa);var moduleInput=document.createElement('input');moduleInput.name='module';moduleInput.type='hidden';moduleInput.value=currentModule;newForm.appendChild(moduleInput);var actionInput=document.createElement('input');actionInput.name='action';actionInput.type='hidden';actionInput.value='Compose';newForm.appendChild(actionInput);if(typeof action_module!='undefined'&&action_module!=''){var actionModule=document.createElement('input');actionModule.name='action_module';actionModule.type='hidden';actionModule.value=action_module;newForm.appendChild(actionModule);}
if(typeof return_info!='undefined'&&return_info!=''){var params=return_info.split('&');if(params.length>0){for(var i=0;i<params.length;i++){if(params[i].length>0){var param_nv=params[i].split('=');if(param_nv.length==2){returnModule=document.createElement('input');returnModule.name=param_nv[0];returnModule.type='hidden';returnModule.value=param_nv[1];newForm.appendChild(returnModule);}}}}}
var isAjaxCall=document.createElement('input');isAjaxCall.name='ajaxCall';isAjaxCall.type='hidden';isAjaxCall.value=true;newForm.appendChild(isAjaxCall);var isListView=document.createElement('input');isListView.name='ListView';isListView.type='hidden';isListView.value=true;newForm.appendChild(isListView);var toPdf=document.createElement('input');toPdf.name='to_pdf';toPdf.type='hidden';toPdf.value=true;newForm.appendChild(toPdf);YAHOO.util.Connect.setForm(newForm);var callback={success:function(o){var resp=YAHOO.lang.JSON.parse(o.responseText);var quickComposePackage=new Object();quickComposePackage.composePackage=resp;quickComposePackage.fullComposeUrl='index.php?module=Emails&action=Compose&ListView=true'+'&uid='+uidTa.value+'&action_module='+action_module;SUGAR.quickCompose.init(quickComposePackage);}}
YAHOO.util.Connect.asyncRequest('POST','index.php',callback,null);document.MassUpdate.uid.value='';return false;}
sugarListView.prototype.send_form=function(select,currentModule,action,no_record_txt,action_module,return_info){if(document.MassUpdate.select_entire_list.value==1){if(sugarListView.get_checks_count()<1){alert(no_record_txt);return false;}
var href=action;if(action.indexOf('?')!=-1)
href+='&module='+currentModule;else
href+='?module='+currentModule;if(return_info)
href+=return_info;var newForm=document.createElement('form');newForm.method='post';newForm.action=href;newForm.name='newForm';newForm.id='newForm';var postTa=document.createElement('textarea');postTa.name='current_post';postTa.value=document.MassUpdate.current_query_by_page.value;postTa.style.display='none';newForm.appendChild(postTa);document.MassUpdate.parentNode.appendChild(newForm);newForm.submit();return;}
else if(document.MassUpdate.massall.checked==true)
select=false;else
select=true;sugarListView.get_checks();var newForm=document.createElement('form');newForm.method='post';newForm.action=action;newForm.name='newForm';newForm.id='newForm';var uidTa=document.createElement('textarea');uidTa.name='uid';uidTa.style.display='none';uidTa.value=document.MassUpdate.uid.value;if(uidTa.value==''){alert(no_record_txt);return false;}
newForm.appendChild(uidTa);var moduleInput=document.createElement('input');moduleInput.name='module';moduleInput.type='hidden';moduleInput.value=currentModule;newForm.appendChild(moduleInput);var actionInput=document.createElement('input');actionInput.name='action';actionInput.type='hidden';actionInput.value='index';newForm.appendChild(actionInput);if(typeof action_module!='undefined'&&action_module!=''){var actionModule=document.createElement('input');actionModule.name='action_module';actionModule.type='hidden';actionModule.value=action_module;newForm.appendChild(actionModule);}
if(typeof return_info!='undefined'&&return_info!=''){var params=return_info.split('&');if(params.length>0){for(var i=0;i<params.length;i++){if(params[i].length>0){var param_nv=params[i].split('=');if(param_nv.length==2){returnModule=document.createElement('input');returnModule.name=param_nv[0];returnModule.type='hidden';returnModule.value=param_nv[1];newForm.appendChild(returnModule);}}}}}
document.MassUpdate.parentNode.appendChild(newForm);newForm.submit();document.MassUpdate.uid.value='';return false;}
sugarListView.get_checks_count=function(){ar=new Array();if(document.MassUpdate.uid.value!=''){oldUids=document.MassUpdate.uid.value.split(',');for(uid in oldUids){if(typeof(oldUids[uid])!='function'){ar[oldUids[uid]]=1;}}}
inputs=document.MassUpdate.elements;for(i=0;i<inputs.length;i++){if(inputs[i].name=='mass[]'){ar[inputs[i].value]=(inputs[i].checked)?1:0;}}
uids=new Array();for(i in ar){if((typeof(ar[i])!='function')&&ar[i]==1){uids.push(i);}}
return uids.length;}
sugarListView.get_checks=function(){ar=new Array();if(document.MassUpdate.uid.value!=''){oldUids=document.MassUpdate.uid.value.split(',');for(uid in oldUids){if(typeof(oldUids[uid])!='function'){ar[oldUids[uid]]=1;}}}
inputs=document.MassUpdate.elements;for(i=0;i<inputs.length;i++){if(inputs[i].name=='mass[]'){ar[inputs[i].value]=(inputs[i].checked)?1:0;}}
uids=new Array();for(i in ar){if(typeof(ar[i])!='function'&&ar[i]==1){uids.push(i);}}
document.MassUpdate.uid.value=uids.join(',');if(uids.length==0)return false;return true;}
sugarListView.prototype.order_checks=function(order,orderBy,moduleString){checks=sugarListView.get_checks();eval('document.MassUpdate.'+moduleString+'.value = orderBy');document.MassUpdate.lvso.value=order;if(typeof document.MassUpdate.massupdate!='undefined'){document.MassUpdate.massupdate.value='false';}
document.MassUpdate.action.value=document.MassUpdate.return_action.value;document.MassUpdate.return_module.value='';document.MassUpdate.return_action.value='';document.MassUpdate.submit();return!checks;}
sugarListView.prototype.save_checks=function(offset,moduleString){checks=sugarListView.get_checks();eval('document.MassUpdate.'+moduleString+'.value = offset');if(typeof document.MassUpdate.massupdate!='undefined'){document.MassUpdate.massupdate.value='false';}
document.MassUpdate.action.value=document.MassUpdate.return_action.value;document.MassUpdate.return_module.value='';document.MassUpdate.return_action.value='';document.MassUpdate.submit();return!checks;}
sugarListView.prototype.check_item=function(cb,form){if(cb.checked){sugarListView.update_count(1,true);}else{sugarListView.update_count(-1,true);if(typeof form!='undefined'&&form!=null){sugarListView.prototype.updateUid(cb,form);}}}
sugarListView.prototype.updateUid=function(cb,form){if(form.name=='MassUpdate'&&form.uid&&form.uid.value&&cb.value&&form.uid.value.indexOf(cb.value)!=-1){if(form.uid.value.indexOf(','+cb.value)!=-1){form.uid.value=form.uid.value.replace(','+cb.value,'');}else if(form.uid.value.indexOf(cb.value+',')!=-1){form.uid.value=form.uid.value.replace(cb.value+',','');}else if(form.uid.value.indexOf(cb.value)!=-1){form.uid.value=form.uid.value.replace(cb.value,'');}}}
sugarListView.prototype.check_entire_list=function(form,field,value,list_count){count=0;document.MassUpdate.massall.checked=true;document.MassUpdate.massall.disabled=true;for(i=0;i<form.elements.length;i++){if(form.elements[i].name==field&&form.elements[i].disabled==false){if(form.elements[i].checked!=value)count++;form.elements[i].checked=value;form.elements[i].disabled=true;}}
document.MassUpdate.select_entire_list.value=1;sugarListView.update_count(list_count,false);}
sugarListView.prototype.check_all=function(form,field,value,pageTotal){count=0;document.MassUpdate.massall.checked=value;if(document.MassUpdate.select_entire_list&&document.MassUpdate.select_entire_list.value==1)
document.MassUpdate.massall.disabled=true;else
document.MassUpdate.massall.disabled=false;for(i=0;i<form.elements.length;i++){if(form.elements[i].name==field&&!(form.elements[i].disabled==true&&form.elements[i].checked==false)){form.elements[i].disabled=false;if(form.elements[i].checked!=value)
count++;form.elements[i].checked=value;if(!value){sugarListView.prototype.updateUid(form.elements[i],form);}}}
if(pageTotal>=0)
sugarListView.update_count(pageTotal);else if(value)
sugarListView.update_count(count,true);else
sugarListView.update_count(-1*count,true);}
sugarListView.check_all=sugarListView.prototype.check_all;sugarListView.confirm_action=sugarListView.prototype.confirm_action;sugarListView.prototype.check_boxes=function(){var inputsCount=0;var checkedCount=0;var existing_onload=window.onload;var theForm=document.MassUpdate;inputs_array=theForm.elements;if(typeof theForm.uid.value!='undefined'&&theForm.uid.value!=""){checked_items=theForm.uid.value.split(",");if(theForm.select_entire_list.value==1)
document.MassUpdate.massall.disabled=true;for(wp=0;wp<inputs_array.length;wp++){if(inputs_array[wp].name=="mass[]"){inputsCount++;if(theForm.select_entire_list.value==1){inputs_array[wp].checked=true;inputs_array[wp].disabled=true;checkedCount++;}
else{for(i in checked_items){if(inputs_array[wp].value==checked_items[i]){checkedCount++;inputs_array[wp].checked=true;}}}}}
if(theForm.select_entire_list.value==0)
sugarListView.update_count(checked_items.length);else
sugarListView.update_count(0,true);}
else{for(wp=0;wp<inputs_array.length;wp++){if(inputs_array[wp].name=="mass[]"){inputs_array[wp].checked=false;inputs_array[wp].disabled=false;}}
if(document.MassUpdate.massall){document.MassUpdate.massall.checked=false;document.MassUpdate.massall.disabled=false;}
sugarListView.update_count(0)}
if(checkedCount>0&&checkedCount==inputsCount)
document.MassUpdate.massall.checked=true;}
function check_used_email_templates(){var ids=document.MassUpdate.uid.value;var call_back={success:function(r){if(r.responseText!=''){if(!confirm(SUGAR.language.get('app_strings','NTC_TEMPLATES_IS_USED')+r.responseText)){return false;}}
document.MassUpdate.submit();return false;}};url="index.php?module=EmailTemplates&action=CheckDeletable&from=ListView&to_pdf=1&records="+ids;YAHOO.util.Connect.asyncRequest('POST',url,call_back,null);}
sugarListView.prototype.send_mass_update=function(mode,no_record_txt,del){formValid=check_form('MassUpdate');if(!formValid&&!del)return false;if(document.MassUpdate.select_entire_list&&document.MassUpdate.select_entire_list.value==1)
mode='entire';else
mode='selected';var ar=new Array();switch(mode){case'selected':for(wp=0;wp<document.MassUpdate.elements.length;wp++){var reg_for_existing_uid=new RegExp('^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$|^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$');if(typeof document.MassUpdate.elements[wp].name!='undefined'&&document.MassUpdate.elements[wp].name=='mass[]'&&document.MassUpdate.elements[wp].checked&&!reg_for_existing_uid.test(document.MassUpdate.uid.value)){ar.push(document.MassUpdate.elements[wp].value);}}
if(document.MassUpdate.uid.value!='')document.MassUpdate.uid.value+=',';document.MassUpdate.uid.value+=ar.join(',');if(document.MassUpdate.uid.value==''){alert(no_record_txt);return false;}
if(typeof(current_admin_id)!='undefined'&&document.MassUpdate.module!='undefined'&&document.MassUpdate.module.value=='Users'&&(document.MassUpdate.is_admin.value!=''||document.MassUpdate.status.value!='')){var reg_for_current_admin_id=new RegExp('^'+current_admin_id+'[\s]*,|,[\s]*'+current_admin_id+'[\s]*,|,[\s]*'+current_admin_id+'$|^'+current_admin_id+'$');if(reg_for_current_admin_id.test(document.MassUpdate.uid.value)){alert(SUGAR.language.get('Users','LBL_LAST_ADMIN_NOTICE'));return false;}}
break;case'entire':var entireInput=document.createElement('input');entireInput.name='entire';entireInput.type='hidden';entireInput.value='index';document.MassUpdate.appendChild(entireInput);if(document.MassUpdate.module!='undefined'&&document.MassUpdate.module.value=='Users'&&(document.MassUpdate.is_admin.value!=''||document.MassUpdate.status.value!='')){alert(SUGAR.language.get('Users','LBL_LAST_ADMIN_NOTICE'));return false;}
break;}
if(!sugarListView.confirm_action(del))
return false;if(del==1){var deleteInput=document.createElement('input');deleteInput.name='Delete';deleteInput.type='hidden';deleteInput.value=true;document.MassUpdate.appendChild(deleteInput);if(document.MassUpdate.module!='undefined'&&document.MassUpdate.module.value=='EmailTemplates'){check_used_email_templates();return false;}}
document.MassUpdate.submit();return false;}
sugarListView.prototype.clear_all=function(){document.MassUpdate.uid.value='';document.MassUpdate.select_entire_list.value=0;sugarListView.check_all(document.MassUpdate,'mass[]',false);document.MassUpdate.massall.checked=false;document.MassUpdate.massall.disabled=false;sugarListView.update_count(0);}
sListView=new sugarListView();function unformatNumber(n,num_grp_sep,dec_sep){var x=unformatNumberNoParse(n,num_grp_sep,dec_sep);x=x.toString();if(x.length>0){return parseFloat(x);}
return'';}
function unformatNumberNoParse(n,num_grp_sep,dec_sep){if(typeof num_grp_sep=='undefined'||typeof dec_sep=='undefined')return n;n=n?n.toString():'';if(n.length>0){if(num_grp_sep!='')
{num_grp_sep_re=new RegExp('\\'+num_grp_sep,'g');n=n.replace(num_grp_sep_re,'');}
n=n.replace(dec_sep,'.');if(typeof CurrencySymbols!='undefined'){for(var idx in CurrencySymbols){n=n.replace(CurrencySymbols[idx],'');}}
return n;}
return'';}
function formatNumber(n,num_grp_sep,dec_sep,round,precision){if(typeof num_grp_sep=='undefined'||typeof dec_sep=='undefined')return n;n=n?n.toString():'';if(n.split)n=n.split('.');else return n;if(n.length>2)return n.join('.');if(typeof round!='undefined'){if(round>0&&n.length>1){n[1]=parseFloat('0.'+n[1]);n[1]=Math.round(n[1]*Math.pow(10,round))/ Math.pow(10,round);n[1]=n[1].toString().split('.')[1];}
if(round<=0){n[0]=Math.round(parseInt(n[0],10)*Math.pow(10,round))/ Math.pow(10,round);n[1]='';}}
if(typeof precision!='undefined'&&precision>=0){if(n.length>1&&typeof n[1]!='undefined')n[1]=n[1].substring(0,precision);else n[1]='';if(n[1].length<precision){for(var wp=n[1].length;wp<precision;wp++)n[1]+='0';}}
regex=/(\d+)(\d{3})/;while(num_grp_sep!=''&&regex.test(n[0]))n[0]=n[0].toString().replace(regex,'$1'+num_grp_sep+'$2');return n[0]+(n.length>1&&n[1]!=''?dec_sep+n[1]:'');}
SUGAR.ajaxStatusClass=function(){};SUGAR.ajaxStatusClass.prototype.statusDiv=null;SUGAR.ajaxStatusClass.prototype.oldOnScroll=null;SUGAR.ajaxStatusClass.prototype.shown=false;SUGAR.ajaxStatusClass.prototype.positionStatus=function(){statusDivRegion=YAHOO.util.Dom.getRegion(this.statusDiv);statusDivWidth=statusDivRegion.right-statusDivRegion.left;this.statusDiv.style.left=YAHOO.util.Dom.getViewportWidth()/ 2-statusDivWidth / 2+'px';}
SUGAR.ajaxStatusClass.prototype.createStatus=function(text){statusDiv=document.createElement('div');statusDiv.className='dataLabel';statusDiv.id='ajaxStatusDiv';document.body.appendChild(statusDiv);this.statusDiv=document.getElementById('ajaxStatusDiv');}
SUGAR.ajaxStatusClass.prototype.showStatus=function(text){if(!this.statusDiv){this.createStatus(text);}
else{this.statusDiv.style.display='';}
this.statusDiv.innerHTML='&nbsp;<b>'+text+'</b>&nbsp;';this.positionStatus();if(!this.shown){this.shown=true;this.statusDiv.style.display='';if(window.onscroll)this.oldOnScroll=window.onscroll;window.onscroll=this.positionStatus;}}
SUGAR.ajaxStatusClass.prototype.hideStatus=function(text){if(!this.shown)return;this.shown=false;if(this.oldOnScroll)window.onscroll=this.oldOnScroll;else window.onscroll='';this.statusDiv.style.display='none';}
SUGAR.ajaxStatusClass.prototype.flashStatus=function(text,time){this.showStatus(text);window.setTimeout('ajaxStatus.hideStatus();',time);}
var ajaxStatus=new SUGAR.ajaxStatusClass();SUGAR.unifiedSearchAdvanced=function(){var usa_div;var usa_img;var usa_open;var usa_content;var anim_open;var anim_close;return{init:function(){SUGAR.unifiedSearchAdvanced.usa_div=document.getElementById('unified_search_advanced_div');SUGAR.unifiedSearchAdvanced.usa_img=document.getElementById('unified_search_advanced_img');if(!SUGAR.unifiedSearchAdvanced.usa_div||!SUGAR.unifiedSearchAdvanced.usa_img)return;var attributes={height:{to:300}};SUGAR.unifiedSearchAdvanced.anim_open=new YAHOO.util.Anim('unified_search_advanced_div',attributes);SUGAR.unifiedSearchAdvanced.anim_open.duration=0.75;SUGAR.unifiedSearchAdvanced.anim_close=new YAHOO.util.Anim('unified_search_advanced_div',{height:{to:0}});SUGAR.unifiedSearchAdvanced.anim_close.duration=0.75;SUGAR.unifiedSearchAdvanced.usa_img._x=YAHOO.util.Dom.getX(SUGAR.unifiedSearchAdvanced.usa_img);SUGAR.unifiedSearchAdvanced.usa_img._y=YAHOO.util.Dom.getY(SUGAR.unifiedSearchAdvanced.usa_img);SUGAR.unifiedSearchAdvanced.usa_open=false;SUGAR.unifiedSearchAdvanced.usa_content=null;YAHOO.util.Event.addListener('unified_search_advanced_img','click',SUGAR.unifiedSearchAdvanced.get_content);},get_content:function(e)
{query_string=trim(document.getElementById('query_string').value);if(query_string!='')
{window.location.href='index.php?module=Home&action=UnifiedSearch&query_string='+query_string;}else{window.location.href='index.php?module=Home&action=UnifiedSearch&form_only=true';}},animate:function(data){ajaxStatus.hideStatus();if(data){SUGAR.unifiedSearchAdvanced.usa_content=data.responseText;SUGAR.unifiedSearchAdvanced.usa_div.innerHTML=SUGAR.unifiedSearchAdvanced.usa_content;}
if(SUGAR.unifiedSearchAdvanced.usa_open){document.UnifiedSearch.advanced.value='false';SUGAR.unifiedSearchAdvanced.anim_close.animate();}
else{document.UnifiedSearch.advanced.value='true';SUGAR.unifiedSearchAdvanced.usa_div.style.display='';YAHOO.util.Dom.setX(SUGAR.unifiedSearchAdvanced.usa_div,SUGAR.unifiedSearchAdvanced.usa_img._x-90);YAHOO.util.Dom.setY(SUGAR.unifiedSearchAdvanced.usa_div,SUGAR.unifiedSearchAdvanced.usa_img._y+15);SUGAR.unifiedSearchAdvanced.anim_open.animate();}
SUGAR.unifiedSearchAdvanced.usa_open=!SUGAR.unifiedSearchAdvanced.usa_open;return false;},checkUsaAdvanced:function(){if(document.UnifiedSearch.advanced.value=='true'){document.UnifiedSearchAdvanced.query_string.value=document.UnifiedSearch.query_string.value;document.UnifiedSearchAdvanced.submit();return false;}
return true;}};}();if(typeof YAHOO!='undefined')YAHOO.util.Event.addListener(window,'load',SUGAR.unifiedSearchAdvanced.init);SUGAR.ui={toggleHeader:function(){var h=document.getElementById('header');if(h!=null){if(h!=null){if(h.style.display=='none'){h.style.display='';}else{h.style.display='none';}}}else{alert(SUGAR.language.get("app_strings","ERR_NO_HEADER_ID"));}}};SUGAR.util=function(){var additionalDetailsCache;var additionalDetailsCalls;var additionalDetailsRpcCall;return{getAndRemove:function(el){if(YAHOO&&YAHOO.util&&YAHOO.util.Dom)
el=YAHOO.util.Dom.get(el);else if(typeof(el)=="string")
el=document.getElementById(el);if(el&&el.parentNode)
el.parentNode.removeChild(el);return el;},paramsToUrl:function(params){url="";for(i in params){url+=i+"="+params[i]+"&";}
return url;},evalScript:function(text){if(isSafari){var waitUntilLoaded=function(){SUGAR.evalScript_waitCount--;if(SUGAR.evalScript_waitCount==0){var headElem=document.getElementsByTagName('head')[0];for(var i=0;i<SUGAR.evalScript_evalElem.length;i++){var tmpElem=document.createElement('script');tmpElem.type='text/javascript';tmpElem.text=SUGAR.evalScript_evalElem[i];headElem.appendChild(tmpElem);}}};var tmpElem=document.createElement('div');tmpElem.innerHTML=text;var results=tmpElem.getElementsByTagName('script');if(results==null){return;}
var headElem=document.getElementsByTagName('head')[0];var tmpElem=null;SUGAR.evalScript_waitCount=0;SUGAR.evalScript_evalElem=new Array();for(var i=0;i<results.length;i++){if(typeof(results[i])!='object'){continue;};tmpElem=document.createElement('script');tmpElem.type='text/javascript';if(results[i].src!=null&&results[i].src!=''){tmpElem.src=results[i].src;}else{SUGAR.evalScript_evalElem[SUGAR.evalScript_evalElem.length]=results[i].text;continue;}
tmpElem.addEventListener('load',waitUntilLoaded);SUGAR.evalScript_waitCount++;headElem.appendChild(tmpElem);}
SUGAR.evalScript_waitCount++;waitUntilLoaded();return;}
var objRegex=/<\s*script([^>]*)>((.|\s|\v|\0)*?)<\s*\/script\s*>/igm;var lastIndex=-1;var result=objRegex.exec(text);while(result&&result.index>lastIndex){lastIndex=result.index
try{var script=document.createElement('script');script.type='text/javascript';if(result[1].indexOf("src=")>-1){var srcRegex=/.*src=['"]([a-zA-Z0-9_\&\/\.\?=:]*)['"].*/igm;var srcResult=result[1].replace(srcRegex,'$1');script.src=srcResult;}else{script.text=result[2];}
document.body.appendChild(script);}
catch(e){if(typeof(console)!="undefined"&&typeof(console.log)=="function")
{console.log("error adding script");console.log(e);console.log(result);}}
result=objRegex.exec(text);}},getLeftColObj:function(){leftColObj=document.getElementById('leftCol');while(leftColObj.nodeName!='TABLE'){leftColObj=leftColObj.firstChild;}
leftColTable=leftColObj;leftColTd=leftColTable.getElementsByTagName('td')[0];leftColTdRegion=YAHOO.util.Dom.getRegion(leftColTd);leftColTd.style.width=(leftColTdRegion.right-leftColTdRegion.left)+'px';return leftColTd;},fillShortcuts:function(e,shortcutContent){return;},retrieveAndFill:function(url,theDiv,postForm,callback,callbackParam,appendMode){if(typeof theDiv=='string'){try{theDiv=document.getElementById(theDiv);}
catch(e){return;}}
var success=function(data){if(typeof theDiv!='undefined'&&theDiv!=null)
{try{if(typeof appendMode!='undefined'&&appendMode)
{theDiv.innerHTML+=data.responseText;}
else
{theDiv.innerHTML=data.responseText;}}
catch(e){return;}}
if(typeof callback!='undefined'&&callback!=null)callback(callbackParam);}
if(typeof postForm=='undefined'||postForm==null){var cObj=YAHOO.util.Connect.asyncRequest('GET',url,{success:success,failure:success});}
else{YAHOO.util.Connect.setForm(postForm);var cObj=YAHOO.util.Connect.asyncRequest('POST',url,{success:success,failure:success});}},checkMaxLength:function(){var maxLength=this.getAttribute('maxlength');var currentLength=this.value.length;if(currentLength>maxLength){this.value=this.value.substring(0,maxLength);}},setMaxLength:function(){var x=document.getElementsByTagName('textarea');for(var i=0;i<x.length;i++){if(x[i].getAttribute('maxlength')){x[i].onkeyup=x[i].onchange=SUGAR.util.checkMaxLength;x[i].onkeyup();}}},getAdditionalDetails:function(bean,id,spanId){go=function(){oReturn=function(body,caption,width,theme){var _refx=25-width;return overlib(body,CAPTION,caption,STICKY,MOUSEOFF,1000,WIDTH,width,CLOSETEXT,('<img border=0 style="margin-left:2px; margin-right: 2px;" src=index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=close.gif>'),CLOSETITLE,SUGAR.language.get('app_strings','LBL_ADDITIONAL_DETAILS_CLOSE_TITLE'),CLOSECLICK,FGCLASS,'olFgClass',CGCLASS,'olCgClass',BGCLASS,'olBgClass',TEXTFONTCLASS,'olFontClass',CAPTIONFONTCLASS,'olCapFontClass',CLOSEFONTCLASS,'olCloseFontClass',REF,spanId,REFC,'LL',REFX,_refx);}
success=function(data){eval(data.responseText);SUGAR.util.additionalDetailsCache[spanId]=new Array();SUGAR.util.additionalDetailsCache[spanId]['body']=result['body'];SUGAR.util.additionalDetailsCache[spanId]['caption']=result['caption'];SUGAR.util.additionalDetailsCache[spanId]['width']=result['width'];SUGAR.util.additionalDetailsCache[spanId]['theme']=result['theme'];ajaxStatus.hideStatus();return oReturn(SUGAR.util.additionalDetailsCache[spanId]['body'],SUGAR.util.additionalDetailsCache[spanId]['caption'],SUGAR.util.additionalDetailsCache[spanId]['width'],SUGAR.util.additionalDetailsCache[spanId]['theme']);}
if(typeof SUGAR.util.additionalDetailsCache[spanId]!='undefined')
return oReturn(SUGAR.util.additionalDetailsCache[spanId]['body'],SUGAR.util.additionalDetailsCache[spanId]['caption'],SUGAR.util.additionalDetailsCache[spanId]['width'],SUGAR.util.additionalDetailsCache[spanId]['theme']);if(typeof SUGAR.util.additionalDetailsCalls[spanId]!='undefined')
return;ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_LOADING'));url='index.php?to_pdf=1&module=Home&action=AdditionalDetailsRetrieve&bean='+bean+'&id='+id;SUGAR.util.additionalDetailsCalls[spanId]=YAHOO.util.Connect.asyncRequest('GET',url,{success:success,failure:success});return false;}
SUGAR.util.additionalDetailsRpcCall=window.setTimeout('go()',250);},clearAdditionalDetailsCall:function(){if(typeof SUGAR.util.additionalDetailsRpcCall=='number')window.clearTimeout(SUGAR.util.additionalDetailsRpcCall);},extend:function(subc,superc,overrides){subc.prototype=new superc;if(overrides){for(var i in overrides)subc.prototype[i]=overrides[i];}},hrefURL:function(url){if(SUGAR.isIE){var trampoline=document.createElement('a');trampoline.href=url;document.body.appendChild(trampoline);trampoline.click();document.body.removeChild(trampoline);}else{document.location.href=url;}},openWindow:function(URL,windowName,windowFeatures){if(SUGAR.isIE){win=window.open('',windowName,windowFeatures);var trampoline=document.createElement('a');trampoline.href=URL;trampoline.target=windowName;document.body.appendChild(trampoline);trampoline.click();document.body.removeChild(trampoline);}else{win=window.open(URL,windowName,windowFeatures);}
return win;},top:function(){window.scroll(0,0);},doWhen:function(condition,fn,params,scope)
{this._doWhenStack.push({check:condition,fn:fn,obj:params,overrideContext:scope});this._doWhenretryCount=50;this._startDoWhenInterval();},_startDoWhenInterval:function(){if(!this._doWhenInterval){this._doWhenInterval=YAHOO.lang.later(50,this,this._doWhenCheck,null,true);}},_doWhenStack:[],_doWhenInterval:false,_doWhenCheck:function(){if(this._doWhenStack.length===0){this._doWhenretryCount=0;if(this._doWhenInterval){this._doWhenInterval.cancel();this._doWhenInterval=null;}
return;}
if(this._doWhenLocked){return;}
if(SUGAR.isIE){if(!YAHOO.util.Event.DOMReady){this._startDoWhenInterval();return;}}
this._doWhenLocked=true;var tryAgain=YAHOO.util.Event.DOMReady;if(!tryAgain){tryAgain=(this._doWhenretryCount>0&&this._doWhenStack.length>0);}
var notAvail=[];var executeItem=function(context,item){if(item.overrideContext){if(item.overrideContext===true){context=item.obj;}else{context=item.overrideContext;}}
item.fn.call(context,item.obj);};var i,len,item,test;for(i=0,len=this._doWhenStack.length;i<len;i=i+1){item=this._doWhenStack[i];if(item){test=item.check;if((typeof(test)=="string"&&eval(test))||(typeof(test)=="function"&&test())){executeItem(this,item);this._doWhenStack[i]=null;}
else{notAvail.push(item);}}}
this._doWhenretryCount--;if(tryAgain){for(i=this._doWhenStack.length-1;i>-1;i--){item=this._doWhenStack[i];if(!item||!item.check){this._doWhenStack.splice(i,1);}}
this._startDoWhenInterval();}else{if(this._doWhenInterval){this._doWhenInterval.cancel();this._doWhenInterval=null;}}
this._doWhenLocked=false;}};}();SUGAR.util.additionalDetailsCache=new Array();SUGAR.util.additionalDetailsCalls=new Array();if(typeof YAHOO!='undefined')YAHOO.util.Event.addListener(window,'load',SUGAR.util.setMaxLength);SUGAR.savedViews=function(){var selectedOrderBy;var selectedSortOrder;var displayColumns;var hideTabs;var columnsMeta;return{setChooser:function(){var displayColumnsDef=new Array();var hideTabsDef=new Array();var left_td=document.getElementById('display_tabs_td');if(typeof left_td=='undefined'||left_td==null)return;var right_td=document.getElementById('hide_tabs_td');var displayTabs=left_td.getElementsByTagName('select')[0];var hideTabs=right_td.getElementsByTagName('select')[0];for(i=0;i<displayTabs.options.length;i++){displayColumnsDef.push(displayTabs.options[i].value);}
if(typeof hideTabs!='undefined'){for(i=0;i<hideTabs.options.length;i++){hideTabsDef.push(hideTabs.options[i].value);}}
if(!SUGAR.savedViews.clearColumns)
document.getElementById('displayColumnsDef').value=displayColumnsDef.join('|');document.getElementById('hideTabsDef').value=hideTabsDef.join('|');},select:function(saved_search_select){for(var wp=0;wp<document.search_form.saved_search_select.options.length;wp++){if(typeof document.search_form.saved_search_select.options[wp].value!='undefined'&&document.search_form.saved_search_select.options[wp].value==saved_search_select){document.search_form.saved_search_select.selectedIndex=wp;document.search_form.ss_delete.style.display='';document.search_form.ss_update.style.display='';}}},saved_search_action:function(action,delete_lang){if(action=='delete'){if(!confirm(delete_lang))return;}
if(action=='save'){if(document.search_form.saved_search_name.value.replace(/^\s*|\s*$/g,'')==''){alert(SUGAR.language.get('app_strings','LBL_SAVED_SEARCH_ERROR'));return;}}
if(document.search_form.saved_search_action)
{document.search_form.saved_search_action.value=action;document.search_form.search_module.value=document.search_form.module.value;document.search_form.module.value='SavedSearch';document.search_form.action.value='index';}
SUGAR.ajaxUI.submitForm(document.search_form);},shortcut_select:function(selectBox,module){selecturl='index.php?module=SavedSearch&search_module='+module+'&action=index&saved_search_select='+selectBox.options[selectBox.selectedIndex].value
if(typeof(document.getElementById('searchFormTab'))!='undefined'){selecturl=selecturl+'&searchFormTab='+document.search_form.searchFormTab.value;}
if(document.getElementById('showSSDIV')&&typeof(document.getElementById('showSSDIV')!='undefined')){selecturl=selecturl+'&showSSDIV='+document.getElementById('showSSDIV').value;}
document.location.href=selecturl;},handleForm:function(){SUGAR.tabChooser.movementCallback=function(left_side,right_side){while(document.getElementById('orderBySelect').childNodes.length!=0){document.getElementById('orderBySelect').removeChild(document.getElementById('orderBySelect').lastChild);}
var selectedIndex=0;var nodeCount=-1;for(i in left_side.childNodes){if(typeof left_side.childNodes[i].nodeName!='undefined'&&left_side.childNodes[i].nodeName.toLowerCase()=='option'&&typeof SUGAR.savedViews.columnsMeta[left_side.childNodes[i].value]!='undefined'&&typeof SUGAR.savedViews.columnsMeta[left_side.childNodes[i].value]['sortable']=='undefined'&&SUGAR.savedViews.columnsMeta[left_side.childNodes[i].value]['sortable']!=false){nodeCount++;optionNode=document.createElement('option');optionNode.value=left_side.childNodes[i].value;optionNode.innerHTML=left_side.childNodes[i].innerHTML;document.getElementById('orderBySelect').appendChild(optionNode);if(optionNode.value==SUGAR.savedViews.selectedOrderBy)
selectedIndex=nodeCount;}}
document.getElementById('orderBySelect').selectedIndex=selectedIndex;};SUGAR.tabChooser.movementCallback(document.getElementById('display_tabs_td').getElementsByTagName('select')[0]);if(document.search_form.orderBy)
document.search_form.orderBy.options.value=SUGAR.savedViews.selectedOrderBy;if(SUGAR.savedViews.selectedSortOrder=='DESC')document.getElementById('sort_order_desc_radio').checked=true;else document.getElementById('sort_order_asc_radio').checked=true;}};}();SUGAR.searchForm=function(){var url;return{searchFormSelect:function(view,previousView){var module=view.split('|')[0];var theView=view.split('|')[1];var handleDisplay=function(){document.search_form.searchFormTab.value=theView;patt=module+"(.*)SearchForm$";divId=document.search_form.getElementsByTagName('div');for(i=0;i<divId.length;i++){if(divId[i].id.match(module)==module){if(divId[i].id.match('SearchForm')=='SearchForm'){if(document.getElementById(divId[i].id).style.display==''){previousTab=divId[i].id.match(patt)[1];}
document.getElementById(divId[i].id).style.display='none';}}}
document.getElementById(module+theView+'SearchForm').style.display='';if(previousView){thepreviousView=previousView.split('|')[1];}
else{thepreviousView=previousTab;}
thepreviousView=thepreviousView.replace(/_search/,"");for(num in document.search_form.elements){if(document.search_form.elements[num]){el=document.search_form.elements[num];pattern="^(.*)_"+thepreviousView+"$";if(typeof el.type!='undefined'&&typeof el.name!='undefined'&&el.name.match(pattern)){advanced_input_name=el.name.match(pattern)[1];advanced_input_name=advanced_input_name+"_"+theView.replace(/_search/,"");if(typeof document.search_form[advanced_input_name]!='undefined')
SUGAR.searchForm.copyElement(advanced_input_name,el);}}}}
if(document.getElementById(module+theView+'SearchForm').innerHTML==''){ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_LOADING'));var success=function(data){document.getElementById(module+theView+'SearchForm').innerHTML=data.responseText;SUGAR.util.evalScript(data.responseText);if(theView=='saved_views'){if(typeof columnsMeta!='undefined')SUGAR.savedViews.columnsMeta=columnsMeta;if(typeof selectedOrderBy!='undefined')SUGAR.savedViews.selectedOrderBy=selectedOrderBy;if(typeof selectedSortOrder!='undefined')SUGAR.savedViews.selectedSortOrder=selectedSortOrder;}
handleDisplay();enableQS(true);ajaxStatus.hideStatus();}
url='index.php?module='+module+'&action=index&search_form_only=true&to_pdf=true&search_form_view='+theView;var tpl='';if(document.getElementById('search_tpl')!=null&&typeof(document.getElementById('search_tpl'))!='undefined'){tpl=document.getElementById('search_tpl').value;if(tpl!=''){url+='&search_tpl='+tpl;}}
if(theView=='saved_views')
url+='&displayColumns='+SUGAR.savedViews.displayColumns+'&hideTabs='+SUGAR.savedViews.hideTabs+'&orderBy='+SUGAR.savedViews.selectedOrderBy+'&sortOrder='+SUGAR.savedViews.selectedSortOrder;var cObj=YAHOO.util.Connect.asyncRequest('GET',url,{success:success,failure:success});}
else{handleDisplay();}},copyElement:function(inputName,copyFromElement){switch(copyFromElement.type){case'select-one':case'text':document.search_form[inputName].value=copyFromElement.value;break;}},clear_form:function(form,skipElementNames){var elemList=form.elements;var elem;var elemType;for(var i=0;i<elemList.length;i++){elem=elemList[i];if(typeof(elem.type)=='undefined'){continue;}
if(typeof(elem.type)!='undefined'&&typeof(skipElementNames)!='undefined'&&SUGAR.util.arrayIndexOf(skipElementNames,elem.name)!=-1)
{continue;}
elemType=elem.type.toLowerCase();if(elemType=='text'||elemType=='textarea'||elemType=='password'){elem.value='';}
else if(elemType=='select'||elemType=='select-one'||elemType=='select-multiple'){var optionList=elem.options;for(var ii=0;ii<optionList.length;ii++){optionList[ii].selected=false;}}
else if(elemType=='radio'||elemType=='checkbox'){elem.checked=false;elem.selected=false;}
else if(elemType=='hidden'){if((elem.name.length>3&&elem.name.substring(elem.name.length-3)=='_id')||((elem.name.length>9)&&(elem.name.substring(elem.name.length-9)=='_id_basic'))||(elem.name.length>12&&elem.name.substring(elem.name.length-12)=='_id_advanced')){elem.value='';}}}
SUGAR.savedViews.clearColumns=true;}};}();SUGAR.tabChooser=function(){var object_refs=new Array();return{frozenOptions:[],movementCallback:function(left_side,right_side){},orderCallback:function(left_side,right_side){},freezeOptions:function(left_name,right_name,target){if(!SUGAR.tabChooser.frozenOptions){SUGAR.tabChooser.frozenOptions=[];}
if(!SUGAR.tabChooser.frozenOptions[left_name]){SUGAR.tabChooser.frozenOptions[left_name]=[];}
if(!SUGAR.tabChooser.frozenOptions[left_name][right_name]){SUGAR.tabChooser.frozenOptions[left_name][right_name]=[];}
if(typeof target=='array'){for(var i in target){SUGAR.tabChooser.frozenOptions[left_name][right_name][target[i]]=true;}}else{SUGAR.tabChooser.frozenOptions[left_name][right_name][target]=true;}},buildSelectHTML:function(info){var text="<select";if(typeof(info['select']['size'])!='undefined'){text+=" size=\""+info['select']['size']+"\"";}
if(typeof(info['select']['name'])!='undefined'){text+=" name=\""+info['select']['name']+"\"";}
if(typeof(info['select']['style'])!='undefined'){text+=" style=\""+info['select']['style']+"\"";}
if(typeof(info['select']['onchange'])!='undefined'){text+=" onChange=\""+info['select']['onchange']+"\"";}
if(typeof(info['select']['multiple'])!='undefined'){text+=" multiple";}
text+=">";for(i=0;i<info['options'].length;i++){option=info['options'][i];text+="<option value=\""+option['value']+"\" ";if(typeof(option['selected'])!='undefined'&&option['selected']==true){text+="SELECTED";}
text+=">"+option['text']+"</option>";}
text+="</select>";return text;},left_to_right:function(left_name,right_name,left_size,right_size){SUGAR.savedViews.clearColumns=false;var left_td=document.getElementById(left_name+'_td');var right_td=document.getElementById(right_name+'_td');var display_columns_ref=left_td.getElementsByTagName('select')[0];var hidden_columns_ref=right_td.getElementsByTagName('select')[0];var selected_left=new Array();var notselected_left=new Array();var notselected_right=new Array();var left_array=new Array();var frozen_options=SUGAR.tabChooser.frozenOptions;frozen_options=frozen_options&&frozen_options[left_name]&&frozen_options[left_name][right_name]?frozen_options[left_name][right_name]:[];for(i=0;i<display_columns_ref.options.length;i++)
{if(display_columns_ref.options[i].selected==true&&!frozen_options[display_columns_ref.options[i].value])
{selected_left[selected_left.length]={text:display_columns_ref.options[i].text,value:display_columns_ref.options[i].value};}
else
{notselected_left[notselected_left.length]={text:display_columns_ref.options[i].text,value:display_columns_ref.options[i].value};}}
for(i=0;i<hidden_columns_ref.options.length;i++)
{notselected_right[notselected_right.length]={text:hidden_columns_ref.options[i].text,value:hidden_columns_ref.options[i].value};}
var left_select_html_info=new Object();var left_options=new Array();var left_select=new Object();left_select['name']=left_name+'[]';left_select['id']=left_name;left_select['size']=left_size;left_select['multiple']='true';var right_select_html_info=new Object();var right_options=new Array();var right_select=new Object();right_select['name']=right_name+'[]';right_select['id']=right_name;right_select['size']=right_size;right_select['multiple']='true';for(i=0;i<notselected_right.length;i++){right_options[right_options.length]=notselected_right[i];}
for(i=0;i<selected_left.length;i++){right_options[right_options.length]=selected_left[i];}
for(i=0;i<notselected_left.length;i++){left_options[left_options.length]=notselected_left[i];}
left_select_html_info['options']=left_options;left_select_html_info['select']=left_select;right_select_html_info['options']=right_options;right_select_html_info['select']=right_select;right_select_html_info['style']='background: lightgrey';var left_html=this.buildSelectHTML(left_select_html_info);var right_html=this.buildSelectHTML(right_select_html_info);left_td.innerHTML=left_html;right_td.innerHTML=right_html;object_refs[left_name]=left_td.getElementsByTagName('select')[0];object_refs[right_name]=right_td.getElementsByTagName('select')[0];this.movementCallback(object_refs[left_name],object_refs[right_name]);return false;},right_to_left:function(left_name,right_name,left_size,right_size,max_left){SUGAR.savedViews.clearColumns=false;var left_td=document.getElementById(left_name+'_td');var right_td=document.getElementById(right_name+'_td');var display_columns_ref=left_td.getElementsByTagName('select')[0];var hidden_columns_ref=right_td.getElementsByTagName('select')[0];var selected_right=new Array();var notselected_right=new Array();var notselected_left=new Array();var frozen_options=SUGAR.tabChooser.frozenOptions;frozen_options=SUGAR.tabChooser.frozenOptions&&SUGAR.tabChooser.frozenOptions[right_name]&&SUGAR.tabChooser.frozenOptions[right_name][left_name]?SUGAR.tabChooser.frozenOptions[right_name][left_name]:[];for(i=0;i<hidden_columns_ref.options.length;i++)
{if(hidden_columns_ref.options[i].selected==true&&!frozen_options[hidden_columns_ref.options[i].value])
{selected_right[selected_right.length]={text:hidden_columns_ref.options[i].text,value:hidden_columns_ref.options[i].value};}
else
{notselected_right[notselected_right.length]={text:hidden_columns_ref.options[i].text,value:hidden_columns_ref.options[i].value};}}
if(max_left!=''&&(display_columns_ref.length+selected_right.length)>max_left){alert('Maximum of '+max_left+' columns can be displayed.');return;}
for(i=0;i<display_columns_ref.options.length;i++)
{notselected_left[notselected_left.length]={text:display_columns_ref.options[i].text,value:display_columns_ref.options[i].value};}
var left_select_html_info=new Object();var left_options=new Array();var left_select=new Object();left_select['name']=left_name+'[]';left_select['id']=left_name;left_select['multiple']='true';left_select['size']=left_size;var right_select_html_info=new Object();var right_options=new Array();var right_select=new Object();right_select['name']=right_name+'[]';right_select['id']=right_name;right_select['multiple']='true';right_select['size']=right_size;for(i=0;i<notselected_left.length;i++){left_options[left_options.length]=notselected_left[i];}
for(i=0;i<selected_right.length;i++){left_options[left_options.length]=selected_right[i];}
for(i=0;i<notselected_right.length;i++){right_options[right_options.length]=notselected_right[i];}
left_select_html_info['options']=left_options;left_select_html_info['select']=left_select;right_select_html_info['options']=right_options;right_select_html_info['select']=right_select;right_select_html_info['style']='background: lightgrey';var left_html=this.buildSelectHTML(left_select_html_info);var right_html=this.buildSelectHTML(right_select_html_info);left_td.innerHTML=left_html;right_td.innerHTML=right_html;object_refs[left_name]=left_td.getElementsByTagName('select')[0];object_refs[right_name]=right_td.getElementsByTagName('select')[0];this.movementCallback(object_refs[left_name],object_refs[right_name]);return false;},up:function(name,left_name,right_name){SUGAR.savedViews.clearColumns=false;var left_td=document.getElementById(left_name+'_td');var right_td=document.getElementById(right_name+'_td');var td=document.getElementById(name+'_td');var obj=td.getElementsByTagName('select')[0];obj=(typeof obj=="string")?document.getElementById(obj):obj;if(obj.tagName.toLowerCase()!="select"&&obj.length<2)
return false;var sel=new Array();for(i=0;i<obj.length;i++){if(obj[i].selected==true){sel[sel.length]=i;}}
for(i=0;i<sel.length;i++){if(sel[i]!=0&&!obj[sel[i]-1].selected){var tmp=new Array(obj[sel[i]-1].text,obj[sel[i]-1].value);obj[sel[i]-1].text=obj[sel[i]].text;obj[sel[i]-1].value=obj[sel[i]].value;obj[sel[i]].text=tmp[0];obj[sel[i]].value=tmp[1];obj[sel[i]-1].selected=true;obj[sel[i]].selected=false;}}
object_refs[left_name]=left_td.getElementsByTagName('select')[0];object_refs[right_name]=right_td.getElementsByTagName('select')[0];this.orderCallback(object_refs[left_name],object_refs[right_name]);return false;},down:function(name,left_name,right_name){SUGAR.savedViews.clearColumns=false;var left_td=document.getElementById(left_name+'_td');var right_td=document.getElementById(right_name+'_td');var td=document.getElementById(name+'_td');var obj=td.getElementsByTagName('select')[0];if(obj.tagName.toLowerCase()!="select"&&obj.length<2)
return false;var sel=new Array();for(i=obj.length-1;i>-1;i--){if(obj[i].selected==true){sel[sel.length]=i;}}
for(i=0;i<sel.length;i++){if(sel[i]!=obj.length-1&&!obj[sel[i]+1].selected){var tmp=new Array(obj[sel[i]+1].text,obj[sel[i]+1].value);obj[sel[i]+1].text=obj[sel[i]].text;obj[sel[i]+1].value=obj[sel[i]].value;obj[sel[i]].text=tmp[0];obj[sel[i]].value=tmp[1];obj[sel[i]+1].selected=true;obj[sel[i]].selected=false;}}
object_refs[left_name]=left_td.getElementsByTagName('select')[0];object_refs[right_name]=right_td.getElementsByTagName('select')[0];this.orderCallback(object_refs[left_name],object_refs[right_name]);return false;}};}();SUGAR.language=function(){return{languages:new Array(),setLanguage:function(module,data){if(!SUGAR.language.languages){}
SUGAR.language.languages[module]=data;},get:function(module,str){if(typeof SUGAR.language.languages[module]=='undefined'||typeof SUGAR.language.languages[module][str]=='undefined')
{return'undefined';}
return SUGAR.language.languages[module][str];},translate:function(module,str)
{text=this.get(module,str);return text!='undefined'?text:this.get('app_strings',str);}}}();SUGAR.contextMenu=function(){return{objects:new Object(),objectTypes:new Object(),registerObject:function(objectType,id,metaData){SUGAR.contextMenu.objects[id]=new Object();SUGAR.contextMenu.objects[id]={'objectType':objectType,'metaData':metaData};},registerObjectType:function(name,menuItems){SUGAR.contextMenu.objectTypes[name]=new Object();SUGAR.contextMenu.objectTypes[name]={'menuItems':menuItems,'objects':new Array()};},getListItemFromEventTarget:function(p_oNode){var oLI;if(p_oNode.tagName=="LI"){oLI=p_oNode;}
else{do{if(p_oNode.tagName=="LI"){oLI=p_oNode;break;}}while((p_oNode=p_oNode.parentNode));}
return oLI;},onContextMenuMove:function(){var oNode=this.contextEventTarget;var bDisabled=(oNode.tagName=="UL");var i=this.getItemGroups()[0].length-1;do{this.getItem(i).cfg.setProperty("disabled",bDisabled);}
while(i--);},onContextMenuItemClick:function(p_sType,p_aArguments,p_oItem){var oLI=SUGAR.contextMenu.getListItemFromEventTarget(this.parent.contextEventTarget);id=this.parent.contextEventTarget.parentNode.id;funct=eval(SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[id]['objectType']]['menuItems'][this.index]['action']);funct(this.parent.contextEventTarget,SUGAR.contextMenu.objects[id]['metaData']);},init:function(){for(var i in SUGAR.contextMenu.objects){if(typeof SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[i]['objectType']]['objects']=='undefined')
SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[i]['objectType']]['objects']=new Array();SUGAR.contextMenu.objectTypes[SUGAR.contextMenu.objects[i]['objectType']]['objects'].push(document.getElementById(i));}
for(var i in SUGAR.contextMenu.objectTypes){var oContextMenu=new YAHOO.widget.ContextMenu(i,{'trigger':SUGAR.contextMenu.objectTypes[i]['objects']});var aMainMenuItems=SUGAR.contextMenu.objectTypes[i]['menuItems'];var nMainMenuItems=aMainMenuItems.length;var oMenuItem;for(var j=0;j<nMainMenuItems;j++){oMenuItem=new YAHOO.widget.ContextMenuItem(aMainMenuItems[j].text,{helptext:aMainMenuItems[j].helptext});oMenuItem.clickEvent.subscribe(SUGAR.contextMenu.onContextMenuItemClick,oMenuItem,true);oContextMenu.addItem(oMenuItem);}
oContextMenu.moveEvent.subscribe(SUGAR.contextMenu.onContextMenuMove,oContextMenu,true);oContextMenu.keyDownEvent.subscribe(SUGAR.contextMenu.onContextMenuItemClick,oContextMenu,true);oContextMenu.render(document.body);}}};}();SUGAR.contextMenu.actions=function(){return{createNote:function(itemClicked,metaData){loc='index.php?module=Notes&action=EditView';for(i in metaData){if(i=='notes_parent_type')loc+='&parent_type='+metaData[i];else if(i!='module'&&i!='parent_type')loc+='&'+i+'='+metaData[i];}
document.location=loc;},scheduleMeeting:function(itemClicked,metaData){loc='index.php?module=Meetings&action=EditView';for(i in metaData){if(i!='module')loc+='&'+i+'='+metaData[i];}
document.location=loc;},scheduleCall:function(itemClicked,metaData){loc='index.php?module=Calls&action=EditView';for(i in metaData){if(i!='module')loc+='&'+i+'='+metaData[i];}
document.location=loc;},createContact:function(itemClicked,metaData){loc='index.php?module=Contacts&action=EditView';for(i in metaData){if(i!='module')loc+='&'+i+'='+metaData[i];}
document.location=loc;},createTask:function(itemClicked,metaData){loc='index.php?module=Tasks&action=EditView';for(i in metaData){if(i!='module')loc+='&'+i+'='+metaData[i];}
document.location=loc;},createOpportunity:function(itemClicked,metaData){loc='index.php?module=Opportunities&action=EditView';for(i in metaData){if(i!='module')loc+='&'+i+'='+metaData[i];}
document.location=loc;},createCase:function(itemClicked,metaData){loc='index.php?module=Cases&action=EditView';for(i in metaData){if(i!='module')loc+='&'+i+'='+metaData[i];}
document.location=loc;},addToFavorites:function(itemClicked,metaData){success=function(data){}
var cObj=YAHOO.util.Connect.asyncRequest('GET','index.php?to_pdf=true&module=Home&action=AddToFavorites&target_id='+metaData['id']+'&target_module='+metaData['module'],{success:success,failure:success});}};}();var popup_request_data;var close_popup;function get_popup_request_data()
{return YAHOO.lang.JSON.stringify(window.document.popup_request_data);}
function get_close_popup()
{return window.document.close_popup;}
function open_popup(module_name,width,height,initial_filter,close_popup,hide_clear_button,popup_request_data,popup_mode,create,metadata)
{if(typeof(popupCount)=="undefined"||popupCount==0)
popupCount=1;window.document.popup_request_data=popup_request_data;window.document.close_popup=close_popup;width=(width==600)?800:width;height=(height==400)?800:height;URL='index.php?'
+'module='+module_name
+'&action=Popup';if(initial_filter!=''){URL+='&query=true'+initial_filter;popupName=initial_filter.replace(/[^a-z_0-9]+/ig,'_');windowName=module_name+'_popup_window'+popupName;}else{windowName=module_name+'_popup_window'+popupCount;}
popupCount++;if(hide_clear_button){URL+='&hide_clear_button=true';}
windowFeatures='width='+width
+',height='+height
+',resizable=1,scrollbars=1';if(popup_mode==''&&popup_mode=='undefined'){popup_mode='single';}
URL+='&mode='+popup_mode;if(create==''&&create=='undefined'){create='false';}
URL+='&create='+create;if(metadata!=''&&metadata!='undefined'){URL+='&metadata='+metadata;}
win=SUGAR.util.openWindow(URL,windowName,windowFeatures);if(window.focus)
{win.focus();}
win.popupCount=popupCount;return win;}
var from_popup_return=false;function set_return_basic(popup_reply_data,filter)
{var form_name=popup_reply_data.form_name;var name_to_value_array=popup_reply_data.name_to_value_array;for(var the_key in name_to_value_array)
{if(the_key=='toJSON')
{}
else if(the_key.match(filter))
{var displayValue=name_to_value_array[the_key].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');;if(window.document.forms[form_name]&&window.document.forms[form_name].elements[the_key]){if(window.document.forms[form_name].elements[the_key].tagName=='SELECT'){var selectField=window.document.forms[form_name].elements[the_key];for(var i=0;i<selectField.options.length;i++){if(selectField.options[i].text==displayValue){selectField.options[i].selected=true;SUGAR.util.callOnChangeListers(selectField);break;}}}else{window.document.forms[form_name].elements[the_key].value=displayValue;SUGAR.util.callOnChangeListers(window.document.forms[form_name].elements[the_key]);}}}}}
function set_return(popup_reply_data)
{from_popup_return=true;var form_name=popup_reply_data.form_name;var name_to_value_array=popup_reply_data.name_to_value_array;if(typeof name_to_value_array!='undefined'&&name_to_value_array['account_id'])
{var label_str='';var label_data_str='';var current_label_data_str='';for(var the_key in name_to_value_array)
{if(the_key=='toJSON')
{}
else
{var displayValue=name_to_value_array[the_key].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');if(window.document.forms[form_name]&&document.getElementById(the_key+'_label')&&!the_key.match(/account/)){var data_label=document.getElementById(the_key+'_label').innerHTML.replace(/\n/gi,'');label_str+=data_label+' \n';label_data_str+=data_label+' '+displayValue+'\n';if(window.document.forms[form_name].elements[the_key]){current_label_data_str+=data_label+' '+window.document.forms[form_name].elements[the_key].value+'\n';}}}}
if(label_data_str!=label_str&&current_label_data_str!=label_str){if(confirm(SUGAR.language.get('app_strings','NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM')+'\n\n'+label_data_str))
{set_return_basic(popup_reply_data,/\S/);}else{set_return_basic(popup_reply_data,/account/);}}else if(label_data_str!=label_str&&current_label_data_str==label_str){set_return_basic(popup_reply_data,/\S/);}else if(label_data_str==label_str){set_return_basic(popup_reply_data,/account/);}}else{set_return_basic(popup_reply_data,/\S/);}}
function set_return_lead_conv(popup_reply_data){set_return(popup_reply_data);if(document.getElementById('lead_conv_ac_op_sel')&&typeof onBlurKeyUpHandler=='function'){onBlurKeyUpHandler();}}
function set_return_and_save(popup_reply_data)
{var form_name=popup_reply_data.form_name;var name_to_value_array=popup_reply_data.name_to_value_array;for(var the_key in name_to_value_array)
{if(the_key=='toJSON')
{}
else
{window.document.forms[form_name].elements[the_key].value=name_to_value_array[the_key];}}
window.document.forms[form_name].return_module.value=window.document.forms[form_name].module.value;window.document.forms[form_name].return_action.value='DetailView';window.document.forms[form_name].return_id.value=window.document.forms[form_name].record.value;window.document.forms[form_name].action.value='Save';window.document.forms[form_name].submit();}
function get_initial_filter_by_account(form_name)
{var account_id=window.document.forms[form_name].account_id.value;var account_name=escape(window.document.forms[form_name].account_name.value);var initial_filter="&account_id="+account_id+"&account_name="+account_name;return initial_filter;}
function copyAddress(form,fromKey,toKey){var elems=new Array("address_street","address_city","address_state","address_postalcode","address_country");var checkbox=document.getElementById(toKey+"_checkbox");if(typeof checkbox!="undefined"){if(!checkbox.checked){for(x in elems){t=toKey+"_"+elems[x];document.getElementById(t).removeAttribute('readonly');}}else{for(x in elems){f=fromKey+"_"+elems[x];t=toKey+"_"+elems[x];document.getElementById(t).value=document.getElementById(f).value;document.getElementById(t).setAttribute('readonly',true);}}}
return true;}
function check_deletable_EmailTemplate(){id=document.getElementsByName('record')[0].value;currentForm=document.getElementById('form');var call_back={success:function(r){if(r.responseText=='true'){if(!confirm(SUGAR.language.get('app_strings','NTC_TEMPLATE_IS_USED'))){return false;}}else{if(!confirm(SUGAR.language.get('app_strings','NTC_DELETE_CONFIRMATION'))){return false;}}
currentForm.return_module.value='EmailTemplates';currentForm.return_action.value='ListView';currentForm.action.value='Delete';currentForm.submit();}};url="index.php?module=EmailTemplates&action=CheckDeletable&from=DetailView&to_pdf=1&record="+id;YAHOO.util.Connect.asyncRequest('POST',url,call_back,null);}
SUGAR.image={remove_upload_imagefile:function(field_name){var field=document.getElementById('remove_imagefile_'+field_name);field.value=1;var field=document.getElementById(field_name);field.style.display="";var field=document.getElementById('img_'+field_name);field.style.display="none";var field=document.getElementById('bt_remove_'+field_name);field.style.display="none";if(document.getElementById(field_name+'_duplicate')){var field=document.getElementById(field_name+'_duplicate');field.value="";}},confirm_imagefile:function(field_name){var field=document.getElementById(field_name);var filename=field.value;var fileExtension=filename.substring(filename.lastIndexOf(".")+1);fileExtension=fileExtension.toLowerCase();if(fileExtension=="jpg"||fileExtension=="jpeg"||fileExtension=="gif"||fileExtension=="png"||fileExtension=="bmp"){}
else{field.value=null;alert(SUGAR.language.get('app_strings','LBL_UPLOAD_IMAGE_FILE_INVALID'));}},lightbox:function(image)
{if(typeof(SUGAR.image.lighboxWindow)=="undefined")
SUGAR.image.lighboxWindow=new YAHOO.widget.SimpleDialog('sugarImageViewer',{type:'message',modal:true,id:'sugarMsgWindow',close:true,title:"Alert",msg:"<img src='"+image+"'> </img>",buttons:[]});SUGAR.image.lighboxWindow.setBody("<img src='"+image+"'> </img>");SUGAR.image.lighboxWindow.render(document.body);SUGAR.image.lighboxWindow.show();SUGAR.image.lighboxWindow.center()}}
SUGAR.append(SUGAR.util,{isTouchScreen:function(){if(Get_Cookie("touchscreen")=='1'){return true;}
if((navigator.userAgent.match(/iPad/i)!=null)){return true;}
return false;},isLoginPage:function(content){if(SUGAR.util.isPackageManager()){return false;}
var loginPageStart="<!DOCTYPE";if(content.substr(0,loginPageStart.length)==loginPageStart&&content.indexOf("<html>")!=-1&&content.indexOf("login_module")!=-1){window.location.href=window.location.protocol+window.location.pathname;return true;}},isPackageManager:function(){if(typeof(document.the_form)!='undefined'&&typeof(document.the_form.language_pack_escaped)!='undefined'){return true;}else{return false;}},ajaxCallInProgress:function(){var t=true;if(typeof(send_back)!="function"){var c=document.getElementById("content");if(!c)return true;t=YAHOO.lang.trim(SUGAR.util.innerText(c));}
return SUGAR_callsInProgress!=0||t=="";},innerText:function(el){if(el.tagName=="SCRIPT")
return"";if(typeof(el.innerText)=="string")
return el.innerText;var t="";for(var i in el.childNodes){var c=el.childNodes[i];if(typeof(c)!="object")
continue;if(typeof(c.nodeName)=="string"&&c.nodeName=="#text")
t+=c.nodeValue;else
t+=SUGAR.util.innerText(c);}
return t;},callOnChangeListers:function(field){var listeners=YAHOO.util.Event.getListeners(field,'change');if(listeners!=null){for(var i=0;i<listeners.length;i++){var l=listeners[i];l.fn.call(l.scope?l.scope:this,l.obj);}}},closeActivityPanel:{show:function(module,id,new_status,viewType,parentContainerId){if(SUGAR.util.closeActivityPanel.panel)
SUGAR.util.closeActivityPanel.panel.destroy();var singleModule=SUGAR.language.get("app_list_strings","moduleListSingular")[module];singleModule=typeof(singleModule!='undefined')?singleModule.toLowerCase():'';var closeText=SUGAR.language.get("app_strings","LBL_CLOSE_ACTIVITY_CONFIRM").replace("#module#",singleModule);SUGAR.util.closeActivityPanel.panel=new YAHOO.widget.SimpleDialog("closeActivityDialog",{width:"300px",fixedcenter:true,visible:false,draggable:false,close:true,text:closeText,constraintoviewport:true,buttons:[{text:SUGAR.language.get("app_strings","LBL_EMAIL_OK"),handler:function(){if(SUGAR.util.closeActivityPanel.panel)
SUGAR.util.closeActivityPanel.panel.hide();ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_SAVING'));var args="action=save&id="+id+"&record="+id+"&status="+new_status+"&module="+module;var callback={success:function(o)
{window.setTimeout("window.location.reload(true);",0);},argument:{'parentContainerId':parentContainerId}};YAHOO.util.Connect.asyncRequest('POST','index.php',callback,args);},isDefault:true},{text:SUGAR.language.get("app_strings","LBL_EMAIL_CANCEL"),handler:function(){SUGAR.util.closeActivityPanel.panel.hide();}}]});SUGAR.util.closeActivityPanel.panel.setHeader(SUGAR.language.get("app_strings","LBL_CLOSE_ACTIVITY_HEADER"));SUGAR.util.closeActivityPanel.panel.render(document.body);SUGAR.util.closeActivityPanel.panel.show();}},setEmailPasswordDisplay:function(id,exists){link=document.getElementById(id+'_link');pwd=document.getElementById(id);if(!pwd||!link)return;if(exists){pwd.style.display='none';link.style.display='';}else{pwd.style.display='';link.style.display='none';}},setEmailPasswordEdit:function(id){link=document.getElementById(id+'_link');pwd=document.getElementById(id);if(!pwd||!link)return;pwd.style.display='';link.style.display='none';},validateFileExt:function(fileName,allowedTypes){var ext=fileName.split('.').pop().toLowerCase();for(var i=allowedTypes.length;i>=0;i--){if(ext===allowedTypes[i]){return true;}}
return false;},arrayIndexOf:function(arr,val,start){if(typeof arr.indexOf=="function")
return arr.indexOf(val,start);for(var i=(start||0),j=arr.length;i<j;i++){if(arr[i]===val){return i;}}
return-1;}});SUGAR.clearRelateField=function(form,name,id)
{if(typeof form[name]=="object"){form[name].value='';SUGAR.util.callOnChangeListers(form[name]);}
if(typeof form[id]=="object"){form[id].value='';SUGAR.util.callOnChangeListers(form[id]);}};if(typeof(SUGAR.AutoComplete)=='undefined')SUGAR.AutoComplete={};SUGAR.AutoComplete.getOptionsArray=function(options_index){var return_arr=[];var opts=SUGAR.language.get('app_list_strings',options_index);if(typeof(opts)!='undefined'){for(key in opts){if(key!=''&&opts[key]!=''){var item=[];item['key']=key;item['text']=opts[key];return_arr.push(item);}}}
return return_arr;}
if(typeof(SUGAR.MultiEnumAutoComplete)=='undefined')SUGAR.MultiEnumAutoComplete={};SUGAR.MultiEnumAutoComplete.getMultiSelectKeysFromValues=function(options_index,val_string){var opts=SUGAR.language.get('app_list_strings',options_index);var selected_values=val_string.split(", ");if(selected_values.length>0&&selected_values.indexOf('')==selected_values.length-1){selected_values.pop();}
var final_arr=new Array();for(idx in selected_values){for(o_idx in opts){if(selected_values[idx]==opts[o_idx]){final_arr.push(o_idx);}}}
return final_arr;}
SUGAR.MultiEnumAutoComplete.getMultiSelectValuesFromKeys=function(options_index,val_string){var opts=SUGAR.language.get('app_list_strings',options_index);val_string=val_string.replace(/^\^/,'').replace(/\^$/,'')
var selected_values=val_string.split("^,^");if(selected_values.length>0&&selected_values.indexOf('')==selected_values.length-1){selected_values.pop();}
var final_arr=new Array();for(idx in selected_values){for(o_idx in opts){if(selected_values[idx]==o_idx){final_arr.push(opts[o_idx]);}}}
return final_arr;}
// End of File include/javascript/sugar_3.js
                                
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
SUGAR.ajaxUI={loadingWindow:false,callback:function(o)
{var cont;if(typeof window.onbeforeunload=="function")
window.onbeforeunload=null;scroll(0,0);SUGAR.ajaxUI.hideLoadingPanel();try{var r=YAHOO.lang.JSON.parse(o.responseText);cont=r.content;if(r.moduleList)
{SUGAR.themes.setModuleTabs(r.moduleList);}
if(r.title)
{document.title=html_entity_decode(r.title);}
if(r.action)
{action_sugar_grp1=r.action;}
var c=document.getElementById("content");c.innerHTML=cont;SUGAR.util.evalScript(cont);if(typeof(r.responseTime)!='undefined'){var rt=document.getElementById('responseTime');if(rt!=null){rt.innerHTML=r.responseTime;}}}catch(e){SUGAR.ajaxUI.showErrorMessage(o.responseText);}},showErrorMessage:function(errorMessage)
{if(!SUGAR.ajaxUI.errorPanel){SUGAR.ajaxUI.errorPanel=new YAHOO.widget.Panel("ajaxUIErrorPanel",{modal:false,visible:true,constraintoviewport:true,width:"800px",height:"600px",close:true});}
var panel=SUGAR.ajaxUI.errorPanel;panel.setHeader(SUGAR.language.get('app_strings','ERR_AJAX_LOAD'));panel.setBody('<iframe id="ajaxErrorFrame" style="width:780px;height:550px;border:none;marginheight="0" marginwidth="0" frameborder="0""></iframe>');panel.setFooter(SUGAR.language.get('app_strings','ERR_AJAX_LOAD_FOOTER'));panel.render(document.body);SUGAR.util.doWhen(function(){var f=document.getElementById("ajaxErrorFrame");return f!=null&&f.contentWindow!=null&&f.contentWindow.document!=null;},function(){document.getElementById("ajaxErrorFrame").contentWindow.document.body.innerHTML=errorMessage;window.setTimeout('throw "AjaxUI error parsing response"',300);});panel.show();panel.center();throw"AjaxUI error parsing response";},canAjaxLoadModule:function(module)
{if(typeof(SUGAR.config.disableAjaxUI)!='undefined'&&SUGAR.config.disableAjaxUI==true){return false;}
var bannedModules=SUGAR.config.stockAjaxBannedModules;if(typeof(bannedModules)=='undefined')
return false;if(typeof(SUGAR.config.addAjaxBannedModules)!='undefined'){bannedModules.concat(SUGAR.config.addAjaxBannedModules);}
if(typeof(SUGAR.config.overrideAjaxBannedModules)!='undefined'){bannedModules=SUGAR.config.overrideAjaxBannedModules;}
return SUGAR.util.arrayIndexOf(bannedModules,module)==-1;},loadContent:function(url,params)
{if(YAHOO.lang.trim(url)!="")
{var mRegex=/module=([^&]*)/.exec(url);var module=mRegex?mRegex[1]:false;if(module&&SUGAR.ajaxUI.canAjaxLoadModule(module))
{YAHOO.util.History.navigate('ajaxUILoc',url);}else{window.location=url;}}},go:function(url)
{if(YAHOO.lang.trim(url)!="")
{var con=YAHOO.util.Connect,ui=SUGAR.ajaxUI;if(ui.lastURL==url)
return;var inAjaxUI=/action=ajaxui/.exec(window.location);if(typeof(window.onbeforeunload)=="function"&&window.onbeforeunload())
{if(!confirm(window.onbeforeunload()))
{if(!inAjaxUI)
{window.location.hash="";}
else
{YAHOO.util.History.navigate('ajaxUILoc',ui.lastURL);}
return;}
window.onbeforeunload=null;}
if(ui.lastCall&&con.isCallInProgress(ui.lastCall)){con.abort(ui.lastCall);}
var mRegex=/module=([^&]*)/.exec(url);var module=mRegex?mRegex[1]:false;if(!ui.canAjaxLoadModule(module)){window.location=url;return;}
ui.lastURL=url;ui.cleanGlobals();var loadLanguageJS='';if(module&&typeof(SUGAR.language.languages[module])=='undefined'){loadLanguageJS='&loadLanguageJS=1';}
if(!inAjaxUI){if(!SUGAR.isIE)
window.location.replace("index.php?action=ajaxui#ajaxUILoc="+encodeURIComponent(url));else{window.location.hash="#";window.location.assign("index.php?action=ajaxui#ajaxUILoc="+encodeURIComponent(url));}}
else{SUGAR.ajaxUI.showLoadingPanel();ui.lastCall=YAHOO.util.Connect.asyncRequest('GET',url+'&ajax_load=1'+loadLanguageJS,{success:SUGAR.ajaxUI.callback,failure:function(){SUGAR.ajaxUI.hideLoadingPanel();SUGAR.ajaxUI.showErrorMessage(SUGAR.language.get('app_strings','ERR_AJAX_LOAD_FAILURE'));}});}}},submitForm:function(formname,params)
{var con=YAHOO.util.Connect,SA=SUGAR.ajaxUI;if(SA.lastCall&&con.isCallInProgress(SA.lastCall)){con.abort(SA.lastCall);}
SA.cleanGlobals();var form=YAHOO.util.Dom.get(formname)||document.forms[formname];if(SA.canAjaxLoadModule(form.module.value)&&typeof(YAHOO.util.Selector.query("input[type=file]",form)[0])=="undefined"&&/action=ajaxui/.exec(window.location))
{var string=con.setForm(form);var baseUrl="index.php?action=ajaxui#ajaxUILoc=";SA.lastURL="";if(string.length>200)
{SUGAR.ajaxUI.showLoadingPanel();form.onsubmit=function(){return true;};form.submit();}else{con.resetFormState();window.location=baseUrl+encodeURIComponent("index.php?"+string);}
return true;}else{form.submit();return false;}},cleanGlobals:function()
{sqs_objects={};QSProcessedFieldsArray={};collection={};if(SUGAR.EmailAddressWidget){SUGAR.EmailAddressWidget.instances={};SUGAR.EmailAddressWidget.count={};}
YAHOO.util.Event.removeListener(window,'resize');if(typeof(dialog)!='undefined'&&typeof(dialog.destroy)=='function'){dialog.destroy();delete dialog;}},firstLoad:function()
{var url=YAHOO.util.History.getBookmarkedState('ajaxUILoc');var aRegex=/action=([^&#]*)/.exec(window.location);var action=aRegex?aRegex[1]:false;var mRegex=/module=([^&#]*)/.exec(window.location);var module=mRegex?mRegex[1]:false;if(module!="ModuleBuilder")
{var go=url!=null||action=="ajaxui";url=url?url:'index.php?module=Home&action=index';YAHOO.util.History.register('ajaxUILoc',url,SUGAR.ajaxUI.go);YAHOO.util.History.initialize("ajaxUI-history-field","ajaxUI-history-iframe");SUGAR.ajaxUI.hist_loaded=true;if(go)
SUGAR.ajaxUI.go(url);}
SUGAR_callsInProgress--;},print:function()
{var url=YAHOO.util.History.getBookmarkedState('ajaxUILoc');SUGAR.util.openWindow(url+'&print=true','printwin','menubar=1,status=0,resizable=1,scrollbars=1,toolbar=0,location=1');},showLoadingPanel:function()
{if(!SUGAR.ajaxUI.loadingPanel)
{SUGAR.ajaxUI.loadingPanel=new YAHOO.widget.Panel("ajaxloading",{width:"240px",fixedcenter:true,close:false,draggable:false,constraintoviewport:false,modal:true,visible:false});SUGAR.ajaxUI.loadingPanel.setBody('<div id="loadingPage" align="center" style="vertical-align:middle;"><img src="'+SUGAR.themes.loading_image+'" align="absmiddle" /> <b>'+SUGAR.language.get('app_strings','LBL_LOADING_PAGE')+'</b></div>');SUGAR.ajaxUI.loadingPanel.render(document.body);}
if(document.getElementById('ajaxloading_c'))
document.getElementById('ajaxloading_c').style.display='';SUGAR.ajaxUI.loadingPanel.show();},hideLoadingPanel:function()
{SUGAR.ajaxUI.loadingPanel.hide();if(document.getElementById('ajaxloading_c'))
document.getElementById('ajaxloading_c').style.display='none';}};
// End of File include/javascript/ajaxUI.js
                                
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
function Get_Cookie(name){var start=document.cookie.indexOf(name+'=');var len=start+name.length+1;if((!start)&&(name!=document.cookie.substring(0,name.length)))
return null;if(start==-1)
return null;var end=document.cookie.indexOf(';',len);if(end==-1)end=document.cookie.length;if(end==start){return'';}
return unescape(document.cookie.substring(len,end));}
function Set_Cookie(name,value,expires,path,domain,secure)
{var today=new Date();today.setTime(today.getTime());if(expires)
{expires=expires*1000*60*60*24;}
var expires_date=new Date(today.getTime()+(expires));document.cookie=name+"="+escape(value)+
((expires)?";expires="+expires_date.toGMTString():"")+
((path)?";path="+path:"")+
((domain)?";domain="+domain:"")+
((secure)?";secure":"");}
function Delete_Cookie(name,path,domain){if(Get_Cookie(name))
document.cookie=name+'='+
((path)?';path='+path:'')+
((domain)?';domain='+domain:'')+';expires=Thu, 01-Jan-1970 00:00:01 GMT';}
function get_sub_cookies(cookie){var cookies=new Array();var end='';if(cookie&&cookie!=''){end=cookie.indexOf('#')
while(end>-1){var cur=cookie.substring(0,end);cookie=cookie.substring(end+1,cookie.length);var name=cur.substring(0,cur.indexOf('='));var value=cur.substring(cur.indexOf('=')+1,cur.length);cookies[name]=value;end=cookie.indexOf('#')}}
return cookies;}
function subs_to_cookie(cookies){var cookie='';for(var i in cookies)
{if(typeof(cookies[i])!="function"){cookie+=i+'='+cookies[i]+'#';}}
return cookie;}// End of File include/javascript/cookie.js
                                
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
var menuStack=new Array();var hiddenElmStack=new Array();var currentMenu=null;var closeMenusDelay=null;var openMenusDelay=null;var delayTime=75;function eraseTimeout(tId){window.clearTimeout(tId);return null;}
function tbButtonMouseOverOrig(id){closeMenusDelay=eraseTimeout(closeMenusDelay);var menuName=id.replace(/Handle/i,'Menu');var menu=getLayer(menuName);if(currentMenu){closeAllMenus();}
popupMenu(id,menu);}
function tbButtonMouseOver(id,top,left,leftOffset){closeMenusDelay=eraseTimeout(closeMenusDelay);if(openMenusDelay==null){openMenusDelay=window.setTimeout("showMenu('"+id+"','"+top+"','"+left+"','"+leftOffset+"')",delayTime);}}
function showMenu(id,top,left,leftOffset){openMenusDelay=eraseTimeout(openMenusDelay);var menuName=id.replace(/Handle/i,'Menu');var menu=getLayer(menuName);if(currentMenu){closeAllMenus();}
popupMenu(id,menu,top,left,leftOffset);}
function showSubMenu(id){closeMenusDelay=eraseTimeout(closeMenusDelay);var menuName=id.replace(/Handle/i,'Menu');var menu=getLayer(menuName);popupSubMenu(id,menu);}
function popupMenu(handleID,menu,top,left,leftOffset){var bw=checkBrowserWidth();var menuName=handleID.replace(/Handle/i,'Menu');var menuWidth=120;var imgWidth=document.getElementById(handleID).width;if(menu){var menuHandle=getLayer(handleID);var p=menuHandle;if(left==""){var left=0;while(p&&p.tagName.toUpperCase()!='BODY'){left+=p.offsetLeft;p=p.offsetParent;}
left+=parseInt(leftOffset);}
if(left+menuWidth>bw){left=left-menuWidth+imgWidth;}
setMenuVisible(menu,left,top,false);}}
function popupSubMenu(handleID,menu){if(menu){var menuHandle=getLayer(handleID);var p=menuHandle;var top=0,left=p.offsetWidth;while(p&&p.tagName.toUpperCase()!='BODY'){top+=p.offsetTop;left+=p.offsetLeft;p=p.offsetParent;}
if(is.ie&&is.mac){top-=3;left-=10;}
setMenuVisible(menu,left,top,true);}}
function closeMenusOrig(){if(currentMenu){setMenuVisibility(currentMenu,false);}}
function closeSubMenus(handle){closeMenusDelay=eraseTimeout(closeMenusDelay);if(menuStack.length>0){for(var i=menuStack.length-1;i>=0;i--){var menu=menuStack[menuStack.length-1];if(menu.id==handle.getAttribute('parentid')){currentMenu=menu;break;}else{closeMenu(menu);menuPop();}}}}
function closeMenu(menu){setMenuVisibility(menu,false);}
function closeMenusOrig(){if(menuStack.length>0){for(var i=menuStack.length-1;i>=0;i--){var menu=menuPop();closeMenu(menu);}}
currentMenu=null;}
function closeMenus(){if(closeMenusDelay==null){closeMenusDelay=window.setTimeout("closeAllMenus()",delayTime);}}
function closeAllMenus(){closeMenusDelay=eraseTimeout(closeMenusDelay);if(menuStack.length>0){for(var i=menuStack.length-1;i>=0;i--){var menu=menuPop();closeMenu(menu);}}
currentMenu=null;}
function setMenuVisible(menu,x,y,isSubMenu){if(menu){if(isSubMenu){if(menu.getAttribute('parentid')==currentMenu.getAttribute('parentid')){menuPop();setMenuVisibility(currentMenu,false);}}else{menuPop();setMenuVisibility(currentMenu,false);}
currentMenu=menu;menuPush(menu);setMenuVisibility(menu,true,x,y);}}
function getLayer(layerid){return document.getElementById(layerid);}
function setMenuVisibility(menu,on,x,y){var parent=menu;if(menu){setLayer(menu.id,!on,x,y);if(is.ie){if(!on){if(!menu.getAttribute('parentid')){showElement("SELECT");}}else{hideElement("SELECT",x,y,menu.offsetWidth,menu.offsetHeight);}}}}
function menuPop(){if(is.ie&&(is.mac||!is.ie5_5up)){var menu=menuStack[menuStack.length-1];var newMenuStack=new Array();for(var i=0;i<menuStack.length-1;i++){newMenuStack[newMenuStack.length]=menuStack[i];}
menuStack=newMenuStack;return menu;}else{return menuStack.pop();}}
function menuPush(menu){if(is.ie&&(is.mac||!is.ie5_5up)){menuStack[menuStack.length]=menu;}else{menuStack.push(menu);}}
function checkBrowserWidth(){var windowWidth;if(is.ie){windowWidth=document.body.clientWidth;}else{windowWidth=window.innerWidth-16;}
if(windowWidth>=1000){showSB('sbContent',true,'sb');}else{showSB('sbContent',false,'sb');}
return windowWidth;}
function showSB(id,hideit,imgIdPrefix){setLayer(id,!hideit,-1,-1);setLayer(imgIdPrefix+'On',!hideit,-1,-1);setLayer(imgIdPrefix+'Off',hideit,-1,-1);}
function setLayer(id,hidden,x,y){var layer=getLayer(id);setLayerElm(layer,hidden,x,y);}
function setLayerElm(layer,hideit,x,y){if(layer&&layer.style){if(hideit){layer.style.visibility='hidden';}else{layer.style.display='block';layer.style.visibility='visible';}
if(x>=0&&x!=""){layer.style.left=x+'px';}
if(y>=0&&y!=""){layer.style.top=y+'px';}}}
function hiliteItem(menuItem,changeClass){closeMenusDelay=eraseTimeout(closeMenusDelay);if(changeClass=='yes'){if(menuItem.getAttribute('avid')=='false'){menuItem.className='menuItemHiliteX';}else{menuItem.className='menuItemHilite';}}}
function unhiliteItem(menuItem){closeMenusDelay=eraseTimeout(closeMenusDelay);if(menuItem.getAttribute('avid')=='false'){menuItem.className='menuItemX';}else{menuItem.className='menuItem';}}
function showElement(elmID){for(i=0;i<document.getElementsByTagName(elmID).length;i++){obj=document.getElementsByTagName(elmID)[i];if(!obj||!obj.offsetParent)
continue;obj.style.visibility="";}}
function showElementNew(elmID){if(hiddenElmStack.length>0){for(var i=hiddenElmStack.length-1;i>=0;i--){var obj=hiddenElmStack[hiddenElmStack.length-1];obj.style.visibility="";;hiddenElmStack.pop();}}}
function hideElement(elmID,x,y,w,h){for(i=0;i<document.getElementsByTagName(elmID).length;i++){obj=document.getElementsByTagName(elmID)[i];if(!obj||!obj.offsetParent)
continue;objLeft=obj.offsetLeft;objTop=obj.offsetTop;objParent=obj.offsetParent;while(objParent.tagName.toUpperCase()!="BODY"){objLeft+=objParent.offsetLeft;objTop+=objParent.offsetTop;if(objParent.offsetParent==null)
break;else
objParent=objParent.offsetParent;}
objTop=objTop-y;if(x>(objLeft+obj.offsetWidth)||objLeft>(x+w));else if(objTop>h);else if((y+h)<=80);else{obj.style.visibility="hidden";}}}
function Is(){var agt=navigator.userAgent.toLowerCase();this.major=parseInt(navigator.appVersion);this.minor=parseFloat(navigator.appVersion);this.nav=((agt.indexOf('mozilla')!=-1)&&(agt.indexOf('spoofer')==-1)&&(agt.indexOf('compatible')==-1)&&(agt.indexOf('opera')==-1)&&(agt.indexOf('webtv')==-1)&&(agt.indexOf('hotjava')==-1));this.nav2=(this.nav&&(this.major==2));this.nav3=(this.nav&&(this.major==3));this.nav4=(this.nav&&(this.major==4));this.nav4up=(this.nav&&(this.major>=4));this.navonly=(this.nav&&((agt.indexOf(";nav")!=-1)||(agt.indexOf("; nav")!=-1)));this.nav6=(this.nav&&(this.major==5));this.nav6up=(this.nav&&(this.major>=5));this.gecko=(agt.indexOf('gecko')!=-1);this.nav7=(this.gecko&&(this.major>=5)&&(agt.indexOf('netscape/7')!=-1));this.moz1=false;this.moz1up=false;this.moz1_1=false;this.moz1_1up=false;if(this.nav6up){myRegEx=new RegExp("rv:\\d*.\\d*.\\d*");myFind=myRegEx.exec(agt);if(myFind!=null){var strVersion=myFind.toString();strVersion=strVersion.replace(/rv:/,'');var arrVersion=strVersion.split('.');var major=parseInt(arrVersion[0]);var minor=parseInt(arrVersion[1]);if(arrVersion[2])var revision=parseInt(arrVersion[2]);this.moz1=((major==1)&&(minor==0));this.moz1up=((major==1)&&(minor>=0));this.moz1_1=((major==1)&&(minor==1));this.moz1_1up=((major==1)&&(minor>=1));}}
this.ie=((agt.indexOf("msie")!=-1)&&(agt.indexOf("opera")==-1));this.ie3=(this.ie&&(this.major<4));this.ie4=(this.ie&&(this.major==4)&&(agt.indexOf("msie 4")!=-1));this.ie4up=(this.ie&&(this.major>=4));this.ie5=(this.ie&&(this.major==4)&&(agt.indexOf("msie 5.0")!=-1));this.ie5_5=(this.ie&&(this.major==4)&&(agt.indexOf("msie 5.5")!=-1));this.ie5up=(this.ie&&!this.ie3&&!this.ie4);this.ie5_5up=(this.ie&&!this.ie3&&!this.ie4&&!this.ie5);this.ie6=(this.ie&&(this.major==4)&&(agt.indexOf("msie 6.")!=-1));this.ie6up=(this.ie&&!this.ie3&&!this.ie4&&!this.ie5&&!this.ie5_5);this.mac=(agt.indexOf("mac")!=-1);}
function runPageLoadItems(){var myVar;checkBrowserWidth();}
var is=new Is();if(is.ie){document.write('<style type="text/css">');document.write('body {font-size: x-small;}');document.write('</style>');}// End of File include/javascript/menu.js
                                
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
Calendar=function(){};Calendar.getHighestZIndex=function(containerEl)
{var highestIndex=0;var currentIndex=0;var els=Array();els=containerEl?containerEl.getElementsByTagName('*'):document.getElementsByTagName('*');for(var i=0;i<els.length;i++)
{currentIndex=YAHOO.util.Dom.getStyle(els[i],"zIndex");if(!isNaN(currentIndex)&&currentIndex>highestIndex)
{highestIndex=parseInt(currentIndex);}}
return(highestIndex==Number.MAX_VALUE)?Number.MAX_VALUE:highestIndex+1;};Calendar.setup=function(params){YAHOO.util.Event.onDOMReady(function(){var Event=YAHOO.util.Event;var Dom=YAHOO.util.Dom;var dialog;var calendar;var showButton=params.button?params.button:params.buttonObj;var userDateFormat=params.ifFormat?params.ifFormat:(params.daFormat?params.daFormat:"m/d/Y");var inputField=params.inputField?params.inputField:params.inputFieldObj;var dateFormat=userDateFormat.substr(0,10);var date_field_delimiter=/([-.\\/])/.exec(dateFormat)[0];dateFormat=dateFormat.replace(/[^a-zA-Z]/g,'');var monthPos=dateFormat.search(/m/);var dayPos=dateFormat.search(/d/);var yearPos=dateFormat.search(/Y/);var dateParams=new Object();dateParams.delim=date_field_delimiter;dateParams.monthPos=monthPos;dateParams.dayPos=dayPos;dateParams.yearPos=yearPos;Event.on(Dom.get(showButton),"click",function(){if(!dialog){dialog=new YAHOO.widget.SimpleDialog("container_"+showButton,{visible:false,context:[showButton,"tl","bl"],buttons:[],draggable:false,close:true,zIndex:Calendar.getHighestZIndex(document.body)});dialog.setHeader(SUGAR.language.get('app_strings','LBL_MASSUPDATE_DATE'));var dialogBody='<p class="callnav_today"><a href="javascript:void(0)"  id="callnav_today">'+SUGAR.language.get('app_strings','LBL_EMAIL_DATE_TODAY')+'</a></p><div id="'+showButton+'_div"></div>';dialog.setBody(dialogBody);dialog.render(document.body);Dom.addClass("container_"+showButton,"cal_panel");Event.addListener("callnav_today","click",function(){calendar.clear();var now=new Date();Dom.get(inputField).value=formatSelectedDate(now);var cellIndex=calendar.getCellIndex(now);if(cellIndex>-1)
{var cell=calendar.cells[cellIndex];Dom.addClass(cell,calendar.Style.CSS_CELL_SELECTED);}
return false;});dialog.showEvent.subscribe(function(){if(YAHOO.env.ua.ie){dialog.fireEvent("changeContent");}});Event.on(document,"click",function(e){if(!dialog)
{return;}
var el=Event.getTarget(e);var dialogEl=dialog.element;if(el!=dialogEl&&!Dom.isAncestor(dialogEl,el)&&el!=Dom.get(showButton)&&!Dom.isAncestor(Dom.get(showButton),el)){dialog.hide();}});}
if(!calendar){var navConfig={strings:{month:SUGAR.language.get('app_strings','LBL_CHOOSE_MONTH'),year:SUGAR.language.get('app_strings','LBL_ENTER_YEAR'),submit:SUGAR.language.get('app_strings','LBL_EMAIL_OK'),cancel:SUGAR.language.get('app_strings','LBL_CANCEL_BUTTON_LABEL'),invalidYear:SUGAR.language.get('app_strings','LBL_ENTER_VALID_YEAR')},monthFormat:YAHOO.widget.Calendar.SHORT,initialFocus:"year"};calendar=new YAHOO.widget.Calendar(showButton+'_div',{iframe:false,hide_blank_weeks:true,navigator:navConfig});calendar.cfg.setProperty('DATE_FIELD_DELIMITER',date_field_delimiter);calendar.cfg.setProperty('MDY_DAY_POSITION',dayPos+1);calendar.cfg.setProperty('MDY_MONTH_POSITION',monthPos+1);calendar.cfg.setProperty('MDY_YEAR_POSITION',yearPos+1);if(typeof SUGAR.language.languages['app_list_strings']!='undefined'&&SUGAR.language.languages['app_list_strings']['dom_cal_month_long']!='undefined')
{if(SUGAR.language.languages['app_list_strings']['dom_cal_month_long'].length==13)
{SUGAR.language.languages['app_list_strings']['dom_cal_month_long'].shift();}
calendar.cfg.setProperty('MONTHS_LONG',SUGAR.language.languages['app_list_strings']['dom_cal_month_long']);}
if(typeof SUGAR.language.languages['app_list_strings']!='undefined'&&typeof SUGAR.language.languages['app_list_strings']['dom_cal_day_short']!='undefined')
{if(SUGAR.language.languages['app_list_strings']['dom_cal_day_short'].length==8)
{SUGAR.language.languages['app_list_strings']['dom_cal_day_short'].shift();}
calendar.cfg.setProperty('WEEKDAYS_SHORT',SUGAR.language.languages['app_list_strings']['dom_cal_day_short']);}
var formatSelectedDate=function(selDate)
{var monthVal=selDate.getMonth()+1;if(monthVal<10)
{monthVal='0'+monthVal;}
var dateVal=selDate.getDate();if(dateVal<10)
{dateVal='0'+dateVal;}
var yearVal=selDate.getFullYear();selDate='';if(monthPos==0)
{selDate=monthVal;}
else if(dayPos==0)
{selDate=dateVal;}
else
{selDate=yearVal;}
if(monthPos==1)
{selDate+=date_field_delimiter+monthVal;}
else if(dayPos==1)
{selDate+=date_field_delimiter+dateVal;}
else
{selDate+=date_field_delimiter+yearVal;}
if(monthPos==2)
{selDate+=date_field_delimiter+monthVal;}
else if(dayPos==2)
{selDate+=date_field_delimiter+dateVal;}
else
{selDate+=date_field_delimiter+yearVal;}
return selDate;};calendar.selectEvent.subscribe(function(){var input=Dom.get(inputField);if(calendar.getSelectedDates().length>0){input.value=formatSelectedDate(calendar.getSelectedDates()[0]);if(params.comboObject)
{params.comboObject.update();}}else{input.value="";}
if(input.onchange)
input.onchange();dialog.hide();SUGAR.util.callOnChangeListers(input);});calendar.renderEvent.subscribe(function(){dialog.fireEvent("changeContent");});}
var sanitizeDate=function(date,dateParams){var dateArray=Array();var returnArray=Array('','','');var delimArray=Array(".","/","-");var dateCheck=0;for(var delimCounter=0;delimCounter<delimArray.length;delimCounter++){dateArray=date.split(delimArray[delimCounter]);if(dateArray.length==3){break;}}
if(dateArray.length!=3)
{var oDate=new Date();var dateArray=[0,0,0];dateArray[dateParams.dayPos]=oDate.getDate();dateArray[dateParams.monthPos]=oDate.getMonth()+1;dateArray[dateParams.yearPos]=oDate.getFullYear();}
for(var i=0;i<dateArray.length;i++){if(dateArray[i]>32){returnArray[dateParams.yearPos]=dateArray[i];dateCheck+=1;}
else if(dateArray[i]<=12){if((dateParams.monthPos<dateParams.dayPos)&&(returnArray[dateParams.monthPos]=='')){returnArray[dateParams.monthPos]=dateArray[i];dateCheck+=100;}
else if((dateParams.monthPos>dateParams.dayPos)&&(returnArray[dateParams.dayPos]!='')){returnArray[dateParams.monthPos]=dateArray[i];dateCheck+=100;}
else if((dateParams.dayPos<dateParams.monthPos)&&(returnArray[dateParams.dayPos]=='')){returnArray[dateParams.dayPos]=dateArray[i];dateCheck+=10;}
else if((dateParams.dayPos>dateParams.monthPos)&&(returnArray[dateParams.monthPos]!='')){returnArray[dateParams.dayPos]=dateArray[i];dateCheck+=10;}}
else if(dateArray[i]>12&&dateArray[i]<32){if(returnArray[dateParams.dayPos]!=''){returnArray[dateParams.monthPos]=returnArray[dateParams.dayPos];dateCheck-=10;dateCheck+=100;}
returnArray[dateParams.dayPos]=dateArray[i];dateCheck+=10;}}
if(dateCheck!=111){return sanitizeDate("",dateParams);}
return returnArray.join(dateParams.delim);};var sanitizedDate=sanitizeDate(Dom.get(inputField).value,dateParams);var sanitizedDateArray=sanitizedDate.split(dateParams.delim);calendar.cfg.setProperty("selected",sanitizedDate);calendar.cfg.setProperty("pageDate",sanitizedDateArray[monthPos]+dateParams.delim+sanitizedDateArray[yearPos]);calendar.render();dialog.show();});});};
// End of File include/javascript/calendar.js
                                

(function(){var JSON=YAHOO.lang.JSON;SUGAR.quickCompose={};SUGAR.quickCompose=function(){return{parentPanel:null,dceMenuPanel:null,options:null,loadingMessgPanl:null,frameLoaded:false,resourcesLoaded:false,tinyLoaded:false,initComposePackage:function(c)
{SUGAR.email2.addressBook.initFixForDatatableSort();SUGAR.quickCompose.resourcesLoaded=true;var callback={success:function(o)
{var responseData=JSON.parse(o.responseText);var scriptTag=document.createElement('script');scriptTag.id='quickComposeScript';scriptTag.setAttribute('type','text/javascript');if(YAHOO.env.ua.ie>0)
scriptTag.text=responseData.jsData;else
scriptTag.appendChild(document.createTextNode(responseData.jsData));document.getElementsByTagName("head")[0].appendChild(scriptTag);var divTag=document.createElement("div");divTag.innerHTML=responseData.divData;divTag.id='quickCompose';YAHOO.util.Dom.insertBefore(divTag,'footer');SUGAR.quickCompose.frameLoaded=true;SUGAR.quickCompose.initUI(c.data);}}
if(!SUGAR.quickCompose.frameLoaded)
YAHOO.util.Connect.asyncRequest('GET','index.php?entryPoint=GenerateQuickComposeFrame',callback,null);else
SUGAR.quickCompose.initUI(c.data);},initUI:function(options)
{var SQ=SUGAR.quickCompose;this.options=options;loadingMessgPanl.hide();var dce_mode=(typeof this.dceMenuPanel!='undefined'&&this.dceMenuPanel!=null)?true:false;if(SQ.parentPanel!=null)
{tinyMCE.execCommand('mceRemoveControl',false,SUGAR.email2.tinyInstances.currentHtmleditor);SUGAR.email2.tinyInstances[SUGAR.email2.tinyInstances.currentHtmleditor]=null;SUGAR.email2.tinyInstances.currentHtmleditor="";SQ.parentPanel.destroy();SQ.parentPanel=null;}
var theme=SUGAR.themes.theme_name;var idx=0;if(!SE.composeLayout.composeTemplate)
SE.composeLayout.composeTemplate=new YAHOO.SUGAR.Template(SE.templates['compose']);var panel_modal=dce_mode?false:true,panel_width='880px',panel_constrain=dce_mode?false:true,panel_height=dce_mode?'auto':'400px',panel_shadow=dce_mode?false:true,panel_draggable=dce_mode?false:true,panel_resize=dce_mode?false:true,panel_close=dce_mode?false:true;SQ.parentPanel=new YAHOO.widget.Panel("container1",{modal:panel_modal,visible:true,constraintoviewport:panel_constrain,width:panel_width,height:panel_height,shadow:panel_shadow,draggable:panel_draggable,resize:panel_resize,close:panel_close});if(!dce_mode){SQ.parentPanel.setHeader(SUGAR.language.get('app_strings','LBL_EMAIL_QUICK_COMPOSE'));}
SQ.parentPanel.setBody("<div class='email'><div id='htmleditordiv"+idx+"'></div></div>");var composePanel=SE.composeLayout.getQuickComposeLayout(SQ.parentPanel,this.options);if(!dce_mode){var resize=new YAHOO.util.Resize('container1',{handles:['br'],autoRatio:false,minWidth:400,minHeight:350,status:false});resize.on('resize',function(args){var panelHeight=args.height;this.cfg.setProperty("height",panelHeight+"px");var layout=SE.composeLayout[SE.composeLayout.currentInstanceId];layout.set("height",panelHeight-50);layout.resize(true);SE.composeLayout.resizeEditor(SE.composeLayout.currentInstanceId);},SQ.parentPanel,true);}else{SUGAR.util.doWhen("typeof SE.composeLayout[SE.composeLayout.currentInstanceId] != 'undefined'",function(){var panelHeight=400;SQ.parentPanel.cfg.setProperty("height",panelHeight+"px");var layout=SE.composeLayout[SE.composeLayout.currentInstanceId];layout.set("height",panelHeight);layout.resize(true);SE.composeLayout.resizeEditor(SE.composeLayout.currentInstanceId);});}
YAHOO.util.Dom.setStyle("container1","z-index",1);if(!SQ.tinyLoaded)
{tinymce.dom.Event.domLoaded=true;tinyMCE.init({convert_urls:false,theme_advanced_toolbar_align:tinyConfig.theme_advanced_toolbar_align,width:tinyConfig.width,theme:tinyConfig.theme,theme_advanced_toolbar_location:tinyConfig.theme_advanced_toolbar_location,theme_advanced_buttons1:tinyConfig.theme_advanced_buttons1,theme_advanced_buttons2:tinyConfig.theme_advanced_buttons2,theme_advanced_buttons3:tinyConfig.theme_advanced_buttons3,plugins:tinyConfig.plugins,elements:tinyConfig.elements,language:tinyConfig.language,extended_valid_elements:tinyConfig.extended_valid_elements,mode:tinyConfig.mode,strict_loading_mode:true});SQ.tinyLoaded=true;}
SQ.parentPanel.show();SUGAR.email2.composeLayout.forceCloseCompose=function(o){SUGAR.quickCompose.parentPanel.hide();}
if(!dce_mode){SQ.parentPanel.center();}},init:function(o){if(typeof o.menu_id!='undefined'){this.dceMenuPanel=o.menu_id;}else{this.dceMenuPanel=null;}
loadingMessgPanl=new YAHOO.widget.SimpleDialog('loading',{width:'200px',close:true,modal:true,visible:true,fixedcenter:true,constraintoviewport:true,draggable:false});loadingMessgPanl.setHeader(SUGAR.language.get('app_strings','LBL_EMAIL_PERFORMING_TASK'));loadingMessgPanl.setBody(SUGAR.language.get('app_strings','LBL_EMAIL_ONE_MOMENT'));loadingMessgPanl.render(document.body);loadingMessgPanl.show();if(!SUGAR.quickCompose.resourcesLoaded)
this.loadResources(o);else
this.initUI(o);},loadResources:function(o)
{window.skipTinyMCEInitPhase=true;var require=["layout","element","tabview","menu","cookie","tinymce","sugarwidgets","sugarquickcompose","sugarquickcomposecss"];var loader=new YAHOO.util.YUILoader({require:require,loadOptional:true,skin:{base:'blank',defaultSkin:''},data:o,onSuccess:this.initComposePackage,allowRollup:true,base:"include/javascript/yui/build/"});loader.addModule({name:"tinymce",type:"js",varName:"TinyMCE",fullpath:"include/javascript/tiny_mce/tiny_mce.js"});loader.addModule({name:"sugarwidgets",type:"js",fullpath:"include/javascript/sugarwidgets/SugarYUIWidgets.js",varName:"YAHOO.SUGAR",requires:["datatable","dragdrop","treeview","tabview"]});loader.addModule({name:"sugarquickcompose",type:"js",varName:"SUGAR.email2.complexLayout",requires:["layout","sugarwidgets","tinymce"],fullpath:"include/javascript/sugar_grp_quickcomp.js"});loader.addModule({name:"sugarquickcomposecss",type:"css",fullpath:"modules/Emails/EmailUI.css"});loader.insert();}};}();})();
// End of File include/javascript/quickCompose.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
if(typeof YAHOO=="undefined"||!YAHOO){var YAHOO={};}YAHOO.namespace=function(){var b=arguments,g=null,e,c,f;for(e=0;e<b.length;e=e+1){f=(""+b[e]).split(".");g=YAHOO;for(c=(f[0]=="YAHOO")?1:0;c<f.length;c=c+1){g[f[c]]=g[f[c]]||{};g=g[f[c]];}}return g;};YAHOO.log=function(d,a,c){var b=YAHOO.widget.Logger;if(b&&b.log){return b.log(d,a,c);}else{return false;}};YAHOO.register=function(a,f,e){var k=YAHOO.env.modules,c,j,h,g,d;if(!k[a]){k[a]={versions:[],builds:[]};}c=k[a];j=e.version;h=e.build;g=YAHOO.env.listeners;c.name=a;c.version=j;c.build=h;c.versions.push(j);c.builds.push(h);c.mainClass=f;for(d=0;d<g.length;d=d+1){g[d](c);}if(f){f.VERSION=j;f.BUILD=h;}else{YAHOO.log("mainClass is undefined for module "+a,"warn");}};YAHOO.env=YAHOO.env||{modules:[],listeners:[]};YAHOO.env.getVersion=function(a){return YAHOO.env.modules[a]||null;};YAHOO.env.parseUA=function(d){var e=function(i){var j=0;return parseFloat(i.replace(/\./g,function(){return(j++==1)?"":".";}));},h=navigator,g={ie:0,opera:0,gecko:0,webkit:0,chrome:0,mobile:null,air:0,ipad:0,iphone:0,ipod:0,ios:null,android:0,webos:0,caja:h&&h.cajaVersion,secure:false,os:null},c=d||(navigator&&navigator.userAgent),f=window&&window.location,b=f&&f.href,a;g.secure=b&&(b.toLowerCase().indexOf("https")===0);if(c){if((/windows|win32/i).test(c)){g.os="windows";}else{if((/macintosh/i).test(c)){g.os="macintosh";}else{if((/rhino/i).test(c)){g.os="rhino";}}}if((/KHTML/).test(c)){g.webkit=1;}a=c.match(/AppleWebKit\/([^\s]*)/);if(a&&a[1]){g.webkit=e(a[1]);if(/ Mobile\//.test(c)){g.mobile="Apple";a=c.match(/OS ([^\s]*)/);if(a&&a[1]){a=e(a[1].replace("_","."));}g.ios=a;g.ipad=g.ipod=g.iphone=0;a=c.match(/iPad|iPod|iPhone/);if(a&&a[0]){g[a[0].toLowerCase()]=g.ios;}}else{a=c.match(/NokiaN[^\/]*|Android \d\.\d|webOS\/\d\.\d/);if(a){g.mobile=a[0];}if(/webOS/.test(c)){g.mobile="WebOS";a=c.match(/webOS\/([^\s]*);/);if(a&&a[1]){g.webos=e(a[1]);}}if(/ Android/.test(c)){g.mobile="Android";a=c.match(/Android ([^\s]*);/);if(a&&a[1]){g.android=e(a[1]);}}}a=c.match(/Chrome\/([^\s]*)/);if(a&&a[1]){g.chrome=e(a[1]);}else{a=c.match(/AdobeAIR\/([^\s]*)/);if(a){g.air=a[0];}}}if(!g.webkit){a=c.match(/Opera[\s\/]([^\s]*)/);if(a&&a[1]){g.opera=e(a[1]);a=c.match(/Version\/([^\s]*)/);if(a&&a[1]){g.opera=e(a[1]);}a=c.match(/Opera Mini[^;]*/);if(a){g.mobile=a[0];}}else{a=c.match(/MSIE\s([^;]*)/);if(a&&a[1]){g.ie=e(a[1]);}else{a=c.match(/Gecko\/([^\s]*)/);if(a){g.gecko=1;a=c.match(/rv:([^\s\)]*)/);if(a&&a[1]){g.gecko=e(a[1]);}}}}}}return g;};YAHOO.env.ua=YAHOO.env.parseUA();(function(){YAHOO.namespace("util","widget","example");if("undefined"!==typeof YAHOO_config){var b=YAHOO_config.listener,a=YAHOO.env.listeners,d=true,c;if(b){for(c=0;c<a.length;c++){if(a[c]==b){d=false;break;}}if(d){a.push(b);}}}})();YAHOO.lang=YAHOO.lang||{};(function(){var f=YAHOO.lang,a=Object.prototype,c="[object Array]",h="[object Function]",i="[object Object]",b=[],g={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","/":"&#x2F;","`":"&#x60;"},d=["toString","valueOf"],e={isArray:function(j){return a.toString.apply(j)===c;},isBoolean:function(j){return typeof j==="boolean";},isFunction:function(j){return(typeof j==="function")||a.toString.apply(j)===h;},isNull:function(j){return j===null;},isNumber:function(j){return typeof j==="number"&&isFinite(j);},isObject:function(j){return(j&&(typeof j==="object"||f.isFunction(j)))||false;},isString:function(j){return typeof j==="string";},isUndefined:function(j){return typeof j==="undefined";},_IEEnumFix:(YAHOO.env.ua.ie)?function(l,k){var j,n,m;for(j=0;j<d.length;j=j+1){n=d[j];m=k[n];if(f.isFunction(m)&&m!=a[n]){l[n]=m;}}}:function(){},escapeHTML:function(j){return j.replace(/[&<>"'\/`]/g,function(k){return g[k];});},extend:function(m,n,l){if(!n||!m){throw new Error("extend failed, please check that "+"all dependencies are included.");}var k=function(){},j;k.prototype=n.prototype;m.prototype=new k();m.prototype.constructor=m;m.superclass=n.prototype;if(n.prototype.constructor==a.constructor){n.prototype.constructor=n;}if(l){for(j in l){if(f.hasOwnProperty(l,j)){m.prototype[j]=l[j];}}f._IEEnumFix(m.prototype,l);}},augmentObject:function(n,m){if(!m||!n){throw new Error("Absorb failed, verify dependencies.");}var j=arguments,l,o,k=j[2];if(k&&k!==true){for(l=2;l<j.length;l=l+1){n[j[l]]=m[j[l]];}}else{for(o in m){if(k||!(o in n)){n[o]=m[o];}}f._IEEnumFix(n,m);}return n;},augmentProto:function(m,l){if(!l||!m){throw new Error("Augment failed, verify dependencies.");}var j=[m.prototype,l.prototype],k;for(k=2;k<arguments.length;k=k+1){j.push(arguments[k]);}f.augmentObject.apply(this,j);return m;},dump:function(j,p){var l,n,r=[],t="{...}",k="f(){...}",q=", ",m=" => ";if(!f.isObject(j)){return j+"";}else{if(j instanceof Date||("nodeType" in j&&"tagName" in j)){return j;}else{if(f.isFunction(j)){return k;}}}p=(f.isNumber(p))?p:3;if(f.isArray(j)){r.push("[");for(l=0,n=j.length;l<n;l=l+1){if(f.isObject(j[l])){r.push((p>0)?f.dump(j[l],p-1):t);}else{r.push(j[l]);}r.push(q);}if(r.length>1){r.pop();}r.push("]");}else{r.push("{");for(l in j){if(f.hasOwnProperty(j,l)){r.push(l+m);if(f.isObject(j[l])){r.push((p>0)?f.dump(j[l],p-1):t);}else{r.push(j[l]);}r.push(q);}}if(r.length>1){r.pop();}r.push("}");}return r.join("");},substitute:function(x,y,E,l){var D,C,B,G,t,u,F=[],p,z=x.length,A="dump",r=" ",q="{",m="}",n,w;for(;;){D=x.lastIndexOf(q,z);if(D<0){break;}C=x.indexOf(m,D);if(D+1>C){break;}p=x.substring(D+1,C);G=p;u=null;B=G.indexOf(r);if(B>-1){u=G.substring(B+1);G=G.substring(0,B);}t=y[G];if(E){t=E(G,t,u);}if(f.isObject(t)){if(f.isArray(t)){t=f.dump(t,parseInt(u,10));}else{u=u||"";n=u.indexOf(A);if(n>-1){u=u.substring(4);}w=t.toString();if(w===i||n>-1){t=f.dump(t,parseInt(u,10));}else{t=w;}}}else{if(!f.isString(t)&&!f.isNumber(t)){t="~-"+F.length+"-~";F[F.length]=p;}}x=x.substring(0,D)+t+x.substring(C+1);if(l===false){z=D-1;}}for(D=F.length-1;D>=0;D=D-1){x=x.replace(new RegExp("~-"+D+"-~"),"{"+F[D]+"}","g");}return x;},trim:function(j){try{return j.replace(/^\s+|\s+$/g,"");}catch(k){return j;
}},merge:function(){var n={},k=arguments,j=k.length,m;for(m=0;m<j;m=m+1){f.augmentObject(n,k[m],true);}return n;},later:function(t,k,u,n,p){t=t||0;k=k||{};var l=u,s=n,q,j;if(f.isString(u)){l=k[u];}if(!l){throw new TypeError("method undefined");}if(!f.isUndefined(n)&&!f.isArray(s)){s=[n];}q=function(){l.apply(k,s||b);};j=(p)?setInterval(q,t):setTimeout(q,t);return{interval:p,cancel:function(){if(this.interval){clearInterval(j);}else{clearTimeout(j);}}};},isValue:function(j){return(f.isObject(j)||f.isString(j)||f.isNumber(j)||f.isBoolean(j));}};f.hasOwnProperty=(a.hasOwnProperty)?function(j,k){return j&&j.hasOwnProperty&&j.hasOwnProperty(k);}:function(j,k){return !f.isUndefined(j[k])&&j.constructor.prototype[k]!==j[k];};e.augmentObject(f,e,true);YAHOO.util.Lang=f;f.augment=f.augmentProto;YAHOO.augment=f.augmentProto;YAHOO.extend=f.extend;})();YAHOO.register("yahoo",YAHOO,{version:"2.9.0",build:"2800"});YAHOO.util.Get=function(){var m={},k=0,r=0,l=false,n=YAHOO.env.ua,s=YAHOO.lang,q,d,e,i=function(x,t,y){var u=y||window,z=u.document,A=z.createElement(x),v;for(v in t){if(t.hasOwnProperty(v)){A.setAttribute(v,t[v]);}}return A;},h=function(u,v,t){var w={id:"yui__dyn_"+(r++),type:"text/css",rel:"stylesheet",href:u};if(t){s.augmentObject(w,t);}return i("link",w,v);},p=function(u,v,t){var w={id:"yui__dyn_"+(r++),type:"text/javascript",src:u};if(t){s.augmentObject(w,t);}return i("script",w,v);},a=function(t,u){return{tId:t.tId,win:t.win,data:t.data,nodes:t.nodes,msg:u,purge:function(){d(this.tId);}};},b=function(t,w){var u=m[w],v=(s.isString(t))?u.win.document.getElementById(t):t;if(!v){q(w,"target node not found: "+t);}return v;},c=function(w){YAHOO.log("Finishing transaction "+w);var u=m[w],v,t;u.finished=true;if(u.aborted){v="transaction "+w+" was aborted";q(w,v);return;}if(u.onSuccess){t=u.scope||u.win;u.onSuccess.call(t,a(u));}},o=function(v){YAHOO.log("Timeout "+v,"info","get");var u=m[v],t;if(u.onTimeout){t=u.scope||u;u.onTimeout.call(t,a(u));}},f=function(v,A){YAHOO.log("_next: "+v+", loaded: "+A,"info","Get");var u=m[v],D=u.win,C=D.document,B=C.getElementsByTagName("head")[0],x,y,t,E,z;if(u.timer){u.timer.cancel();}if(u.aborted){y="transaction "+v+" was aborted";q(v,y);return;}if(A){u.url.shift();if(u.varName){u.varName.shift();}}else{u.url=(s.isString(u.url))?[u.url]:u.url;if(u.varName){u.varName=(s.isString(u.varName))?[u.varName]:u.varName;}}if(u.url.length===0){if(u.type==="script"&&n.webkit&&n.webkit<420&&!u.finalpass&&!u.varName){z=p(null,u.win,u.attributes);z.innerHTML='YAHOO.util.Get._finalize("'+v+'");';u.nodes.push(z);B.appendChild(z);}else{c(v);}return;}t=u.url[0];if(!t){u.url.shift();YAHOO.log("skipping empty url");return f(v);}YAHOO.log("attempting to load "+t,"info","Get");if(u.timeout){u.timer=s.later(u.timeout,u,o,v);}if(u.type==="script"){x=p(t,D,u.attributes);}else{x=h(t,D,u.attributes);}e(u.type,x,v,t,D,u.url.length);u.nodes.push(x);if(u.insertBefore){E=b(u.insertBefore,v);if(E){E.parentNode.insertBefore(x,E);}}else{B.appendChild(x);}YAHOO.log("Appending node: "+t,"info","Get");if((n.webkit||n.gecko)&&u.type==="css"){f(v,t);}},j=function(){if(l){return;}l=true;var t,u;for(t in m){if(m.hasOwnProperty(t)){u=m[t];if(u.autopurge&&u.finished){d(u.tId);delete m[t];}}}l=false;},g=function(u,t,v){var x="q"+(k++),w;v=v||{};if(k%YAHOO.util.Get.PURGE_THRESH===0){j();}m[x]=s.merge(v,{tId:x,type:u,url:t,finished:false,aborted:false,nodes:[]});w=m[x];w.win=w.win||window;w.scope=w.scope||w.win;w.autopurge=("autopurge" in w)?w.autopurge:(u==="script")?true:false;w.attributes=w.attributes||{};w.attributes.charset=v.charset||w.attributes.charset||"utf-8";s.later(0,w,f,x);return{tId:x};};e=function(H,z,x,u,D,E,G){var F=G||f,B,t,I,v,J,A,C,y;if(n.ie){z.onreadystatechange=function(){B=this.readyState;if("loaded"===B||"complete"===B){YAHOO.log(x+" onload "+u,"info","Get");z.onreadystatechange=null;F(x,u);}};}else{if(n.webkit){if(H==="script"){if(n.webkit>=420){z.addEventListener("load",function(){YAHOO.log(x+" DOM2 onload "+u,"info","Get");F(x,u);});}else{t=m[x];if(t.varName){v=YAHOO.util.Get.POLL_FREQ;YAHOO.log("Polling for "+t.varName[0]);t.maxattempts=YAHOO.util.Get.TIMEOUT/v;t.attempts=0;t._cache=t.varName[0].split(".");t.timer=s.later(v,t,function(w){I=this._cache;A=I.length;J=this.win;for(C=0;C<A;C=C+1){J=J[I[C]];if(!J){this.attempts++;if(this.attempts++>this.maxattempts){y="Over retry limit, giving up";t.timer.cancel();q(x,y);}else{YAHOO.log(I[C]+" failed, retrying");}return;}}YAHOO.log("Safari poll complete");t.timer.cancel();F(x,u);},null,true);}else{s.later(YAHOO.util.Get.POLL_FREQ,null,F,[x,u]);}}}}else{z.onload=function(){YAHOO.log(x+" onload "+u,"info","Get");F(x,u);};}}};q=function(w,v){YAHOO.log("get failure: "+v,"warn","Get");var u=m[w],t;if(u.onFailure){t=u.scope||u.win;u.onFailure.call(t,a(u,v));}};d=function(z){if(m[z]){var t=m[z],u=t.nodes,x=u.length,C=t.win.document,A=C.getElementsByTagName("head")[0],v,y,w,B;if(t.insertBefore){v=b(t.insertBefore,z);if(v){A=v.parentNode;}}for(y=0;y<x;y=y+1){w=u[y];if(w.clearAttributes){w.clearAttributes();}else{for(B in w){if(w.hasOwnProperty(B)){delete w[B];}}}A.removeChild(w);}t.nodes=[];}};return{POLL_FREQ:10,PURGE_THRESH:20,TIMEOUT:2000,_finalize:function(t){YAHOO.log(t+" finalized ","info","Get");s.later(0,null,c,t);},abort:function(u){var v=(s.isString(u))?u:u.tId,t=m[v];if(t){YAHOO.log("Aborting "+v,"info","Get");t.aborted=true;}},script:function(t,u){return g("script",t,u);},css:function(t,u){return g("css",t,u);}};}();YAHOO.register("get",YAHOO.util.Get,{version:"2.9.0",build:"2800"});(function(){var Y=YAHOO,util=Y.util,lang=Y.lang,env=Y.env,PROV="_provides",SUPER="_supersedes",REQ="expanded",AFTER="_after",VERSION="2.9.0";var YUI={dupsAllowed:{"yahoo":true,"get":true},info:{"root":VERSION+"/build/","base":"http://yui.yahooapis.com/"+VERSION+"/build/","comboBase":"http://yui.yahooapis.com/combo?","skin":{"defaultSkin":"sam","base":"assets/skins/","path":"skin.css","after":["reset","fonts","grids","base"],"rollup":3},dupsAllowed:["yahoo","get"],"moduleInfo":{"animation":{"type":"js","path":"animation/animation-min.js","requires":["dom","event"]},"autocomplete":{"type":"js","path":"autocomplete/autocomplete-min.js","requires":["dom","event","datasource"],"optional":["connection","animation"],"skinnable":true},"base":{"type":"css","path":"base/base-min.css","after":["reset","fonts","grids"]},"button":{"type":"js","path":"button/button-min.js","requires":["element"],"optional":["menu"],"skinnable":true},"calendar":{"type":"js","path":"calendar/calendar-min.js","requires":["event","dom"],supersedes:["datemath"],"skinnable":true},"carousel":{"type":"js","path":"carousel/carousel-min.js","requires":["element"],"optional":["animation"],"skinnable":true},"charts":{"type":"js","path":"charts/charts-min.js","requires":["element","json","datasource","swf"]},"colorpicker":{"type":"js","path":"colorpicker/colorpicker-min.js","requires":["slider","element"],"optional":["animation"],"skinnable":true},"connection":{"type":"js","path":"connection/connection-min.js","requires":["event"],"supersedes":["connectioncore"]},"connectioncore":{"type":"js","path":"connection/connection_core-min.js","requires":["event"],"pkg":"connection"},"container":{"type":"js","path":"container/container-min.js","requires":["dom","event"],"optional":["dragdrop","animation","connection"],"supersedes":["containercore"],"skinnable":true},"containercore":{"type":"js","path":"container/container_core-min.js","requires":["dom","event"],"pkg":"container"},"cookie":{"type":"js","path":"cookie/cookie-min.js","requires":["yahoo"]},"datasource":{"type":"js","path":"datasource/datasource-min.js","requires":["event"],"optional":["connection"]},"datatable":{"type":"js","path":"datatable/datatable-min.js","requires":["element","datasource"],"optional":["calendar","dragdrop","paginator"],"skinnable":true},datemath:{"type":"js","path":"datemath/datemath-min.js","requires":["yahoo"]},"dom":{"type":"js","path":"dom/dom-min.js","requires":["yahoo"]},"dragdrop":{"type":"js","path":"dragdrop/dragdrop-min.js","requires":["dom","event"]},"editor":{"type":"js","path":"editor/editor-min.js","requires":["menu","element","button"],"optional":["animation","dragdrop"],"supersedes":["simpleeditor"],"skinnable":true},"element":{"type":"js","path":"element/element-min.js","requires":["dom","event"],"optional":["event-mouseenter","event-delegate"]},"element-delegate":{"type":"js","path":"element-delegate/element-delegate-min.js","requires":["element"]},"event":{"type":"js","path":"event/event-min.js","requires":["yahoo"]},"event-simulate":{"type":"js","path":"event-simulate/event-simulate-min.js","requires":["event"]},"event-delegate":{"type":"js","path":"event-delegate/event-delegate-min.js","requires":["event"],"optional":["selector"]},"event-mouseenter":{"type":"js","path":"event-mouseenter/event-mouseenter-min.js","requires":["dom","event"]},"fonts":{"type":"css","path":"fonts/fonts-min.css"},"get":{"type":"js","path":"get/get-min.js","requires":["yahoo"]},"grids":{"type":"css","path":"grids/grids-min.css","requires":["fonts"],"optional":["reset"]},"history":{"type":"js","path":"history/history-min.js","requires":["event"]},"imagecropper":{"type":"js","path":"imagecropper/imagecropper-min.js","requires":["dragdrop","element","resize"],"skinnable":true},"imageloader":{"type":"js","path":"imageloader/imageloader-min.js","requires":["event","dom"]},"json":{"type":"js","path":"json/json-min.js","requires":["yahoo"]},"layout":{"type":"js","path":"layout/layout-min.js","requires":["element"],"optional":["animation","dragdrop","resize","selector"],"skinnable":true},"logger":{"type":"js","path":"logger/logger-min.js","requires":["event","dom"],"optional":["dragdrop"],"skinnable":true},"menu":{"type":"js","path":"menu/menu-min.js","requires":["containercore"],"skinnable":true},"paginator":{"type":"js","path":"paginator/paginator-min.js","requires":["element"],"skinnable":true},"profiler":{"type":"js","path":"profiler/profiler-min.js","requires":["yahoo"]},"profilerviewer":{"type":"js","path":"profilerviewer/profilerviewer-min.js","requires":["profiler","yuiloader","element"],"skinnable":true},"progressbar":{"type":"js","path":"progressbar/progressbar-min.js","requires":["element"],"optional":["animation"],"skinnable":true},"reset":{"type":"css","path":"reset/reset-min.css"},"reset-fonts-grids":{"type":"css","path":"reset-fonts-grids/reset-fonts-grids.css","supersedes":["reset","fonts","grids","reset-fonts"],"rollup":4},"reset-fonts":{"type":"css","path":"reset-fonts/reset-fonts.css","supersedes":["reset","fonts"],"rollup":2},"resize":{"type":"js","path":"resize/resize-min.js","requires":["dragdrop","element"],"optional":["animation"],"skinnable":true},"selector":{"type":"js","path":"selector/selector-min.js","requires":["yahoo","dom"]},"simpleeditor":{"type":"js","path":"editor/simpleeditor-min.js","requires":["element"],"optional":["containercore","menu","button","animation","dragdrop"],"skinnable":true,"pkg":"editor"},"slider":{"type":"js","path":"slider/slider-min.js","requires":["dragdrop"],"optional":["animation"],"skinnable":true},"storage":{"type":"js","path":"storage/storage-min.js","requires":["yahoo","event","cookie"],"optional":["swfstore"]},"stylesheet":{"type":"js","path":"stylesheet/stylesheet-min.js","requires":["yahoo"]},"swf":{"type":"js","path":"swf/swf-min.js","requires":["element"],"supersedes":["swfdetect"]},"swfdetect":{"type":"js","path":"swfdetect/swfdetect-min.js","requires":["yahoo"]},"swfstore":{"type":"js","path":"swfstore/swfstore-min.js","requires":["element","cookie","swf"]},"tabview":{"type":"js","path":"tabview/tabview-min.js","requires":["element"],"optional":["connection"],"skinnable":true},"treeview":{"type":"js","path":"treeview/treeview-min.js","requires":["event","dom"],"optional":["json","animation","calendar"],"skinnable":true},"uploader":{"type":"js","path":"uploader/uploader-min.js","requires":["element"]},"utilities":{"type":"js","path":"utilities/utilities.js","supersedes":["yahoo","event","dragdrop","animation","dom","connection","element","yahoo-dom-event","get","yuiloader","yuiloader-dom-event"],"rollup":8},"yahoo":{"type":"js","path":"yahoo/yahoo-min.js"},"yahoo-dom-event":{"type":"js","path":"yahoo-dom-event/yahoo-dom-event.js","supersedes":["yahoo","event","dom"],"rollup":3},"yuiloader":{"type":"js","path":"yuiloader/yuiloader-min.js","supersedes":["yahoo","get"]},"yuiloader-dom-event":{"type":"js","path":"yuiloader-dom-event/yuiloader-dom-event.js","supersedes":["yahoo","dom","event","get","yuiloader","yahoo-dom-event"],"rollup":5},"yuitest":{"type":"js","path":"yuitest/yuitest-min.js","requires":["logger"],"optional":["event-simulate"],"skinnable":true}}},ObjectUtil:{appendArray:function(o,a){if(a){for(var i=0;
i<a.length;i=i+1){o[a[i]]=true;}}},keys:function(o,ordered){var a=[],i;for(i in o){if(lang.hasOwnProperty(o,i)){a.push(i);}}return a;}},ArrayUtil:{appendArray:function(a1,a2){Array.prototype.push.apply(a1,a2);},indexOf:function(a,val){for(var i=0;i<a.length;i=i+1){if(a[i]===val){return i;}}return -1;},toObject:function(a){var o={};for(var i=0;i<a.length;i=i+1){o[a[i]]=true;}return o;},uniq:function(a){return YUI.ObjectUtil.keys(YUI.ArrayUtil.toObject(a));}}};YAHOO.util.YUILoader=function(o){this._internalCallback=null;this._useYahooListener=false;this.onSuccess=null;this.onFailure=Y.log;this.onProgress=null;this.onTimeout=null;this.scope=this;this.data=null;this.insertBefore=null;this.charset=null;this.varName=null;this.base=YUI.info.base;this.comboBase=YUI.info.comboBase;this.combine=false;this.root=YUI.info.root;this.timeout=0;this.ignore=null;this.force=null;this.allowRollup=true;this.filter=null;this.required={};this.moduleInfo=lang.merge(YUI.info.moduleInfo);this.rollups=null;this.loadOptional=false;this.sorted=[];this.loaded={};this.dirty=true;this.inserted={};var self=this;env.listeners.push(function(m){if(self._useYahooListener){self.loadNext(m.name);}});this.skin=lang.merge(YUI.info.skin);this._config(o);};Y.util.YUILoader.prototype={FILTERS:{RAW:{"searchExp":"-min\\.js","replaceStr":".js"},DEBUG:{"searchExp":"-min\\.js","replaceStr":"-debug.js"}},SKIN_PREFIX:"skin-",_config:function(o){if(o){for(var i in o){if(lang.hasOwnProperty(o,i)){if(i=="require"){this.require(o[i]);}else{this[i]=o[i];}}}}var f=this.filter;if(lang.isString(f)){f=f.toUpperCase();if(f==="DEBUG"){this.require("logger");}if(!Y.widget.LogWriter){Y.widget.LogWriter=function(){return Y;};}this.filter=this.FILTERS[f];}},addModule:function(o){if(!o||!o.name||!o.type||(!o.path&&!o.fullpath)){return false;}o.ext=("ext" in o)?o.ext:true;o.requires=o.requires||[];this.moduleInfo[o.name]=o;this.dirty=true;return true;},require:function(what){var a=(typeof what==="string")?arguments:what;this.dirty=true;YUI.ObjectUtil.appendArray(this.required,a);},_addSkin:function(skin,mod){var name=this.formatSkin(skin),info=this.moduleInfo,sinf=this.skin,ext=info[mod]&&info[mod].ext;if(!info[name]){this.addModule({"name":name,"type":"css","path":sinf.base+skin+"/"+sinf.path,"after":sinf.after,"rollup":sinf.rollup,"ext":ext});}if(mod){name=this.formatSkin(skin,mod);if(!info[name]){var mdef=info[mod],pkg=mdef.pkg||mod;this.addModule({"name":name,"type":"css","after":sinf.after,"path":pkg+"/"+sinf.base+skin+"/"+mod+".css","ext":ext});}}return name;},getRequires:function(mod){if(!mod){return[];}if(!this.dirty&&mod.expanded){return mod.expanded;}mod.requires=mod.requires||[];var i,d=[],r=mod.requires,o=mod.optional,info=this.moduleInfo,m;for(i=0;i<r.length;i=i+1){d.push(r[i]);m=info[r[i]];YUI.ArrayUtil.appendArray(d,this.getRequires(m));}if(o&&this.loadOptional){for(i=0;i<o.length;i=i+1){d.push(o[i]);YUI.ArrayUtil.appendArray(d,this.getRequires(info[o[i]]));}}mod.expanded=YUI.ArrayUtil.uniq(d);return mod.expanded;},getProvides:function(name,notMe){var addMe=!(notMe),ckey=(addMe)?PROV:SUPER,m=this.moduleInfo[name],o={};if(!m){return o;}if(m[ckey]){return m[ckey];}var s=m.supersedes,done={},me=this;var add=function(mm){if(!done[mm]){done[mm]=true;lang.augmentObject(o,me.getProvides(mm));}};if(s){for(var i=0;i<s.length;i=i+1){add(s[i]);}}m[SUPER]=o;m[PROV]=lang.merge(o);m[PROV][name]=true;return m[ckey];},calculate:function(o){if(o||this.dirty){this._config(o);this._setup();this._explode();if(this.allowRollup){this._rollup();}this._reduce();this._sort();this.dirty=false;}},_setup:function(){var info=this.moduleInfo,name,i,j;for(name in info){if(lang.hasOwnProperty(info,name)){var m=info[name];if(m&&m.skinnable){var o=this.skin.overrides,smod;if(o&&o[name]){for(i=0;i<o[name].length;i=i+1){smod=this._addSkin(o[name][i],name);}}else{smod=this._addSkin(this.skin.defaultSkin,name);}if(YUI.ArrayUtil.indexOf(m.requires,smod)==-1){m.requires.push(smod);}}}}var l=lang.merge(this.inserted);if(!this._sandbox){l=lang.merge(l,env.modules);}if(this.ignore){YUI.ObjectUtil.appendArray(l,this.ignore);}if(this.force){for(i=0;i<this.force.length;i=i+1){if(this.force[i] in l){delete l[this.force[i]];}}}for(j in l){if(lang.hasOwnProperty(l,j)){lang.augmentObject(l,this.getProvides(j));}}this.loaded=l;},_explode:function(){var r=this.required,i,mod;for(i in r){if(lang.hasOwnProperty(r,i)){mod=this.moduleInfo[i];if(mod){var req=this.getRequires(mod);if(req){YUI.ObjectUtil.appendArray(r,req);}}}}},_skin:function(){},formatSkin:function(skin,mod){var s=this.SKIN_PREFIX+skin;if(mod){s=s+"-"+mod;}return s;},parseSkin:function(mod){if(mod.indexOf(this.SKIN_PREFIX)===0){var a=mod.split("-");return{skin:a[1],module:a[2]};}return null;},_rollup:function(){var i,j,m,s,rollups={},r=this.required,roll,info=this.moduleInfo;if(this.dirty||!this.rollups){for(i in info){if(lang.hasOwnProperty(info,i)){m=info[i];if(m&&m.rollup){rollups[i]=m;}}}this.rollups=rollups;}for(;;){var rolled=false;for(i in rollups){if(!r[i]&&!this.loaded[i]){m=info[i];s=m.supersedes;roll=false;if(!m.rollup){continue;}var skin=(m.ext)?false:this.parseSkin(i),c=0;if(skin){for(j in r){if(lang.hasOwnProperty(r,j)){if(i!==j&&this.parseSkin(j)){c++;roll=(c>=m.rollup);if(roll){break;}}}}}else{for(j=0;j<s.length;j=j+1){if(this.loaded[s[j]]&&(!YUI.dupsAllowed[s[j]])){roll=false;break;}else{if(r[s[j]]){c++;roll=(c>=m.rollup);if(roll){break;}}}}}if(roll){r[i]=true;rolled=true;this.getRequires(m);}}}if(!rolled){break;}}},_reduce:function(){var i,j,s,m,r=this.required;for(i in r){if(i in this.loaded){delete r[i];}else{var skinDef=this.parseSkin(i);if(skinDef){if(!skinDef.module){var skin_pre=this.SKIN_PREFIX+skinDef.skin;for(j in r){if(lang.hasOwnProperty(r,j)){m=this.moduleInfo[j];var ext=m&&m.ext;if(!ext&&j!==i&&j.indexOf(skin_pre)>-1){delete r[j];}}}}}else{m=this.moduleInfo[i];s=m&&m.supersedes;if(s){for(j=0;j<s.length;j=j+1){if(s[j] in r){delete r[s[j]];}}}}}}},_onFailure:function(msg){YAHOO.log("Failure","info","loader");
var f=this.onFailure;if(f){f.call(this.scope,{msg:"failure: "+msg,data:this.data,success:false});}},_onTimeout:function(){YAHOO.log("Timeout","info","loader");var f=this.onTimeout;if(f){f.call(this.scope,{msg:"timeout",data:this.data,success:false});}},_sort:function(){var s=[],info=this.moduleInfo,loaded=this.loaded,checkOptional=!this.loadOptional,me=this;var requires=function(aa,bb){var mm=info[aa];if(loaded[bb]||!mm){return false;}var ii,rr=mm.expanded,after=mm.after,other=info[bb],optional=mm.optional;if(rr&&YUI.ArrayUtil.indexOf(rr,bb)>-1){return true;}if(after&&YUI.ArrayUtil.indexOf(after,bb)>-1){return true;}if(checkOptional&&optional&&YUI.ArrayUtil.indexOf(optional,bb)>-1){return true;}var ss=info[bb]&&info[bb].supersedes;if(ss){for(ii=0;ii<ss.length;ii=ii+1){if(requires(aa,ss[ii])){return true;}}}if(mm.ext&&mm.type=="css"&&!other.ext&&other.type=="css"){return true;}return false;};for(var i in this.required){if(lang.hasOwnProperty(this.required,i)){s.push(i);}}var p=0;for(;;){var l=s.length,a,b,j,k,moved=false;for(j=p;j<l;j=j+1){a=s[j];for(k=j+1;k<l;k=k+1){if(requires(a,s[k])){b=s.splice(k,1);s.splice(j,0,b[0]);moved=true;break;}}if(moved){break;}else{p=p+1;}}if(!moved){break;}}this.sorted=s;},toString:function(){var o={type:"YUILoader",base:this.base,filter:this.filter,required:this.required,loaded:this.loaded,inserted:this.inserted};lang.dump(o,1);},_combine:function(){this._combining=[];var self=this,s=this.sorted,len=s.length,js=this.comboBase,css=this.comboBase,target,startLen=js.length,i,m,type=this.loadType;YAHOO.log("type "+type);for(i=0;i<len;i=i+1){m=this.moduleInfo[s[i]];if(m&&!m.ext&&(!type||type===m.type)){target=this.root+m.path;target+="&";if(m.type=="js"){js+=target;}else{css+=target;}this._combining.push(s[i]);}}if(this._combining.length){YAHOO.log("Attempting to combine: "+this._combining,"info","loader");var callback=function(o){var c=this._combining,len=c.length,i,m;for(i=0;i<len;i=i+1){this.inserted[c[i]]=true;}this.loadNext(o.data);},loadScript=function(){if(js.length>startLen){YAHOO.util.Get.script(self._filter(js),{data:self._loading,onSuccess:callback,onFailure:self._onFailure,onTimeout:self._onTimeout,insertBefore:self.insertBefore,charset:self.charset,timeout:self.timeout,scope:self});}else{this.loadNext();}};if(css.length>startLen){YAHOO.util.Get.css(this._filter(css),{data:this._loading,onSuccess:loadScript,onFailure:this._onFailure,onTimeout:this._onTimeout,insertBefore:this.insertBefore,charset:this.charset,timeout:this.timeout,scope:self});}else{loadScript();}return;}else{this.loadNext(this._loading);}},insert:function(o,type){this.calculate(o);this._loading=true;this.loadType=type;if(this.combine){return this._combine();}if(!type){var self=this;this._internalCallback=function(){self._internalCallback=null;self.insert(null,"js");};this.insert(null,"css");return;}this.loadNext();},sandbox:function(o,type){var self=this,success=function(o){var idx=o.argument[0],name=o.argument[2];self._scriptText[idx]=o.responseText;if(self.onProgress){self.onProgress.call(self.scope,{name:name,scriptText:o.responseText,xhrResponse:o,data:self.data});}self._loadCount++;if(self._loadCount>=self._stopCount){var v=self.varName||"YAHOO";var t="(function() {\n";var b="\nreturn "+v+";\n})();";var ref=eval(t+self._scriptText.join("\n")+b);self._pushEvents(ref);if(ref){self.onSuccess.call(self.scope,{reference:ref,data:self.data});}else{self._onFailure.call(self.varName+" reference failure");}}},failure=function(o){self.onFailure.call(self.scope,{msg:"XHR failure",xhrResponse:o,data:self.data});};self._config(o);if(!self.onSuccess){throw new Error("You must supply an onSuccess handler for your sandbox");}self._sandbox=true;if(!type||type!=="js"){self._internalCallback=function(){self._internalCallback=null;self.sandbox(null,"js");};self.insert(null,"css");return;}if(!util.Connect){var ld=new YAHOO.util.YUILoader();ld.insert({base:self.base,filter:self.filter,require:"connection",insertBefore:self.insertBefore,charset:self.charset,onSuccess:function(){self.sandbox(null,"js");},scope:self},"js");return;}self._scriptText=[];self._loadCount=0;self._stopCount=self.sorted.length;self._xhr=[];self.calculate();var s=self.sorted,l=s.length,i,m,url;for(i=0;i<l;i=i+1){m=self.moduleInfo[s[i]];if(!m){self._onFailure("undefined module "+m);for(var j=0;j<self._xhr.length;j=j+1){self._xhr[j].abort();}return;}if(m.type!=="js"){self._loadCount++;continue;}url=m.fullpath;url=(url)?self._filter(url):self._url(m.path);var xhrData={success:success,failure:failure,scope:self,argument:[i,url,s[i]]};self._xhr.push(util.Connect.asyncRequest("GET",url,xhrData));}},loadNext:function(mname){if(!this._loading){return;}var self=this,donext=function(o){self.loadNext(o.data);},successfn,s=this.sorted,len=s.length,i,fn,m,url;if(mname){if(mname!==this._loading){return;}this.inserted[mname]=true;if(this.onProgress){this.onProgress.call(this.scope,{name:mname,data:this.data});}}for(i=0;i<len;i=i+1){if(s[i] in this.inserted){continue;}if(s[i]===this._loading){return;}m=this.moduleInfo[s[i]];if(!m){this.onFailure.call(this.scope,{msg:"undefined module "+m,data:this.data});return;}if(!this.loadType||this.loadType===m.type){successfn=donext;this._loading=s[i];fn=(m.type==="css")?util.Get.css:util.Get.script;url=m.fullpath;url=(url)?this._filter(url):this._url(m.path);if(env.ua.webkit&&env.ua.webkit<420&&m.type==="js"&&!m.varName){successfn=null;this._useYahooListener=true;}fn(url,{data:s[i],onSuccess:successfn,onFailure:this._onFailure,onTimeout:this._onTimeout,insertBefore:this.insertBefore,charset:this.charset,timeout:this.timeout,varName:m.varName,scope:self});return;}}this._loading=null;if(this._internalCallback){var f=this._internalCallback;this._internalCallback=null;f.call(this);}else{if(this.onSuccess){this._pushEvents();this.onSuccess.call(this.scope,{data:this.data});}}},_pushEvents:function(ref){var r=ref||YAHOO;if(r.util&&r.util.Event){r.util.Event._load();}},_filter:function(str){var f=this.filter;return(f)?str.replace(new RegExp(f.searchExp,"g"),f.replaceStr):str;
},_url:function(path){return this._filter((this.base||"")+path);}};})();YAHOO.register("yuiloader",YAHOO.util.YUILoader,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/yuiloader/yuiloader-min.js
                                
/*
 * More info at: http://phpjs.org
 *
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

// End of File include/javascript/phpjs/license.js
                                
/*
 * More info at: http://phpjs.org
 *
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
function get_html_translation_table(table,quote_style){var entities={},hash_map={},decimal=0,symbol='';var constMappingTable={},constMappingQuoteStyle={};var useTable={},useQuoteStyle={};constMappingTable[0]='HTML_SPECIALCHARS';constMappingTable[1]='HTML_ENTITIES';constMappingQuoteStyle[0]='ENT_NOQUOTES';constMappingQuoteStyle[2]='ENT_COMPAT';constMappingQuoteStyle[3]='ENT_QUOTES';useTable=!isNaN(table)?constMappingTable[table]:table?table.toUpperCase():'HTML_SPECIALCHARS';useQuoteStyle=!isNaN(quote_style)?constMappingQuoteStyle[quote_style]:quote_style?quote_style.toUpperCase():'ENT_COMPAT';if(useTable!=='HTML_SPECIALCHARS'&&useTable!=='HTML_ENTITIES'){throw new Error("Table: "+useTable+' not supported');}
entities['38']='&amp;';if(useTable==='HTML_ENTITIES'){entities['160']='&nbsp;';entities['161']='&iexcl;';entities['162']='&cent;';entities['163']='&pound;';entities['164']='&curren;';entities['165']='&yen;';entities['166']='&brvbar;';entities['167']='&sect;';entities['168']='&uml;';entities['169']='&copy;';entities['170']='&ordf;';entities['171']='&laquo;';entities['172']='&not;';entities['173']='&shy;';entities['174']='&reg;';entities['175']='&macr;';entities['176']='&deg;';entities['177']='&plusmn;';entities['178']='&sup2;';entities['179']='&sup3;';entities['180']='&acute;';entities['181']='&micro;';entities['182']='&para;';entities['183']='&middot;';entities['184']='&cedil;';entities['185']='&sup1;';entities['186']='&ordm;';entities['187']='&raquo;';entities['188']='&frac14;';entities['189']='&frac12;';entities['190']='&frac34;';entities['191']='&iquest;';entities['192']='&Agrave;';entities['193']='&Aacute;';entities['194']='&Acirc;';entities['195']='&Atilde;';entities['196']='&Auml;';entities['197']='&Aring;';entities['198']='&AElig;';entities['199']='&Ccedil;';entities['200']='&Egrave;';entities['201']='&Eacute;';entities['202']='&Ecirc;';entities['203']='&Euml;';entities['204']='&Igrave;';entities['205']='&Iacute;';entities['206']='&Icirc;';entities['207']='&Iuml;';entities['208']='&ETH;';entities['209']='&Ntilde;';entities['210']='&Ograve;';entities['211']='&Oacute;';entities['212']='&Ocirc;';entities['213']='&Otilde;';entities['214']='&Ouml;';entities['215']='&times;';entities['216']='&Oslash;';entities['217']='&Ugrave;';entities['218']='&Uacute;';entities['219']='&Ucirc;';entities['220']='&Uuml;';entities['221']='&Yacute;';entities['222']='&THORN;';entities['223']='&szlig;';entities['224']='&agrave;';entities['225']='&aacute;';entities['226']='&acirc;';entities['227']='&atilde;';entities['228']='&auml;';entities['229']='&aring;';entities['230']='&aelig;';entities['231']='&ccedil;';entities['232']='&egrave;';entities['233']='&eacute;';entities['234']='&ecirc;';entities['235']='&euml;';entities['236']='&igrave;';entities['237']='&iacute;';entities['238']='&icirc;';entities['239']='&iuml;';entities['240']='&eth;';entities['241']='&ntilde;';entities['242']='&ograve;';entities['243']='&oacute;';entities['244']='&ocirc;';entities['245']='&otilde;';entities['246']='&ouml;';entities['247']='&divide;';entities['248']='&oslash;';entities['249']='&ugrave;';entities['250']='&uacute;';entities['251']='&ucirc;';entities['252']='&uuml;';entities['253']='&yacute;';entities['254']='&thorn;';entities['255']='&yuml;';}
if(useQuoteStyle!=='ENT_NOQUOTES'){entities['34']='&quot;';}
if(useQuoteStyle==='ENT_QUOTES'){entities['39']='&#39;';}
entities['60']='&lt;';entities['62']='&gt;';for(decimal in entities){symbol=String.fromCharCode(decimal);hash_map[symbol]=entities[decimal];}
return hash_map;}
// End of File include/javascript/phpjs/get_html_translation_table.js
                                
/*
 * More info at: http://phpjs.org
 *
 * This is version: 3.25
 * php.js is copyright 2011 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Legaev
 * Andrey, Ates Goral (http://magnetiq.com), Ratheous, Alex, Rafa? Kukawski
 * (http://blog.kukawski.pl), Martijn Wieringa, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/), Nate, Enrique Gonzalez,
 * Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/), Jani
 * Hartikainen, Ole Vrijenhoek, Ash Searle (http://hexmen.com/blog/), Carlos
 * R. L. Rodrigues (http://www.jsfromhell.com), travc, Michael Grier,
 * Erkekjetter, Johnny Mast (http://www.phpvrouwen.nl), Rafa? Kukawski
 * (http://blog.kukawski.pl/), GeekFG (http://geekfg.blogspot.com), Andrea
 * Giammarchi (http://webreflection.blogspot.com), WebDevHobo
 * (http://webdevhobo.blogspot.com/), d3x, marrtins,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, stag019, T.Wild, Martin (http://www.erlenwiese.de/), majak, Marc
 * Palau, Mirek Slugen, Chris, Diplom@t (http://difane.com/), Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * gettimeofday, Arpad Ray (mailto:arpad@php.net), Oleg Eremeev, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Steve Hilder, mdsjack (http://www.mdsjack.bo.it), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net/), gorthaur, Aman Gupta, Sakimori, Joris,
 * Robin, Kankrelune (http://www.webfaktory.info/), Alfonso Jimenez
 * (http://www.alfonsojimenez.com), David, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), Lars Fischer, Karol Kowalski, Imgen Tata
 * (http://www.myipdf.com/), Steven Levithan (http://blog.stevenlevithan.com),
 * Tim de Koning (http://www.kingsquare.nl), Dreamer, AJ, Paul Smith, KELAN,
 * Pellentesque Malesuada, felix, Michael White, Mailfaker
 * (http://www.weedem.fr/), Thunder.m, Tyler Akins (http://rumkin.com),
 * saulius, Public Domain (http://www.json.org/json2.js), Caio Ariede
 * (http://caioariede.com), Steve Clay, David James, madipta, Marco, Ole
 * Vrijenhoek (http://www.nervous.nl/), class_exists, T. Wild, noname, Arno,
 * Frank Forte, Francois, Scott Cariss, Slawomir Kaniecki, date, Itsacon
 * (http://www.itsacon.net/), Billy, vlado houba, Jalal Berrami,
 * ReverseSyntax, Mateusz "loonquawl" Zalega, john (http://www.jd-tech.net),
 * mktime, Douglas Crockford (http://javascript.crockford.com), ger, Nick
 * Kolosov (http://sammy.ru), Nathan, nobbler, Fox, marc andreu, Alex Wilson,
 * Raphael (Ao RUDLER), Bayron Guevara, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Lincoln Ramsay, djmix,
 * Pyerre, Jon Hohle, Thiago Mata (http://thiagomata.blog.com), lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Linuxworld, duncan,
 * Gilbert, Sanjoy Roy, Shingo, sankai, Oskar Larsson H�gfeldt
 * (http://oskar-lh.name/), Denny Wardhana, 0m3r, Everlasto, Subhasis Deb,
 * josh, jd, Pier Paolo Ramon (http://www.mastersoup.com/), P, merabi, Soren
 * Hansen, EdorFaus, Eugene Bulkin (http://doubleaw.com/), Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, JB, LH, kenneth, J A R,
 * Marc Jansen, Stoyan Kyosev (http://www.svest.org/), Francesco, XoraX
 * (http://www.xorax.info), Ozh, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), Olivier Louvignes
 * (http://mg-crea.com/), T0bsn, Tim Wiel, Bryan Elliott, nord_ua, Martin, JT,
 * David Randall, Thomas Beaucourt (http://www.webapp.fr), Tim de Koning,
 * stensi, Pierre-Luc Paour, Kristof Coomans (SCK-CEN Belgian Nucleair
 * Research Centre), Martin Pool, Kirk Strobeck, Rick Waldron, Brant Messenger
 * (http://www.brantmessenger.com/), Devan Penner-Woelk, Saulo Vallory, Wagner
 * B. Soares, Artur Tchernychev, Valentina De Rosa, Jason Wong
 * (http://carrot.org/), Christoph, Daniel Esteban, strftime, Mick@el, rezna,
 * Simon Willison (http://simonwillison.net), Anton Ongson, Gabriel Paderni,
 * Marco van Oort, penutbutterjelly, Philipp Lenssen, Bjorn Roesbeke
 * (http://www.bjornroesbeke.be/), Bug?, Eric Nagel, Tomasz Wesolowski,
 * Evertjan Garretsen, Bobby Drake, Blues (http://tech.bluesmoon.info/), Luke
 * Godfrey, Pul, uestla, Alan C, Ulrich, Rafal Kukawski, Yves Sucaet,
 * sowberry, Norman "zEh" Fuchs, hitwork, Zahlii, johnrembo, Nick Callen,
 * Steven Levithan (stevenlevithan.com), ejsanders, Scott Baker, Brian Tafoya
 * (http://www.premasolutions.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Aidan Lister
 * (http://aidanlister.com/), Rob, e-mike, HKM, ChaosNo1, metjay, strcasecmp,
 * strcmp, Taras Bogach, jpfle, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), DxGx, kilops, Orlando,
 * dptr1988, Le Torbi, James (http://www.james-bell.co.uk/), Pedro Tainha
 * (http://www.pedrotainha.com), James, Arnout Kazemier
 * (http://www.3rd-Eden.com), Chris McMacken, Yannoo, jakes, gabriel paderni,
 * FGFEmperor, Greg Frazier, baris ozdil, 3D-GRAF, daniel airton wermann
 * (http://wermann.com.br), Howard Yeend, Diogo Resende, Allan Jensen
 * (http://www.winternet.no), Benjamin Lupton, Atli ?�r, Maximusya, davook,
 * Tod Gentille, Ryan W Tenney (http://ryan.10e.us), Nathan Sepulveda, Cord,
 * fearphage (http://http/my.opera.com/fearphage/), Victor, Rafa? Kukawski
 * (http://kukawski.pl), Matteo, Manish, Matt Bradley, Riddler
 * (http://www.frontierwebdev.com/), Alexander M Beedie, T.J. Leahy, Rafa?
 * Kukawski, taith, Luis Salazar (http://www.freaky-media.com/), FremyCompany,
 * Rival, Luke Smith (http://lucassmith.name), Andrej Pavlovic, Garagoth, Le
 * Torbi (http://www.letorbi.de/), Dino, Josep Sanz (http://www.ws3.es/), rem,
 * Russell Walker (http://www.nbill.co.uk/), Jamie Beck
 * (http://www.terabit.ca/), setcookie, Michael, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Ben
 * (http://benblume.co.uk/), DtTvB
 * (http://dt.in.th/2008-09-16.string-length-in-bytes.html), Andreas, William,
 * meo, incidence, Cagri Ekin, Amirouche, Amir Habibi
 * (http://www.residence-mixte.com/), Kheang Hok Chin
 * (http://www.distantia.ca/), Jay Klehr, Lorenzo Pisani, Tony, Yen-Wei Liu,
 * Greenseed, mk.keck, Leslie Hoare, dude, booeyOH, Ben Bryan
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
function html_entity_decode(string,quote_style){var hash_map={},symbol='',tmp_str='',entity='';tmp_str=string.toString();if(false===(hash_map=this.get_html_translation_table('HTML_ENTITIES',quote_style))){return false;}
delete(hash_map['&']);hash_map['&']='&amp;';for(symbol in hash_map){entity=hash_map[symbol];tmp_str=tmp_str.split(entity).join(symbol);}
tmp_str=tmp_str.split('&#039;').join("'");return tmp_str;}
// End of File include/javascript/phpjs/html_entity_decode.js
                                
