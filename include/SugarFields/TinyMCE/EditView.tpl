{if empty({{sugarvar key='value' string=true}})}
{assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
{assign var="value" value={{sugarvar key='value' string=true}} }
{/if}

{literal}
<script type="text/javascript" language="Javascript" src="include/javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" language="Javascript">
tinyMCE.init({
mode : "exact",
{/literal}
elements: "{{sugarvar key='name'}}",
{literal}
theme : "advanced"
});
</script>
{/literal}
<textarea id="{{sugarvar key='name'}}" name="{{sugarvar key='name'}}" rows="10" cols="60" title='{{$vardef.help}}' tabindex="{{$tabindex}}">
{$value}
</textarea>