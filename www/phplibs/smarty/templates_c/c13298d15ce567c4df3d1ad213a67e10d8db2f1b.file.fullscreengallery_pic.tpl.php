<?php /* Smarty version Smarty-3.1.11, created on 2013-08-25 13:11:35
         compiled from "phplibs/smarty/templates/fullscreengallery_pic.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1180960168521a64f7ba6383-74090215%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c13298d15ce567c4df3d1ad213a67e10d8db2f1b' => 
    array (
      0 => 'phplibs/smarty/templates/fullscreengallery_pic.tpl',
      1 => 1356963455,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1180960168521a64f7ba6383-74090215',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pictureName' => 0,
    'fullScreenPicRate' => 0,
    'fullScreenPicDetails' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_521a64f7c03398_85513452',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521a64f7c03398_85513452')) {function content_521a64f7c03398_85513452($_smarty_tpl) {?><img id="fullScreenPic" src="images/gallary/mini/<?php echo $_smarty_tpl->tpl_vars['pictureName']->value;?>
.jpg">
<div class="fullScreenPicRate"><?php echo $_smarty_tpl->tpl_vars['fullScreenPicRate']->value;?>
</div>
<div class="fullScreenPicDetails"><?php echo $_smarty_tpl->tpl_vars['fullScreenPicDetails']->value;?>
</div><?php }} ?>