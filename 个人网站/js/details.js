$(function(){
	class Details{
		constructor(){
			this.data();
		}
		data(){
			var hash = parseInt(window.location.hash.slice(1));
			console.log(hash);
			let str = $("#matter").html();
			$.post("../php/details.php",{
				id:hash
			},function(data){
				$("section").empty();
				data = typeof data == "object"?data:eval("("+data+")");
				console.log(data);
				var substr = templateFn(str,data);
				$("section").append(substr);
				function templateFn(str,data){
					return str.replace(/\@([a-z\w]+)\@/g,function(match,$1,index,string){
						return data[$1];
					})
				}
			})
		}
	}
	new Details();
})
