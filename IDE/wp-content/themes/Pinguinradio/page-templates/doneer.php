<?php
/**
 * Template Name: Doneren Template
 *
 * Description: Net gedraaid template
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
		
		<section id="content" class="row" role="main">			
			<?php get_sidebar('left'); ?>
				
		<article class="sevencol content-bg" id="post-61">
			<header class="entry-header">
				<h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title;?></h3>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
		Wees niet ongerust! Marcel werkt hier nog aan op dit moment! :-)
		
	<?php	
include('/_assets/php/multisafepay/MultiSafepay.combined.php');
include('/_assets/php/multisafepay/MultiSafepay.config.php');


$sDonatePath = 'acties/doneren';

function not_empty($sInput) {
	if (trim($sInput) != '') { return true; }
	else { return false; }
}
function is_validEmail($sInput) {
	//if (trim($sInput) != '') { return true; }//if(filter_var(trim($sInput), FILTER_VALIDATE_EMAIL)) { return true; }
	//else { return false; }
	return true;
}

// Setting defaults
$bProcessOrder = false;
$aErrors = array();
$sNaam = '';
$sVoornaam = '';
$sAchternaam = '';
$sAdres = '';
$sPostcode = '';
$sPlaats = '';
$sLand = '';
$sEmail = '';
$sTelefoon = '';
$sLuisteraar = '';
$sBedankt = '';
$iAmount = 0;

// POST afhandelen
if (isset($_POST) && isset($_POST['order'])) {
	//print_r($_POST);
	if (isset($_POST['naam'])) 						{ $sNaam = $_POST['naam']; }
	if (isset($_POST['adres']))						{ $sAdres = $_POST['adres']; }
	if (isset($_POST['postcode']))				{ $sPostcode = $_POST['postcode']; }
	if (isset($_POST['plaats']))					{	$sPlaats = $_POST['plaats']; }
	if (isset($_POST['land']))						{ $sLand = $_POST['land']; }
	if (isset($_POST['email']))						{ $sEmail = $_POST['email']; }
	if (isset($_POST['telefoon']))				{ $sTelefoon = $_POST['telefoon']; }
	if (isset($_POST['luisteraar']))			{ $sLuisteraar = $_POST['luisteraar']; }
	if (isset($_POST['bedankt']))					{ $sBedankt = $_POST['bedankt']; }
	if (isset($_POST['amount']))					{ $iAmount = (int)$_POST['amount']; }
		
	// Validation
	if (!not_empty($sNaam))			{ $aErrors[] = 'Vul je naam in'; }
	if (!not_empty($sAdres))		{ $aErrors[] = 'Vul je adres in'; }
	if (!not_empty($sPostcode))	{ $aErrors[] = 'Vul je postcode in'; }
	if (!not_empty($sPlaats))		{ $aErrors[] = 'Vul je woonplaats in'; }
	if (!is_email($sEmail))			{ $aErrors[] = 'Vul een geldig e-mailadres in'; }
	if (!not_empty($sTelefoon))	{ $aErrors[] = 'Vul je telefoonnummer in'; }
	if (!not_empty($iAmount) || !is_int($iAmount) || $iAmount < 2)	{ $aErrors[] 	 = 'Vul een bedrag van minimaal 2,- in'; }
	
	$_SESSION['local_order'] = array (
		'naam' => $sNaam,
		'adres' => $sAdres,
		'postcode' => $sPostcode,
		'plaats' => $sPlaats,
		'land' => $sLand,
		'email' => $sEmail,
		'telefoon' => $sTelefoon,
		'luisteraar' => $sLuisteraar,
		'bedankt' => $sBedankt,
		'amount' => $iAmount
	);
	
	if (count($aErrors) == 0) {
		$bProcessOrder = true;
	}
	//print_r($aErrors);
}

// Bestelling verwerken
if ($bProcessOrder === true) {
	unset($_SESSION['msp_order']);
	unset($_SESSION['local_order']);
	$msp = new MultiSafepay();
	$iTotalAmount = 0;
	$sItemHtml = '';
	
	// Merchant Settings
	$msp->test                         = MSP_TEST_API;
	$msp->merchant['account_id']       = MSP_ACCOUNT_ID;
	$msp->merchant['site_id']          = MSP_SITE_ID;
	$msp->merchant['site_code']        = MSP_SITE_CODE;
	$msp->merchant['notification_url'] = BASE_URL . $sDonatePath.'?type=initial';
	$msp->merchant['cancel_url']       = BASE_URL . $sDonatePath.'?order=cancel';
	$msp->merchant['redirect_url']     = BASE_URL . $sDonatePath.'?order=return'; 

	// Customer Details - supply if available
	$aNames = explode(' ',$sNaam,2);
	$msp->customer['locale']           = $sLand;
	$msp->customer['firstname']        = $aNames[0];
	$msp->customer['lastname']         = $aNames[1];
	$msp->customer['zipcode']          = $sPostcode;
	$msp->customer['city']             = $sPlaats;
	$msp->customer['country']          = strtoupper($sLand);
	$msp->customer['phone']            = $sTelefoon;
	$msp->customer['email']            = $sEmail;
	$msp->customer['luisteraar']       = $sLuisteraar;
	$msp->customer['bedankt']          = $sBedankt;
	$msp->parseCustomerAddress($sAdres);

	// Shopping cart / producten
	$oCartItem = new MspItem(
		'PinguinRadio donatie',
		'Donatie van '.$iAmount.' EUR aan PinguinRadio',
		1,
		number_format(($iAmount /*/ 1.19*/),10,'.','')
	);
	$oCartItem->SetMerchantItemId('Donatie 001');
	$msp->cart->AddItem($oCartItem);
	
	$sItemHtml .= '<li>Donatie van '.$iAmount.' EUR aan PinguinRadio</li>';
	
	// Transaction Details
	$msp->transaction['id']            = rand(100000000,999999999); // generally the shop's order ID is used here
	$msp->transaction['currency']      = 'EUR';
	$msp->transaction['amount']        = number_format((($iAmount /*/ 1.19*/)*100),0,'.',''); // cents
	$msp->transaction['description']   = 'Order #' . $msp->transaction['id'];
	$msp->transaction['items']         = '<br/><ul>'.$sItemHtml.'</ul>';
	
	// Shipping methods
	/*$ship = new MspFlatRateShipping("Verzending per post", 0);
	$filter = new MspShippingFilters();
	$filter->AddAllowedPostalArea('NL');
	$filter->AddAllowedPostalArea('BE');
	$ship->AddShippingRestrictions($filter);
	$msp->cart->AddShipping($ship);//*/

	// Taxes
	$msp->setDefaultTaxZones();
	
	// Sessie vullen
	$_SESSION['msp_order'] = array(
		'transaction' => $msp->transaction,
		'customer' => $msp->customer,
		'product' => 'PinguinRadio donatie',
		'totalAmount' => $iAmount
	);
	
	// Request bouwen
	$url = $msp->startTransaction();
	if ($msp->error){
	  echo "<h1>Donatie mislukt</h1> <p>Er ging iets fout bij het verwerken van je donatie.</p><p>" . $msp->error_code . ": " . $msp->error."</p>";
	} elseif (!$msp->error){
	  header("Location: ".$url);
	}
}
?>


<?php if (isset($_GET['order']) && isset($_GET['transactionid']) && $_GET['order'] == 'return' && $_GET['transactionid'] > 0) : ?>
	<h1 style="color:#458B00">Je donatie is verzonden, Hartstikke bedankt!</h1>
	<p style="color:#458B00">Je ontvangt binnen enkele minuten een bevestiging op het opgegeven e-mailadres.<br/><br/></p>
<?php
	if (isset($_SESSION['msp_order']) && $_SESSION['msp_order']['transaction']['id'] == $_GET['transactionid']) {
		// Send mail to customer
		$aOrder = $_SESSION['msp_order'];
		$aTransaction = $aOrder['transaction'];
		$aCustomer = $aOrder['customer'];
		$sProduct = $aOrder['product'];
		
		// Building message
		$sMessage = 'Beste '.$aCustomer['firstname'].' '.$aCustomer['lastname'].",\n\n";
		$sMessage .= 'Je betaling is succesvol verlopen. Het bedrag van '.number_format(($aTransaction['amount'] / 100),2,',','').' EUR is overgemaakt aan PinguinRadio.'."\n\n";
		
		$sMessage .= 'Omschrijving: '.$aTransaction['description']."\n";
		$sMessage .= '----------------------------------------------------------------'."\n";
		$sMessage .= $sProduct.''."\n";
		/*foreach($aProducts as $aProduct) {
			$sMessage .= $aProduct['quantity'].'x '.$aProduct['name']."\n";
		}*/
		$sMessage .= '----------------------------------------------------------------'."\n\n";
		
		if($aCustomer['luisteraar'] != "") {
			$sMessage .= 'Echt gaaf dat '.$aCustomer['luisteraar'].' je heeft geattendeerd om te doneren aan Pinguin Radio! We zijn hem erg dankbaar!'."\n";
		}
		$sMessage .= 'Je hebt aangegeven dat je '.$aCustomer['bedankt'].' op onze bedanktlijst wilt komen.'."\n\n";

		
		$sMessage .= 'Bedankt voor je donatie en je steun aan Pinguinradio.'."\n\n";
		
		$sMessage .= 'Met vriendelijke groet,'."\n\n";
		$sMessage .= 'PinguinRadio'."\n";
		
		$sMailto  = trim($aCustomer['email']);
		$sSubject = 'Donatie PinguinRadio';
		$sHeaders = 'From: noreply@pinguinradio.com' . "\r\n";
		$sBcc			=	'Bcc: hplvandermeer@planet.nl' . "\r\n";
		
		if ($sMailto != '') {
			mail($sMailto, $sSubject, $sMessage, $sHeaders, $sBcc);
		}
		unset($_SESSION['msp_order']);
	}
?>
<?php elseif (isset($_GET['order']) && $_GET['order'] == 'cancel') : unset($_SESSION['msp_order']); ?>
	<h1>Donatie geannuleerd</h1>
	<p>Je hebt je donatie geannuleerd. Niet de bedoeling? Je kan hier onder gewoon opnieuw proberen.<br/><br/></p>
<?php elseif (isset($_POST) && isset($_POST['order']) && !$bProcessOrder) : ?>
	<p>Er ging iets niet goed bij je donatie.</p>
	<?php if (count($aErrors) > 0): ?>
	<ul>
		<?php foreach($aErrors as $sError) : ?>
		<li><?php echo $sError;?></li>
		<?php endforeach;?>
	</ul>
	<?php endif;?>
<?php endif;?>

<?php
if (isset($_SESSION['local_order'])) {
	$sNaam = $_SESSION['local_order']['naam'];
	$sAdres = $_SESSION['local_order']['adres'];
	$sPostcode = $_SESSION['local_order']['postcode'];
	$sPlaats = $_SESSION['local_order']['plaats'];
	$sLand = $_SESSION['local_order']['land'];
	$sEmail = $_SESSION['local_order']['email'];
	$sTelefoon = $_SESSION['local_order']['telefoon'];
	$sLuisteraar = $_SESSION['local_order']['luisteraar'];
	$sBedankt = $_SESSION['local_order']['bedankt'];
	$iAmount = $_SESSION['local_order']['amount'];
}
?>

	<div id="doneer">
	<form id="donateform" method="post">
		<input type="hidden" name="order" value="1" />
		<p>Ik steun PinguinRadio en doneer:</p>
		<div class="amountContainer">
			<span>&euro; </span><input type="text" name="amount" value="<?php echo $iAmount;?>" /><span>,-</span>
			<div class="clear"></div>
		</div>
		
		<div id="order">
			<ol>
				<li>
					<label>Naam:<span>*</span></label>
					<input type="text" name="naam" value="<?php echo $sNaam;?>" />
				</li>
				<!--<li>
					<label>Adres:<span>*</span></label>
					<input type="text" name="adres" value="<?php echo $sAdres;?>" />
				</li>-->
				<li>
					<label>Postcode:<span>*</span></label>
					<input type="text" name="postcode" value="<?php echo $sPostcode;?>" class="postcode" />
				</li>
				<li>
					<label>E-mailadres:<span>*</span></label>
					<input type="text" name="email" value="<?php echo $sEmail;?>" />
				</li>
				<li style="border-top: 1px dotted #999; padding: 10px 0 5px 0; margin:19px 0 0 0; font-size:12px">
					<label style="width:360px;">Deze luisteraar heeft mij op het idee gebracht om ook te doneren:</label>
					<input style="margin: 0 0 5px 120px" type="text" name="luisteraar" value="<?php echo $sLuisteraar;?>" />
				</li>
				<li>
					<label style="float:left; margin: 0 0 0 60px;">Plaats mij</label>
					<select style="float:left; margin: 0 0 0 -60px;" name="bedankt">
						<option value="wel" <?php if ($sBedankt == 'wel') :?>selected="selected"<?php endif;?>>Wel</option>
						<option value="niet" <?php if ($sBedankt == 'niet') :?>selected="selected"<?php endif;?>>Niet</option>
					</select>
					<label style="float:left;">&nbsp;op de bedanktlijst!</label>
				</li>
				<!--<li>
					<label>Telefoonnummer:<span>*</span></label>
					<input type="text" name="telefoon" value="<?php echo $sTelefoon;?>" />
				</li>-->
				<li class="next">
					<input type="submit" value="Volgende stap" class="submit" />
				</li>
			</ol>
		</div>
		<p>* = verplicht</p>
		
		<input type="hidden" name="adres" value="Stationsstraat 23-25" />
		<input type="hidden" name="plaats" value="Bergen op Zoom" />
		<input type="hidden" name="land" value="nl" />
		<input type="hidden" name="telefoon" value="0164-210240" />
	</form>
</div>

		
		
					
		</article>
				
			<?php get_sidebar('right'); ?>
		</section><!-- #content -->

<?php get_footer(); ?>