<?php
/**
 * Tälle tiedostolle tulee pyyntö resurssista. Resurssi annetaan vain, jos 
 * mukana on validi JWT bearer token.
 */
require('functions.php');

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['selectusername'];
    $password = $_POST['createpassword'];

        try{
            //Tarkistetaan ja dekoodataan token. Jo ei validi, siirtyy catchiin.
          //  $decoded = JWT::decode($token, new Key(base64_encode('mysecret'), 'HS256')  );

            //Onnistunut dekoodaus sisältää sub-kentän, jossa käyttäjänimi
          //  $username = $decoded->sub;

        $db = createDbConnection();
        createUser($db, $firstname, $lastname, $username, $password);

            //Lähetetään clientille ykstyisen resurssi, koska oikeus tarkistettu
            echo  json_encode( array("message"=>"new user created " .$username) );
            
        }catch(Exception $e){
            echo  json_encode( array("message"=>"error creating new user") );
        }




?>