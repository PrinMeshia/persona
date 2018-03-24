var CACHE_NAME = 'persona-cache-v1';
var urls2Cache = [
	'/',
	'/approot/rsc/css/101-container.css',
  '/approot/rsc/css/100-global.css',
  '/approot/rsc/css/102-cs.css',
	'/approot/rsc/css/103-mobile.css',
	'/approot/rsc/css/199-custom.css',
	'/approot/rsc/js/00-lib.js',
	'/approot/rsc/js/10-app.js',
	'/approot/rsc/js/11-latest.js',
	'/approot/rsc/js/12-toast.js'
  
];

/*Enregistrement en cache*/
self.addEventListener('install',function(e){
	e.waitUntil(
		caches.open(CACHE_NAME).then(function(cache){
			console.log('cache ready');
			return cache.addAll(urls2Cache);
		})
	);
});

/*récupération du cache*/
self.addEventListener('fetch', function(e) {
  e.respondWith(
    caches.match(e.request).then(function(res) {
        if (res) {
          return res;
        }
        return fetch(e.request);
      })
    );
});



/*maj du cache*/
self.addEventListener('activate',function(e){
	var WLcache = [CACHE_NAME];
	e.waitUntil(
		caches.keys().then(function(cacheNames){
			return Promise.all(
				cacheNames.map(function(cacheName){
					if(WLcache.indexOf(cacheName) === -1)
						return caches.delete(cacheName);
				})
			);
		})
	);
});
self.addEventListener('push', function(e) {
  var title = "We reached a milestone.";
  var body = "Come quick! The counter is going crazy!";
  var icon = 'images/icons/icon-android-152x152.png';
  Element.waitUntil(
    self.registration.showNotification(title, {
      'body': body,
      'icon': icon
    }));
});
self.addEventListener('notificationclick', function(e) {
  e.notification.close();
  e.waitUntil(clients.matchAll({
    type: 'window'
  }).then(function(clientList) {
    for (var i = 0; i < clientList.length; i++) {
      var client = clientList[i];
      if (client.url === '/' && 'focus' in client) {
        return client.focus();
      }
    }
    if (clients.openWindow) {
      return clients.openWindow('/');
    }
  }));
});


