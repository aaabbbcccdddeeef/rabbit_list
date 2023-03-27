<?php 
include_once __DIR__ . '/config.php';
access_by_cookie($config,$_COOKIE);
?>
<html>
<head>
<meta charset="utf-8">
    <script type="text/javascript" src="../../dist/vis.js"></script>
    <link href="../../dist/vis.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        #mynetwork {
            position: absolute;
            width: 100%;
            height: 100%;
            top:0%;
        }
    </style>
</head>
<body>
<style>
            .loading {
              width: 30px;
              height: 30px;
              border: 1px solid #000;
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
    <div id='loading' ></div>
<script type="text/javascript">
  function startloading()
  {
    document.getElementById('loading').innerHTML='<div class="loading" style="position:absolute;right:48.5%;left:48.5%;top:48.5%;bottom:48.5%;background-color: aquamarine;"></div>'
'<div class="loading" style="position:absolute;right:48.5%;left:48.5%;top:48.5%;bottom:48.5%;background-color: aquamarine;"></div>';
  }
  function stoploading(object)
  {
    document.getElementById('loading').innerHTML='';
  }
    function setnewkeyword(keyword){
        document.getElementById("keyword4search").innerHTML=keyword;
    }
    function reflash()
{
    nodestart=document.getElementById("newnode").value;
    // create an array with nodes
      nodes = new vis.DataSet([
        {id: nodestart, label: nodestart,'image':'/img/icon/start.png','shape':'image'}//,
      //  {id: 'password', label: 'password'},
      //  {id: 'phone', label: 'phone'},
      //  {id: 'address', label: 'address'},
      //  {id: 'name', label: 'name'}
    ]);


    // create an array with edges
      edges = new vis.DataSet([]);

      // create a network
       container = document.getElementById("mynetwork");
       data = {
        nodes: nodes,
        edges: edges,
      };

       options = {
        interaction: { hover: true },
        manipulation: {
          enabled: true,
        },
        physics:{
    enabled: true,
    barnesHut: {
      gravitationalConstant: -32000,
      centralGravity: 0.5,
      springLength: 99,
      springConstant: 0.1,
      damping: 0.09,
      avoidOverlap: 0
    },
  }
      };
       network = new vis.Network(container, data, options);
      // addnode
    // network 检测
    network.on("click", function (params) {
      // alert("don't touch my code! BE carefor of bugs hurt peopel");
       // setnode_type();
        img_type();
        params.event = "[original event]";
        // console.log(params.event);
       //  alert(this.getNodeAt(params.pointer.DOM));
       if(network)
       {
        document.getElementById("nodesnum").value='all nodes: '+network.body.data.nodes.length;
       }
       keyword=this.getNodeAt(params.pointer.DOM);
       try{
        document.getElementById("edgesnum").value='edges: '+network.body.nodes[keyword].edges.length;
       }
       catch(err)
       {
        document.getElementById("edgesnum").value='edges: null';
       }
       document.getElementById("keyword4search").value=keyword;
       setnode_type();
       showmodes();
      });
}

function addimg(type)
{
return "/img/icon/"+type+".png";
}


function showmodes(){
  var myselect=document.getElementById("nodeclass");
  var index=myselect.selectedIndex;
  var type_choosed=myselect.options[index].value; // 下拉菜单值
  let allmodesurl=[];
  let allmodes_html='';
  allmodes=getURLString('./showmode.php').split('#');
  // 一级目录
  mode_reg=/^\w*\.(php)$/;

for(mdn in allmodes)
{
  if(allmodes[mdn]!='')
  {
    if(allmodes[mdn]==type_choosed)
    {
           // console.log(allmodes[mdn]);
    // allmodes_html=allmodes_html+'<option value="' + allmodes[mdn] + '" >'+ allmodes[mdn] + "</option>\n";
    treemode=getURLString('./showmode.php?mode='+allmodes[mdn]).split('#');
    for(mdn1 in treemode)
    {
      if(treemode[mdn1]!='')
      {
        // console.log(allmodes[mdn]+'/'+treemode[mdn1]);
       // allmodes_html=allmodes_html+'<option value="' + allmodes[mdn]+'/'+treemode[mdn1] + '" >'+ allmodes[mdn]+'/'+treemode[mdn1] + "</option>\n";
        if(!mode_reg.test[treemode[mdn1]])
        {
        singlemodes=getURLString('./showmode.php?mode='+allmodes[mdn]+'/'+treemode[mdn1]).split('#');  
        for(mdn2 in singlemodes)
        {
        if(singlemodes[mdn2]!='')
        {
        // console.log(allmodes[mdn]+'/'+treemode[mdn1]+'/'+singlemodes[mdn2]);  
        allmodes_html=allmodes_html+'<option value="' + allmodes[mdn]+'/'+treemode[mdn1]+'/'+singlemodes[mdn2] + '" >'+ allmodes[mdn]+'/'+treemode[mdn1]+'/'+singlemodes[mdn2] + "</option>\n";
        }  
        }
        }
      }
    } 
    }
  }
}
document.getElementById('addup_modes').innerHTML='<option value="getinfo">信息提取</option>'+allmodes_html;
}

function gerurl()
{
  var myselect=document.getElementById("addup_modes");
  var index=myselect.selectedIndex;
  var mode_choosed=myselect.options[index].value; // 下拉菜单值
  var url='./mode/'+mode_choosed;
  console.log(url);
}


function shownodes(){
  keyword=document.getElementById('seacrh_node').value;
  //keyword=keyword1.split('');
  // console.log('keyword:',keyword);
  var result='<div style="position:absolute;height:5%;width:10%;left:10%;margin:0;top:0">可能的节点</div>';
  num=0;
  var keyword_reg = new RegExp("(.*)("+keyword+")(.*)");
  for(var obj in Object.getOwnPropertyNames(network.body.nodes)){
      shownode=Object.getOwnPropertyNames(network.body.nodes)[obj];
        if(keyword_reg.test(shownode))
          {
            network.focus(shownode);
            topnum=num*5;
            result=result+'<input onclick="choose_node('+num+')" style="position:absolute;height:5%;width:10%;left:10%;margin:0;top:'+topnum+'%;" id="proble_node'+num+'"'+' value='+shownode+' placefolder='+shownode+'></input>';
            num++;
          }
        }
      // i++;
      document.getElementById('addup').innerHTML=result;
      // console.log('insert=',result);
      }
function replaceStar(str_input)
{
  let result=[];
  let arr= str_input.split('');
  let starIndex = arr.findIndex(item => item === '*');

  for(let i=0; i<10; i++) 
  {
    let temp = [...arr];
    temp[starIndex] = i;
    result.push(temp.join(""));
  }

  return result;
}

function isContainStar(arr1111) {
  return arr1111.some(item => item.includes("*")) ? 1 : 0;
}


function singlephonereg(){
  var reg=/^[1][3,4,5,7,8,9][0-9]{9}$/;
  fromkeyword=document.getElementById('keyword4search').value;
  if(reg.test(fromkeyword))
  {
  phone_reg_mode(fromkeyword);  
  }  
  return ;
}

function findphone(code){
var reg=/^[1][3,4,5,7,8,9][0-9]{9}$/;
fromkeyword=document.getElementById('keyword4search').value;
list=network.getConnectedNodes(fromkeyword,'');
if(!list)
{
  console.log('no data');
  return 0;
}
for(num in list)
{
  if(reg.test(list[num]))
  {
    phone_reg_mode(list[num]);
  // console.log(list[num]);
  }
}
// return 1;
}

function autoblank_phone(str_input)
{
  new_str_output=str_input.split(',');
 // console.log(new_str);
  return autoblank(new_str_output);  
}

function autoblank(result)
{
  while(1)
  {
     if(!isContainStar(result))
     {
     break;
     }
     // console.log('mid:',result);
    
    for(number in result)
      {
        if(result[number].includes('*'))
        {
        data_list=replaceStar(result[number]);  
        for(datanum in data_list)  
        {
        result.push(data_list[datanum]);
        }
        result.splice(number,1);
        }
      }

  }
  // console.log('result',result);

  return result;
}

function phonereg(nodeid_input,url_input)
{
  var myselect=document.getElementById("addup_modes");
        var index=myselect.selectedIndex;
        var site=myselect.options[index].value; 
if(!nodeid_input || !url_input)
{
  return;
}
else
{
  var fetchurl=url_input+'?phone='+nodeid_input;
  if(getURLString(fetchurl)=='true')
  {
    addnode(nodeid_input,'reg:'+site,'reg:'+site,nodes,edges);
  }
}
return ;
}


function search_phone()
{
  var reg=/^[1][3,4,5,7,8,9][0-9]{9}$/;
  for(i in network.body.nodes){
    if(reg.test(network.body.nodes[i].id))
    {
      // console.log(network.body.nodes[i].id);
      phone_reg_mode(network.body.nodes[i].id);
    }
  }
}


function addnode_for(input_str,startnode){ 
result=autoblank_phone(input_str);
for(num in result)
{
  addnode(startnode,result[num],result[num],nodes,edges);
}
}

function blankfront(){
  thisnode=document.getElementById('keyword4search').value;
  addnode_for(thisnode,thisnode)
}





function get_setup_type(nodeid_input)
{
  try{
  var type=network.body.nodes[nodeid_input].options.image.split('/')[3].split('.')[0];
  return type;
  }
  catch(err)
  {
    return null;
  }
}

function set_imgtype()
{
  var nodeid=document.getElementById('keyword4search').value;
  var list=network.getConnectedNodes(nodeid,'');
  var myselect=document.getElementById("force_type");
  var index=myselect.selectedIndex;
  var select=myselect.options[index].value; // 下拉菜单值
  if(!select)
  {
    return ;
  }
  var image='./img/icon/'+select;
  delnode(nodeid);
  let newNode = {'id': nodeid,'label': nodeid,image,'shape':'image'};
  nodes.add(newNode);
for(var i=0;i<list.length;i++)
{
  var line = {'from': nodeid,'to': list[i],'arrows': "from",'dashes': [5, 5, 3, 3], 'background': 'false'};
  edges.add(line);
}
return;
}


function img_type()
{ 
  var allimg=getURLString('./showimg.php').split('#');
  var img_options='';
  for(var i=0;i<allimg.length;i++)
 {
  var name=allimg[i];
  if(name)
  {
    img_options=img_options+'<option id=' + name + ' value=' + name + '>' + name + '</opton>';
  }
 }
 document.getElementById("force_type").innerHTML=img_options;
}

function getURLString(url) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, false);
    xhr.send(null);
    return xhr.responseText;
}

function setkeyword(nodes,edges)
    {
        var myselect=document.getElementById("keyword");
        var index=myselect.selectedIndex;
        var select=myselect.options[index].value; // 下拉菜单值
        var keyword=document.getElementById("keyword4search").value; // 搜索关键词
      //  console.log(select); // 下拉菜单值
        if(!keyword)
        {
           alert('请输入搜索内容');
           return 1;
        }
        if(select=='isblank')
        {

          alert('请输选择搜索类型');
          return 1; 
        }
       url='./search.php?keyword_type=' + select + '&content=' + keyword;
      // console.log(nodes,edges);
       fetch(url).then(res => {return res.text()}).then((res)=>{addnodefromdb(keyword,res)});
     //   console.log(keyword); // 搜索关键词
       // addnode('admin','2','2',nodes,edges);
    }
    // 弹出框
   //  addnode('admin','1','1',nodes,edges);

  function delbyfront()
  {
    var myselect=document.getElementById("delby");
    var index=myselect.selectedIndex;
    var delby=myselect.options[index].value; // 下拉菜单值
    delvalue=document.getElementById('delvalue').value;
    console.log(delby,delvalue);
    delnode_byedges(delby,delvalue);
  }

   function delnode_byedges(code,edges)
   {
    allnodes=network.body.data.nodes.getIds(); 
    for(nodenum in allnodes)
    {
      nodeid=allnodes[nodenum];
      if(nodeid)
      {
       try{
      edges_of_node=network.body.nodes[nodeid].edges.length;
       }
       catch(err)
       {
        edges_of_node='unknown';
       }
       switch(code)
   {
    case '<': 
      if(edges_of_node < edges)
      {
       delnode(nodeid); 
      }
    break;
    case '=':
      if(edges_of_node==edges)
      {
       delnode(nodeid); 
      }
    break;  
    case '>':
      if(edges_of_node > edges)
      {
       delnode(nodeid); 
      }
    break;
    case 'this':
      nodeid=document.getElementById("keyword4search").value;
      delnode(nodeid);
      return;
      break;
      case 'is_connect':
var fromkeyword=document.getElementById('keyword4search').value;
var list=network.getConnectedNodes(fromkeyword,'');   
      for(i in list)
      {
        delnode(list[i]);
      }  
      break;
    case 'not_connect':
    for(node_id in network.body.data.nodes._data)
    {
      try
      {
      if(connect_test(network.body.data.nodes._data[node_id].id)==0)
      {
        delnode(network.body.data.nodes._data[node_id].id);
      }
      }
      catch(err)
      {
        console.log(network.body.data.nodes._data[node_id])
      }
    }
    break;    
    default:

   }
      }
    }
  } 

function connect_test(input_id)
{
  var fromkeyword=document.getElementById('keyword4search').value;
  var list=network.getConnectedNodes(fromkeyword,''); 
  if(input_id==fromkeyword)
    {
      return 1;
    }
  for(i in list)
  {
    if(list[i]==input_id)
    {
      return 1;
    }
  } 
  return 0;
}

function delnode(nodeid)
{  
network.selectNodes([nodeid]);
try{
  network.deleteSelected();
}
catch(err)
{
  console.log(nodeid,'seems not node');
}
}



</script>    
<!--- <div id="mynetwork"></div> -->
<div id='insertBlank' style="z-index:10;position:absolute;width:30%;height:10%;left:35%;top:0%;margin:0;backgroud-color:black">

</div>
<div id="mynetwork"><div class="vis-label">Edit</div></div>
<!-- 功能栏 -->
<div id='addup'></div>
<div style="position:absolute;width:100%;height:10%;background-color:#39c5bb;left:0;right:0;top:0;bottom:0;">
<input style="position:absolute;height:50%;width:10%;left:25%;margin:0;top:50%" placeholder="newnode" input='newnode' value='' id='newnode'></input>
<!-- <input style="position:absolute;height:50%;width:5%;left:25%;margin:0;top:50%" placeholder="autoblank" input="autoblank" value="" id="autoblank"></input> -->
<button onclick="frontaddnode()" style="position:absolute;width:5%;height:50%;left:30%;top:50%;margin:0">新增</button>
<!-- <button  style="position:absolute;width:5%;height:50%;left:30%;top:50%;margin:0">枚举</button> -->
<button onclick="reflash()" style="position:absolute;width:10%;height:50%;left:25%;top:0;margin:0">初始化</button>
<input onclick="focuson()" onblur="shownodes()" style="position:absolute;height:50%;width:10%;left:10%;margin:0;top:50%" placeholder="seacrh from nodes" input='search' value='' id='seacrh_node'>seacrh</input>
<input  style="position:absolute;width:10%;height:50%;right:0%;top:0%;margin:0" value='edges:null' id='edgesnum'></input>
<input  style="position:absolute;width:10%;height:50%;right:0%;top:50%;margin:0" value='allnodes:null' id='nodesnum'></input>
<select onchange="showmodes()" id='nodeclass' style="position:absolute;width:10%;height:50%;right:25%;top:50%;margin:0" value='类型:null'>

</select>
<select onchange='set_imgtype()' id='force_type' style='position:absolute;width:10%;height:50%;left:0%;top:50%;margin:0'>
</select>
<!-- ul -->
<select id='blank' style='position:absolute;width:5%;height:50%;right:30%;top:0%;margin:0'>
<option  value="autoblank">通用枚举</option>
<option  value="advance_phone_blank">高级手机号枚举</option>
</select>
<button onclick='setblank()' style='position:absolute;width:5%;height:50%;right:25%;top:0%;margin:0'>
枚举
</button>
<button  onclick="shownodes()" style="position:absolute;width:5%;height:50%;left:20%;top:50%;margin:0">搜索</button>
<select  style="position:absolute;width:5%;height:50%;right:20%;top:50%;margin:0" id='use_functions'>
<option  value="singlenode_execmode">当前</option>
<option  value="search_node_execmode">自动</option>
<option  value="childnodes_node_execmodes">关联</option>
</select>
  <select  id='addup_modes' style="position:absolute;width:5%;height:50%;right:15%;top:50%;margin:0;">
  <option value ="getinfo"> 信息提取 </option>
  </select>

  <select id='delby' style='position:absolute;width:5%;height:50%;right:15%;top:0%;margin:0'>
   <option value='this'>选中 </option> 
   <option value='not_connect'>非直接关联</option>
   <option value='is_connect'>直接关联</option>
   <option value='<' >边<</option> 
   <option value='=' >边=</option> 
   <option value='>' >边></option> 
  <!-- <option value='inputreg'>正则匹配</option>  -->
  </select>
  <input id='delvalue' value='1' style='position:absolute;width:5%;height:50%;right:10%;top:0%;margin:0'>1</input>
  <button style='position:absolute;width:5%;height:50%;right:20%;top:0%;margin:0'  value='delallreg' onclick="delbyfront()" >删除</button>
<button onclick="execute_mode()" style="position:absolute;width:5%;height:50%;right:10%;top:50%;margin:0;">执行模块</button>
<!-- <iframe src='./search.php' style="position:absolute;width:15%;height:80%;left:5%;top:5%;top:5%;background-color:#39c5bb;border:0">从数据库查询</iframe>
-->
<div style="position:absolute;width:10%;height:50%;background-color:#39c5bb;left:0;right:0;top:0;bottom:0;" >
<select id="keyword" style="position:absolute;left:0;margin:0;height:100%;width:100%">    
<option value ="isblank" >数据类型</option>
<?php
function getresult($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}
$search=getresult("http://127.0.0.1/search.php?showtable=1");
$keywords=$search;
// echo "<script>console.log('keyword_list:',$keywords)</script>";
$search=explode(",",$keywords,-1);
//echo "<script>console.log('search_list:',$search)</script>";
foreach ($search as $v)
{
  if(strlen($v)<32)
  {
  // echo "<script>console.log($v)</script>";
  echo "<option value='".$v."'>".$v."</option>";
  }
}
?>
</select>
<input type="keyword" placeholder="keyword" id='keyword4search' style="position:absolute;height:100%;width:100%;left:100%;margin:0"></input>
<button onclick="setkeyword()" style="position:absolute;width:50%;height:100%;left:200%;margin:0">
<img src='./search.ico'></img></button>
<script>
    function frontaddnode(){
       startnode=document.getElementById("keyword4search").value;
      // console.log('oldnode',startnode);
       if(!startnode)
        {
            alert('请选择起始节点');
        }
       newnodeid=newnodelabel=document.getElementById("newnode").value;
      // console.log('newnode',newnodeid);
       addnode(startnode,newnodeid,newnodeid,nodes,edges);
       // alert(startnode);
    }

function testconnect(from,to)
{
  var list=network.getConnectedNodes(from,'');
  for(i=0;i<=list.length;i++)
  {
    if(list[i]==to)
    {
      return 1;
    }
  }
  return 0;
}

    function addnode(startfromnode,newnodeid,newnodelabel,nodes,edges){
    // console.log('from',startfromnode);
    // console.log('to',newnodeid);   
    if(newnodeid.length>=64)
    {
      return 1;
    }
    var image=addimg(returnnode_type(newnodeid));
    try{
      if(newnodeid!=startfromnode)
      {
        if(testconnect(startfromnode,newnodeid)==0)
        {
     let newNode = {'id': newnodeid,'label': newnodelabel,image,shape:'image'};
     let line = {'from': newnodeid,'to': startfromnode,'arrows': "from",'dashes': [5, 5, 3, 3], 'background': 'false'};
    nodes.add(newNode);
    edges.add(line);
      }
    }
    }
    catch(err)
    {
      if(newnodeid!=startfromnode)
      {
        if(testconnect(startfromnode,newnodeid)==0)
        {
     // tagid='tag: '+ newnodeid + Math.random()*10000;
     let newNode = {'id': newnodeid,'label': newnodelabel,image,shape:'image'};
     // let tagsame= {'id':tagid,'lable':'sametag','color':"red"}
     //  nodes.add(tagsame);
     let line ={'from':newnodeid,'to':startfromnode,'arrows': "from"};
     // let tag_same_line ={'from':newnodeid,'to':tagid};
     edges.add(line); 
     //   edges.add(tag_same_line);
      }
    }
    }
    }
    function execute_mode()
    {
        startloading();
        var myselect=document.getElementById("use_functions");
        var index=myselect.selectedIndex;
        var select=myselect.options[index].value; // 下拉菜单值
       // console.log('mode: ',select);
     switch(select) {
     case 'autoblank':
        // 简易枚举
        stoploading(blankfront());
      break;
     case 'search_node_execmode':
      stoploading(search_node_execmode());
      break;
     case 'childnodes_node_execmodes':
      stoploading(childnodes_node_execmodes());
      break;
     case 'singlenode_execmode':
      stoploading(singlenode_execmode());
      break; 
     default:
      alert('未选择模块');
      stoploading();
} 
    }

function setblank()
{
var myselect=document.getElementById("blank");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value; // 下拉菜单值  
var keyword=document.getElementById('keyword4search').value;
startloading();
switch(node_choosed)
{
case 'autoblank':
  blankfront();
        // 简易枚举
        stoploading();
break;
case 'advance_phone_blank':
  advance_phone_blank();
  stoploading();
break;
default:
  console.log('not set');    
  stoploading();
}
stoploading();
}


function newcitys()
{
var myselect=document.getElementById("provience_blank");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value;
  list=getURLString('./mode/phone/phone/phone_num_info.php?showinfo='+node_choosed).split('#');
  let location='';
  for(part in list)
  {
    if(list[part]!='')
    {
      location=location+'<option id="'+list[part]+'"'+'value="'+list[part]+'">'+list[part]+'</option>'
    // console.log(list[part]);
    }
  }
  document.getElementById("city_blank").innerHTML=location;
}

function advance_phone_blank()
{
  list=getURLString('./mode/phone/phone/phone_num_info.php?showinfo=provience').split('#');
  let location='';
  document.getElementById("insertBlank").innerHTML='<select id="provience_blank" style="position:absolute;left:0%;width:20%;height:50%;top:0;margin:0"></select>';
  for(part in list)
  {
    if(list[part]!='')
    {
      location=location+'<option id="'+list[part]+'"'+'value="'+list[part]+'">'+list[part]+'</option>';   
    }
  }
  add='<select onchange="newcitys()" id="provience_blank" style="position:absolute;left:0%;width:20%;height:50%;top:0;margin:0">'+location+'</select>';
  add='<select id="carrier_blank" style="position:absolute;left:40%;width:20%;height:50%;top:0%;margin:0"><option value="运营商">运营商</option><option value="电信">电信</option><option value="联通">联通</option><option value="移动">移动</option></select>'+add;
  add='<select id="city_blank" style="position:absolute;left:0%;width:20%;height:50%;top:50%;margin:0;"></select>'+add;
  add='<input id="tail_blank" placeholder="尾号" style="position:absolute;left:20%;width:20%;height:50%;top:0;margin:0"></input>'+add;
  add='<input id="nsid_blank" placeholder="网络识别号" style="position:absolute;left:20%;width:20%;height:50%;top:50%;margin:0"></input>'+add;
  add='<button onclick="advance_phone_blank()" "position:absolute;left:40%;width:20%;height:50%;top:0;margin:0">重置</button>'+add;
  add='<button onclick="exec_advance_phonenum()" style="position:absolute;left:40%;width:20%;height:50%;top:50;margin:0">执行枚举</button>'+add;
  document.getElementById("insertBlank").innerHTML=add;
}

function exec_advance_phonenum()
{
var myselect=document.getElementById("provience_blank");
var index=myselect.selectedIndex;
var provience=myselect.options[index].value;
var myselect=document.getElementById("city_blank");
var index=myselect.selectedIndex;
var city=myselect.options[index].value;
var nsid=document.getElementById('nsid_blank').value;
var tail=document.getElementById('tail_blank').value;
var myselect=document.getElementById("carrier_blank");
var index=myselect.selectedIndex;
var carrier=myselect.options[index].value;

url_add='';
if(provience)
{
if(provience!='省')
{
url_add=url_add+'&provience='+provience;
}
}
if(city){
if(city!='城市')
{
url_add=url_add+'&city='+city;
}
}
if(tail!='')
{
  if(tail.length==4)
  {
    url_add=url_add+'&tail='+tail;    
  }
  else
{
  alert(tail +' is a not legal phone numbers tail');
}
}
if(nsid!='')
{
  if(nsid.length==3)
  {
url_add=url_add+'&nsid='+nsid;
  }
  else
  {
  alert(nsid+' is not a legal phone numbers nsid');
  }
}

if(carrier!='运营商')
{
  url_add=url_add+'&carrier='+carrier; 
}


url='./mode/phone/phone/phone_num_info.php?'+url_add;
//console.log('url: '+url);
var start=document.getElementById('keyword4search').value;
if(start=='')
{
  alert('未初始化');
  return;
}
list=getURLString(url).split('#');
for(part in list)
{
  if(list[part]!='')
  {
  //  console.log(list[part]);  
  addnode(start,list[part],list[part],nodes,edges);
  }
}
}


function search_node_execmode()
{
var myselect=document.getElementById("nodeclass");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value; // 下拉菜单值 
for(i in network.body.nodes){
  try
  {
    if(node_choosed==get_setup_type(network.body.nodes[i].id))
{
  addnode_bymode(network.body.nodes[i].id);
}
  }
  catch(err)
  {
    console.log(network.body.nodes[i].id);
  }
  }
}

function childnodes_node_execmodes()
{

var myselect=document.getElementById("nodeclass");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value; // 下拉菜单值 
var  fromkeyword=document.getElementById('keyword4search').value;
var  list=network.getConnectedNodes(fromkeyword,'');
  for(num in list)
{
  if(get_setup_type(list[num])==node_choosed)
  {
   // console.log(list[num]);
    addnode_bymode(list[num]);
  // console.log(list[num]);
  }
}
}

function singlenode_execmode()
{
  var singlenode=document.getElementById('keyword4search').value;
  addnode_bymode(singlenode);
}

function addnode_type(input_mode)
{
register=/(_phone_reg.php)$/i;
if(register.test(input_mode))
{
return 'reg';
}
else 
{
return 'notreg';
}
} 



function addnode_bymode(fromnode_input)
{
var myselect=document.getElementById("addup_modes");
var index=myselect.selectedIndex;
var mode_choosed=myselect.options[index].value; 

var myselect1=document.getElementById("nodeclass");
var index=myselect1.selectedIndex;
var type=myselect1.options[index].value;

var exectype=addnode_type(mode_choosed); 
console.log(exectype);
var startnode=fromnode_input;
if(mode_choosed=='getinfo')
{
  url='./find_info_fromnode.php?input='+fromnode_input+'&type='+type;
 // console.log(url);
  var list=getURLString(url).split(',');
  for(var i in list)
  {
    if(list[i]!='')
    {
      addnode(fromnode_input,list[i],list[i],nodes,edges); 
    }
  }
  return 1;
}
var url='./mode/'+mode_choosed;
switch(exectype)
{
  case 'reg':
     console.log('startreg');  
 var result_reg=getURLString(url+'?'+get_setup_type(fromnode_input)+'='+fromnode_input).split('#');
 for(var i in mode_choosed)
 {
  if(mode_choosed[i]=='/')
  {
  var start=i;
  }
  if(mode_choosed[i]=='_')
  { 
  var end=i;   
  break;
  }
 }
 var site=mode_choosed.slice(start,end);
 site='registed:'+site.slice(1,site.length);
// console.log('site: '+site);
 for(mdn in result_reg)
 {
  if(result_reg[mdn])
  {
    if(result_reg[mdn]!='')
    {
   // console.log('result: '+result_reg[mdn]);  
    if(result_reg[mdn]=='true')  
    {
    addnode(fromnode_input,site,site,nodes,edges);
    }
    }
  }
 }
break;
 default:
 // console.log('info');  
  var data_list=getURLString(url+'?'+type+'='+fromnode_input).split(',');
  for(dln in data_list)
 {
  if(data_list[dln])
  {
    if(data_list[dln]!='')
    {
      if(data_list[dln]=='<newnode>')
      {
        continue;
      }
    if(data_list[dln-1]=='<newnode>')
    {
      addnode(fromnode_input,data_list[dln],data_list[dln],nodes,edges);
      startnode=data_list[dln];
    }
    else
    {
      addnode(startnode,data_list[dln],data_list[dln],nodes,edges);
    }  
    }
  }
 }
  break;   
}
return 'done';
}
    function remove_node_front(){
      
      remove_the_node(nodeid);
      return 1;
    }
    function remove_the_node(nodeid){
     // console.log(nodeid);
      let nodeid_s=nodeid.toString();
      try{
nodes.remove({id: nodeid_s});
      }
catch(err){
alert(nodeid_s,'dosn`t exists');
}
    }
function focuson(){
node=document.getElementById('seacrh_node').value;
if(!node){
  return;
}
else{
  try{network.focus(node);
  }
  catch(err){
    document.getElementById('search_node').value='no that node';
  }
}
}

function addnodefromdb(startnode,rowdata){
var data_string=rowdata.split('<br>');  
// console.log(startnode,data_string);
num=1;
create_node=0;
fromnode=startnode;
content_node=data_string[0]; 
tbname=content_node.split(':');
tbname_source=tbname[1];
// console.log('test:',tbname_source,key);
for(var key in data_string)
{
content_node=data_string[key];  
if(content_node)
{
if(content_node==data_string[0]){
console.log('tbname:',tbname_source);
}
else{
num1=0;
//  console.log('new leaf:',content_node);
addnode(startnode,content_node,content_node,nodes,edges); 
}
create_node=0;
}
else
{
  if(create_node<1){
  //console.log('create node');
  newname=tbname_source.split('.')[1];
  source=newname+':'+num;
  addnode(fromnode,source,source,nodes,edges); 
  startnode=source;
  num++;
  create_node++;  
  }
}
// key++;
}
remove_the_node(source);
return 0;
}
function choose_node(num){
  var node_choosed='proble_node'+num;
  document.getElementById('seacrh_node').value=document.getElementById(node_choosed).value;
  focuson(node_choosed);
  close_nodelist();
}
function close_nodelist(){
for(var i=0;i<5000;i++){
  var node_choosed='proble_node'+i;
  // console.log('node_choosed:',node_choosed);
if(node_choosed)
{
  try{
    nodeid=document.getElementById(node_choosed).value;
  document.getElementById(node_choosed).remove();
  }  
  catch(err)
  {
    if(document.getElementById(node_choosed))
    {
      document.getElementById(node_choosed).remove();
    }
  }
}
else 
{
    return ;
}
}
}


function returnnode_type(input_node_str)
{
var cn_phone_reg=/^[1][3,4,5,7,8,9][0-9]{9}$/;
var email_reg=/[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/;
var cn_idcard_reg=/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/;
var ipv4_reg=/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
var ipv6_reg=/^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i;
var domain_reg=/^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$/;
var weixin_reg=/^[a-zA-Z]([-_a-zA-Z0-9]{5,19})+$/;
var chinesename_reg=/[\u4E00-\u9FA5]{2,10}(·[\u4E00-\u9FA5]{2,10}){0,2}/;
var narmal_phone_reg=/^[\u4E00-\u9FA5]{2,10}(·[\u4E00-\u9FA5]{2,10}){0,2}$/;
var landline_reg=/^(0[0-9]{2})\d{8}$|^(0[0-9]{3}(\d{7,8}))$/;
var proble_username_reg= /^[a-zA-Z][a-zA-Z0-9_]{4,16}$/;
var proble_iemi=/^\d{15,17}$/;
var carid_reg=/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领 A-Z]{1}[A-HJ-NP-Z]{1}[A-Z0-9]{4}[A-Z0-9挂学警港澳]{1}$/;
var cn_passport=/(^[EeKkGgDdSsPpHh]\d{8}$)|(^(([Ee][a-fA-F])|([DdSsPp][Ee])|([Kk][Jj])|([Mm][Aa])|(1[45]))\d{7}$)/;
var bankcards_id=/^([1-9]{1})(\d{15}|\d{18})$/;
var file=/^[\s\S]*\.(zip|rar|7z|txt|php|docx|xls|sql|csv|html|pdf|doc||exe|bin|link|bak|dat|asp|sh|mp[0-9])$/;
var reg_reg=/^registed:/;
var image_reg=/\.(jpg|svg|png|img|ico|jpeg|gif|tif|webp|bmp)$/;
var company_reg=/(责任|集团|公司|有限|无限|社|会|厂|团队|工作室|实验室|研究|基地)/;
var address_reg=/(省|州|岛|市|城|区)/;
var home_reg=/(站|中心|酒店|商场|局|路|园|街|办事处|期|号|栋|单元|楼)/;
var url_reg=/^http(:|s:)\/\//;
var location_reg=/^(location:\[)(.*)]$/;
// 越靠前越优先返回
if(location_reg.test(input_node_str))
{
  return 'location';
}
if(cn_idcard_reg.test(input_node_str))
{
  return 'idcard';
}
else if(url_reg.test(input_node_str))
{
  return 'url';
}
else if(reg_reg.test(input_node_str))
{
  return 'registed';
}
else if(home_reg.test(input_node_str))
{
  return 'home';
}
else if(address_reg.test(input_node_str))
{
  return 'address';
}
else if(company_reg.test(input_node_str))
{
return 'company';
}
else if(file.test(input_node_str))
{
  return 'file';
}
else if(image_reg.test(input_node_str))
{
  return 'image';
}
else if(email_reg.test(input_node_str))
{
  return 'email';
}
else if(cn_phone_reg.test(input_node_str))
{
  return 'phone';
}
else if(ipv4_reg.test(input_node_str))
{
  return 'ip';
}
else if(ipv6_reg.test(input_node_str))
{
  return 'ip';
}
else if(domain_reg.test(input_node_str))
{
  return 'domain';
}
else if(carid_reg.test(input_node_str))
{
  return 'carid';
}
/* else if(bankcards_id.test(input_node_str))
{
  return 'bankcard_id';
} */
/* else if(chinesename_reg.test(input_node_str))
{
  return 'chinese_name';
} */
/* else if(narmal_phone_reg.test(input_node_str))
{
  return 'narmal_phone';
} */
else if(proble_username_reg.test(input_node_str))
{
  return 'username';
}
// console.log(input_node_str);
return 'unknown';
}

function setnode_type()
{
 var type_list=[]; 
 var keyword=document.getElementById('keyword4search').value;
 var frist_type=get_setup_type(keyword);
 //console.log('keyword: '+keyword,'frist_type: '+frist_type);
 alltype=getURLString('./showmode.php').split('#');
 for(var nodenum in alltype)
 {
  if(alltype[nodenum]==frist_type)
  {
    var swap=alltype[1];
    //  console.log('from: '+swap,'to: '+alltype[1]);
    alltype[1]=alltype[nodenum];
    alltype[nodenum]=swap;
  }
 }
 for(nodenum in alltype)
 {
  if(alltype[nodenum])
  {
  // alltype[nodenum]
  if(alltype[nodenum]!='')
  {
    type_list=type_list+'<option value="' + alltype[nodenum] + '" >'+ alltype[nodenum] + "</option>\n";
  }
  }
 }
 document.getElementById('nodeclass').innerHTML=type_list;
// console.log('frist_type: '+frist_type);

 return ;
}

</script>
<div> <button style="position:absolute;width:50%;height:100%;right:200%;margin:0">在图中搜索</buttom></div>  
</body>
</html>