<?php 
//Start the session 
session_start(); 
    //设置时区(中国标准时间)
    date_default_timezone_set('PRC');
    // 获取当前时间
	$nowDate = date('Y-m-d');
	$mintian=strtotime("tomorrow");
	$tomorrowDate = date('Y-m-d', $mintian);

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>达旗一中教育管理信息系统</title>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" href="css/style.css">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script src="js/distpicker.js"></script>
	<script src="js/clipboard.min.js"></script>

</head>
<body>
     <?php 
    // 引入 loginYz.php 文件
    require_once("loginYz.php"); 
    //登录状态显示用户名，未登录显示登录表单
    loggedIn(); 
    ?>
	<!-- 学生管理页 -->
	<div data-role="page" id="index">
		<div data-role="header" data-theme="b">
			<div data-role="navbar">
				<ul>
					<li><a href="#index" class="ui-btm-active ui-state-persist">学生管理</a></li>
					<li><a href="notice_list.php">通知公告</a></li>
					<li><a href="#teacherPage">教师办公</a></li>
					<li><a href="#ortherPage">系统管理</a></li>
				</ul>
			</div>
			<!-- <h1>达旗一中学生管理</h1> -->
			<span>嗨！ <?php echo $_SESSION['user_name'] ?> 今天是：<?php echo date("Y/m/d") ?></span>
		</div>
		<!-- 学生个体管理模块 -->
		<div role="main" class="ui-content" id="div_stn">
			<div class="ui-grid-b">
				<div class="ui-block-a">
					<p id="studentsListShowHide">个体管理：</p>
				</div>
				<div class="ui-block-b">
					<!-- <label for="stdnt_name">个体：</label> -->
					<input type="text" name="stdnt_name" id="stdnt_name" placeholder="姓名或胸卡号">
				</div>
				<div class="ui-block-c">
					<input type="button" value="搜索" id="search_submit" data-mini="true">
				</div>
			</div>
				<ul data-role="listview" data-inset="true" id="stdntList">
				</ul>

			<hr>
			<!--学生管理分列菜单-->
			<p id="stdntMenuShowHide">群体管理:</p>
			<div id="stdntMenu">
				<div class="ui-grid-b">
					<div class="ui-block-a">
						<a href="#stdntHmcPage" data-role="button" data-mini="true">花名册</a><br>
						<a href="#stdntWzxPage" data-role="button" data-mini="true">晚自习名单</a><br>
						<a href="#zxsMdBjPgae" data-role="button" data-mini="true">住校生名单</a><br>
						<a href="#xsMhcxPgae" data-role="button" data-mini="true">模糊查询</a><br>
					</div>
					<div class="ui-block-b">
						<a href="#qjCurrentPgae" data-role="button" data-mini="true">学生假条</a><br>
						<a href="zxs_qj_batch.php" data-role="button" data-mini="true">批量请假</a><br>
						<a href="stdnt_crb_list.php" data-role="button" data-mini="true">晨午检记录</a><br>
					</div>
					<div class="ui-block-c">
						<a href="#wjMainPage" data-role="button" data-mini="true">违纪记录</a><br>
						<a href="#jfMainPage" data-role="button" data-mini="true">加分记录</a><br>
						<a href="#dyfMainPage" data-role="button" data-mini="true">德育成绩</a><br>
						<a href="#zxsglPage" data-role="button" data-mini="true">住校生管理</a><br>				
					</div>
				</div>
			</div>
			<!-- 扣分 -->
			<div class="ui-corner-all" id="popupKoufen" data-role="popup">
				<h4>学生违纪扣分</h4>
				<form id="callAjaxForm">  
                <div data-role="fieldcontain">  
                	<fieldset class="ui-grid-a">
                		<div class="ui-block-a">
		                    <label for="kfNj" data-mini="true">年级：</label>
		                    <input type="text" data-mini="true" name="kfNj" id="kfNj" value="" readonly>
	                		<label for="kfXm" data-mini="true">姓名</label>
		                    <input type="text" data-mini="true" name="kfXm" id="kfXm" value="" readonly>
                		</div>
        				<div class="ui-block-b">
        					<label for="kfBj" data-mini="true">班级：</label>
		                    <input type="number" data-mini="true" name="kfBj" id="kfBj" value="" readonly>
                			<label for="kfXh" data-mini="true">胸卡号：</label>
		                    <input type="text" data-mini="true" name="kfXh" id="kfXh" value="" readonly>
		                </div>
                	</fieldset>
                    <label for="kfWjqk" data-mini="true">违纪情况</label>
                    <input type="text" data-mini="true" name="kfWjqk" id="kfWjqk" placeholder="请描述违纪情况">
                    <fieldset class="ui-grid-a">
                    	<div class="ui-block-a">
                    		<label for="kfWjrq" data-mini="true">违纪日期</label>
		                    <input type="date" data-mini="true" name="kfWjrq" id="kfWjrq" value="<?php echo $nowDate ?>">
		                    <label for="kfKcfs" data-mini="true">扣分：</label>
		                    <input type="number" data-mini="true" name="kfKcfs" id="kfKcfs" min="1" max="30">
                    	</div>
                    	<div class="ui-block-b">
                    		<label for="kfJcr" data-mini="true">检查人：</label>
		                    <input type="text" data-mini="true" name="kfJcr" id="kfJcr" value="<?php echo $_SESSION['user_name'] ?>">
		                    <label for="kfLrr" data-mini="true">录入人：</label>
		                    <input type="text" data-mini="true" name="kfLrr" id="kfLrr" value="<?php echo $_SESSION['user_name'] ?>" readonly>
                    	</div>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <input type="submit" id="kfSubmit" value="确定" data-mini="true">
                </div>  
            </form>  
			</div>
			<div class="ui-corner-all" id="popupJiafen" data-role="popup">
				<h4>好人好事加分</h4>
				<form id="jiafenForm">  
                <div data-role="fieldcontain">  
                	<fieldset class="ui-grid-a">
                		<div class="ui-block-a">
		                    <label for="jfNj" data-mini="true">年级：</label>
		                    <input type="text" data-mini="true" name="jfNj" id="jfNj" value="" readonly>
	                		<label for="jfXm" data-mini="true">姓名</label>
		                    <input type="text" data-mini="true" name="jfXm" id="jfXm" value="" readonly>
                		</div>
        				<div class="ui-block-b">
        					<label for="jfBj" data-mini="true">班级：</label>
		                    <input type="number" data-mini="true" name="jfBj" id="jfBj" value="" readonly>
                			<label for="jfXh" data-mini="true">胸卡号：</label>
		                    <input type="text" data-mini="true" name="jfXh" id="jfXh" value="" readonly>
		                </div>
                	</fieldset>
                    <label for="jfqk" data-mini="true">加分原因</label>
                    <input type="text" data-mini="true" name="jfqk" id="jfqk">
                    <fieldset class="ui-grid-a">
                    	<div class="ui-block-a">
                    		<label for="jfrq" data-mini="true">加分日期</label>
		                    <input type="date" data-mini="true" name="jfrq" id="jfrq" value="<?php echo $nowDate ?>">
		                    <label for="jffs" data-mini="true">加分值：</label>
		                    <input type="number" data-mini="true" name="jffs" id="jffs" min="1" max="5">
                    	</div>
                    	<div class="ui-block-b">
                    		<label for="jfZmr" data-mini="true">证明人：</label>
		                    <input type="text" data-mini="true" name="jfZmr" id="jfZmr" value="<?php echo $_SESSION['user_name'] ?>">
		                    <label for="jfLrr" data-mini="true">录入人：</label>
		                    <input type="text" data-mini="true" name="jfLrr" id="jfLrr" value="<?php echo $_SESSION['user_name'] ?>" readonly>
                    	</div>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <input type="submit" id="jfSubmit" value="确定" data-mini="true">
                </div>  
            </form>  
			</div>
		</div>
		<div data-role="footer" data-theme="b">
			<h4>&copy;天际雪原</h4>
		</div>
	</div>
	<!-- 绑定要查找的学生 -->
	<script>
        var isbind = 0;
        var isAjax=false;

		var getSearchStdnt = function(){
			$.mobile.loading("show");
			if(!$("#stdnt_name").val()){
				alert("请输入学生胸卡号或姓名！");
				$.mobile.loading("hide");
				return false;
			}
			var stdntSearchData = {};
			var stdntSearchUrl = "stdnt_search_post.php";
			stdntSearchData.stdnt_name = $("#stdnt_name").val();
			$.post(stdntSearchUrl, stdntSearchData, function(data,status){
				$("#stdntList").html(data);
				$("#stdntList").listview("refresh");
				$("#stdntList").trigger('create');
				$("#stdntList").show();
			});
			$.mobile.loading("hide");
			return false;
		};

			var getPanduanCaozuo = function(){
				if($(this).attr('data-bz') == "koufen"){
					var strCanshu = $(this).attr('data-canshu').split(",");
					$("#kfXh").val(strCanshu[0]);
					$("#kfNj").val(strCanshu[1]);
					$("#kfBj").val(strCanshu[2]);
					$("#kfXm").val(strCanshu[3]);
				}
				else if($(this).attr('data-bz') == "jiafen"){
					var strCanshu = $(this).attr('data-canshu').split(",");
					$("#jfXh").val(strCanshu[0]);
					$("#jfNj").val(strCanshu[1]);
					$("#jfBj").val(strCanshu[2]);
					$("#jfXm").val(strCanshu[3]);
				}

			};

			var koufenPost = function(){
				$.mobile.loading("show");
				if($("#kfWjqk").val() == ""){
					alert("请输入扣分原因！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#kfWjrq").val() == ""){
					alert("请输入违纪日期！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#kfKcfs").val() == ""){
					alert("请输入扣分分值(0——30分)！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#kfKcfs").val() > 30 || $("#kfKcfs").val() < 1){
					alert("单次扣分范围：1——30分！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#kfJcr").val() == ""){
					alert("请输入检查人！");
					$.mobile.loading("hide");
					return false;
				}
				var kfData = {};
				var yesUrl = "stdnt_kf_post.php";
				kfData.nj = $("#kfNj").val();
				kfData.bj = $("#kfBj").val();
				kfData.xm = $("#kfXm").val();
				kfData.xh = $("#kfXh").val();
				kfData.wjqk = $("#kfWjqk").val();
				kfData.wjrq = $("#kfWjrq").val();
				kfData.kcfs = $("#kfKcfs").val();
				kfData.jcr = $("#kfJcr").val();
				kfData.lrr = $("#kfLrr").val();
				$.post(yesUrl, kfData, function(data,status){
					alert(data);
					// if(data == 1){
					// 	alert("扣分成功！");
					// 	// $("#infoTitle").show();
					// 	// $("#infoTitle").html("扣分失败");
					// }else{
					// 	alert(data)
					// 	// $("#infoTitle").show();
					// 	// $("#infoTitle").html($("#kfXm").val() + data + "条记录扣分成功。");
					// }
					
				});
				$.mobile.loading("hide");
				$("#popupKoufen").popup("close");
				return false;
			};

			// 加分
			var jiafenPost = function(){
				$.mobile.loading("show");
				if($("#jfqk").val() == ""){
					alert("请输入加分原因！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#jfrq").val() == ""){
					alert("请选择加分日期！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#jffs").val() == ""){
					alert("请输入加分分数！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#jffs").val() > 5 || $("#jffs").val() < 1){
					alert("单次加分范围：1——5分！");
					$.mobile.loading("hide");
					return false;
				}
				if($("#jfZmr").val() == ""){
					alert("请输入加分证明人！");
					$.mobile.loading("hide");
					return false;
				}
				var jfData = {};
				var jfUrl = "stdnt_jf_post.php";
				jfData.nj = $("#jfNj").val();
				jfData.bj = $("#jfBj").val();
				jfData.xm = $("#jfXm").val();
				jfData.xh = $("#jfXh").val();
				jfData.jfqk = $("#jfqk").val();
				jfData.jfrq = $("#jfrq").val();
				jfData.jffs = $("#jffs").val();
				jfData.zmr = $("#jfZmr").val();
				jfData.lrr = $("#jfLrr").val();
				$.post(jfUrl, jfData, function(data,status){
					alert(data);
					// if(data == 1){
					// 	alert("加分成功！");
					// // 	$("#infoTitle").show();
					// // $("#infoTitle").html("加分失败");
					// }else{
					// 	alert("加分成功！");
					// // 	$("#infoTitle").show();
					// // $("#infoTitle").html($("#jfXm").val() + data + "条加分记录录入成功。");
					// }
					
				});
				$.mobile.loading("hide");
				$("#popupJiafen").popup("close");
				return false;
			};

		//绑定事件
        var bindIndexEvent = function () {
            $("#search_submit").on("click", getSearchStdnt);
            $("#stdntList").on("click", "a",getPanduanCaozuo);
            $("#kfSubmit").on("click", koufenPost);
            $("#jfSubmit").on("click", jiafenPost);
            $("#studentsListShowHide").on("click", function(e){
            	$("#stdntList").toggle();
            });
            $("#stdntMenuShowHide").on("click", function(e){
            	$("#stdntMenu").toggle();
            	// if($("#stdntMenuShowHide").text() == "显示群体管理菜单"){
            	// 	$("#stdntMenuShowHide").text("隐藏群体管理菜单");
            	// }else if($("#stdntMenuShowHide").text() == "隐藏群体管理菜单"){
            	// 	$("#stdntMenuShowHide").text("显示群体管理菜单");
            	// }
            });
        };

		$(document).on("pageshow", "#index", function(){
            if (isbind) return
            isbind = 1;
            bindIndexEvent();
		});

	</script>

	<!-- 在校生管理页面 -->
	<div data-role="page" id="zxsglPage">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>住校生管理</h4>
		</div>
		<div role="main" class="ui-content">
			<ul data-role="listview">
				<li><a href="#zxsMdSuPgae">宿管查房</a></li>
				<li><a href="stdnt_zxsqj_current.php">住校生当前假条</a></li>
				<li><a href="zxs_md_bj.php">各班住校生名单</a></li>
				<li><a href="zxs_input.php">办理入住</a></li>
				<li><a href="zxs_output.php">办理退宿</a></li>
				<li><a href="zxs_change.php">个别调整宿舍</a></li>
				<li><a href="zxs_cxssh.php">查询住校生宿舍号</a></li>

			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h4>&copy;天际雪原</h4>
		</div>
	</div>

	<!-- 教师办公页面 -->
	<div data-role="page" id="teacherPage">
		<div data-role="header" data-theme="b">
			<div data-role="navbar">
				<ul>
					<li><a href="#index">学生管理</a></li>
					<li><a href="notice_list.php">通知公告</a></li>
					<li><a href="#teacherPage" class="ui-btm-active ui-state-persist">教师办公</a></li>
					<li><a href="#ortherPage">系统管理</a></li>
				</ul>
			</div>
			<!-- <h1>达旗一中教师办公</h1> -->
		</div>
		<div role="main" class="ui-content">
			<ul data-role="listview">
				<li><a href="tch_xzxx.php">校长信箱</a></li>
				<?php if($_SESSION['user_zw_name'] == "校长"){echo "<li><a href='tch_xzxx_list.php'>校长查看信箱</a></li>";} ?>
				<li><a href="tch_lsqj.php">临时外出请假（半天内）</a></li>
				<li><a href="tch_lsqj_list.php">临时假条浏览</a></li>
				<li><a href="tch_qj.php">常规请假条上传（半天以上）</a></li>
				<li><a href="tch_qj_sp_list.php">常规请假条审批</a></li>
				<li><a href="tch_xj_sp_list.php">常规请假条销假</a></li>
				<li><a href="tch_qj_list.php">当前生效常规请假条列表</a></li>
				<li><a href="tch_qj_list_datecx.php">常规请假条按日期范围查询</a></li>
				<li><a href="tch_kh_input.php">课堂管理考核记录录入</a></li>
				<li><a href="tch_kh_list.php">课堂管理考核记录列表</a></li>
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h4>&copy;天际雪原</h4>
		</div>
	</div>

	<div data-role="page" id="ortherPage">
		<div data-role="header" data-theme="b">
			<div data-role="navbar">
				<ul>
					<li><a href="#index">学生管理</a></li>
					<li><a href="notice_list.php">通知公告</a></li>
					<li><a href="#teacherPage">教师办公</a></li>
					<li><a href="#ortherPage" class="ui-btm-active ui-state-persist">系统管理</a></li>
				</ul>
			</div>
			<!-- <h1>系统管理</h1> -->
		</div>
		<div role="main" class="ui-content">
			<ul data-role="listview">
				<li><a href="repassword.php">重置密码</a></li>
				<li><a href="pwdcx.php">查询教职工密码</a></li>
				<li><a href="stdnt_xkbb_qr.php">学生领取胸卡确认</a></li>
				<li><a href="stdnt_input.php">录入新生信息</a></li>
				<li><a href="upload_xsphoto.php">上传学生照片</a></li>
				<li><a href="stdnt_tiaoban.php">学生调班</a></li>
				<li><a href="stdnt_del.php">删除学生</a></li>
				<li><a href="stdnt_recover.php">恢复已删除学生</a></li>
				<li><a href="stdnt_gjxx_update.php">学生关键信息变更</a></li>
				<li><a href="user_add.php">增加职工</a></li>
<!-- 				<li><a href="stdnt_add.php">增加新学生</a></li>
 -->				<li><a href="#ljbysListPage">历届毕业生花名册</a></li>
				<li><a href="#ljbysXmCxPage">历届毕业生查询</a></li>
			</ul>

		</div>
		<div data-role="footer" data-theme="b">
			<h4>&copy;天际雪原</h4>
		</div>
	</div>
	<!-- 德育分查询 -->
		<div data-role="page" id="dyfMainPage">
		<div data-role="header">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>学生德育分查询</h4>
		</div>
		<div data-role="content">
			<a class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-check ui-btn-icon-left ui-btn-a" href="#popupDyfTj" data-transition="pop" data-rel="popup" data-position-to="window">筛选条件</a>
			<div class="ui-corner-all" id="popupDyfTj" data-role="popup" data-theme="b">
				<form id="kfglForm">
					<h3>请选择筛选条件</h3>
					<div data-role="fieldcontain">
						<label for="dyfNj" data-mini="true">年级：</label>
						<input type="range" name="dyfNj" id="dyfNj" value="" min="" max="">
						<label for="dyfBj" data-mini="true">班级：</label>
						<input type="range" name="dyfBj" id="dyfBj" value="0" min="0" max="24">
						<label for="dyfMax" data-mini="true">上限值：</label>
						<input type="number" name="dyfMax" id="dyfMax" value="" data-mini="true">
					</div>
					<div data-role="fieldcontain">
						<input type="submit" id="dyfSubmit" value="查找">
					</div>
				</form>
			</div>
			<ul data-role="listview" data-inset="true" id="dyfList">

			</ul>
		</div>
		<div data-role="footer">
			
		</div>
	</div>
	<!-- 德育分管理代码 -->
	<script>
		var isDyfBind = 0
		var isSetDyfDate = 0;
		// 设置年级滑块
		var setDyfRange = function(){
			if(isSetDyfDate) return;
			isSetDyfDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#dyfNj").attr("min", njMin);
			$("#dyfNj").attr("max", njMax);
			$("#dyfNj").attr("value", njMin).slider("refresh");
		};

		var postDyf = function(){
			$.mobile.loading("show");
			var dyfData = {};
			var dyfUrl = "dyfMainPost.php";
			dyfData.nj = $("#dyfNj").val();
			dyfData.bj = $("#dyfBj").val();
			dyfData.dyfMax = $("#dyfMax").val();
			dyfData.page = 1;
			$.post(dyfUrl, dyfData, function(data,status){
				if(parseInt(data) == 0){
					$("#dyfList").html("");
					alert("未能查询到记录！");
				} else {
					$("#dyfList").html(data);
					$("#dyfList").listview("refresh");
					$("#dyfList").trigger('create');
				}
			});
			$.mobile.loading("hide");
			$("#popupDyfTj").popup("close");
			return false;
		};

		var pageDyfChange = function(urlStr){
			var strUrl=urlStr.split(",");
			var dyfPageData = {};
			var dyfPageUrl = "dyfMainPost.php";
			dyfPageData.nj = strUrl[0];
			dyfPageData.bj = strUrl[1];
			dyfPageData.dyfMax = strUrl[2];
			dyfPageData.page = strUrl[3];
			$.post(dyfPageUrl, dyfPageData, function(data,status){
				$("#dyfList").html("");
				if(parseInt(data) == 0){
					alert("未能查询到记录！请联系管理员。");
				} else {
					$("#dyfList").html(data);
					$("#dyfList").listview("refresh");
					$("#dyfList").trigger('create');
				}
			});
		};

		var postDyfPanduan = function(){

			if($(this).attr('data-bz') == "fanye")
			{
				var urlStr = $(this).attr('data-canshu');
				pageDyfChange(urlStr);
			}
		};

		var bindDyfEvent = function(){
			$("#dyfSubmit").on("click", postDyf);
			$("#dyfList").on("click", "a", postDyfPanduan);
		};

		$(document).on("pageshow", "#dyfMainPage", function(){
			if (isDyfBind) return
			isDyfBind = 1;
			bindDyfEvent();
		});

		$(document).on("pageinit", "#dyfMainPage", function(){
			setDyfRange();
		});
	</script>
	<!-- 违纪记录管理 -->
		<div data-role="page" id="wjMainPage">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h1>学生违纪情况管理</h1>
		</div>
		<div data-role="content">
			<a class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-check ui-btn-icon-left ui-btn-a" href="#popupTiaojian" data-transition="pop" data-rel="popup" data-position-to="window">筛选条件</a>
			<div class="ui-corner-all" id="popupTiaojian" data-role="popup" data-theme="b">
				<form id="kfglForm">
					<h3>请选择筛选条件</h3>
				<div data-role="fieldcontain">
					<label for="nj">年级：</label>
					<input type="range" name="nj" id="nj" value="" min="" max="">
					<label for="bj">班级：</label>
					<input type="range" name="bj" id="bj" value="0" min="0" max="24">
				</div>
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal">
						<legend>请选择记录范围:</legend>
						<input type="radio" name="jllx" id="rd1" value="allRow" checked="checked">
						<label for="rd1">全部记录</label>
						<input type="radio" name="jllx" id="rd2" value="wqrRow">
						<label for="rd2">未确认记录</label>
						<input type="radio" name="jllx" id="rd3" value="wshRow">
						<label for="rd3">未审核记录</label>
					</fieldset>
				</div>
				<div data-role="fieldcontain">
					<input type="submit" id="submit" value="确定">
				</div>
			</form>
			</div>
			<div id="popupWjsh" data-role="popup">
				<form id="wjshForm">
				<div data-role="fieldcontain">
					<label for="shId">记录ID：</label>
					<input type="text" name="shId" id="shId" value="" readonly="true">
					<label for="shXm">姓名：</label>
					<input type="text" name="shXm" id="shXm" value="" readonly="true">
					<label for="shXh">胸卡号：</label>
					<input type="text" name="shXh" id="shXh" value="" readonly="true">
					<label for="shWjqk">违纪情况：</label>
					<input type="text" name="shWjqk" id="shWjqk" value="" readonly="true">
					<label for="shKcfs">请修改分值：</label>
					<input type="number" name="shKcfs" id="shKcfs" value="" min="1" max="30">
				</div>
				<div data-role="fieldcontain">
					<p id="wjTjMsg"></p>
					<input type="submit" id="shSubmit" value="确定">
				</div>
			</form>
			</div>
			<h4 id="wjMsg">学生违纪记录</h4>
			<ul data-role="listview" data-inset="true" id="wjList">

			</ul>
		</div>
	</div>
	<!-- 违纪情况管理js代码 -->
	<script>
		var isWjBind = 0;
		var isWjLoad = 0;
		var isSetDate = 0;
		// 设置年级滑块
		var setRange = function(){
			if(isSetDate) return;
			isSetDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#nj").attr("min", njMin);
			$("#nj").attr("max", njMax);
			$("#nj").attr("value", njMin).slider("refresh");
		};

		var wjLoad = function(){
			if (isWjLoad) return;
			isWjLoad = 1;
			$.mobile.loading("show");
			$.post("wjMainPost.php",
				{
					nj:"all",
					bj:"all",
					jllx:"allRow",
					page:1
				},
				function(data,status){
					$("#wjList").html("");
					$("#wjMsg").html("");
					// var list = $("#wjList");
					if(parseInt(data) == 0){
						$("#wjMsg").html("未能查询到记录！请重新提交申请或联系管理员。");
					} else {
						$("#wjMsg").html("学生违纪记录");
						$("#wjList").html(data);
						$("#wjList").listview("refresh");
						$("#wjList").trigger('create');
					}
			});
			$.mobile.loading("hide");
		};


		var postWjjl = function(){
			$.mobile.loading("show");
			var _data = {};
			var _url = "wjMainPost.php";
			_data.nj = $("#nj").val();
			_data.bj = $("#bj").val();
			_data.jllx = $("input[name='jllx']:checked").val();
			_data.page = 1;
			$.post(_url, _data, function(data,status){
				if(parseInt(data) == 0){
					$("#wjList").html("");
					$("#wjMsg").html("未能查询到记录！请重新提交申请或联系管理员。");
				} else {
					$("#wjMsg").html("学生违纪记录");
					$("#wjList").html(data);
					$("#wjList").listview("refresh");
					$("#wjList").trigger('create');
				}
			});
			$.mobile.loading("hide");
			$("#popupTiaojian").popup("close");
			return false;
		};

		var pageChange = function(urlStr){
			var strUrl=urlStr.split(",");
			var pageData = {};
			var pageUrl = "wjMainPost.php";
			pageData.nj = strUrl[0];
			pageData.bj = strUrl[1];
			pageData.jllx = strUrl[2];
			pageData.page = strUrl[3];
			$.post(pageUrl, pageData, function(data,status){
				$("#wjList").html("");
				$("#wjMsg").html("");
				if(parseInt(data) == 0){
					$("#wjMsg").html("未能查询到记录！请重新提交申请或联系管理员。");
				} else {
					$("#wjMsg").html("学生违纪记录");
					$("#wjList").html(data);
					$("#wjList").listview("refresh");
					$("#wjList").trigger('create');
				}
			});
		};

		var wjQueren = function(urlStr){
			var strUrl = urlStr.split(",")
			var qrData = {};
			var qrUrl = "wjQr.php";
			qrData.id = strUrl[0];
			qrData.xm = strUrl[1];
			qrData.nj = strUrl[2];
			qrData.bj = strUrl[3];
			$.post(qrUrl, qrData, function(data,status){
				$("#wjMsg").html(data);
				// $(this).hide();
			});
		};

		var wjYes = function(urlStr){
			var strUrl=urlStr.split(",");
			var yesData = {};
			var yesUrl = "wjYes.php";
			yesData.id = strUrl[0];
			yesData.xh = strUrl[1];
			yesData.kcfs = strUrl[2];
			yesData.xm = strUrl[3];
			$.post(yesUrl, yesData, function(data,status){
				$("#wjMsg").html(data);
			});
		};

		var wjDel = function(urlStr){
			var strUrl=urlStr.split(",");
			var delData = {};
			var delUrl = "wjDel.php";
			delData.id = strUrl[0];
			delData.wjrq = strUrl[1];
			delData.lrr = strUrl[2];
			delData.kcfs = strUrl[3];
			delData.kcyf = strUrl[4];
			delData.xh = strUrl[5];
			$.post(delUrl, delData, function(data,status){
				$("#wjMsg").html(data);
			});
		};

		var postShjl = function(){
			$.mobile.loading("show");
			if($("#shKcfs").val() == ""){
				alert("请输入扣分分数！(1-30分)");
				$.mobile.loading("hide");
				return false;
			}
			if(($("#shKcfs").val() > 30) || $("#shKcfs").val() < 1){
				alert("单次扣分分值范围：1-30分！");
				$.mobile.loading("hide");
				return false;
			}
			var yesData = {};
			var yesUrl = "wjYes.php";
			yesData.id = $("#shId").val();
			yesData.xh = $("#shXh").val();
			yesData.kcfs = $("#shKcfs").val();
			yesData.xm = $("#shXm").val();
			$.post(yesUrl, yesData, function(data,status){
				$("#wjMsg").html(data);
			});
			$.mobile.loading("hide");
			$("#popupWjsh").popup("close");
			return false;
		};

		var postPanduan = function(){

			if($(this).attr('data-bz') == "fanye")
			{
				var urlStr = $(this).attr('data-canshu');
				pageChange(urlStr);
			}
			else if($(this).attr('data-bz') == "queren")
			{
				var urlStr = $(this).attr('data-canshu');
				wjQueren(urlStr);
			}
			else if($(this).attr('data-bz') == "shtg")
			{
				var urlStr = $(this).attr('data-canshu');
				wjYes(urlStr);
			}
			else if($(this).attr('data-bz') =="shbtg")
			{
				var urlStr = $(this).attr('data-canshu').split(",");
				$("#shId").val(urlStr[0]);
				$("#shXm").val(urlStr[4]);
				$("#shXh").val(urlStr[1]);
				$("#shWjqk").val(urlStr[3]);
				$("#shKcfs").val(urlStr[2]);
				$("#popupWjsh").open();
			}
			else if($(this).attr('data-bz') == "del")
			{
				var urlStr = $(this).attr('data-canshu');
				wjDel(urlStr);
			}
			$(this).hide();
		};

		// 绑定事件
		var bindEvent = function(){
			$("#submit").on("click", postWjjl);
			$("#wjList").on("click", "a", postPanduan);
			$("#shSubmit").on("click", postShjl);
		};

		$(document).on("pageshow", "#wjMainPage", function(){
			if (isWjBind) return
			isWjBind = 1;
			bindEvent();
		});

		$(document).on("pageinit", "#wjMainPage", function(){
			wjLoad();
			setRange();
		});

	</script>

	<!-- 加分记录管理 -->
	<div data-role="page" id="jfMainPage">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>好人好事记录管理</h4>
		</div>
		<div data-role="content">
			<a class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-icon-check ui-btn-icon-left ui-btn-a" href="#popupJfcxtj" data-transition="pop" data-rel="popup" data-position-to="window">筛选条件</a>
			<div class="ui-corner-all" id="popupJfcxtj" data-role="popup" data-theme="b">
				<form id="jfglForm">
					<h3>请选择筛选条件</h3>
				<div data-role="fieldcontain">
					<label for="jfcxNj">年级：</label>
					<input type="range" name="jfcxNj" id="jfcxNj" value="" min="" max="">
					<label for="jfcxBj">班级：</label>
					<input type="range" name="jfcxBj" id="jfcxBj" value="0" min="0" max="24">
				</div>
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal">
						<legend>请选择记录范围:</legend>
						<input type="radio" name="jfJllx" id="jfRd1" value="allRow" checked="checked">
						<label for="jfRd1">全部记录</label>
						<input type="radio" name="jfJllx" id="jfRd2" value="wqrRow">
						<label for="jfRd2">未确认记录</label>
						<input type="radio" name="jfJllx" id="jfRd3" value="wshRow">
						<label for="jfRd3">未审核记录</label>
					</fieldset>
				</div>
				<div data-role="fieldcontain">
					<input type="submit" id="jfcxSubmit" value="确定">
				</div>
			</form>
			</div>
			<div id="popupJfsh" data-role="popup">
				<form id="jfshForm">
				<div data-role="fieldcontain">
					<label for="jfshId">记录ID：</label>
					<input type="text" name="jfshId" id="jfshId" value="" readonly="true">
					<label for="jfshXm">姓名：</label>
					<input type="text" name="jfshXm" id="jfshXm" value="" readonly="true">
					<label for="jfshXh">胸卡号：</label>
					<input type="text" name="jfshXh" id="jfshXh" value="" readonly="true">
					<label for="jfshJfqk">违纪情况：</label>
					<input type="text" name="jfshJfqk" id="jfshJfqk" value="" readonly="true">
					<label for="jfshJffs">请修改分值：</label>
					<input type="number" name="jfshJffs" id="jfshJffs" value="" min="1" max="5">
				</div>
				<div data-role="fieldcontain">
					<p id="jfTjMsg"></p>
					<input type="submit" id="jfshSubmit" value="确定">
				</div>
			</form>
			</div>
			<h4 id="jfMsg">学生加分记录</h4>
			<ul data-role="listview" data-inset="true" id="jfList">

			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<p>&copy 天际雪原</p>
		</div>
	</div>


	<!-- 加分记录管理代码 -->
	<script>
		var isJfBind = 0;
		var isJfLoad = 0;
		var isJfDate = 0;

		// 设置年级滑块
		var setJfRange = function(){
			if(isJfDate) return;
			isJfDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#jfcxNj").attr("min", njMin);
			$("#jfcxNj").attr("max", njMax);
			$("#jfcxNj").attr("value", njMin).slider("refresh");
		};

		// 首次进入加载加分记录
		var jfLoad = function(){
			if (isJfLoad) return;
			isJfLoad = 1;
			$.mobile.loading("show");
			$.post("jfMainPost.php",
				{
					nj:"all",
					bj:"all",
					jllx:"allRow",
					page:1
				},
				function(data,status){
					$("#jfList").html("");
					$("#jfMsg").html("");
					if(parseInt(data) == 0){
						$("#jfMsg").html("未能查询到记录！请重新提交申请或联系管理员。");
					} else {
						$("#jfMsg").html("学生加分记录");
						$("#jfList").html(data);
						$("#jfList").listview("refresh");
						$("#jfList").trigger('create');
					}
			});
			$.mobile.loading("hide");
		};

		var postJfjl = function(){
			$.mobile.loading("show");
			var _data = {};
			var _url = "jfMainPost.php";
			_data.nj = $("#jfcxNj").val();
			_data.bj = $("#jfcxBj").val();
			_data.jllx = $("input[name='jfJllx']:checked").val();
			_data.page = 1;
			$.post(_url, _data, function(data,status){
				if(parseInt(data) == 0){
					$("#jfList").html("");
					$("#jfMsg").html("未能查询到记录！请重新提交申请或联系管理员。");
				} else {
					$("#jfMsg").html("学生加分记录");
					$("#jfList").html(data);
					$("#jfList").listview("refresh");
					$("#jfList").trigger('create');
				}
			});
			$.mobile.loading("hide");
			$("#popupJfcxtj").popup("close");
			return false;
		};

		var jfPageChange = function(urlStr){
			var strUrl=urlStr.split(",");
			var pageData = {};
			var pageUrl = "jfMainPost.php";
			pageData.nj = strUrl[0];
			pageData.bj = strUrl[1];
			pageData.jllx = strUrl[2];
			pageData.page = strUrl[3];
			$.post(pageUrl, pageData, function(data,status){
				$("#jfList").html("");
				$("#jfMsg").html("");
				if(parseInt(data) == 0){
					$("#jfMsg").html("未能查询到记录！请重新提交申请或联系管理员。");
				} else {
					$("#jfMsg").html("学生加分记录");
					$("#jfList").html(data);
					$("#jfList").listview("refresh");
					$("#jfList").trigger('create');
				}
			});
		};

		var jfQueren = function(urlStr){
			var strUrl = urlStr.split(",")
			var qrData = {};
			var qrUrl = "jfQr.php";
			qrData.id = strUrl[0];
			qrData.xm = strUrl[1];
			qrData.nj = strUrl[2];
			qrData.bj = strUrl[3];
			$.post(qrUrl, qrData, function(data,status){
				$("#jfMsg").html(data);
			});
		};

		var jfYes = function(urlStr){
			var strUrl=urlStr.split(",");
			var yesData = {};
			var yesUrl = "jfYes.php";
			yesData.id = strUrl[0];
			yesData.xh = strUrl[1];
			yesData.jffs = strUrl[2];
			yesData.xm = strUrl[3];
			$.post(yesUrl, yesData, function(data,status){
				$("#jfMsg").html(data);
			});
		};

		var jfDel = function(urlStr){
			var strUrl=urlStr.split(",");
			var delData = {};
			var delUrl = "jfDel.php";
			delData.id = strUrl[0];
			delData.jfrq = strUrl[1];
			delData.lrr = strUrl[2];
			delData.jffs = strUrl[3];
			delData.jfyf = strUrl[4];
			delData.xh = strUrl[5];
			$.post(delUrl, delData, function(data,status){
				$("#jfMsg").html(data);
			});
		};

		var postJfShjl = function(){
			$.mobile.loading("show");
			if($("#jfshJffs").val() == ""){
				alert("请输入加分分数！(1-5分)");
				$.mobile.loading("hide");
				return false;
			}
			if(($("#jfshJffs").val() > 5) || $("#jfshJffs").val() < 1){
				alert("单次加分分值范围：1——5分！");
				$.mobile.loading("hide");
				return false;
			}
			var yesData = {};
			var yesUrl = "jfYes.php";
			yesData.id = $("#jfshId").val();
			yesData.xh = $("#jfshXh").val();
			yesData.jffs = $("#jfshJffs").val();
			yesData.xm = $("#jfshXm").val();
			$.post(yesUrl, yesData, function(data,status){
				$("#jfMsg").html(data);
			});
			$.mobile.loading("hide");
			$("#popupJfsh").popup("close");
			return false;
		};

		var postJfPanduan = function(){

			if($(this).attr('data-bz') == "fanye")
			{
				var urlStr = $(this).attr('data-canshu');
				jfPageChange(urlStr);
			}
			else if($(this).attr('data-bz') == "queren")
			{
				var urlStr = $(this).attr('data-canshu');
				jfQueren(urlStr);
			}
			else if($(this).attr('data-bz') == "shtg")
			{
				var urlStr = $(this).attr('data-canshu');
				jfYes(urlStr);
			}
			else if($(this).attr('data-bz') =="shbtg")
			{
				var urlStr = $(this).attr('data-canshu').split(",");
				$("#jfshId").val(urlStr[0]);
				$("#jfshXm").val(urlStr[4]);
				$("#jfshXh").val(urlStr[1]);
				$("#jfshJfqk").val(urlStr[3]);
				$("#jfshJffs").val(urlStr[2]);
				$("#popupJfsh").open();
			}
			else if($(this).attr('data-bz') == "del")
			{
				var urlStr = $(this).attr('data-canshu');
				jfDel(urlStr);
			}
			$(this).hide();
		};

		// 绑定事件
		var bindJfEvent = function(){
			$("#jfcxSubmit").on("click", postJfjl);
			$("#jfList").on("click", "a", postJfPanduan);
			$("#jfshSubmit").on("click", postJfShjl);
		};

		$(document).on("pageshow", "#jfMainPage", function(){
			if (isJfBind) return
			isJfBind = 1;
			bindJfEvent();
		});

		$(document).on("pageinit", "#jfMainPage", function(){
			jfLoad();
			setJfRange();
		});
	</script>

	<!-- 复制信息js代码 -->
    <script>
	    var clipboard = new Clipboard('.btn');

	    clipboard.on('success', function(e) {
	        console.log(e);
	    });

	    clipboard.on('error', function(e) {
	        console.log(e);
	    });
    </script>

	<!-- 设置content高度占满屏幕剩余空间 -->
   <!--  <script>
		    	/// 设置高度的函数
		function setHeight(nextPage) {
		    var screen = $.mobile.getScreenHeight();
		    var header = nextPage.children(".ui-header").hasClass("ui-header-fixed") ? nextPage.children(".ui-header").outerHeight() - 1 : nextPage.children(".ui-header").outerHeight();
		    var footer = nextPage.children(".ui-footer").hasClass("ui-footer-fixed") ? nextPage.children(".ui-footer").outerHeight() - 1 : nextPage.children(".ui-footer").outerHeight()
		    var contentCurrent = nextPage.children(".ui-content").outerHeight() - nextPage.children(".ui-content").height();
		    var content = screen - header - footer - contentCurrent;
		    nextPage.children(".ui-content").height(content);
		}

		/// 初始化高度设置函数.
		function initHeightSetting("index") {
		    // 这段代码在初始化的时候执行.设置第一个页面的高度
		    setHeight($("index"));

		    // 在页面显示前会执行下面代码.设置高度
		    $( "body" ).on( "pagecontainershow", function( event, ui ) {
		        var nextPage = $(ui.toPage[0]);
		        setHeight(nextPage);
		    });
		}
    </script> -->

	<!-- 历届毕业生花名册 -->
    	<div data-role="page" id="ljbysListPage">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>历届毕业生花名册</h4>
		</div>
		<div data-role="content">
			<form id="ljbysHmcForm">
		      <div data-role="fieldcontain">
            	<fieldset class="ui-grid-b">
            		<div class="ui-block-a">
						<label for="ljbysNj">毕业年份：</label>
						<input type="number" name="ljbysNj" id="ljbysNj" value="" min="2008" max=""  maxlength="4" onkeyup="value=value.replace(/[^1234567890]+/g,'')">
            		</div>
    				<div class="ui-block-b">
						<label for="ljbysBj">毕业班级：</label>
						<input type="number" name="ljbysBj" id="ljbysBj" value="1" maxlength="2" onkeyup="value=value.replace(/[^1234567890]+/g,'')">
	                </div>
    				<div class="ui-block-c">
				      <input type="button" id="ljbysHmcSubmit" data-inline="true" value="查询">
	                </div>
            	</fieldset>
		      </div>
		    </form>
			<ul data-role="listview" data-inset="true" id="ljbysHmcList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isLjbysHmcNjBind = 0;

		var postLjbysHmc = function(){
			$.mobile.loading("show");
			var ljbysHmcData = {};
			var ljbysHmcUrl = "ljbys_list_post.php";
			ljbysHmcData.byn = $("#ljbysNj").val();
			ljbysHmcData.bj = $("#ljbysBj").val();
			$.post(ljbysHmcUrl, ljbysHmcData, function(data,status){
				$("#ljbysHmcList").html(data);
				$("#ljbysHmcList").listview("refresh");
				$("#ljbysHmcList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindLjbysHmcEvent = function(){
			$("#ljbysHmcSubmit").on("click", postLjbysHmc);
		};

		//绑定页面刷新一次
		var bindPageReloadEvent = function() {
			window.location.reload();
		};

		$(document).on("pageshow", "#ljbysListPage", function(){
			if (isLjbysHmcNjBind) return
			isLjbysHmcNjBind = 1;
			bindLjbysHmcEvent();
		});

		$(document).on("pageinit", "#ljbysListPage", function(){

		});

	</script>

	</div>

	<!-- 历届毕业生查询 -->
	<div data-role="page" id="ljbysXmCxPage">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>历届毕业生查询</h4>
		</div>
		<div data-role="content">
			<form id="ljbysCxForm">
		      <div data-role="fieldcontain">
            	<fieldset class="ui-grid-b">
            		<div class="ui-block-a">
						<label for="ljbysXm">姓名：</label>
						<input type="text" name="ljbysXm" id="ljbysXm" value="" maxlength="10" placeholder="学生或家长姓名">
            		</div>
            		<div class="ui-block-b">
				        <label for="ljbyscxSwitch">查询对象：</label>
				        <select name="ljbyscxSwitch" id="ljbyscxSwitch" data-role="slider">
				          <option value="xs" selected>学生</option>
				          <option value="jz">家长</option>
				        </select>
            		</div>
    				<div class="ui-block-c">
				      <input type="button" id="ljbysCxSubmit" data-inline="true" value="查询">
	                </div>
            	</fieldset>
		      </div>
		    </form>
			<ul data-role="listview" data-inset="true" id="ljbysCxList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isLjbysCxBind = 0;
			var postLjbysCxList = function(){
			$.mobile.loading("show");
			if($("#ljbysXm").val().length < 2){
				alert("姓名最少输入两个字。");
				$.mobile.loading("hide");
				return false;
			}
			var ljbysCxData = {};
			var ljbysCxUrl = "ljbys_cx_post.php";
			ljbysCxData.xm = $("#ljbysXm").val();
			ljbysCxData.obj = $("#ljbyscxSwitch").val();
			$.post(ljbysCxUrl, ljbysCxData, function(data,status){
				$("#ljbysCxList").html(data);
				$("#ljbysCxList").listview("refresh");
				$("#ljbysCxList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindLjbysCxEvent = function(){
			$("#ljbysCxSubmit").on("click", postLjbysCxList);
		};

		$(document).on("pageshow", "#ljbysXmCxPage", function(){
			if (isLjbysCxBind) return
			isLjbysCxBind = 1;
			bindLjbysCxEvent();
		});

		$(document).on("pageinit", "#ljbysXmCxPage", function(){

		});

	</script>

	</div>

<!-- 花名册 -->
	<div data-role="page" id="stdntHmcPage">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>学生花名册</h4>
		</div>
		<div data-role="content">
			<form id="stdntHmcForm">
		      <fieldset data-role="collapsible">
		        <legend>选择班级</legend>
					<label for="hmcNj">年级：</label>
					<input type="range" name="hmcNj" id="hmcNj" value="" min="" max="">
					<label for="hmcBj">班级：</label>
					<input type="range" name="hmcBj" id="hmcBj" value="1" min="1" max="24">
		      <input type="button" id="stdntHmcSubmit" data-inline="true" value="提交">
		      </fieldset>
		    </form>
			<ul data-role="listview" data-inset="true" id="stdntHmcList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var ishmcNjBind = 0;
		var isSetHmcDate = 0;

		var setHmcNianjiRange = function(){
			if(isSetHmcDate) return;
			isSetHmcDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#hmcNj").attr("min", njMin);
			$("#hmcNj").attr("max", njMax);
			$("#hmcNj").attr("value", njMin).slider("refresh");
		};
		var postHmc = function(){
			$.mobile.loading("show");
			var stdntHmcData = {};
			var stdntHmcUrl = "stdnt_hmc_post.php";
			stdntHmcData.nj = $("#hmcNj").val();
			stdntHmcData.bj = $("#hmcBj").val();
			$.post(stdntHmcUrl, stdntHmcData, function(data,status){
				$("#stdntHmcList").html(data);
				$("#stdntHmcList").listview("refresh");
				$("#stdntHmcList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindHmcEvent = function(){
			$("#stdntHmcSubmit").on("click", postHmc);
		};

		$(document).on("pageshow", "#stdntHmcPage", function(){
			if (ishmcNjBind) return
			ishmcNjBind = 1;
			bindHmcEvent();
		});

		$(document).on("pageinit", "#stdntHmcPage", function(){
			setHmcNianjiRange();
		});

	</script>

	</div>

<!-- 住校生名单——宿舍 -->
	<div data-role="page" id="zxsMdSuPgae">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home">首页</a>&nbsp
			<a href='JavaScript:history.back()'>返回</a>
			<h4>住校生名单</h4>
		</div>
		<div data-role="content">
			<form id="zxsMdForm">
		      <fieldset data-role="collapsible">
		        <legend>搜索条件</legend>
		            <fieldset data-role="fieldcontain">
				    <label for="louName">选择楼名:</label>
				    <select name="louName" id="louName">
				      <option value="1" checked>女生宿舍</option>
				      <option value="2">男生宿舍</option>
				      <option value="3">男生公寓</option>
				    </select>
				  </fieldset>
	              <label for="louCengName">选择楼层：</label>
				  <input type="range" name="louCengName" id="louCengName" value="0" min="0" max="4">
				  <label for="suSheHao">输入宿舍号：</label>
				  <input type="number" name="suSheHao" id="suSheHao" value="" placeholder="不输代表全部宿舍">
		      <input type="button" id="zxsMdSusheSubmit" data-inline="true" value="提交">
		      </fieldset>
		    </form>
			<ul data-role="listview" data-inset="true" id="zxsMdSusheList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isZxsInforBind = 0;

		var postZxsMdSushe = function(){
			$.mobile.loading("show");
			var zxsmdSusheData = {};
			var zxsmdSusheUrl = "zxs_md_sushe_post.php";
			zxsmdSusheData.louName = $("#louName").val();
			zxsmdSusheData.louCengName = $("#louCengName").val();
			zxsmdSusheData.suSheHao = $("#suSheHao").val();
			$.post(zxsmdSusheUrl, zxsmdSusheData, function(data,status){
				$("#zxsMdSusheList").html(data);
				$("#zxsMdSusheList").listview("refresh");
				$("#zxsMdSusheList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindZxsMdEvent = function(){
			$("#zxsMdSusheSubmit").on("click", postZxsMdSushe);
		};

		$(document).on("pageshow", "#zxsMdSuPgae", function(){
			if (isZxsInforBind) return
			isZxsInforBind = 1;
			bindZxsMdEvent();
		});
	</script>
	</div>

<!-- 住校生名单——班级 -->
	<div data-role="page" id="zxsMdBjPgae">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home">首页</a>&nbsp
			<a href='JavaScript:history.back()'>返回</a>
			<h4>住校生名单</h4>
		</div>
		<div data-role="content">
			<form id="zxsMdBjForm">
		      <fieldset data-role="collapsible">
		        <legend>搜索条件</legend>
					<label for="zxsMdNj">年级：</label>
					<input type="range" name="zxsMdNj" id="zxsMdNj" value="" min="" max="">
					<label for="zxsMdBj">班级：</label>
					<input type="range" name="zxsMdBj" id="zxsMdBj" value="0" min="0" max="24">
		      <input type="button" id="zxsMdBjSubmit" data-inline="true" value="提交">
		      </fieldset>
		    </form>
			<ul data-role="listview" data-inset="true" id="zxsMdBjList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isZxsMdBjBind = 0;
		var isSetZxsMdBjDate = 0;

		var setZxsmdNjRange = function(){
			if(isSetZxsMdBjDate) return;
			isSetZxsMdBjDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#zxsMdNj").attr("min", njMin);
			$("#zxsMdNj").attr("max", njMax);
			$("#zxsMdNj").attr("value", njMin).slider("refresh");
		};
		var postZxsMdBj = function(){
			$.mobile.loading("show");
			var zxsMdBjData = {};
			var zxsMdBjUrl = "zxs_md_bj_post.php";
			zxsMdBjData.nj = $("#zxsMdNj").val();
			zxsMdBjData.bj = $("#zxsMdBj").val();
			$.post(zxsMdBjUrl, zxsMdBjData, function(data,status){
				$("#zxsMdBjList").html(data);
				$("#zxsMdBjList").listview("refresh");
				$("#zxsMdBjList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindZxsMdbjEvent = function(){
			$("#zxsMdBjSubmit").on("click", postZxsMdBj);
		};

		$(document).on("pageshow", "#zxsMdBjPgae", function(){
			if (isZxsMdBjBind) return
			isZxsMdBjBind = 1;
			bindZxsMdbjEvent();
		});

		$(document).on("pageinit", "#zxsMdBjPgae", function(){
			setZxsmdNjRange();
		});

	</script>
	<!-- 复制信息js代码 -->
    <script>
	    var clipboard = new Clipboard('.btn');

	    clipboard.on('success', function(e) {
	        console.log(e);
	    });

	    clipboard.on('error', function(e) {
	        console.log(e);
	    });
    </script>

	</div>


<!-- 上晚自习名单 -->
	<div data-role="page" id="stdntWzxPage">
		<div data-role="header" data-theme="b">
			<div data-role="navbar">
				<ul>
					<li><a href="#index" data-role="button">返回首页</a></li>
					<li><a href="stdnt_swzx_add.php" data-role="button">增加学生</a></li>
					<li><a href="stdnt_qj_dec.php" data-role="button">减少学生</a></li>
				</ul>
			</div>
		</div>
		<div data-role="content">
			<h4>上晚自习名单</h4>
			<form id="stdntWzxForm">
		      <fieldset data-role="collapsible">
		        <legend>搜索条件</legend>
					<label for="wzxNj">年级：</label>
					<input type="range" name="wzxNj" id="wzxNj" value="" min="" max="">
					<label for="wzxBj">班级：</label>
					<input type="range" name="wzxBj" id="wzxBj" value="1" min="1" max="24">
		      <input type="button" id="wzxSubmit" data-inline="true" value="提交">
		      </fieldset>
		    </form>
			<ul data-role="listview" data-inset="true" id="stdntWzxList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isWzxBind = 0;
		var isSetWzxDate = 0;

		var setWzxRange = function(){
			if(isSetWzxDate) return;
			isSetWzxDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#wzxNj").attr("min", njMin);
			$("#wzxNj").attr("max", njMax);
			$("#wzxNj").attr("value", njMin).slider("refresh");
		};
		var postWzx = function(){
			$.mobile.loading("show");
			var stdntWzxData = {};
			var stdntWzxUrl = "stdnt_wzxmd_post.php";
			stdntWzxData.nj = $("#wzxNj").val();
			stdntWzxData.bj = $("#wzxBj").val();
			$.post(stdntWzxUrl, stdntWzxData, function(data,status){
				$("#stdntWzxList").html(data);
				$("#stdntWzxList").listview("refresh");
				$("#stdntWzxList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindWzxmdEvent = function(){
			$("#wzxSubmit").on("click", postWzx);
		};

		$(document).on("pageshow", "#stdntWzxPage", function(){
			if (isWzxBind) return
			isWzxBind = 1;
			bindWzxmdEvent();
		});

		$(document).on("pageinit", "#stdntWzxPage", function(){
			setWzxRange();
		});

	</script>


	</div>

<!-- 学生假条——当前 -->
	<div data-role="page" id="qjCurrentPgae">
		<div data-role="header" data-theme="b">
			<div data-role="navbar">
				<ul>
					<li><a href="#index" data-role="button">返回首页</a></li>
					<li><a href="stdnt_qj_future.php" data-role="button">未来假条</a></li>
					<li><a href="stdnt_qj_old.php" data-role="button">历史假条</a></li>
				</ul>
			</div>
		</div>
		<div data-role="content">
			<h4>当前请假学生记录</h4>
			<form id="xsTjcxForm">
		      <fieldset data-role="collapsible">
		        <legend>搜索条件</legend>
					<label for="xsJtNj">年级：</label>
					<input type="range" name="xsJtNj" id="xsJtNj" value="" min="" max="">
					<label for="xsJtBj">班级：</label>
					<input type="range" name="xsJtBj" id="xsJtBj" value="0" min="0" max="24">
		      <input type="button" id="xsTjBjSubmit" data-inline="true" value="提交">
		      </fieldset>
		    </form>
			<ul data-role="listview" data-inset="true" id="qjCurrentList">

			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isXsjtBind = 0;
		var isSetZxsfDate = 0;

		var setXsjtRange = function(){
			if(isSetZxsfDate) return;
			isSetZxsfDate = 1;
			var myDate = new Date();
			//获取当前年
			var year=myDate.getFullYear();
			//获取当前月
			var month=myDate.getMonth()+1;
			if(month < 8){
				var njMin = year - 3;
				var njMax = year - 1;
			}else{
				var njMin = year - 2;
				var njMax = year;
			}
			$("#xsJtNj").attr("min", njMin);
			$("#xsJtNj").attr("max", njMax);
			$("#xsJtNj").attr("value", njMin).slider("refresh");
		};

		var postJtBjcx = function(){
			$.mobile.loading("show");
			var xsjtBjData = {};
			var xsjtBjUrl = "stdnt_qj_current_post.php";
			xsjtBjData.nj = $("#xsJtNj").val();
			xsjtBjData.bj = $("#xsJtBj").val();
			$.post(xsjtBjUrl, xsjtBjData, function(data,status){
				$("#qjCurrentList").html(data);
				$("#qjCurrentList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 预加载
		var jiatiaoLoad = function(){
			$.mobile.loading("show");
			var xsjtBjYjzData = {};
			var xsjtBjYjzUrl = "stdnt_qj_current_post.php";
			xsjtBjYjzData.nj = 0;
			xsjtBjYjzData.bj = 0;
			$.post(xsjtBjYjzUrl, xsjtBjYjzData, function(data,status){
				$("#qjCurrentList").html(data);
				$("#qjCurrentList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};
		
		// 单击后隐藏按钮
		// var qjCurButtonHide = function(){
		// 	$(this).hide();
		// };

		// 绑定事件
		var bindXsjtEvent = function(){
			$("#xsTjBjSubmit").on("click", postJtBjcx);
			// $("#qjCurrentList").on("click", "a", qjCurButtonHide)
		};

		$(document).on("pageshow", "#qjCurrentPgae", function(){
			if (isXsjtBind) return
			isXsjtBind = 1;
			bindXsjtEvent();
		});
		$(document).on("pageinit", "#qjCurrentPgae", function(){
			setXsjtRange();
			jiatiaoLoad();
		});

	</script>
	<!-- 复制信息js代码 -->
    <script>
	    var clipboard = new Clipboard('.btn');

	    clipboard.on('success', function(e) {
	        console.log(e);
	    });

	    clipboard.on('error', function(e) {
	        console.log(e);
	    });
    </script>

	</div>

<!-- 模糊查询——在校生 -->
	<div data-role="page" id="xsMhcxPgae">
		<div data-role="header" data-theme="b">
			<a href="#index" data-role="button" data-icon="home"></a>
			<h4>学生姓名模糊查询</h4>
		</div>
		<div data-role="content">
			<form id="xsMhcxForm">
				<label for="mhXm">姓名:</label>
				<input type="text" name="mhXm" id="mhXm" placeholder="姓名中包含的字">
                <div data-role="fieldcontain">
			        <label for="xsMhcxSwitch">查询对象：</label>
			        <select name="xsMhcxSwitch" id="xsMhcxSwitch" data-role="slider">
			          <option value="xs" selected>学生</option>
			          <option value="jz">家长</option>
			        </select>
			    </div>
		      <input type="button" id="xsMhcxSubmit" data-inline="true" value="查询">
		    </form>
			<ul data-role="listview" data-inset="true" id="xsMhcxList">
			</ul>
		</div>
		<div data-role="footer" data-theme="b">
			<h5>&copy天际雪原</h5>
		</div>
	<script>
		var isXsMocxBind = 0;

		var postXsMohucx = function(){
			$.mobile.loading("show");
			if($("#mhXm").val() == ""){
				alert("请输入学生或家长姓名中包含的字！");
				$.mobile.loading("hide");
				return false;
			}
			var xsMohucxData = {};
			var xsMohucxUrl = "stdnt_mhcx_post.php";
			xsMohucxData.mhxm = $("#mhXm").val();
			xsMohucxData.obj = $("#xsMhcxSwitch").val();
			$.post(xsMohucxUrl, xsMohucxData, function(data,status){
				$("#xsMhcxList").html(data);
				$("#xsMhcxList").listview("refresh");
				$("#xsMhcxList").trigger('create');
			});
			$.mobile.loading("hide");
			return false;
		};

		// 绑定事件
		var bindXsMohucxEvent = function(){
			$("#xsMhcxSubmit").on("click", postXsMohucx);
		};

		$(document).on("pageshow", "#xsMhcxPgae", function(){
			if (isXsMocxBind) return
			isXsMocxBind = 1;
			bindXsMohucxEvent();
		});
	</script>
	</div>

</body>
</html>