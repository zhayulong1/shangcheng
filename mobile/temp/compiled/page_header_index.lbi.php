
<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?> 
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<script language="javascript"> 
<!--
/*屏蔽所有的js错误*/
function killerrors() { 
return true; 
} 
window.onerror = killerrors; 
//-->

</script>

<a href="catalog.php" class="top_bt"></a>
<a href="flow.php" id='user_btn' class='user_btn'></a>
<a href="javascript:showReg();" id='follow_btn' class='follow_btn' style="display:none; color:#FFF;"  >关注</a>
<div class="new_index_search_mid"> <a href="searchindex.php" > <em>搜索商品</em> <span><img src="themesmobile/prince_jtypmall_mobile/images/icosousuo.png"></span> </a> </div>




<script>
onload = function(){  
        header_login();
}
function header_login()
{	
	Ajax.call('login_act_ajax_top.php', '', loginactResponse, 'GET', 'JSON', '1', '1');
}
function loginactResponse(result)
{
	if(result.user_id>0 && result.got_u==0){
		ChangeUrlParam("u",result.user_id)
	}
	if(result.isfollow==0){
        document.getElementById('user_btn').style.display = 'none';
		document.getElementById('follow_btn').style.display = 'block';
	}
}
function ChangeUrlParam(name,value){
  	var url=window.location.href ;
  	var newUrl="";
	var reg = new RegExp("(^|)"+ name +"=([^&]*)(|$)");
	var tmp = name + "=" + value;
	if(url.match(reg) != null){
		 newUrl= url.replace(eval(reg),tmp);
	}else{
		 if(url.match("[\?]")){
 			newUrl= url + "&" + tmp;
    	}else{
 			newUrl= url + "?" + tmp;
 		}
	}
	var stateObject = {};
	var title = "";
	history.pushState(stateObject,title,newUrl);
}
function showReg(){
                document.getElementById('show_guide_qrcode').style.display = 'block';
}
function closeReg(){
                document.getElementById('show_guide_qrcode').style.display = 'none';
}
</script>