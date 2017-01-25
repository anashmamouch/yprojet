import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';
import { Http } from '@angular/http';

import { FilleulsPage } from '../filleuls/filleuls';
import { PersonnelPage } from '../personnel/personnel';
import { ParrainPage } from '../parrain/parrain';

/*
  Generated class for the Monequipe page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-monequipe',
  templateUrl: 'monequipe.html'
})
export class MonequipePage {
  nombreAffilieNiv1:any;
  nombreAffilie:any;

  remunEnCours:any;
  remunEncaisse:any;

  API:any;
  idAffiliate:any;
  response:any;

  segment:any;

  params:any = {
    id_affiliate: '',
    first_name: '',
    last_name: '',
  };

  constructor(public navCtrl: NavController, public http:Http) {
    console.log('Hello Mon Equipe');

    this.segment = 'equipe';

    this.API = localStorage.getItem('api');
    this.idAffiliate = localStorage.getItem('id_affiliate');

    if(localStorage.getItem('remEnCours') && localStorage.getItem('remEquipe')){
      this.remunEnCours = localStorage.getItem('remEnCours');
      this.remunEncaisse = localStorage.getItem('remEquipe');
    }else {
      this.remunEnCours = 0;
      this.remunEncaisse = 0;
    }

    this.getData();
  }

  getData(){
    let URL:string = "http://" +this.API+ "/Y_PROJECT/scripts/api_mobile/api_return_affilies_niv1.php?term="+this.idAffiliate;
    let URLInfo:string = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term="+this.idAffiliate;

    this.http.get(URL).subscribe((data)=>{
      this.response = JSON.parse(data['_body']);

      console.log("data ", this.response);

      this.nombreAffilieNiv1 = this.response.length;

    }, (error)=>{
      console.log("error", error);
    });

    this.http.get(URLInfo).subscribe((data) => {
      let response = JSON.parse(data['_body']);

      this.nombreAffilie = response['nbr_filleul'];
    }, (error) => {
      console.log("::error info::", error);
    });
  }

  affilieNiv1(){
    this.navCtrl.push(FilleulsPage, {params: this.response});
  }

  selectProfile(){
    this.navCtrl.setRoot(PersonnelPage);
  }

  selectEquipe(){

  }

  selectParrain(){
    this.navCtrl.setRoot(ParrainPage);
  }


}
