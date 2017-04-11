import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Majrecommandations3Page } from '../majrecommandations3/majrecommandations3'; 

import { Http } from '@angular/http'; 


@Component({
  selector: 'page-majrecommandations2',
  templateUrl: 'majrecommandations2.html'
})
export class Majrecommandations2Page {

  API:any; 
  recoTraiter:any; 
  etapeReco:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {
      this.recoTraiter = this.navParams.get('reco_traiter'); 
      this.etapeReco = ''; 
  }

  choose(data, string){
    console.log('<<RECO-_-DATA>>', data);
    console.log('STRING:::::>>', string); 
    console.log('-----------------DOCUMENTELEMENT', document.getElementById(string)); 

    this.navCtrl.push(Majrecommandations3Page, { etapeReco: data, etapeRecoString:string, recoTraiter: this.recoTraiter }); 
  }

  
}
