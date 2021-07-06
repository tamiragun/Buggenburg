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

function register_get_item(){
    $item = $_GET['item'];
    global $wpdb;
    //$register_results = $wpdb->get_results("SELECT * FROM " . $wpdb->wp_registry . "WHERE id = '" . $item . "'");
    $register_results = $wpdb->get_row("SELECT * FROM wp_registry WHERE id = '" . $item . "'");
    if ($register_results->password) {
        return 'test1';
    } else {
        return 'test2';
    }
    
    
}

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
        $test = register_get_item();
        $content = $test . '<form method="POST">
    <label for="pwd" style="font-color: white;">Enter a password that you will definitely remember if you want to un-reserve this item later on:</label><br><br>
    <input type="text" id="pwd" name="pwd" required>
    <input type="hidden" id="item" name="' . $item . '"><br><br>
    <input type="submit" value="Reserve this item">
    </form>'; 
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