<?php
/* Smarty version 3.1.33, created on 2019-08-03 03:31:54
  from 'C:\wamp\www\Phil\app\view\Index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d45002ad5d101_71194843',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '214bc716a8353c4cd78468d0ceafa4c0b0f82e5e' => 
    array (
      0 => 'C:\\wamp\\www\\Phil\\app\\view\\Index\\index.tpl',
      1 => 1564803111,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:index_body.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5d45002ad5d101_71194843 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, 'header.conf', null, 0);
?>

<?php $_smarty_tpl->_subTemplateRender('file:header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" type="text/css" href="css/index.css">
<?php echo '<script'; ?>
 type="text/javascript" src="js/index.js"><?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:index_body.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
