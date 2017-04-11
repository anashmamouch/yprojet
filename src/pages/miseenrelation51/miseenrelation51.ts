import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { Http } from '@angular/http'; 

import { IonProfileHeaderOptions } from '../../components/ion-profile-header'; 

import { Miseenrelation3Page } from '../miseenrelation3/miseenrelation3'; 
import { Miseenrelation4Page } from '../miseenrelation4/miseenrelation4'; 

import { Miseenrelation6Page } from '../miseenrelation6/miseenrelation6'; 

@Component({
  selector: 'page-miseenrelation51',
  templateUrl: 'miseenrelation51.html'
})
export class Miseenrelation51Page {

  blur:any; 

  nom:any; 
  prenom:any;
  image:any;

  API:any; 

  adresse:any; 
  type:any; 

  relationData:any; 

  commentaires:any; 
  nomCommentaire:any;
  prenomCommentaire:any; 

  options:IonProfileHeaderOptions;

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {

    this.relationData = this.navParams.get('relationData');  
    this.API = localStorage.getItem('api'); 

    this.adresse = this.relationData['ville']; 
    this.type = this.relationData['type']; 

    this.commentaires = [ ] ; 

    let URL = "http://www.nosrezo.com/scripts/api_mobile/api_infos_partenaire.php?term="+this.navParams.get('id_affiliate');

    this.blur = { value:'5px',colors: {start:'rgba(43, 40, 50, 0.8)',mid:'rgba(83, 86, 99, 0.8)',end:'rgba(69, 77, 91, 0.6)'}}; 
    this.image = ' ' ; 

    this.setOptions(' ', ' ', ' ');  

    this.http
        .get(URL)
        .subscribe(
          data => {
            let response = JSON.parse(data['_body'])[0];

            this.commentaires = response['commentaires'];

            for(let i = 0; i < this.commentaires.length; i++){
              this.commentaires[i]['nom'] = this.commentaires[i]['nom'].split('')[0]; 
            }

            console.log('COMMENTAIRE', this.commentaires);  

            console.log("<----==RESPONSE==---->", response);

            let URL =  "http://www.nosrezo.com/scripts/API_MOBILE/api_return_info_affiliate.php?term=" + response['id_affiliate'];
            this.http 
                .get(URL)
                .subscribe(
                  data => {
                    let response = JSON.parse(data['_body'])[0]; 
                    console.log('((*************RESPONSE FINAL*************))', response); 

                    this.nom = response['last_name']; 
                    this.prenom = response['first_name']; 
                    this.image = this.API.split("scripts")[0] + '/' + response['photo_profil']; 

                    console.log('____nom____', this.nom); 
                    console.log('____prenom____', this.prenom); 
                    console.log('____image____', this.image); 
                  }, 
                  error => {
                    console.log('error', error); 
                  }
                )
          }, 
          error => { 
            console.log('--ERROR--INFO--AFFILIATE--', error); 
          }
        )
    }

    goToType(){
      this.navCtrl.popTo(this.navCtrl.getByIndex(1)); 
    }

    goToAdresse(){
      this.navCtrl.popTo(this.navCtrl.getByIndex(0))
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

    suivant(){ 
      console.log("--suivant--suivant--suivant--"); 
      this.navCtrl.push(Miseenrelation6Page, {relationData: this.navParams.get('relationData')});
    }


}
