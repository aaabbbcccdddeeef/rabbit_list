<?php 
include_once __DIR__ . '/config.php';
access_by_cookie($config,$_COOKIE);
?>
<html>
<head>
<meta charset="utf-8">
    <script type="text/javascript" src="../../dist/vis.js"></script>
    <link href="../../dist/vis.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="./index.js?1=000"></script>
    <link href="./index.css" rel="stylesheet" type="text/css" />
</head>
<body>
<style>
            .loading {
              width: 90px;
              height: 90px;
              border: 3px solid #000;
              border-top-color: transparent;
              border-radius: 100%;
            
              animation: circle infinite 0.75s linear;
            }
            @keyframes circle {
              0% {
                transform: rotate(0);
              }
              100% {
                transform: rotate(360deg);
              }
            }
            </style>
            <div style="position:absolute;left:10%;top:0;width:15%;height:5%;background-color:white;z-index:5">
          <div style="position:absolute;left:0;width:35%;height:100%;border:none;background-color:transparent">
        <button style="position:absolute;top:0;left:0%;width:50%;height:100%;border:none;" onclick="show_alert_databox()">
          <img src="/img/upload.png" width="100%"></img>
        </button>  
        <button style="position:absolute;top:0;left:50%;width:50%;height:100%;border:none;" onclick="show_outport()">
          <img src="/img/download.png" width="100%"></img>
        </button> 
        </div>
          <div style="position:absolute;left:35%;width:35%;height:100%;border:none;background-color:transparent">
<div style="position:absolute;left:0;top:0;width:45%;height:90%;border:1% grey;border-style: double;">
<p style="text-align:center;margin:auto;">项目</p>
</div>
<div style="position:absolute;right:0;top:0;width:45%;height:90%;border:1% grey;border-style: double;">
<p style="text-align:center;margin:auto;">帮助</p>
</div>
        </div>
          <div style="position:absolute;left:70%;width:30%;height:100%;border:none;background-color:transparent">
          <button style="position:absolute;top:0;left:0%;width:50%;height:100%;border:none;" onclick="togithub()">
          <img src="/img/github.png" width="100%"></img>
        </button> 
        <button style="position:absolute;top:0;left:50%;width:50%;height:100%;border:none;" >
          <img src="/img/help.png" width="100%"></img>
        </button> 
        </div>
          </div>
            <div style="position:absolute;left:0;top:0;width:10%;height:5%;background-color:grey;z-index:5">
          <h src="/img/head.jpg" style="top:0%;position:absolute;width:98%;height:97%;color:#FAF408;text-align:center;margin:auto;border:1% grey;border-style: double;"> 名单 3.0 </h>
          </div>
<div style="position:absolute;right:0%;bottom:0%;height:100%;width:15%;background-color:transparent;z-index:-99">
<button id='analyse' style="position:absolute;top:10.5%;right:7.5%;width:20%;height:5%;background-color:transparent;border-sytle:none;border-color:transparent;z-index:1000">
<img src="/img/show.png" width="100%" onclick="change_tesk_status()"></img> 
</button>

</div>            
    <div id='loading' ></div>
    <div id='wait_num' style='position:absolute;margin:0 auto;left:44.5%;top:65%;width:12%;height:3%;'></div>
    <div id='stoptry' style='position:absolute;margin:0 auto;left:48.5%;top:75%;width:4%;height:3%;z-index:50;'></div>
    <!--- <div id="mynetwork"></div> -->
</div>
<div style="position:absolute;left:35%;top:0%;width:30%;height:10%;background-color:27c6ac;z-index:20" id="insertBlank"></div>
<div id="mynetwork" style="position:absolute;width:100%;height:90%;top:10%;left:0%"></div>
<!-- 功能栏 -->
<div id='addup'></div>
<div style="position:absolute;width:100%;height:10%;background-color:27C6AC ;left:0%;right:0%;top:0%;bottom:0%;">
<!-- <input style="position:absolute;height:50%;width:5%;left:25%;margin:0;top:50%" placeholder="autoblank" input="autoblank" value="" id="autoblank"></input> -->
<button onclick="advance_change()" style="position:absolute;width:5%;height:50%;left:30%;top:0%;margin:0">高级</button>
<!-- <button  style="position:absolute;width:5%;height:50%;left:30%;top:50%;margin:0">枚举</button> -->

<button onclick="reflash()" style="position:absolute;width:5%;height:50%;left:25%;top:0%;margin:0">重置</button>

<input onclick="focuson()" onblur="shownodes()" style="position:absolute;height:50%;width:15%;left:10%;margin:0;top:50%" placeholder="input node" input='search' id='search_node' value=''></input>
<input  style="position:absolute;width:10%;height:50%;right:0%;top:0%;margin:0" value='edges:null' id='edgesnum'></input>
<input  style="position:absolute;width:10%;height:50%;right:0%;top:50%;margin:0" value='allnodes:null' id='nodesnum'></input>
<select onchange="showmodes()" id='nodeclass' style="position:absolute;width:10%;height:50%;right:25%;top:50%;margin:0" value='类型:null'>

</select>
<select onchange='set_imgtype(nodes,edges)' id='force_type' style='position:absolute;width:10%;height:50%;left:0%;top:50%;margin:0'>
</select>
<!-- ul -->
<select id='blank' style='position:absolute;width:5%;height:50%;right:30%;top:0%;margin:0'>
<option  value="autoblank">通用号码枚举</option>
<option  value="advance_phone_blank">高级手机枚举</option>
<!--<option  value="advance_phone_blank">高级中文名枚举</option>-->
</select>
<button onclick='setblank()' style='position:absolute;width:5%;height:50%;right:25%;top:0%;margin:0'>
枚举
</button>
<button  onclick="shownodes()" style="position:absolute;width:5%;height:50%;left:25%;top:50%;margin:0">查询</button>
<button  onclick="show_info()" style="position:absolute;width:5%;height:50%;left:30%;top:50%;margin:0">导出</button>
<select  style="position:absolute;width:5%;height:50%;right:20%;top:50%;margin:0" id='use_functions'>
<option  value="singlenode_execmode">当前</option>
<option  value="search_node_execmode">自动</option>
<option  value="childnodes_node_execmodes">关联</option>
</select>
  <select  id='addup_modes' style="position:absolute;width:5%;height:50%;right:15%;top:50%;margin:0;">
  <option value ="getinfo"> 点击节点再选择模块 </option>
  </select>

  <select id='delby' style='position:absolute;width:5%;height:50%;right:15%;top:0%;margin:0'>
   <option value='this'>选中 </option> 
   <option value='not_connect'>非直接关联</option>
   <option value='is_connect'>直接关联</option>
   <option value='<' >边<</option> 
   <option value='=' >边=</option> 
   <option value='>' >边></option> 
  <option value='inputreg'>正则匹配</option> 
  <input id='delvalue' value='1' style='position:absolute;width:5%;height:50%;right:10%;top:0%;margin:0'></input>
  <button style='position:absolute;width:5%;height:50%;right:20%;top:0%;margin:0'  value='delallreg' onclick="delbyfront()" >删除</button>
<button onclick="loading()" style="position:absolute;width:5%;height:50%;right:10%;top:50%;margin:0;">执行模块</button>
          </div>

<div style="left:0%;top:10%;width:100%;height:80%;background-color:white;z-index:-1" id="show_alert" >
<div style="position:absolute;left:0;width:100%;height:100%;background:url(./rabbit-list.jpg);background-size:cover;top:0;z-index:55">
<div style="position:absolute;top:35%;height:15%;width:30%;background-color:27C6AC;left:35%;border:2% white;border-style:double">
<div style="position:absolute;left:0;top:0;background-color:transparent;width:80%;height:100%">
<input style="position:absolute;background-color:white;top:20%;left:2%;width:80%;height:60%" placeholder="输出初始节点" id="nodes_init" value=""></input>
<button style="position:absolute;right:2%;width:15%;height:60%;top:20%;background-color:white" onclick="reflash()">
初始化
</button>
</div>
  <div style="position:absolute;width:12.5%;height:60%;top:20%;left:85%;background-color:transparent;border:none">
  <button style="position:absolute;background-color:white;width:100%;height:100%;border:none;" onclick="show_alert_databox()">
<img src="/img/upload.png" width="100%"></img>
</button>
          </div>
</div>
</body>
</html>