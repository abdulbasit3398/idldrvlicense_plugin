<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Link_List_Table extends WP_List_Table {

    /**
     * Constructor, we override the parent to pass our own arguments
     * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
     */
    function __construct() {
        parent::__construct( array(
            'singular'=> 'wp_list_text_link', //Singular label
            'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
            'ajax'   => false //We won't support Ajax for this table
            ) );
    }

    function extra_tablenav( $which ) {
        if ( $which == "top" ){
           //The code that goes before the table is here
           echo"Hello, I'm before the table";
        }
        if ( $which == "bottom" ){
           //The code that goes after the table is there
           echo"Hi, I'm after the table";
        }
     }

     function get_columns() {
        return $columns= array(
           'col_link_id'=>__('ID'),
           'col_link_user_login'=>__('City'),
           'col_link_user_email'=>__('Zipcode')
        );
     }

     public function get_sortable_columns() {
        return $sortable = array(
           'col_link_id'=>'city',
           'col_link_user_login'=>'zipcode',
           'col_link_user_email'=>'link_visible'
        );
     }


     function prepare_items() {

        $example_data = array(
                array(
                        'id'        => 1,
                        'user_login'     => 'vasim',
                        'user_email'    => 'vasim@abc.com'                        
                ),
                array(
                        'id'        => 2,
                        'user_login'     => 'Asma',
                        'user_email'    => 'Asma@abc.com'                        
                ),
                array(
                        'id'        => 3,
                        'user_login'     => 'Nehal',
                        'user_email'    => 'nehal@abc.com'                        
                ),
            );

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $example_data;
    }

}