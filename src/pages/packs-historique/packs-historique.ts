import { Component } from '@angular/core';
import { NavController, ViewController } from 'ionic-angular';

import { Http } from '@angular/http'; 

import { PacksPage } from '../packs/packs'; 

/*
  Generated class for the PacksHistorique page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-packs-historique',
  templateUrl: 'packs-historique.html'
})
export class PacksHistoriquePage {

  packs:any; 

  API:any; 
  idAffiliate:any;

  response:any;

  URL:string;

  segment:any;

  constructor(public navCtrl: NavController, public viewCtrl: ViewController, public http:Http) {
      console.log('Hello PacksHistoriquePage Page');

      this.packs = []; 
      this.segment = "historiquepacks"; 

      this.getData(); 

  }

  getData(){
    this.API = localStorage.getItem('api'); 
    this.idAffiliate = localStorage.getItem('id_affiliate');

    this.URL = "http://"+this.API+"/Y_PROJECT/scripts/api_mobile/api_historique_bundle.php?term="+this.idAffiliate;

    this.http.get(this.URL).subscribe((data) => {
      this.response = JSON.parse(data['_body']); 

      console.log("historique api", this.response); 

      for(var i = 0; i < this.response.length; i++){

        let dateStartArray = this.response[i]['date_debut_abonnement'].split(" ")[0].split("-"); 
        let dateEndArray = this.response[i]['date_fin_abonnement'].split(" ")[0].split("-"); 
        
        let dateStart = dateStartArray[2] + "/" + dateStartArray[1] + "/" + dateStartArray[0]; 
        let dateEnd = dateEndArray[2] + "/" + dateEndArray[1] + "/" + dateEndArray[0]; 

        let nom = this.response[i]['nom_pack']; 
        let prixPack = Math.round(this.response[i]['prix_pack_ttc']); 
        let facture = Math.round(this.response[i]['montant_facture']); 

        let upgrade = ' '; 

        if(parseInt(this.response[i]['is_upgrade']) == 1 ){ 
          upgrade = "upgrade"; 
        }else if ( parseInt(this.response[i]['is_upgrade']) == 0){
          upgrade = "downgrade";
        } 
        
        console.log("date", this.response[i].date_abonnement); 
        console.log("nom", this.response[i].nom_bundle); 

        this.packs.push({
          nom: nom, 
          date_debut_abonnement: dateStart, 
          date_fin_abonnement: dateEnd, 
          prix: prixPack, 
          facture: facture, 
          upgrade: upgrade,
        }); 
      }

    }, (error) => {
      console.log("error historique bundles: ", error); 
    }); 
  }

  selectHistorique(){
    console.log("historique packs"); 
  }

  selectPacks(){
     this.navCtrl.setRoot(PacksPage); 
  }

}
