<?php

class IdlModelAdmin
{
    public $string;
    public $tbl_singup;
    public $tbl_centers;
    public $tbl_dsa;

    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    private $conn;
    private $columns;
    private $tbl_cities;
    public function __construct(){
        global $wpdb; 
        $this->tbl_license= $wpdb->prefix."licenses_data";
        $this->tbl_cities= $wpdb->prefix."licenses_cities";
        $license_froms = array("id","first_name","last_name","email","phone_number","postcode","house_number","dob","preferred_day","preferred_time","status");
        $this->license_columns = implode(',', $license_froms);
        $cities_col = array("id","city","zipcode");
        $this->cities_columns = implode(',', $cities_col);
        $new_license_froms = array("$this->tbl_license.id","$this->tbl_license.first_name","$this->tbl_license.last_name","$this->tbl_license.email","$this->tbl_license.phone_number","$this->tbl_license.postcode","$this->tbl_license.house_number","$this->tbl_license.dob","$this->tbl_license.preferred_day","$this->tbl_license.preferred_time","$this->tbl_license.status","$this->tbl_license.date_upated","$this->tbl_license.payment","$this->tbl_license.rijbewijs","$this->tbl_license.id_kaart","$this->tbl_license.paspoort","$this->tbl_license.id_4","$this->tbl_license.id_5","$this->tbl_license.id_6","$this->tbl_license.id_7","$this->tbl_license.id_8","$this->tbl_license.id_9","$this->tbl_cities.city");
        $this->new_license_columns = implode(',', $new_license_froms);
    }

    public function get_licenses_cities($offset, $limit){
        global $wpdb;
        $query = "SELECT $this->cities_columns FROM $this->tbl_cities LIMIT $offset, $limit";
        $cities = $wpdb->get_results($query);
        return $cities;
    }

    public function totalcities() {
        global $wpdb;
       return $wpdb->get_var( "SELECT COUNT(`id`) FROM ".$this->tbl_cities );
    }

    public function license_exist($id) {
        $id = (int)$id;
        global $wpdb;
        return  $wpdb->get_row( "SELECT * FROM ".$this->tbl_license.' where id = '.$id );
        
    }

    public function get_licenses_citiesbyid($id){
        global $wpdb;
        $query = "SELECT $this->cities_columns FROM $this->tbl_cities where id='$id' " ;
        $cities = $wpdb->get_row($query);
        return $cities;
    }

    public function update_licenses_city_data($data, $where){
        global $wpdb;
        $wpdb->update($this->tbl_cities ,$data,$where);
    }

    public function insert_licenses_city_data($data){
        global $wpdb;
        $wpdb->insert($this->tbl_cities, $data);
    }

    public function delete_licenses_city_data($where){
        global $wpdb;
        $wpdb->delete($this->tbl_cities ,$where);
    }




    public function get_licenses_forms_data($offset, $limit, $payment, $pstatus){
        global $wpdb;
        /*$query = "SELECT $this->license_columns FROM $this->tbl_license where status='handled' || status='unhandled' LIMIT $offset, $limit";*/
        echo $query = "SELECT $this->new_license_columns FROM $this->tbl_license LEFT JOIN $this->tbl_cities ON  SUBSTRING($this->tbl_license.postcode, 1, 4) = $this->tbl_cities.zipcode where status='$pstatus' AND payment='$payment'  GROUP BY $this->tbl_license.id LIMIT $offset,$limit";

        $forms_data = $wpdb->get_results($query);
        return $forms_data;
    }

    public function totallisencefroms() {
        global $wpdb;
       return $wpdb->get_var( "SELECT COUNT(`id`) FROM ".$this->tbl_license );
    }

    public function get_licenses_forms_data_byid($id){
        global $wpdb;
        /*$query = "SELECT $this->license_columns FROM $this->tbl_license where id='$id' " ;*/
        //$query = "SELECT $this->license_columns FROM $this->tbl_license where id='$id' " ;
        $query = "SELECT $this->new_license_columns FROM $this->tbl_license LEFT JOIN $this->tbl_cities ON SUBSTRING($this->tbl_license.postcode, 1, 4) = $this->tbl_cities.zipcode where $this->tbl_license.id='$id' ";
        $forms_data = $wpdb->get_row($query);
        return $forms_data;
    }

    public function update_licenses_forms_data($data, $where){
        global $wpdb;
        $wpdb->update($this->tbl_license ,$data,$where);
    }

     public function delete_licenses_forms_data($where){
        global $wpdb;
        $wpdb->delete($this->tbl_license ,$where);
    }



    public function generate_id() {
        global $wpdb;
        $wpdb->insert($this->tbl_license, array('first_name'=>''));
        return $wpdb->insert_id;
    }

    public function savelicense($data, $where) {
        global $wpdb;
        $wpdb->update($this->tbl_license ,$data,$where);
        if($wpdb->last_error !== '')
            return json_encode(array('msg' => 'error','error'=>$wpdb->print_error()));
        else
            return  json_encode(array('msg' => 'success','review_id' => $where));
    }
    
    private function user_exists_dsa($email)
	{
        $this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		$sql = "SELECT email FROM $this->tbl_dsa where email = '$email'";
		$result = mysqli_query($this->conn, $sql);
		if ($result->num_rows > 0)
			return true;
		else
			return false;

    }

    public function centers()
    {
        global $wpdb;
        $query = "SELECT * FROM $this->tbl_centers";
        $centers = $wpdb->get_results($query);
        if(sizeof($centers))
            return $centers;
        else
            return false;
    }
    
    public function get_center($id)
    {
        global $wpdb;
        $id = (int)$id;
        $query = "SELECT * FROM $this->tbl_centers WHERE ID = $id";
        $center = $wpdb->get_row($query);
        return $center;
    }
	
    public function savetodsa($data, $email ='')
    {
        $this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname) or die(mysqli_connect_error());
		$conditions = [];
		foreach ($data as $column => $value) {
            if(in_array($column,$this->columns))
            {
                          if($column == 'earlier_than')
                          {
                            $value = date('Y-m-d',strtotime($value));
                          }
			    $conditions[] = "`{$column}` = '{$value}'";
            }
		}
    
		$conditions = implode(',', $conditions);
		
		if($this->user_exists_dsa($email))
          $sql = "Update ".$this->tbl_dsa." SET {$conditions} where email = '{$email}'";
        else
          $sql = "Insert into ".$this->tbl_dsa." SET {$conditions}";
            
		if(mysqli_query($this->conn, $sql))
			return true;
		else {
		    echo mysqli_error($con);
			return false;
		}
    }

    public function save_user($data,$format)
    {
        global $wpdb;        
        $wpdb->replace($this->tbl_singup,$data,$format);
        if($wpdb->last_error !== '')
            return false;
        else
            return  $wpdb->insert_id;
    }

    public function update_user($data, $where)
    {
        global $wpdb;        
        $wpdb->update($this->tbl_singup, $data, $where);
        if($wpdb->last_error !== '')
            echo json_encode(array('msg' => 'error','error'=>$wpdb->print_error()));
        else
            return  json_encode(array('msg' => 'success','review_id' => $where));
    }

    public function get_user_wd_key($key)
    {
        global $wpdb;
        $user = $wpdb->get_row("SELECT * from $this->tbl_singup where activation_key =  '$key' and activated IS NULL");
        if(sizeof($user) > 0)
            return $user;
        else
            return false;
    }

    public function get_settings()
	{
		global $wpdb;
		$settings = $wpdb->get_results(
		                "SELECT * FROM " . $this->tbl_settings
	            , OBJECT);
		if(sizeof($settings) > 0)
			return $settings;
		else
			return false;
	}
}