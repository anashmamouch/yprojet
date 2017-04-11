import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';
import { Http } from '@angular/http';
import {DomSanitizer} from '@angular/platform-browser';

import {SMS, CallNumber} from 'ionic-native';

import { MonequipePage } from '../monequipe/monequipe';
import { PersonnelPage } from '../personnel/personnel';

/*
  Generated class for the Parrain page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-parrain',
  templateUrl: 'parrain.html'
})
export class ParrainPage {

  //objet ou l'on met les parametres du parrain
  parrain = {
    "nomParrain": '',
    "idParrain": '',
    "adresseParrain":'',
    "telephoneParrain":'',
    "emailParrain":'',
    "dateNaissanceParrain":'',
    "dateInscriptionParrain":''
  }

  idAffiliate: any;

  urlImage: string;

  trustUrlImage:any;

  response:any ;
  image:string;
  dateInscriptionParrain:any;

  backgroundImage:string;

  API:any;

  segment:any;

  constructor(public navCtrl: NavController, public http:Http, public sanitizer: DomSanitizer) {

    //this.validateParrainForm();
    this.getParrainInfo();

    this.segment = 'sponsor';

  }

  //fonction pour connexion avec l'API remplir le formulaire depuis l'API
  getParrainInfo(){
    this.idAffiliate = localStorage.getItem('id_affiliate');
    this.API = localStorage.getItem('api');

    let URL: string = this.API + 'api_infos_affiliate.php?term='+this.idAffiliate;

    this.urlImage = '';

    this.http.get(URL).subscribe(data =>{
      this.response = JSON.parse(data['_body']);

      console.log("image url", this.urlImage);
      console.log("Reponse: ", this.response);

      //let dateNaissanceParrain = this.formatDate(this.response.birth_date2);
      this.dateInscriptionParrain = new Date(this.response.creation_date2);

      this.parrain.nomParrain = this.response.first_and_last_name_p2;
      this.parrain.idParrain = this.response.id_parrain2;
      this.parrain.adresseParrain = this.response.address_p2;
      this.parrain.telephoneParrain = this.response.phone_number_p2;
      this.parrain.emailParrain = this.response.email_p2;
      this.parrain.dateNaissanceParrain = this.response.birth_date2;
      this.parrain.dateInscriptionParrain = this.dateInscriptionParrain.toISOString();

      let URLParrain: string = this.API + 'api_infos_affiliate.php?term='+this.parrain.idParrain;

      this.http.get(URLParrain).subscribe((data) => {

          var imageURL = JSON.parse(data['_body'])['photo_profil'];

          this.urlImage = 'http://' + this.API + '/Y_PROJECT/'+imageURL ;

          console.log("url image", this.urlImage);
          console.log("<<::Response PARRAIN::>>", this.response);

          this.backgroundImage = "url("+this.urlImage+")";
          this.trustUrlImage = this.sanitizer.bypassSecurityTrustStyle(this.backgroundImage);

      }, (error) => {
        console.log("Error URL Parrain::", error)
      });

    }, error => {
      console.log(error);
    });
  }

  sendSMS(){
    SMS.send(this.response.phone_number_p2, 'NOSREZO Salut!');
  }

  call(){
    CallNumber.callNumber(this.response.phone_number_p2, true)
      .then(() => console.log('Launched dialer!'))
      .catch(() => console.log('Error launching dialer'));
  }


  selectProfile(){
    this.navCtrl.setRoot(PersonnelPage);
  }

  selectEquipe(){
    this.navCtrl.setRoot(MonequipePage);
  }

  selectParrain(){

  }

}
