<?php
require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldTinyMCE extends SugarFieldBase {

function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
$this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
return $this->fetch('include/SugarFields/Fields/TinyMCE/EditView.tpl');
}

}
?>