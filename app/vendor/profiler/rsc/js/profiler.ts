'use strict';

class Profiler{
    ListEl : any = {};
    bindEvent(el:any, eventName:string, callback:any){
        if(el instanceof NodeList){
			for (let i = 0, len = el.length; i < len; i++) {
				el[i].addEventListener(eventName, callback, false);
			}
        }else
            el.addEventListener(eventName, callback, false); 
    }
    hide(el:HTMLElement){
		el.style.display = "none";
    }
    show(el:HTMLElement){
        el.style.display = "block";
    } 
}
let ProfilerBar : Profiler = new Profiler();
        ProfilerBar.bindEvent(document.querySelectorAll('#profilerBar [rel="close"]'), 'click', function (e) {
			ProfilerBar.hide(<HTMLElement>document.querySelector('#profilerBar_body'));
			ProfilerBar.hide(<HTMLElement>document.querySelector('#profilerBar [rel="close"]'));
		});
        ProfilerBar.bindEvent(document.querySelectorAll('#profilerBar .profilerBar-tab'), 'click', function () {
            ProfilerBar.show(<HTMLElement>document.querySelector('#profilerBar_body'));
			ProfilerBar.show(<HTMLElement>document.querySelector('#profilerBar [rel="close"]'));
			var items = document.querySelectorAll('#profilerBar .profilerBar_body-item');
			for (var i = 0, len = items.length; i < len; i++) {
				ProfilerBar.hide(<HTMLElement>items[i]);
			}
			ProfilerBar.show(<HTMLElement>document.querySelector('#'+this.getAttribute("rel")));
        });
