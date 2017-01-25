import { Component } from '@angular/core';

import { NavParams } from 'ionic-angular' ; 

import { Http } from '@angular/http'; 

import { IonProfileHeaderOptions } from '../../components/ion-profile-header'

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
 
  constructor(public navParams:NavParams, public http:Http) {
    
    this.idAffiliate = this.navParams.get('id_affiliate'); 
    this.API = localStorage.getItem('api'); 

    this.URL = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term='+this.idAffiliate; 

    console.log(this.URL); 

    this.blur = {value:'5px',colors: {start:'rgba(43, 40, 50, 0.8)',mid:'rgba(83, 86, 99, 0.8)',end:'rgba(69, 77, 91, 0.6)'}}; 

    this.image = ' ' ; 
    this.setOptions('Benjamin', 'ALLAIS', 'Paris'); 

    this.http.get(this.URL).subscribe((data) => { 
      this.response = JSON.parse(data['_body']); 
      console.log("anas", this.response); 

      this.image = 'http://' + this.API + '/Y_PROJECT/' + this.response['photo_profil'];

      this.adresse = this.response['address']; 
      this.ville = this.response['city']; 
      this.codePostal = this.response['zip_code']; 
      this.email = this.response['email']; 
      this.nomParrain = this.response['first_and_last_name_p2']; 

      let dateArray = this.response['birth_date'].split(" ")[0].split("-")[0]; 

      this.dateNaissance = dateArray ; 
      console.log(dateArray); 
      console.log(this.dateNaissance); 

      this.setOptions(this.response['first_name'], this.response['last_name'], this.response['city']); 
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
}
