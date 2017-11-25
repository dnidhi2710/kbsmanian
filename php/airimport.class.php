<?php
include('db.php');
include('mapResultSet.php');
//global $db;
//$db = new Dbclass;
//echo $db->test();
class Airimport
{
	public function addImportDetails()
	{
		//echo "connected to class";
		global $request,$db;
		$db = new Dbclass;
		//echo $db->test();
		$insert = "INSERT INTO import_air (impJobId, importedDate, partyRef, consignee, address, hsOrBtAccParty, supplier, invoiceNo, invoiceDate, flightDtls, dueDate, arrival, gdd, lfd, advisedBy, advisedOn, shed, warehouse, licenseNo, value, balance, agents, igmNo, licenseDate, mawbNo, hawbNo, hawbDate, doNo, doDate, invoiceValue, customsClerk, dockClerk, tinNo, cstNo, gstNo, landingCharges, bOrEValue, stAgentsCharges, remarks) VALUES ('".$request['impJobId']."', '".$request['importedDate']."', '".$request['partyRef']."', '".$request['consignee']."', '".$request['address']."', '".$request['hsOrBtAccParty']."', '".$request['supplier']."', '".$request['invoiceNo']."', '".$request['invoiceDate']."', '".$request['flightDtls']."', '".$request['dueDate']."', '".$request['arrival']."', '".$request['gdd']."', '".$request['lfd']."', '".$request['advisedBy']."', '".$request['advisedOn']."', '".$request['shed']."', '".$request['warehouse']."', '".$request['licenseNo']."', '".$request['value']."', '".$request['balance']."', '".$request['agents']."', '".$request['igmNo']."', '".$request['licenseDate']."', '".$request['mawbNo']."', '".$request['hawbNo']."', '".$request['hawbDate']."', '".$request['doNo']."', '".$request['doDate']."', '".$request['invoiceValue']."', '".$request['customsClerk']."', '".$request['dockClerk']."', '".$request['tinNo']."', '".$request['cstNo']."', '".$request['gstNo']."', '".$request['landingCharges']."', '".$request['bOrEValue']."', '".$request['stAgentsCharges']."', '".$request['remarks']."')";
		//echo $insert;
		//	echo $db->query($insert);
		//$Docresult = mysql_query($query);
		//echo $db->query($insert);
		if($db->query($insert))
		{
			//echo "doc field inserted";
			$insert_con = "INSERT INTO import_map_contents (impJobId,type, contrNos, noOfPkgs, content, measurements, grossWeight, nettWeight) VALUES";
			foreach($request['contents'] as $con)
			{
				$insert_con .="('".$request['impJobId']."','".$con['type']."', '".$con['contrNos']."', '".$con['noOfPkgs']."', '".$con['content']."', '".$con['measurements']."', '".$con['grossWeight']."', '".$con['nettWeight']."'),";
			}
		
			$insert_con = rtrim($insert_con,',');
			//echo $insert_con;
			if($db->query($insert_con))
			{
				return array('result'=>true,'msg'=>'success');
			}
			else
			{
				return array('result'=>false,'msg'=>mysql_error());
			}
		}
		else
		{
			
			$error = $db->getError();
			//echo $error;
			return array('result'=>false,'msg'=>$error);
		}
	}
	public function addImportSeaDetails()
	{
		//echo "connected to class";
		global $request,$db;
		$db = new Dbclass;
		//echo $db->test();
		$insert = "INSERT INTO import_sea (impJobId, importedDate, partyRef, consignee, address, hsOrBtAccParty, supplier, invoiceNo, invoiceDate, motherVsl, mvDue, arrival, GLD, cntrOut, feederVsl, fvOn, CFS,agents, igmNo, licenseDate, lineNo, hblNo, hblDate, mbl, mblDate, invoiceValue,invoiceMode , customsClerk, dockClerk, tinNo, cstNo, gstNo,stAgentsCharges, remarks) VALUES ('".$request['impJobId']."', '".$request['importedDate']."', '".$request['partyRef']."', '".$request['consignee']."', '".$request['address']."', '".$request['hsOrBtAccParty']."', '".$request['supplier']."', '".$request['invoiceNo']."', '".$request['invoiceDate']."', '".$request['motherVsl']."', '".$request['mvdate']."', '".$request['arrival']."', '".$request['gld']."', '".$request['cntrOut']."', '".$request['feederVsl']."', '".$request['fvOn']."', '".$request['CFS']."', '".$request['agents']."', '".$request['igmNo']."', '".$request['licenseDate']."', '".$request['lineNo']."', '".$request['hblNo']."', '".$request['hblDate']."', '".$request['mbl']."', '".$request['mblDate']."', '".$request['invoiceValue']."','".$request['invoiceMode']."','".$request['customsClerk']."', '".$request['dockClerk']."', '".$request['tinNo']."', '".$request['cstNo']."', '".$request['gstNo']."', '".$request['stAgentsCharges']."', '".$request['remarks']."')";
		//echo $insert;
		//	echo $db->query($insert);
		//$Docresult = mysql_query($query);
		//echo $db->query($insert);
		//$db->openConn();
		if($db->query($insert))
		{
			//echo "doc field inserted";
			$insert_con = "INSERT INTO import_map_contents (impJobId,type, contrNos, noOfPkgs, content, measurements, grossWeight, nettWeight) VALUES";
			foreach($request['contents'] as $con)
			{
				$insert_con .="('".$request['impJobId']."','".$con['type']."', '".$con['contrNos']."', '".$con['noOfPkgs']."', '".$con['content']."', '".$con['measurements']."', '".$con['grossWeight']."', '".$con['nettWeight']."'),";
			}
		
			$insert_con = rtrim($insert_con,',');
			//echo $insert_con;
			if($db->query($insert_con))
			{
				return array('result'=>true,'msg'=>'success');
			}
			else
			{
				//$ConError = $db->query($insert_con);
				$error = $db->getError();
				return array('result'=>false,'msg'=>$error);
			}
		}
		else
		{   
			//$error = $db->query($insert);
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);
		}
	}
	public function updateImportSeaDetails(){
				//echo "connected to class";
		global $request,$db;
		$db = new Dbclass;
		//echo $db->test();
		$insert = "UPDATE import_sea SET importedDate= '".$request['importedDate']."',partyRef = '".$request['partyRef']."',consignee = '".$request['consignee']."',address= '".$request['address']."', hsOrBtAccParty='".$request['hsOrBtAccParty']."', supplier='".$request['supplier']."', invoiceNo='".$request['invoiceNo']."', invoiceDate='".$request['invoiceDate']."', motherVsl='".$request['motherVsl']."', mvDue='".$request['mvdate']."', arrival='".$request['arrival']."', GLD= '".$request['gld']."', cntrOut= '".$request['cntrOut']."', feederVsl='".$request['feederVsl']."' , fvOn= '".$request['fvOn']."', CFS='".$request['CFS']."',agents='".$request['agents']."', igmNo='".$request['igmNo']."', licenseDate= '".$request['licenseDate']."', lineNo='".$request['lineNo']."', hblNo='".$request['hblNo']."', hblDate='".$request['hblDate']."', mbl='".$request['mbl']."', mblDate='".$request['mblDate']."', invoiceValue='".$request['invoiceValue']."' ,invoiceMode='".$request['invoiceMode']."' , customsClerk='".$request['customsClerk']."', dockClerk='".$request['dockClerk']."', tinNo='".$request['tinNo']."', cstNo='".$request['cstNo']."', gstNo='".$request['gstNo']."',stAgentsCharges='".$request['stAgentsCharges']."', remarks='".$request['remarks']."',jobType='".$request['jobType']."' WHERE id = '".$request['id']."' ";

		if($db->query($insert))
		{
				$containerObj = $request['Container'];
				$update_content = "UPDATE import_map_contents SET contrNos = '".$containerObj['Contr']."',noOfPkgs = '".$containerObj['noOfPkgs']."',content = '".$containerObj['content']."',measurements = '".$containerObj['measurements']."',grossWeight = '".$containerObj['grossWeight']."',nettWeight = '".$containerObj['nettWeight']."' WHERE impJobId = '".$request['id']."' AND type = '".$request['type']."';";
				if($db->query($update_content))
				{
					return array('result'=>true,'msg'=>'success');
				}
				else
				{
					return array('result'=>false,'msg'=>mysql_error());
				}
			//echo "doc field inserted";
		}
		else
		{   
			//$error = $db->query($insert);
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);
		}
	}

	public function updateImportAirDetails(){
		global $request,$db;
		$db = new Dbclass;
		//echo $db->test();
		if($request['contents']!=null){
			$insert = "UPDATE import_air SET importedDate='".$request['importedDate']."',partyRef='".$request['partyRef']."',consignee='".$request['consignee']."',address='".$request['address']."',hsOrBtAccParty='".$request['hsOrBtAccParty']."',supplier='".$request['supplier']."',invoiceNo='".$request['invoiceNo']."',invoiceDate='".$request['invoiceDate']."',flightDtls='".$request['flightDtls']."',dueDate='".$request['dueDate']."',arrival='".$request['arrival']."',gdd='".$request['gdd']."',lfd='".$request['lfd']."',advisedBy='".$request['advisedBy']."',advisedOn='".$request['advisedOn']."',shed='".$request['shed']."', warehouse='".$request['warehouse']."',licenseNo='".$request['licenseNo']."',value='".$request['value']."',balance='".$request['balance']."',agents='".$request['agents']."',igmNo='".$request['igmNo']."',licenseDate='".$request['licenseDate']."',mawbNo='".$request['mawbNo']."',hawbNo='".$request['hawbNo']."',hawbDate='".$request['hawbDate']."',doNo='".$request['doNo']."',doDate='".$request['doDate']."',invoiceValue='".$request['invoiceValue']."',customsClerk='".$request['customsClerk']."', dockClerk='".$request['dockClerk']."', tinNo='".$request['tinNo']."', cstNo='".$request['cstNo']."', gstNo='".$request['gstNo']."',landingCharges='".$request['landingCharges']."',bOrEValue='".$request['bOrEValue']."',stAgentsCharges='".$request['stAgentsCharges']."', remarks='".$request['remarks']."' WHERE impJobId ='".$request['impJobId']."'; ";
			if($db->query($insert))
			{	
				//$contentFlag = null;
				foreach($request['contents'] as $con)
				{
				if(isset($con['id'])){
					if($con['deleteRecord']==true){
						// delete record
					}else{
						//update record
					}
				}else{
					// insert record
				}
				$execQuery ="('".$request['impJobId']."','".$con['type']."', '".$con['contrNos']."', '".$con['noOfPkgs']."', '".$con['content']."', '".$con['measurements']."', '".$con['grossWeight']."', '".$con['nettWeight']."'),";
					if($db->query($execQuery)){
							$contentFlag = true;
					}else{
							$contentFlag = false;
							break;
					}
				}
				if($contentFlag== true){
						return array('result'=>true,'msg'=>'success');
				}else{
						$error = $db->getError();
						return array('result'=>false,'msg'=>$error);
				}
			}
			else
			{ 
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);
			}
		}else{
			return array('result'=>false,'msg'=>'Content field cannot be empty.');
		}
	}

	public function getImportSeaDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_sea WHERE id = '".$request['id']."' ";
			if($db->getResults($select)){
					$docObj = $map->mapSeaDocFields($db->getResults($select));
				}else{
					$docObj = null;
				}	
		$content =  "SELECT * from import_map_contents WHERE impJobId = '".$request['id']."' and type = '".$request['type']."'  ";
				if($db->getResults($content)){
					$content = $map->mapContents($db->getResults($content));
				}else{
					$content = null;
				}
		if($docObj!= null || $content != null){
			return array('result'=>true,'data'=>$map->groupImportSeaDoc($docObj,$content));
		}else{
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);	
		}
	}

	public function getImportAirDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_air WHERE impJobId = '".$request['id']."' ";
		if($db->getResults($select)){
			$selectContent = "SELECT * from import_map_contents WHERE impJobId = '".$request['id']."' and type=  '".$request['type']."' ";
			if($db->getResults($selectContent)){
				$airDetailObj = $map->mapAirDocFields($db->getResults($select),$db->getResults($selectContent));
			}else{
				$airDetailObj = $map->mapAirDocFields($db->getResults($select),null);		
			}
			return array('result'=>true,'data'=>$airDetailObj);
		}else{
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);	
		}
	}

	public function addSampleAndOpenOrder()
	{
		global $db,$request;
		$db = new Dbclass;
		$insert = "INSERT INTO import_map_samples (impJobId,type, iOrAFilledOn, iOrAFiledNo, iOrAFiledDate, iOrAFiledAmount, iOrAComparedOn, samplesCalledOn, dockClerkInstrn, calledInitial, drawnOn, calledDelayReason, submittedToCustoms, bOrEReceivedOn, bOrEReceivedTime, bOrERecdInitial, origOpenOrderGIvenOn, origOpenOrderCmptdOn, origOpenOrderDelayReason, dupeOpenOrderGIvenOn, dupeOpenOrderCmptdOn, dupeOpenOrderDelayReason) VALUES ('".$request['impJobId']."', '".$request['type']."','".$request['iOrAFilledOn']."', '".$request['iOrAFiledNo']."', '".$request['iOrAFiledDate']."', '".$request['iOrAFiledAmount']."', '".$request['iOrAComparedOn']."', '".$request['samplesCalledOn']."', '".$request['dockClerkInstrn']."', '".$request['calledInitial']."', '".$request['drawnOn']."', '".$request['calledDelayReason']."', '".$request['submittedToCustoms']."', '".$request['bOrEReceivedOn']."', '".$request['bOrEReceivedTime']."', '".$request['bOrERecdInitial']."', '".$request['origOpenOrderGIvenOn']."', '".$request['origOpenOrderCmptdOn']."', '".$request['origOpenOrderDelayReason']."', '".$request['dupeOpenOrderGIvenOn']."', '".$request['dupeOpenOrderCmptdOn']."', '".$request['dupeOpenOrderDelayReason']."')";
				
		if($db->query($insert))
		{
			return array('result'=>true,'msg'=>'success');
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}	
	}
	
	public function addImportSurvey()
	{
		global $db,$request;
		$db = new Dbclass;
		$insert = "INSERT INTO 
				import_map_survey(impJobId,type, sOrAAppliedOn, sOrAGrantedOn, sOrAHeldOn, insAppliedOn, insGrantedOn, insHeldOn, pTAppliedOn, pTAGrantedOn, pTHeldOn, transIndentedOn, transIndentedTime, transSuppliedOn, transSuppliedTime, transDeleyReason)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['sOrAAppliedOn']."', '".$request['sOrAGrantedOn']."', '".$request['sOrAHeldOn']."', '".$request['insAppliedOn']."', '".$request['insGrantedOn']."', '".$request['insHeldOn']."', '".$request['pTAppliedOn']."', '".$request['pTAGrantedOn']."', '".$request['pTHeldOn']."', '".$request['transIndentedOn']."', '".$request['transIndentedTime']."', '".$request['transSuppliedOn']."', '".$request['transSuppliedTime']."', '".$request['transDeleyReason']."')";
				
		if($db->query($insert))
		{
			return array('result'=>true,'msg'=>'success');
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}	
	}
	
	public function addOtherImportDetails()
	{
		global $db,$request;
		$db = new Dbclass;
		$insert_ict = "INSERT INTO 
				import_map_ict(impJobId,type, importerIctNo, importerIctRate, givenON, actualIctNo, actualIctRate, dutyAmount, ReasonNotAdmitImpIct)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['importerIctNo']."', '".$request['importerIctRate']."', '".$request['givenON']."', '".$request['actualIctNo']."', '".$request['actualIctRate']."', '".$request['dutyAmount']."', '".$request['ReasonNotAdmitImpIct']."')";
				
		if($db->query($insert_ict))
		{
			$insert_penalty = "INSERT INTO 
				import_map_penalty(impJobId,type, amount, leviedOn, paidOn, penaltyReason)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['amount']."', '".$request['leviedOn']."', '".$request['paidOn']."', '".$request['penaltyReason']."')";
				
			if($db->query($insert_penalty))
			{
				$insert_licence = "INSERT INTO 
				import_map_licence(impJobId,type, licenceSentOn, licenceSentTime, toAuditOn, auditedOn, auditedTime, auditRecdBackOn, auditRecdBackTime, dsptdFrBEOn, dsptdFrBETime, dsptdRecdBackOn, dsptdRecdBackTime, dsptdRecdBackInitial, parcelHandedOn, parcelHandedTime, parcelHandedInitial, detentionCrftNo, detentionCrftDate, detentionCrftFrom, detentionCrftTo)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['licenceSentOn']."', '".$request['licenceSentTime']."', '".$request['toAuditOn']."', '".$request['auditedOn']."', '".$request['auditedTime']."', '".$request['auditRecdBackOn']."', '".$request['auditRecdBackTime']."', '".$request['dsptdFrBEOn']."', '".$request['dsptdFrBETime']."', '".$request['dsptdRecdBackOn']."', '".$request['dsptdRecdBackTime']."', '".$request['dsptdRecdBackInitial']."', '".$request['parcelHandedOn']."', '".$request['parcelHandedTime']."', '".$request['parcelHandedInitial']."', '".$request['detentionCrftNo']."', '".$request['detentionCrftDate']."', '".$request['detentionCrftFrom']."', '".$request['detentionCrftTo']."')";
				
				if($db->query($insert_licence))
				{
					return array('result'=>true,'msg'=>'success');
				}
				else
				{
					return array('result'=>false,'msg'=>mysql_error());
				}
			}
			else
			{
				return array('result'=>false,'msg'=>mysql_error());
			}
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}		
	}
	
	public function addClearanceDetails()
	{
		global $db,$request;
		$db = new Dbclass;
		$insert_ict = "INSERT INTO 
				import_map_clearance(impJobId,type, iceGateJobNo, bOrEDetail, gcNoteNo, transpoterGcNoteNo,CIFValues,landingCharges,BEValue,remarks)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['iceGateJobNo']."', '".$request['bOrEDetail']."', '".$request['gcNoteNo']."', '".$request['transpoterGcNoteNo']."','".$request['CIFValues']."', '".$request['landingCharges']."', '".$request['BEValue']."', '".$request['remarks']."')";
				
		if($db->query($insert_ict))
		{
			$insert_con = "INSERT INTO 
				import_map_clearance_particulars(impJobId,type, pkgs, clearanceDate, clearedOrDelivered)
				VALUES";
				
			foreach($request['particulars'] as $con)
			{
				$insert_con  .=  "('".$request['impJobId']."','".$request['type']."', '".$con['pkgs']."', '".$con['clearanceDate']."', '".$con['clearedOrDelivered']."'),";
			}
			$insert_con = rtrim($insert_con,',');
			if($db->query($insert_con))
			{
				return array('result'=>true,'msg'=>'success');
			}
			else
			{
				$error = $db->getError();
				return array('result'=>false,'msg'=>$error);
			}
		}
		else
		{
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);
		}
	}
	
	public function getClearanceDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_map_clearance WHERE impJobId = '".$request['id']."' ";
		if($db->getResults($select)){
			$selectContent = "SELECT * from import_map_clearance_particulars WHERE impJobId = '".$request['id']."' and type =  '".$request['type']."' ";
			if($db->getResults($selectContent)){
				$seaDetailObj = $map->mapClearanceFields($db->getResults($select),$db->getResults($selectContent));
			}else{
				$seaDetailObj = $map->mapClearanceFields($db->getResults($select),null);		
			}
			return array('result'=>true,"data"=>$seaDetailObj);
		}else{
			$error = $db->getError();
			if($error == null){
				$error = "Clearance detail is not available";
			}
			return array('result'=>false,'msg'=>$error);
		}
	}
	public function getSampleDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_map_samples WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($select)){
			$sampleObj = $map->mapSampleFields($db->getResults($select));		
			return array('result'=>true,"data"=>$sampleObj);
		}else{
			$error = $db->getError();
			if($error == null){
				$error = "Sample detail is not available";
			}
			return array('result'=>false,'msg'=>$error);
		}
	}

	public function getSurveyDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_map_survey WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($select)){
				$surveyObj = $map->mapSurveyFields($db->getResults($select));		
			return array('result'=>true,"data"=>$surveyObj);
		}else{
			$error = $db->getError();
			if($error == null){
				$error = "Survey detail is not available";
			}
			return array('result'=>false,'msg'=>$error);
		}
	}

	public function getOtherDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_map_ict WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($select)){
			$ictObj = $map->mapICTFields($db->getResults($select));
		}else{
			$ictObj = null;
		}
		$selectPerSample = "SELECT * FROM import_map_penalty WHERE impJobId ='".$request['id']."' and type =  '".$request['type']."' ";
				if($db->getResults($selectPerSample)){
					$penality = $map->mapPenalityFields($db->getResults($selectPerSample));
				}else{
					$penality = null;
				}
		$selectContent = "SELECT * from import_map_licence WHERE impJobId = '".$request['id']."' and type =  '".$request['type']."' ";
			if($db->getResults($selectContent)){
				$licenseObj = $map->mapLicenseFields($db->getResults($selectContent));
			}else{
				$licenseObj = null;		
			}
		if($ictObj!=null || $penality!=null || $licenseObj!=null ){
			return array('result'=>true,"data"=>$map->groupOthersObj($ictObj,$penality,$licenseObj));
		}else{
			$error = $db->getError();
			if($error == null){
				$error = "Detail is not available";
			}
			return array('result'=>false,'msg'=>$error);
		}	
	}

	public function getPersonnelDetails(){
		global $db,$request;
		$db = new Dbclass;
		$map = new mapResultSet;
		$select = "SELECT * from import_map_personnel WHERE impJobId = '".$request['id']."' AND type ='".$request['type']."' ";
		if($db->getResults($select)){
			$personnelObj = $map->mapPersonnelFields($db->getResults($select));
		}else{
			$personnelObj = null;
		}
		$selectPerSample = "SELECT * FROM import_map_personnel_sample WHERE impJobId ='".$request['id']."' and type =  '".$request['type']."' ";
				if($db->getResults($selectPerSample)){
					$personnelsample = $map->mapPerSampleFields($db->getResults($selectPerSample));
				}else{
					$personnelsample = null;
				}
		$selectContent = "SELECT * from import_map_be WHERE impJobId = '".$request['id']."' and type =  '".$request['type']."' ";
			if($db->getResults($selectContent)){
				$beObj = $map->mapBeFields($db->getResults($selectContent));
			}else{
				$beObj = null;		
			}
		if($personnelObj!=null || $personnelsample!=null || $beObj!=null ){
			return array('result'=>true,"data"=>$map->groupPersonnelObj($personnelObj,$personnelsample,$beObj));
		}else{
			$error = $db->getError();
			if($error == null){
				$error = "Personnel detail is not available";
			}
			return array('result'=>false,'msg'=>$error);
		}	
	}

	public function updateClearanceDetails(){
		global $request,$db;
		$db = new Dbclass;
		//echo $db->test();
		$insert = "UPDATE import_map_clearance SET iceGateJobNo = '".$request['iceGateJobNo']."', bOrEDetail = '".$request['bOrEDetail']."' ,gcNoteNo ='".$request['gcNoteNo']."', transpoterGcNoteNo='".$request['transpoterGcNoteNo']."',CIFValues='".$request['CIFValues']."',landingCharges='".$request['landingCharges']."',BEValue='".$request['BEValue']."',remarks='".$request['remarks']."' WHERE impJobId ='".$request['impJobId']."' AND type= '".$request['type']."'; ";
		if($db->query($insert))
		{
			//echo "doc field inserted";
			return array('result'=>true,'msg'=>'success');
		}
		else
		{   
			//$error = $db->query($insert);
			$error = $db->getError();
			return array('result'=>false,'msg'=>$error);
		}
	}

	public function updateSampleDetails()
	{
		global $db,$request;
		$db = new Dbclass;
		$update = "UPDATE import_map_samples SET iOrAFilledOn='".$request['iOrAFilledOn']."',iOrAFiledNo='".$request['iOrAFiledNo']."', iOrAFiledDate='".$request['iOrAFiledDate']."', iOrAFiledAmount='".$request['iOrAFiledAmount']."',iOrAComparedOn='".$request['iOrAComparedOn']."', samplesCalledOn='".$request['samplesCalledOn']."',dockClerkInstrn='".$request['dockClerkInstrn']."',calledInitial='".$request['calledInitial']."', drawnOn='".$request['drawnOn']."',calledDelayReason='".$request['calledDelayReason']."',submittedToCustoms='".$request['submittedToCustoms']."',bOrEReceivedOn='".$request['bOrEReceivedOn']."', bOrEReceivedTime='".$request['bOrEReceivedTime']."',bOrERecdInitial='".$request['bOrERecdInitial']."', origOpenOrderGIvenOn='".$request['origOpenOrderGIvenOn']."',origOpenOrderCmptdOn='".$request['origOpenOrderCmptdOn']."',origOpenOrderDelayReason='".$request['origOpenOrderDelayReason']."', dupeOpenOrderGIvenOn='".$request['dupeOpenOrderGIvenOn']."', dupeOpenOrderCmptdOn='".$request['dupeOpenOrderCmptdOn']."', dupeOpenOrderDelayReason='".$request['dupeOpenOrderDelayReason']."' WHERE impJobId='".$request['impJobId']."' AND type='".$request['type']."';";	
		if($db->query($update))
		{
			return array('result'=>true,'msg'=>'success');
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}	
	}

	public function updateSurveyDetails()
	{
		global $db,$request;
		$db = new Dbclass;
		$update = "UPDATE import_map_survey SET sOrAAppliedOn='".$request['sOrAAppliedOn']."', sOrAGrantedOn= '".$request['sOrAGrantedOn']."', sOrAHeldOn='".$request['sOrAHeldOn']."', insAppliedOn='".$request['insAppliedOn']."', insGrantedOn='".$request['insGrantedOn']."', insHeldOn='".$request['insHeldOn']."', pTAppliedOn='".$request['pTAppliedOn']."', pTAGrantedOn='".$request['pTAGrantedOn']."', pTHeldOn='".$request['pTHeldOn']."', transIndentedOn='".$request['transIndentedOn']."', transIndentedTime='".$request['transIndentedTime']."', transSuppliedOn='".$request['transSuppliedOn']."', transSuppliedTime='".$request['transSuppliedTime']."', transDeleyReason='".$request['transDeleyReason']."' WHERE impJobId ='".$request['impJobId']."' AND type ='".$request['type']."';";
	
		if($db->query($update))
		{
			return array('result'=>true,'msg'=>'success');
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}	
	}
	public function updatePersonnelDetails(){
		global $db,$request;
		$db = new Dbclass;
		$update = "UPDATE import_map_personnel SET customsClerk = '".$request['customsClerk']."', jobAllotedOn ='".$request['jobAllotedOn']."', documentsRecd='".$request['documentsRecd']."', documentsRecdDate='".$request['documentsRecdDate']."', documentdCalled='".$request['documentdCalled']."', documentdDate='".$request['documentdDate']."', rem='".$request['rem']."', received='".$request['received']."' WHERE impJobId = '".$request['impJobId']."' AND type = '".$request['type']."';";

		if($db->query($update))
		{
			$update_be = "UPDATE import_map_be SET bOrEFilledAppDeptOn = '".$request['bOrEFilledAppDeptOn']."', bOrEGroupNo = '".$request['bOrEGroupNo']."', bOrERetrnOn = '".$request['bOrERetrnOn']."', bOrEFor= '".$request['bOrEFor']."', bOrEPutupAppOn='".$request['bOrEPutupAppOn']."', bOrEPutupAppRetrnOn='".$request['bOrEPutupAppRetrnOn']."', bOrEPutupAppFor='".$request['bOrEPutupAppFor']."' WHERE impJobId = '".$request['impJobId']."' AND type = '".$request['type']."';";
			
			if($db->query($update_be))
			{
				$update_sam = "UPDATE import_map_personnel_sample SET dockClerkInstrnOn='".$request['dockClerkInstrnOn']."', drawnOn='".$request['drawnOn']."', reasonForDelay='".$request['reasonForDelay']."', orderSentToGroupOn='".$request['orderSentToGroupOn']."', testReportRecdOn='".$request['testReportRecdOn']."', samplesCollectedOn='".$request['samplesCollectedOn']."', givenTo='".$request['givenTo']."', givenOn='".$request['givenOn']."', givenTime='".$request['givenTime']."', testcustomsAssDelayFrom='".$request['testcustomsAssDelayFrom']."', testcustomsAssDelayTo='".$request['testcustomsAssDelayTo']."', reason='".$request['reason']."' WHERE impJobId = '".$request['impJobId']."' AND type = '".$request['type']."';";
				if($db->query($update_sam))
				{
					return array('result'=>true,'msg'=>'success');
				}
				else
				{
					return array('result'=>false,'msg'=>mysql_error());
				}
			}
			else
			{
				return array('result'=>false,'msg'=>mysql_error());
			}
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}
	}

	public function updateOtherDetails(){
		global $db,$request;
		$db = new Dbclass;
		$update_ict = "UPDATE import_map_ict SET importerIctNo='".$request['importerIctNo']."', importerIctRate='".$request['importerIctRate']."', givenON='".$request['givenON']."', actualIctNo='".$request['actualIctNo']."', actualIctRate='".$request['actualIctRate']."', dutyAmount='".$request['dutyAmount']."', ReasonNotAdmitImpIct='".$request['ReasonNotAdmitImpIct']."' WHERE impJobId= '".$request['impJobId']."' AND type='".$request['type']."';";			
		if($db->query($update_ict))
		{
			$update_penalty = "UPDATE import_map_penalty SET amount='".$request['amount']."', leviedOn='".$request['leviedOn']."', paidOn='".$request['paidOn']."', penaltyReason='".$request['penaltyReason']."' WHERE impJobId= '".$request['impJobId']."' AND type='".$request['type']."';";
			if($db->query($update_penalty))
			{
				$update_licence = "UPDATE import_map_licence SET licenceSentOn='".$request['licenceSentOn']."', licenceSentTime='".$request['licenceSentTime']."', toAuditOn='".$request['toAuditOn']."', auditedOn='".$request['auditedOn']."', auditedTime='".$request['auditedTime']."', auditRecdBackOn='".$request['auditRecdBackOn']."', auditRecdBackTime='".$request['auditRecdBackTime']."', dsptdFrBEOn='".$request['dsptdFrBEOn']."', dsptdFrBETime='".$request['dsptdFrBETime']."', dsptdRecdBackOn='".$request['dsptdRecdBackOn']."', dsptdRecdBackTime='".$request['dsptdRecdBackTime']."', dsptdRecdBackInitial='".$request['dsptdRecdBackInitial']."', parcelHandedOn='".$request['parcelHandedOn']."', parcelHandedTime='".$request['parcelHandedTime']."', parcelHandedInitial='".$request['parcelHandedInitial']."', detentionCrftNo='".$request['detentionCrftNo']."', detentionCrftDate='".$request['detentionCrftDate']."', detentionCrftFrom='".$request['detentionCrftFrom']."', detentionCrftTo='".$request['detentionCrftTo']."' WHERE impJobId= '".$request['impJobId']."' AND type='".$request['type']."';";	
				if($db->query($update_licence))
				{
					return array('result'=>true,'msg'=>'success');
				}
				else
				{
					return array('result'=>false,'msg'=>mysql_error());
				}
			}
			else
			{
				return array('result'=>false,'msg'=>mysql_error());
			}
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}	
	}
	
	public function addPersonnelDetails()
	{
		global $db,$request;
		$db = new Dbclass;
		$insert = "INSERT INTO 
				import_map_personnel(impJobId,type, customsClerk, jobAllotedOn, documentsRecd, documentsRecdDate, documentdCalled, documentdDate, rem, received)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['customsClerk']."', '".$request['jobAllotedOn']."', '".$request['documentsRecd']."', '".$request['documentsRecdDate']."', '".$request['documentdCalled']."', '".$request['documentdDate']."', '".$request['rem']."', '".$request['received']."')";
				
		if($db->query($insert))
		{
			$insert_be = "INSERT INTO 
				import_map_be(impJobId,type, bOrEFilledAppDeptOn, bOrEGroupNo, bOrERetrnOn, bOrEFor, bOrEPutupAppOn, bOrEPutupAppRetrnOn, bOrEPutupAppFor)
				VALUES
				('".$request['impJobId']."','".$request['type']."', '".$request['bOrEFilledAppDeptOn']."', '".$request['bOrEGroupNo']."', '".$request['bOrERetrnOn']."', '".$request['bOrEFor']."', '".$request['bOrEPutupAppOn']."', '".$request['bOrEPutupAppRetrnOn']."', '".$request['bOrEPutupAppFor']."')";
			if($db->query($insert_be))
			{
				$insert_sam = "INSERT INTO 
					import_map_personnel_sample(impJobId,type, dockClerkInstrnOn, drawnOn, reasonForDelay, orderSentToGroupOn, testReportRecdOn, samplesCollectedOn, givenTo, givenOn, givenTime, testcustomsAssDelayFrom, testcustomsAssDelayTo, reason)
					VALUES
					('".$request['impJobId']."','".$request['type']."', '".$request['dockClerkInstrnOn']."', '".$request['drawnOn']."', '".$request['reasonForDelay']."', '".$request['orderSentToGroupOn']."', '".$request['testReportRecdOn']."', '".$request['samplesCollectedOn']."', '".$request['givenTo']."', '".$request['givenOn']."', '".$request['givenTime']."', '".$request['testcustomsAssDelayFrom']."', '".$request['testcustomsAssDelayTo']."', '".$request['reason']."')";
				if($db->query($insert_sam))
				{
					return array('result'=>true,'msg'=>'success');
				}
				else
				{
					return array('result'=>false,'msg'=>mysql_error());
				}
			}
			else
			{
				return array('result'=>false,'msg'=>mysql_error());
			}
		}
		else
		{
			return array('result'=>false,'msg'=>mysql_error());
		}
	}
}
?>