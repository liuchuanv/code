/** jquery 插件集合 **/

;(function($, window, undefined){
	
	/** 1.导航定位插件 **/
	var navposition = function(options){
		var $that = this;
		var defaults = {
				extraTop : 50,	//必须是数字
				linkClass : '',
				fixedClass : '',
			},
			settings = $.extend({}, defaults, options),
			arr_top = [],				//存储导航元素对应的id元素的top值
			links = this.find("li a");	//导航元素
		//遍历导航元素
		links.each(function(index, ele){
			var $this = $(this);
			var id = $this.attr("href");
			arr_top[index] = $(id).offset().top;
			
			//点击事件
			$this.click(function(){
				$("html, body").animate({scrollTop : arr_top[index]}, 300);
			});
		});
		//最后附加一个长度
		arr_top.push(arr_top[arr_top.length-1] + settings.extraTop);
		
		//滚动事件
		$(window).scroll(function(){
			var scrollTop = $(this).scrollTop() + settings.extraTop;
			var len = arr_top.length;
			for(var i=0; i<len-1; i++){
				if(scrollTop > arr_top[i] && scrollTop < arr_top[i+1]){
					$(links[i]).parent().addClass(settings.linkClass);
				}else{
					$(links[i]).parent().removeClass(settings.linkClass);
				}
			}
			if(scrollTop < arr_top[0]){
				$that.removeClass(settings.fixedClass);
				$that.next().css("margin-top", 0);
				return ;
			}else{
				//固定菜单
				$that.addClass(settings.fixedClass);
				$that.next().css("margin-top", $that.outerHeight(true));
			}
			
		});
	};
	$.fn.navposition = navposition;
	
	/** 2.图片上传本地预览插件**/
	/*
	*名称:图片上传本地预览插件 v1.1
	*作者:周祥
	*时间:2013年11月26日
	*介绍:基于JQUERY扩展,图片上传预览插件 目前兼容浏览器(IE 谷歌 火狐) 不支持safari
	*插件网站:http://keleyi.com/keleyi/phtml/image/16.htm
	*参数说明: Img:图片ID;Width:预览宽度;Height:预览高度;ImgType:支持文件类型;Callback:选择文件显示图片后回调方法;
	*使用方法: 
	<div>
	<img id="ImgPr" width="120" height="120" /></div>
	<input type="file" id="up" />
	把需要进行预览的IMG标签外 套一个DIV 然后给上传控件ID给予uploadPreview事件
	$("#up").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120, ImgType: ["gif", "jpeg", "jpg", "bmp", "png"], Callback: function () { }});
	*/
	function uploadPreview(opts) {
		var _self = this,
			_this = $(this);
		opts = jQuery.extend({
			Img: "ImgPr",
			Width: 100,
			Height: 100,
			ImgType: ["gif", "jpeg", "jpg", "bmp", "png"],
			Callback: function () {}
		}, opts || {});
		_self.getObjectURL = function (file) {
			var url = null;
			if (window.createObjectURL != undefined) {
				url = window.createObjectURL(file)
			} else if (window.URL != undefined) {
				url = window.URL.createObjectURL(file)
			} else if (window.webkitURL != undefined) {
				url = window.webkitURL.createObjectURL(file)
			}
			return url
		};
		_this.change(function () {
			if (this.value) {
				if (!RegExp("\.(" + opts.ImgType.join("|") + ")$", "i").test(this.value.toLowerCase())) {
					alert("选择文件错误,图片类型必须是" + opts.ImgType.join("，") + "中的一种");
					this.value = "";
					return false
				}
				if ($.browser.msie) {
					try {
						$("#" + opts.Img).attr('src', _self.getObjectURL(this.files[0]))
					} catch (e) {
						var src = "";
						var obj = $("#" + opts.Img);
						var div = obj.parent("div")[0];
						_self.select();
						if (top != self) {
							window.parent.document.body.focus()
						} else {
							_self.blur()
						}
						src = document.selection.createRange().text;
						document.selection.empty();
						obj.hide();
						obj.parent("div").css({
							'filter': 'progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)',
							'width': opts.Width + 'px',
							'height': opts.Height + 'px'
						});
						div.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = src
					}
				} else {
					$("#" + opts.Img).attr('src', _self.getObjectURL(this.files[0]))
				}
				opts.Callback()
			}
		})
	};
	jQuery.fn.uploadPreview = uploadPreview;
	
})($, window);