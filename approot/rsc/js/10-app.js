(function() {
	'use strict';
	/* ITEM */
	var overLay = document.querySelector('#overlay');
	var header = document.querySelector('header');
	var mobNav = document.querySelector('#mobileNavigation')
	var hamBtn = document.querySelector('#hamburger');
	var closeBtn = document.querySelector('#close');
	var countElem = document.querySelector('#count');
	var pnBtn = document.querySelector('#pushBtn');
	var mobilePushBtn = document.querySelector('#mobilePushBtn');
	/*var*/
	var hambtnClick = false;
	var defer = localStorage.defer || 0;
	var hammertime = new Hammer(document.body);
	var registry;
	var hasPush = false;
	var xhr = new XMLHttpRequest();
	/* FUNCTION*/
	function hasClass(element, cls) {
		return(' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
	}

	function updateNetworkStatus() {
		if(navigator.onLine) {
			mobNav.classList.add('app__offline');
			header.classList.remove('app__offline');
		} else {
			toast('You are now offline..');
			header.classList.add('app__offline');
			mobNav.classList.add('app__offline');
		}
	}
	/* listenner */
	document.addEventListener('DOMContentLoaded', function(event) {
		//On initial load to check connectivity
		if(!navigator.onLine) updateNetworkStatus();
		window.addEventListener('online', updateNetworkStatus, false);
		window.addEventListener('offline', updateNetworkStatus, false);
	});
	hamBtn.addEventListener('click', function() {
		if(hasClass(document.body, 'navigation')) document.body.classList.remove('navigation');
		else document.body.classList.add('navigation');
		hambtnClick = !hambtnClick;
	}, false);
	overLay.addEventListener('click', function() {
		document.body.classList.remove('navigation');
		hambtnClick = !hambtnClick;
	}, false);
	mobilePushBtn.addEventListener('click', function() {
		if(isSubscribed) {
			unsubscribe();
		} else {
			subscribe();
		}
	}, false);
	window.onresize = function() {
		if((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) > 768) document.body.classList.remove('navigation');
		else {
			if(hambtnClick) document.body.classList.add('navigation');
		}
	};
	/* Navigation Mobile swift*/
	hammertime.on('swipeleft', function() {
		document.body.classList.remove('navigation');
	});
	hammertime.on('swiperight', function() {
		document.body.classList.add('navigation');
	});
	/*serviceWorker*/
	if('serviceWorker' in navigator) {
		navigator.serviceWorker.register('./sw.js', {
			scope: './'
		}).then(function(SWReg) {
			registry = SWReg;
			console.log('Service worker registered!');
		}).catch(function(error) {
			console.log('There was an error! ' + error);
		});
	}
	/* XHR */
	function callApi(action, value, callback) {
		var path = action;
		if(typeof value != undefined) path += '/' + value;
	}
})();