/*public js xianhuachneg.com*/
/*Tab Search style*/
function selectsearch(theA,word){
 obj=document.getElementById("selectsearch").getElementsByTagName("a");
 for(var i=0;i< obj.length;i++ ){
  obj[i].className='';
 }
 theA.className='choose';
  if(word=='restaurant_name'){
	  $("input[name='search_type']").val('shop');
	  $("#hot_shop").show().next().hide();
  }else if(word=='food_name'){
	  $("input[name='search_type']").val('food');
	  $("#hot_shop").hide().next().show();
  }
}
//INDEX TAB LIST
window.onload = function ()
{
	var oLi = document.getElementById("Indextab").getElementsByTagName("li");
	var oUl = document.getElementById("Indexcontent").getElementsByTagName("ul");
	for(var i = 0; i < oLi.length; i++)
	{
		oLi[i].index = i;
		oLi[i].onclick = function ()
		{
			for(var n = 0; n < oLi.length; n++) oLi[n].className="";
			this.className = "current";
			for(var n = 0; n < oUl.length; n++) oUl[n].style.display = "none";
			oUl[this.index].style.display = "block"
		}	
	}
}
/*change radio background color*/
function changeColor(arg){  
var rdCount = document.getElementsByName("rdColor").length;  
for(i=1;i<=rdCount;i++){  
document.getElementById("style"+i).style.fontWeight = "normal"; 
document.getElementById("style"+i).style.backgroundColor = "";
document.getElementById("style"+i).style.boxShadow = "none"; 
document.getElementById("style"+i).style.border = "none";
}  
document.getElementById("style"+arg).style.backgroundColor = "#fff5cc";
document.getElementById("style"+arg).style.fontWeight = "bold";
document.getElementById("style"+arg).style.boxShadow = "3px 2px 10px #dedede";
document.getElementById("style"+arg).style.border = "1px #ffe580 solid";
}

function getUrl(){
	var href = top.location.href;
	var _index = href.indexOf('?');
	var str = '';
	var arr = new Object();
	if(_index != -1){
		str = href.substr(_index+1);
		str = str.split('&');
		for(var i=0;i<str.length;i++){
			var a = str[i];
			a = a.split('=');
			var b = a[0];
			arr[b] = a[1] ? a[1] : '';
		}
		return arr;
	}
	return arr;
}

var hoturl = $("#hoturl").val(); 	//index/get_hotword
function getHotWords(type) {
	$.ajax({
		type: "POST",
		url: hoturl,
		data: {type:type},
		dataType:'json',
		success: function(msg){
			var str='';
			$.each(msg.shop,function (k,v) {
				str+='<a href="/search/search?keyword='+v.hot_word+'" title="'+v.hot_word+'">'+v.hot_word+'</a>';
			});
			$("#hot_shop").html(str);
			str='';
			$.each(msg.food,function (k,v) {
				str+='<a href="/search/search?search_type=food&keyword='+v.hot_word+'" title="'+v.hot_word+'">'+v.hot_word+'</a>';
			});
			$("#hot_food").html(str);
		}
	});
}

getHotWords(0);