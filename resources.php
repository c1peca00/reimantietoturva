<?php
/**
 * Tälle tiedostolle tulee pyyntö resurssista. Resurssi annetaan vain, jos 
 * mukana on validi JWT bearer token.
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require('headers.php');
require('functions.php');

//Haetaan otsikot pyynnöstä
//Kommentissa vaihtoehtoiset otsikkosijainnit, jotka eivät esim. xamppin kanssa taida toimia
$requestHeaders =  apache_request_headers(); //$_SERVER['Authorization'] tai $_SERVER['HTTP_AUTHORIZATION'])

//Onko auth header olemassa?
if( isset( $requestHeaders['authorization'] ) ){

    //Halkaistaan osiin Bearer ja token
    $auth_value = explode(' ', $requestHeaders['authorization']);


    //Tarkistetaan onko Bearer sanaa
    if( $auth_value[0] === 'Bearer' ){

        //Otetaan itse token talteen
        $token = $auth_value[1];

        try{
            //Tarkistetaan ja dekoodataan token. Jo ei validi, siirtyy catchiin.
            $decoded = JWT::decode($token, new Key(base64_encode('mysecret'), 'HS256')  );

            //Onnistunut dekoodaus sisältää sub-kentän, jossa käyttäjänimi
            $username = $decoded->sub;

            $data = getpersonaldata($username);

            //Lähetetään clientille ykstyisen resurssi, koska oikeus tarkistettu
            echo  json_encode( array("message"=>"here is your private information ".$data) );
            
        }catch(Exception $e){
            echo  json_encode( array("message"=>"No access!!") );
        }

    }

}

function getpersonaldata($id) {

    try{
        $db = createDbConnection();
        $data = "";

        $sql = "SELECT puhnro,osoite FROM tieto WHERE id=?";  //komento, arvot parametreina
        $prepare = $db->prepare($sql);   //valmistellaan
        $prepare->execute(array($id));  //kysely tietokantaan

        $rows = $prepare->fetchAll(); //haetaan tulokset (voitaisiin hakea myös eka rivi fetch ja tarkistus)

        //Käydään rivit läpi (max yksi rivi tässä tapauksessa) 
        foreach($rows as $row){
            $data .= "puhelinnumerosi: ".$row['puhnro']. " osoitteesi: ".$row['osoite'];
        }

        return $data;

    }catch(PDOException $e){
        return $e->getMessage();
    }

}

?>