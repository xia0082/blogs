$(function(){
	class Home{
		constructor(){
			this.time = null;
			this.lock = true;
			this.sing();
			this.chang();
			this.tab();
			this.logins();
		}
		sing(){
			let num = 0;
			this.time = setInterval(function(){
				num ++;
				$(".aud img").css({
					"transform":"rotate("+ num + "deg)"
				})
			},10)	
			//不可以使用jq设置音频的播放，暂停
			$(".aud audio")[0].play();
			
		}
		chang(){
			var self = this;
			$('.aud img').mouseover( () => {
				if(self.lock){
					clearInterval(this.time);
					console.log($('.aud img'));
					$(".aud audio").removeAttr("autoplay");
					$(".aud audio")[0].pause();
					
					self.lock = false;
				}else{
					self.sing();
					$(".aud audio")[0].play();
					self.lock = true;
				}
			})
		}
		tab(){
			$(".login span").on("click",function(){
				var index = $(this).index();
//				console.log(index);
				$(this).addClass('active').siblings().removeClass('active');
				$(".info section").eq(index).addClass('singin').siblings().removeClass('singin');
			})
		}
		logins(){
			$("#btn").on("click",function(e){
				e.preventDefault();
				var user = $("#user").val();
				var pwd = $("#pwd").val();
//				console.log(user);
				if(user == "" || pwd == ""){
					alert("填写内容不能为空");	
				}
				$.post("../php/login&register/login.php",{
					'user':user,
					'pwd':pwd
				},function(data){
//					console.log(data);
					if(data.message == '用户已存在'){
						alert(data.message);
					}else{
						alert(data.message);
					}
				})
			})
			$("#reg").on("click",function(e){
				e.preventDefault();
				var user = $("#user").val();
				var pwd = $("#pwd").val();
				$.post("../php/login&register/register.php",{
					'user':user,
					'pwd':pwd
				},function(data){
					console.log(data);
					if(data == "登录成功"){
						location.href = '../html/index.html';
					}else{
						alert(data);
					}
				})
			})
		}
	}
	const h = new Home();
})
