import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { ProfilePage } from '../profile/profile';

import { Http } from '@angular/http';

/*
  Generated class for the Filleuls page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
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

  constructor(public navCtrl: NavController, public http:Http, public navParams: NavParams) {
      console.log('Hello Filleuls Page');

      this.filleuls = this.navParams.get('params');
      this.API = localStorage.getItem('api');

      console.log(this.filleuls);

        for(let p in this.filleuls){
          let URL = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term='+this.filleuls[p]['id_affiliate'];

          this.http.get(URL).subscribe((data) => {
            let response = JSON.parse(data['_body']);

            var image = 'http://' + this.API + '/Y_PROJECT/' + response['photo_profil'];
            this.images.push(image);

            console.log('<<objet>>', response )
          }, (error) => {
            console.log("Error URL image filleuls::", error);
          });

         }
      }

  goToProfile(index){
    let idAffiliate = this.filleuls[index]['id_affiliate'];
    let firstName = this.filleuls[index]['first_name'];
    let lastName = this.filleuls[index]['last_name'];
    this.navCtrl.push(ProfilePage,  { id_affiliate: idAffiliate})
  }

}
