<?php
namespace Craft;

return array(

	'xlsUploadPath' => craft()->path->getPluginsPath().'excelimporter/uploads/',

	//accepted file upload types
	'validUploadMimes' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
);