<?php /* Smarty version Smarty-3.1.11, created on 2013-08-25 13:10:42
         compiled from "phplibs/smarty/templates/classificator.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1484006330521a64c2067ff7-12801466%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa8082123060f093383f93705be89e0eaa0239d5' => 
    array (
      0 => 'phplibs/smarty/templates/classificator.tpl',
      1 => 1347201520,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1484006330521a64c2067ff7-12801466',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'classificatorID' => 0,
    'classificatorName' => 0,
    'classificatorBody' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_521a64c207e1e3_85902278',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521a64c207e1e3_85902278')) {function content_521a64c207e1e3_85902278($_smarty_tpl) {?><div class="classificator_header" classificator_id="<?php echo $_smarty_tpl->tpl_vars['classificatorID']->value;?>
"><div class="classificator_header_text"><?php echo $_smarty_tpl->tpl_vars['classificatorName']->value;?>
</div><div class="clear_btn"></div></div>
<div class="classificator_body" classificator_id="<?php echo $_smarty_tpl->tpl_vars['classificatorID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['classificatorBody']->value;?>
</div><?php }} ?>