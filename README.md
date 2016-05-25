# Kaltura API for Bulk Metadata Changes

###Using the Kaltura API to change custom metadata fields
In this example, I have added two custom metadata fields called "Key" and "Value", which control 1. whether videos can be downloaded in MediaSpace, and 2. which trascoded flavors can be downloaded. However, this could be used for any metadata field (e.g., Tags, Description, Categories) with a few tweaks.

###What It Does
Sometimes it's necessary to apply bulk metadata changes or additions and Kaltura doesn't provide many of these options out of the box. However, the API gives us the ability to create an interface for a Kaltura admin to enter a category id and trancoding ids and apply this in bulk to all videos in the category (instead of one at a time). 

###The Files
* Upload the API folder to your server and note the path
* Add post.php to your server
* Add index.html to your server

###Secure the files
Make sure you place these files in a secure location (e.g., password protect directory, firewall, etc.). If these files are accessible, not only could someone make global changes to the metadata on your videos but they could also potentially access your account admin secret in the post.php file.

###Add Kaltura Information
* Open post.php in your favorite editor
* Change the path to the KalturaClient.php and KalturaMetadataClientPlugin.php to match the path on your server
* Add your partner id and keys
* Add the metadata id
* Add the email of an admin user for your Kaltura account
```php
    require_once("/path/api/KalturaClient.php"); 
		require_once("/path/api/KalturaPlugins/KalturaMetadataClientPlugin.php"); 
		define("PARTNER_ID", "AddYourPartnerIdHere");
		define("ADMIN_SECRET", "AddYourAdminSecretHere");
		define("USER_SECRET",  "AddYourUserSecretHere");
		define("METADATA_ID",  "AddYourMetaDataIdFieldHere");
		$user = "kalturaadmin.email@example.com";
```
Now you should be able to enter a category id into the top field and trascoding ids into the values field and then this will be applied to all videos in the category.
