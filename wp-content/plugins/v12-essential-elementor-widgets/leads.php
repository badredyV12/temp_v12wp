<?php
//die("test ajax:".strpos($_SERVER['REQUEST_URI'], '_ajax'));
/** Ajax request process */
if (strpos($_SERVER['REQUEST_URI'], '_ajax') !== false) {
    IfAjax();
}

function IfAjax()
{

    $APP_CLIENT_URL = "https://crm.v12software.ai/api/v2/lead/store";
    $APP_CLIENT_TOKEN = "Authorization: Bearer REFx1MRtzW7k3mzY0tJWikz47DjoKtOB";

	// Other forms
	if(isset($_GET['ACT']) && in_array($_GET['ACT'],["api"])){
		if(isset($_POST["name_mid"]) && $_POST["name_mid"]!=""){
			$res['success']['status']['code'] = 200;
			$res = json_encode($res);
			echo $res;
			die;
		}else{
			$url  = $APP_CLIENT_URL;
			$res = MyproxyDataNFS($url,$_POST,$APP_CLIENT_TOKEN);
			echo $res;
			die;
		} 
	}
	elseif(isset($_GET['ACT']) && $_GET['ACT']=="Availability" ){

		global $user_id;
		$showTask = false;
		$confirmTask = false;
		$rescheduleTask = false;

		$getAailability = true;
		$url  = 'https://crm.v12software.ai/api/v2/task/availability';
		$method  = "GET";

		$data = $_GET;

		$res = MyproxyDataNFS($url,$data,$APP_CLIENT_TOKEN,$method,$showTask,$confirmTask,$rescheduleTask,$getAailability);
		echo $res;
		die;
	}

}

function MyproxyDataNFS($url,$data,$APP_CLIENT_TOKEN,$method="POST",$showTask=false,$confirmTask=false,$rescheduleTask=false,$getAailability=false,$isTrackableNum=false) {

	try {
		if(!$isTrackableNum){
			if(isset($_COOKIE['referrer'])){
				$source = $_COOKIE['referrer'];
				if($_COOKIE['network_id']=="facebook"){
					$network_id = "1";
				}elseif($_COOKIE['network_id']=="google"){
					$network_id = "2";
				}elseif($_COOKIE['network_id']=="megadrive"){
					$network_id = "4";
				}elseif($_COOKIE['network_id']=="google_merchant"){
					$network_id = "8";
				}
			}elseif(isset($_GET['referrer'])){
				$source = $_GET['referrer'];
				if($_GET['network_id']=="facebook"){
					$network_id = "1";
				}elseif($_GET['network_id']=="google"){
					$network_id = "2";
				}elseif($_GET['network_id']=="megadrive"){
					$network_id = "4";
				}elseif($_GET['network_id']=="google_merchant"){
					$network_id = "8";
				}
			}else {
				$source = 'Website';
				$network_id = false;
			}
			$visitor_id = isset($_COOKIE['visitorID']) ? json_decode($_COOKIE['visitorID'])->guid : 'false';
	
			if(!$showTask && !$confirmTask && !$rescheduleTask && !$getAailability){
				$data['network_id'] = $network_id;
				$data['visitor_id'] = $visitor_id;
	
				if($source=="ad360"){
					$data['source_id'] = 219;
					$data['source'] = "Digital Ads";
				}
				else{
					$data['source_id'] = 1;
					$data['source'] = $source;
				}
	
			}
		}else{
			if($_GET['network_id']=="facebook"){
				$use_for = "3";
			}elseif($_COOKIE['referrer']=="ad360"){
				$use_for = "2";
			}elseif(in_array($_GET['network_id'],["google","google_merchant"])){
				$use_for = "4";
			}elseif($_GET['network_id']=="craigslist"){
				$use_for = "5";	
			}else{
				$use_for = "1";
			}
			$data['use_for'] = $use_for;
		}
		// $data['user_id'] = $_POST["user_id"];
		$data['user_id'] = 100079;

		$ch = curl_init();
		
		// $data = ["user_id" => 100079,"current_day" =>"2023-09-14"];
		$data = json_encode($data);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $APP_CLIENT_TOKEN ));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
		$res = curl_exec($ch);
		return "#_ajax_v12#".$res;

	} catch (Exception $e) {
		return $e->getMessage();
	}
}




