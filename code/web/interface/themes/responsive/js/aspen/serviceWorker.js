//not bundled because we only want to include this if PWA is turned on
console.log("serviceWorker.js loaded...");
console.log("updated code...");

const CACHE_NAME = 'aspen-mobile';

const PRECACHE_ASSETS = [

];

self.addEventListener('install', event => {
	console.log("install fired");
	event.waitUntil((async () => {
		const cache = await caches.open(CACHE_NAME);
		cache.addAll(PRECACHE_ASSETS);
	})());
});

self.addEventListener('activate', event => {
	console.log("activate fired");
	event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
	console.log("fetch...");
	event.respondWith(async () => {
		const cache = await caches.open(CACHE_NAME);

		// match the request to our cache
		const cachedResponse = await cache.match(event.request);

		// check if we got a valid response
		if (cachedResponse !== undefined) {
			// Cache hit, return the resource
			return cachedResponse;
		} else {
			// Otherwise, go to the network
			return fetch(event.request)
		};
	});
});

self.addEventListener('push', (event) => {
	console.log("event push");
	event.waitUntil(
		self.registration.showNotification('Notification Title', {
			body: 'Notification Body Text',
			icon: 'custom-notification-icon.png',
		})
	);
});

self.addEventListener('notificationclick', (event) => {
	console.log("notification clicked");
	event.notification.close();
	var fullPath = self.location.origin + event.notification.data.path;
	clients.openWindow(fullPath);
});

function notifyMe() {
	if (!("Notification" in window)) {
	  // Check if the browser supports notifications
	  alert("This browser does not support desktop notification");
	} else if (Notification.permission === "granted") {
	  // Check whether notification permissions have already been granted;
	  // if so, create a notification
	  const notification = new Notification("Hi there!");
	  // …
	} else if (Notification.permission !== "denied") {
	  // We need to ask the user for permission
	  Notification.requestPermission().then((permission) => {
		// If the user accepts, let's create a notification
		if (permission === "granted") {
		  const notification = new Notification("Hi there!");
		  // …
		}
	  });
	}
  
	// At last, if the user has denied notifications, and you
	// want to be respectful there is no need to bother them anymore.
  }
