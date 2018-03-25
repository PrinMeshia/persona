(function () {
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
		return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
	}

	function updateNetworkStatus() {
		if (navigator.onLine) {
			mobNav.classList.add('app__offline');
			header.classList.remove('app__offline');
		} else {
			toast('You are now offline..');
			header.classList.add('app__offline');
			mobNav.classList.add('app__offline');
		}
	}
	/* listenner */
	document.addEventListener('DOMContentLoaded', function (event) {
		//On initial load to check connectivity
		if (!navigator.onLine) updateNetworkStatus();
		window.addEventListener('online', updateNetworkStatus, false);
		window.addEventListener('offline', updateNetworkStatus, false);
	});
	hamBtn.addEventListener('click', function () {
		if (hasClass(document.body, 'navigation')) document.body.classList.remove('navigation');
		else document.body.classList.add('navigation');
		hambtnClick = !hambtnClick;
	}, false);
	overLay.addEventListener('click', function () {
		document.body.classList.remove('navigation');
		hambtnClick = !hambtnClick;
	}, false);
	mobilePushBtn.addEventListener('click', function () {
		if (isSubscribed) {
			unsubscribe();
		} else {
			subscribeDevice();
		}
	}, false);
	pnBtn.addEventListener('click', function () {
		if (isSubscribed) {
			unsubscribe();
		} else {
			subscribeDevice();
		}
	}, false);
	window.onresize = function () {
		if ((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) > 768) document.body.classList.remove('navigation');
		else {
			if (hambtnClick) document.body.classList.add('navigation');
		}
	};
	/* Navigation Mobile swift*/
	hammertime.on('swipeleft', function () {
		document.body.classList.remove('navigation');
	});
	hammertime.on('swiperight', function () {
		document.body.classList.add('navigation');
	});
	/*serviceWorker*/

	function subscribeDevice() {
		navigator.serviceWorker.ready.then(function (serviceWorkerRegistration) {
			// Demande d'inscription au Push Server (1)
			return serviceWorkerRegistration.pushManager.subscribe({ userVisibleOnly: true });
		}).then(function (subscription) {
			//sauvegarde de l'inscription dans le serveur applicatif (2)
			fetch('/register-to-notification', {
				method: 'post',
				headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				credentials: 'same-origin',
				body: JSON.stringify(subscription)
			}).then(function (response) {
				return response.json();
			}).catch(function (err) {
				console.log('Could not register subscription into app server', err);
			});
		}).catch(function (subscriptionErr) {
			// Check for a permission prompt issue
			console.log('Subscription failed ' + subscriptionErr);
		});
	}

	if ('serviceWorker' in navigator) {
		if (navigator.serviceWorker.controller) {
			console.log('Service worker found, no need to register')
		} else {
			navigator.serviceWorker.register('./sw.js', {
				scope: './'
			}).then(function (reg) {
				registry = SWReg;
				console.log('Service worker has been registered for scope:' + reg.scope);
			});
		}
	}
	/* XHR */
	function callApi(action, value, callback) {
		var path = action;
		if (typeof value != undefined) path += '/' + value;
	}
})();