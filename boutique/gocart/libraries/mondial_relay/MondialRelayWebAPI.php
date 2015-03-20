<?php
require_once ('lib/nusoap.php');
require_once ('dto/PointRelais.dto.php');
require_once ('helpers/ParcelShopHelper.Class.php');
require_once ('helpers/ApiHelper.Class.php');
/**
 * API Mondial Relay
 */
class MondialRelayWebAPI {
	
	/**
	 * URL du web service Mondial Relay
	 * @var string
	 * @access private
	 */
	private $_APIEndPointUrl;
	/**
	 * Mondial relay Customer ID (Brand ID)
	 * @var string
	 * @access private
	 */
	private $_APILogin;
	/**
	 * Mondial Relay Customer Password (secret key)
	 * @var string
	 * @access private
	 */
	private $_APIPassword;
	/**
	 * API File Endpoint
	 * @var string
	 * @access private
	 */
	private $_APIFileEndPoint;
	/**
	 * Nusoap Soap client isntance
	 * @var nusoap_client
	 * @access private
	 */
	private $_SoapClient;
	/**
	 * Mondial Relay Customer Extranet Root Url
	 * @var string
	 * @access private
	 */
	private $_MRConnectUrl = "http://connect.mondialrelay.com";
	/**
	 * Mondial Relay Stickers Root URL
	 * @var string
	 * @access private
	 */
	private $_MRStickersUrl = "http://www.mondialrelay.com";
	/**
	 * Debug mode enabled or not
	 * @var boolean
	 * @access private
	 */
	private $_Debug = false;
	
	/**
	 * constructor
	 *
	 * @param    string $ApiEndPointUrl Mondial Relay API EndPoint
	 * @param    string $ApiLogin Mondial Relay API Login (provided by your technical contact)
	 * @param    string $ApiPassword Mondial Relay API Password (provided by your technical contact)
	 * @access   public
	 */
	
	/*
	public function __construct($ApiEndPointUrl, $ApiLogin, $ApiPassword, $DebugMode = false ) { 
		$this->_APIEndPointUrl = $ApiEndPointUrl ;
		$this->_APILogin = $ApiLogin ;
		$this->_APIPassword = $ApiPassword ;
		$this->_APIFileEndPoint  = "Web_Services.asmx?WSDL";
		
		$this->_Debug = $DebugMode;
		
		$this->_SoapClient = new nusoap_client($this->_APIEndPointUrl . $this->_APIFileEndPoint, true);
		$this->_SoapClient->soap_defencoding = 'utf-8';
	} 
	*/
	
	public function __construct($config) {
		$this->_APIEndPointUrl = $config ['_APIEndPointUrl'];
		$this->_APILogin = $config ['_APILogin'];
		$this->_APIPassword = $config ['_APIPassword'];
		$this->_APIFileEndPoint = "Web_Services.asmx?WSDL";
		
		$this->_Debug = $config ['_Debug'];
		
		$this->_SoapClient = new nusoap_client ( $this->_APIEndPointUrl . $this->_APIFileEndPoint, true );
		$this->_SoapClient->soap_defencoding = 'utf-8';
	}
	
	public function __destruct() {
	
	}
	
	/**
	 * Search parcel Shop Arround a postCode according to filters
	 *
	 * @param    string $CountryCode Country Code (ISO) of the post code
	 * @param    string $PostCode Post Code arround which you want to find parcel shops
	 * @param    string $DeliveryMode Optionnal - Delivery Mode Code Filter (3 Letter code, 24R, DRI). Will restrict the results to parcelshops available with this delivery Mode
	 * @param    int $ParcelWeight Optionnal - Will restrict results to parcelshops compatible with the parcel Weight in gramms specified
	 * @param    int $ParcelShopActivityCode Optionnal - Will restrict results to parcelshops regarding to their actity code
	 * @param    int $SearchDistance Optionnal - Will restrict results to parcelshops in the perimeter specified in km
	 * @param    int $SearchOpenningDelay Optionnal - If you intend to give us the parcel in more than one day, you can specified a delay in order to filter ParcelShops according to their oppening periods
	 * @access   public
	 * @return   Array of parcelShop
	 */
	public function SearchParcelShop($CountryCode, $PostCode, $DeliveryMode = "", $ParcelWeight = "", $ParcelShopActivityCode = "", $SearchDistance = "", $SearchOpenningDelay = "") {
		
		$params = array ('Enseigne' => $this->_APILogin, 'Pays' => $CountryCode, 'Ville' => "", 'CP' => $PostCode, 'Taille' => "", 'Poids' => $ParcelWeight, 'Action' => $DeliveryMode, 'RayonRecherche' => $SearchDistance, 'TypeActivite' => $ParcelShopActivityCode, 'DelaiEnvoi' => $SearchOpenningDelay );
		
		$result = $this->CallWebApi ( "WSI3_PointRelais_Recherche", $this->AddSecurityCode ( $params ) );
		
		if ($result ["WSI3_PointRelais_RechercheResult"] ["STAT"] == 0) {
			if ($result ["WSI3_PointRelais_RechercheResult"] ["PointsRelais"] != null) {
				foreach ( $result ["WSI3_PointRelais_RechercheResult"] ["PointsRelais"] ["PointRelais_Details"] as $val ) {
					$parcelShopArray [] = ParcelShopHelper::ParcelShopResultToDTO ( $val );
				}
				
				return $parcelShopArray;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * get the parcel shop datas (adress, openning, geodata, picture url, ...)
	 *
	 * @param    string $CountryCode Country Code (ISO) of the post code
	 * @param    string $ParcelShopId parcel Shop ID
	 * @access   public
	 * @return   ParcelShop
	 */
	public function GetParcelShopDetails($CountryCode, $ParcelShopId) {
		$params = array ('Enseigne' => $this->_APILogin, 'Pays' => $CountryCode, 'NumPointRelais' => $ParcelShopId );
		
		$result = $this->CallWebApi ( "WSI3_PointRelais_Recherche", $this->AddSecurityCode ( $params ) );
		//print_r($result);
		

		//transformation en dto
		$parcelShopArray = ParcelShopHelper::ParcelShopResultToDTO ( $result ["WSI3_PointRelais_RechercheResult"] ["PointsRelais"] ["PointRelais_Details"] );
		
		return $parcelShopArray;
	
	}
	
	/**
	 * register a shipment in our system
	 *
	 * @param    string $ShipmentDetails Shipment datas
	 * @param    string $ReturnStickers (optionnal) default is TRUE, will return a stickers url id true
	 * @access   public
	 * @return   shipmentResult
	 * @todo : better result output
	 */
	public function CreateShipment($ShipmentDetails, $ReturnStickers = true) {
		$params = array ('Enseigne' => $this->_APILogin, 'ModeCol' => $ShipmentDetails->CollectMode->Mode, 'ModeLiv' => $ShipmentDetails->DeliveryMode->Mode, 'NDossier' => $ShipmentDetails->InternalOrderReference, 'NClient' => $ShipmentDetails->InternalCustomerReference, 'Expe_Langage' => $ShipmentDetails->Sender->Language, 'Expe_Ad1' => $ShipmentDetails->Sender->Adress1, 'Expe_Ad2' => $ShipmentDetails->Sender->Adress2, 'Expe_Ad3' => $ShipmentDetails->Sender->Adress3, 'Expe_Ad4' => $ShipmentDetails->Sender->Adress4, 'Expe_Ville' => $ShipmentDetails->Sender->City, 'Expe_CP' => $ShipmentDetails->Sender->PostCode, 'Expe_Pays' => $ShipmentDetails->Sender->CountryCode, 'Expe_Tel1' => $ShipmentDetails->Sender->PhoneNumber, 'Expe_Tel2' => $ShipmentDetails->Sender->PhoneNumber2, 'Expe_Mail' => $ShipmentDetails->Sender->Email, 

		'Dest_Langage' => $ShipmentDetails->Recipient->Language, 'Dest_Ad1' => $ShipmentDetails->Recipient->Adress1, 'Dest_Ad2' => $ShipmentDetails->Recipient->Adress2, 'Dest_Ad3' => $ShipmentDetails->Recipient->Adress3, 'Dest_Ad4' => $ShipmentDetails->Recipient->Adress4, 'Dest_Ville' => $ShipmentDetails->Recipient->City, 'Dest_CP' => $ShipmentDetails->Recipient->PostCode, 'Dest_Pays' => $ShipmentDetails->Recipient->CountryCode, 'Dest_Tel1' => $ShipmentDetails->Recipient->PhoneNumber, 'Dest_Tel2' => $ShipmentDetails->Recipient->PhoneNumber2, 'Dest_Mail' => $ShipmentDetails->Recipient->Email, 

		'Poids' => $ShipmentDetails->ShipmentWeight, 'Longueur' => $ShipmentDetails->ShipmentHeight, 'Taille' => $ShipmentDetails->ShipmentPresetSize, 'NbColis' => $ShipmentDetails->NumberOfParcel, 'CRT_Valeur' => $ShipmentDetails->CostOnDelivery, 'CRT_Devise' => $ShipmentDetails->CostOnDeliveryCurrency, 'Exp_Valeur' => $ShipmentDetails->Value, 'Exp_Devise' => $ShipmentDetails->ValueCurrency, 

		'COL_Rel_Pays' => $ShipmentDetails->CollectMode->ParcelShopContryCode, 'COL_Rel' => $ShipmentDetails->CollectMode->ParcelShopId, 

		'LIV_Rel_Pays' => $ShipmentDetails->DeliveryMode->ParcelShopContryCode, 'LIV_Rel' => $ShipmentDetails->DeliveryMode->ParcelShopId, 

		'Assurance' => $ShipmentDetails->InsuranceLevel, 'Instructions' => $ShipmentDetails->DeliveryInstruction );
		
		$params = $this->AddSecurityCode ( $params );
		
		$params ['Texte'] = $ShipmentDetails->CommentOnLabel;
		
		$result = $this->CallWebApi ( "WSI2_CreationEtiquette", $params );
		
		return $result;
	}
	
	/**
	 * get a parcel status
	 *
	 * @param    int $ShipmentNumber Shipment number(8 digits)
	 * @access   public
	 * @return   shipmentStatus
	 */
	public function GetShipmentStatus($ShipmentNumber) {
		die ( "Not implemented yet !" );
	}
	
	/**
	 * get a secure link to the parcel informations mondial relay website 
	 *
	 * @param    int $ShipmentNumber Shipment number(8 digits)
	 * @access   public
	 * @return   string puclic tracing url
	 */
	public function GetShipmentPublicTracingLink($ShipmentNumber) {
		die ( "Not implemented yet !" );
	}
	
	/**
	 * get a secure link to the professional parcel informations mondial relay extranet 
	 *
	 * @param    int $ShipmentNumber Shipment number(8 digits)
	 * @param    string $UserLogin Login to connect to the system
	 * @access   public
	 * @return   string
	 */
	public function GetShipmentConnectTracingLink($ShipmentNumber, $UserLogin) {
		$Tracing_url = "/Yeti.Web/" . trim ( strtoupper ( $this->_APILogin ) ) . "/Expedition/Afficher?numeroExpedition=" . $ShipmentNumber;
		return $this->_MRConnectUrl . $this->AddConnectSecurityParameters ( $Tracing_url, $UserLogin );
	}
	
	/**
	 * add the security signature to the extranet url request
	 *
	 * @param    string $UrlToSecure Url 
	 * @param    string $UserLogin Login to connect to the system
	 * @access   private
	 * @return   string
	 */
	private function AddConnectSecurityParameters($UrlToSecure, $UserLogin) {
		$UrlToSecure = $UrlToSecure . "&login=" . $UserLogin . "&ts=" . time ();
		$UrlToEncode = $this->_APIPassword . "_" . $UrlToSecure;
		//echo $UrlToEncode;
		return $UrlToSecure . "&crc=" . strtoupper ( md5 ( $UrlToEncode ) );
	}
	
	/**
	 * add the security signature to the soap request
	 *
	 * @param    string $ParameterArray Soap Parameters Request to secure 
	 * @param    boolean $ReturnArray Optionnal, False if you just want to output the security string
	 * @access   private
	 * @return   string
	 */
	private function AddSecurityCode($ParameterArray, $ReturnArray = true) {
		
		$secString = "";
		foreach ( $ParameterArray as $prm ) {
			$secString .= $prm;
		}
		if ($ReturnArray) {
			$ParameterArray ['Security'] = strtoupper ( md5 ( $secString . $this->_APIPassword ) );
			return $ParameterArray;
		} else {
			return strtoupper ( md5 ( $secString . $this->_APIPassword ) );
		}
	}
	
	/**
	 * perform a call to the mondial relay API
	 *
	 * @param    string $methodName Soap Method to call
	 * @param    $ParameterArray Soap parameters array
	 * @access   private
	 */
	private function CallWebApi($methodName, $ParameterArray) {
		$result = $this->_SoapClient->call ( $methodName, $ParameterArray, $this->_APIEndPointUrl, $this->_APIEndPointUrl . $methodName );
		
		// Display the request and response
		if ($this->_Debug) {
			echo '<div style="border:solid 1px #ddd;font-family:verdana;padding:5px">';
			echo '<h1>Method ' . $methodName . '</h1>';
			echo '<div>' . ApiHelper::GetStatusCode ( $result ) . '</div>';
			echo '<h2>Request</h2>';
			echo '<pre>';
			print_r ( $ParameterArray );
			echo '</pre>';
			echo '<pre>' . htmlspecialchars ( $this->_SoapClient->request, ENT_QUOTES ) . '</pre>';
			echo '<h2>Response</h2>';
			echo '<pre>';
			print_r ( $result );
			echo '</pre>';
			echo '<pre>' . htmlspecialchars ( $this->_SoapClient->response, ENT_QUOTES ) . '</pre>';
			
			echo '</div>';
		
		}
		
		return $result;
	}
	
	/**
	 * Build a link to download the stickers 
	 * from a web service call result
	 *
	 * @param    service result $StickersResult 
	 * @access   public
	 */
	public function BuildStickersLink($StickersResult) {
		
		return $this->_MRStickersUrl . $StickersResult ['WSI2_CreationEtiquetteResult'] ['URL_Etiquette'];
	}

}
?>