
    json_array=[];          // 原始数据数组
    node_list_json=[];      // vis.js 能处理的 node json数组
    edge_list_json=[];      // 边的数组
    fnodes_wait_toexec=[];  // 待处理的模块-节点ID
    the_node_json='';       // 某处理数据 
    select_nodes_list=[]; // 选中的节点ID
    nodeid_filter_list=[];
    content='';

    console.log('tothemoon');
function tohelp()
{
  window.open('');
}


function togithub()
{
  window.open('https://github.com/LDZ-27/rabbit_list');
}

    function import_start()
    {
      let all=JSON.parse(fileContent);
      let nodes_list=all['nodes'];
      let edges_list=all['edges'];
      nodes = new vis.DataSet([]);
      edges = new vis.DataSet([]);
      container = document.getElementById("mynetwork");
      data = {
        nodes: nodes,
        edges: edges,
      };

    for(index in nodes_list)
    {
    nodes.add(nodes_list[index]); 
    }
    
    for(index in edges_list)
    {
    edges.add(edges_list[index]);
    }
     options = {
      interaction: { hover: true },
      manipulation: {
        enabled: true,
      },
      physics:{
  enabled: true,
  barnesHut: {
    gravitationalConstant: -48000,
    centralGravity: 0.4,
    springLength: 99.9999,
    springConstant: 0.1,
    damping: 0.1,
    avoidOverlap: 0
  },
}
    };
     network = new vis.Network(container, data, options);
     network.on("click", function (params) {
      img_type();
      auto_add();
      auto_draw();
      params.event = "[original event]";
      // console.log(params.event);
     //  alert(this.getNodeAt(params.pointer.DOM));
     if(network)
     {
      document.getElementById("nodesnum").value='all nodes: '+network.body.data.nodes.length;
     }
     try{
      if(nodes._data[this.getNodeAt(params.pointer.DOM)].id)
      {
      keyword=this.getNodeAt(params.pointer.DOM);
      document.getElementById("search_node").value=keyword;
      }
      document.getElementById("edgesnum").value='edges: '+network.body.nodes[keyword].edges.length;
     }
     catch(err)
     {
      document.getElementById("edgesnum").value='edges: null';
     }
     setnode_type();
     showmodes();
    });
    }
  
    function save_project(nodes,edges)
    {

      nodes_list='';
      edges_list='';
      try
      {
      if(!nodes)
      {
        return ;
      }
    }
    catch(err)
    {
      return ;
    }
      let filename=document.getElementById('filename').value;
      let n=0
      for(index in nodes._data)
      {
        new_node=JSON.stringify(nodes._data[index]);
        if(n>0)
        {
        nodes_list=nodes_list+','+new_node;
        }
        else 
        {
        nodes_list=new_node;
        }
        n++;
      }
      n=0;
      for(index in edges._data)
      {
        new_edge=JSON.stringify(edges._data[index]);
        if(n>0)
        {
        edges_list=edges_list+','+new_edge;
        }
        else 
        {
          edges_list=new_edge;
        }
        n++;
        
      }
     downloadStringAsFile('{"nodes":['+nodes_list+'],"edges":['+edges_list+']}',filename);
    }

    function show_outport()
    {
document.getElementById('show_alert').innerHTML='<div style="position:absolute;left:35%;top:30%;height:40%;width:30%;background-color:27C6AC;z-index:5"><button style="postion:fix;top:0%;left:100%;width:7.5%;height:12.5%;background-color:transparent;border:none" onclick="close_alert()"><img src="/img/close.png" width="100%"></button><div style="position:absolute;left:10%;top:10%;width:80%;height:80%;background-color:white"><input style="position:absolute;top:0%;height:20%;left:0%;width:100%;front-color:red;background-color:transparent" id="filename" value="" placeholder="请输入保存的文件名"></input><div style="position:absolute;top:20%;height:80%;left:0%;width:100%;background-color:grey"><button style="position:absolute;left:30%;width:40%;top:20%;height:80%;border:none;background-color:transparent" onclick="save_project(nodes,edges)"><img src="/img/save.png" width="60%"></img></button></div></div><button style="position:absolute;left:37.5%;width:25%;height:15%;top:85%;" onclick="save_project(nodes,edges)">确认保存</button></div>';
    }

function show_alert_databox()
{
  document.getElementById('show_alert').innerHTML='<div style="position:absolute;background-color:27c6ac;width:30%;height:40%;left:35%;top:30%;border:1% grey;border-style: double"><div style="position:absolute;background-color:white;left:10%;top:15%;width:80%;height:70%"> </div><div style="position:absolute;left:20%;width:60%;height:85%;background-color:white;border:none"><h style="position:absolute;Font-size:200%;width:100%;height:100%;text-align:center;margin:auto;background-color:27c6ac;">拖拽文件上传</h></div><button style="postion:fix;top:0%;left:100%;width:7.5%;height:12.5%;background-color:transparent;border:none" onclick="close_alert()"><img src="/img/close.png" width="100%"></img></button><div style="position:absolute;top:15%;left:5%;width:90%;height:70%;background-color:white" id="drop_zone"><div style="position:absolute;background-color:white;left:25%;width:50%;height:100%"><img src="/img/upload.png" width="100%"></img></div></div><div style="position:absolute;background-color:white;width:100%;height:15%;top:85%"></div><div style="position:absolute;width:100%;height:15%;background-color:27c6ac;top:85%"><button style="position:absolute;left:35%;width:30%;height:100%;background-color:white" onclick="import_start()">开始导入</button></div></div>';

  return '1';
}

function save_change(nodes,num)
{
  let node_id=nodes._data[nodeid_filter_list[num-1]].id;
  let node_id_new=document.getElementById('id_input').value;
  let node_img=nodes._data[node_id].image;
  let node_label=document.getElementById('label_input').value;
  let node_title=document.getElementById('title_input').value;
  let node_group=nodes._data[node_id].group;
  let node ={'id':node_id,'label':node_label,'image':node_img,'shape':'image','title':node_title,'group':node_group};
  nodes.update(node,node_id);
}    

function add_newnode(nodes,edges,num)
{
  let new_node_id=document.getElementById('newid_input').value;
  let node ={'id':new_node_id,'label':new_node_id,'image':'/img/icon/unknown.png','shape':'image','title':'','group':'user_add'};
  try
  {
    nodes.add(node);
  }
  catch(err)
  {

  }
  let node_id=nodes._data[nodeid_filter_list[num-1]].id;
  let edge={'id':'user_add'+ new_node_id+'@edge','to': new_node_id,'from': node_id,'arrows':'to','label':'手动添加','color':{'color':'#39c5bb'},'background':'false','width':'4','frontcolor':'gray'};
  try
  {
    edges.add(edge);
  }
  catch(err)
  {

  }
}

function close_alert()
{
  document.getElementById('show_alert').innerHTML='';
}

function show_more_div(num,nodes)
{
  try 
  {
  if(document.getElementById('div_'+num))
  {
    let choose_node_id=nodes._data[nodeid_filter_list[num-1]].id;
    let choose_node_label=nodes._data[choose_node_id].label;
    let choose_node_title=nodes._data[choose_node_id].title;
    let str='<div style="position:absolute;background-color:27C6AC;left:35%;width:30%;height:45%;top:20%;z-index:99;border:15px white;border-style: double;"><button style="postion:fix;top:0%;left:100%;width:7.5%;height:12.5%;background-color:transparent;border:none" onclick="close_alert()"><img src="/img/close.png" width="100%"></img></button><div style="position:absolute;top:12%;width:99%;height:17%;background-color:white;border:1% grey;border-style: double;">';
    str=str+'<input style="width:100%;height:100%" id="newid_input" placeholder="如果需要新增节点，在此输入节点ID" value=""></input></div><div style="position:absolute;top:30%;width:100%;height:70%;background-color:yellow"><div style="position:absolute;left:0;width:10%;height:100%;background-color:white;border:1% grey;border-style: double;"><div style="position:absolute;left:0;width:99%;height:15%;top:0;background-color:white;border:1% grey;border-style: double;">'+'<p>ID</p></div><div style="position:absolute;left:0;width:99%;height:15%;top:15%;background-color:white;border:1% grey;border-style: double;"><p>Label</p></div><div style="position:absolute;left:0;width:99%;height:69%;top:30%;background-color:white;border:1% grey;border-style: double;">'+'<p>Title</p></div></div><div style="position:absolute;left:10%;height:100%;width:89%;background-color:white;border:1% grey;border-style: double;"><div style="position:absolute;left:0;width:99%;height:15%;top:0;background-color:white;border:1% grey;border-style: double;">'+'<input style="width:100%;height:100%" id="id_input" placeholder="id" value="'+ choose_node_id +'"></input></div><div style="position:absolute;left:0;width:99%;height:15%;top:15%;background-color:white;border:1% grey;border-style: double;"><input style="width:100%;height:100%" id="label_input" placeholder="label_input" value="'+ choose_node_label +'"></input></div><div style="position:absolute;left:0;width:99%;height:69%;top:30%;background-color:white;border:1% grey;border-style: double;"><input style="width:100%;height:100%" id="title_input" placeholder="title" value="'+ choose_node_title +'"></input></div></div></div><button style="position:fix;bottom:0%;width:7.5%;height:10%;right:20%;background-color:transparent;border:none" onclick="retry_getcontent(nodes,'+num+')"><img src="/img/retry.png" width="100%"></img></button><button style="position:fix;bottom:0%;width:7.5%;height:10%;right:20%;background-color:transparent;border:none" onclick="add_newnode(nodes,edges,'+num+')"><img src="/img/add.png" width="100%"></img></button><button style="position:fix;bottom:0%;width:7.5%;height:10%;right:20%;background-color:transparent;border:none" onclick="save_change(nodes,'+num+')"><img src="/img/save.png" width="100%"></img></button></div>';
    document.getElementById('show_alert').innerHTML=str;
  } 
}
catch(err)
{

}
  return ;
}


window.onload=function() {dropzone = document.getElementById('show_alert');

// 阻止浏览器默认行为，防止文件在浏览器中打开
dropzone.addEventListener('dragover', window.onload=function(e) {
  e.preventDefault();
  e.stopPropagation();
});

// 获取拖放的文件并读取文件内容到字符串
dropzone.addEventListener('drop', window.onload=function(e) {
  e.preventDefault();
  e.stopPropagation();

  var file = e.dataTransfer.files[0];
  var reader = new FileReader();

  reader.onload = function() {
     fileContent = reader.result;
    // console.log(fileContent); // 将文件内容输出到控制台
  };

  reader.readAsText(file);
});
}

function retry_getcontent(nodes,num)
{
  try
  {
  let choose_node_id=nodes._data[nodeid_filter_list[num-1]].id;
  let choose_node_label=nodes._data[nodeid_filter_list[num-1]].title;
  let choose_node_title=nodes._data[nodeid_filter_list[num-1]].title;
  let str='<div style="position:absolute;background-color:27C6AC;left:35%;width:30%;height:45%;top:20%;border:15px white;border-style: double;"><button style="postion:fix;top:0%;left:100%;width:7.5%;height:12.5%;background-color:transparent;border:none" onclick="close_alert()"><img src="/img/close.png" width="100%"></img></button><div style="position:absolute;top:12%;width:99%;height:17%;background-color:white;border:1% grey;border-style: double;">';
  str=str+'<input style="width:100%;height:100%" id="newid_input" placeholder="如果需要新增节点，在此输入节点ID" value=""></input></div><div style="position:absolute;top:30%;width:100%;height:70%;background-color:yellow"><div style="position:absolute;left:0;width:10%;height:100%;background-color:white;border:1% grey;border-style: double;"><div style="position:absolute;left:0;width:99%;height:15%;top:0;background-color:white;border:1% grey;border-style: double;">'+'<p>ID</p></div><div style="position:absolute;left:0;width:99%;height:15%;top:15%;background-color:white;border:1% grey;border-style: double;"><p>Label</p></div><div style="position:absolute;left:0;width:99%;height:69%;top:30%;background-color:white;border:1% grey;border-style: double;">'+'<p>Title</p></div></div><div style="position:absolute;left:10%;height:100%;width:89%;background-color:white;border:1% grey;border-style: double;"><div style="position:absolute;left:0;width:99%;height:15%;top:0;background-color:white;border:1% grey;border-style: double;">'+'<input style="width:100%;height:100%" id="id_input" placeholder="id" value="'+ choose_node_id +'"></input></div><div style="position:absolute;left:0;width:99%;height:15%;top:15%;background-color:white;border:1% grey;border-style: double;"><input style="width:100%;height:100%" id="label_input" placeholder="label_input" value="'+ choose_node_label +'"></input></div><div style="position:absolute;left:0;width:99%;height:69%;top:30%;background-color:white;border:1% grey;border-style: double;"><input style="width:100%;height:100%" id="title_input" placeholder="title" value="'+ choose_node_title +'"></input></div></div></div><button style="position:fix;bottom:0%;width:7.5%;height:10%;right:20%;background-color:transparent;border:none" onclick="retry_getcontent(nodes,'+num+')"><img src="/img/retry.png" width="100%"></img></button><button style="position:fix;bottom:0%;width:7.5%;height:10%;right:20%;background-color:transparent;border:none" onclick="add_newnode(nodes,edges,'+num+')"><img src="/img/add.png" width="100%"></img></button><button style="position:fix;bottom:0%;width:7.5%;height:10%;right:20%;background-color:transparent;border:none" onclick="save_change(nodes,'+num+')"><img src="/img/save.png" width="100%"></img></button></div>';
  document.getElementById('show_alert').innerHTML=str; 
  }
  catch(err)
  {

  }
}

function choose_all_nodes()
{
  let choosed_list=[];
  for(let i=1;i<=nodeid_filter_list.length;i++)
  {
    if(document.getElementById('div_'+i).value=='✔️')
    {
    choosed_list.unshift(nodeid_filter_list[nodeid_filter_list.length-i]);
    }
  }
  network.selectNodes(choosed_list);
  return 1;
}

function filter(nodes)
{
nodeid_filter_list=[];
let filter_id=document.getElementById('filter_id').value;
if(!filter_id)
{
  alert('请输入filter_id');
  return;
}
var div_filter_test=new RegExp("("+filter_id+")");;
// nodeid_filter_list=['1','12','13','14'];
div_stream='<div style="position:absolute;width:100%;height:5%;background-color:grey;"><input style="position:absolute;width:10%;height:100%" value="选中" onclick="change_div(0)"></input><input style="position:absolute;left:10%;width:10%;height:100%" value="编号"></input><input style="position:absolute;background-color:white;color:black;width:60%;height:100%;left:20%;top:0%" id="filter_id_num_0" value="                符合的节点ID"></input><button style="position:absolute;width:10%;height:100%;right:10%" ><img src="/img/more.png" width="100%"></img></button><button style="position:absolute;width:10%;height:100%;right:0%"><img src="/img/setup.png" width="100%"></img></button><div>';
for (index in nodes._data) {
  let nodeid_tmp = nodes._data[index].id;
  if(nodes._data[index].id.indexOf(filter_id) !== -1)
  {
    nodeid_filter_list.unshift(nodeid_tmp);
  }
}
let width=100;
for (let index=1;index<nodeid_filter_list.length+1;index++)
{
  div_num=nodeid_filter_list.length-index+1;
  div_stream=div_stream+'<div style="position:absolute;width:100%;height:100%;background-color:grey;top:'+width+'%"><input style="position:absolute;width:10%;height:100%" value="❌" id="div_'+ index +'" onclick="change_div('+index+')"></input><input style="position:absolute;left:10%;width:10%;height:100%" value="'+index+'"></input><input style="position:absolute;background-color:white;color:black;width:60%;height:100%;left:20%;top:0%" id="filter_id_num_'+index+'" value="'+nodeid_filter_list[nodeid_filter_list.length-index]+'"></input><button style="position:absolute;width:10%;height:100%;right:10%" onclick="show_more_div('+div_num+',nodes)"><img src="/img/more.png" width="100%"></img></button><button style="position:absolute;width:10%;height:100%;right:0%" onclick="setup_div('+index+')"><img src="/img/setup.png" width="100%"></img></button><div>';
}
document.getElementById('filter_div').innerHTML=div_stream;

}

function change_div(num)
{
if(num==0)
{
  for(let i=1;i<nodeid_filter_list.length+1;i++)
  {
    if(document.getElementById('div_'+i))
    {
      try 
      {
      sign=document.getElementById('div_'+i).value;
      if(sign=='❌')
      {
        document.getElementById('div_'+i).value='✔️';
      }
      else 
      {
        document.getElementById('div_'+i).value='❌';
      }
    }
    catch(err)
    {

    }
    } 
    else 
    {
      break;
    }
  }
  return 0;
}
else 
{
  let sign=document.getElementById('div_'+num).value;
if(sign=='❌')
{
  document.getElementById('div_'+num).value='✔️';
}
else 
{
  document.getElementById('div_'+num).value='❌';
}

}
}


function advance_change()
{
let div_stream='<div style="position:absolute;width:100%;height:5%;background-color:grey;"><input style="position:absolute;width:10%;height:100%" value="选中" onclick="change_div(0)"></input><input style="position:absolute;left:10%;width:10%;height:100%" value="编号"></input><input style="position:absolute;background-color:white;color:black;width:60%;height:100%;left:20%;top:0%" id="filter_id_num_0" value="                符合的节点ID"></input><button style="position:absolute;width:10%;height:100%;right:10%" ><img src="/img/more.png" width="100%"></img></button><button style="position:absolute;width:10%;height:100%;right:0%"><img src="/img/setup.png" width="100%"></img></button><div>';
  let mid ='<div style="position:absolute;background-color:27C6AC ;width:25%;height:90%;left:5%;top:10%;"><div style="position:absolute;left:0%;height:100%;width:5%;background-color:27C6AC "></div><div style="position:absolute;top:0%;left:5%;height:15%;width:90%;background-color:27C6AC ;"><input style="position:absolute;background-color:white;color:black;left:5%;width:80%;height:50%;top:35%" placeholder="输入关键词 ID" value="" id="filter_id"></input><button style="position:absolute;right:2.5%;width:12.5%;height:50%;top:35%;background-color:27C6AC;border:none" onclick="filter(nodes)"><img src="/img/search.ico" width="100%"></img></button></div><button style="position:absolute;background-color:while;right:0%;width:10%;height:5.5%;z-index:10" onclick="close_outport()"><img src="/img/close.png" width="100%" alt="关闭"></img></button><div style="position:absolute;left:5%;top:15%;width:90%;height:85%;background-color:grey;overflow-y:auto" id="filter_div">'+ div_stream + '</div></div>';
 // let right='<div style="postion:absolute;background-color:blue;width:10%;height:50%;left:0%;top:0%"></div>';
  let html=mid;
  document.getElementById('addup').innerHTML=html;
}

    function getfnodes_list()
    {
      var myselect=document.getElementById("nodeclass");
      var index0=myselect.selectedIndex;
      var node_type=myselect.options[index0].value; // 下拉菜单值 
      // node_type 选择的节点类型
      var myselect=document.getElementById("use_functions");
      var index1=myselect.selectedIndex;
      var node_range=myselect.options[index1].value; // 下拉菜单值
      // node_range 作用范围
      var myselect=document.getElementById("addup_modes");
      var index2=myselect.selectedIndex;
      var mode_choosed=myselect.options[index2].value; 
      // mode_choosed
      var  fromkeyword=document.getElementById('search_node').value;
      var  childens_list=network.getConnectedNodes(fromkeyword,'');
      // from_keyword 选中的节点
      // childens_list 选中节点的子节点
      var edge_reg=/$edgeId:(.*)/;
      console.log(node_type,node_range,mode_choosed);
      if(mode_choosed=='useall')
      {
      console.log('use all modules');
      var modules=getURLString('./showmodules.php?mode='+node_type).split('#');
      for(var i in modules)
      {
      // console.log(modules[i]);
      if(modules[i].length>1)
      {
      var modules_tree=getURLString('./showmodules.php?mode='+node_type+'/'+modules[i]).split('#');
      for(var n in modules_tree)
      {
        if(modules_tree[n].length>1)
        {
          var url='/modules/'+node_type+'/'+modules[i]+'/'+modules_tree[n]+'?'+node_type+'=';
          console.log(url);
          //
          switch(node_range)
          {
            case 'singlenode_execmode':
              var url1=url+fromkeyword;
              fnodes_wait_toexec.unshift(url1);
              // 单个节点
            break;
            case 'search_node_execmode':
              // 自动匹配节点
              for(var i in network.body.nodes)
              {
              var node_id=network.body.nodes[i].id;
              if(get_setup_type(node_id)==node_type)
              {
              if(!edge_reg.test(node_id))
              {
                var url1=url+node_id;
                fnodes_wait_toexec.unshift(url1);
              }  
              }
              }
            break;
            case 'childnodes_node_execmodes':
              // 子节点中匹配节点
              for(var i in childens_list)
              {
              var node_id=childens_list[i];
              if(get_setup_type(node_id)==node_type)
              {
                if(!edge_reg.test(node_id))
                {
              var url1=url+node_id;
              fnodes_wait_toexec.unshift(url1);
                }
              }
              }
            break;      
          }
          //
        }
      }
      }
      }
    }
      else 
      {
      console.log('single module choosed');
      var url='/modules/'+mode_choosed+'?'+node_type+'=';;
      // 选择的单个模块执行
      switch(node_range)
      {
      case 'singlenode_execmode':
        var url1=url+fromkeyword;
        fnodes_wait_toexec.unshift(url1);
      break;
      case 'childnodes_node_execmodes':
      for(var i in childens_list)
      {
        var node_id=childens_list[i]; 
        if(get_setup_type(node_id)==node_type)
        {
        if(!edge_reg.test(node_id))
        {
        var url1=url+node_id;
        fnodes_wait_toexec.unshift(url1);
        }
      }
      }  
      break;
      case 'search_node_execmode':
        for(var i in network.body.nodes)
        {
          var node_id=network.body.nodes[i].id; 
          if(get_setup_type(node_id)==node_type)
          {
          if(!edge_reg.test(node_id))
          {
          var url1=url+node_id;
          fnodes_wait_toexec.unshift(url1);
          }
        }
        }
      break;      
      }
      }
 }
//   

function show_info()
{
  var this_node=document.getElementById('search_node').value;
  if(!this_node)
  {
    return;
  }
  var starty=10;
  var insert_data='';
  var n=1;
   insert_data=insert_data+'<input onclick="choose_outport_node(0,\'id\');choose_all(\'id\');"  style="position:absolute;height:5%;width:2.5%;left:10%;margin:0;top:'+starty+'%;" id="0_id" value="节点" placefolder="节点">';
   insert_data=insert_data+'<input onclick="choose_outport_node(0,\'id\');choose_all(\'id\');"   style="position:absolute;height:5%;width:2.5%;left:12.5%;margin:0;top:'+starty+'%;" id="0test_id" value="❌" placefolder="0">';
   insert_data=insert_data+'<input onclick="choose_outport_node(0,\'title\');choose_all(\'title\');"   style="position:absolute;height:5%;width:2.5%;left:15%;margin:0;top:'+starty+'%;" id="0_title" value="附加" placefolder="附加">';
   insert_data=insert_data+'<input onclick="choose_outport_node(0,\'title\');choose_all(\'title\');"   style="position:absolute;height:5%;width:2.5%;left:17.5%;margin:0;top:'+starty+'%;" id="0test_title" value="❌" placefolder="0">';  
   insert_data=insert_data+'<input onclick="outport_data()" style="position:absolute;height:5%;width:2.5%;left:20%;margin:0;top:'+starty+'%;" id="0_title" value="导出" placefolder="附加">';
   insert_data=insert_data+'<input onclick="close_outport()" style="position:absolute;height:5%;width:2.5%;left:22.5%;margin:0;top:'+starty+'%;" id="0test_title" value="关闭" placefolder="0">';  
   // onclick="close_outport()"
   // onclick="outport_choosed()"
   for(var i in nodes._data)
  {
    if(connect_test(this_node,nodes._data[i].id)==1)
    {
    starty=5*n+10;
  if(n<=21)
    {
    insert_data=insert_data+'<input onclick="choose_outport_node('+n+',\'id\')" style="position:absolute;height:5%;width:2.5%;left:10%;margin:0;top:'+starty+'%;" id="'+n+'_id" value="'+nodes._data[i].id+'" placefolder="'+i+'">';
    insert_data=insert_data+'<input onclick="choose_outport_node('+n+',\'id\')" style="position:absolute;height:5%;width:2.5%;left:12.5%;margin:0;top:'+starty+'%;" id="'+n+'test_id" value="❌" placefolder="'+n+'">';
    if(nodes._data[i].title)
    {
    insert_data=insert_data+'<input onclick="choose_outport_node('+n+',\'title\')" style="position:absolute;height:5%;width:2.5%;left:15%;margin:0;top:'+starty+'%;" id="'+n+'_title" value="'+nodes._data[i].title+'" placefolder="'+i+'">';
    }
    else
    {
      insert_data=insert_data+'<input onclick="choose_outport_node('+n+',\'title\')" style="position:absolute;height:5%;width:2.5%;left:15%;margin:0;top:'+starty+'%;" id="'+n+'_title" value="无" placefolder="'+i+'">';
    }
    insert_data=insert_data+'<input onclick="choose_outport_node('+n+',\'title\')" style="position:absolute;height:5%;width:2.5%;left:17.5%;margin:0;top:'+starty+'%;" id="'+n+'test_title" value="❌" placefolder="'+i+'">';  
  }
    n++;
  }
  }
  document.getElementById('addup').innerHTML=insert_data;
}

function choose_outport_node(n,a)
{
  if(a=='id')
{
if(document.getElementById(n+'test_id').value=='❌')
{
  document.getElementById(n+'test_id').value='✔️';
}
else
{
  document.getElementById(n+'test_id').value='❌';
}
}
else if(a=='title')
{
  if(document.getElementById(n+'test_title').value=='❌')
  {
    document.getElementById(n+'test_title').value='✔️';
  }
  else
  {
    document.getElementById(n+'test_title').value='❌';
  }
}
}

function close_outport()
{
  document.getElementById('addup').innerHTML='';
}

function change_task_status()
{
let change=document.getElementById('analyse');
if(change=='<button id="analyse" style="position:absolute;top:10.5%;right:7.5%;width:20%;height:5%;background-color:transparent;border-sytle:none;border-color:transparent;"><img src="/img/show.png" width="100%" onclick="change_tesk_status()" class="no_exif_metadata"> </button>')
{
document.getElementById('analyse').inertHTML='<button id="analyse" style="position:absolute;top:10.5%;right:7.5%;width:20%;height:5%;background-color:transparent;border-sytle:none;border-color:transparent;"><img src="/img/hide.png" width="100%" onclick="change_tesk_status()" class="no_exif_metadata"> </button>';
}
else if(change=='<button id="analyse" style="position:absolute;top:10.5%;right:7.5%;width:20%;height:5%;background-color:transparent;border-sytle:none;border-color:transparent;"><img src="/img/hide.png" width="100%" onclick="change_tesk_status()" class="no_exif_metadata"> </button>')
{
  document.getElementById('analyse').inertHTML='<button id="analyse" style="position:absolute;top:10.5%;right:7.5%;width:20%;height:5%;background-color:transparent;border-sytle:none;border-color:transparent;"><img src="/img/show.png" width="100%" onclick="change_tesk_status()" class="no_exif_metadata"> </button>';  
}

}


function outport_data()
{
  let data_id=[];
  let data_title=[];
  for(let i=1;i<=21;i++)
  {
    try
    {
    let part=document.getElementById(i+'test_id').value;
    if(!part)
    {
      break;
    }
    if(part=='✔️')
    {
    data_id.unshift(document.getElementById(i+'_id').value);
    }
  }
  catch(err)
  {

  }
  }
  for(let i=1;i<=21;i++)
  {
    try
    {
    let part=document.getElementById(i+'test_title').value;
    if(!part)
    {
      break;
    }
    if(part=='✔️')
    {
    data_title.unshift(document.getElementById(i+'_title').value);
    }
  }
  catch(err)
  {

  }
  }
  let obj="{'id':["+data_id.toString()+"],'title':["+data_title.toString()+']}';
  downloadStringAsFile(obj,'outport.txt');
}

function downloadStringAsFile(str,filename) {
  if(!filename)
  {
    filename='download.txt';
  }
  const element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(str));
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}

function choose_all(data_type)
{
  
if(data_type=='id')
{
 // choose_outport_node(0,'id'); 
for(var i=1;i<=21;i++)
{
  try
  {
  document.getElementById(i+'test_id').value=document.getElementById('0test_id').value;
  }
  catch(err)
  {
    break;
  }
}
}
else if(data_type=='title')
{
  // choose_outport_node(0,'title'); 
  for(var i=1;i<=21;i++)
{
try
{
  document.getElementById(i+'test_title').value=document.getElementById('0test_title').value;
}
catch(err)
{
  break;
}
}
}
}

function status_show()
{
  wait_num=fnodes_wait_toexec.length;
  if(wait_num!=0)
  {
  var str1='<div style="background-color:27C6AC ;height:100%;width:100%"><p style="text-align: center;">剩余任务数: '+wait_num+'</p></div>';  
  document.getElementById('wait_num').innerHTML=str1;
  document.getElementById('stoptry').innerHTML='<button onclick="stoptry()" style="background-color:27C6AC ">取消加载</button>';
  }
  else
  {
  var str1='<div style="background-color:27C6AC ;height:100%;width:100%"><p style="text-align: center;"> 处理数据 </p></div>';   
  if(json_array.length>0)
  {
  document.getElementById('wait_num').innerHTML=str1;
  document.getElementById('stoptry').innerHTML='<button onclick="stoptry()" style="background-color:#39c5b0">取消加载</button>';
  }
  else 
  {
  document.getElementById('stoptry').innerHTML='';  
  }  
}
  return ;
}

async function fetchJson(url) {
  if(url)
  {
  if(url.length>5)
  {
  const response = await fetch(url);
  const json =await response.json();
  // console.log(json);
  // return ;
  if (!response.ok) {
  // throw new Error(`Failed to fetch ${url}: ${response.status} ${response.statusText}`);
  // console.log(json);
  await delect_url(url);
  throw new Error('something wrong in fetch');  
}
  if(typeof json!='object')
  {
   // console.log(json);
   // console.log('error: '+url);
    await delect_url(url);
    throw new Error('data is not json');
    
  }
  await delect_url(url);
  return json;
}
  }
else
{
  await delect_url(url);
  throw new Error('url 错误');
}
await delect_url(url);
}

async function fetchAllJsons() {
  const jsonArr = [];
  const fetchPromises = await fnodes_wait_toexec.map(url => fetchJson(url));
 // fnodes_wait_toexec=[];
  while (fetchPromises.length > 0) {
    const [json, index] = await Promise.race(fetchPromises.map((p, i) => p.then(json => [json, i] )));
    jsonArr.push(...json);
    status_show();
    startloading();
   // console.log(JSON.stringify(json));
   // console.log(json);
    fetchPromises.splice(index, 1);
  }
  return jsonArr;
}

async function delect_url(url1)
{
  for(var i in fnodes_wait_toexec)
  {
    if(fnodes_wait_toexec[i]==url1)
    {
    fnodes_wait_toexec.splice(i,1);
    }
  }
}



async function test() 
{
  while(fnodes_wait_toexec.length>0)
  {
  await fetchAllJsons(fnodes_wait_toexec).then(jsonArr => {
  for(i of jsonArr)
  {
  json_array.unshift(i);
  }
}).catch(error => {
  fetchJson()
});
  }
}
//


    
 

function getfrist_fnode()
{
 the_fnode=fnodes_wait_toexec[0];
 fnodes_wait_toexec.shift();
 return; 
}

async function get_fristnode_raw() // 删除并把值赋予给 the_node_raw_json
{
the_node_raw_json=json_array[0];
json_array.shift();
return;
}

function get_fristnode_json() // 删除并把值赋予给 the_node_raw_json
{
the_node_json=node_list_json[0];
node_list_json.shift();
return;
}

function auto_add()
{
    while(json_array.length!=0)
    {
        addnode_tojson_list(); 
      //  addnode_fromjson_list();
    }
    return 1;
}

function auto_draw()
{
    while(node_list_json.length!=0)
    {
    addnode_fromjson_list();    
    }
    return 1;
}

function addnode_tojson_list() // 添加到待添加的节点列表
{
get_fristnode_raw();
if(!the_node_raw_json)
{
return ;
}
 
 let image=the_node_raw_json.imageurl;
 if(image)
 {
 tmp_node_json1 = {'id': the_node_raw_json.root_id,'label': the_node_raw_json.root_label,image,shape:'image','title':the_node_raw_json.title,'group':the_node_raw_json.type};
 the_edge_json1 = {'id': the_node_raw_json.root_id,'to': the_node_raw_json.root_id,'from': the_node_raw_json.from_id,'arrows':'to','label':the_node_raw_json.edge_label,'color':{'color':the_node_raw_json.edge_color},'background':'false','width':'4','frontcolor':'gray'};
try{
node_list_json.unshift(tmp_node_json1);
}
catch(err)
{
 console.log('same node');
}
try
{
  edge_list_json.unshift(the_edge_json1);
}
catch(err)
{
  console.log('same edge');
}
}
}

async function get_fristedge_json()
{
    the_edge_json=edge_list_json[0];
    edge_list_json.shift();
    return;  
}

 function addnode_fromjson_list()
{
    if(nodes)
    {
        // alert('未初始化');
         get_fristedge_json();
           if(the_edge_json)
           { 
          the_edge_json.id=the_edge_json.id+'@'+Math.random();  
           edges.add(the_edge_json);
         }
         get_fristnode_json();
        try
        {
            if(the_node_json)
            {
                nodes.add(the_node_json);
            }
            else 
            {
                return 0; // done
            }
        }
        catch(err)
        {
          nodes.update(the_node_json,the_node_json.id);
        }
    }
    return 1;
}

function startloading()
{
  document.getElementById('loading').innerHTML='<div class="loading" style="position:absolute;right:48.5%;left:48.5%;top:48.5%;bottom:48.5%;background-color: aquamarine;"></div>'
  '<div class="loading" style="position:absolute;right:48.5%;left:48.5%;top:48.5%;bottom:48.5%;background-color: aquamarine;"></div>';
  return 1;  
}

function stoptry()
{
  if(fnodes_wait_toexec.length>0)
  {
  fnodes_wait_toexec=[];
  }
  else
  {
    json_array=[];
  }
}

function stoploading(object)
{
  if(document.getElementById('loading'))
  {
    document.getElementById('loading').innerHTML='';
    document.getElementById('wait_num').innerHTML='';
    document.getElementById('stoptry').innerHTML='';
  }
}

function reflash()
{
  nodestart='';
  if(document.getElementById('nodes_init'))
  {
    nodestart=document.getElementById('nodes_init').value;
    // console.log('a');
    document.getElementById('show_alert').innerHTML='';
  }
  else 
  {
    nodestart=document.getElementById("search_node").value;
   // console.log('b');
  }
    nodes = new vis.DataSet([{id: nodestart, label: nodestart,'image':'/img/icon/start.png','shape':'image'}]);
    edges = new vis.DataSet([]);
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
    gravitationalConstant: -48000,
    centralGravity: 0.4,
    springLength: 99.9999,
    springConstant: 0.1,
    damping: 0.1,
    avoidOverlap: 0
  },
}
    };
    
     network = new vis.Network(container, data, options);
    // addnode
  // network 检测
  network.on("click", function (params) {
      img_type();
      auto_add();
      auto_draw();
      params.event = "[original event]";
      // console.log(params.event);
     //  alert(this.getNodeAt(params.pointer.DOM));
     if(network)
     {
      document.getElementById("nodesnum").value='all nodes: '+network.body.data.nodes.length;
     }
     try{
      if(nodes._data[this.getNodeAt(params.pointer.DOM)].id)
      {
      keyword=this.getNodeAt(params.pointer.DOM);
      document.getElementById("search_node").value=keyword;
      }
      document.getElementById("edgesnum").value='edges: '+network.body.nodes[keyword].edges.length;
     }
     catch(err)
     {
      document.getElementById("edgesnum").value='edges: null';
     }
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
allmodes=getURLString('./showmodules.php').split('#');
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
  treemode=getURLString('./showmodules.php?mode='+allmodes[mdn]).split('#');
  for(mdn1 in treemode)
  {
    if(treemode[mdn1]!='')
    {
      // console.log(allmodes[mdn]+'/'+treemode[mdn1]);
     // allmodes_html=allmodes_html+'<option value="' + allmodes[mdn]+'/'+treemode[mdn1] + '" >'+ allmodes[mdn]+'/'+treemode[mdn1] + "</option>\n";
      if(!mode_reg.test[treemode[mdn1]])
      {
      singlemodes=getURLString('./showmodules.php?mode='+allmodes[mdn]+'/'+treemode[mdn1]).split('#');  
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
document.getElementById('addup_modes').innerHTML='<option value="useall">所有模块</option>'+allmodes_html;
}

function gerurl()
{
var myselect=document.getElementById("addup_modes");
var index=myselect.selectedIndex;
var mode_choosed=myselect.options[index].value; // 下拉菜单值
var url='./modules/'+mode_choosed;
//  console.log(url);
}


function shownodes(){
  try
  {
  if(!network)
  {
    return ;
  }
}
catch(err)
{
  return ;
}
keyword=document.getElementById('search_node').value;
//keyword=keyword1.split('');
// console.log('keyword:',keyword);
var result='<div style="position:absolute;height:5%;width:10%;left:10%;margin:0;top:0">可能的节点</div>';
num=0;
var keyword_reg = new RegExp("(.*)("+keyword+")(.*)");
for(var obj in nodes._data){
    shownode=nodes._data[obj].id;
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
fromkeyword=document.getElementById('search_node').value;
if(reg.test(fromkeyword))
{
phone_reg_mode(fromkeyword);  
}  
return ;
}

function findphone(code){
var reg=/^[1][3,4,5,7,8,9][0-9]{9}$/;
fromkeyword=document.getElementById('search_node').value;
list=network.getConnectedNodes(fromkeyword,'');
if(!list)
{
// console.log('no data');
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
thisnode=document.getElementById('search_node').value;
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

function set_imgtype(nodes,edges)
{
  if(!network)
  {
    return;
  }
var nodeid=document.getElementById('search_node').value;
var list=network.getConnectedNodes(nodeid,'');
var myselect=document.getElementById("force_type");
var index=myselect.selectedIndex;
var select=myselect.options[index].value; // 下拉菜单值
newnode=nodes._data[nodeid];
// newedges=getedges(nodeid,edges);
newnode.image="/img/icon/"+select;
nodes.update(newnode,nodeid);
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
      var keyword=document.getElementById("search_node").value; // 搜索关键词
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
 // console.log(delby,delvalue);
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
    nodeid=document.getElementById("search_node").value;
    delnode(nodeid);
    return;
    break;
    case 'is_connect':
var fromkeyword=document.getElementById('search_node').value;
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
    if(connect_test(network.body.data.nodes._data[node_id].id,document.getElementById('search_node').value)==0)
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
  case 'inputreg':
    var reg = new RegExp(document.getElementById('delvalue').value);  
    for(node_id in network.body.data.nodes._data)
  {
  if(reg.test(network.body.data.nodes._data[node_id]))
  {
    delnode(network.body.data.nodes._data[node_id].id);
  }
  }
    break;
  default:

 }
    }
  }
} 

function connect_test(input_id,input_id2)
{
var fromkeyword=input_id2;
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
    function frontaddnode(){
       startnode=document.getElementById("search_node").value;
      // console.log('oldnode',startnode);
       if(!startnode)
        {
            alert('请选择起始节点');
        }
       newnodeid=newnodelabel=document.getElementById("search_node").value;
      // console.log('newnode',newnodeid);
       addnode(startnode,newnodeid,newnodeid,nodes,edges);
       // alert(startnode);
    }

function loading()
{
getfnodes_list()
test();
status_show();
}

function asyncLoop() {
    setInterval(function() {
    auto_add();
    auto_draw();
    try 
    {
    choose_all_nodes();
    }
    catch(err)
    {
      
    }
    if(fnodes_wait_toexec.length==0)
    {
      stoploading();
    }
  }, 1000);
}

asyncLoop();



function testconnect(from,to)
{
  var list=network.getConnectedNodes(from,'');
  if(list==null || !to)
  {
    return 0;
  }
  for(i=0;i<=list.length;i++)
  {
    if(list[i]==to)
    {
      return 1;
    }
  }
  return 0;
}

  async function addnode(startfromnode,newnodeid,newnodelabel,nodes,edges){
    // console.log('from',startfromnode);
    startloading();
    // console.log('to',newnodeid);   
    if(newnodeid.length>=64)
    {
      return 1;
    }
     var image=addimg(returnnode_type(newnodeid));
     try
     {
       if(newnodeid!=startfromnode)
       {
        let newNode = {'id': newnodeid,'label': newnodelabel,image,shape:'image'};
        let line = {'from': newnodeid,'to': startfromnode,'arrows': "from",'dashes': [5, 5, 3, 3], 'background': 'false',color:{ color:'red'}};
         nodes.add(newNode);
         edges.add(line);
       }
    }
    catch(err) 
    {
      if(newnodeid!=startfromnode)
      {
        if(testconnect(startfromnode,newnodeid)==0)
        {
     //  tagid='tag: '+ newnodeid + Math.random()*10000;
     let newNode = {'id': newnodeid,'label': newnodelabel,image,shape:'image'};
     //  let tagsame= {'id':tagid,'lable':'sametag','color':"red"}
     //  nodes.add(tagsame);
     let line ={'from':newnodeid,'to':startfromnode,'arrows': "from",color:{ color:'red'}};
     // let tag_same_line ={'from':newnodeid,'to':tagid};
      edges.add(line); 
     //   edges.add(tag_same_line);
      }
    }
    }
    stoploading();
    }
 async function execute_mode()
    {
       // console.log('startloading');
        var myselect=document.getElementById("use_functions");
        var index=myselect.selectedIndex;
        var select=myselect.options[index].value; // 下拉菜单值
       // console.log('mode: ',select);
   switch(select) {
     case 'autoblank':
        // 简易枚举
        if(!document.getElementById('search_node').value)
        {
          alert('未选中');
        //  stoploading();
          return ;
        }
       blankfront();
      break;
     case 'search_node_execmode':
      setTimeout( async function() {
        await search_node_execmode();
   stoploading();
},100); 
      break;
     case 'childnodes_node_execmodes':
      setTimeout( async function() {
        await childnodes_node_execmodes();
   stoploading();
},100);  
      break;
     case 'singlenode_execmode':
      setTimeout( async function() {
       await singlenode_execmode();
   stoploading();
},100);
      break; 
     default:
      alert('未选择模块');
    //  stoploading();
      return ;
} 
return ;
    }

function setblank()
{
var myselect=document.getElementById("blank");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value; // 下拉菜单值  
var keyword=document.getElementById('search_node').value;
startloading();
var key1=document.getElementById('search_node').value.split('');
       var num=0;
switch(node_choosed)
{
case 'autoblank':
  for(var i in key1)
        {
          if(key1[i]=='*')
          {
           // console.log(key1[i]);
            num++;
          }
        }
        if(num>2)
        {
          alert('数量级过大已阻止操作');
          return ;
        }
  blankfront();
        // 简易枚举
    //    stoploading();
break;
case 'advance_phone_blank':
  advance_phone_blank();
//  stoploading();
break;
default:
  console.log('not set');    
 // stoploading();
}
// stoploading();
}


function newcitys()
{
var myselect=document.getElementById("provience_blank");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value;
  list=getURLString('./modules/phone/info/basicinfo.php?showinfo='+node_choosed).split('#');
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
  list=getURLString('./modules/phone/info/basicinfo.php?showinfo=provience').split('#');
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
  return ;
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
  return ;
  }
}

if(carrier!='运营商')
{
  url_add=url_add+'&carrier='+carrier; 
}

var start=document.getElementById('search_node').value;
url='./modules/phone/info/basicinfo.php?'+url_add+'&phone1='+start;
//console.log('url: '+url);
if(start=='')
{
  alert('未初始化');
  return;
}
fnodes_wait_toexec.unshift(url);
test();
}



async function search_node_execmode()
{
var myselect=document.getElementById("nodeclass");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value; // 下拉菜单值 
for(i in network.body.nodes){
  try
  {
    if(node_choosed==get_setup_type(network.body.nodes[i].id))
{
  if(network.body.nodes[i].id.length<=16)
  {
  addnode_bymode(network.body.nodes[i].id);
  }
 
}
  }
  catch(err)
  {
    console.log(network.body.nodes[i].id);
  }
  }
  return 1;
}

async function childnodes_node_execmodes()
{

var myselect=document.getElementById("nodeclass");
var index=myselect.selectedIndex;
var node_choosed=myselect.options[index].value; // 下拉菜单值 
var  fromkeyword=document.getElementById('search_node').value;
var  list=network.getConnectedNodes(fromkeyword,'');
  for(num in list)
{
  if(get_setup_type(list[num])==node_choosed)
  {
      addnode_bymode(list[num]);
  }
}
return 1;
}

function singlenode_execmode()
{
  var singlenode=document.getElementById('search_node').value;
  addnode_bymode(singlenode);
  return 1;
}



function addnode_type(input_mode)
{
register=/(_reg.php)$/i;
if(register.test(input_mode))
{
return 'reg';
}
else 
{
return 'notreg';
}
} 



async function addnode_bymode(fromnode_input)
{
var myselect=document.getElementById("addup_modes");
var index=myselect.selectedIndex;
var mode_choosed=myselect.options[index].value; 

var myselect1=document.getElementById("nodeclass");
var index=myselect1.selectedIndex;
var type=myselect1.options[index].value;

var exectype=addnode_type(mode_choosed); 
// console.log(exectype);
var startnode=fromnode_input;
var url='./modules/'+mode_choosed;
switch(exectype)
{
  case 'reg':
  //   console.log('startreg');  
 var result_reg=getURLString(url + '?' + get_setup_type(fromnode_input) + '=' + fromnode_input).split('#');
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
  var data_list=getURLString(url + '?' + type + '=' + fromnode_input).split(',');
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
node=document.getElementById('search_node').value;
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
  document.getElementById('search_node').value=document.getElementById(node_choosed).value;
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
var unknown=/([\*])/;  
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
if(unknown.test(input_node_str))
{
  return 'unknown';
}
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
 var keyword=document.getElementById('search_node').value;
 var frist_type=get_setup_type(keyword);
 //console.log('keyword: '+keyword,'frist_type: '+frist_type);
 alltype=getURLString('./showmodules.php').split('#');
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
