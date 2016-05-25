<?php
		require_once("/path/api/KalturaClient.php"); 
		require_once("/path/api/KalturaPlugins/KalturaMetadataClientPlugin.php"); 
		define("PARTNER_ID", "AddYourPartnerIdHere");
		define("ADMIN_SECRET", "AddYourAdminSecretHere");
		define("USER_SECRET",  "AddYourUserSecretHere");
		define("METADATA_ID",  "AddYourMetaDataIdFieldHere");
		$user = "kalturaadmin.email@example.com";
		if($_POST['category']){
			$kalturaConf = new KalturaConfiguration(PARTNER_ID);
			$client = new KalturaClient($kalturaConf);		
			$session = $client->session->start(ADMIN_SECRET, $user, KalturaSessionType::ADMIN);
			$client->setKs($session);		
			$pager = new KalturaFilterPager();
			$pager->pageSize = 5;
			$pager->pageIndex = $_GET['page'];	
			$filter = new KalturaMediaEntryFilter();
			$filter->orderBy = KalturaMediaEntryOrderBy::CREATED_AT_DESC;
			$filter->categoriesIdsMatchOr   = $_POST['category']; //'Samples>Sample Videos';
			$result = $client->media->listAction($filter,$pager);
			$profile = new KalturaMetadataProfile();
			$profile->metadataObjectType = KalturaMetadataObjectType::ENTRY;		
			foreach($result->objects as $entry){		
				$metadataId = METADATA_ID;
				$filter = new KalturaMetadataFilter();
				$filter->objectIdEqual = $entry->id;
				$metadata = $client->metadata->listAction($filter)->objects;		
				$xmlData = '<metadata>
							  <Key>downloadmedia</Key>
							  <Value>'.$_POST['values'].'</Value>
							</metadata>';
				$m = false;
				foreach($metadata as $meta){
					if($meta->metadataProfileId == $metadataId){
						$m = true;
						$metadataId = $meta->id;
					}
				}
				if($m === true){
					$rc = $client->metadata->update($metadataId, $xmlData);
				} else{
					$rc = $client->metadata->add($metadataId, $profile->metadataObjectType,  $entry->id, $xmlData);
				}
			}		
			echo $result->totalCount;
		}