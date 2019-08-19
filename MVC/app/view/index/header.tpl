<!doctype html>
<html>
<head>
<title>{$data.web_name}</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/iconfont.css">
<script type="text/javascript" src="js/jquery18.js"></script>
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
{* 导航栏 *}
<div class="nav-list">
  <div class="nav">
    <ul class="topnav">
      <li class="no_sub active">
        <a><p>首页</p></a>
      </li>
      {foreach $data.navs key="nav_key" item="nav"}
        <li class="game">
          <a>{$nav.type}</a>
          <div class="sub-nav" style="display:none;">
            <ul>
              {foreach $nav.list key="list_key" item="list"}
                <li>
                  <div class="bg">
                    <div class="gameWord" style="top: 23px;">
                    <p class="gamew1">{$list.name}</p>
                    <p class="gamew2">{$list.group}</p>
                  </div>
                  <div class="buttonbg">
                    <button>进入游戏</button>
                  </div>
                </li>
              {/foreach}
            </ul>
          </div>
        </li>
      {/foreach}
    </ul>
  </div>
</div>