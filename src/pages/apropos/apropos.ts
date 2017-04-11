import { Component } from '@angular/core';
import { Platform } from 'ionic-angular';
import { NavController, NavParams } from 'ionic-angular';


import { CguPage } from '../cgu/cgu'; 
import { CgiPage } from '../cgi/cgi'; 
import { CodebonsensPage } from '../codebonsens/codebonsens';  
import { ConceptPage } from '../concept/concept'; 


@Component({
  selector: 'page-apropos',
  templateUrl: 'apropos.html'
})

export class AproposPage {

  listInfo:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public platform:Platform) {

    this.listInfo = {  }; 

    this.listInfo.nb_affiliate_level_1 = localStorage.getItem('nb_affiliate_level_1'); 
    this.listInfo.nb_affiliate_level_2 = localStorage.getItem('nb_affiliate_level_2'); 
    this.listInfo.lien_webinar = localStorage.getItem('lien_webinar'); 
    this.listInfo.telephone_service_qualite = localStorage.getItem('telephone_service_qualite'); 
    this.listInfo.first_name_owner = localStorage.getItem('first_name'); 
    this.listInfo.phone_number = localStorage.getItem('phone_number');

    console.log('###############LIST INFO###############', this.listInfo); 

    this.platform.ready().then(() =>{
      //cordova inappbrowser
    })
  }

  conceptNosRezo(){
    console.log('concept nosrezo'); 
    this.navCtrl.push(ConceptPage); 
  }

  presentationsEnligne(){
    console.log('presentations en ligne'); 
  }

  calendrierPresentations(){
    console.log('calendrier presentations'); 
  }

  serviceQualiteTelephone(){
    console.log('service qualite telephone'); 
  }

  serviceQualiteMail(){
    console.log('service qualite mail'); 
  }

  conditionsGeneralesUtilisations(){
     console.log('conditions generales utilisations'); 
     this.navCtrl.push(CguPage); 
  }

  conditionsGeneralesInscription(){
     console.log('conditions generales inscription');
     this.navCtrl.push(CgiPage);  
  }

  codeBonSensNosRezo(){
     console.log('code bon sens nosrezo'); 
     this.navCtrl.push(CodebonsensPage);
  }

  likeFacebookPage(){

  }

  avisAppStore(){

  }


}
