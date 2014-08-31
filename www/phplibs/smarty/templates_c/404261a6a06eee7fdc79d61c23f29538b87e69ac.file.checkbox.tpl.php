<?php /* Smarty version Smarty-3.1.11, created on 2012-10-22 23:39:44
         compiled from "phplibs\smarty\templates\checkbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1847503031db8bf875-88160046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '404261a6a06eee7fdc79d61c23f29538b87e69ac' => 
    array (
      0 => 'phplibs\\smarty\\templates\\checkbox.tpl',
      1 => 1350934782,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1847503031db8bf875-88160046',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_503031db931198_50765604',
  'variables' => 
  array (
    'classificatorID' => 0,
    'indents' => 0,
    'checkbox_name' => 0,
    'parent_name' => 0,
    'checkbox_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_503031db931198_50765604')) {function content_503031db931198_50765604($_smarty_tpl) {?>
    <div class="checkbox_wrapper" classificator_id="<?php echo $_smarty_tpl->tpl_vars['classificatorID']->value;?>
">
        <?php echo $_smarty_tpl->tpl_vars['indents']->value;?>

        <div class=checkbox_essence>
            <input class="classificator_value" type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['checkbox_name']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['checkbox_name']->value;?>
" parent="<?php echo $_smarty_tpl->tpl_vars['parent_name']->value;?>
" classificator_id="<?php echo $_smarty_tpl->tpl_vars['classificatorID']->value;?>
"> 
            <div class="fake_checkbox" checkbox_id="<?php echo $_smarty_tpl->tpl_vars['checkbox_name']->value;?>
"><img src="images/panel/checkmark_gray.png" class="fake_checkbox_img"></div>            
            <div class="classificator_value_text"><?php echo $_smarty_tpl->tpl_vars['checkbox_text']->value;?>
</div>
        </div>
    </div>
<?php }} ?>