<?php /* Smarty version Smarty-3.1.11, created on 2013-08-25 13:10:42
         compiled from "phplibs/smarty/templates/td.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1793160985521a64c2d49237-00448585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d75d46e91f49ae2b299260da1bc491994f3e614' => 
    array (
      0 => 'phplibs/smarty/templates/td.tpl',
      1 => 1356674243,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1793160985521a64c2d49237-00448585',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'picRate' => 0,
    'sequenceNumber' => 0,
    'pictureNum' => 0,
    'picDescription' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_521a64c2de2b78_30061376',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521a64c2de2b78_30061376')) {function content_521a64c2de2b78_30061376($_smarty_tpl) {?><td>
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