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
	'/approot/rsc/js/99-git.js',
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
self.addEventListener('push', function(event) {
  event.waitUntil(
    self.registration.pushManager.getSubscription()
    .then(function(subscription) {
      fetch(TODO_URL + "get-notification?endpoint=" + JSON.stringify(subscription.endpoint))
      .then(function(response) {
        if (response.status !== 200) {
          // gestion des code d'erreurs HTTP
        }
        return response.json();
      })
      .then(function(data) {
        // obtenir de data les informations de la notification pour l'afficher
        var notificationOptions = {
          body: data.body,
          icon: data.icon ? data.icon : 'public/icons/icon-default.png',
          data:{
            url : data.clickUrl
          }
        };
        title = data.click;
        return self.registration.showNotification(title, notificationOptions);
      })
      .catch(function(err) {
        // gestion des erreurs
      })
    })
    .catch(function(err) {
      //gestion de l'erreur de récupération de l'inscription
    })
  );
});
self.addEventListener('notificationclick', function(event) {
  var url = event.notification.data.url;
  event.notification.close();
  event.waitUntil(clients.openWindow(url));
});


