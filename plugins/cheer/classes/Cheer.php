<?php
include(_DIRPATH_.'cheer/config/settings.php');
require_once(_DIRPATHLIB_.'/DBplugin.php');
include(_DIRPATH_.'cheer/classes/class-excel-xml.inc.php');
class Cheer extends HTML{
    var $month;
    function Cheer() {
	$this->dbConnect= new DBplugin(DBHOST, DBUSER, DBPASS, DBNAME);
	$this->xls = new Excel_XML();
    }
    
    public function NewPatients() {
	return $this->_newPatients();
    }
    public function ExistingPatients() {
	return $this->_existingPatients();
    }
    public function download() {
	return $this->_download();
    }
    
    public function CheerData($data) {
	return $this->_chearDataView($data);
    }
    public function enrollmentHistory($monthfrom, $monthto){
	return $this->_enrollmentHistory($monthfrom, $monthto);
    }
    public function serviceTracker($monthfrom, $monthto){
	return $this->_serviceTracker($monthfrom, $monthto);
    }
     public function sboServiceTracker($monthfrom, $monthto, $data){
	 return $this->_sboServiceTracker($monthfrom, $monthto, $data);
     }
    public function EmpData($empcode, $data){
	return $this->_empData($empcode, $data);
    }
    public function BillDataContacted($data){
	return $this->_billDataContacted($data);
    }
    public function BillDataTotalActiveUsers($data){
	return $this->_billDataTotalActiveUsers($data);
    }
    public function BillDataDeclined($data){
	return $this->_billDataDeclined($data);
    }
    public function GetManager(){
	return $this->_getmanager();
    }
    
    public function getManagerName($id){
	return $this->_getmanagerName($id);
    }
    public function sboEnrollmentHistory($data){
	return $this->_sboEnrollmentHistory($data);
    }
    
     public function sbo($data){
	return $this->_sbo($data);
    }
    public function sboEnrollmentHistoryDownload($data){
	return $this->_sboEnrollmentHistoryDownload($data);
    }
     
    public function enrollmentHistoryDownload($request){
	return $this->_enrollmentHistoryDownload($request);
    }
    
    public function serviceTrackerDownload($request){
	return $this->_serviceTrackerDownload($request);
    }
    public function billingDownload($request){
	return $this->_billingDownload($request);
    }
    
    public function cheerDownload($request){
	return $this->_cheerDownload($request);
    }
    public function sboserviceTrackerDownload($request){
	return $this->_sboserviceTrackerDownload($request);
    }
    
     public function getSboListName($id) {
	return $this->_getSboListName($id);
    }
    public function getSboList($id) {
	return $this->_getSboList($id);
    }
    
    public function getSboListAll($id) {
	return $this->_getSboListAll($id);
    }
    
    private function _getmanagerName($id){
	return $this->dbConnect->ExecuteSQL("SELECT * FROM `emp_master` WHERE  id='".$id."'");
    }

   private function _chearDataView($request){
	$data = "";
	$month ="";
	$day="";
	$year="";
	if(isset($request['eformmonth']) && !empty($request['eformmonth'])) { 
	    list($year, $months) = explode('-', $request['eformmonth']);
	    $month = $months;
	    $year = $year;
	} else {
	    $month = date('m');
	    $year = date('Y');
	}
	$w=0;
	$dataSbo = $this->_chearData($request);
	$weeks = $this->_getWeekDate($month, $year);
	for($i=0;$i<count($dataSbo); $i++){
	    $data[$w] = array($dataSbo[$i]['name']."-". $dataSbo[$i]['emp_code']);
	    foreach($weeks as $week){
		$empData = $this->_empData($dataSbo[$i]['emp_code'], $week);
		$data[$w][] = $empData['Total'];
	    }
	    $w++;
	 } 
	
	for($m=0;$m<count($data); $m++){
	    $week1 += $data[$m][1];
	    $week2 += $data[$m][2];
	    $week3 += $data[$m][3];
	    $week4 += $data[$m][4];
	    $week5 += $data[$m][5];
	    
	    
	}
	$data[$w][]="Total";
	$data[$w][]=$week1;
	$data[$w][]=$week2;
	$data[$w][]=$week3;
	$data[$w][]=$week4;
	$data[$w][]=$week5;
	return $data;
     }
    
     private function _cheerDownload($request){
	$data = "";
	$header= array("SBO Name", 
			"Week 1", 
			"Week 2", 
			"Week 3",
			"Week 4",
			"Week 5",
			);
	
	$month ="";
	$day="";
	$year="";
	if(isset($request['eformmonth']) && !empty($request['eformmonth'])) { 
	    list($year, $months) = explode('-', $request['eformmonth']);
	    $month = $months;
	    $year = $year;
	} else {
	    $month = date('m');
	    $year = date('Y');
	}
	
	$data[1]=$header;
	$w=0;
	$dataSbo = $this->_chearData($request);
	$weeks = $this->_getWeekDate($month, $year);
	for($i=0;$i<count($dataSbo); $i++){
	    $data[$w] = array($dataSbo[$i]['name']."-". $dataSbo[$i]['emp_code']);
	    foreach($weeks as $week){
		$empData = $this->_empData($dataSbo[$i]['emp_code'], $week);
		$data[$w][] = $empData['Total'];
	    }
	    $w++;
	 } 
	
	for($m=0;$m<count($data); $m++){
	    $week1 += $data[$m][1];
	    $week2 += $data[$m][2];
	    $week3 += $data[$m][3];
	    $week4 += $data[$m][4];
	    $week5 += $data[$m][5];
	    
	    
	}
	$data[$w][]="Total";
	$data[$w][]=$week1;
	$data[$w][]=$week2;
	$data[$w][]=$week3;
	$data[$w][]=$week4;
	$data[$w][]=$week5;
	$filename = "cheer";
	$this->_genrateXls($data,$filename);
	exit;
     }
    
    private function _billingDownload($request){
	$data = "";
	$header= array("Month", 
			"Activated", 
			"Total active users", 
			"Declined");
	 
	$enrollmentHistoryData = $this->_billDataContacted($request['monthform'], $request['monthto']);
	$data[1]=$header;
	$filename = "Billing";
	$w=2;
	foreach($enrollmentHistoryData as $key=>$enrollmentHistory){  
	   $xlsData ="";
	    $data[$w][] = $key;
	    foreach($enrollmentHistory as $value){
		 $data[$w][] = $value['Total'];
	    }
	   $w++;
	} 
	$this->_genrateXls($data,$filename);
	exit;
	
    }
    
    private function _sboserviceTrackerDownload($request){
	$data = "";
	$header= array("Month", 
			"No. of Active Patients", 
			"Existing Patient Status", 
			"",
			"",
			"",
			 "New Patient Status", 
			 "","",""
			);
	 $header2= array("", "", 
			"HTS Subscribed", 
			 "RR Subscribed",
			 "HTS Sent",
			 "RR Sent",
			 "HTS Subscribed", 
			 "RR Subscribed",
			 "HTS Sent",
			 "RR Sent"
			);
	$enrollmentHistoryData = $this->_sboServiceTracker($request['eformmonth'], $request['etomonth'], $request);
	$data[1]=$header;
	$data[2]=$header2;
	$filename = "SboServiceTracker";
	$w=3;
	foreach($enrollmentHistoryData as $key=>$enrollmentHistory){  
	   $xlsData ="";
	    $data[$w][] = $key;
	    foreach($enrollmentHistory as $value){
		 $data[$w][] = $value['Total'];
	    }
	   $w++;
	} 
	$this->_genrateXls($data,$filename);
	exit;
    }
     private function _serviceTrackerDownload($request){
	$data = "";
	$header= array("Month", 
			"No. of Active Patients", 
			"Existing Patient Status", 
			"",
			"",
			"",
			 "New Patient Status", 
			 "","",""
			);
	 $header2= array("", "", 
			"HTS Subscribed", 
			 "RR Subscribed",
			 "HTS Sent",
			 "RR Sent",
			 "HTS Subscribed", 
			 "RR Subscribed",
			 "HTS Sent",
			 "RR Sent"
			);
	$enrollmentHistoryData = $this->_serviceTracker($request['monthform'], $request['monthto']);
	$data[1]=$header;
	$data[2]=$header2;
	$filename = "ServiceTracker";
	$w=3;
	foreach($enrollmentHistoryData as $key=>$enrollmentHistory){  
	   $xlsData ="";
	    $data[$w][] = $key;
	    foreach($enrollmentHistory as $value){
		 $data[$w][] = $value['Total'];
	    }
	   $w++;
	} 
	$this->_genrateXls($data,$filename);
	exit;
	
    }
    private function _enrollmentHistoryDownload($request){
	$data = "";
	$header= array("Month", 
			"Existing Patient Status", 
			"", 
			 "",
			 "New Patient Status", 
			 "",""
			);
	 $header2= array("", "Patients Contacted", 
			"Active Patients", 
			 "Dropped Patients",
			  "Patients Contacted",
			 "Active Patients",
			 "Inactive Patients"
			);
	$enrollmentHistoryData = $this->_enrollmentHistory($request['monthform'], $request['monthto']);
	$data[1]=$header;
	$data[2]=$header2;
	$filename = "EnrollmentHistory";
	$w=3;
	foreach($enrollmentHistoryData as $key=>$enrollmentHistory){  
	   $xlsData ="";
	    $data[$w][] = $key;
	    foreach($enrollmentHistory as $value){
		 $data[$w][] = $value['Total'];
	    }
	   $w++;
	} 
	$this->_genrateXls($data,$filename);
	exit;
	
    }
    
    private function _sboEnrollmentHistoryDownload($id){
	$data = "";
	$header= array("SBO Name", 
			"SBO Region", 
			"Existing Patient Status", 
			 "","","",
			 "New Patient Status", 
			 "","",""
			);
	 $header2= array("", "", 
			"Patients Contacted", 
			 "Active Patients",
			  "Dropped Patients",
			 "On-hold patients",
			 "Patients Contacted", 
			 "Active Patients","Declined this Services",
			 "Yet to be contacted"
			);
	$value = array("manager"=>$id['id'], "eformmonth"=>$id['eformmonth'], "etomonth"=>$id['etomonth']);
	
	$sboData = $this->_sboEnrollmentHistory($value);
	$data[1]=$header;
	$data[2]=$header2;
	$filename = "sboEnrollmentHistory";
	$w=3;
	foreach($sboData as $key=>$enrollmentHistory){  
	   $xlsData ="";
	    $data[$w][] = $key;
	    foreach($enrollmentHistory as $value){
		 $data[$w][] = $value['Total'];
	    }
	   $w++;
	} 
	
	$this->_genrateXls($data,$filename);
	exit;
    }

    private function _sbo($data) {

	
	$sboLists = $this->_getSboListName($data);
	$month = date('m');
	$year = date('Y');
	$weeks = $this->_getWeekDate($month, $year);
	foreach($weeks as $week){
	    $sboPatientContacted = $this->_sboSboPatientContacted($sboLists['emp_code'], $week);
	    $sboPatientActive	 = $this->_sbosboPatientActive($sboLists['emp_code'], $week);
	    $sboPatientDropped	 = $this->_sbosboPatientDropped($sboLists['emp_code'], $week);
	    $sboPatientOnHold	 = $this->_sbosboPatientOnHold($sboLists['emp_code'], $week);	    
	    $contactedPatients['Patients Contacted'][] = $sboPatientContacted;
	    $contactedPatients['Active Patients'][] = $sboPatientActive;
	    $contactedPatients['Inactive Patients'][] = $sboPatientDropped;
	    $contactedPatients['Yet to be contacted'][] = $sboPatientOnHold;
	    
	    $total= $sboPatientContacted['Total'] + $sboPatientActive['Total'] +$sboPatientDropped['Total'] + $sboPatientOnHold['Total'];
	    $contactedPatients['Total'][] = array("Total"=>$total);
	    
	}
	return $contactedPatients;
	
    }
    
    private function _sboEnrollmentHistory($data) {
	if($data['eformmonth']){
	    list($fYear, $fMonth) = explode("-", $data['eformmonth']);
	} else {
	    $fYear = date('Y');
	    $fMonth = date('m');
	}
	if($data['etomonth']){
	    list($tYear, $tMonth) = explode("-", $data['etomonth']);
	} else {
	    $tYear = date('Y');
	    $tMonth = date('m');
	}
	$days = cal_days_in_month(CAL_GREGORIAN, $tMonth, $tYear);
	$tMonth = sprintf("%02s", $tMonth);
	$fMonth = sprintf("%02s", $fMonth);
	$endDate = $tYear."-".$tMonth."-".$days;
	$startDate = $fYear."-".$fMonth."-01";
	
	
	$sboLists = $this->_getSboListData($data['manager']);
	foreach($sboLists as $sbo){
	    $sboPatientContacted = $this->_sboPatientContacted($sbo['emp_code'], $startDate, $endDate);
	    $sboPatientActive	 = $this->_sboPatientActive($sbo['emp_code'], $startDate, $endDate);
	    $sboPatientDropped	 = $this->_sboPatientDropped($sbo['emp_code'], $startDate, $endDate);
	    $sboPatientOnHold	 = $this->_sboPatientOnHold($sbo['emp_code'], $startDate, $endDate);
	    
	    
	    $currentSboPatientContacted	 = $this->_sboPatientContacted($sbo['emp_code'], $startDate, $endDate);
	    $currentSboPatientActive	 = $this->_sboPatientActive($sbo['emp_code'], $startDate, $endDate);
	    $currentSboPatientDropped	 = $this->_sboPatientDropped($sbo['emp_code'], $startDate, $endDate);
	    $currentSboPatientOnHold	 = $this->_sboPatientOnHold($sbo['emp_code'], $startDate, $endDate);
	    
	    $sboPatientContactedTotal	+= $sboPatientContacted['Total'];
	    $sboPatientActiveTotal	+= $sboPatientActive['Total'];
	    $sboPatientDroppedTotal	+= $sboPatientDropped['Total'];
	    $sboPatientOnHoldTotal	+= $sboPatientOnHold['Total'];
	    
	    $currentSboPatientContactedTotal	+= $currentSboPatientContacted['Total'];
	    $currentSboPatientActiveTotal	+= $currentSboPatientActive['Total'];
	    $currentSboPatientDroppedTotal	+= $currentSboPatientDropped['Total'];
	    $currentSboPatientOnHoldTotal	+= $currentSboPatientOnHold['Total'];
	    
	    $contactedPatients[$sbo['name']][] = array("Total"=>$sbo['manager_area']);
	    $contactedPatients[$sbo['name']][] = $sboPatientContacted;
	    $contactedPatients[$sbo['name']][] = $sboPatientActive;
	    $contactedPatients[$sbo['name']][] = $sboPatientDropped;
	    $contactedPatients[$sbo['name']][] = $sboPatientOnHold;
	    
	    $contactedPatients[$sbo['name']][] = $currentSboPatientContacted;
	    $contactedPatients[$sbo['name']][] = $currentSboPatientActive;
	    $contactedPatients[$sbo['name']][] = $currentSboPatientDropped;
	    $contactedPatients[$sbo['name']][] = $currentSboPatientOnHold;
	    
	}
	if(count($sboPatientContactedTotal)>0){
	    $contactedPatients['Total']=array(array('Total'=>" "), 
				    array('Total'=>$sboPatientContactedTotal), 
				    array('Total'=>$sboPatientActiveTotal),
				    array('Total'=>$sboPatientDroppedTotal),
				    array('Total'=>$sboPatientOnHoldTotal),
				    array('Total'=>$currentSboPatientContactedTotal), 
				    array('Total'=>$currentSboPatientActiveTotal),
				    array('Total'=>$currentSboPatientDroppedTotal),
				    array('Total'=>$currentSboPatientOnHoldTotal));
	}
	return $contactedPatients;
	
    }
    
    private function _sboPatientOnHold($data, $startDate, $endDate) {
	
	 return $this->dbConnect->ExecuteSQL("SELECT count(*) as Total 
					      FROM `patient_details` AS PD 
					      INNER JOIN psc_subscription_request as PSU 
					      ON PSU.id=PD.`subscription_request_id` 
					      WHERE PD.emp_code='".$data."' AND PSU.`process_status`=4
					      AND PSU.created BETWEEN '".$startDate."' AND '".$endDate."'");
    }
    
    private function _sbosboPatientOnHold($data, $week) {
	
	 return $this->dbConnect->ExecuteSQL("SELECT count(*) as Total 
					      FROM `patient_details` AS PD 
					      INNER JOIN psc_subscription_request as PSU 
					      ON PSU.id=PD.`subscription_request_id` 
					      WHERE PD.emp_code='".$data."' AND PSU.`process_status`=4 
					      AND PSU.created BETWEEN '".$week['ssdate']."' AND '".$week['eedate']."'");
    }
    
    private function _sboPatientContacted($data, $startDate, $endDate) {
	 return $this->dbConnect->ExecuteSQL("SELECT count(*) as Total FROM `patient_details` where emp_code='".$data."' 
					    AND created BETWEEN '".$startDate."' AND '".$endDate."'");
    }
    
     private function _sboSboPatientContacted($data, $week) {
	 return $this->dbConnect->ExecuteSQL("SELECT count(*) as Total FROM `patient_details` WHERE  emp_code='".$data."' 
					    AND created BETWEEN '".$week['ssdate']."' AND '".$week['eedate']."'");
    }

     private function _sbosboPatientActive($data, $week){
	$slctProgServsId = $this->dbConnect->ExecuteSQL("SELECT service_id FROM psc_program_services WHERE program_id = '7'");
	$sboServ=array();
	foreach($slctProgServsId as $sboServices){
		array_push($sboServ,$sboServices['service_id']);
	}
	$sboServ_id = implode(",",$sboServ);
	$allPatientList = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total
					FROM `patient_details` AS pd 
					LEFT JOIN psc_user_details AS PUD ON pd.pateint_mobile=PUD.phone_number 
					LEFT JOIN `psc_subscription_request` AS PSR ON pd.subscription_request_id=PSR.id 
					LEFT JOIN `psc_drl_user_attribute` AS DUA ON DUA.user_detail_id=PUD.id 
					LEFT JOIN `psc_states` AS PS ON PS.id=DUA.state 
					LEFT JOIN psc_service_user AS PSU ON PSU.user_details_id=PUD.id 
					AND service_type_id IN (".$sboServ_id.") 
					WHERE pd.emp_code =  '".$data."' 
					AND PSR.programme_id='7' 
					AND DUA.current_med_flag='1' AND DUA.created BETWEEN '".$week['ssdate']."' AND '".$week['eedate']."'");
	return $allPatientList;
	
    }
    
    private function _sboPatientActive($data, $startDate, $endDate){
	$slctProgServsId = $this->dbConnect->ExecuteSQL("SELECT service_id FROM psc_program_services WHERE program_id = '7'");
	$sboServ=array();
	foreach($slctProgServsId as $sboServices){
		array_push($sboServ,$sboServices['service_id']);
	}
	$sboServ_id = implode(",",$sboServ);
	$allPatientList = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total
					FROM `patient_details` AS pd 
					LEFT JOIN psc_user_details AS PUD ON pd.pateint_mobile=PUD.phone_number 
					LEFT JOIN `psc_subscription_request` AS PSR ON pd.subscription_request_id=PSR.id 
					LEFT JOIN `psc_drl_user_attribute` AS DUA ON DUA.user_detail_id=PUD.id 
					LEFT JOIN `psc_states` AS PS ON PS.id=DUA.state 
					LEFT JOIN psc_service_user AS PSU ON PSU.user_details_id=PUD.id 
					AND service_type_id IN (".$sboServ_id.") 
					WHERE pd.emp_code =  '".$data."' 
					AND PSR.programme_id='7' 
					AND DUA.current_med_flag='1'
					AND DUA.created BETWEEN '".$startDate."' AND '".$endDate."'");
	return $allPatientList;
	
    }

    private function _sboPatientDropped($data, $startDate, $endDate){
	$slctProgServsId = $this->dbConnect->ExecuteSQL("SELECT service_id FROM psc_program_services WHERE program_id = '7'");
	$sboServ=array();
	foreach($slctProgServsId as $sboServices){
		array_push($sboServ,$sboServices['service_id']);
	}
	$sboServ_id = implode(",",$sboServ);

	$allPatientList = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total
					FROM `patient_details` AS pd 
					LEFT JOIN psc_user_details AS PUD ON pd.pateint_mobile=PUD.phone_number 
					LEFT JOIN `psc_subscription_request` AS PSR ON pd.subscription_request_id=PSR.id 
					LEFT JOIN `psc_drl_user_attribute` AS DUA ON DUA.user_detail_id=PUD.id 
					LEFT JOIN `psc_states` AS PS ON PS.id=DUA.state 
					LEFT JOIN psc_service_user AS PSU ON PSU.user_details_id=PUD.id 
					AND service_type_id IN (".$sboServ_id.") 
					WHERE pd.emp_code =  '".$data."' 
					AND PSR.programme_id='7' 
					AND DUA.current_med_flag='0'
					AND DUA.created BETWEEN '".$startDate."' AND '".$endDate."'");
	return $allPatientList;
	
    }
    
    private function _sbosboPatientDropped($data, $week){
	$slctProgServsId = $this->dbConnect->ExecuteSQL("SELECT service_id FROM psc_program_services WHERE program_id = '7'");
	$sboServ=array();
	foreach($slctProgServsId as $sboServices){
		array_push($sboServ,$sboServices['service_id']);
	}
	$sboServ_id = implode(",",$sboServ);

	$allPatientList = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total
					FROM `patient_details` AS pd 
					LEFT JOIN psc_user_details AS PUD ON pd.pateint_mobile=PUD.phone_number 
					LEFT JOIN `psc_subscription_request` AS PSR ON pd.subscription_request_id=PSR.id 
					LEFT JOIN `psc_drl_user_attribute` AS DUA ON DUA.user_detail_id=PUD.id 
					LEFT JOIN `psc_states` AS PS ON PS.id=DUA.state 
					LEFT JOIN psc_service_user AS PSU ON PSU.user_details_id=PUD.id 
					AND service_type_id IN (".$sboServ_id.") 
					WHERE pd.emp_code =  '".$data."' 
					AND PSR.programme_id='7' 
					AND DUA.current_med_flag='0' AND 
					DUA.modified BETWEEN '".$week['ssdate']."' AND '".$week['eedate']."'");
	return $allPatientList;
	
    }
    
    private function _sboServiceTracker($monthfrom, $monthto, $data){
	if($monthfrom){
	    list($fYear, $fMonth) = explode("-", $monthfrom);
	} else {
	    $fYear = date('Y');
	    $fMonth = date('m');
	}
	if($monthto){
	    list($tYear, $tMonth) = explode("-", $monthto);
	} else {
	    $tYear = date('Y');
	    $tMonth = date('m');
	}
	$days = cal_days_in_month(CAL_GREGORIAN, $tMonth, $tYear);
	$tMonth = sprintf("%02s", $tMonth);
	$fMonth = sprintf("%02s", $fMonth);
	$endDate = $tYear."-".$tMonth."-".$days;
	$startDate = $fYear."-".$fMonth."-01";
	$monthes = $this->_getMonthDates($startDate, $endDate);
	 if($data['sbo']){
	    $sboList= $this->getSboListName($data['sbo']);
	 }
	foreach($monthes as $month){
	   $monthName		= date('F',  strtotime($month['start']));  
	   $HTSubscribed	= $this->_getSboHTSubscribed($month['start'],  $month['end'], $sboList['emp_code']);
	   $callBackActive	= $this->_getSboCallBackActive($month['start'],  $month['end'], $sboList['emp_code']);
	   $RRSubscribed	= $this->_getsSboRRSubscribed($month['start'],  $month['end'], $sboList['emp_code']);
	   $HTSent		= $this->_getSboHTSent($month['start'],  $month['end'], $sboList['emp_code']);
	   $RRSent		=   $this->_getSboRRSent($month['start'],  $month['end'], $sboList['emp_code']);
	   $currentMonthInActive  = $this->_getSboCurrentMonthInActive($month['start'],  $month['end'], $sboList['emp_code']);
	   $callBackActiveTotal += $callBackActive['Total'];
	   $HTSubscribedTotal	   += $HTSubscribed['Total'];
	   $RRSubscribedTotal  += $RRSubscribed['Total'];
	   
	   $HTSentTotal += $HTSent['Total'];
	   $RRSentTotal    += $RRSent['Total'];
	   $currentMonthInActiveTotal  += $currentMonthInActive['Total'];
	   $contactedPatients[$monthName][] = $callBackActive;
	   $contactedPatients[$monthName][] = $HTSubscribed;
	   $contactedPatients[$monthName][] = $RRSubscribed;
	   $contactedPatients[$monthName][] = $HTSent;
	   $contactedPatients[$monthName][] = $RRSent;
	   $contactedPatients[$monthName][] =  $HTSubscribed;
	   $contactedPatients[$monthName][] = $RRSubscribed;
	   $contactedPatients[$monthName][] = $HTSent;
	   $contactedPatients[$monthName][] = $RRSent;
	   $w++;
	}
	
	$contactedPatients['Total']=array(array('Total'=>$callBackActiveTotal), 
				    array('Total'=>$HTSubscribedTotal), 
				    array('Total'=>$RRSubscribedTotal),
				    array('Total'=>$HTSentTotal),
				    array('Total'=>$RRSentTotal),
				    array('Total'=>$HTSubscribedTotal), 
				    array('Total'=>$RRSubscribedTotal),
				    array('Total'=>$HTSentTotal),
				    array('Total'=>$RRSentTotal));
	return $contactedPatients;
    }
    
   private function _serviceTracker($monthfrom, $monthto){
	if($monthfrom){
	    list($fYear, $fMonth) = explode("-", $monthfrom);
	} else {
	    $fYear = date('Y');
	    $fMonth = date('m');
	}
	if($monthto){
	    list($tYear, $tMonth) = explode("-", $monthto);
	} else {
	    $tYear = date('Y');
	    $tMonth = date('m');
	}
	$days = cal_days_in_month(CAL_GREGORIAN, $tMonth, $tYear);
	$tMonth = sprintf("%02s", $tMonth);
	$fMonth = sprintf("%02s", $fMonth);
	$endDate = $tYear."-".$tMonth."-".$days;
	$startDate = $fYear."-".$fMonth."-01";
	
	$monthes = $this->_getMonthDates($startDate, $endDate);
	foreach($monthes as $month){
	   $monthName =date('F',  strtotime($month['start'])); 
	   $HTSubscribed	= $this->_getHTSubscribed($month['start'], $month['end']);
	   $callBackActive	= $this->_getCallBackActive($month['start'], $month['end']);
	   $RRSubscribed	= $this->_getRRSubscribed($month['start'], $month['end']);
	   $HTSent = $this->_getHTSent($month['start'], $month['end']);
	   $RRSent	  =   $this->_getRRSent($month['start'], $month['end']);
	   $currentMonthInActive  = $this->_getCurrentMonthInActive($month['start'], $month['end']);
	   $callBackContactedTotal += $callBackActive['Total'];
	   $callBackActiveTotal	   += $HTSubscribed['Total'];
	   $callBackInActiveTotal  += $RRSubscribed['Total'];
	   
	   $currentMonthContactedTotal += $HTSent['Total'];
	   $currentMonthActiveTotal    += $RRSent['Total'];
	   $currentMonthInActiveTotal  += $currentMonthInActive['Total'];
	   $contactedPatients[$monthName][] = $callBackActive;
	   $contactedPatients[$monthName][] = $HTSubscribed;
	   $contactedPatients[$monthName][] = $RRSubscribed;
	   $contactedPatients[$monthName][] = $HTSent;
	   $contactedPatients[$monthName][] = $RRSent;
	   $contactedPatients[$monthName][] =  $HTSubscribed;
	   $contactedPatients[$monthName][] = $RRSubscribed;
	   $contactedPatients[$monthName][] = $HTSent;
	   $contactedPatients[$monthName][] = $RRSent;
	   $w++;
	}
	
	$contactedPatients['Total']=array(array('Total'=>$callBackContactedTotal), 
				    array('Total'=>$callBackActiveTotal), 
				    array('Total'=>$callBackInActiveTotal),
				    array('Total'=>$currentMonthContactedTotal),
				    array('Total'=>$currentMonthActiveTotal),
				    array('Total'=>$currentMonthInActiveTotal), 
				    array('Total'=>$callBackInActiveTotal),
				    array('Total'=>$currentMonthContactedTotal),
				    array('Total'=>$currentMonthActiveTotal));
	return $contactedPatients;
    }
    
    private function _enrollmentHistory($monthfrom, $monthto){
	if($monthfrom){
	    list($fYear, $fMonth) = explode("-", $monthfrom);
	} else {
	    $fYear = date('Y');
	    $fMonth = date('m');
	}
	if($monthto){
	    list($tYear, $tMonth) = explode("-", $monthto);
	} else {
	    $tYear = date('Y');
	    $tMonth = date('m');
	}
	$days = cal_days_in_month(CAL_GREGORIAN, $tMonth, $tYear);
	$tMonth = sprintf("%02s", $tMonth);
	$fMonth = sprintf("%02s", $fMonth);
	$endDate = $tYear."-".$tMonth."-".$days;
	$startDate = $fYear."-".$fMonth."-01";
	
	$monthes = $this->_getMonthDates($startDate, $endDate);
	$w =0;
	foreach($monthes as $month){
	   $monthName =date('F',  strtotime($month['start'])); 
	   $callBackContacted = $this->_getCallBackContacted($month['start'], $month['end']);
	   $callBackActive    = $this->_getCallBackActive($month['start'], $month['end']);
	   $callBackInActive  = $this->_getCallBackInActive($month['start'], $month['end']);
	   $currentMonthContacted = $this->_getCurrentMonthContacted($month['start'], $month['end']);
	   $currentMonthActive	  =   $this->_getCurrentMonthActive($month['start'], $month['end']);
	   $currentMonthInActive  = $this->_getCurrentMonthInActive($month['start'], $month['end']);
	   $callBackContactedTotal += $callBackContacted['Total'];
	   $callBackActiveTotal	   += $callBackActive['Total'];
	   $callBackInActiveTotal  += $callBackInActive['Total'];
	   
	   $currentMonthContactedTotal += $currentMonthContacted['Total'];
	   $currentMonthActiveTotal    += $currentMonthActive['Total'];
	   $currentMonthInActiveTotal  += $currentMonthInActive['Total'];
	   
	   $contactedPatients[$monthName][] = $callBackContacted;
	   $contactedPatients[$monthName][] = $callBackActive;
	   $contactedPatients[$monthName][] = $callBackInActive;
	   $contactedPatients[$monthName][] = $currentMonthContacted;
	   $contactedPatients[$monthName][] = $currentMonthActive;
	   $contactedPatients[$monthName][] = $currentMonthInActive;
	   $w++;
	}
	
	$contactedPatients['Total']=array(array('Total'=>$callBackContactedTotal), 
				    array('Total'=>$callBackActiveTotal), 
				    array('Total'=>$callBackInActiveTotal),
				    array('Total'=>$currentMonthContactedTotal),
				    array('Total'=>$currentMonthActiveTotal),
				    array('Total'=>$currentMonthInActiveTotal));
	return $contactedPatients;
    }
    
    private function _getActiveUsers(){
	
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as  Total
				    FROM psc_drl_treatment_call_history 
				    WHERE call_date BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  program_id=7
				   ");
	return $values;
    
    }
    private function _getSboListName($id){
	$datas = $this->dbConnect->ExecuteSQL("SELECT id, name, emp_code, manager_area FROM `emp_master` 
					     WHERE emp_code='".$id."'");
	
	return $datas;
    }
    
    private function _getSboListAll($id){
	$sql = "SELECT id, name, emp_code, manager_area FROM `emp_master` ";
	$sql .= "WHERE `role`='sbo'  ";
	if($id['id']){
	    $sql .= " AND manager_id='".$id['id']."' ";
	}
	$sql .= " AND program_id=7 ";
	$datas = $this->dbConnect->ExecuteSQL($sql);
	
	return $datas;
    }
    private function _getSboList($id){
	$datas = $this->dbConnect->ExecuteSQL("SELECT id, name, emp_code, manager_area FROM `emp_master` 
					     WHERE `role`='sbo' AND 
					     manager_id='".$id['id']."' AND 
					     program_id=7");
	$dropDown = "<select name='sbo' class='btn btn-default' id='sbo' style='text-align: left;'>";
	$dropDown .="<option value=''>--Select SBO--</option>";
	foreach($datas as $data){
	    $dropDown .= "<option value='". $data['emp_code']."'>".$data['name']."</option>";
	}
	$dropDown .="</select>";
	return $dropDown;
    }
    
    private function _getSboListData($id){
	return $this->dbConnect->ExecuteSQL("SELECT id, name, emp_code, manager_area FROM `emp_master` 
					     WHERE `role`='sbo' AND 
					     manager_id='".$id."' AND 
					     program_id=7");
	
    }

    private function _getmanager(){
	return $this->dbConnect->ExecuteSQL("SELECT id, name FROM `emp_master` where `role`='manager' AND 
					     program_id=7");
    }
    private function _billDataDeclined($data){
	$month ="";
	$year = "";
	if(isset($data['eformmonth']) && !empty($data['eformmonth'])) { 
	    list($year, $months) = explode('-', $data['eformmonth']);
	    $month = $months;
	    $year = $year;
	} else {
	    $month = date('m');
	    $year = date('Y');
	}
	if(isset($data['etomonth']) && !empty($data['etomonth'])) { 
	    list($year, $months) = explode('-', $data['etomonth']);
	    $monthend = $months;
	    $year = $year;
	} else {
	    $monthend = date('m');
	    $year = date('Y');
	}
	
	$day = date('d');
	$days = cal_days_in_month(CAL_GREGORIAN, $monthend, $year);
	$monthStartDate = $year."-".$month."-01";
	$monthEndDate = date('Y')."-".$monthend."-".$days;
	return $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as Total, 
						MONTHNAME(created) as month_name   
						FROM psc_drl_user_attribute 
						WHERE current_med_flag=0 
						AND psconnect_flag=0 
						AND created BETWEEN '".$monthStartDate."' 
						AND '".$monthEndDate."'
						group by MONTH(created)");
    }
    private function _billDataTotalActiveUsers($data){
	$month ="";
	if(isset($data['eformmonth']) && !empty($data['eformmonth'])) { 
	    list($year, $months) = explode('-', $data['eformmonth']);
	    $month = $months;
	    $year = $year;
	} else {
	    $month = date('m');
	    $year = date('Y');
	}
	if(isset($data['etomonth']) && !empty($data['etomonth'])) { 
	    list($year, $months) = explode('-', $data['etomonth']);
	    $monthend = $months;
	    $year = $year;
	} else {
	    $monthend = date('m');
	    $year = date('Y');
	}
	
	$day = date('d');
	$days = cal_days_in_month(CAL_GREGORIAN, $monthend, $year);
	$monthStartDate = $year."-".$month."-01";
	$monthEndDate = date('Y')."-".$monthend."-".$days;
	return $this->dbConnect->ExecuteSQL("select COUNT(*) as Total, 
						MONTHNAME(created) as month_name   
						FROM psc_drl_user_attribute 
						WHERE current_med_flag=1 
						AND psconnect_flag=1 
						AND created BETWEEN '".$monthStartDate."' 
						AND '".$monthEndDate."'
						group by MONTH(created)");
    }
    private function _billDataContacted($monthfrom, $monthto){
	if($monthfrom){
	    list($fYear, $fMonth) = explode("-", $monthfrom);
	} else {
	    $fYear = date('Y');
	    $fMonth = date('m');
	}
	if($monthto){
	    list($tYear, $tMonth) = explode("-", $monthto);
	} else {
	    $tYear = date('Y');
	    $tMonth = date('m');
	}
	$days = cal_days_in_month(CAL_GREGORIAN, $tMonth, $tYear);
	$tMonth = sprintf("%02s", $tMonth);
	$fMonth = sprintf("%02s", $fMonth);
	$endDate = $tYear."-".$tMonth."-".$days;
	$startDate = $fYear."-".$fMonth."-01";
	
	$monthes = $this->_getMonthDates($startDate, $endDate);
	$w =0;
	foreach($monthes as $month){
	   $monthName =date('F',  strtotime($month['start'])); 
	   $callBackContacted = $this->_getCallBackContacted($month['start'], $month['end']);
	   $callBackActive    = $this->_getCallBackActive($month['start'], $month['end']);
	   $callBackInActive  = $this->_getCallBackInActive($month['start'], $month['end']);
	   
	   $callBackContactedTotal += $callBackContacted['Total'];
	   $callBackActiveTotal	   += $callBackActive['Total'];
	   $callBackInActiveTotal  += $callBackInActive['Total'];
	   
	   
	   $contactedPatients[$monthName][] = $callBackContacted;
	   $contactedPatients[$monthName][] = $callBackActive;
	   $contactedPatients[$monthName][] = $callBackInActive;
	   
	   $w++;
	}
	
	$contactedPatients['Total']=array(array('Total'=>$callBackContactedTotal), 
				    array('Total'=>$callBackActiveTotal), 
				    array('Total'=>$callBackInActiveTotal)
				    );
	return $contactedPatients;
	
	
    }
    
    
    
    private function _chearData($data) {
	$sboEmpCode="";
	if(isset($data['sbo']) && !empty($data['sbo'])){
	  $sboEmpCode = " AND emp_code='".$data['sbo']."'";
	}
	if(isset($data['manager']) && !empty($data['manager'])){
	  $managerCode = " AND manager_id='".$data['manager']."'";
	}
	return $this->dbConnect->ExecuteSQL("SELECT name,emp_code,id  FROM `emp_master` where program_id=7  $sboEmpCode $managerCode");
    }

   private function _empData($empcode, $data) {
       $datases =  $this->dbConnect->ExecuteSQL("SELECT COUNT(*) Total  
					    FROM patient_details as PD 
					    INNER JOIN emp_master as EM ON 
					    EM.emp_code=PD.emp_code
					    WHERE PD.emp_code='".$empcode."' 
					    AND created BETWEEN '".$data['ssdate']."' 
					    AND '".$data['eedate']."'");
       return $datases ;
   }

    private function _existingPatients() {
	$totalContacted="";
	$totalActive="";
	$totalInActive ="";
	$totalYetToBeContacted ="";
	//$year = date('Y');
	//$month = date('m');
	$year = date('Y');
	$month = date('m')-1;
	$day = date('d');
	$monthName =date('F',  strtotime($year."-".date('m')."-01"));
	//echo "<pre>";
	$weekDates = $this->_getWeekDate($month,$year);
	$w=1;
	$contactedPatients['header'][] =$monthName." ".$year;
	foreach($weekDates as $weekData){
	    $contactedPatients['header'][] = "Week ".$w;
	    $contactedPatients['data']['Patients Contacted'][$w]    = $this->_getCallBackContacted($weekData['ssdate'], $weekData['eedate']);
	    $contactedPatients['data']['Active Patients'][$w]	    = $this->_getCallBackActive($weekData['ssdate'], $weekData['eedate']);
	    $contactedPatients['data']['Inactive Patients'][$w]	    = $this->_getCallBackInActive($weekData['ssdate'], $weekData['eedate']);
	    $contactedPatients['data']['Yet to be Contacted'][$w]   = $this->_getCallBackYetToBeContacted($weekData['ssdate'], $weekData['eedate']);
	    $w++;
	}
	$contactedPatients['header'][$w+1] = "Total";
	foreach($contactedPatients['data']['Patients Contacted'] as $contactedPatient){
	    $contactedPatientTotal += $contactedPatient['Total'];
	}
	foreach($contactedPatients['data']['Active Patients'] as $ActivePatient){
	    $activePatientTotal += $ActivePatient['Total'];
	}
	foreach($contactedPatients['data']['Inactive Patients'] as $inactivePatient){
	    $inactivePatientTotal += $inactivePatient['Total'];
	}
	foreach($contactedPatients['data']['Yet to be Contacted'] as $yetToBeContacted){
	    $yetToBeContactedTotal += $yetToBeContacted['Total'];
	}
	$contactedPatients['data']['Patients Contacted'][]  =array('Total'=>$contactedPatientTotal);
	$contactedPatients['data']['Active Patients'][]	    =array('Total'=>$activePatientTotal);
	$contactedPatients['data']['Inactive Patients'][]   =array('Total'=>$inactivePatientTotal);
	$contactedPatients['data']['Yet to be Contacted'][] =array('Total'=>$yetToBeContactedTotal);
	$table = $this->grid($contactedPatients);

	return $table;
    }
    
    private function _newPatients() {
	$totalContacted="";
	$totalActive="";
	$totalInActive ="";
	$totalYetToBeContacted ="";
	//$year = date('Y');
	//$month = date('m');
	$year = date('Y');
	$month = date('m');
	$day = date('d');
	$monthName =date('F',  strtotime($year."-".$month."-01"));
	//echo "<pre>";
	$weekDates = $this->_getWeekDate($month,$year);
	$w=1;
	$contactedPatients['header'][] =$monthName." ".$year;
	foreach($weekDates as $weekData){
	    $contactedPatients['header'][] = "Week ".$w;
	    $contactedPatients['data']['Patients Contacted'][$w]    = $this->_getCurrentMonthContacted($weekData['ssdate'], $weekData['eedate']);
	    $contactedPatients['data']['Active Patients'][$w]	    = $this->_getCurrentMonthActive($weekData['ssdate'], $weekData['eedate']);
	    $contactedPatients['data']['Inactive Patients'][$w]	    = $this->_getCurrentMonthInActive($weekData['ssdate'], $weekData['eedate']);
	    $contactedPatients['data']['Yet to be Contacted'][$w]   = $this->_getCurrentMonthYettobeContacted($weekData['ssdate'], $weekData['eedate']);
	    $w++;
	}
	$contactedPatients['header'][$w+1] = "Total";
	foreach($contactedPatients['data']['Patients Contacted'] as $contactedPatient){
	    $contactedPatientTotal += $contactedPatient['Total'];
	}
	foreach($contactedPatients['data']['Active Patients'] as $ActivePatient){
	    $activePatientTotal += $ActivePatient['Total'];
	}
	foreach($contactedPatients['data']['Inactive Patients'] as $inactivePatient){
	    $inactivePatientTotal += $inactivePatient['Total'];
	}
	foreach($contactedPatients['data']['Yet to be Contacted'] as $yetToBeContacted){
	    $yetToBeContactedTotal += $yetToBeContacted['Total'];
	}
	$contactedPatients['data']['Patients Contacted'][]  =array('Total'=>$contactedPatientTotal);
	$contactedPatients['data']['Active Patients'][]	    =array('Total'=>$activePatientTotal);
	$contactedPatients['data']['Inactive Patients'][]   =array('Total'=>$inactivePatientTotal);
	$contactedPatients['data']['Yet to be Contacted'][] =array('Total'=>$yetToBeContactedTotal);
	$table = $this->grid($contactedPatients);

	return $table;
    }
    
   private function _getWeekNoByDay($month, $year) 
    { 
	return ceil( cal_days_in_month(CAL_GREGORIAN, $month, $year) / 7 ); 

    } 

    private function _getHTSubscribed($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total 
						FROM `psc_service_user` 
						WHERE created 
						BETWEEN '".$monthStart."' 
						AND '".$monthEnd."' 
						AND service_type_id=13");
	return $values;
    }
    
    private function _getSboHTSubscribed($monthStart, $monthEnd, $emp_code){
	$sql = "SELECT count(PUD.phone_number)as Total 
						FROM `psc_service_user` AS PSU 
						INNER JOIN psc_user_details as PUD ON PUD.id=PSU.user_details_id
						INNER JOIN patient_details as PD ON PD.pateint_mobile=PUD.phone_number
						WHERE PSU.service_type_id='13' 
						AND PSU.created BETWEEN '".$monthStart."' AND '".$monthEnd."'";
	if(!empty($emp_code)){
	    $sql .=" AND PD.emp_code='".$emp_code."'";
	    }
						
	
	$values = $this->dbConnect->ExecuteSQL($sql);
	return $values;
    }
    
     private function _getHTSent($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total 
						FROM `psc_scheduler_log` AS PSL 
						INNER JOIN `psc_service_user` AS PSU 
						ON PSU.id=PSL.service_user_id 
						WHERE PSL.created between '".$monthStart."' AND '".$monthEnd."'  
						AND PSU.service_type_id=13");
	return $values;
    }
    
    private function _getSboHTSent($monthStart, $monthEnd , $emp_code){
	$sql ="SELECT count(PSU.service_type_id) as Total 
						FROM `psc_service_user` AS PSU 
						INNER JOIN psc_user_details as PUD ON PUD.id=PSU.user_details_id
						INNER JOIN patient_details as PD ON PD.pateint_mobile=PUD.phone_number
						WHERE PSU.service_type_id='13' 
						AND PSU.created BETWEEN '".$monthStart."' AND '".$monthEnd."' 
						";
	if($emp_code){
	    $sql .=" AND PD.emp_code='".$emp_code."'";
	}
	$values = $this->dbConnect->ExecuteSQL($sql);
	return $values;
    }
    
    
    private function _getsSboRRSubscribed($monthStart, $monthEnd, $emp_code){
	$sql = "SELECT count(PUD.phone_number)as Total 
						FROM `psc_service_user` AS PSU 
						INNER JOIN psc_user_details as PUD ON PUD.id=PSU.user_details_id
						INNER JOIN patient_details as PD ON PD.pateint_mobile=PUD.phone_number
						WHERE PSU.service_type_id='12' 
						AND PSU.created BETWEEN '".$monthStart."' AND '".$monthEnd."' 
						";
	if($emp_code){
	   $sql .= "AND PD.emp_code='".$emp_code."'";
	}
	$values = $this->dbConnect->ExecuteSQL($sql);
	return $values;
    }
    
     private function _getRRSubscribed($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total 
						FROM `psc_service_user` 
						WHERE created 
						BETWEEN '".$monthStart."' 
						AND '".$monthEnd."' 
						AND service_type_id=12");
	return $values;
    }
    
    private function _getSboRRSent($monthStart, $monthEnd, $emp_code){
	$sql = "SELECT count(PSU.service_type_id) as Total 
						FROM `psc_service_user` AS PSU 
						INNER JOIN psc_user_details as PUD ON PUD.id=PSU.user_details_id
						INNER JOIN patient_details as PD ON PD.pateint_mobile=PUD.phone_number
						WHERE PSU.service_type_id='12' 
						AND PSU.created BETWEEN '".$monthStart."' AND '".$monthEnd."' 
						";
	if($emp_code){
	    $sql .="AND PD.emp_code='".$emp_code."'";
	}
	$values = $this->dbConnect->ExecuteSQL($sql);
	return $values;
    }
    
    private function _getRRSent($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT count(*) as Total 
						FROM `psc_scheduler_log` AS PSL 
						INNER JOIN `psc_service_user` AS PSU 
						ON PSU.id=PSL.service_user_id 
						WHERE PSL.created between '".$monthStart."' AND '".$monthEnd."'  
						AND PSU.service_type_id=12");
	return $values;
    }
    private function _getCallBackContacted($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as  Total
				    FROM psc_drl_treatment_call_history 
				    WHERE call_date BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  program_id=7
				   ");
	return $values;
    }
    
    private function _getSboCallBackActive($monthStart, $monthEnd, $emp_code){
	$sql ="SELECT COUNT(PUD.phone_number) as  Total FROM 
						psc_drl_treatment_call_history AS PDTCH 
						INNER JOIN psc_user_details as PUD ON PUD.id=PDTCH.user_details_id
						INNER JOIN patient_details AS PD ON PD.pateint_mobile=PUD.phone_number
						WHERE PDTCH.program_id=7
						AND PDTCH.call_date BETWEEN '".$monthStart."' AND '".$monthEnd."' 
						AND PDTCH.`status`='2'";
	if($emp_code){
	    $sql .="AND PD.emp_code='".$emp_code."'";
	}
	$values = $this->dbConnect->ExecuteSQL($sql);
	return $values;
    }
    private function _getCallBackActive($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as  Total
				    FROM psc_drl_treatment_call_history 
				    WHERE call_date BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  program_id=7
				    AND status='2'
				   ");
	return $values;
    }
    
    private function _getCallBackInActive($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as  Total
				    FROM psc_drl_treatment_call_history 
				    WHERE call_date BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  program_id=7
				    AND status='3'
				   ");
	return $values;
    }
    private function _getCallBackYetToBeContacted($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as  Total
				    FROM psc_drl_treatment_call_history 
				    WHERE call_date BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  program_id=7
				    AND status='1'
				   ");
	return $values;
    }
    private function _getCurrentMonthContacted($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) as  Total
				    FROM psc_subscription_request 
				    WHERE created BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  programme_id=7 
				    ");
	return $values;
    }
    
    private function _getCurrentMonthActive($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) Total
				    FROM psc_subscription_request 
				    WHERE created BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  programme_id=7 
				    AND process_status=2");
	return $values;
    }
    
    private function _getSboCurrentMonthInActive($monthStart, $monthEnd,$emp_code){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) Total
				    FROM psc_subscription_request AS PSR 
				    INNER JOIN patient_details AS PD ON PD.subscription_request_id = PSR.id
				    WHERE PSR.created BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  PSR.programme_id=7 
				    AND PSR.process_status=2
				    AND PD.emp_code='".$emp_code."'");
	return $values;
    }
    private function _getCurrentMonthInActive($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) Total
				    FROM psc_subscription_request 
				    WHERE created BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  programme_id=7 
				    AND process_status=3");
	return $values;
    }
    private function _getCurrentMonthYettobeContacted($monthStart, $monthEnd){
	$values = $this->dbConnect->ExecuteSQL("SELECT COUNT(*) Total
				    FROM psc_subscription_request 
				    WHERE created BETWEEN '".$monthStart."' 
				    AND '".$monthEnd."' 
				    AND  programme_id=7 
				    AND (process_status=0 OR process_status=4)");
	return $values;
    }
    
     private function _getMonthDates($startDate, $endDate){
	 
	$curMonth =  date("m", strtotime($endDate)); //End Month
	$curYear = date("Y", strtotime($endDate)); //End Year
	$months = array();
	$months[] = array('start' => "$curYear-$curMonth-01", 'end' => $endDate);

	while ("$curYear-$curMonth-01" > $startDate) {
	    $monthEnd =  date("Y-m-d", mktime(0, 0, 0, $curMonth, 0, $curYear));
	    $curMonth = date('m', strtotime($monthEnd));
	    $curYear = date('Y', strtotime($monthEnd));
	    $monthStart = ($curYear-$curMonth-01 > $startDate) ? $startDate : "$curYear-$curMonth-01";
	    $months[] = array('start' => $monthStart, 'end' => $monthEnd);
	}
	return $months;
     }
     
     private function _getWeekDate($month, $year){
	 
	$mm= $month;
	$yy= $year;
	$startdate=date($yy."-".$mm."-01") ;
	$current_date=date('Y-m-t');
	$days= cal_days_in_month(CAL_GREGORIAN, $mm, $yy);
	$lastday=$yy.'-'.$mm.'-'.$days;
	$start_date = date('Y-m-d', strtotime($startdate));
	$end_date = date('Y-m-d', strtotime($lastday));
	$count_week=0;
	$week_array = array();
	$weeks = ceil($days/7);
	for($w=0; $w<$weeks; $w++){
	    if($start_date){
		$end_date = date('Y-m-d', strtotime($start_date." + 6 days"));
		if(strtotime($end_date)>strtotime($lastday)){
		    $end_date = $lastday;
		}
		$week_array[] = array(
		"ssdate" => $start_date,
		"eedate" => $end_date,
		);
	      $start_date = date('Y-m-d', strtotime($end_date." + 1 days"));
	    }
	}
	
	return $week_array;
     }
     
     private function _download(){
	    require('class-excel-xml.inc.php');
	    $download = $_GET['d'];
	    $manager = $_GET['m'];

	    if($download='sboenrollmenthistory'){
	    $header = array("SBO Name", "SBO Region", "Existing Patient Status", "","","","New Patient Status", "","","","");    
	    }
	    $doc = array (
		1 => $header ,
		     array ("Oliver", "Peter", "Paul"),
		     array ("Marlene", "Lucy", "Lina")
		);

	    // generate excel file
	    $xls = new Excel_XML;
	    $xls->addArray ( $doc );
	    $xls->generateXML ($download);
	    exit;
     }


     private function _genrateXls($dataes, $filename) {
	    $this->xls->addArray ( $dataes );
	    $this->xls->generateXML ($filename);
	    exit;
     }
     
}
?>
