<?php

class PWASetting extends DataObject {
	public $__table = 'pwa_settings';
	public $id;
	public $name;
	public $autoRotateCard;
	public $enableSelfRegistration;
	public $showMoreInfoBtn;
	public $manifestID;
	public $startURL;
	public $slug;
	public $sha256CertFingerprint;

	private $_libraries;

	static function getObjectStructure($context = ''): array {
		$libraryList = Library::getLibraryList(!UserAccount::userHasPermission('Administer All Libraries'));

		$structure = [
			'id' => [
				'property' => 'id',
				'type' => 'label',
				'label' => 'Id',
				'description' => 'The unique id',
			],
			'name' => [
				'property' => 'name',
				'type' => 'text',
				'label' => 'Name',
				'description' => 'The name for these settings',
				'maxLength' => 50,
				'required' => true,
			],
			'manifestID' => [
				'property' => 'manifestID',
				'type' => 'text',
				'label' => 'Manifest ID',
				'description' => 'the ID to be displayed in the manifest.json',
				'maxLength' => 50,
				'required' => true,
			],
			'startURL' => [
				'property' => 'startURL',
				'type' => 'text',
				'label' => 'Start URL',
				'description' => 'URL for the application to start at.',
				'maxLength' => 50,
				'required' => true,
				'default' => '/',
			],
			'slug' => [
				'property' => 'slug',
				'type' => 'text',
				'label' => 'Slug',
				'description' => 'slug to identify the application',
				'maxLength' => 50,
				'required' => true,
			],
			'sha256CertFingerprint' => [
				'property' => 'sha256CertFingerprint',
				'type' => 'text',
				'label' => 'Sha 256 Cert Fingerprint',
				'description' => 'Provided by Google Play after initial upload; proves that App and the website are authorized',
				'maxLength' => 200,
				'required' => true,
			],
			'autoRotateCard' => [
				'property' => 'autoRotateCard',
				'type' => 'checkbox',
				'label' => 'Automatically rotate the library card screen to landscape',
				'description' => 'Whether or not the library card screen automatically rotates to landscape mode when navigated to.',
				'hideInLists' => true,
			],
			'enableSelfRegistration' => [
				'property' => 'enableSelfRegistration',
				'type' => 'checkbox',
				'label' => 'Enable self-registration',
				'description' => 'Whether or not users can self register for a new account in LiDA.',
				'hideInLists' => true,
			],
			'showMoreInfoBtn' => [
				'property' => 'showMoreInfoBtn',
				'type' => 'checkbox',
				'label' => 'Show More Info button on Grouped Work Screen',
				'note' => 'This button opens up an in-app Aspen Discovery session to see additional record information.',
				'description' => 'Whether or not to display a More Info button in Aspen LiDA on the Grouped Work screen.',
				'hideInLists' => true,
			],
			'libraries' => [
				'property' => 'libraries',
				'type' => 'multiSelect',
				'listStyle' => 'checkboxSimple',
				'label' => 'Libraries',
				'description' => 'Define libraries that use these settings',
				'values' => $libraryList,
				'hideInLists' => true,
			],
			'firebaseAPIKey' => [
				'property' => 'firebaseAPIKey',
				'type' => 'text',
				'label' => 'Firebase API Key',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			],
			'firebaseAuthDomain' => [
				'property' => 'firebaseAuthDomain',
				'type' => 'text',
				'label' => 'Firebase Authorization Domain',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			],
			'firebaseProjectID' => [
				'property' => 'firebaseProjectID',
				'type' => 'text',
				'label' => 'Firebase project ID',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			],
			'firebaseStorageBucket' => [
				'property' => 'firebaseStorageBucket',
				'type' => 'text',
				'label' => 'Firebase Storage Bucket',
				'description' => 'URL for firebase Storage',
				'maxLength' => 50,
				'required' => true,

			],
			'firebaseMessagingSenderID' => [
				'property' => 'firebaseMessagingSenderID',
				'type' => 'text',
				'label' => 'Firebase Messaging Sender ID',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			],
			'firebaseAppID' => [
				'property' => 'firebaseAppID',
				'type' => 'text',
				'label' => 'Firebase application ID',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			],
			'firebaseMeasurementID' => [
				'property' => 'firebaseMeasurementID',
				'type' => 'text',
				'label' => 'Firebase Measurement ID',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			],
			'vapidKey' => [
				'property' => 'vapidKey',
				'type' => 'text',
				'label' => 'Vapid Key',
				'description' => 'description here',
				'maxLength' => 50,
				'required' => true,

			]
		];
		// TODO should we have a PWA permission?
		if (!UserAccount::userHasPermission('Administer Aspen LiDA Settings')) {
			unset($structure['libraries']);
		}

		return $structure;
	}

	function getFirebaseSettings(){
		return [
			'firebaseAPIKey' => $this->firebaseAPIKey,
			'firebaseAuthDomain' =>$this->firebaseAuthDomain,
			'firebaseProjectID' => $this->firebaseProjectID,
			'firebaseStorageBucket' => $this->firebaseStorageBucket,
			'firebaseMessagingSenderID' => $this->firebaseMessagingSenderID,
			'firebaseAppID' => $this->firebaseAppID,
			'firebaseMeasurementID' => $this->firebaseMeasurementID,
			'vapidKey' => $this->vapidKey
		];
	}
}
?>