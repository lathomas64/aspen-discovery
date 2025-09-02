//not bundled because we only want to include this if PWA is turned on
console.log("serviceWorker.js loaded...");
import { initializeApp } from 'https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js';
import { getMessaging, getToken, onMessage, onBackgroundMessage } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-messaging-sw.js";

// TODO: Replace the following with your app's Firebase project configuration
//http://localhost:8083/API/SystemAPI?method=getFirebaseSettings
const firebaseConfig = {
  
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Cloud Messaging and get a reference to the service
const messaging = getMessaging(app);
getToken(messaging, {vapidKey: firebaseConfig['vapidKey']}).then((currentToken) => {
	if (currentToken) {
		// TODO send the token to your server and update the UI if necessary
		//https://firebase.google.com/docs/cloud-messaging/js/first-message#web
	} else {
		//show permission request UI
		// QUESTION when do we get here? when is token falsey
		console.log('no registration token available. request permission to generate one.');
	}
}).catch((err) => {
	console.log('an error occured while retrieving token. ', err);
});

onMessage(messaging, (payload) => {
	console.log('Message received. ', payload);
});

onBackgroundMessage(messaging, (payload) => {
	console.log('[firebase-messaging-sw.js] Received background message ', payload);
	// Customize notification here
	const notificationTitle = 'Background Message Title';
	const notificationOptions = {
	  body: 'Background Message body.',
	  icon: '/firebase-logo.png'
	};
  
	self.registration.showNotification(notificationTitle,
	  notificationOptions);
  });

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
