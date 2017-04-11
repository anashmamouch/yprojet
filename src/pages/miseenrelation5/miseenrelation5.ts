import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { Miseenrelation6Page } from '../miseenrelation6/miseenrelation6'; 
import { Miseenrelation3Page } from '../miseenrelation3/miseenrelation3'; 
import { Miseenrelation51Page } from '../miseenrelation51/miseenrelation51'; 

import { Http } from '@angular/http'; 


@Component({
  selector: 'page-miseenrelation5',
  templateUrl: 'miseenrelation5.html'
})

export class Miseenrelation5Page {

  partenaireList:any;
  relationData:any; 

  adresse:any; 
  type:any;

  API:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {

    this.partenaireList = this.navParams.get('partenaireList'); 
    this.relationData = this.navParams.get('relationData'); 
    this.API = localStorage.getItem('api'); 

    this.adresse = this.relationData['ville']; 
    this.type    = this.relationData['type'];

    console.log('*** RELATION DATA ***', this.relationData);
  }

  goToType(){
    this.navCtrl.pop(); 
  }

  goToAdresse(){
    this.navCtrl.setRoot(Miseenrelation3Page); 
  }

  onPartenaireSelected(data){
    console.log('********************PARTENAIRE SELECTED********************', data); 


    this.relationData.partenaire = data.partenaire
    this.relationData.partenaire_val = data.val; 

    // let URL = this.API + 'api_infos_partenaire.php?term=' + this.relationData.partenaire_val; 

    // this.http 
    //     .get(URL)
    //     .subscribe(
    //       data => {
    //         let response = JSON.parse(data['_body']); 
    //         console.log('PARTENAIRE RESPONSE', response); 
    //       }, 
    //       error => {
    //         console.log('error', error); 
    //       }
    //     )
    
    console.log('relation data', this.relationData); 
    
    this.navCtrl.push(Miseenrelation51Page, { relationData: this.relationData, id_affiliate: data.val });

  }
}
