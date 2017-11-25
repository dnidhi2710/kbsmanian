<?php
$sample = array
('module' => 'airimport',
'action' => 'addotherdetails',
'impJobId' => '01/2017-18',  
'importerIctNo' => 'CCC1234', 
'importerIctRate' => '123456', 
'givenON' => '2017-07-06', 
'actualIctNo' => 'AA1234', 
'actualIctRate' => '123456', 
'dutyAmount' => '123456', 
'ReasonNotAdmitImpIct' => 'asdas sada',
'amount' => '123456', 
'leviedOn' => '2017-07-06', 
'paidOn' => '2017-07-06', 
'penaltyReason' => 'asda asdas',
'licenceSentOn' => '2017-07-06', 
'licenceSentTime' => '09:00', 
'toAuditOn' => '2017-07-06', 
'auditedOn' => '2017-07-06',
'auditedTime' => '09:00',
'auditRecdBackOn' => '2017-07-06',
'auditRecdBackTime' => '09:00',
'dsptdFrBEOn' => '2017-07-06',
'dsptdFrBETime' => '09:00',
'dsptdRecdBackOn' => '2017-07-06',
'dsptdRecdBackTime' => '09:00',
'dsptdRecdBackInitial' => 'AAAdfsdf1233',
'parcelHandedOn' => '2017-07-06',
'parcelHandedTime' => '09:00',
'parcelHandedInitial' => 'AAAdfsdf1233',
'detentionCrftNo' => 'SSS1234',
'detentionCrftDate' => '2017-07-06',
'detentionCrftFrom' => '2017-07-06',
'detentionCrftTo' => '2017-07-06');

echo json_encode($sample);


$json = {
	"module": "airimport",
	"action": "addimport",
	"impJobId": "01\/2017-18",
	"importedDate": "2017-07-06",
	"partyRef": "XXX",
	"consignee": "ABC Company",
	"address": "#2, Jaffer syrang lane, Chennai-1",
	"hsOrBtAccParty": "YYY",
	"contents" : 
	{
		"contrNos": "1234",
		"noOfPkgs": "10",
		"content": "asdasf afasf",
		"measurements": "asdasd",
		"grossWeight": "100",
		"nettWeight": "120"
	},
	{
		"contrNos": "1234",
		"noOfPkgs": "10",
		"content": "asdasf afasf",
		"measurements": "asdasd",
		"grossWeight": "100",
		"nettWeight": "120"
	}
	"supplier": "Supplier1",
	"invoiceNo": "SP123489",
	"invoiceDate": "2017-07-06",
	"flightDtls": "JetAirways",
	"dueDate": "2017-07-06",
	"arrival": "2017-07-06 10:40",
	"gdd": "aaa",
	"lfd": "aaa",
	"advisedBy": "XXX",
	"advisedOn": "2017-07-06",
	"shed": "XXX",
	"warehouse": "XXX",
	"licenseNo": "LN123456",
	"value": "123456",
	"balance": "123456",
	"agents": "",
	"igmNo": "AAA1234",
	"licenseDate": "2017-07-06",
	"mawbNo": "BBB1234",
	"hawbNo": "CCC1234",
	"hawbDate": "2017-07-06",
	"doNo": "DDD1234",
	"doDate": "2017-07-06",
	"invoiceValue": "123456",
	"customsClerk": "",
	"dockClerk": "",
	"tinNo": "XX1234",
	"cstNo": "YY1234",
	"gstNo": "ZZ1234",
	"landingCharges": "123456",
	"bOrEValue": "123456",
	"stAgentsCharges": "asdasd asdasas",
	"remarks": "asfasf sdfsdgs"
}

echo json_decode($json);

?>