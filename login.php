<?php

/**
 * Tämä tiedosto hoitaa login-toiminnon. Login tarkistaa on basic auth otsikko asetettu.
 * Tämän jälkeen tarkistetaan löytyykö otsikon käyttäjätunnus ja salasana tietokannasta.
 * Jos löytyy, palautetaan clientille ok ja lisäksi JWT token.
 * 
 * JTW työkalut on lisätty headers.php-tiedostoon (fb-kansiossa itse kirjasto)
 */

use Firebase\JWT\JWT;

require('headers.php');
require('functions.php');
//echo(json_encode("testi"));
//exit;

//Tarkistetaan tuleeko palvelimelle basic login tiedot (authorization: Basic asfkjsafdjsajflkasj)
if( isset($_SERVER['PHP_AUTH_USER']) ){
    //Tarkistetaan käyttäjä tietokannasta
    if(checkUser(createDbConnection(), $_SERVER['PHP_AUTH_USER'],$_SERVER["PHP_AUTH_PW"] )){
        
       

        //Käyttäjä tunnistettu, joten luodaan vastaukseen JWT token payload
        $payload = array(
            "iat"=>time(),
            "sub"=>$_SERVER['PHP_AUTH_USER']
        );

        //Luodaan signeerattu JWT
        $jwt = JWT::encode( $payload, base64_encode('mysecret'), 'HS256' );

        //Lähetetään JSON muodossa infoteksti ja JWT token clientille
        //{"info":"Kirjauduit sisään", "token":"xxxxxxxxxxx"}
        echo  json_encode( array("info"=>"Kirjauduit sisään", "token"=>$jwt)  );
        header('Content-Type: application/json');
        exit;

    }
    else{
        echo '{"info":"tietokantayhteys epäonnistui buhuu"}';
        header('Content-Type: application/json');
        header('HTTP/1.1 401');
        exit;
    }
}

//Login ei onnistunut
//Käyttäjälle unauhtorized-otsikko sekä JSONissa info epäonnistumisesta
echo '{"info":"Kirjautuminen epäonnistui"}';
header('Content-Type: application/json');
header('HTTP/1.1 401');
exit;

?>