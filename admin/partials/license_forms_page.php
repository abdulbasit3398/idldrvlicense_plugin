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
.idltable_bodyh2 {
    font-size: 42px;
    padding: 4px 0 6px 0;
    text-align: center;
    font-weight: 600;
}
.idltable_a{
    padding: 10px 20px 10px 20px;
    background: white;
    color: green;
}
  </style>
  <h2 class="idltable_bodyh2">License forms</h2>
<form class="idluppaymentclass" method="post" action="<?php menu_page_url('idl-froms-cities_import') ?>" target="">
  <select name="idluppayment" id="idluppayment">  
    <option value="unpaid" >unpaid</option>
    <option value="paid" selected>paid</option>
  </select>
  <select name="idluphpayment" id="idluphpayment">  
    <option value="handled" selected>handled</option>
    <option value="unhandled">unhandled</option>
  </select>
  <input class="idltable_handled_paid" name="idltable_handled_paid" type="submit" value="submit">
</form>
  <table class="idltable">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone #</th>
      <th>Postcode</th>
      <th>city</th>
      <th>House #</th>
      <th>DOB</th>
      <th>Preferred Day</th>
      <th>Preferred Time</th>
      <th>Order Date & Time</th>
      <th>rijbewijs</th>
      <th>id_kaart</th>
      <th>paspoort</th>
      <th>id_4</th>
      <th>id_5</th>
      <th>id_6</th>
      <th>id_7</th>
      <th>id_8</th>
      <th>id_9</th>
      <th>Payment</th>
      <th>Status</th>
      <th class="idltable_a">Actions</th>
    </tr>
    <?php
    foreach ($forms_data as $key => $value) {?>
      <tr>
        <td><?php echo $value->first_name;?></td>
        <td><?php echo $value->last_name; ?></td>
        <td><?php echo $value->email; ?></td>
        <td><?php echo $value->phone_number; ?></td>
        <td><?php echo $value->postcode; ?></td>
        <td><?php echo $value->city; ?></td>
        <td><?php echo $value->house_number; ?></td>
        <td><?php 
                  if ($value->dob==0) {
                    echo "";
                  }
                  else{
                    echo $value->dob;
                  }
             ?>      
        </td>
        <td><?php echo $value->preferred_day; ?></td>
        <td><?php echo $value->preferred_time; ?></td>
        <td><?php echo $value->date_upated; ?></td>
        <td><?php echo $value->rijbewijs; ?></td>
        <td><?php echo $value->id_kaart; ?></td>
        <td><?php echo $value->paspoort; ?></td>
        <td><?php echo $value->id_4; ?></td>
        <td><?php echo $value->id_5; ?></td>
        <td><?php echo $value->id_6; ?></td>
        <td><?php echo $value->id_7; ?></td>
        <td><?php echo $value->id_8; ?></td>
        <td><?php echo $value->id_9; ?></td>
        <td><span class="idl<?php echo $value->payment;?>"><?php echo $value->payment; ?></span></td>
        <td><span class="idl<?php echo $value->status;?>"><?php echo $value->status; ?></span></td>
        <td><a href="<?php menu_page_url('idl-froms-cities_import') ?>&ad_id=<?php echo $value->id; ?>">edit</a> / <a class="sure_deleteclass" href="<?php menu_page_url('idl-froms-cities_import') ?>&del_id=<?php echo $value->id; ?>">delete</a></td>
      </tr>
  <?php }?>
  </table>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: left;">
      <?php 
        $page_links = paginate_links( array(
          'base' => add_query_arg( 'pagenum', '%#%' ),
          'format' => '',
          'prev_text' => __( '&laquo;', 'text-domain' ),
          'next_text' => __( '&raquo;', 'text-domain' ),
          'total' => $num_of_pages,
          'current' => $pagenum
      ) );

      if ( $page_links ) {
          echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
      }
        ?>
      </td>
    </tr>
  </table>