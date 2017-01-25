import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

/*
  Generated class for the Detailspack page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-detailspack',
  templateUrl: 'detailspack.html'
})
export class DetailsPackPage {

  pack:any;
  date:string; 

  constructor(public navCtrl: NavController, public navParams: NavParams) {
    this.pack = this.navParams.get('pack'); 

    if(this.pack['prix_pack_ttc'] == 0){
      this.pack['prix_pack_ttc'] = "Gratuit"
    }else { 
      this.pack['prix_pack_ttc'] = Math.round( this.pack['prix_pack_ttc'] ) + " €/mois"; 
    }

    let dateArray = this.pack['date_debut_abonnement'].split(' ')[0].split('-'); 

    console.log("pack", this.pack); 
  }

}
