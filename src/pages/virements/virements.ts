import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';
import { Http } from '@angular/http';

import { Validators, FormBuilder, FormGroup } from '@angular/forms';

/*
  Generated class for the Virements page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-virements',
  templateUrl: 'virements.html'
})
export class VirementsPage {

  //objet ou l'on met les parametres de chaque virement
  virement = {
    "nom": '',
    "codeBanque": '',
    "numCompte": '',
    "bicswift": '',
    "codeGuichet": '' ,
    "cleRib": '',
    "iban": ''
    }

  public virementForm: FormGroup;

  idAffiliate: any;
  response: any;

  API:any;

  constructor(public navCtrl: NavController,public alertController:AlertController, public fb:FormBuilder, public http:Http) {
    //appel de la fonction validateVirementForm
    this.validateVirementForm();

    this.getVirementInfo();
  }

  //fonction pour la connexion avec l'API et remplir le formulaire
  getVirementInfo(){
    this.idAffiliate = localStorage.getItem('id_affiliate');
    this.API = localStorage.getItem('api');

    let URL: string = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term='+this.idAffiliate;

    this.http.get(URL).subscribe(data =>{
      this.response = JSON.parse(data['_body']);

      console.log("Reponse: ", this.response);

      this.virement.nom = this.response.first_and_last_name;
      this.virement.codeBanque = this.response.code_banque;
      this.virement.numCompte = this.response.numero_compte;
      this.virement.bicswift = this.response.BIC_CLIENT;
      this.virement.codeGuichet = this.response.code_guichet;
      this.virement.cleRib = this.response.cle_rib;
      this.virement.iban = this.response.IBAN;

    }, error => {
      console.log(error);
    });
  }


  validateVirementForm(){
    this.virementForm = this.fb.group({
      //"nom" : ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
      "codeBanque" : ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9\. ]+$')])],
      "numCompte" : ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
      "bicswift" : ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z0-9-_\. ]+$')])],
      "codeGuichet" : ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
      "cleRib" : ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
      "iban" : ['', Validators.compose([Validators.required, Validators.maxLength(50), Validators.pattern('^[a-zA-Z0-9-_\. ]+$')])]
    })
  }

  //fonction appelé lorsqu'on click sur le button enregistrer
  confirmerVirement(){
    console.log(this.virement);
    //code

    let URLVirement:string = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_update_virement.php'
                                +'?id_affiliate='+this.idAffiliate
                                +'&code_banque='+this.virement.codeBanque
                                +'&code_guichet='+this.virement.codeGuichet
                                +'&numero_compte='+this.virement.numCompte
                                +'&cle_rib='+this.virement.cleRib
                                +'&IBAN='+this.virement.iban
                                +'&BIC_CLIENT='+this.virement.bicswift;

    this.http.get(URLVirement).subscribe((data)=>{
      let response = JSON.parse(data['_body']);

      this.showAlert(" ", response['msg_alert'], "OK");

      console.log("<<::RESPONSE VIREMENT::>>", response);
    }, (error)=>{
      console.log("ERROR", error);
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
