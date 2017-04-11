import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';
import { Http } from '@angular/http';
import { FilleulsPage } from '../filleuls/filleuls';
import { PersonnelPage } from '../personnel/personnel';
import { ParrainPage } from '../parrain/parrain';


@Component({
  selector: 'page-monequipe',
  templateUrl: 'monequipe.html'
})
export class MonequipePage {
  nombreAffilieNiv1:any;
  nombreAffilieNiv2:any; 
  nombreAffilie:any;
  recoEquipe:any; 
  remPotentielle:any;
  remEncaisse:any;

  segment:any;

  constructor(public navCtrl: NavController, public http:Http) {
    console.log('Hello Mon Equipe');

    this.segment = 'equipe';

    if(localStorage.getItem('nb_reco_level_1') && localStorage.getItem('gain_potentiel') && localStorage.getItem('commission_a_encaisser') && localStorage.getItem('nb_filleul_total') && localStorage.getItem('nb_affiliate_level_1') && localStorage.getItem('nb_affiliate_level_2')){
      this.nombreAffilieNiv1 = localStorage.getItem('nb_affiliate_level_1'); 
      this.nombreAffilieNiv2 = localStorage.getItem('nb_affiliate_level_2'); 
      this.nombreAffilie = localStorage.getItem('nb_filleul_total'); 
      this.recoEquipe = localStorage.getItem('nb_reco_total'); 
      this.remPotentielle = localStorage.getItem('gain_potentiel'); 
      this.remEncaisse = localStorage.getItem('commission_a_encaisser');
    }else {
      this.nombreAffilieNiv1 = 0 ; 
      this.nombreAffilieNiv2 = 0 ; 
      this.nombreAffilie = 0 ; 
      this.recoEquipe = 0 ; 
      this.remPotentielle = 0 ; 
      this.remEncaisse = 0 ;
    }
  }

  affilieNiv1(){
    this.navCtrl.push(FilleulsPage);
  }

  selectProfile(){
    this.navCtrl.setRoot(PersonnelPage);
  }

  selectEquipe(){
    console.log('select Equipe');
  }

  selectParrain(){
    this.navCtrl.setRoot(ParrainPage);
  }
  
}
