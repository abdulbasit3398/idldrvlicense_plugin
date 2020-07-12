<?php

class IdlModel
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
        $this->license_columns = "first_name,last_name,email, dob,phone_number, postcode, house_number, dob, preferred_day, preferred_time";
        $this->cities_columns = "city,zipcode";
    }

    public function generate_id($attr) {
        global $wpdb;
        $wpdb->insert($this->tbl_license, $attr);
        return $wpdb->insert_id;
    }

	public function get_license($id)
    {
        global $wpdb;
        $id = (int)$id;
        $query = "SELECT * FROM $this->tbl_license WHERE id = $id";
        $center = $wpdb->get_row($query);
        return $center;
    }

	public function insert_mollie_order_id($mollieid, $orderid) {
        global $wpdb;
		$data = array('mollie_id' => $mollieid);
		$where = array('id' => $orderid);
		$wpdb->update($this->tbl_license ,$data,$where);
            
    }

    public function change_payment_status($status, $orderid) {
        global $wpdb;
        $orderid = (int)$orderid;
        if($orderid)
        {
            $data = array('payment' => $status);
            $where = array('id' => $orderid);
            $wpdb->update($this->tbl_license ,$data,$where);
        }
            
    }

    public function savelicense($data, $where) {
        global $wpdb;
        $wpdb->update($this->tbl_license ,$data,$where);
        if($wpdb->last_error !== '')
            return json_encode(array('msg' => 'error','error'=>$wpdb->print_error()));
        else
            return  json_encode(array('msg' => 'success','review_id' => $where));
    }

	public function get_unpaid_license() {
        global $wpdb;
        $query = "SELECT id,mollie_id FROM $this->tbl_license where payment = 'unpaid'";
        $licenses = $wpdb->get_results($query);
        return $licenses;

    }

    public function getformdata($id) {
        global $wpdb;
        $id = (int)$id;
        $query = "SELECT * FROM $this->tbl_license Where id = ".$id;
        return $wpdb->get_row($query);

    }

    public function formexist($id) {
        global $wpdb;
        $id = (int)$id;
		$query = "SELECT COUNT(id) FROM $this->tbl_license Where id = ".$id;
        return $wpdb->get_var($query);

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

    public function update_review($data, $where)
    {
        global $wpdb;
        $wpdb->update($this->tbl_reviews,$data,$where);
        if($wpdb->last_error !== '')
            return json_encode(array('msg' => 'error','error'=>$wpdb->print_error()));
        else
            return  json_encode(array('msg' => 'success','review_id' => $where));
    }

    public function load_reviews()
    {
        global $wpdb;
         $reviews = $wpdb->get_results("SELECT * from $this->tbl_reviews where status = 'approved' ");
        
        if(sizeof($reviews) > 0)
        {
            $reviews_wd_images = array();
            foreach($reviews as $review)
            {
                if($images = $this->get_images($review->id))
                {
                    $imgs = '';
                    foreach($images as $img)
                      $imgs .= "<div class='col-xs-4 cell'><div class='page-gallery-thumbnail'><a href='#'><img src='".plugins_url('images/'.$img->image, dirname(__FILE__ ))."'></a></div></div>";
                
                      $review->images = $imgs;
                }
                else 
                    $review->images = '';

                $reviews_wd_images[] = $review;
            }
            return $reviews_wd_images;
        }
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