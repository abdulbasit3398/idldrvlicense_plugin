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
.idltable_a a {
    padding: 10px 20px 10px 20px;
    background: white;
    color: green;
}
  </style>
  <h2 class="idltable_bodyh2">Cities management</h2>
  <table class="idltable">
    <tr>
      <th>City</th>
      <th>Zipcode</th>
      <th class="idltable_a"><a href="<?php menu_page_url('idl-froms-cities') ?>&add_new_city=add_new_city">Add</a></th>
    </tr>
    <?php
    foreach ($cities as $key => $value) {?>
      <tr>
        <td><?php echo $value->city;?></td>
        <td><?php echo $value->zipcode; ?></td>
        <td><a href="<?php menu_page_url('idl-froms-cities') ?>&ad_id=<?php echo $value->id; ?>">edit</a> / <a class="sure_deleteclass" href="<?php menu_page_url('idl-froms-cities') ?>&delete_city=<?php echo $value->id; ?>">delete</a></td>
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
