import { Component } from '@angular/core';
import { NavController, ViewController } from 'ionic-angular';
import { Http } from '@angular/http';
import { PacksHistoriquePage } from '../packs-historique/packs-historique';

@Component({
  selector: 'page-packs',
  templateUrl: 'packs.html'
})

export class PacksPage {

  URL:any;

  response:any

  API:any;
  idAffiliate:any;

  packs:any = [];
  historiquepacks:any = [];

  segment:any;

  upgrade:any;
  downgrade:any;

  constructor(public navCtrl: NavController, public viewCtrl: ViewController, public http:Http) {
    console.log('Hello PacksPage Page');

    this.segment = "packs";

    this.API = localStorage.getItem('api');
    this.idAffiliate = localStorage.getItem('id_affiliate');

    this.upgrade = false;
    this.downgrade = false;

    this.getPacks();
    this.getHistoriquePacks();
  }

  getPacks(){

    this.URL = "http://"+this.API+"/Y_PROJECT/scripts/api_mobile/api_mes_packs.php?term="+this.idAffiliate;

    this.http.get(this.URL).subscribe((data) => {
        this.response = JSON.parse(data['_body']);

        console.log("mes packs", this.response);

        for (var i = 0; i < this.response.length; i++){

          console.log("item "+ i, this.response[i]);
          let nomPack = this.response[i]['nom_pack'];
          let prixPack = this.response[i]['prix_pack_ttc'];

          let upgrade = false;
          let downgrade = false;

          if(this.response[i]['status'] == "upgrade"){
            upgrade = true;
            downgrade = false;
          }else if (this.response[i]['status'] == "downgrade"){
            upgrade = false;
            downgrade = true;
          }

          prixPack = Math.round(prixPack);

          let dateStartArray = this.response[i]['date_debut_abonnement'].split(" ")[0].split("-");
          let dateStart = dateStartArray[2] + "/" + dateStartArray[1] + "/" + dateStartArray[0];
          let activated = parseInt(this.response[i]['is_activated']);
          let active = '';

          if( activated == 1 ){
            active = "Activé";
          }else if (activated == 0){
            active = "Désactivé";
          }

          this.packs.push({
              nom: nomPack,
              date_debut_abonnement: dateStart,
              prix: prixPack,
              active: active,
              upgrade: upgrade,
              downgrade:downgrade
          });


        }
        console.log("<--((packs))-->", this.packs);

    }, (error) => {
          console.log("error packs: ", error);
    });

  }

  getHistoriquePacks(){

    let URLHistorique = "http://"+this.API+"/Y_PROJECT/scripts/api_mobile/api_historique_bundle.php?term="+this.idAffiliate;

    this.http.get(URLHistorique).subscribe((data) => {
      this.response = JSON.parse(data['_body']);

      console.log("historique api", this.response);

      for(var i = 0; i < this.response.length; i++){

        let dateStartArray = this.response[i]['date_debut_abonnement'].split(" ")[0].split("-");
        let dateEndArray = this.response[i]['date_fin_abonnement'].split(" ")[0].split("-");
        let dateStart = dateStartArray[2] + "/" + dateStartArray[1] + "/" + dateStartArray[0];
        let dateEnd = dateEndArray[2] + "/" + dateEndArray[1] + "/" + dateEndArray[0];
        let nom = this.response[i]['nom_pack'];
        let prixPack = Math.round(this.response[i]['prix_pack_ttc']);
        let facture = Math.round(this.response[i]['montant_facture']) ;
        let upgrade = ' ';
        if(parseInt(this.response[i]['is_upgrade']) == 1 ){
          upgrade = "upgrade";
        }else if ( parseInt(this.response[i]['is_upgrade']) == 0){
          upgrade = "downgrade";
        }

        this.historiquepacks.push({
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


}
