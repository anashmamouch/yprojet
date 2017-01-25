import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http'

import { DomSanitizer } from '@angular/platform-browser';

import { Camera } from 'ionic-native';

import {Validators, FormBuilder, FormGroup } from '@angular/forms';

//pages
import { EntreprisePage } from '../entreprise/entreprise';
import { VirementsPage } from '../virements/virements';
import { LoginPage } from '../login/login';
import { MonequipePage } from '../monequipe/monequipe';
import { ParrainPage } from '../parrain/parrain';

@Component({
  selector: 'page-personnel',
  templateUrl: 'personnel.html'
})
export class PersonnelPage {
  //objet user on l'on met les parametres des champs de la forme personnel
  user = {
    "nom": '',
    "telephone": '',
    "email": '',
    "adresse": '',
    "codePostal": '',
    "ville": '',
    "pays":'',
    "numSecuriteSocial": '' ,
  };

  personnelForm: FormGroup;

  idAffiliate: any;

  urlImage: string;
  backgroundImage:string;
  trustUrlImage:any;

  image: any;

  response: any;

  responseUpdate: any;

  API:any;

  segment:any;

  constructor(public navCtrl: NavController, public fb:FormBuilder, public alertController: AlertController, public http: Http, public sanitizer: DomSanitizer) {
    //valider les champs
    this.validatePersonnel();

    this.idAffiliate = localStorage.getItem('id_affiliate');
    this.API = localStorage.getItem('api');

    this.urlImage = '';
    this.segment = 'profile';

    console.log("URL_IMAGE",this.urlImage);

    let URL: string = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term='+this.idAffiliate;

    this.http.get(URL).subscribe(data =>{
      this.response = JSON.parse(data['_body']);

      var imageURL = this.response['photo_profil'];

      this.urlImage = 'http://' + this.API + '/Y_PROJECT/'+imageURL ;
      this.backgroundImage = "url("+this.urlImage+")";
      this.trustUrlImage = sanitizer.bypassSecurityTrustStyle(this.backgroundImage);

      this.user.nom = this.response.first_name+" "+this.response.last_name;
      this.user.telephone = this.response.phone_number;
      this.user.email = this.response.email;
      this.user.adresse = this.response.address;
      this.user.codePostal = this.response.zip_code;
      this.user.ville = this.response.city;
      this.user.pays = this.response.nationality;
      this.user.numSecuriteSocial = this.response.num_securite_sociale;

    }, error => {
      console.log(error);
    });
  }

  openEntreprise(){
    this.navCtrl.push(EntreprisePage, {params : " "});
  }

  openVirement(){
    this.navCtrl.push(VirementsPage, {params: ""});
  }

  logout() {
    this.navCtrl.setRoot(LoginPage);
  }

  selectProfile(){

  }

  selectEquipe(){
    this.navCtrl.setRoot(MonequipePage);
  }

  selectParrain(){
    this.navCtrl.setRoot(ParrainPage);
  }

  getInfoAffiliate(){

  }

  //fonction appellé lorsque le button modifier
  modifier(){
    console.log(this.user);
    let URL: string = "http://"+this.API+"/Y_PROJECT/scripts/api_mobile/api_update_profil.php"
                      +"?id_affiliate="+this.idAffiliate
                      +"&phone_number="+this.user.telephone
                      +"&email="+this.user.email
                      +"&address="+this.user.adresse
                      +"&zip_code="+this.user.codePostal
                      +"&city="+this.user.ville
                      +"&nationality="+this.user.pays

    this.http.get(URL).subscribe(data =>{
      this.responseUpdate = JSON.parse(data['_body']);

      this.showAlert(" ", this.responseUpdate['msg_alert'], "OK");

      console.log("DATA", this.responseUpdate);
    });
  }

  validatePersonnel(){
    this.personnelForm = this.fb.group({
      //"nom": ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "telephone" : ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\.]+$')])],
      "email":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
      "adresse" : ['', Validators.compose([Validators.required, Validators.minLength(6), Validators.pattern('^[a-zA-Z0-9-_ àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+')])],
      "codePostal" :  ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.pattern('^[0-9\. ]+$')])],
      "ville": ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.maxLength(30), Validators.pattern('^[a-zA-Z- àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "pays": ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.maxLength(30), Validators.pattern('^[a-zA-ZàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "numSecuriteSocial": ['', Validators.compose([Validators.required, , Validators.minLength(6), Validators.pattern('^[0-9\. ]+$')])],
    })
  }

  modifierImage(){
    Camera.getPicture({
      destinationType : Camera.DestinationType.FILE_URI,
      sourceType: Camera.PictureSourceType.SAVEDPHOTOALBUM,
      correctOrientation: true,
    }).then((imagePath)=>{
      console.log("image Path" + imagePath);

      alert("image Path: " + imagePath);

    }, (error) => {
      console.log("Anas::Error " + error.message);
    })
}

  //fonction generique pour afficher les alertes
  showAlert(mytitle,mysubTitle,mybuttons) {
       let alert = this.alertController.create({
           title: mytitle,
           subTitle: mysubTitle,
           buttons: [mybuttons]
       });
       alert.present();
   }

}
