<?php 

//must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }
   
    echo '<div class="wrap">';
    // header
    echo "<h2>" . __( 'List of images', 'full-window-interactive-slider' ) . "<a class='page-title-action' href='admin.php?page=full-window-interactive-slider'>Add new</a></h2>";

class My_Example_List_Table extends WP_List_Table {

function __construct(){
global $status, $page;
 
parent::__construct( array(
'singular' => __( 'id', 'mylisttable' ), //singular name of the listed records
'plural' => __( 'id', 'mylisttable' ), //plural name of the listed records
'ajax' => false //does this table support ajax?
 
) );
 
add_action( 'admin_head', array( &$this, 'admin_header' ) );
 
}



function process_bulk_action() { 
    if(isset($_REQUEST['id'])){
     $entry_id = ( is_array( $_REQUEST['id'] ) ) ? $_REQUEST['id'] : array( $_REQUEST['id'] );
    //Detect when a bulk action is being triggered... 
        if( 'delete'===$this->current_action() ) { 
            if ( 'delete' === $this->current_action() ) {
                foreach ( $entry_id as $id ) {
                    $this->delete_this($id);
                }
            }
        }
    }
}
function delete_this($id) {
    global $wpdb;
    $id = absint( $id );
    $wpdb->query( "DELETE FROM ".$wpdb->prefix."nt_fwms_slides WHERE id = $id" );
    echo '<div id="message" class="updated notice is-dismissible below-h2"><p>'.__( 'Element deleted', 'full-window-interactive-slider' ).'</p> <button class="notice-dismiss" type="button">
<span class="screen-reader-text">'.__( 'Discard this message', 'full-window-interactive-slider' ).'.</span>
</button></div>';
} 
function admin_header() {
    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'my_list_test' != $page )
    return;
    echo '<style type="text/css">';
    echo '.wp-list-table .column-id { width: 5%; }';
    echo '.wp-list-table .column-nombre { width: 40%; }';
    echo '.wp-list-table .column-formula { width: 35%; }';
    echo '.wp-list-table .column-descripcion { width: 20%;}';
    echo '</style>';
}
 
function no_items() {
    __( 'There are no items in the database.', 'full-window-interactive-slider' );
}
 
function column_default( $item, $column_name ) {
    switch( $column_name ) {
    case 'name':
    case 'ide':
    return $item[ $column_name ];
    default:
    return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
}
}
function get_sortable_columns() {
    $sortable_columns = array(
        'ID' => array('ID',false),
        'name' => array('name',false),
        'ide' => array('ide',false)
    );
    return $sortable_columns;
}
 
function get_columns(){
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __( 'Name', 'full-window-interactive-slider' ),
        'ide' => 'ID'
    );
    return $columns;
}
 
function usort_reorder( $a, $b ) {
    // If no sort, default to title
    $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'name';
    // If no order, default to asc
    $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
    // Determine sort order
    $result = strnatcmp( $a[$orderby], $b[$orderby] );
    // Send final sort direction to usort
    return ( $order === 'asc' ) ? $result : -$result;
}
function get_bulk_actions() {
    $actions = array(
        'delete' => __( 'Delete', 'full-window-interactive-slider' )
    );
    return $actions;
}
function column_cb($item) {
return sprintf(
'<input type="checkbox" name="id[]" value="%s" />', $item['ID']
);
}
function column_name($item) {
return 
'<a href="admin.php?page=full-window-interactive-slider&id='.$item['ID'].'">'.$item['name'].'</a>';
}
function prepare_items() {

global $wpdb;
    $this->process_bulk_action();
    $table_data = array();
    $table_name = $wpdb->prefix."nt_fwms_slides";
    $query = ("SELECT * FROM $table_name");    
    $elements = $wpdb->get_results($query);
    echo $wpdb->last_error;     
    if ( $elements )
{
    foreach ( $elements as $data )
    {
array_push($table_data,
array( 
'ID' => $data->id,
'name' => $data->name,
'ide' => $data->id
)
);  
    }   
}
$columns = $this->get_columns();
$hidden = array();
$sortable = $this->get_sortable_columns();
$this->_column_headers = array( $columns, $hidden, $sortable );
usort( $table_data, array( &$this, 'usort_reorder' ) );
// get the current user ID
$user = get_current_user_id();
// get the current admin screen
$screen = get_current_screen();
// retrieve the "per_page" option
$screen_option = $screen->get_option('per_page', 'option');
// retrieve the value of the option stored for the current user
$per_page = get_user_meta($user, $screen_option, true);
if ( empty ( $per_page) || $per_page < 1 ) {
    // get the default value if none is set
     $per_page = $screen->get_option( 'per_page', 'default' );
}
$current_page = $this->get_pagenum();
$total_items = count( $table_data );
// only ncessary because we have sample data
$this->found_data = array_slice( $table_data,( ( $current_page-1 )* $per_page ), $per_page );

$this->set_pagination_args( array(
'total_items' => $total_items, //WE have to calculate the total number of items
'per_page' => $per_page //WE have to determine how many items to show on a page
) );
$this->items = array_slice( $table_data,( ( $current_page-1 )* $per_page ), $per_page );

}
 
} //class
 
 
 

global $myListTable;
// $option = 'per_page';
// $args = array(
// 'label' => 'Books',
// 'default' => 10,
// 'option' => 'books_per_page'
// );
// add_screen_option( $option, $args );
$myListTable = new My_Example_List_Table();


 
 
 

$myListTable->prepare_items();
?>

<form method="post">
<input type="hidden" name="page" value="ttest_list_table">
<?php
$myListTable->search_box( 'search', 'search_id' );
 
$myListTable->display();
echo '</form></div>';

    ?>

