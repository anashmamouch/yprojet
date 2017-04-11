import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http';

import {Validators, FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'page-entreprise',
  templateUrl: 'entreprise.html'
})
export class EntreprisePage {

  entreprise = {
    'nom': '',
    'type': '',
    'numTVA': '',
    'numSiret': ''
  }

  entrepriseForm: FormGroup;
  API:any;
  idAffiliate:any;

  constructor(public navCtrl: NavController, public fb:FormBuilder, public http:Http, public alertController:AlertController) {
    this.idAffiliate = localStorage.getItem('id_affiliate');
    this.API = localStorage.getItem('api');

    this.getInfoEntreprise();
    this.validateEntreprise();
  }

  getInfoEntreprise(){
    let URL: string = this.API+'/api_return_info_affiliate.php?term='+this.idAffiliate;

    this.http.get(URL).subscribe((data) => {
      let response = JSON.parse(data['_body']);

      this.entreprise.nom = response.entreprise_name;
      this.entreprise.type = response.entreprise_type;
      this.entreprise.numTVA = response.TVA_INTRA;
      this.entreprise.numSiret = response.SIRET;

    }, (error) => {
      console.log('error entreprise', error);
    });
  }

  validateEntreprise(){
    this.entrepriseForm = this.fb.group({
      "nom" : ['', Validators.compose([Validators.required, Validators.minLength(2), Validators.pattern('^[a-zA-Z0-9-_àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+')])],
      "numSiret" :  ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.pattern('^[0-9\. ]+$')])],
      "numTVA" :  ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.pattern('^[a-zA-Z0-9\. ]+$')])],
    })
  }

  modifierEntreprise(){
    let URLEntreprise:string = 'http://'+ this.API + '/Y_PROJECT/scripts/api_mobile/api_update_entreprise.php'
                                +'?id_affiliate='+this.idAffiliate
                                +'&entreprise_type='+this.entreprise.type
                                +'&entreprise_name='+this.entreprise.nom
                                +'&SIRET='+this.entreprise.numSiret
                                +'&TVA_INTRA='+this.entreprise.numTVA

    console.log('<--url entreprise-->', URLEntreprise);

    this.http.get(URLEntreprise).subscribe((data)=>{
      let response = JSON.parse(data['_body']);

      this.showAlert(" ", response['msg_alert'], "OK");
    }, (error) => {
      console.log('error url entreprise', error);
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
}
