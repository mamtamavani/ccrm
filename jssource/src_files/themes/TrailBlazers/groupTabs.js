/**
 * groupTabs javascript file
 *
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2010 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 */
 


SUGAR.themes.updateDelay = 250;

SUGAR.themes.updateSubTabHtml = function(mainTab){
	var subTabs = document.getElementById("subtabs");
	subTabs.innerHTML = SUGAR.themes.subTabs[mainTab];
	
	//get sub menu dom node
	var menuHandle = document.getElementById(mainTab+"_sub_tab_id");
	
	//get group tab dom node
	var parentMenu = document.getElementById(mainTab+"_tab");
	var left='';
	if (left == "") {
		p = parentMenu;
		var left = 0;
		while(p&&p.tagName.toUpperCase()!='BODY'){
			left+=p.offsetLeft;
			p=p.offsetParent;
		}
	}
	
	//get browser width
	var bw = checkBrowserWidth();
	
	//If the mouse over on 'MoreMenu' group tab, stop the following function
	if(!parentMenu){
		return;
	}
	//Calculate left position of the middle of current group tab .
	var groupTabLeft = left + (parentMenu.offsetWidth / 2);
	var subTabHalfLength = 0;
	var children = menuHandle.getElementsByTagName('li');
	for(var i = 0; i< children.length; i++){
		//offsetWidth = width + padding + border
		subTabHalfLength += parseInt(children[i].offsetWidth);
	}
	
	if(subTabHalfLength != 0){
		subTabHalfLength = subTabHalfLength / 2;
	}
	
	var totalLengthInTheory = subTabHalfLength + groupTabLeft;
	if(subTabHalfLength>0 && groupTabLeft >0){
		if(subTabHalfLength >= groupTabLeft){
			left = 1;
		}else{
			left = groupTabLeft - subTabHalfLength;
		}
	}
	
	//If the sub menu length > browser length
	if(totalLengthInTheory > bw){
		var differ = totalLengthInTheory - bw;
		left = groupTabLeft - subTabHalfLength - differ - 2;
	}
	
	if (left >=0){
		menuHandle.style.marginLeft = left+'px';
	}
};

SUGAR.themes.updateSubTabs = function(mainTab, htmlTab){
	if(typeof htmlTab != 'undefined'){
		SUGAR.themes.updateSubTabHtml(htmlTab);
	}else{
		SUGAR.themes.updateSubTabHtml(mainTab);
	}
	
	if(SUGAR.themes.activeTab){
		var oldActive = document.getElementById(SUGAR.themes.activeTab + "_tab");
		oldActive.getElementsByTagName('a')[0].className = 'otherTab';
		oldActive.className = 'otherTab';
	}
	
	var newActive = document.getElementById(mainTab + "_tab");
	newActive.getElementsByTagName('a')[0].className = 'currentTab';
	newActive.className = 'currentTab';
	
	SUGAR.themes.activeTab = mainTab;
};

SUGAR.themes.updateMoreTab = function(tabName){
	var moreTab = document.getElementById(SUGAR.themes.moreTab + "_tab");
	if (moreTab == null)
        return;
	if(SUGAR.themes.moreTabUrl == null){
		SUGAR.themes.moreTabUrl = moreTab.getElementsByTagName('a')[0].href;
	}
	var href = (tabName!=SUGAR.themes.moreTab)?document.getElementById(tabName + "Handle").href:SUGAR.themes.moreTabUrl;
	moreTab.onmouseover = function(){SUGAR.themes.updateSubTabsDelay(SUGAR.themes.moreTab,tabName);};
	moreTab.getElementsByTagName('a')[0].innerHTML = tabName;
	moreTab.getElementsByTagName('a')[0].href = href;
	moreTab.getElementsByTagName('a')[0].onclick = function(){SUGAR.themes.chooseTab(tabName);return true;};
};

SUGAR.themes.resetTabs = function(){
	SUGAR.themes.updateSubTabs(SUGAR.themes.startTab);
	SUGAR.themes.updateMoreTab(SUGAR.themes.moreTab);
}

SUGAR.themes.firstReset = function(){
	SUGAR.themes.resetTabs();
}

SUGAR.themes.setResetTimer = function(){
	window.clearTimeout(SUGAR.themes.updateSubTabsTimer);
	window.clearTimeout(SUGAR.themes.resetSubTabsTimer);
	SUGAR.themes.resetSubTabsTimer = window.setTimeout('SUGAR.themes.resetTabs();', 1000);
}

SUGAR.themes.updateSubTabsDelay = function(mainTab, htmlTab, moreTab){
	var htmlTabArg = '';
	if(typeof htmlTab != 'undefined'){
		htmlTabArg = ', "'+htmlTab+'"';
	}
	var moreTabCode = '';
	if(typeof moreTab != 'undefined'){
		moreTabCode = 'SUGAR.themes.updateMoreTab("'+moreTab+'");';
	}
	window.clearTimeout(SUGAR.themes.updateSubTabsTimer);
	SUGAR.themes.updateSubTabsTimer = window.setTimeout('SUGAR.themes.updateSubTabs("'+mainTab+'"'+htmlTabArg+');'+moreTabCode, SUGAR.themes.updateDelay);
}

SUGAR.themes.chooseTab = function(tab){
	Set_Cookie('parentTab',tab,30,'/','','');
}
