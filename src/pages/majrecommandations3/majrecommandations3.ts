import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { Majrecommandations4Page } from '../majrecommandations4/majrecommandations4'; 

@Component({
  selector: 'page-majrecommandations3',
  templateUrl: 'majrecommandations3.html'
})
export class Majrecommandations3Page {

  recoTraiter:any; 
  etapeReco:any;
  etapeRecoString:any; 
  delaiRelance:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams) {
    this.recoTraiter = this.navParams.get('recoTraiter'); 
    this.etapeReco = this.navParams.get('etapeReco'); 
    this.etapeRecoString = this.navParams.get('etapeRecoString'); 

    console.log('ETAPE RECO >>>', this.etapeReco); 
    console.log('RECO TRAITER >>>', this.recoTraiter); 
  }

  clickOption(data){
    console.log('delaiRelance ---> ', data);
    this.navCtrl.push(Majrecommandations4Page, { etapeReco: this.etapeReco, recoTraiter:this.recoTraiter, delaiRelance: this.delaiRelance});  
  }

  choose(data, string){
    console.log('DATA ---->', data);
    console.log('STRING ---->', string); 
    this.navCtrl.push(Majrecommandations4Page, { etapeReco: this.etapeReco, etapeRecoString: this.etapeRecoString, recoTraiter:this.recoTraiter, delaiRelance: this.delaiRelance, delaiRelanceString: string });  
  }

}
