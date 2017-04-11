import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { Http } from '@angular/http'

@Component({
  selector: 'page-aperorezo',
  templateUrl: 'aperorezo.html'
})
export class AperorezoPage {

  aperosrezo:any;
  API:any; 
  idAffiliate:any; 
  image:any; 

  constructor(public navCtrl: NavController, public http: Http) {

    this.API = localStorage.getItem('api'); 
    this.idAffiliate = localStorage.getItem('id_affiliate'); 

    let URL:string = this.API + 'api_return_aperorezo2.php?term='+this.idAffiliate;

    console.log(URL); 

    this.http
        .get(URL)
        .subscribe(
          data => {
            console.log('DATADATADATA', data); 
            let response = JSON.parse(data['_body']); 
            console.log('APERO REZO', response); 
            this.aperosrezo = response;

            for(let i = 0; i < this.aperosrezo.length; i ++){
              console.log('APERO', this.aperosrezo[i]); 

              this.image = this.API.split('scripts')[0] + this.aperosrezo[i]['photo_profil'] ; 
              
              console.log(this.image); 
            }


        }, 
          error => {
            console.log('error', error); 
        });
  }
}
