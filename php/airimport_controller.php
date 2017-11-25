<?php 
global $db,$request;
//echo $request;
//echo "included controller";
include('airimport.class.php');
$airimport = new Airimport();
$action = $request['action'];
switch($action)
{
	case 'addimport':
		$result = $airimport->addImportDetails();
		$output = json_encode($result);
		echo $output;
		break;
	
	case 'addimportsea':
		$result = $airimport->addImportSeaDetails();
		$output = json_encode($result);
		echo $output;
		break;

	case 'updateimportsea':
		$result = $airimport->updateImportSeaDetails();
		$output = json_encode($result);
		echo $output;
		break;
		
	case 'addsample':
		$result = $airimport->addSampleAndOpenOrder();
		$output = json_encode($result);
		echo $output;
		break;

	case 'addsurvey':
		$result = $airimport->addImportSurvey();
		$output = json_encode($result);
		echo $output;
		break;	
		
	case 'addotherdetails':
		$result = $airimport->addOtherImportDetails();
		$output = json_encode($result);
		echo $output;
		break;
		
	case 'addclearance':
		$result = $airimport->addClearanceDetails();
		$output = json_encode($result);
		echo $output;
		break;
		
	case 'updateclearance':
		$result = $airimport->updateClearanceDetails();
		$output = json_encode($result);
		echo $output;
		break;

	case 'updateSampleDetails':
		$result = $airimport->updateSampleDetails();
		$output = json_encode($result);
		echo $output;
		break;

	case 'updateSurveyDetails':
		$result = $airimport->updateSurveyDetails();
		$output = json_encode($result);
		echo $output;
		break;

	case 'updateOtherDetails':
		$result = $airimport->updateOtherDetails();
		$output = json_encode($result);
		echo $output;
		break;
		
	case 'updatePersonnelDetails':
		$result = $airimport->updatePersonnelDetails();
		$output = json_encode($result);
		echo $output;
		break;

	case 'addpersonnel':
		$result = $airimport->addPersonnelDetails();
		$output = json_encode($result);
		echo $output;
		break;
	case 'getImportSeaDetails':
		$result = $airimport->getImportSeaDetails();
		$output = json_encode($result);
		echo $output;
		break;
	case 'getClearanceDetails':
		$result = $airimport->getClearanceDetails();
		$output = json_encode($result);
		echo $output;
		break;
	case 'getPersonnelDetails':
		$result = $airimport->getPersonnelDetails();
		$output = json_encode($result);
		echo $output;
		break;	
	case 'getSampleDetails':
		$result = $airimport->getSampleDetails();
		$output = json_encode($result);
		echo $output;
		break;
	case 'getSurveyDetails':
		$result = $airimport->getSurveyDetails();
		$output = json_encode($result);
		echo $output;
		break;
	case 'getOtherDetails':
		$result = $airimport->getOtherDetails();
		$output = json_encode($result);
		echo $output;
		break;	
					
	case 'getImportAirDetails':
		$result = $airimport->getImportAirDetails();
		$output = json_encode($result);
		echo $output;
		break;		
}
?>