<?php
/*
 Plugin Name: Trouwlijst
 Plugin URI: https://www.buggenburg.be/
 Description: A plugin that keeps track of reserved gifts, in Dutch
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

function lijst_retrieve_password($item){
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
function lijst_print_form(){
    //Get the registry item id from the GET header
    $item = $_GET['item'];
    global $wpdb;
    $registry_results = $wpdb->get_row("SELECT image_url, url FROM wp_registry
        WHERE id = '" . $item . "'");
    $image_url = $registry_results->image_url;
    $url = $registry_results->url;
    
    //Check if the password of the corresponding registry item is null (i.e.
    //the item is NOT reserved)
    if (!lijst_retrieve_password($item)){
        //Display the form to reserve the item
        $form = '
        <figure class="wp-block-image size-large is-style-twentytwentyone-border">
            <img src="' . $image_url . '" alt=""/></figure>
        <p>Nadat je dit artikel <a href="' . $url . '" target="_blank">
            via zijn website</a> hebt gekocht, kan je het hieronder als \'gereserveerd\' 
            markeren. Zo geef je aan de andere gasten aan dat dit artikel
            reeds gekocht is.</p> 
        <p>Kies  een paswoord en klik op "Reserveer dit artikel".</p>
        <p>Indien je dit 
            artikel later toch terug beschikbaar wilt maken voor de andere gasten,
            kan je dit doen door op deze pagina het door jou gekozen paswoord weer in te 
            vullen.</p>
        <br>
        <form method="POST" >
           <label for="pwd" style="font-color: white;">Paswoord:</label><br>
           <input type="text" id="pwd" name="pwd" maxlength="99" required>
           <input type="hidden" id="item" name="' . $item . '">
           <input type="submit" value="Reserveer dit artikel">
        </form>
        <br>
        <p>Of <a href="/inspiratie/#cadeaus">keer terug</a> naar alle artikels.</p>';
        return $form;
        //Check if the password of the corresponding registry item is not null
        //(i.e. the item IS reserved)
    } else if (lijst_retrieve_password($item)) {
        //Display the form to unreserve the item
        $form = '
        <figure class="wp-block-image size-large is-style-twentytwentyone-border">
            <img src="' . $image_url . '" alt=""/></figure>
        <p>Iemand heeft dit artikel al gereserveerd. Je kan <a href=
            "/inspiratie/#cadeaus">terugkeren</a> naar alle artikels voor meer inspiratie.</p>
        <br>
        <p>Ben jij de persoon  die het artikel gereserveerd heeft, en wil je het 
            graag weer beschikbaar maken voor de andere gasten? Vul dan het 
            paswoord in dat je eerder gebruikte om het artikel de reserveren, en 
            klik dan op \'Maak artikel beschikbaar\'.</p>
                
        <form method="POST" >
           <label for="pwd" style="font-color: white;">Paswoord:</label><br>
           <input type="text" id="pwd" name="pwd" maxlength="99" required>
           <input type="hidden" id="item" name="' . $item . '">
           <input type="submit" value="Maak artikel beschikbaar">
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
function lijst_update_registry_database(){
    //Execute the code if the submit button is pressed
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Save the form data into variables
        $item = $_GET['item'];
        $password = $_POST['pwd'];
        
        global $wpdb;
        
        //Check that the item is not reserved
        if (lijst_retrieve_password($item) === NULL){
            //Update the database and set that item's password to the given
            //password
            $sql = $wpdb->prepare( "UPDATE wp_registry SET password = %s
                    WHERE id = %s;", $password, $item);
            $wpdb->query($sql);
            //Return success message
            return "<p>Dankjewel. Dit artikel verschijnt nu als 'gereserveerd'
                        voor de andere gasten.
                    <br>
                    <br>
                    <a href=\"/\">Keer terug naar de startpagina</a>.</p>";
            
            //If the item is already reserved check that the saved password matches
            //the provided password
        } else if (lijst_retrieve_password($item) === $password){
            //Update the database and set that item's password back to NULL
            $sql = $wpdb->prepare( "UPDATE wp_registry SET password = NULL
                    WHERE id = %s;", $item);
            $wpdb->query($sql);
            //Return success message
            return "<p>Dankjewel. Dit artikel verschijnt nu opnieuw als 
                        'beschikbaar' voor de andere gasten.
                    <br>
                    <br>
                    <a href=\"/inspiratie/#cadeaus\">Keer terug</a>
                        naar alle artikels.</p>";
            //If the item is already reserved but the saved password does not match
            //the provided password
        } else if (lijst_retrieve_password($item) != $password){
            //Return error message, and display the form again so the user can
            //try again.
            return '<p>Dit paswoord stemt niet overeen met het paswoord dat je 
                        eerder gebruikte om dit artikel te reseveren. 
                        Probeer opnieuw.</p>
                    <form method="POST" >
                       <label for="pwd" style="font-color: white;">Paswoord:
                            </label><br>
                       <input type="text" id="pwd" name="pwd" maxlength="99" required>
                       <input type="hidden" id="item" name="' . $item . '">
                       <input type="submit" value="Maak dit artikel beschikbaar">
                    </form>
                    <p>Indien je hulp nodig hebt, stuur dan een e-mail naar 
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
function lijst_reserve_item( $content ) {
    //Only replace the content on this page
    if (is_page('reserveer-cadeau')){
        //Create an array of database ids so that we can check if the item number
        //is indeed a valid entry in the database
        global $wpdb;
        $all_itemsDB = $wpdb->get_results("SELECT id FROM wp_registry");
        $all_items_ids = [];
        foreach ($all_itemsDB as $item) {
            array_push($all_items_ids, $item->id);
        }
        
        //Only display the forms if there is an appropriate GET value set for the item.
        //Else display fallback page.
        if (isset($_GET['item']) && in_array($_GET['item'], $all_items_ids)){
            
            //If the form has eben submitted, display the corresponding success or
            //error message
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $content = lijst_update_registry_database();
                //If the form has not yet been submitted, display the form depending on
                //whether the item is reserved or not
            } else {
                $content = lijst_print_form();
            }
            
            return $content;
            
        } else {
            return $content;
        }
        //If the user is on any other page, just display that page's regular content
    } else {
        return $content;
    }
}
//Add this function to the the_content hook to enable the plugin functionality
add_filter( 'the_content', 'lijst_reserve_item', 99);

/*
 * DISPLAY THE CORRECT BUTTON ON THE GIFTS PAGE
 * This function checks if the user is on the 'gifts' page
 * If so, it checks for each gift item if the item is reserved yet.
 * If it is reserved, it chanegs the button display to "Unreserve this item".
 * If it not reserved, it leaves the reserve button unchanged.
 */
function lijst_toggle_reserved_items($content){
    //Only replace the content on this page
    if (is_page('inspiratie')){
        //Loop through the array of available article ids
        global $wpdb;
        $all_itemsDB = $wpdb->get_results("SELECT id FROM wp_registry");
        foreach ($all_itemsDB as $item) {
            //Check if the item is reserved
            if (lijst_retrieve_password($item->id)){
                //If it is, find the button HTML in the_content and replace it
                //with a new string.
                $string_to_find = 'value="' . $item->id . '"><input type="submit" value="Reserveer dit artikel">';
                $string_to_replace = 'value="' . $item->id . '"><input type="submit" value="Maak beschikbaar">';
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
add_filter( 'the_content', 'lijst_toggle_reserved_items', 99);

