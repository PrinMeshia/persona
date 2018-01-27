'use strict';
var Profiler = (function() {
    function Profiler() {
        this.ListEl = {};
    }
    Profiler.prototype.bindEvent = function(el, eventName, callback) {
        if (el instanceof NodeList) {
            for (var i = 0, len = el.length; i < len; i++) {
                el[i].addEventListener(eventName, callback, false);
            }
        } else
            el.addEventListener(eventName, callback, false);
    };
    Profiler.prototype.hide = function(el) {
        el.style.display = "none";
    };
    Profiler.prototype.show = function(el) {
        el.style.display = "block";
    };
    return Profiler;
}());
var ProfilerBar = new Profiler();
ProfilerBar.bindEvent(document.querySelectorAll('#profilerBar [rel="close"]'), 'click', function(e) {
    ProfilerBar.hide(document.querySelector('#profilerBar_body'));
    ProfilerBar.hide(document.querySelector('#profilerBar [rel="close"]'));
});
ProfilerBar.bindEvent(document.querySelectorAll('#profilerBar .profilerBar-tab'), 'click', function() {
    ProfilerBar.show(document.querySelector('#profilerBar_body'));
    ProfilerBar.show(document.querySelector('#profilerBar [rel="close"]'));
    var items = document.querySelectorAll('#profilerBar .profilerBar_body-item');
    for (var i = 0, len = items.length; i < len; i++) {
        ProfilerBar.hide(items[i]);
    }
    ProfilerBar.show(document.querySelector('#' + this.getAttribute("rel")));
});