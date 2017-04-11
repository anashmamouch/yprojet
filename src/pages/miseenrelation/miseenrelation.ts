import { Component } from '@angular/core';
import { NavController, AlertController} from 'ionic-angular';

import { Http } from '@angular/http';

import { AccueilPage } from '../accueil/accueil'; 

import {Validators, FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'page-miseenrelation',
  templateUrl: 'miseenrelation.html'
})
export class MiseenrelationPage {
  
  idAffiliate:string; 
  API:string;
  
  relationData:any;

  villeList: any[];  
  typeList: any[];  
  partenaireList: any[];
  miseEnRelationForm:any;   

  constructor(public navCtrl:NavController, public fb:FormBuilder, public alertController: AlertController, public http:Http){

    this.idAffiliate = localStorage.getItem('id_affiliate'); 
    this.API = localStorage.getItem('api'); 

    this.villeList = []; 
    this.typeList = []; 
    this.partenaireList = []; 

    this.relationData = {
                          codePostal: '' ,
                          ville: '',
                          ville_value:'',
                          latitude:'',
                          longitude:'',
                          country:'',
                          partenaire:'',
                          partenaire_value: '', 
                          type:'', 
                          nomContact:'',
                          prenomContact:'',
                          email:'',
                          adresse:'',
                          mobile:'',
                          commentaire:''
                        }
    this.validateForm(); 
    
  }

  onChangeCodePostal(data){
    console.log('********************CODE POSTAL SELECTED********************', data); 
  }

  trouverVille(data){
    console.log('TROUVER LA VILLE', data); 

    if(this.relationData.codePostal){
      let URLLocation = 'http://www.nosrezo.com/scripts/API_MOBILE/api_city_getautocomplete.php?term='
                        +this.relationData.codePostal;

      console.log('-----------------------URL LOCATION-----------------------', URLLocation); 
      this.http
          .get(URLLocation)
          .subscribe(
            data => { 
              this.villeList = JSON.parse(data['_body']);
              console.log('%%AUTOCOMPLETE%%', this.villeList); 
            }, 
            error => {
              console.log('error', error); 
            }
          )
    }

  }

  onChangeVille(data){
      console.log('********************VILLE SELECTED********************', data); 

      this.relationData.ville = data.label.split(" ")[2]; 
      this.relationData.ville_value = data.value;
      this.relationData.latitude = data.latitude;
      this.relationData.longitude = data.longitude;
      this.relationData.country = data.country; 

      let URLType = 'http://www.nosrezo.com/scripts/API_MOBILE/api_service_mobile2.php?term=' 
                    + localStorage.getItem('id_partenaire_is_iad') 
                    + '&country=' + this.relationData.country; 
      console.log('<< URL TYPE >>', URLType); 

      this.http
          .get(URLType)
          .subscribe(
            data => { 
              this.typeList= JSON.parse(data['_body']);
              console.log('TYPE____LIST', this.typeList); 
            }, 
            error => {
              console.log('error', error); 
            }
          )
  }

  onTypeSelected(data){
      console.log('**********************TYPE SELECTED**********************', data);  

      this.relationData.service = data['id_services']; 

      let dataType = {
                        id_affiliate: localStorage.getItem('id_affiliate'),
                        latitude: this.relationData.latitude,
                        longitude: this.relationData.longitude,
                        category: this.relationData.service,
                        id_partenaire_is_iad : localStorage.getItem('id_partenaire_is_iad'),
                        parrain_is_iad : localStorage.getItem('parrain_is_iad'),
                        id_partenaire_du_parrain_1: localStorage.getItem('id_partenaire_du_parrain_1'),
                        service_du_parrain_1 : localStorage.getItem('service_du_parrain_1'),
                        parrain_2_is_iad : localStorage.getItem('parrain_2_is_iad'),
                        id_parrain_2_is_iad : localStorage.getItem('id_parrain_2_is_iad'),
                        id_partenaire_du_parrain_2 : localStorage.getItem('id_partenaire_du_parrain_2'),
                        service_du_parrain_2 : localStorage.getItem('service_du_parrain_2')
                }

      let URLType = 'http://www.nosrezo.com/scripts/API_MOBILE/api_recherche_partenaires.php'; 

      console.log('-----------------------URL TYPE-----------------------', URLType); 

      this.http
          .post(URLType, dataType)
          .subscribe(
            data => {
              this.partenaireList = JSON.parse(data['_body']); 
              console.log('[[PARTENAIRES]]', this.partenaireList);
            }, 
            error =>{
              console.log('error', error); 
            }
          )
  }

  onPartenaireSelected(data){
    console.log('********************PARTENAIRE SELECTED********************', data); 
    this.relationData.partenaire = data.partenaire
    this.relationData.partenaire_val = data.val; 
  }

  mettreEnRelation(){
    let URLRelation = this.API + 'api_insert_prescription_mobile.php'; 

    console.log('-----------------------URL RELATION-----------------------', URLRelation); 

    let data =  {
                    id_affiliate: this.idAffiliate,
                    email: this.relationData.email,
                    mobile: this.relationData.mobile,
                    s_sub_category_code: this.relationData.service,
                    villevalue : this.relationData.ville_value,
                    nom: this.relationData.nom,
                    prenom: this.relationData.prenom,
                    commentaires: this.relationData.commentaire,
                    t_sub_category:'',
                    ville: this.relationData.ville,
                    villelatitude: this.relationData.latitude,
                    villelongitude: this.relationData.longitude,
                    adresse: this.relationData.adresse,
                    partner: this.relationData.partenaire,
                    first_id_partenaire_algorithme: this.relationData.partenaire_value
                }
      console.log('**********************RELATION DATA**********************', data); 
      this.http
          .post(URLRelation, data)
          .subscribe(
            data => {
              let response = JSON.parse(data['_body']); 
              console.log('[[[[[[RELATION]]]]]', response);

              if(response['data'] == 1 || response['data'] == 2){
                this.showAlert(" ", "Recommandation effectuée avec succès.", "OK"); 
                this.relationData = {};
                this.navCtrl.setRoot(AccueilPage);  
              }else {
                 this.showAlert(" ", response['ERROR_MESSAGE'], "OK"); 
              }
              
            }, 
            error => {
              console.log('error mise en relation', error);
            }
          )
  }

  validateForm(){
    this.miseEnRelationForm = this.fb.group({
      "nom": ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "prenom": ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "mobile" : ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\.]+$')])],
      "email":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
      "adresse" : ['', Validators.compose([Validators.required, Validators.minLength(6), Validators.pattern('^[a-zA-Z0-9-_àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+')])],
      "commentaire":['', Validators.required], 
    })

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
