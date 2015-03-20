<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// GoCart Theme
$config['theme']				= 'default';

$config['kickstrap']			= false;

// SSL support
$config['ssl_support']			= false;

// Business information
$config['company_name']			= '';
$config['entreprise_name']		= '';
$config['domain_name']			= '';
$config['fb_namespace']			= '';
$config['address1']				= '';
$config['address2']				= '';
$config['country']				= ''; // use proper country codes only
$config['country_full']			= '';
$config['city']					= ''; 
$config['state']				= '';
$config['zip']					= '';
$config['email']				= '';
$config['email_backup_orders']	= '';
$config['email_contact']		= '';

// Store currency
$config['currency']						= 'EUR';  // USD, EUR, etc
$config['currency_symbol']				= '€';
$config['currency_symbol_side']			= 'right'; // anything that is not "left" is automatically right
$config['currency_rate']				= 1;
$config['currency_decimal']				= '.';
$config['currency_thousands_separator']	= ',';
$config['currency_decimal_place']		= 2;

// Shipping config units
$config['weight_unit']	    		= 'KG'; // LB, KG, etc
$config['dimension_unit']  	 		= 'CM'; // FT, CM, etc

// site logo path (for packing slip)
$config['site_logo']				= '';

//change the name of the admin controller folder 
$config['admin_folder']				= 'admin';

//file upload size limit
$config['size_limit']				= intval(ini_get('upload_max_filesize'))*1024;

//are new registrations automatically approved (true/false)
$config['new_customer_status']		= true;

//do we require customers to log in 
$config['require_login']			= false;

//default order status
$config['order_status']				= 'Pending'; 											//Pending

// default Status for non-shippable orders (downloads)
$config['nonship_status'] 			= 'Livré';												//Delivered

$config['order_statuses']			= array(
		'Pending'  					=> 'Engistré - en attente de paiement',					//Pending
		'Processing'    			=> 'En cours de traitement - paiement reçu',			//Processing
		'Shipped'					=> 'Expédié',											//Shipped
		'On Hold'					=> 'En attente',										//On Hold
		'Cancelled'					=> 'Annulé',											//Cancelled
		'Delivered'					=> 'Livré'												//Delivered
);


$config['order_statuses_colors']	= array(
		'Pending'  					=> 'primary',											//Pending
		'Processing'    			=> 'info',												//Processing
		'Shipped'					=> 'warning',											//Shipped
		'On Hold'					=> 'inverse',											//On Hold
		'Cancelled'					=> 'danger',											//Cancelled
		'Delivered'					=> 'success'											//Delivered
);

// enable inventory control ?
$config['inventory_enabled']						= true;

$config['limit_fin_de_collection']					= 1;

// allow customers to purchase inventory flagged as out of stock?
$config['allow_os_purchase'] 						= false;

//do we tax according to shipping or billing address (acceptable strings are 'ship' or 'bill')
$config['tax_address']								= 'bill';

$config['require_shipping'] 						= true;

//do we tax the cost of shipping?
$config['tax_shipping']								= false;

//display vat taxes specifically for european countries NOTICE config vat_tax_all_countries must be false
$config['vat_tax_country_list']			= array(
											'BE', 'BG', 'CZ', 'DK', 'DE', 'EE', 'EL', 'ES', 'FR', 'HR', 'IE', 'IT', 'CY', 'LV', 'LT', 'LU', 'HU', 'MT', 'NL', 'AT', 'PL', 'PT', 'RO', 'SI', 'SK', 'FI', 'SE', 'UK'
										);
//this will display vat taxes for all countries
$config['vat_tax_all_countries']					= true;

$config['vat_tax_rate']								= 0.2;

$config['display_vat_taxes']						= false;

// Additinal taxes (if any) added on top of VAT taxes. 
// If false additinal taxes based only on merchandise OR if true additinal taxes based on shipping.
$config['additional_tax_shipping']					= false;
// If true additinal taxes applied only to shipping OR if false additinal taxes applied to merchandise and shipping
$config['additional_tax_applied_only_to_shipping']	= false;

$config['subscribe_to_newsletter_during_checkout_stage'] 						=  false;

$config['redirect_only_to_mondial_relay_interface_for_create_shipment'] 		=  false;
$config['redirect_only_to_mondial_relay_interface_for_parcel_tracking_info'] 	=  false;

$config['MondialRelay_ParcelShopId']	= '';
$config['MondialRelay_AccountId']		= '';
$config['MondialRelay_Marque']			= '';
$config['MondialRelay_CodeMarque']		= '';
$config['MondialRelay_PrivateKey']		= '';
$config['MondialRelay_Login']			= '';
$config['MondialRelay_MotdePasse']		= '';

$config['mysqli_connect'] 				= array(
											'host_db' => "", // nom de votre serveur
											'user_db' => "", // nom d'utilisateur de connexion ‡ votre bdd
											'password_db' => "", // mot de passe de connexion ‡ votre bdd
											'bdd_db' => "" // nom de votre bdd
										);

/*
|--------------------------------------------------------------------------
| Asset URL
|--------------------------------------------------------------------------
|
| URL to your site's assets folder. If blank, it defaults to the Site URL
| specified above. A trailing slash will be added if not present.
|
|
*/
$config['asset_url'] = '';
					
/*
|--------------------------------------------------------------------------
| File Upload Preferences
|--------------------------------------------------------------------------
|
| You can optionally override upload destination paths, URLs and titles.
|
*/


$config['upload_name'] 				= IMG_UPLOAD_FOLDER;														// Display name
$config['upload_server_path'] 		= 'absolute_path'.IMG_UPLOAD_FOLDER; 										// Server path to upload directory
$config['upload_url'] 				= 'url_path'.IMG_UPLOAD_FOLDER;												// URL of upload directory

/*
$config['upload_name'] 				= IMG_UPLOAD_FOLDER;														// Display name
$config['upload_server_path'] 		= 'absolute_path'.IMG_UPLOAD_FOLDER;										// Server path to upload directory
$config['upload_url'] 				= 'url_path'.IMG_UPLOAD_FOLDER;												// URL of upload directory
*/

$config['og_name'] 					= OPEN_GRAPH_FOLDER;														// Display name
$config['og_server_path'] 			= 'absolute_path'.OPEN_GRAPH_FOLDER; 										// Server path to upload directory
$config['og_url'] 					= 'url_path'.OPEN_GRAPH_FOLDER;												// URL of upload directory

/*
|--------------------------------------------------------------------------
| Custom Styles
|--------------------------------------------------------------------------
|
| 
|
*/

$config['carousel_full_page']			= false;

$config['homepage_style_couettabra']	= false;

$config['category_style_couettabra']	= false;
$config['category_style_couettabra2']	= true;
$config['category_style_housses']		= true;

$config['category_style_plaidabra']		= false;

$config['category_style_duvettabra']	= false;


/*
|--------------------------------------------------------------------------
| Format Output
|--------------------------------------------------------------------------
|
| 
|
*/

$config['compact_html'] 				= false;