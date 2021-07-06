<?php
/*
 Plugin Name: Register
 Plugin URI: https://www.buggenburg.be/
 Description: A plugin that keeps track of reserved gifts
 Version: 1.0
 Author: amira Gunzburg
 Author URI: https://www.buggenburg.be/
 License: UNLICENSED
 */

function register_is_item_reserved(){
    $item = $_GET['item'];
    global $wpdb;
    //$register_results = $wpdb->get_results("SELECT * FROM " . $wpdb->wp_registry . "WHERE id = '" . $item . "'");
    $register_results = $wpdb->get_row("SELECT * FROM wp_registry WHERE id = '" . $item . "'");
    if ($register_results->password) {
        return true;
    } else {
        return false;
    } 
}

function register_print_form(){
    $item = $_GET['item'];
    if (!register_is_item_reserved()){
        $form = '
<p>After you have purchased this item, you can mark it as \'reserved\' here. This will indicate to other guests that the item has already been purchased by someone. Simply choose a password and click "Reserve this item"</p>
<p>If you want to make the item available again to other guests, you can come back later and \'un-reserve\' it with the same password.</p>
<br>       
<form method="POST" >
        <label for="pwd" style="font-color: white;">Password:</label><br>
        <input type="text" id="pwd" name="pwd" required>
        <input type="hidden" id="item" name="' . $item . '">
        <input type="submit" value="Reserve this item">
    </form>';
        return $form;
    }
}

function register_update_registry_database(){
    if (is_page('reserve-gift')){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $reserved_item = $_GET['item'];
            $password = $_POST['pwd'];
            global $wpdb;
            $sql = $wpdb->prepare( "UPDATE wp_registry SET password = %s WHERE id = %s;", $password, $reserved_item);
            $wpdb->query($sql);
            //$wpdb->update($wpdb->wp_registry, array("password" => $password),array("id"=>$reserved_item), array("%s"), array("%s"),);

        }
        
    }
}

add_action( 'wp_head' , 'register_update_registry_database' ); 

function register_test_add_html( $content ) {
    if (is_page('gifts')){
        $test = str_replace("button-1\"><a class=\"wp-block-button__link\">Reserve this item</a></div>","button-1\"><a class=\"wp-block-button__link\">Unreserve this item</a></div>",$content);
        $html_segment = '<p>Text to be added:</p>';
        $content = $html_segment . $test . $html_segment;
        return $content;
    } else {
        return $content;
    }
}
add_filter( 'the_content', 'register_test_add_html', 99); 

 function register_test_form( $content ) {
    if (is_page('reserve-gift')){
        $item = $_GET['item'];
        $content = register_print_form();
/*         '<form method="POST">
    <label for="pwd" style="font-color: white;">Enter a password that you will definitely remember if you want to un-reserve this item later on:</label><br><br>
    <input type="text" id="pwd" name="pwd" required>
    <input type="hidden" id="item" name="' . $item . '"><br><br>
    <input type="submit" value="Reserve this item">
    </form>'; */ 
        return $content;
    } else {
        return $content;
    }
}
add_filter( 'the_content', 'register_test_form', 99);  

/* function register_test_form() {
    echo '<form method="POST">
    <label for="pwd" style="font-color: white;">Enter a password that you will remember if you want to un-reserve this item later on:</label><br><br>
    <input type="text" id="pwd" name="pwd">
    <input type="submit" value="Reserve this item">
    </form>';
}
*/
//add_action( 'wp_head' , 'register_get_item' ); 


/* add_action( 'the_content', 'my_thank_you_text', 10, 1 );

function my_thank_you_text ( $content ) {
    
    return $content .= '<p>Thank you for reading!</p>';
}  */


/* function register_test() {
    if (!is_page()) return null ;
    
    return "this is a test";
}

add_action( 'wp_head' , 'register_test' );  */