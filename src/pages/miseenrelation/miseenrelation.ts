import { Component } from '@angular/core';
import { NavController, MenuController } from 'ionic-angular';

import { Http } from '@angular/http';

//pages
import { ParrainerPage } from '../parrainer/parrainer';
import { MonequipePage } from '../monequipe/monequipe';


@Component({
  selector: 'page-miseenrelation',
  templateUrl: 'miseenrelation.html'
})
export class MiseenrelationPage {

  id_affiliate:any;
  affiliate:any;

  services:any;

  segments:any;

  relationData:any = {
    codePostal: '' ,
    ville: '',
    type: '',
    partenaire:'',
    nomContact:'',
    prenomContact:'',
    email:'',
    adresse:'',
    mobile:'',
    commentaire:''
  };

  villeList: any[] = [];
  typeList: any[] = [];
  partenaireList: any[] = [];

  geoFound:boolean = false;

  URL:any;

  location:string;

  categories:any[] = [];

  partenaireData:any;

  category:any;

  constructor(public navCtrl: NavController, public menu:MenuController, public http: Http) {
    console.log('Hello MiseenrelationPage Page');
    this.id_affiliate = localStorage.getItem('id_affiliate');

    this.segments = 'miseenrelation';

    this.menu.swipeEnable(true);

    this.geoFound = false;
    this.relationData.partenaire = [];

    let URLInfo = 'http://www.nosrezo.com/scripts/API_MOBILE/api_return_info_affiliate.php?term=' + this.id_affiliate;

    this.http.get(URLInfo).subscribe(data => {

      this.affiliate = JSON.parse(data['_body']);

      console.log("info affiliate", this.affiliate)
      console.log("affiliate", this.affiliate[0]);

      //type
      this.URL = 'http://www.nosrezo.com/scripts/API_MOBILE/api_service_mobile.php?term=' + this.affiliate[0]['id_partenaire_is_iad'] ;

      this.http.get(this.URL).subscribe(data =>{

          this.services = JSON.parse(data['_body']);

          for(let category of this.services){
            this.categories.push(category['s_sub_category']);
          }

          var j = 1;

          for(let cat of this.categories){
            this.typeList.push({ value: cat, text: cat, checked: true});
            j++;
          }

          console.log("services", this.services);
          console.log("categories", this.typeList);
      }, error =>{
        console.log("ERROR service mobile", error);
      });

    }, error => {
      console.log("ERROR info", error);
    });

  }

  checkGeo(){
      if(this.relationData.codePostal){

         let URLLocation = 'http://www.nosrezo.com/scripts/API_MOBILE/api_city_getautocomplete.php?term='+this.relationData.codePostal;

          this.http.get(URLLocation).subscribe(data => {
            this.location = JSON.parse(data['_body']);

            console.log("Location", this.location);

            console.log("ville", this.location[0]['label']);

            let array:any[] = [];

            this.villeList = [];

            this.relationData.ville = this.location;

            for(let loc of this.location){
              array.push(loc['label']) ;
            }

            let i = 1;

            for (let element of this.location){


              if( i == 1){
                this.villeList.push({ value: element['latitude']  +" "+  element['longitude'], text: element['label'], checked: true});
              }else{
                this.villeList.push({ value: element['latitude']  +" "+  element['longitude'], text: element['label'], checked: false});
              }

              i++;
            }

            console.log("ville list", this.villeList);

          }, error =>{
              console.log("error ", error);
          });

          let URLPartenaire = 'http://www.nosrezo.com/scripts/API_MOBILE/api_recherche_partenaires.php';
      }
  }

  onTypeSelected(value){
    if(value == 'Mise en vente de bien'){

    }

    this.category = value;

    console.log("selected value: ", value)

    this.partenaireList = ['anas', 'simo', 'youssef', 'jocking', 'brother'];
  }

  trouvezVille($event){
    console.log("Trouvez la ville");
    console.log($event);
    this.checkGeo();
  }

  onChangeVille(data){

    let latitude = data.split(" ")[0];
    let longitude = data.split(" ")[1];


    console.log("latitude: "+ latitude);
    console.log("longitude: "+ longitude);

    console.log("affiliate", this.affiliate);

    let params = {
      id_affiliate: this.affiliate['id_affiliate'] ,
      latitude: latitude ,
      longitude: longitude ,
      category: this.category,
      id_partenaire_is_iad: this.affiliate['id_partenaire_is_iad'] ,
      parrain_is_iad: this.affiliate['parrain_is_iad'] ,
      id_partenaire_du_parrain_1: this.affiliate['id_partenaire_du_parrain_1'] ,
      service_du_parrain_1: this.affiliate['service_du_parrain_1'] ,
      parrain_2_is_iad : this.affiliate['parrain_2_is_iad'] ,
      id_partenaire_du_parrain_2: this.affiliate['id_partenaire_du_parrain_2'],
      service_du_parrain_2: this.affiliate['service_du_parrain_2'],
    }

    console.log("params of partenaires", params);

    //partenaire api call
    let URLPartenaire = "http://www.nosrezo.com/scripts/API_MOBILE/api_recherche_partenaires.php";

  }

  mettreEnRelation(){
    console.log("Mettre En Relation");
  }

  selectMiseEnRelation(){
    console.log(".. mise en relation ..");
  }

  selectParrainerAmi(){
    this.navCtrl.setRoot(ParrainerPage);
  }

  selectMonEquipe(){
    this.navCtrl.setRoot(MonequipePage);
  }

}
