import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { ProfilePage } from '../profile/profile';

import { Http } from '@angular/http';

@Component({
  selector: 'page-filleuls',
  templateUrl: 'filleuls.html'
})
export class FilleulsPage {

  params:any;

  filleuls:any = [];
  images:any = [];

  fullName:any;
  image:any;

  API:any;
  idAffiliate:any; 

  constructor(public navCtrl: NavController, public http:Http, public navParams: NavParams) {
      console.log('Hello Filleuls Page');

      this.API = localStorage.getItem('api');
      this.idAffiliate = localStorage.getItem('id_affiliate'); 

      let URL = this.API + '/api_return_affilies_niv1.php?term=' + this.idAffiliate; 
      console.log('RETURN AFFILIES', URL); 

      this.http
          .get(URL)
          .subscribe(
            data => {
              console.log('<<<DATA>>>', data); 
              this.filleuls = JSON.parse(data['_body']); 

              for(let i = 0; i < this.filleuls.length; i++){
                this.images.push(this.API.split("scripts")[0] + this.filleuls[i]['photo_profil']); 
              }


              console.log('######################---FILLEULS---######################', this.filleuls);
              console.log('++IMAGES++', this.images); 
            }, 
            error => {
              console.log('RETURN AFFILIES ERROR', error);
            }
          )
      }

  goToProfile(index){
    let idAffiliate = this.filleuls[index]['id_affiliate'];
    let firstName = this.filleuls[index]['first_name'];
    let lastName = this.filleuls[index]['last_name'];

    console.log(this.filleuls[index]); 

    this.navCtrl.push(ProfilePage, {params: this.filleuls[index]}); 
  }

}
