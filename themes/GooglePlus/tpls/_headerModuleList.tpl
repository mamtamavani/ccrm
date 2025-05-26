{assign var='underscore' value='_'}
<div id="topNav">
	<div class="yuimenubar yuimenubarnav" id="moduleList">
	{foreach from=$groupTabs item=tabGroup key=tabGroupName name=tabGroups}
	{* This is a little hack for Smarty, to make the ID's match up for compatibility *}
	{if $tabGroupName == 'All'}
		{assign var='groupTabId' value=''}
	{else}
		{assign var='groupTabId' value=$tabGroupName$underscore}
	{/if}
	  
		<div id="themeTabGroupMenu_{$tabGroupName}" class="themeTabGroupMenu yuimenubar yuimenubarnav">
			<div class="bd" id="themeTabGroup_{$tabGroupName}"  style="{if $tabGroupName != $currentGroupTab}display:none;{/if}">
				<ul class="first-of-type">
			  
				{if $USE_GROUP_TABS}
					<script type="text/javascript">
						sugar_theme_gm_current = '{$currentGroupTab}';
						Set_Cookie('sugar_theme_gm_current','{$currentGroupTab}',30,'/','','');
					</script>
					{* Tab group selection *}
					<li class="yuimenubaritem moduleTabGroupMenu">
						<a href="#" class="yuimenuitemlabel more group" title="{$tabGroupName}">{$tabGroupName}<img src="{sugar_getimagepath file="grouped-menu-arrow.png"}" class="arrow"></a>
						<div id="TabGroupMenu_{$tabGroupName}" class="yuimenu dashletPanelMenu">
							<div class="bd">
								<ul>
									{foreach from=$groupTabs item=module key=group name=groupList}
									<li><a href="javascript:(sugar_theme_gm_switch('{$group}') && false)" class="yuimenuitemlabel">{$group}</a></li>
									{/foreach}
								</ul>
							</div>
							<div class="clear"></div>
						</div> 
					</li>
				{/if}
		
				{foreach from=$tabGroup.modules item=module key=name name=moduleList}
					{if $name == $MODULE_TAB}
					<li class="yuimenubaritem {if $smarty.foreach.moduleList.index == 0}first-of-type{/if} current">{sugar_link id="moduleTab_$groupTabId$name" module=$name data=$module class="yuimenuitemlabel"}
					{else}
					<li class="yuimenubaritem {if $smarty.foreach.moduleList.index == 0}first-of-type{/if}">{sugar_link id="moduleTab_$groupTabId$name" module=$name data=$module class="yuimenuitemlabel"}
					{/if}
					{if $shortcutTopMenu.$name}
						<div id="{$groupTabId}{$name}" class="yuimenu dashletPanelMenu">
							<div class="bd">
								<ul class="shortCutsUl">
								<li class="yuimenuitem"><span>{$APP.LBL_LINK_ACTIONS}<span></li>
								{foreach from=$shortcutTopMenu.$name item=shortcut_item}
								  {if $shortcut_item.URL == "-"}
									<hr style="margin-top: 2px; margin-bottom: 2px" />
								  {else}
									 <li class="yuimenuitem"><a href="{sugar_ajax_url url=$shortcut_item.URL}" class="yuimenuitemlabel">{$shortcut_item.LABEL}</a></li>
								  {/if}
								{/foreach}
								</ul>
								{if $groupTabId}
								<ul id="lastViewedContainer{$tabGroupName}_{$name}" class="lastViewedUl"><li class="yuimenuitem"><span>{$APP.LBL_LAST_VIEWED}</span></li><li class="yuimenuitem" id="shortCutsLoading{$tabGroupName}_{$name}"><a href="#" class="yuimenuitemlabel">&nbsp;</a></li></ul>
								{else}
								<ul id="lastViewedContainer{$name}" class="lastViewedUl"><li class="yuimenuitem"><span>{$APP.LBL_LAST_VIEWED}</span></li><li class="yuimenuitem" id="shortCutsLoading{$tabGroupName}_{$name}"><a href="#" class="yuimenuitemlabel">&nbsp;</a></li></ul>
								{/if}
							</div>
							<div class="clear"></div>
						</div>      
					{/if}
					</li>
				{/foreach}
		
				{if count($tabGroup.extra) > 0}
					<li class="yuimenubaritem moduleTabExtraMenu more" id="moduleTabExtraMenu{$tabGroupName}">
						<a href="#" class="yuimenuitemlabel more">More »</a>
						<div id="More{$tabGroupName}" class="yuimenu dashletPanelMenu">
							<div class="bd">
								<ul>
									{foreach from=$tabGroup.extra item=name key=module name=moduleList}
									<li>{sugar_link id="moduleTab_$groupTabId$module" class="yuimenuitemlabel" module="$module" data="$name"}
									{/foreach}
								</ul>
							</div>
							<div class="clear"></div>
						</div> 
					</li>
				{/if}
					
			</ul>            
		</div>
	{/foreach}
	</div>
</div>

{include file="_globalLinks.tpl" theme_template=true}

<div class="clear"></div>
</div>