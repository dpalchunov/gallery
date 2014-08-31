<?php /* Smarty version Smarty-3.1.11, created on 2013-08-25 13:10:41
         compiled from "phplibs/smarty/templates/checkbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1543287814521a64c1eede11-69502440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b63c6333262b8f755cc34a57bec75a2befdd337d' => 
    array (
      0 => 'phplibs/smarty/templates/checkbox.tpl',
      1 => 1350934782,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1543287814521a64c1eede11-69502440',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'classificatorID' => 0,
    'indents' => 0,
    'checkbox_name' => 0,
    'parent_name' => 0,
    'checkbox_text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_521a64c2057b07_86183570',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521a64c2057b07_86183570')) {function content_521a64c2057b07_86183570($_smarty_tpl) {?>
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