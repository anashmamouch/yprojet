import { Component } from '@angular/core';
import { NavController, NavParams, AlertController } from 'ionic-angular';

import { Validators, FormBuilder, FormGroup} from '@angular/forms';

import { Http } from '@angular/http'; 

import { Recommandations2Page } from '../recommandations2/recommandations2'; 

@Component({
  selector: 'page-majrecommandations4',
  templateUrl: 'majrecommandations4.html'
})
export class Majrecommandations4Page {

  recoTraiter:any; 
  etapeReco:any; 
  delaiRelance:any; 
  montantHonoraires:any; 
  description:any;

  etapeRecoString:string; 
  delaiRelanceString:string; 

  API:any; 

  recommandationsForm:FormGroup; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http, public fb:FormBuilder, public alertController:AlertController) {
    this.etapeReco = this.navParams.get('etapeReco'); 
    this.delaiRelance = this.navParams.get('delaiRelance'); 
    this.recoTraiter = this.navParams.get('recoTraiter'); 
    this.montantHonoraires = this.recoTraiter['r_devis_ttc'];
    this.description = '';

    this.etapeRecoString = this.navParams.get('etapeRecoString'); 
    this.delaiRelanceString = this.navParams.get('delaiRelanceString'); 

    this.API = localStorage.getItem('api'); 

    this.validateForm(); 

  }

   validateForm(){
    this.recommandationsForm = this.fb.group({
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
