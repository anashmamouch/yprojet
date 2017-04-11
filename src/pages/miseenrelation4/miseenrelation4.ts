import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { Http } from '@angular/http';
import { Miseenrelation5Page } from '../miseenrelation5/miseenrelation5';
import { Miseenrelation41Page } from '../miseenrelation41/miseenrelation41';
import { AccueilPage } from '../accueil/accueil'

@Component({
  selector: 'page-miseenrelation4',
  templateUrl: 'miseenrelation4.html'
})


export class Miseenrelation4Page {
  
  typeList:any; 
  partenaireList:any;
  relationData:any;

  adresse:string;

  API:string; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {

    this.partenaireList = []; 

    this.typeList = this.navParams.get('typeList'); 
    this.relationData = this.navParams.get('relationData'); 

    if(this.relationData != null){
        this.adresse = this.relationData['ville']; 
     }else{
        this.adresse = this.navParams.get('ville'); 
    }

    console.log('<--relationDATA--type-->', this.relationData);
    console.log('++++++++type-list++++++++', this.typeList); 
    
  }

  goBack(){
    this.navCtrl.pop(); 
  }

  info(item){
    console.log('== more info ==', item); 
    this.navCtrl.push(Miseenrelation41Page, {item: item});
  }

  onTypeSelected(data){
    console.log('**********************TYPE SELECTED**********************', data);  

    this.relationData.service = data['id_services'];
    this.relationData.type = data['s_sub_category'];  

    let dataType = {
                      id_affiliate: localStorage.getItem('id_affiliate'),
                      latitude: this.relationData.latitude,
                      longitude: this.relationData.longitude,
                      category: this.relationData.service,
                      id_partenaire_is_iad : localStorage.getItem('id_partenaire_is_iad'),
                      parrain_is_iad : localStorage.getItem('parrain_is_iad'),
                      id_partenaire_du_parrain_1: localStorage.getItem('id_partenaire_du_parrain_1'),
                      service_du_parrain_1 : localStorage.getItem('service_du_parrain_1'),
                      parrain_2_is_iad : localStorage.getItem('parrain_2_is_iad'),
                      id_parrain_2_is_iad : localStorage.getItem('id_parrain_2_is_iad'),
                      id_partenaire_du_parrain_2 : localStorage.getItem('id_partenaire_du_parrain_2'),
                      service_du_parrain_2 : localStorage.getItem('service_du_parrain_2')
                  }

    let URLType = 'http://www.nosrezo.com/scripts/API_MOBILE/api_recherche_partenaires.php'; 

    console.log('[-----------------------URL TYPE-----------------------]', URLType); 

    this.http
        .post(URLType, dataType)
        .subscribe(
          data => {
            this.partenaireList = JSON.parse(data['_body']); 
            console.log('<-partenaire-list->', this.partenaireList); 
            this.navCtrl.push( Miseenrelation5Page, { partenaireList: this.partenaireList, relationData: this.relationData }); 
          }, 
          error =>{
            console.log('error', error); 
          }
        )
}

}
