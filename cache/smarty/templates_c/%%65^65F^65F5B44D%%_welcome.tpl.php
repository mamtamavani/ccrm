<?php /* Smarty version 2.6.11, created on 2025-05-23 13:37:02
         compiled from themes/Sugar5/tpls/_welcome.tpl */ ?>
<?php if ($this->_tpl_vars['AUTHENTICATED']): ?>
<div id="welcome">
    <?php echo $this->_tpl_vars['APP']['NTC_WELCOME']; ?>
, <strong><a id="welcome_link" href='index.php?module=Users&action=EditView&record=<?php echo $this->_tpl_vars['CURRENT_USER_ID']; ?>
'><?php echo $this->_tpl_vars['CURRENT_USER']; ?>
</a></strong><?php if (! empty ( $this->_tpl_vars['LOGOUT_LINK'] ) && ! empty ( $this->_tpl_vars['LOGOUT_LABEL'] )): ?> [ <a id="logout_link" href='<?php echo $this->_tpl_vars['LOGOUT_LINK']; ?>
' class='utilsLink'><?php echo $this->_tpl_vars['LOGOUT_LABEL']; ?>
</a> ]<?php endif; ?>
</div>
<?php endif; ?>