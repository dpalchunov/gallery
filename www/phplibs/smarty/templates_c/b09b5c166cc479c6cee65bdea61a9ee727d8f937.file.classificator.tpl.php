<?php /* Smarty version Smarty-3.1.11, created on 2012-09-09 18:39:18
         compiled from "phplibs\smarty\templates\classificator.tpl" */ ?>
<?php /*%%SmartyHeaderCode:174815042549e893434-02079829%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b09b5c166cc479c6cee65bdea61a9ee727d8f937' => 
    array (
      0 => 'phplibs\\smarty\\templates\\classificator.tpl',
      1 => 1347201520,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '174815042549e893434-02079829',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5042549e91bc56_14106407',
  'variables' => 
  array (
    'classificatorID' => 0,
    'classificatorName' => 0,
    'classificatorBody' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5042549e91bc56_14106407')) {function content_5042549e91bc56_14106407($_smarty_tpl) {?><div class="classificator_header" classificator_id="<?php echo $_smarty_tpl->tpl_vars['classificatorID']->value;?>
"><div class="classificator_header_text"><?php echo $_smarty_tpl->tpl_vars['classificatorName']->value;?>
</div><div class="clear_btn"></div></div>
<div class="classificator_body" classificator_id="<?php echo $_smarty_tpl->tpl_vars['classificatorID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['classificatorBody']->value;?>
</div><?php }} ?>