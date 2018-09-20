 $(function(){
	class Index {
		constructor(){
			this.pages = 1;
			this.allPageList = 1;
			this.long = 13;
			this.search();
			this.click();
			this.back();
		}
		
		search(){
			var self = this;
			let templateString = $("#knowledge").html();
			$.post('../php/xinxi.php',{
				pages:self.pages,
				longs:self.long,
			},function(data){
				$('.every_dian').empty();
				data = typeof data == 'object' ? data : eval("(" +data+ ")");
				var dataArry = data.data;
				console.log(dataArry);
				self.allPageList = Math.ceil(data.nums/13);
				console.log(self.allPageList);
				if(self.allPageList == 0) self.allPageList = 0;
				if(self.pages > self.allPageList){
					self.pages = self.allPageList;
				}			
				for (var i = 0; i < dataArry.length; i++) {
					var DomString = templateFn(templateString,dataArry[i]); 
//					console.log(dataArry[i].id)
					$(".every_dian").append(DomString);	
				}
				$(".every_dian li").each(function(i){
					var jump = dataArry[i].id;
//						console.log(jump);
					$(this).attr("dataPage",jump);
					$(this).on("click",function(e){
						e.preventDefault();
						console.log(jump);
						window.open("../html/details.html#" + jump,"_self");
					})
				})
				function templateFn(templateString,data){
					return templateString.replace(/\@([a-z\w]+)\@/g,function(match,$1,index,string){
						return data[$1];
					});
				}
				
				
			})
			
		}
		click(){
			var self = this;
			$('.next').on('click',function(){
				console.log(self.allPageList);
				if(self.pages < self.allPageList){
					self.pages ++;
					console.log(self.allPageList);
					self.search();
				}
		
			})
			$('.prev').on('click',function(){
				if(self.pages >1){
					self.pages --;
				}
				self.allPageList = self.pages;
				self.search();
			})
		}
		back(){
			$(window).scroll(() => {
				let t = $(window).scrollTop();
				if(t > 600){
					$(".back").show();
				}else{
					$(".back").hide();
				}
			})
			$(".back").click( () => {
				$('html,body').animate({
					"scrollTop":0
				})
			})
		}		
	}
	const ind = new Index();
})
