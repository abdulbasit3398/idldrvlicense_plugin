<?php

class Idldrvlicense_Public {

	private $plugin_name;
	private $version;
	private $model;
	public $images;
	public $preferred_day;
	public $preferred_time;
	private $mollie;
	private $apikey;

	public function __construct( $plugin_name, $version ) {

		$this->preferred_day = array( "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag");
		$this->preferred_time = array("9-10", "10-11", "11-12", "12-13", "13-14", "14-15", "15-16", "16-17");
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->apikey = get_option('idl_apikey_cofiguration');
		include 'includes/front_model.php';
		$this->model = new IdlModel();
		$this->images = plugin_dir_url( __FILE__ )."/images/";

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/idldrvlicense-public.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name.'validation', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'notify', plugin_dir_url( __FILE__ ) . 'js/notify.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'cookie', plugin_dir_url( __FILE__ ) . 'js/jquery.cookie.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'easing', plugin_dir_url( __FILE__ ) . 'js/jquery.easing.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'masking', plugin_dir_url( __FILE__ ) . 'js/jquery.inputmask.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'multiselect', plugin_dir_url( __FILE__ ) . 'js/jquery.multiselect.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'calendar', plugin_dir_url( __FILE__ ) . 'js/jquery.datepicker.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'calendar-lang', plugin_dir_url( __FILE__ ) . 'i18n/datepicker.zh-CN.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/idldrvlicense-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'idlajax' , array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'site_url'=> site_url() ) );

	}

	public function translate($lang) {
		if($lang == 'en')
		{
			define('FIRSTNAME', 'First Name');
			define('LASTNAME', 'Last Name');
			define('EMAIL', 'Email');
			define('PHONENUMBER', 'Phone#');
			define('POSTCODE', 'PostCode');
			define('HOUSENUMBER', 'House#');
			define('PREFERREDDATE', 'preferred date');
			define('PREFERREDTIME', 'preferred time');
			define('DOB', 'DOB');
		}
		else {
			define('FIRSTNAME', 'VOORNAAM');
			define('LASTNAME', 'ACHTERNAAM');
			define('EMAIL', 'EMAILADRES');
			define('PHONENUMBER', 'TELEFOONNUMMER');
			define('POSTCODE', 'POSTCODE');
			define('HOUSENUMBER', 'HUISNUMMER');
			define('PREFERREDDATE', 'VOORKEURSDAG(EN)');
			define('PREFERREDTIME', 'VOORKEURSTIJDSTIP(PEN)');
			define('DOB', 'GEBOORTEDATUM');
		}

	}

	public function loadlicenseform($attr) {
		if(isset($_GET['idllast'])) { ?>
		<script> 
			var goto3 = true; 
		</script>
		<?php } else { ?>
			<script> 
				var goto3 = false; 
			</script>
		<?php }
		$value = shortcode_atts( array(
			'rijbewijs' => '',
			'id_kaart' => '',
			'paspoort' => '',
			'id_4' => '',
			'id_5' => '',
			'id_6' => '',
			'id_7' => '',
			'id_8' => '',
			'id_9' => '',
			'dob' => 'NULL',
		), $attr );


		$this->translate('de');
		$images = $this->images;
		$license = '';
		if(isset($_COOKIE['idlhandle'])){
			$id = $_COOKIE['idlhandle'];
			$form = $this->model->formexist($id);
			if($form) {
				$license = $this->model->getformdata($id);
			}
			else {
				$id = $this->model->generate_id($value);
			}
				
		}			
		else{
			$id = $this->model->generate_id($value);
		}

		ob_start();
			include 'partials/license_form.php';
			$content = ob_get_contents();
		ob_end_clean();
		return $content;
		exit;
	}

	public function savelicense() {
		$first_name = sanitize_text_field($_POST['first_name']);
		$last_name = sanitize_text_field($_POST['last_name']);
		$email = sanitize_text_field($_POST['email']);
		$phone_number = sanitize_text_field($_POST['phone_number']);
		$postcode = sanitize_text_field($_POST['postcode']);
		$house_number = sanitize_text_field($_POST['house_number']);
		$dob = sanitize_text_field($_POST['dob']);
		$dob = ($dob) ? date('Y-m-d', strtotime(str_replace('/', '-', $dob))) : 'NULL';
		$preferred_day = sanitize_text_field($_POST['prefdat']);
		/*$preferred_time = sanitize_text_field($_POST['preferred_time']);*/
		/*$preferred_time = sanitize_text_field($_POST['preferred_time']);*/
		$preferred_time = sanitize_text_field($_POST['preftime']);
		$status = 'unhandled';

		$data = array('first_name'=> $first_name,'last_name'=> $last_name,'email'=> $email,'phone_number'=> 
						$phone_number,'postcode'=> $postcode,'house_number'=> $house_number,
						'dob'=> $dob,'preferred_day'=> $preferred_day,'preferred_time'=> $preferred_time, 'status'=> $status);
		$where  = array('id' => $_POST['dataid']);
		echo $this->model->savelicense($data, $where);
		exit;
	}

	public function paynow() {

			$first_name = sanitize_text_field($_POST['first_name']);
			$last_name = sanitize_text_field($_POST['last_name']);
			$email = sanitize_text_field($_POST['email']);
			$phone_number = sanitize_text_field($_POST['phone_number']);
			$postcode = sanitize_text_field($_POST['postcode']);
			$house_number = sanitize_text_field($_POST['house_number']);
			$dob = sanitize_text_field($_POST['dob']);
			$dob = date('Y-m-d', strtotime($dob));

			$price = number_format(get_option('idl_price_cofiguaration'), 2);
			$orderId = $_POST['dataid'];
			$vat = 21;
			$vatAmount = $price * ($vat / (100 + $vat));
			$vatAmount = number_format($vatAmount, 2);
			$siteurl = site_url();
			if($this->initializeMollie()) {
				$mollie = $this->mollie;
			
			try {
				
				$order = $mollie->orders->create(["amount" => 
														["value" => $price, 
														"currency" => "EUR"
														], 
												"billingAddress" => [
														"streetAndNumber" => $house_number, 
														"postalCode" => $postcode, 
														"city" => "Amsterdam", 
														"country" => "nl", 
														"givenName" => $first_name .' '.$last_name, 
														"familyName" => "Skywalker", 
														"email" => $email], 
														"consumerDateOfBirth" => $dob, 
														"locale" => "en_US",
														"redirectUrl"=> $siteurl."/?mollie=".$this->encrypt_decrypt('encrypt',$orderId),
														"webhookUrl"=> $siteurl."/?molliepagemt=done",
														"orderNumber" => strval($orderId), 
														"lines" => [[
															"name" => "License Booking", 
															"quantity" => 1, 
															"vatRate" => $vat, 
															"unitPrice" => ["currency" => "EUR", "value" => $price], 
															"totalAmount" => ["currency" => "EUR", "value" => $price], 
															"vatAmount" => ["currency" => "EUR", "value" => $vatAmount]], 
														]]);

				$this->model->insert_mollie_order_id($order->id, $orderId);
				echo json_encode(array('status'=>'success', 'url' => $order->getCheckoutUrl()));
				exit;
			} catch (\Mollie\Api\Exceptions\ApiException $e) {
				echo json_encode(array('status'=>'error', 'error' => htmlspecialchars($e->getMessage())));
				exit;
			}
			}
		}

		public function molliewebhook() {
			if(isset($_GET['mollie']))
			{
				$oid = $this->encrypt_decrypt('decrypt', sanitize_text_field($_GET['mollie']));
				$lorder = $this->model->get_license($oid);
				if($this->initializeMollie()) {
					$mollie = $this->mollie;
						try {

							$mollie_id = $lorder->mollie_id;
							$orderId = $lorder->id;
							$orderId = $this->encrypt_decrypt('decrypt',$lorder->id);
							$order = $mollie->orders->get($mollie_id);

							if ($order->isPaid() || $order->isCompleted() || $order->isAuthorized()) {
								$this->model->change_payment_status('paid',$orderId );
								wp_redirect(site_url().'/bevestiging-rijbewijs/');
								exit;
							} elseif ($order->isCanceled() || $order->isExpired()) {
								$this->model->change_payment_status('canceled',$orderId );
								wp_redirect(site_url().'/rijbewijs-aanvragen/?idllast=true');
								exit;
							} elseif ($order->isPending()) {
								$this->model->change_payment_status('unpaid',$orderId );
								wp_redirect(site_url().'/rijbewijs-aanvragen/?idllast=true');
								exit;
							}
							else {
								$this->model->change_payment_status('failed',$orderId );
								wp_redirect(site_url().'/rijbewijs-aanvragen/?idllast=true');
								exit;
							}
						} catch (\Mollie\Api\Exceptions\ApiException $e) {
							$pluginlog = plugin_dir_path(__FILE__).'debug.log';
							error_log($e->getMessage(), 3, $pluginlog);
						}
				}

			}
			else {
				$unpaids = $this->model->get_unpaid_license();
				if($this->initializeMollie()) {
					$mollie = $this->mollie;
					foreach($unpaids as $unpaid) {
						try {

							$mollie_id = $unpaid->mollie_id;
							$orderId = $unpaid->id;
							$order = $mollie->orders->get($mollie_id);

							if ($order->isPaid() || $order->isAuthorized()) {
								$this->model->change_payment_status('paid',$orderId );
							} elseif ($order->isCanceled()) {
								$this->model->change_payment_status('canceled',$orderId );
							} elseif ($order->isExpired()) {
								$this->model->change_payment_status('canceled',$orderId );
							} elseif ($order->isCompleted()) {
								$this->model->change_payment_status('paid',$orderId );
							} elseif ($order->isPending()) {
								$this->model->change_payment_status('unpaid',$orderId );
							}
						} catch (\Mollie\Api\Exceptions\ApiException $e) {
							$pluginlog = plugin_dir_path(__FILE__).'debug.log';
							error_log($e->getMessage(), 3, $pluginlog);
						}
					}
				}
			}
			
		}

		private function initializeMollie () {
			if($this->apikey) {
				include "mollie/vendor/autoload.php";
				$this->mollie = new \Mollie\Api\MollieApiClient();
				$this->mollie->setApiKey($this->apikey);
				return true;
			}
			else	
				return false;
		}

		public function encrypt_decrypt($action, $string) 
		{
			$output = false;
			$encrypt_method = "AES-256-CBC";
			$secret_key = 'idlxxxxxxxxxxxxxxxbridge';
			$secret_iv = 'bridgexxxxxxxxxxxxxxxxidl';
			// hash
			$key = hash('sha256', $secret_key);    
			// iv - encrypt method AES-256-CBC expects 16 bytes 
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			if ( $action == 'encrypt' ) {
				$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
				$output = base64_encode($output);
			} else if( $action == 'decrypt' ) {
				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}
			return $output;
		}

}
