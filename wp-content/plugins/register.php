<?php
/*
 Plugin Name: Register
 Plugin URI: https://www.buggenburg.be/
 Description: A plugin that keeps track of reserved gifts
 Version: 1.0
 Author: Tamira Gunzburg
 Author URI: https://www.buggenburg.be/
 License: UNLICENSED
 */

/*
 * CHECK IF ITEM IS RESERVED AND RETRIEVE PASSWORD
 * This helper function checks if the current registry item is reserved.
 * It searches the database for the registry item with the id passed in the 
 * GET header.
 * It then returns the stored password for that registry item.
 * The password will be NULL for unreserved items and a string for reserved 
 * items.
 */

function register_retrieve_password($item){
    //Get the registry item id from the GET header
    //$item = $_GET['item'];
    global $wpdb;
    //Get the password of the corresponding registry item in the database
    $registry_results = $wpdb->get_row("SELECT password FROM wp_registry 
        WHERE id = '" . $item . "'");
    //Return the password, which will be NULL or a string
    return $registry_results->password;
}

/*
 * PRINT THE FORM TO RESERVE OR UNRESERVE ITEM
 * This helper function checks if the current registry item is reserved.
 * If the item is not reserved, it displays a form to reserve the item.
 * If the item is reserved, it displays a message to the user and a for to 
 * 'un-reserve' the item.
 */
function register_print_form(){
    //Get the registry item id from the GET header
    $item = $_GET['item'];
    global $wpdb;
    $registry_results = $wpdb->get_row("SELECT image_url, url FROM wp_registry 
        WHERE id = '" . $item . "'");
    $image_url = $registry_results->image_url;
    $url = $registry_results->url;
    
    //Check if the password of the corresponding registry item is null (i.e. 
    //the item is NOT reserved)
    if (!register_retrieve_password($item)){
        //Display the form to reserve the item
        $form = '
        <figure class="wp-block-image size-large is-style-twentytwentyone-border">
            <img src="' . $image_url . '" alt=""/></figure>        
        <p>After you have purchased this item <a href="' . $url . '" target="_blank">
            on its website</a>, you can mark it as \'reserved\' below. This will 
            indicate to other guests that the item has already been purchased by 
            someone. Simply choose a password and click "Reserve this item"</p>
        <p>If you want to make the item available again to other guests, you can 
            come back later and \'un-reserve\' it with the same password.</p>
        <br>       
        <form method="POST" >
           <label for="pwd" style="font-color: white;">Password:</label><br>
           <input type="text" id="pwd" name="pwd" required>
           <input type="hidden" id="item" name="' . $item . '">
           <input type="submit" value="Reserve this item">
        </form>
        <br>
        <p>Or <a href="/wordpress/buggenburg_local/gifts">go back</a> to browse 
            other items.</p>';
        return $form;
    //Check if the password of the corresponding registry item is not null 
    //(i.e. the item IS reserved)
    } else if (register_retrieve_password($item)) {
        //Display the form to unreserve the item
        $form = '
        <figure class="wp-block-image size-large is-style-twentytwentyone-border">
            <img src="' . $image_url . '" alt=""/></figure>
        <p>Someone has already reserved this item. You can <a href=
            "/wordpress/buggenburg_local/gifts">go back</a> to browse other items.</p>
        <br>
        <p>If you are the person who reserved this item, and you would like to 
            make it available to other guests again, just enter the password 
            you used to reserve it, and then click \'un-reserve\'.</p>
        
        <form method="POST" >
           <label for="pwd" style="font-color: white;">Password:</label><br>
           <input type="text" id="pwd" name="pwd" required>
           <input type="hidden" id="item" name="' . $item . '">
           <input type="submit" value="Un-reserve this item">
        </form>';
        return $form;
    }
}

/*
 * UPDATE THE DATABASE TO RESERVE OR UNRESERVE WITH THE GIVEN PASSWORD
 * This function takes the submitted form data and checks what that item's 
 * password is.
 * If the password is NULL, then the item is not reserved, and the database 
 * is updated with this new password, thus 'reserving' the item. 
 * A success message is returned.
 * If the password is not null, then the item is reserved. 
 * The function now checks to see if the newly entered password matches the 
 * password in the database. 
 * If it does match, then the database is updated to reflect password NULL, 
 * thus 'unreserving' the item. A success message is returned.
 * If it does not match, an error message is returend and the form is presented 
 * again.
 */
function register_update_registry_database(){
    //Execute the code if the submit button is pressed
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Save the form data into variables
        $item = $_GET['item'];
        $password = $_POST['pwd'];
        
        global $wpdb;
        
        //Check that the item is not reserved
        if (register_retrieve_password($item) === NULL){
            //Update the database and set that item's password to the given 
            //password
            $sql = $wpdb->prepare( "UPDATE wp_registry SET password = %s 
                    WHERE id = %s;", $password, $item);
            $wpdb->query($sql);
            //Return success message
            return "<p>Thank you. This item is now marked as 'reserved' to 
                        other guests.
                    <br>
                    <br>
                    <a href=\"/wordpress/buggenburg_local/\">Go back to 
                        home</a>.</p>";                    
        
        //If the item is already reserved check that the saved password matches 
        //the provided password
        } else if (register_retrieve_password($item) === $password){
            //Update the database and set that item's password back to NULL
            $sql = $wpdb->prepare( "UPDATE wp_registry SET password = NULL 
                    WHERE id = %s;", $item);
            $wpdb->query($sql);
            //Return success message
            return "<p>Thank you. This item is now marked as available again 
                        to other guests. 
                    <br>
                    <br>
                    <a href=\"/wordpress/buggenburg_local/gifts\">Go back</a> 
                        to browse other items.</p>";
        //If the item is already reserved but the saved password does not match 
        //the provided password
        } else if (register_retrieve_password($item) != $password){
            //Return error message, and display the form again so the user can 
            //try again.
            return '<p>This password does not match the password that was 
                        entered when this item was reserved. Please try again.</p>
                    <form method="POST" >
                       <label for="pwd" style="font-color: white;">Password:
                            </label><br>
                       <input type="text" id="pwd" name="pwd" required>
                       <input type="hidden" id="item" name="' . $item . '">
                       <input type="submit" value="Un-reserve this item">
                    </form>
                    <p>If you need further assistance, please email 
                        t.gunzburg@gmail.com.</p>';
        }
    }
}

/*
 * DISPLAY THE CORRECT CONTENT ON THE RESERVE ITEM PAGE
 * This function checks if the user is on the 'reserve-gift' page
 * If so, it checks if the form submit button has been clicked yet.
 * If not, it displays the reserve or unreserve form, depending on whether the 
 * item is already reserved.
 * If it has been submitted, it displays the corresponding success or failure 
 * message.
 */
function register_reserve_item( $content ) {
    //Only replace the content on this page
    if (is_page('reserve-gift')){
        //If the form has eben submitted, display the corresponding success or 
        //error message
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $content = register_update_registry_database();
        //If the form has not yet been submitted, display the form depending on 
        //whether the item is reserved or not
        } else {
            $content = register_print_form();
        }
        
        return $content;
    //If the user is on any other page, just display that page's regular content
    } else {
        return $content;
    }
}
//Add this function to the the_content hook to enable the plugin functionality
add_filter( 'the_content', 'register_reserve_item', 99);  

/*
 * DISPLAY THE CORRECT BUTTON ON THE GIFTS PAGE
 * This function checks if the user is on the 'gifts' page
 * If so, it checks for each gift item if the item is reserved yet.
 * If it is reserved, it chanegs the button display to "Unreserve this item".
 * If it not reserved, it leaves the reserve button unchanged.
 */
function register_toggle_reserved_items($content){
    //Only replace the content on this page
    if (is_page('gifts')){
        //Loop through the array of available article ids
        $all_items = [1,2,3,4,5,6,7,8,9,10,11];
        foreach ($all_items as $item) {
            //Check if the item is reserved
            if (register_retrieve_password($item)){
                //If it is, find the button HTML in the_content and replace it 
                //with a new string.
                $string_to_find = 'value="' . $item . '"><input type="submit" 
                    value="Reserve this item">';
                $string_to_replace = 'value="' . $item . '"><input type="submit" 
                    value="Un-reserve this item">';
                //Return the updated content and move on to the next item in the array
                $content = str_replace($string_to_find,$string_to_replace, $content);
            }
        }
        //After finishing the loop and updating the_content zero or more times, 
        //return the final content
        return $content;
    //If the user is on any other page, just display that page's regular content
    } else {
        return $content;
    }
}


//Add this function to the the_content hook to enable the plugin functionality
add_filter( 'the_content', 'register_toggle_reserved_items', 99); 

