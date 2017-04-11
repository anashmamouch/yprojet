import { Component } from '@angular/core';

import { NavParams } from 'ionic-angular' ; 

import { Http } from '@angular/http'; 

import { IonProfileHeaderOptions } from '../../components/ion-profile-header'; 

@Component({
  selector: 'page-profile', 
  templateUrl: 'profile.html'
})
export class ProfilePage {

  options:IonProfileHeaderOptions;

  params:any; 
  API:any; 

  idAffiliate:any; 
  response:any; 

  firstName:any; 
  lastName:any; 

  URL:string; 

  image:string; 
  blur:any;

  adresse:string; 
  ville:string; 
  codePostal:string;
  dateNaissance:string;
  email:string; 
  nomParrain:string;
  dateDerniereConnexion:string;
 
  constructor(public navParams:NavParams, public http:Http) {

    this.params = this.navParams.get('params'); 
    
    this.idAffiliate = this.params['id_affiliate']; 
    this.API = localStorage.getItem('api'); 

    console.log('___________________________________________________________PARAMS', this.params); 

    this.dateDerniereConnexion = this.params['last_connection_date']; 
    
    this.blur = { value:'5px',colors: {start:'rgba(43, 40, 50, 0.8)',mid:'rgba(83, 86, 99, 0.8)',end:'rgba(69, 77, 91, 0.6)'}}; 
    this.image = ' ' ; 
    this.setOptions('Benjamin', 'ALLAIS', 'Paris'); 

    this.URL = this.API + 'api_return_info_affiliate.php?term='+this.idAffiliate; 

    console.log(this.URL); 

    this.http.get(this.URL).subscribe((data) => { 
      let response = JSON.parse(data['_body'])[0]; 
      console.log("anas", this.response); 

      this.image = this.API.split("scripts")[0] + '/' + response['photo_profil']; 

      console.log('^^^^^^^^^^^^^PHOTO^^^^^^^^^^^^^', this.image); 

      this.adresse = response['address']; 
      this.ville = response['city']; 
      this.codePostal = response['zip_code']; 
      this.email = response['email']; 
      this.nomParrain = response['first_and_last_name_p2']; 

      let dateArray = response['birth_date'].split(" ")[0].split("-")[0]; 

      this.dateNaissance = dateArray ; 
      console.log(dateArray); 
      console.log(this.dateNaissance);

      this.setOptions(response['first_name'], response['last_name'], response['city']); 
    }, (error) => {
      console.log("profile page error", error)
    }); 

  }

  setOptions(firstName, lastName, city){
      this.options = {
          background: {
            url: this.image,
            classes: "-- mettre la classe css ici --",
            blur: this.blur, 
          },
          img: {
            url: this.image,
            classes: "-- mettre la classe css ici --"
          },
          name: {
            text: firstName + " " + lastName,
            classes: '-- mettre la classe css ici --'
          },
          subtext: {
            text: city,
            classes: '-- mettre la classe css ici --'
          }
      }; 
  }

  call(){

  }

  sendMail(){

  }

  sendMessage(){

  }
}
