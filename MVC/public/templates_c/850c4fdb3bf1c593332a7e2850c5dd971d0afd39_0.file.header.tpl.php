<?php
/* Smarty version 3.1.33, created on 2019-08-03 03:05:24
  from 'C:\wamp\www\Phil\app\view\Index\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d44f9f4c680f6_02163307',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '850c4fdb3bf1c593332a7e2850c5dd971d0afd39' => 
    array (
      0 => 'C:\\wamp\\www\\Phil\\app\\view\\Index\\header.tpl',
      1 => 1564801146,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d44f9f4c680f6_02163307 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['data']->value['web_name'];?>
</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/iconfont.css">
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery18.js"><?php echo '</script'; ?>
>
</head>
<body>
<div class="header" id="rt">
  <div class="top-bar">
    <div class="nav-header">
      <ul class="ul-links fl">
        <li>
          <a href="" target="_blank">官方论坛</a></li>
        <li id="license" style="cursor: pointer">牌照展示</li>
        <li id="qr-phone">
          <i class="iconfont icon-iconset0228"></i>
          <div class="phone-bg">
            <div class="erweima-box-t">
              <canvas width="150" height="150"></canvas>
            </div>
            <p>下载APP领彩金</p>
          </div>
        </li>
      </ul>
      <ul class="ul-links fr">
        <li>
          <i class="iconfont icon-zhengque"></i>正在处理提款：
          <span class="c-gold withdraw-msg">111</span>笔</li>
        <li>
          <i class="iconfont icon-shijian"></i>平均到账时间：
          <span class="c-gold">5</span>分钟</li>
        <li class="daohang">
          <a href="">帮助中心</a></li>
      </ul>
    </div>
  </div>
  <div class="login-bar">
    <div class="logo fl">
      <a class="f1" style="margin-top:10px;">
        <img src="img/logo.png" style="margin-top:10px;" />
      </a>
    </div>
    <div class="link fr">
      <div>
        <a href="javascript:void(0);" id="login_btn" class="t1 btn-khaki">立即登录</a>
        <a href="" id="zc" class="t1 btn-org">快速注册</a></div>
    </div>
  </div>
</div>
<div class="nav-list">
  <div class="nav">
    <ul class="topnav">
      <li class="no_sub active">
        <a><p>首页</p></a>
      </li>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['navs'], 'nav', false, 'nav_key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['nav_key']->value => $_smarty_tpl->tpl_vars['nav']->value) {
?>
        <li class="game">
          <a><?php echo $_smarty_tpl->tpl_vars['nav']->value['type'];?>
</a>
          <div class="sub-nav" style="display:none;">
            <ul>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['nav']->value['list'], 'list', false, 'list_key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['list_key']->value => $_smarty_tpl->tpl_vars['list']->value) {
?>
                <li>
                  <div class="bg">
                    <div class="gameWord" style="top: 23px;">
                    <p class="gamew1"><?php echo $_smarty_tpl->tpl_vars['list']->value['name'];?>
</p>
                    <p class="gamew2"><?php echo $_smarty_tpl->tpl_vars['list']->value['group'];?>
</p>
                  </div>
                  <div class="buttonbg">
                    <button>进入游戏</button>
                  </div>
                </li>
              <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
          </div>
        </li>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
  </div>
</div><?php }
}
