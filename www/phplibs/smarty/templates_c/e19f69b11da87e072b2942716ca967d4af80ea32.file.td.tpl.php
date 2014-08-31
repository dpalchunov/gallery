<?php /* Smarty version Smarty-3.1.11, created on 2012-12-28 09:59:01
         compiled from "phplibs\smarty\templates\td.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14493503a4fc29c8f71-98306899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e19f69b11da87e072b2942716ca967d4af80ea32' => 
    array (
      0 => 'phplibs\\smarty\\templates\\td.tpl',
      1 => 1356674243,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14493503a4fc29c8f71-98306899',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_503a4fc2be80f6_13633454',
  'variables' => 
  array (
    'picRate' => 0,
    'sequenceNumber' => 0,
    'pictureNum' => 0,
    'picDescription' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_503a4fc2be80f6_13633454')) {function content_503a4fc2be80f6_13633454($_smarty_tpl) {?><td>
    <div class="all_td_space">		
	<div class="rate" align="left"><?php echo $_smarty_tpl->tpl_vars['picRate']->value;?>
</div>  
        <img class="small_image" class1="small_image" sequence_number="<?php echo $_smarty_tpl->tpl_vars['sequenceNumber']->value;?>
" src="images/gallary/sketches/<?php echo $_smarty_tpl->tpl_vars['pictureNum']->value;?>
.jpg">              
        <div class="details" align="left"><div class="details_inner"><p><?php echo $_smarty_tpl->tpl_vars['picDescription']->value;?>
</p></div></div>                            
    </div>
</td>

<?php }} ?>