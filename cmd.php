<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>cmd</title>
		<style>
			body{
				background:black;
				color:white;
			}
			input{color:white;border:none; background: none;outline: none }  

			input-unlimited {color:white;border:none; background: none;outline: none}
		</style>
		<script>

		

		document.addEventListener("DOMContentLoaded",function(){
			console.log("DOMContentLoaded");
		})

		window.onload = function(){
			console.log("onload");
			Screen = document.getElementById("screen");
			Input = document.getElementsByTagName("input")[0]; 
			PrefixPath = document.getElementsByTagName("span")[0];
			

			cmd_cls();
			Input.focus();

			cmd_ver();
			printMessage(COPYRIGHT);


			//WebSocketTest();			
			//test_History();
			//test_Command();
			cmd_telnet();
			return;

			Input.addEventListener("keydown",function(e){
				//console.log(e.keyCode)
				switch(e.keyCode){
					case 9:pressTab(this);break;
					case 116:pressF5(this);break;
					case 13:pressEnter(this);break;
					case 38:pressUp(this);break;
					case 40:pressDown(this);break;
				}
				this.focus();
			});
			Input.addEventListener("click",function(e){//单击触发编辑状态
			});
			Input.addEventListener("mouseup",function(e){//选择文字关闭编辑状态				
			});
		}


		var Screen;
		var Input;
		var PrefixPath;


			function setTitle(title){
				document.title = title;				
			}



			var Command_History = [];
			var Command_Hisotry_Index = -1;
			function _clearHistory(){
				Command_History = [];
				Command_Hisotry_Index = -1;
			}
			function getHistory(i){
				return Command_History[i];
			}
			function setHistory(cmdString){//保存命令历史
				var max = 100;
				
				if (Command_History.length > max-1) {
					Command_History.shift();
				}
				Command_History.push(cmdString);
				
			}
			function test_Command(){
				for (var i in Commands) {
					executeCommand(Commands[i].name);
				}				
				_scrollToEnd();
			}
			function test_History(){
				_clearHistory();
				setHistory("一");
				setHistory("二");
				setHistory("三");
				setHistory("四");
				setHistory("五");
				setHistory("六");
				setHistory("七");

				var Input = document.getElementsByTagName("input")[0]; 

				var pu1 = pressUp(Input);
				console.log("pressUp 七=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 六=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 五=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 四=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 三=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 二=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 一=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 七=" + pu1 + " index=" + Command_Hisotry_Index);
				pu1 = pressUp(Input);
				console.log("pressUp 六=" + pu1 + " index=" + Command_Hisotry_Index);
				console.log("pressUp结束");
				



				_clearHistory();
				setHistory("一");
				setHistory("二");
				setHistory("三");
				setHistory("四");
				setHistory("五");
				setHistory("六");
				setHistory("七");

				var pd1 = pressDown(Input);
				console.log("pressDown 一=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 二=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 三=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 四=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 五=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 六=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 七=" + pd1 + " index=" + Command_Hisotry_Index);
				pd1 = pressDown(Input);
				console.log("pressDown 一=" + pd1 + " index=" + Command_Hisotry_Index);
				console.log("pressDown结束");


				 
			}

			function pressUp(_input){
				if (Command_History.length==0) return false;//没有历史 不执行

				Command_Hisotry_Index = Command_Hisotry_Index - 1;//先滚动

				if (Command_Hisotry_Index <= -1) Command_Hisotry_Index = Command_History.length -1;
				
				_input.value = getHistory(Command_Hisotry_Index);
				return  _input.value;
			}
			function pressDown(_input){
				if (Command_History.length==0) return false;				

				if (Command_Hisotry_Index>=Command_History.length-1) Command_Hisotry_Index=-1;

				Command_Hisotry_Index = Command_Hisotry_Index + 1;
				
				_input.value = getHistory(Command_Hisotry_Index);
				return  _input.value;
			}
			function _scrollToEnd(){
				Screen.scrollTop = Screen.scrollHeight;
			}
			function pressEnter(_input){
				executeCommand(_input.value);
				_input.value = "";
			}
			function pressTab(_input){
				console.log("pressTab");
			}
			function pressF5(_input){
				console.log("pressF5");
			}

			
			
			function printMessage(cmdString){//打印

				var p = document.createElement("p");
				p.innerText = cmdString;
				Screen.appendChild(p);
			}
			function executeCommand(cmdString){//执行命令
				cmdString = cmdString.replace(/(^\s*)|(\s*$)/g, '');//trim
				var cmd = cmdString.split(' ')[0];
				var paras = cmdString.replace(cmd+' ',"");
				console.log("命令="+cmd);
				console.log("参数行="+paras);
				if(cmd.length == 0)return;//空白命令

				setHistory(cmdString);
				for(var i in Commands){
					if (cmd.toUpperCase() == Commands[i].name.toUpperCase()) {
						//printMessage(cmd+'找到');
						try{
							Commands[i].exec();
						}catch(e){
							console.log("%cexec()执行不成功：" + e,"color:green");
						}
						return true;
					}					
				}
				printMessage(ERROR_STRING.replace("{0}",cmd));
				return false;
			}
			function cmd_telnet(){
			  if ("WebSocket" in window)
			  {			     
			     var ws = new WebSocket("ws://111.13.100.91/");
				 console.log("支持WebSocket!");
			     ws.onopen = function()
			     {
			        ws.send("发送消息");
			        console.log("发送消息");
			     };
			     ws.onmessage = function (evt)
			     {
			        var received_msg = evt.data;
			        console.log("收到消息");
			     };
			     ws.onerror = function(e){
			     	console.log(e);
			     };
			     ws.onclose = function()
			     {
			        console.log("连接已经断开");
			     };
			  }
			  else
			  {
			     console.log("不支持WebSocket!");
			  }
			}
			function cmd_cls(){
				Screen.innerHTML = "";
			}
			function cmd_help(paras){
				console.log("进入cmd_help");
				console.log("paras="+paras);
				console.log(paras);
			}
			function cmd_ver(){
				printMessage(VERSION);
			}

			
			const VERSION = "Microsoft Windows [版本 10.0.10240]";
			const COPYRIGHT = "(c) 2015 Microsoft Corporation. All rights reserved.";
			const ERROR_STRING = "'{0}'不是内部或外部命令，也不是可运行的程序\n或批处理文件。";
			var currentPath = "";

			var Commands = [				
				{
					name:"CD",
					description:"显示当前目录的名称或将其更改。"
				},				
				{
					name:"CHDIR",
					description:"显示当前目录的名称或将其更改。"
				},				
				{
					name:"CLS",
					description:"清除屏幕。",
					parameters:[1000],
					exec : function(){ cmd_cls() }
				},
				{
					name:"help",
					description:"提供 Windows 命令的帮助信息。",
					parameters:[],
					exec : function(){ cmd_help(this.parameters) }
				},			
				{
					name:"COLOR",
					description:"设置默认控制台前景和背景颜色。"
				},				
				{
					name:"EXIT",
					description:"退出 CMD.EXE 程序(命令解释程序)。"
				},
				{
					name:"ver",
					description:"显示 Windows 的版本。",
					parameters:[],
					exec : function(){ cmd_ver() }
				},
				/*{
				name : "",
				parameters : [],
				exec : function(para){},
				help : "",
				parameterHelp : []
				}*/
			];			 
			

		</script>

	</head>
	<body>
<div id="screen">
	<p>Microsoft Windows [版本 10.0.10240]</p>
	<p>(c) 2015 Microsoft Corporation. All rights reserved.</p>


</div>
<span>C:\Users\amysi_000></span><input />
<!--
<input-unlimited contenteditable="false">aaa</input-unlimited>
-->
	</body>
</html>
<!--		
有关某个命令的详细信息，请键入 HELP 命令名
FC             比较两个文件或两个文件集并显示
               它们之间的不同。
FIND           在一个或多个文件中搜索一个文本字符串。
FINDSTR        在多个文件中搜索字符串。
FOR            为一组文件中的每个文件运行一个指定的命令。
FORMAT         格式化磁盘，以便用于 Windows。
FSUTIL         显示或配置文件系统属性。
FTYPE          显示或修改在文件扩展名关联中使用的文件
               类型。
GOTO           将 Windows 命令解释程序定向到批处理程序
               中某个带标签的行。
GPRESULT       显示计算机或用户的组策略信息。
GRAFTABL       使 Windows 在图形模式下显示扩展
               字符集。
HELP           提供 Windows 命令的帮助信息。
ICACLS         显示、修改、备份或还原文件和
               目录的 ACL。
IF             在批处理程序中执行有条件的处理操作。
LABEL          创建、更改或删除磁盘的卷标。
MD             创建一个目录。
MKDIR          创建一个目录。
MKLINK         创建符号链接和硬链接
MODE           配置系统设备。
MORE           逐屏显示输出。
MOVE           将一个或多个文件从一个目录移动到另一个
               目录。
OPENFILES      显示远程用户为了文件共享而打开的文件。
PATH           为可执行文件显示或设置搜索路径。
PAUSE          暂停批处理文件的处理并显示消息。
POPD           还原通过 PUSHD 保存的当前目录的上一个
               值。
PRINT          打印一个文本文件。
PROMPT         更改 Windows 命令提示。
PUSHD          保存当前目录，然后对其进行更改。
RD             删除目录。
RECOVER        从损坏的或有缺陷的磁盘中恢复可读信息。
REM            记录批处理文件或 CONFIG.SYS 中的注释(批注)。
REN            重命名文件。
RENAME         重命名文件。
REPLACE        替换文件。
RMDIR          删除目录。
ROBOCOPY       复制文件和目录树的高级实用工具
SET            显示、设置或删除 Windows 环境变量。
SETLOCAL       开始本地化批处理文件中的环境更改。
SC             显示或配置服务(后台进程)。
SCHTASKS       安排在一台计算机上运行命令和程序。
SHIFT          调整批处理文件中可替换参数的位置。
SHUTDOWN       允许通过本地或远程方式正确关闭计算机。
SORT           对输入排序。
START          启动单独的窗口以运行指定的程序或命令。
SUBST          将路径与驱动器号关联。
SYSTEMINFO     显示计算机的特定属性和配置。
TASKLIST       显示包括服务在内的所有当前运行的任务。
TASKKILL       中止或停止正在运行的进程或应用程序。
TIME           显示或设置系统时间。
TITLE          设置 CMD.EXE 会话的窗口标题。
TREE           以图形方式显示驱动程序或路径的目录
               结构。
TYPE           显示文本文件的内容。
VER            显示 Windows 的版本。
VERIFY         告诉 Windows 是否进行验证，以确保文件
               正确写入磁盘。
VOL            显示磁盘卷标和序列号。
XCOPY          复制文件和目录树。
WMIC           在交互式命令 shell 中显示 WMI 信息。

有关工具的详细信息，请参阅联机帮助中的命令行参考。
-->
