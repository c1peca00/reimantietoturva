/**
 * Haetaan tarvitut elementit domista
 */
 var form = document.querySelector("form");
 var loginResult = document.querySelector("p")
 var resourceElem = document.getElementById("resource")
 
 /**
  * Lisätään napeille kuuntelijafunktiot
  */
 document.getElementById("getresource").addEventListener("click", getResource)
 form.addEventListener("submit", login)

// document.getElementById("createuser").addEventListener("click", CreateUser)
 
 /**
  * Login tietojen lähetys
  */
 function login(e){
     e.preventDefault();
 
     //Muunnetaan form-data olioksi
     var data = new FormData(form)
 
     //base64 koodataan käyttäjän antamat käyttäjätunnus:salasana
     var base64cred = btoa( data.get("username")+":"+data.get("passwd") )
     console.log(base64cred);
 
     //Luodaan basic auth otsikko ja muut parametrit
     //Authorization: Basic xxxxxxxxx
     var params = {
         headers: { 'Authorization':'Basic ' + base64cred },
         withCredentials: true,
         method: 'post'
     }
 
 
     fetch('http://localhost/argh/login.php', params)
         .then(resp => resp.json())
         .then( data => {
             //Näytetään login tulos saadusta jsonista ja 
             //asetetaan saatu token session storageen talteen
             loginResult.textContent = data.info
             sessionStorage.setItem("token", data.token)            
         })
         .catch(e => {
             loginResult.textContent = "Epäonnistui!!!!"
             console.log(e);
         })
         
 }
 
 /**
  * Haetaan tokenin avulla tietoja palvelimelta
  */
 function getResource(){
 
     //Lisätään osioihin Bearer token session storagesta
     var params = {
         headers: { 'authorization':'Bearer ' + sessionStorage.getItem("token") },
         withCredentials: true,
     }
 
     //Lähetetään pyyntö tokenin kanssa ja katsotaan saadanko vastaus.
     fetch('http://localhost/argh/resources.php', params)
         .then(resp=>resp.json())
         .then(json=> resourceElem.textContent=json.message )
         .catch(e=>resourceElem.textContent="Virhe tuli pyynnössä.")
 }

 function CreateUser(e){
    e.preventDefault();
     console.log("testi user")
 
       //Muunnetaan form-data olioksi
       var data = new FormData(form)
 
       //base64 koodataan käyttäjän antamat käyttäjätunnus:salasana
     //  var base64cred = btoa(data.get("firstname")+":"+data.get("lastname")+":"+data.get("username")+":"+data.get("passwd") )
     var base64cred = btoa("firstname:" + data.get("firstname") + ", lastname:" + data.get("lastname") + ", username:" + data.get("username") + ", password:" + data.get("password"));
       console.log(base64cred);
   
       //Luodaan basic auth otsikko ja muut parametrit
       //Authorization: Basic xxxxxxxxx
       var params = {
           headers: { 'Authorization':'Basic ' + base64cred },
           withCredentials: true,
           method: 'post'
       }

   // Lähetetään pyyntö tokenin kanssa ja katsotaan saadanko vastaus.
        fetch('http://localhost/argh/createuser.php', params)
        .then(resp=>resp.json())
         .then(json=> resourceElem.textContent=json.message )
        .catch(e=>resourceElem.textContent="Virhe tuli pyynnössä.")
}