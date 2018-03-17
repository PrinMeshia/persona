'use strict';

class Profiler{
    ListEl : any = {};
    static bindEvent(el:any, eventName:string, callback:any){
        if(el instanceof NodeList){
			for (let i = 0, len = el.length; i < len; i++) {
				el[i].addEventListener(eventName, callback, false);
			}
        }else
            el.addEventListener(eventName, callback, false); 
    }
    static hide(el:HTMLElement){
		el.style.display = "none";
    }
    static show(el:HTMLElement){
        el.style.display = "block";
    } 
}
let ProfilerBar : Profiler = new Profiler();
        Profiler.bindEvent(document.querySelectorAll('#profilerBar [rel="close"]'), 'click', function (e) {
			Profiler.hide(<HTMLElement>document.querySelector('#profilerBar_body'));
			Profiler.hide(<HTMLElement>document.querySelector('#profilerBar [rel="close"]'));
		});
        Profiler.bindEvent(document.querySelectorAll('#profilerBar .profilerBar-tab'), 'click', function () {
            Profiler.show(<HTMLElement>document.querySelector('#profilerBar_body'));
			Profiler.show(<HTMLElement>document.querySelector('#profilerBar [rel="close"]'));
			var items = document.querySelectorAll('#profilerBar .profilerBar_body-item');
			for (var i = 0, len = items.length; i < len; i++) {
				Profiler.hide(<HTMLElement>items[i]);
			}
			Profiler.show(<HTMLElement>document.querySelector('#'+this.getAttribute("rel")));
        });
