# Discuz--
Discuz 特殊主题+Canvas游戏插件开发

pre_plugin_transaction：

  名字	类型	排序规则	属性	空	默认	注释	额外
  
  id主键	int(8)			否	无		AUTO_INCREMENT
  
  tid	int(8)		UNSIGNED	否	无		
  
  uid	int(8)		UNSIGNED	否	无	
  
  price	int(8)		UNSIGNED	否	无
  
  number	int(8)		UNSIGNED	否	无
  
  wx	varchar(50)	utf8_general_ci		否	无
  
  zfb	varchar(50)	utf8_general_ci		否	无
  
  buyer	int(8)		UNSIGNED	是	NULL
  
  c_time	datetime			否	无	
  
  e_time	datetime			是	NULL
  
  b_time	datetime			是	NULL	
  
  p_time	datetime			是	NULL	
  
  f_time	datetime			是	NULL
  
  status	varchar(10)	utf8_general_ci		否	无
  
  
  后台配置：
  Phildreamc_extcredit	extcredit	扩展积分(extcredit)
