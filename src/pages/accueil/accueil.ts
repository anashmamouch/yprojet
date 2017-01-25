import { Component , ViewChild } from '@angular/core';
import { NavController, ViewController, NavParams} from 'ionic-angular';
import { Http } from '@angular/http';

import CountUp from 'countup.js';

import { Stats1Page } from '../stats1/stats1';
import { Stats2Page } from '../stats2/stats2';
import { Stats3Page } from '../stats3/stats3';
import { PacksPage } from '../packs/packs';
import { BundlesPage } from '../bundles/bundles';

import { Api } from '../../providers/api';

@Component({
  selector: 'page-accueil',
  templateUrl: 'accueil.html',
})

export class AccueilPage {

  demo:any =  {} ;
  demo1:any;
  demo2:any;

  options:any = {
      useEasing : true,
      useGrouping : true,
      separator : ' ',
      decimal : '.',
      prefix : '',
      suffix : ''
  };

  items: Array<any>;

  API:any;
  idAffiliate:any;

  response:any;
  responseRemEnCours:any;
  responseRemEquipe:any;

  nombreFilleuls:any;

  cagnotte:any = '';

  nomPack:any = ' ';
  prixPack:any = ' ';
  imagePack:any= ' ';
  dateAbonnement:any;

  avantages:any = [];
  images:any = [];

  @ViewChild('counter') counter:any;
  @ViewChild('counter1') counter1:any;
  @ViewChild('counter2') counter2:any;

  constructor(public navCtrl: NavController,public api: Api, public navParams: NavParams , public vc:ViewController, public http:Http) {
    console.log("Hello Accueil Page");
  }

  goToPacks(){
    this.navCtrl.push(PacksPage);
  }

  goToBundles(){
    this.navCtrl.push(BundlesPage);
  }

  goToPersonnel(){
    //this.navCtrl.push(PersonnelPage);
  }

  getData(){
    this.API = localStorage.getItem('api');
    this.idAffiliate = localStorage.getItem('id_affiliate');

    let URL:string = "http://"+this.API+"/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term="+this.idAffiliate;
    let URLRemEnCours = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_statistique_remuneration_en_cours.php?term="+this.idAffiliate;
    let URLRemEquipe = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_statistique_remuneration_equipe.php?term="+this.idAffiliate;

    this.http.get(URL).subscribe((data)=>{
      this.response = JSON.parse(data['_body']);

      console.log("::response::", this.response);

      if(this.response['creation_date']){

          this.nombreFilleuls = this.response['nbr_filleul'];

          console.log("nombre filleuls: ", this.nombreFilleuls);

          this.nomPack = this.response['nom_bundle_en_cours'];
          this.prixPack = Math.round(parseFloat(this.response['prix_pack_ttc']));

          var dateArray = this.response['date_debut_abonnement'].split(' ')[0].split('-');

          this.dateAbonnement ="souscrit le "+  dateArray[2] + "/" + dateArray[1] + "/" + dateArray[0];

          if(this.prixPack == 0 ){
            this.prixPack = 'Gratuit';
          }else{
            this.prixPack = this.prixPack + " €/mois"
          }

          if(this.nomPack == "Fremium"){
            this.imagePack = "assets/images/bundles/freemium.png";
          }else if (this.nomPack == "Blue Sky"){
            this.imagePack = "assets/images/bundles/bluesky.png";
          }else if(this.nomPack == "Orange Mechanic"){
            this.imagePack = "assets/images/bundles/orangemechanic.png";
          }else if(this.nomPack == "Green Peace"){
            this.imagePack = "assets/images/bundles/greenpeace.png";
          }else if(this.nomPack == "Red Devil"){
            this.imagePack = "assets/images/bundles/reddevil.png";
          }else if(this.nomPack == "Black Star"){
            this.imagePack = "assets/images/bundles/blackstar.png";
          }

          this.avantages = this.response['list_avantages_bundle'];

          for (var i = 0; i < this.avantages.length; i++){
              var link = "assets/images/avantages/" + this.avantages[i]['link_background'];

              this.avantages[i]['avantage_percent'] = Math.round(this.avantages[i]['avantage_percent']);

              console.log("link_background :: ", link);

              this.images.push(link);
          }

          console.log("images", this.images);
          console.log("nombre filleuls", this.nombreFilleuls);
          console.log("nom pack", this.nomPack);
          console.log("prix pack", this.prixPack);
          console.log("date", this.dateAbonnement);
          console.log("avantages", this.avantages);

          this.demo = new CountUp(this.counter.nativeElement, 0, Math.round(parseInt(this.nombreFilleuls)), 0,  2.5, this.options);
      }else {
        this.navCtrl.setRoot(BundlesPage);
      }
        }, (error)=>{
            console.error("error URL Info", error);
      });

    this.http.get(URLRemEnCours).subscribe((data)=>{
      this.responseRemEnCours = JSON.parse(data['_body']);

      this.cagnotte =this.responseRemEnCours[this.responseRemEnCours.length - 1];

      localStorage.setItem('remEnCours', this.cagnotte );

      this.demo1 = new CountUp(this.counter1.nativeElement, 0, Math.round(parseInt(this.cagnotte)) , 0, 2.5, this.options);

      }, (error)=>{
        console.error("error URL Remuneration en cours", error);
    });

    this.http.get(URLRemEquipe).subscribe((data) => {
        this.responseRemEquipe = JSON.parse(data['_body']);

        let remEquipe = this.responseRemEquipe[this.responseRemEquipe.length  - 1];

        localStorage.setItem('remEquipe', remEquipe);

        this.demo2 = new CountUp(this.counter2.nativeElement, 0, remEquipe, 0, 2.5, this.options);

    }, (error) => {
      console.error("error URL Remuneration équipe", error);
    });
  }

  ngAfterViewInit() {

    this.getData();

    setInterval(() => {
      this.demo.start();
      this.demo1.start();
      this.demo2.start();
    }, 300);

  }

   goToRemEnCours(){
      this.navCtrl.push(Stats1Page);
   }

   goToRemMois(){
      this.navCtrl.push(Stats2Page);
   }

    goToFilleuls(){
      this.navCtrl.push(Stats3Page, {'filleuls': this.nombreFilleuls});
   }

}
