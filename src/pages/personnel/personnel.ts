import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http'

import { DomSanitizer } from '@angular/platform-browser';

import { Camera } from 'ionic-native';

import { Storage } from '@ionic/storage' ; 

import { TranslateService } from 'ng2-translate';

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

  user:any = {
    "nom": '',
    "telephone": '',
    "email": '',
    "adresse": '',
    "codePostal": '',
    "ville": '',
    "pays":'',
    "numSecuriteSocial": '' ,
    "logementAffiliate": '',
    "statutLogement":'', 
  };

  personnelForm: FormGroup;

  idAffiliate: any;

  imageURL: string;
  backgroundImage:string;
  trustUrlImage:any;

  image: any;

  response: any;

  responseUpdate: any;

  API:any;

  segment:any;

  profileData:any;

  language: any; 

  constructor(public navCtrl: NavController, public translate: TranslateService, public storage:Storage, public fb:FormBuilder, public alertController: AlertController, public http: Http, public sanitizer: DomSanitizer) {
    

    this.idAffiliate = localStorage.getItem('id_affiliate');
    this.API = localStorage.getItem('api');
    this.language = localStorage.getItem('language'); 

    this.segment = 'profile';
    this.imageURL = ''; 
    this.user  = {
                    "nom": '',
                    "telephone": '',
                    "email": '',
                    "adresse": '',
                    "codePostal": '',
                    "ville": '',
                    "dateNaissance": '',
                    "placeNaissance": '', 
                    "pays":'',
                    "numSecuriteSocial": '' ,
                    "logementAffiliate": '',
                    "statutLogement":'', 
                  };

    this.getInfoAffiliate(); 

    
    this.validatePersonnel();
  }


  changeLanguage(){
    this.translate.use(this.language);
    console.log('language <--> ', this.language);
    localStorage.setItem('language', this.language); 
  }
  
  getInfoAffiliate(){
    let URL:string = this.API + 'api_return_info_affiliate.php?term='+this.idAffiliate;
    console.log('URL INFO AFFILIATE', URL);  
    this.http
        .get(URL)
        .subscribe(
          data => {
            let response = JSON.parse(data['_body'])[0]; 

            this.imageURL = this.API.split("scripts")[0] + response['photo_profil'];
            console.log("IMAGE URL", this.imageURL); 

            this.backgroundImage = "url("+this.imageURL+")";
            this.trustUrlImage = this.sanitizer.bypassSecurityTrustStyle(this.backgroundImage);
            
            this.user.nom = response['first_name']+" "+response['last_name'];
            this.user.telephone = response['phone_number'];
            this.user.email = response['email_aff'];
            this.user.adresse = response['address'];
            this.user.codePostal = response['zip_code'];
            this.user.ville = response['city'];
            this.user.dateNaissance = response['birth_date']; 
            this.user.placeNaissance = response['birth_place']; 
            this.user.pays = response['nationality'];
            this.user.numSecuriteSocial = response['id_securite_sociale'];
            this.user.logementAffiliate = response['logement_affiliate']; 
            this.user.statutLogement = response['statut_logement']; 

            this.user.dateNaissance = this.user.dateNaissance.split("/")[2]
                                      + "-" + this.user.dateNaissance.split("/")[1] 
                                      + "-" + this.user.dateNaissance.split("/")[0]; 
                                    
            console.log('>>>>>>>>>>>>>>>user OBJECT>>>>>>>>>>>>>>>', this.user);
          
          }, 
          error =>{
            console.log('######INFO AFFILIATE ERROR######', error); 
          }
        )
  }


  logout() {

        this.storage.clear(); 

        localStorage.setItem('first_name','' ); 
        localStorage.setItem('last_name', ''); 
        localStorage.setItem('email_aff', ''); 
        localStorage.setItem('photo_profil',''); 
        localStorage.setItem('id_partenaire', ''); 
        localStorage.setItem('id_upline', '');
        localStorage.setItem('id_partenaire_is_iad', '');
        localStorage.setItem('parrain_is_iad', ''); 
        localStorage.setItem('id_partenaire_2_is_iad', ''); 
        localStorage.setItem('name_parrain', ''); 
        localStorage.setItem('email_parrain', ''); 
        localStorage.setItem('tel_parrain', ''); 
        localStorage.setItem('phone_number', ''); 
        localStorage.setItem('address', ''); 
        localStorage.setItem('zip_code', ''); 
        localStorage.setItem('city', ''); 
        localStorage.setItem('birth_date', ''); 
        localStorage.setItem('birth_place', ''); 
        localStorage.setItem('nationality', ''); 
        localStorage.setItem('id_securite_sociale', ''); 
        localStorage.setItem('logement_affiliate', ''); 
        localStorage.setItem('statut_logement', ''); 
        localStorage.setItem('photo_profil', ''); 
        localStorage.setItem('nb_filleul_total', ''); 
        localStorage.setItem('nb_affiliate_level_1', '');
        localStorage.setItem('nb_affiliate_level_2', '');  
        localStorage.setItem('nb_reco_level_1', ''); 
        localStorage.setItem('nb_reco_total', ''); 
        localStorage.setItem('nb_reco', ''); 
        localStorage.setItem('gain_potentiel', ''); 
        localStorage.setItem('commission_a_encaisser', ''); 
        localStorage.setItem('id_partenaire_du_parrain_1', ''); 
        localStorage.setItem('service_du_parrain_1', ''); 
        localStorage.setItem('parrain_2_is_iad', ''); 
        localStorage.setItem('id_partenaire_du_parrain_2', ''); 
        localStorage.setItem('service_du_parrain_2', ''); 
        localStorage.setItem('lien_webinar', ''); 
        localStorage.setItem('telephone_service_qualite', ''); 
        localStorage.setItem('nb_reco_retard', ''); 

    this.navCtrl.setRoot(LoginPage);
  }

  selectProfile(){

  }

  selectEquipe(){
    this.navCtrl.setRoot(MonequipePage);
  }

  //fonction appellé lorsque le button modifier
  modifier(){
    console.log(this.user);
    let URLUpdate: string = this.API + "api_update_profil_mobile.php"  
    console.log('%%%%%%%%%%%%%URL___||___UPDATE%%%%%%%%%%%%%'); 
    let dataUpdate = {
                    id_affiliate:  this.idAffiliate,
                    phone_number: this.user.telephone,
                    address: this.user.adresse,
                    zip_code: this.user.codePostal,
                    city: this.user.ville,
                    birth_date: this.user.dateNaissance,
                    birth_place: this.user.placeNaissance,
                    nationality: this.user.pays,
                    id_securite_sociale: this.user.numSecuriteSocial,
                    logement_affiliate: this.user.logementAffiliate,
                    statut_logement: this.user.statutLogement,
                }

    this.http
        .post(URLUpdate, dataUpdate)
        .subscribe(data =>{
            console.log('DATA', data); 
            let responseUpdate = JSON.parse(data['_body'])[0];

            this.showAlert("",responseUpdate['msg_alerte'], "OK"); 

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
      "dateNaissance": ['', Validators.required],
      "placeNaissance": ['', Validators.required],
      "pays": ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.maxLength(30), Validators.pattern('^[a-zA-ZàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "numSecuriteSocial": ['', Validators.compose([Validators.required, , Validators.minLength(6), Validators.pattern('^[0-9\. ]+$')])],
      "logementAffiliate": ['', Validators.required], 
      "statutLogement":['', Validators.required], 
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
