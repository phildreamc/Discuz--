<div id="mainContent">
  <div id="snowflake">
  
    <div class="banner">
      <div class="banner-img-box">
        {foreach $data.banners key="banner_key" item="url"}
          <a><img src="{$url}"></a>
        {/foreach}
      </div>
      <div class="adv-btns">
        {foreach $data.banners key="banner_key" item="url"}
          <a href=""javascript:void(0);"></a>
        {/foreach}
      </div>
    </div>
    
    <div class="txtMarquee-left">
      <div class="block">
        <div class="iconfont icon-tongzhi2"></div>
        <p>公告：</p>
        <div class="bd">
          <div class="temWrap">
            <ul class="infoList">
              {foreach $data.announcement key="announcement_key" item="a"}
                <li><a>{$announcement_key + 1}.{$a}</a></li>
              {/foreach}
              <li><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
              {foreach $data.announcement key="announcement_key" item="a"}
                <li><a>{$announcement_key + 1}.{$a}</a></li>
              {/foreach}
              <li><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="wp main clearfix"> 
     <div class="blockTitle"> 
      <i class="iconfont icon-meihua1"></i>棋牌游戏 
      <span class="more"><a href="/chess.jsp"> &nbsp;&nbsp;更多▶</a></span> 
     </div> 
     <div class="in_banner banner_stl slideBox" id="slideChess"> 
      <div class="bd fl"> 
       <ul> 
        <li class="asChess-banner bannerChess" onclick="qpGo('/chess.jsp?qipai=as')" style="display: none;"> 
         <div class="gameChessBox"> 
          <div class="gameChess" onclick="asGame('CSD')">
           <img src="img/gameChessAS1.png" /> 
          </div> 
          <div class="gameChess" onclick="asGame('ASBR')">
           <img src="img/gameChessAS2.png" /> 
          </div> 
          <div class="gameChess" onclick="asGame('JSYS')">
           <img src="img/gameChessAS3.png" /> 
          </div> 
         </div> 
         <div class="block-bottom"> 
          <p class="fl">AS真人棋牌</p> 
          <p class="fr">热门指数 <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> </p> 
         </div> </li> 
        <li class="dtChess-banner bannerChess" onclick="qpGo('/chess.jsp?qipai=dt')" style="display: none;"> 
         <div class="gameChessBox"> 
          <div class="gameChess" onclick="dtGame('ershiyidian520')">
           <img src="img/gameChessDT21.png" />
          </div> 
          <div class="gameChess" onclick="dtGame('jinhua520')">
           <img src="img/gameChessDT2.png" />
          </div> 
          <div class="gameChess" onclick="dtGame('qznn520')">
           <img src="img/gameChessDT3.png" /> 
          </div> 
         </div> 
         <div class="block-bottom"> 
          <p class="fl">DT棋牌</p> 
          <p class="fr">热门指数 <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-starmarkhighlightbookmarksave"></i> </p> 
         </div> </li> 
        <li class="kyChess-banner bannerChess" onclick="qpGo('/chess.jsp?qipai=hl')" style="display: list-item;"> 
         <div class="gameChessBox"> 
          <div class="gameChess" onclick="hlqp('dice')">
           <img src="img/HL1.png" />
          </div> 
          <div class="gameChess" onclick="hlqp('qzpj')">
           <img src="img/HL2.png" />
          </div> 
          <div class="gameChess" onclick="hlqp('ebg')">
           <img src="img/HL3.png" />
          </div> 
         </div> 
         <div class="block-bottom"> 
          <p class="fl">欢乐棋牌</p> 
          <p class="fr">热门指数 <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-star"></i> <i class="iconfont icon-starmarkhighlightbookmarksave"></i> </p> 
         </div> </li> 
       </ul> 
      </div> 
      <div class="hd fl"> 
       <ul> 
        <li class=""> 
         <div class="chessImg chessAS"></div> <p>AS真人棋牌</p> </li> 
        <li> 
         <div class="chessImg chessDT"></div> <p>DT棋牌</p> </li> 
        <li class="on"> 
         <div class="chessImg chessKY"></div> <p>欢乐棋牌</p> </li> 
       </ul> 
      </div> 
     </div> 
     <div class="block1 fl"> 
      <div class="blockTitle"> 
       <i class="iconfont icon-slot"></i>热门老虎机 
       <span class="more"><a href="/slotGame.jsp?showtype=PT"> &nbsp;&nbsp;更多▶</a></span> 
       <p class="fr" style="padding-right: 20px;">以小搏大 惊爆奖池</p> 
      </div> 
      <div class="blockBox block-dtSlot fl" id="dtSlot"> 
       <div class="block-content"> 
        <p class="title">DT老虎机</p> 
        <p>细腻的游戏&nbsp;&nbsp;美妙的音乐</p> 
        <p>唤起童年的记忆</p> 
        <button>进入</button> 
       </div> 
      </div> 
      <div class="blockBox block-ptSlot fl" id="ptSlot"> 
       <div class="block-content"> 
        <p class="title">PT老虎机</p> 
        <p>小成本&nbsp;&nbsp;大机会</p> 
        <p>爆千万奖池</p> 
        <button>进入</button> 
       </div> 
      </div> 
      <div class="blockBox block-swSlot fl" id="cq9Slot"> 
       <div class="block-content"> 
        <p class="title">CQ9老虎机</p> 
        <p>经典重现&nbsp;&nbsp;品质选择</p> 
        <p>最细腻的游戏体验</p> 
        <button>进入</button> 
       </div> 
      </div> 
      <div class="blockBox block-mgSlot fl" id="mgSlot"> 
       <div class="block-content"> 
        <p class="title">MG老虎机</p> 
        <p>最畅快的游戏体验</p> 
        <p>最具想象力的电游</p> 
        <button>进入</button> 
       </div> 
      </div> 
     </div> 
     <div class="block2 fr"> 
      <div class="block-Offer"> 
       <i class="iconfont icon-heitao"></i> 
       <i class="iconfont icon-fangkuai"></i> 
       <span>幸运榜</span> 
       <i class="iconfont icon-meihua1"></i> 
       <i class="iconfont icon-hongtao"></i> 
      </div> 
      <div class="block-Lucky fl" id="listLucky"> 
       <div class="block-content"> 
        <div id="luckyScroll"> 
         <div class="contentSc bd"> 
          <div class="tempWrap" style="overflow:hidden; position:relative; height:246px">
           <ul id="j-luckyList" class="luckyList" style="height: 1271px; position: relative; padding: 0px; margin: 0px; top: -832.755px;">
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=180653&amp;extra=page%3D6" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">luc***</span>在《
               <span class="w2">封神榜</span>》喜中
               <span class="w1">13万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=42186&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">ccc***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">285万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=173317&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">dai***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">210万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=221392&amp;extra=page%3D2" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">ccl***</span>在《
               <span class="w2">印加头奖</span>》喜中
               <span class="w1">198万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=132724&amp;extra=page%3D3" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">m58***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">147万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=161682&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">rzu***</span>在《
               <span class="w2">印加头奖</span>》喜中
               <span class="w1">142万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=141647&amp;extra=page%3D7" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">qaz***</span>在《
               <span class="w2">日日生财</span>》喜中
               <span class="w1">136万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=210586&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">ghi***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">135万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=154051&amp;extra=page%3D2" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">abc***</span>在《
               <span class="w2">印加头奖</span>》喜中
               <span class="w1">133万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=131053" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">tbz***</span>在《
               <span class="w2">六福兽</span>》喜中
               <span class="w1">108万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=142600&amp;extra=page%3D2" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">K68***</span>在《
               <span class="w2">翡翠公主</span>》喜中
               <span class="w1">102万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=114129&amp;extra=page%3D2" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">dem***</span>在《
               <span class="w2">小丑系列</span>》喜中
               <span class="w1">100万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=224161&amp;extra=page%3D7" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">xia***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">96万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=205533&amp;extra=page%3D5" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">lov***</span>在《
               <span class="w2">禁锢王座</span>》喜中
               <span class="w1">92万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=46597&amp;extra=page%3D3" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">zj5***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">70万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=226110&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">zsw***</span>在《
               <span class="w2">老夫子</span>》喜中
               <span class="w1">64万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=166496&amp;extra=page%3D4" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">fzj***</span>在《
               <span class="w2">黄金之地</span>》喜中
               <span class="w1">57万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=32221" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">w11***</span>在《
               <span class="w2">飞龙在天</span>》喜中
               <span class="w1">50万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=48905" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">wei***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">50万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=50606&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">jqj***</span>在《
               <span class="w2">翡翠公主</span>》喜中
               <span class="w1">48万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=30772&amp;extra=page%3D2" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">xb1***</span>在《
               <span class="w2">飞龙在天</span>》喜中
               <span class="w1">43万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=200284&amp;extra=page%3D5" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">bin***</span>在《
               <span class="w2">黄金之地</span>》喜中
               <span class="w1">42.8万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=87655&amp;extra=page%3D3" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">tyz***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">32万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=54502&amp;extra=page%3D8" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">xys***</span>在《
               <span class="w2">小丑系列</span>》喜中
               <span class="w1">20万</span>奖池
              </div></a></li>
            <li style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=180653&amp;extra=page%3D6" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">luc***</span>在《
               <span class="w2">封神榜</span>》喜中
               <span class="w1">13万</span>奖池
              </div></a></li>
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=42186&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">ccc***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">285万</span>奖池
              </div></a></li>
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=173317&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">dai***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">210万</span>奖池
              </div></a></li>
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=221392&amp;extra=page%3D2" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">ccl***</span>在《
               <span class="w2">印加头奖</span>》喜中
               <span class="w1">198万</span>奖池
              </div></a></li>
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=132724&amp;extra=page%3D3" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">m58***</span>在《
               <span class="w2">年年有余</span>》喜中
               <span class="w1">147万</span>奖池
              </div></a></li>
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=161682&amp;extra=page%3D1" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">rzu***</span>在《
               <span class="w2">印加头奖</span>》喜中
               <span class="w1">142万</span>奖池
              </div></a></li>
            <li class="clone" style="height: 21px;"><a href="https://www.yabobbs.com/forum.php?mod=viewthread&amp;tid=141647&amp;extra=page%3D7" target="_blank">
              <div>
               恭喜玩家
               <span class="w1">qaz***</span>在《
               <span class="w2">日日生财</span>》喜中
               <span class="w1">136万</span>奖池
              </div></a></li>
           </ul>
          </div> 
         </div> 
        </div> 
       </div> 
       <div class="block-hr"> 
        <img src="img/hr.png" /> 
       </div> 
       <div class="jackpotBox"> 
        <p class="title">- 本月累计送出优惠 -</p> 
        <div class="total-prize-pool"> 
         <div class="prize-bg"> 
          <div class="jiangchi jackpot-box"> 
           <div class="money">
            CNY
           </div> 
           <div class="jackpot" id="j-offerJackpotCount">
            <span class="num-item">1</span>
            <span class="num-item">0</span>
            <span class="num-item">,</span>
            <span class="num-item">6</span>
            <span class="num-item">6</span>
            <span class="num-item">0</span>
            <span class="num-item">,</span>
            <span class="num-item">6</span>
            <span class="num-item">5</span>
            <span class="num-item">5</span>
            <span class="num-item">.</span>
            <span class="num-item">7</span>
            <span class="num-item">6</span>
           </div> 
          </div> 
         </div> 
        </div> 
       </div> 
      </div> 
     </div> 
     <div class="block3 fl"> 
      <div class="blockTitle">
       <i class="iconfont icon-pukepuke"></i>更多选择
      </div> 
      <div class="blockBox block-live fl" id="gameLive"> 
       <div class="block-content"> 
        <p>玩家同场竞技</p> 
        <p>唯一百家乐比赛平台</p> 
       </div> 
       <div class="block-bottom"> 
        <p>真人百家乐</p> 
       </div> 
      </div> 
      <div class="blockBox block-sport fl" id="gameSport"> 
       <div class="block-bottom"> 
        <p>体育竞技</p> 
       </div> 
      </div> 
      <div class="blockBox block-fish fl" id="gameFish"> 
       <div class="block-bottom"> 
        <p>捕鱼游戏</p> 
       </div> 
      </div> 
     </div> 
     <div class="block4 fl"> 
      <div class="blockTitle">
       <i class="iconfont icon-pinpai"></i>品牌实力
      </div> 
      <div class="blockBox block-style fl" id="styleBox"> 
       <div class="block-content"> 
        <p class="title">亚博风采</p> 
        <p>百万赞助 见证品牌实力</p> 
       </div> 
      </div> 
      <div class="blockBox block-novice fr" id="noviceBox"> 
       <div class="block-content"> 
        <p class="title">新手学堂</p> 
        <p>贴心教学 我们用心服务</p> 
       </div> 
      </div> 
      <div class="blockBox block-partner fr" id="partnerBox"> 
       <div class="block-content"> 
        <p class="title">合作伙伴</p> 
        <p>月入百万 零投入 高回报</p> 
       </div> 
      </div> 
     </div> 
    </div> 
    
  </div>
</div>