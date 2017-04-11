import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Http } from '@angular/http'; 

@Component({
  selector: 'page-simulateurgains',
  templateUrl: 'simulateurgains.html'
})

export class SimulateurgainsPage {
  nombreAffilies:any; 
  nombreValeur:any;
  nombrePercent:any;

  gainData:any; 
  idAffiliate:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {
    console.log('Simulateur de gains');

    this.idAffiliate = localStorage.getItem('id_affiliate'); 

    this.gainData = {}; 
    

  }

  calculGain(){
    console.log('nombre affilies: ', this.nombreAffilies); 
    console.log('nombre valeur: ', this.nombreValeur); 
    console.log('nombre percent: ', this.nombrePercent); 
    console.log('--------------------------------------'); 

    if(this.nombreAffilies && this.nombreValeur && this.nombrePercent){
      let data = {
        nb_affiliate: this.nombreAffilies, 
        nb_valeur: this.nombreValeur,
        percent_num: this.nombrePercent
      }

      let URL:string = 'http://www.nosrezo.com/scripts/API_MOBILE/api_calcul_gain.php'; 

      this.http
          .post(URL, data)
          .subscribe(
            data => {
              this.gainData = JSON.parse(data['_body'])[0];
          
              console.log('gain data', this.gainData);
            }, 
            error => { 
              console.log('error', error); 
            }
          )
    }
  }

}
