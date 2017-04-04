!function($,UI){
	"use strict";
	var switchs=function($element){
		var _this=this;
		if($element.length>1){
			$element.each(function(){
				_this._init($(this));
			});
		}else{
			_this._init($element);
		}
		return this;
	}
	switchs.prototype._init=function($element){
		var _class=$element[0].className;
		$element[0].className="";
		var $switch=$("<div _switch></div>");
		$switch[0].className=_class;
		if($element.is(':checked'))$switch.addClass('am-active');
		$switch.append('<div class="am-switch-handle"></div>')
		$element.wrap($switch);
	}
	switchs.prototype._on=function(){
		$(document).on('click','.am-switch',function(){
			var $checkbox=$(this).find("input[type='checkbox']");
			var state=$checkbox.is(':checked');
			$(this).css({
				'transition-duration': '0.2s'
			});
			$checkbox.prop("checked",!state);
			if(state){
				$(this).removeClass('am-active');
			}else{
				$(this).addClass('am-active');
			}
		});
	};
	$.fn.extend({
		'switch':function(){
			return new switchs(this);
		}
	});
	UI.ready(function(context) {
		$('.am-switch', context).switch()._on();
	});
}(jQuery,jQuery.AMUI);