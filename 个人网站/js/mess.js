$(function(){
	class Mess{
		constructor(){
			this.arry;
			this.arry();
			this.sub();
			this.search();
		}
		arry(){
			this.arry = ["../img/face.gif","../img/face1.gif","../img/face2.gif","../img/face3.gif","../img/face4.gif","../img/face5.gif","../img/face6.gif","../img/face7.gif","../img/face8.gif"];
			console.log(this.arry[Math.floor(Math.random()*10)]);
			this.url = this.arry[Math.floor(Math.random()*10)];
		}
		sub(){
			var self = this;
			$("#sub").on("click",function(e){
				e.preventDefault();
				self.jiao();
			})
		}
		jiao(){
			var self = this;
			var name = $("#name").val();
			var text = $("#text").val();
//			console.log(name);
			$.post("../php/liuyan/insert.php",{
				"name":name,
				"text":text,
				"url":this.url
			},function(data){
				console.log(data);
				self.search();
			})
		}
		search(){			
			let tempStr = $("#liuyan").html();
			$.post("../php/liuyan/search.php",data=>{
				$(".lang").empty();
				console.log(data);
				if(!data.data) return;
				data = typeof data == 'object'?data:eval("(" +data+ ")");
				var dataArry = data.data;
				for (var i = 0; i < dataArry.length; i++) {
					var DomString = templateFn(tempStr,dataArry[i]);
					$(".lang").prepend(DomString);
				}
				function templateFn(tempStr,data){
					return tempStr.replace(/\@([a-z\w]+)\@/g,function(match,$1,index,string){
						return data[$1];
					});
				}
			})
		}
	}
	const mess = new Mess();
})
