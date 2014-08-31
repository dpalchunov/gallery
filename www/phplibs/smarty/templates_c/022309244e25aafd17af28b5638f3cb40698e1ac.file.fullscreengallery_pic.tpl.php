<?php /* Smarty version Smarty-3.1.11, created on 2012-12-31 18:17:37
         compiled from "phplibs\smarty\templates\fullscreengallery_pic.tpl" */ ?>
<?php /*%%SmartyHeaderCode:134495054f27d7d8e28-66828954%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '022309244e25aafd17af28b5638f3cb40698e1ac' => 
    array (
      0 => 'phplibs\\smarty\\templates\\fullscreengallery_pic.tpl',
      1 => 1356963455,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134495054f27d7d8e28-66828954',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5054f27d86d8e4_61018238',
  'variables' => 
  array (
    'pictureName' => 0,
    'fullScreenPicRate' => 0,
    'fullScreenPicDetails' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5054f27d86d8e4_61018238')) {function content_5054f27d86d8e4_61018238($_smarty_tpl) {?><img id="fullScreenPic" src="images/gallary/mini/<?php echo $_smarty_tpl->tpl_vars['pictureName']->value;?>
.jpg">
<div class="fullScreenPicRate"><?php echo $_smarty_tpl->tpl_vars['fullScreenPicRate']->value;?>
</div>
<div class="fullScreenPicDetails"><?php echo $_smarty_tpl->tpl_vars['fullScreenPicDetails']->value;?>
</div><?php }} ?>