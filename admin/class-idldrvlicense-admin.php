<?php

$model;
class Idldrvlicense_Admin {

	private $version;
	public $wp_list_table;
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		include 'includes/front_model.php';
		$this->model = new IdlModelAdmin();
		$this->preferred_day = array( "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag");
		$this->preferred_time = array("9-10", "10-11", "11-12", "12-13", "13-14", "14-15", "15-16", "16-17");
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/idldrvlicense-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/idldrvlicense-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function idl_license_cities_menu()
	{
		if (function_exists('add_menu_page')) {
			add_menu_page(__('IDL License', 'idl-froms-cities'),
				__('IDL License', 'idl-froms-cities'), 'manage_options', 'idl-froms-cities',
				array($this, 'cities_mangment'), 'dashicons-backup');
		}
		if (function_exists('add_submenu_page')) {
			add_submenu_page('idl-froms-cities', __('Cities management', 'idl-froms-cities'),
				__('Cities management', 'idl-froms-cities'), 'manage_options', 'idl-froms-cities',
				array($this, 'cities_mangment'));

			add_submenu_page('idl-froms-cities', __('License forms', 'idl-froms-cities'),
				__('License forms', 'idl-froms-cities'), 'manage_options', 'idl-froms-cities_import',
				array($this, 'license_froms'));

			add_submenu_page('idl-froms-cities', __('Cofiguration', 'idl-froms-cities'),
				__('Configuration', 'idl-froms-cities'), 'manage_options', 'idl-cities_Cofiguration',
				array($this, 'idl_Cofiguration'));
		}
	}

	public function idl_lisenceforms_register_settings() {
		add_option( 'idl_lisenceforms_options_group', 'This is my option value.');
		register_setting( 'idl_lisenceforms_options_group', 'idl_enable_delivery','delivery_callback' );
		register_setting( 'idl_lisenceforms_options_group', 'idl_required_delivery','delivery_callback' );
		register_setting( 'idl_lisenceforms_options_group', 'idl_disable_virtual','delivery_callback' );
		register_setting( 'idl_lisenceforms_options_group', 'idl_price_cofiguaration','delivery_callback' );
		register_setting( 'idl_lisenceforms_options_group', 'idl_apikey_cofiguration','delivery_callback' );

		register_setting( 'idl_lisenceforms_options_group', 'algemene_voorwaarden_link','delivery_callback' );
		register_setting( 'idl_lisenceforms_options_group', 'privacy_policy_link','delivery_callback' );
		register_setting( 'idl_lisenceforms_options_group', 'idl_custom_link','delivery_callback' );
	}
	public function test()
	{
		echo 'sdvvd';
	}
	public function idl_Cofiguration() {
		?>
		<h2>Idl Price & Api Key Configuaration</h2>
		<div class="SettingDetails" >
			<div class="PluginSettings">
			<form method="post" action="options.php">
			<?php settings_fields( 'idl_lisenceforms_options_group' ); ?>
				<table class="form-table">
				  <tbody>
						<tr>
						<th><label for="Day_Delivery">Price</label></th> 
						<td>
							<div class="onoffswitch"> 
								<input name="idl_price_cofiguaration" type="text" class="input_text" value="<?php $title = get_option('idl_price_cofiguaration'); if(empty($title)){ echo ""; }else{echo $title; }?>">
							</div>  
						</td>
						</tr>
						<tr>
						<th><label for="Day_Delivery">API Key</label></th> 
						<td>
							<div class="onoffswitch"> 
								<input name="idl_apikey_cofiguration" type="text" class="input_text" value="<?php $title_option = get_option('idl_apikey_cofiguration'); if(empty($title_option)){ echo ""; }else{echo $title_option; }?>">
							</div> 			
						</td>
						</tr>


						<tr>
						<th><label for="Day_Delivery">algemene voorwaarden link</label></th> 
						<td>
							<div class="onoffswitch"> 
								<input name="algemene_voorwaarden_link" type="text" class="input_text" value="<?php $title_option = get_option('algemene_voorwaarden_link'); if(empty($title_option)){ echo "#"; }else{echo $title_option; }?>">
							</div> 			
						</td>
						</tr>
						<tr>
						<th><label for="Day_Delivery">privacy policy link</label></th> 
						<td>
							<div class="onoffswitch"> 
								<input name="privacy_policy_link" type="text" class="input_text" value="<?php $title_option = get_option('privacy_policy_link'); if(empty($title_option)){ echo "#"; }else{echo $title_option; }?>">
							</div> 			
						</td>
						</tr>
					
				  </tbody>
				</table>
			  <?php  submit_button(); ?>
			</form>
			</div>
			<!--  -->
		</div>
		<?php 
	}

	public function send_email() {
		if(isset($_GET['molliepayemt'])) {
			get_header();
			$orderid = (int)$_GET['orderid'];
			$order = $this->model->license_exist($orderid);
			if(sizeof($order)) {
				//send email
				ob_start();
				include 'partials/email_payment.php';
				$email = ob_get_contents();
				ob_end_clean();
				wp_mail($order->email, 'Payment Done', $email); ?>
				<div style="width: 100%;text-align: center;">Tanks for your payment.</div>
			<?php }
			else {
				
				?>
				<div style="width: 100%;text-align: center;">Sorry no order found</div>
				<?php
			}
			get_footer();
			exit;

		}
	}

	public function cities_mangment() {
		
		$list = true;
		if(isset($_GET['add_new_city'])) {
			include_once 'partials/lisence_form_cities.php';
			exit;
		}

		if(!empty($_POST['id']) && !empty($_POST['city']) && !empty($_POST['zipcode']) ){
			$ad_id = intval($_POST['id']);
			$ad_city = sanitize_text_field($_POST['city']);
			$ad_zipcode = sanitize_text_field($_POST['zipcode']);
			$data = array('city'=> $ad_city,'zipcode'=> $ad_zipcode);
			$where  = array('id' => $ad_id);
			echo $this->model->update_licenses_city_data($data, $where);
			$list = true;
		}

		if(empty($_POST['id']) && !empty($_POST['city']) && !empty($_POST['zipcode']) ){
			$ad_city = sanitize_text_field($_POST['city']);
			$ad_zipcode = sanitize_text_field($_POST['zipcode']);
			$data = array('city'=> $ad_city,'zipcode'=> $ad_zipcode);
			$edit = $this->model->insert_licenses_city_data($data);
			$list = true;
		}

		if(isset($_GET['delete_city'])){
			$ad_id = intval($_GET['delete_city']);
			$where  = array('id' => $ad_id);
			$delete = $this->model->delete_licenses_city_data($where);
			$list = true;
		}
		
		if(isset($_GET['ad_id'])){
			$list = false;
			$id = intval($_GET['ad_id']);
			$city = $this->model->get_licenses_citiesbyid($id);
			include_once 'partials/lisence_form_cities.php';
			exit;
		}
		if($list){
			$limit = 20; // number of rows in page
			$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
			$offset = ( $pagenum - 1 ) * $limit;
			$total = $this->model->totalcities();
			$num_of_pages = ceil( $total / $limit );
			$cities = $this->model->get_licenses_cities($offset, $limit);
			include_once 'partials/cities_mangment_page.php';
		}

	}

	public function license_froms(){
		session_start();
			$list = true;
			if(isset($_GET['del_id'])){
				$ad_id = intval($_GET['del_id']);
				$where  = array('id' => $ad_id);
				$delete = $this->model->delete_licenses_forms_data($where);
			}

			


			if(isset($_POST['idledit'])){
				$ad_id = intval($_POST['id']);
				$first_name = sanitize_text_field($_POST['first_name']);
				$last_name = sanitize_text_field($_POST['last_name']);
				$email = sanitize_text_field($_POST['email']);
				$phone_number = sanitize_text_field($_POST['phone_number']);
				$postcode = sanitize_text_field($_POST['postcode']);
				$house_number = sanitize_text_field($_POST['house_number']);
				$dob = sanitize_text_field($_POST['dob']);
				$preferred_day = sanitize_text_field($_POST['preferred_day']);
				$preferred_time = sanitize_text_field($_POST['preferred_time']);
				$payment = sanitize_text_field($_POST['payment']);
				$status = $_POST['status'];
				$data = array('first_name'=> $first_name,'last_name'=> $last_name,'email'=> $email,'phone_number'=> $phone_number,'postcode'=> $postcode,'house_number'=> $house_number,'dob'=> $dob,'preferred_day'=> $preferred_day,'preferred_time'=> $preferred_time,'status'=> $status,'payment'=> $payment);
				$where  = array('id' => $ad_id);
				$edit = $this->model->update_licenses_forms_data($data, $where);
				$list = true;
			}

			////// to open edit form
			if(isset($_GET['ad_id'])){   //to open edit form
				$list = false;
				$id = $_GET['ad_id'];
				$forms_data = $this->model->get_licenses_forms_data_byid($id);
				include_once 'partials/lisence_form_data_edit.php';
				exit;
			}

			if($list){
				$limit = 20; // number of rows in page
				$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
				$offset = ( $pagenum - 1 ) * $limit;
				$total = $this->model->totallisencefroms();
				$num_of_pages = ceil( $total / $limit );
				
				$payment = isset($_SESSION['idluppayment']) ? $_SESSION['idluppayment'] : "paid";
				$pstatus = isset($_SESSION['idluphpayment']) ? $_SESSION['idluphpayment'] : "handled";
				if(isset($_POST['idltable_handled_paid'])){
					$payment = $_SESSION['idluppayment'] =  $_POST['idluppayment'];
					$pstatus = $_SESSION['idluphpayment'] =  $_POST['idluphpayment'];
				}
				
				$forms_data = $this->model->get_licenses_forms_data($offset, $limit, $payment, $pstatus);
				
				include_once 'partials/license_forms_page.php';
			}
			
		}

}
