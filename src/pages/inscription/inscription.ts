import { Component, NgZone } from '@angular/core';
import { NavController, AlertController, Platform, NavParams, LoadingController, ModalController, ViewController } from 'ionic-angular';
import { Http } from '@angular/http';
import { Validators, FormBuilder, FormGroup} from '@angular/forms';

import { BundlesPage } from '../bundles/bundles';
import { AccueilPage } from '../accueil/accueil';
import { LoginPage } from '../login/login';

declare var google: any;

@Component({
  selector: 'page-inscription',
  templateUrl: 'inscription.html'
})

export class InscriptionPage {

  //objet user avec les parametres de l'utilisateur
  user = {
    "gender": '',
    "nom": '',
    "prenom": '',
    "telephone": '',
    "email": '',
    "confirmEmail":'',
    "codePostal": '',
    "ville": '',
    "place": '',
    "dateNaissance": '',
    "numSecuriteSociale": '',
    "idParrain": '',
    "nomParrain": '',
  }

  nomParrain: any;
  response:any;
  //objet utilisé pour valider les champs voir fonction validateForm
  inscriptionForm: FormGroup;

  API:any;

  el;

  //autocomplete variables
  address:any;
  autocompleteItems;
  autocomplete;

  service = new google.maps.places.AutocompleteService();

  hide:boolean = true;
  hideDescription:boolean = true;

  placesService:any;

  map: any;

  desc:string = '';

  inscrire:any;

  components = {
                  route: { set: false, short:'', long:'' },
                  street_number: { set: false, short:'', long:'' },
                  sublocality_level_1: { set: false, short:'', long:'' },
                  locality: { set: false, short:'', long:'' },
                  administrative_area_level_2: { set: false, short:'', long:'' },
                  administrative_area_level_1: { set: false, short:'', long:'' },
                  country: { set: false, short:'', long:'' },
                  postal_code: { set: false, short:'', long:'' },
                  postal_code_suffix: { set: false, short:'', long:'' },
                }
    codePostal:any = '';
    ville:any = '';

  constructor(public navCtrl: NavController,public alertController: AlertController, public platform: Platform ,public params: NavParams,public viewCtrl: ViewController, public zone:NgZone ,public modalCtrl: ModalController, public fb:FormBuilder, public http:Http, public loadingController:LoadingController) {
    console.log("Hello Inscription Page");

    this.el = document.getElementById('autocomplete');

    this.autocompleteItems = [];
    this.autocomplete = {
      query: ''
    };

    this.API = localStorage.getItem('api');

    this.validateForm();

    if(this.params){
      this.user.nom = this.params.get('nom');
      this.user.prenom = this.params.get('prenom');
      this.user.telephone = '';
      this.user.email = this.params.get('email');
      this.user.confirmEmail = this.params.get('email');
      this.user.ville = this.params.get('city');
      //this.user.gender = this.params.get('gender');
      //this.user.dateNaissance = (new Date(this.params.get('birthday'))).toISOString();

      console.log(this.params.get('nom'));
      console.log(this.params);
    }

    //autocomplete places
    this.initialize();

    console.log("components", this.components);

     // when platform ready, init map
      platform.ready().then(() => {
        console.log('ready');
        // init map
        //Paris - France
        this.initMap();
      });
  }

  /* begin autocomplete places methods */
   private initMap() {

        let latLng = new google.maps.LatLng(48.866667, 2.333333);
        let divMap = document.getElementById('map');
        this.map = new google.maps.Map(divMap, {
            center: latLng,
            zoom: 15,
            disableDefaultUI: true,
            draggable: false,
            zoomControl: true
        });

        console.log(this.map);

        this.placesService = new google.maps.places.PlacesService(this.map);

        let self = this;

         this.placesService.getDetails({placeId: "ChIJl1LUi21u5kcRihrAska0tBg"}, function(place, status){

            for (var i = 0; i < place.address_components.length; i++) {
              let addressType = place.address_components[i].types[0];

              console.log("address type", addressType);
              console.log("components: ", self.components);

              let values = {
                        short_name: place.address_components[i]['short_name'],
                        long_name: place.address_components[i]['long_name']
                    };
              if(self.components[addressType]){
                  self.components[addressType].set = true;
                  self.components[addressType].short = place.address_components[i]['short_name'];
                  self.components[addressType].long = place.address_components[i]['long_name'];
              }
            }

            console.log(self.components);
          });

        console.log(self.placesService);
    }

   updateSearch() {
    this.hide = false;

    if (this.autocomplete.query == '') {
      this.autocompleteItems = [];
      return;
    }
    let me = this;
    this.service.getPlacePredictions({ input: this.autocomplete.query, componentRestrictions: {country: 'FR'} }, function (predictions, status) {
      me.autocompleteItems = [];
      me.zone.run(function () {
        /* start if */
        if(predictions){
          predictions.forEach(function (prediction) {
            var request = {
              placeId: prediction.place_id
            };
            me.autocompleteItems.push(prediction.description);

            me.placesService.getDetails({placeId: prediction.place_id}, function(place, status){

              for (var i = 0; i < place.address_components.length; i++) {
                let addressType = place.address_components[i].types[0];

                let values = {
                          short_name: place.address_components[i]['short_name'],
                          long_name: place.address_components[i]['long_name']
                      };
                if(me.components[addressType]){
                    me.components[addressType].set = true;
                    me.components[addressType].short = place.address_components[i]['short_name'];
                    me.components[addressType].long = place.address_components[i]['long_name'];
                }
              }

              console.log("place details", me.components);
              me.user.codePostal = me.components['postal_code']['long'];
              me.user.ville = me.components['locality']['long'];

              console.log("code postal: ", me.codePostal);
              console.log("ville: ", me.ville);
            });

          });

        }
      });
    });
  }

  chooseItem($event, item){
    console.log($event);
    console.log("item", item);
    this.hide = true;
    this.desc = item;
    this.hideDescription = false;
  }

  dismiss(){
    this.hide = true;
  }

  initialize(){
    this.autocompleteItems = [];

    this.autocomplete = {
      query: ''
    };

    this.address = {
      places: ''
    };
  }
  /* end autocomplete places methods */

  //fonction pour valider les champs cote client
  validateForm(){

    this.inscriptionForm = this.fb.group({
       "nom": ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "prenom":  ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "telephone" : ['', Validators.compose([Validators.required, Validators.pattern('^[\+0-9]+$')])],
       "email":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
       "confirmEmail":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
       "codePostal" :  ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
       "ville": ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "dateNaissance": ['', Validators.required],
       "numSecuriteSociale": ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.pattern('^[0-9\. ]+$')])],
       "idParrain": ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
       "nomParrain": ['', Validators.compose([Validators.required, Validators.maxLength(20), Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
    });

  }

  //fonction lorsque l'utilisateur clique sur le button devenir membre
  inscrireMembre(){
    this.nomParrain = this.user.nomParrain.split(' ')[0];

    this.inscrire = true;

    localStorage.setItem('inscrire', this.inscrire);

    let URL = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_inscription_mobile.php'
              +'?first_name='+this.user.prenom
              +'&last_name='+this.user.nom
              +'&phone_number='+this.user.telephone
              +'&email='+this.user.email
              +'&email2='+this.user.confirmEmail
              +'&zip_code='+this.user.codePostal
              +'&city='+this.user.ville
              +'&birth_date='+this.user.dateNaissance
              +'&id_parrain='+this.user.idParrain
              +'&name_parrain='+this.user.nomParrain
              +'&num_securite_sociale='+this.user.numSecuriteSociale

    console.log("URL INSCRIPTION", URL);

    this.http.get(URL).subscribe(data =>{
      this.response = JSON.parse(data['_body']);

      console.log("::response//", this.response);

        this.showAlert(" ", this.response['msg_error'], "OK");

        console.log("::RESPONSE::", this.response);

        if(this.response['data'] == 100){

            localStorage.setItem('id_affiliate', this.response['id_affiliate']);

            // let URLInfo = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php'
            //               +'&term='+this.response['id_affiliate'];
            //
            //     this.http.get(URLInfo).subscribe((data)=>{
            //         let response = JSON.parse(data['_body']);
            //
            //         localStorage.setItem('password', response['password']);
            //
            //     }, (error) => {
            //       console.log("error", error);
            //     });

            this.navCtrl.setRoot(AccueilPage);
        }

    },error => {
      console.log("ERROR INSCRIPTION", error);
    });
  }

   //fonction generique pour afficher le LoadingController
   showLoading(){
     let loading = this.loadingController.create({
         content: "Connexion...",
         duration: 500
      });

      loading.present();
   }

  //fonction generique pour afficher les alertes
  showAlert(mytitle,mysubTitle,mybuttons) {
       let alert = this.alertController.create({
           title: mytitle,
           subTitle: mysubTitle,
           buttons: [mybuttons]
       });
       alert.present();
   }

}
