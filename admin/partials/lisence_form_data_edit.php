<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 40%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }
  .idltable input[type="submit"] {
    background: #4CAF50;
    color: #fff;
    border: 1px solid #4CAF50;
    font-size: 14px;
    padding: 10px 20px 10px 20px;
    font-weight: 600;
}
.idltable input[type="submit"]:hover {
    background: #ffff;
    color: #4CAF50;
    border: 2px solid #4CAF50;
    border-color: #4CAF50 !important;
    font-size: 14px;
    padding: 10px 20px 10px 20px;
    font-weight: 600;
}
  </style>
  <h2>License Forms</h2>
  <table class="idltable">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone #</th>
      <th>Postcode</th>
      
      
    </tr>
    <form method="post" action="<?php menu_page_url('idl-froms-cities_import') ?>" target="">
      <tr>
        <td>
          <input type="hidden" id="id" name="id" value="<?php echo $forms_data->id;?>">
          <input type="text" id="first_name" name="first_name" value="<?php echo $forms_data->first_name;?>">
        </td>
        <td>
          <input type="text" id="last_name" name="last_name" value="<?php echo $forms_data->last_name;?>">
        </td>
        <td>
          <input type="email" id="email" name="email" value="<?php echo $forms_data->email;?>">
        </td>
        <td>
          <input type="text" id="phone_number" name="phone_number" value="<?php echo $forms_data->phone_number;?>">
        </td>
        <td>
          <input type="text" id="postcode" name="postcode" value="<?php echo $forms_data->postcode;?>">
        </td>
        
        
      </tr>
      <tr>
        <th>City</th>
        <th>House #</th>
        <th>DOB</th>
        <th>Preferred Day</th>
        <th>Preferred Time</th>
        
     </tr>
      <tr>
        <td>
          <input type="text" id="city" readonly name="city" value="<?php echo $forms_data->city;?>">
        </td>
        <td>
          <input type="text" id="house_number" name="house_number" value="<?php echo $forms_data->house_number;?>">
        </td>
        <td>
          <input type="date" id="dob" name="dob" value="<?php echo $forms_data->dob;?>">
        </td>
        <td>
          <input type="text" id="preferred_day" name="preferred_day" value="<?php echo $forms_data->preferred_day;?>">
        </td>
        <td>
          <input type="text" id="preferred_time" name="preferred_time" value="<?php echo $forms_data->preferred_time;?>">
        </td>
        
      </tr>
      <tr>
        <th>Order Date & Time</th>
        <th>Payment</th>
        <th>Status</th>
        <th></th>
      </tr>
      <tr>
        <td>
          <input type="text" id="date_upated" readonly name="date_upated" value="<?php echo $forms_data->date_upated;?>">
        </td>
        <td>
            <?php if ($forms_data->payment=="unpaid"){ ?>
                <select name="payment" id="payment">  
                  <option value="unpaid" selected>unpaid</option>
                  <option value="paid">paid</option>
                </select>
            <?php }else{?>
                <select name="payment" id="payment">  
                  <option value="unpaid">unpaid</option>
                  <option value="paid" selected>paid</option>
                </select>
            <?php }?>
        </td>
        <td>
            <?php if ($forms_data->status=="handled"){ ?>
                <select name="status" id="status">  
                  <option value="handled" selected>handled</option>
                  <option value="unhandled">unhandled</option>
                </select>
            <?php }else{?>
                <select name="status" id="status">  
                  <option value="handled">handled</option>
                  <option value="unhandled" selected>unhandled</option>
                </select>
            <?php }?>
        </td>
        <td><input class="idltable_submitforms_class" name="idledit" type="submit" value="submit"></td>
      </tr>
    </form>
  </table>
