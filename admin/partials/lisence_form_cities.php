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
  <h2>License Cities</h2>
  <table class="idltable">
    <tr>
      <th>City</th>
      <th>Zipcode</th>
      <th></th>
    </tr>
    <form method="post" action="<?php menu_page_url('idl-froms-cities') ?>" target="">
      <tr>
        <td>
          <input type="hidden" id="id" name="id" value="<?php echo $city->id;?>">
          <input type="text" id="city" name="city" value="<?php echo $city->city;?>"></td>
        <td><input type="text" id="zipcode" name="zipcode" value="<?php echo $city->zipcode;?>"></td>
        <td><input class="idltable_submitclass" type="submit" value="submit"></td>
      </tr>
    </form>
  </table>

