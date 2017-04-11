import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Miseenrelation4Page } from '../miseenrelation4/miseenrelation4'; 
import { Http } from '@angular/http'

@Component({
  selector: 'page-miseenrelation3',
  templateUrl: 'miseenrelation3.html'
})

export class Miseenrelation3Page {

  geoCode:string; 
  relationData:any; 
  typeList:any;  
  API:any;

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {
    console.log('<------------------MISE EN RELATION PAGE------------------>');
    this.geoCode =  "http://nosrezo.com/scripts/API_MOBILE/api_city_getautocomplete.php?term=:keyword"; 

    this.relationData = { }; 
    this.typeList = []; 

    this.API = localStorage.getItem('api'); 

  }

    onChangeVille(data){

    if(data.constructor ===  { }.constructor ){

      console.log('********************VILLE SELECTED********************', data); 

      this.relationData.ville = data.label.split(" ")[2]; 
      this.relationData.ville_value = data.value;
      this.relationData.latitude = data.latitude;
      this.relationData.longitude = data.longitude;
      this.relationData.country = data.country; 

      let URLType = this.API + 'api_service_mobile2.php?term=' 
                    + localStorage.getItem('id_partenaire_is_iad') 
                    + '&country=' + this.relationData.country; 

      console.log('<<<< URL TYPE >>>>', URLType); 

      this.http
          .get(URLType)
          .subscribe(
            data => { 
              console.log('data', data); 


              this.typeList = JSON.parse(data['_body']);
              console.log('#####TYPE LIST#####', this.typeList); 
              this.navCtrl.push(Miseenrelation4Page, { typeList: this.typeList, relationData: this.relationData }); 
            }, 
            error => {
              console.log('error', error); 
            }
          )

    }else{
      console.log('DATA -->', data); 
    } 
  }

}
