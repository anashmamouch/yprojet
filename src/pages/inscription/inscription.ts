import { Component} from '@angular/core';
import { NavController, AlertController, LoadingController, ModalController, ViewController } from 'ionic-angular';
import { Http } from '@angular/http';
import { Validators, FormBuilder, FormGroup} from '@angular/forms';
import { CgiPage } from '../cgi/cgi';  

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
    "mobile": '',
    "email": '',
    "email2":'',
    "cp": '',
    "ville": '',
    "id_parrain": '',
    "name_parrain": '',
    "source_appel_appli": '2',
  }

  nomParrain: any;
  response:any;

  inscriptionForm: FormGroup;

  API:any;

  desc:string = '';

  inscrire:any;

  constructor(public navCtrl: NavController, public alertController: AlertController, public viewCtrl: ViewController, public modalCtrl: ModalController, public fb:FormBuilder, public http:Http, public loadingController:LoadingController) {
    console.log("Hello Inscription Page");

    this.API = localStorage.getItem('api');

    this.validateForm();
  }

  //fonction pour valider les champs cote client
  validateForm(){

    this.inscriptionForm = this.fb.group({
       "gender": ['', Validators.required], 
       "nom": ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "prenom":  ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "telephone" : ['', Validators.compose([Validators.required, Validators.pattern('^[\+0-9]+$')])],
       "email":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
       "confirmEmail":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
       "codePostal" :  ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
       "ville": ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "id_parrain": ['', Validators.compose([Validators.required, Validators.pattern('^[0-9\. ]+$')])],
       "name_parrain": ['', Validators.compose([Validators.required, Validators.maxLength(20), Validators.pattern('^[a-zA-Z-àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
    });
  }

  goToCGU(){
    this.navCtrl.push(CgiPage);  
  }

  //fonction lorsque l'utilisateur clique sur le button devenir membre
  inscrireMembre(){
    console.log('Yassine', this.user);
    let nomParrain = this.user.name_parrain.split(' ')[0];

    let URL = this.API+'api_inscription_mobile.php'; 

    this.http
        .post(URL, this.user)
        .subscribe(
          data => { 
            console.log('datatata', data); 
            let response = JSON.parse(data['_body']); 

            console.log('response Inscription', response); 

            if(response['data'] == '100'){
              this.showAlert("Envoi réussi !", "Bienvenue chez NosRezo !", "OK"); 
              this.user = {
                  "gender": '',
                  "nom": '',
                  "prenom": '',
                  "mobile": '',
                  "email": '',
                  "email2":'',
                  "cp": '',
                  "ville": '',
                  "id_parrain": '',
                  "name_parrain": '',
                  "source_appel_appli": '2',
                }
              //this.navCtrl.setRoot(InscriptionPage);
            }else {
              this.showAlert("ATTENTION", response['ERROR_MESSAGE'], "OK");   
            }
          }, 
          error => {
            console.log('error', error); 
          }
        )
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
