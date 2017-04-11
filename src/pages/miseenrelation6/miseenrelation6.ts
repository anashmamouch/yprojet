import { Component } from '@angular/core';
import { NavController, NavParams, AlertController } from 'ionic-angular';

import { Http } from '@angular/http'; 

import { Validators, FormBuilder, FormGroup } from '@angular/forms';

import { AccueilPage } from '../accueil/accueil'; 

import { Miseenrelation4Page } from '../miseenrelation4/miseenrelation4'; 
import { Miseenrelation3Page } from '../miseenrelation3/miseenrelation3';

@Component({
  selector: 'page-miseenrelation6',
  templateUrl: 'miseenrelation6.html'
})

export class Miseenrelation6Page {

  relationData:any;
  miseEnRelationForm:any;   

  idAffiliate:any; 
  API:any; 

  nom:any; 
  adresse:any; 
  type:any; 
  partenaire:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public alertController:AlertController, public fb:FormBuilder, public http:Http) {

    console.log('+++++MISE EN RELATION+++++'); 
    console.log('!!!!! RELATION DATA !!!!!', this.navParams.get('relationData')); 

    this.idAffiliate = localStorage.getItem('id_affiliate'); 
    this.API = localStorage.getItem('api'); 
    
    this.relationData = this.navParams.get('relationData'); 

 
    this.adresse = this.relationData['ville']; 
    this.type    = this.relationData['type'];
    this.partenaire = this.relationData['partenaire'];

    console.log('--------Adresse--------', this.adresse); 
    console.log('--------Type--------', this.type); 
    console.log('--------Partenaire-------', this.partenaire);

    this.relationData.nomContact = ''; 
    this.relationData.prenomContact = ''; 
    this.relationData.email = ''; 
    this.relationData.adresse = ''; 
    this.relationData.mobile = ''; 
    this.relationData.commentaire = ''; 

    this.validateForm(); 
  }


  mettreEnRelation(){
    let URLRelation = this.API + 'api_insert_prescription_mobile.php'; 

    console.log('-----------------------URL RELATION-----------------------', URLRelation); 

    let data =  {
                    id_affiliate: this.idAffiliate,
                    email: this.relationData.email,
                    mobile: this.relationData.mobile,
                    s_sub_category_code: this.relationData.service,
                    villevalue : this.relationData.ville_value,
                    nom: this.relationData.nomContact,
                    prenom: this.relationData.prenomContact,
                    commentaires: this.relationData.commentaire,
                    t_sub_category:'',
                    ville: this.relationData.ville,
                    villelatitude: this.relationData.latitude,
                    villelongitude: this.relationData.longitude,
                    adresse: this.relationData.adresse,
                    partner: this.relationData.partenaire,
                    first_id_partenaire_algorithme: this.relationData.partenaire_value
                }
      console.log('**********************RELATION DATA**********************', data); 
      this.http
          .post(URLRelation, data)
          .subscribe(
            data => {

              console.log('DADADADA', data);
              let response = JSON.parse(data['_body']); 
              console.log('[[[[[[RELATION]]]]]', response);

              if(response['data'] == 1 ){
                this.showAlert(" ", "Recommandation effectuée avec succès.", "OK"); 
                this.relationData = {};
                this.navCtrl.setRoot(AccueilPage);  
              }else {
                this.showAlert(" ", response['ERROR_MESSAGE'], "OK"); 
              }

            }, 
            error => {
              console.log('error mise en relation', error);
            }
          )
  }

  validateForm(){
    this.miseEnRelationForm = this.fb.group({
      "nom": ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "prenom": ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "mobile" : ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\.]+$')])],
      "email":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
      "adresse" : ['', Validators.compose([Validators.required, Validators.minLength(6), Validators.pattern('^[a-zA-Z0-9-_àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+')])],
      "commentaire":['', Validators.compose([Validators.required, Validators.minLength(10)])], 
    });
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


  goToType(){
    //this.navCtrl.setRoot(Miseenrelation4Page); 
    this.navCtrl.popToRoot(this.navCtrl.getByIndex(2)); 
  }

  goToAdresse(){
    //this.navCtrl.setRoot(Miseenrelation3Page); 
    this.navCtrl.popToRoot(this.navCtrl.getByIndex(1)); 
  }

  goToPartenaire(){
    this.navCtrl.pop(); 
  }

}
