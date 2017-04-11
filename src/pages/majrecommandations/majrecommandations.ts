import { Component } from '@angular/core';
import { NavController, NavParams, AlertController } from 'ionic-angular';
import { Validators, FormBuilder, FormGroup} from '@angular/forms';

import { Http } from '@angular/http';

import { Recommandations2Page } from '../recommandations2/recommandations2'; 

@Component({
  selector: 'page-majrecommandations',
  templateUrl: 'majrecommandations.html'
})

export class MajrecommandationsPage {
  
  recoTraiter:any; 
  recommandationsForm:FormGroup; 
  
  delaiRelance:any;
  etapeReco:any;
  montantHonoraires:any;
  description:any;

  API:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public fb:FormBuilder, public http:Http, public alertController:AlertController) {
    this.recoTraiter = this.navParams.get('reco_traiter'); 

    console.log("RECO A TRAITER", this.recoTraiter); 
    console.log("||||||STATUS||||||", this.recoTraiter['r_status']); 

    this.API = localStorage.getItem('api'); 

    this.delaiRelance = ''; 
    this.etapeReco = ''; 
    this.montantHonoraires = this.recoTraiter['r_devis_ttc'];
    this.description = '';

    this.validateForm(); 
  }

  validateForm(){
    this.recommandationsForm = this.fb.group({
      "delaiRelance": ['', Validators.required],
      "etapeReco":['', Validators.required],
      "montantHonoraires":['', Validators.required],
      "description":['', Validators.required],
    }); 
  }

  mettreAJour(){
    console.log("$$$$$$$$$$$$$$$$$  @ METTRE A JOUR @  $$$$$$$$$$$$$$$$$"); 

    let data = { 
            montant_honoraires: this.montantHonoraires, 
            etape_reco: this.etapeReco, 
            id_iad_transaction: this.recoTraiter['id_iad_transaction'],
            delai_relance: this.delaiRelance,
            id_recommandation: this.recoTraiter['id_recommandation'],
            description: this.description
    }

    let URL: string = this.API + 'api_maj_recommandation.php';
    
    this.http
        .post(URL, data)
        .subscribe(
          data => {
            let response = JSON.parse(data['_body']); 
            console.log('^^^^^^^^^^^^DATA^^^^^^^^^^^^', response);

            let msg_info = response[0].msg_info;
            let msg_success = response[0].msg_success;
            let msg_success2 = response[0].msg_success2;
            let msg_danger = response[0].msg_danger;
            let msg_danger2 = response[0].msg_danger2;  
            
            if (response[0].msg_danger2 != "") {
                  this.showAlert('',response[0].msg_danger2, "OK");
              } else
              if (response[0].msg_danger != "") {
                  this.showAlert('', response[0].msg_danger, "OK");
              } else
              if (response[0].msg_success != "") {
                  this.showAlert('', response[0].msg_success, "OK");

              } else
              if (response[0].msg_success2 != "") {
                  this.showAlert('', response[0].msg_success2,"OK");
              }else
              if (response[0].msg_info != "") {
                  this.showAlert('', response[0].msg_info, "OK");
                  this.navCtrl.setRoot(Recommandations2Page); 
              } 
          }, 
          error => {
            console.log('^^^^^^^^^^^^ERROR^^^^^^^^^^^^', error); 
          }
        )
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
