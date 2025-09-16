import { initializeApp } from 'https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js';
console.log("did we import anything?");
import { getMessaging } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-messaging-sw.js";
import { getToken } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-messaging.js";
//import { create } from 'apisauce';

// TODO: Replace the following with your app's Firebase project configuration
//http://localhost:8083/API/SystemAPI?method=getFirebaseSettings
fetch("/API/SystemAPI?method=getFirebaseSettings").then(function (response) {
	return response.json();
}).then(function (data) {
	if(data.result?.success)
	{
		//do things for getting settings here. 
		console.log(data.result.settings);
		const firebaseConfig = data.result.settings;
		// Initialize Firebase
		const app = initializeApp(firebaseConfig);
		console.log(app);

		// Initialize Firebase Cloud Messaging and get a reference to the service
		const messaging = getMessaging(app);
		console.log(messaging);
		getToken(messaging, {vapidKey: firebaseConfig['vapidKey']}).then((currentToken) => {
			if (currentToken) {
				// TODO send the token to your server and update the UI if necessary
				//https://firebase.google.com/docs/cloud-messaging/js/first-message#web
				//https://console.firebase.google.com/project/aspen-pwa-test/notification/compose
				console.log(currentToken);
				Notification.requestPermission().then((permission) => {
					if (permission === 'granted') {
					  console.log('Notification permission granted.');
					  fetch("/API/SystemAPI?method=saveFirebaseToken&token="+currentToken);
					}
				  });
			} else {
				//show permission request UI
				// QUESTION when do we get here? when is token falsey
				console.log('no registration token available. request permission to generate one.');
			}
		}).catch((err) => {
			console.log('an error occured while retrieving token. ', err);
		});
		messaging.onBackgroundMessageHandler = (payload) => {
			console.log('[firebase-messaging-sw.js] Received background message ', payload);
			// Customize notification here
			const notificationTitle = 'Background Message Title';
			const notificationOptions = {
			body: 'Background Message body.',
			icon: '/firebase-logo.png'
			};
		
			self.registration.showNotification(notificationTitle,
			notificationOptions);
		};
	}
	else {
		//we failed to get settings here. 
		console.log("We ran into a snag getting settings");
		console.log(data.result.error)
	}
});