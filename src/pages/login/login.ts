import { Component } from '@angular/core';
import { NavController, MenuController, AlertController, LoadingController} from 'ionic-angular';
import { AccueilPage } from '../accueil/accueil';
import { InscriptionPage } from '../inscription/inscription';
import { Http } from '@angular/http';

import { MotpasseoubliePage } from '../motpasseoublie/motpasseoublie';

import { Validators, FormBuilder, FormGroup } from '@angular/forms';

import { Api } from '../../providers/api';

import { Facebook } from 'ionic-native';

import { TranslateService, TranslatePipe } from 'ng2-translate';

@Component({
  selector: 'page-login',
  templateUrl: 'login.html'
})
export class LoginPage {

  user = {
    "username" : '',
    "password" : ''
  };

  loginForm: FormGroup;

  API:any;

  backgroundImage:string;

  FacebookAccessToken:any;

  FacebookData:any;

  inscrire:any;

  response:any;
  responseInfo:any;

  constructor(public navCtrl: NavController, public menu: MenuController, public api:Api, public fb:FormBuilder, public http: Http, public alertController: AlertController, public translate: TranslateService, public loadingController: LoadingController) {

    this.API = localStorage.getItem('api');
    this.menu.swipeEnable(false);
    this.backgroundImage = "assets/images/background_login.png";
    this.translate = translate;

    localStorage.setItem('language', 'fr');  

    this.validateLoginForm();

    if(localStorage.getItem('id_affiliate') && localStorage.getItem('password')){
      this.user.username = localStorage.getItem('id_affiliate');
      this.user.password = localStorage.getItem('password');

      console.log('id_affiliate', localStorage.getItem('id_affiliate'));
      console.log('password', localStorage.getItem('password'));
    }
  }

  validateLoginForm(){
      this.loginForm = this.fb.group({
          "username" : ["", Validators.compose([Validators.required,  Validators.pattern('^[a-zA-Z0-9-_\. ]+')])],
          "password" : ["", Validators.compose([Validators.required])]
      });
  }

   loginFacebook(){
      Facebook.login(['email']).then((response)=>{
        console.log("Facebook Login", JSON.stringify(response.authResponse));
        console.log(JSON.stringify(response.authResponse));
      }, (error)=>{
        console.log("Facebook Login ERROR: ", JSON.stringify(error));
      });
  }

  getFacebookDetails(response){

        var request = "?fields=id,gender,last_name,first_name,email,birthday,location";
        var permissions = ['email', 'user_birthday', 'user_location'];

        Facebook.api('/' + response.authResponse.userID + request, permissions).then((response) =>{
          console.log("Facebook API Details", JSON.stringify(response));
          console.log(JSON.stringify(response));
          this.FacebookData = JSON.stringify(response);

          console.log(response['birthday']);

          var birthdayArray = response['birthday'].split('/');

          var birthday = birthdayArray[1] + '/' + birthdayArray[0] + '/' + birthdayArray[2];

          console.log(birthday);

          var gender = '' ;

          if(response['gender'] == 'male'){
            gender = 'm';
          }else {
            gender = 'f';
          }

          response['gender']

          this.navCtrl.setRoot(InscriptionPage, {
              nom: response['last_name'],
              prenom: response['first_name'],
              email: response['email'],
              city: response['location']['name'].split(',')[0],
              gender: gender,
              birthday: birthday
          });

          this.showLoading();

        }, (error)=>{
          console.log("Facebook API Details Error", JSON.stringify(error));
        });
        console.log("Facebook Login ERROR: ", JSON.stringify(response));
        console.log(JSON.stringify(response));
  }

  facebookConnect(){
      this.FacebookAccessToken = Facebook.getAccessToken();

      Facebook.getLoginStatus().then((response)=>{
        // if connected with facebook
        if(response.status == 'connected'){

          this.getFacebookDetails(response);

        }else {
            this.login();
            this.getFacebookDetails(response);
        }
      }, (error)=>{
        console.log("Facebook Details ERROR: ", JSON.stringify(error));
      });
    }

  logout(){
      Facebook.logout().then((response)=>{
        console.log("Logout", JSON.stringify(response));
      }, (error) => {
        console.log("Logout Error ", JSON.stringify(error));
      });
  }

  login(){
    let link = this.API + 'api_connection.php'; 
	console.log(link)
    let data = JSON.stringify({
                    id_affiliate: this.user.username, 
                    password: this.user.password, 
                    version_application: '2.1.0'
                })

    this.showLoading();

    this.http.post(link, data).subscribe(
        data => {
			    console.log('******LOGIN-DATA******', data); 
          
          this.response = JSON.parse(data['_body']); 

          if(this.response.data == 100){
              this.getInfo();             
          }

          else if( this.response.data == 10 ){
              this.showAlert(" ", "Membre non reconnu ou inactif", "OK"); 
          }
          else {
              this.showAlert(" ", "Une erreur s'est produite veuillez réessayer plus tard", "OK"); 
          }
          
        }, 
        error => { 
          console.log('error connection', error); 
        }
    )
  }

  getInfo(){
    let URLInfo: string = this.API + 'api_return_info_affiliate.php?term='+this.user.username;

    this.http.get(URLInfo).subscribe(data => {

        console.log('---------INFO-----------', data); 

        let responseInfo = JSON.parse(data['_body'])[0];

        localStorage.setItem('first_name', responseInfo.first_name); 
        localStorage.setItem('last_name', responseInfo.last_name); 
        localStorage.setItem('email_aff', responseInfo.email_aff); 
        localStorage.setItem('photo_profil', responseInfo.photo_profil); 
        localStorage.setItem('id_partenaire', responseInfo.id_partenaire); 
        localStorage.setItem('id_upline', responseInfo.id_upline);
        localStorage.setItem('id_partenaire_is_iad', responseInfo.id_partenaire_is_iad);
        localStorage.setItem('parrain_is_iad', responseInfo.parrain_is_iad); 
        localStorage.setItem('id_partenaire_2_is_iad', responseInfo.id_partenaire_2_is_iad); 
        localStorage.setItem('name_parrain', responseInfo.name_parrain); 
        localStorage.setItem('email_parrain', responseInfo.email_parrain); 
        localStorage.setItem('tel_parrain', responseInfo.tel_parrain); 
        localStorage.setItem('phone_number', responseInfo.phone_number); 
        localStorage.setItem('address', responseInfo.address); 
        localStorage.setItem('zip_code', responseInfo.zip_code); 
        localStorage.setItem('city', responseInfo.city); 
        localStorage.setItem('birth_date', responseInfo.birth_date); 
        localStorage.setItem('birth_place', responseInfo.birth_place); 
        localStorage.setItem('nationality', responseInfo.nationality); 
        localStorage.setItem('id_securite_sociale', responseInfo.id_securite_sociale); 
        localStorage.setItem('logement_affiliate', responseInfo.logement_affiliate); 
        localStorage.setItem('statut_logement', responseInfo.statut_logement); 
        localStorage.setItem('photo_profil', responseInfo.photo_profil);


        localStorage.setItem('nb_filleul_total', responseInfo.nb_filleul_total); 
        localStorage.setItem('nb_affiliate_level_1', responseInfo.nb_affiliate_level_1);
        localStorage.setItem('nb_affiliate_level_2', responseInfo.nb_affiliate_level_2);  
        localStorage.setItem('nb_affiliate_level_3', responseInfo.nb_affiliate_level_3); 
        localStorage.setItem('nb_affiliate_level_4', responseInfo.nb_affiliate_level_4); 
        localStorage.setItem('nb_affiliate_level_5', responseInfo.nb_affiliate_level_5); 
        localStorage.setItem('nb_affiliate_level_6', responseInfo.nb_affiliate_level_6); 

        localStorage.setItem('nb_reco_total', responseInfo.nb_reco_total); 
        localStorage.setItem('nb_reco', responseInfo.nb_reco); 
        localStorage.setItem('nb_reco_retard', responseInfo.nb_reco_retard); 
        localStorage.setItem('nb_reco_level_0', responseInfo.nb_reco_level_0); 
        localStorage.setItem('nb_reco_level_1', responseInfo.nb_reco_level_1); 
        localStorage.setItem('nb_reco_level_2', responseInfo.nb_reco_level_2); 
        localStorage.setItem('nb_reco_level_3', responseInfo.nb_reco_level_3); 
        localStorage.setItem('nb_reco_level_4', responseInfo.nb_reco_level_4); 
        localStorage.setItem('nb_reco_level_5', responseInfo.nb_reco_level_5); 
        localStorage.setItem('nb_reco_level_6', responseInfo.nb_reco_level_6); 

        localStorage.setItem('remuneration_level_0', responseInfo.remuneration_level_0); 
        localStorage.setItem('remuneration_level_1', responseInfo.remuneration_level_1);
        localStorage.setItem('remuneration_level_2', responseInfo.remuneration_level_2);
        localStorage.setItem('remuneration_level_3', responseInfo.remuneration_level_3);
        localStorage.setItem('remuneration_level_4', responseInfo.remuneration_level_4);
        localStorage.setItem('remuneration_level_5', responseInfo.remuneration_level_5);
        localStorage.setItem('remuneration_level_6', responseInfo.remuneration_level_6);

        localStorage.setItem('gain_potentiel', responseInfo.gain_potentiel); 
        localStorage.setItem('commission_a_encaisser', responseInfo.commission_a_encaisser); 
        localStorage.setItem('id_partenaire_du_parrain_1', responseInfo.id_partenaire_du_parrain_1); 
        localStorage.setItem('service_du_parrain_1', responseInfo.service_du_parrain_1); 
        localStorage.setItem('parrain_2_is_iad', responseInfo.parrain_2_is_iad); 
        localStorage.setItem('id_partenaire_du_parrain_2', responseInfo.id_partenaire_du_parrain_2); 
        localStorage.setItem('service_du_parrain_2', responseInfo.service_du_parrain_2); 
        localStorage.setItem('lien_webinar', responseInfo.lien_webinar); 
        localStorage.setItem('telephone_service_qualite', responseInfo.telephone_service_qualite); 


        this.api.getInfo(this.user.username);
        localStorage.setItem('id_affiliate', this.user.username);
        localStorage.setItem('password', this.user.password);
        this.navCtrl.setRoot(AccueilPage, {params: this.user});

        console.log('--INFO AFFILIATE--', responseInfo);
       
    }, error =>{
        console.log("ERROR info", error);
    });
  }

  forgotPassword(){
    console.log("Mot de passe oublié");
    this.navCtrl.push(MotpasseoubliePage);
  }

  register(){
    console.log("::Inscription::");
    this.navCtrl.push(InscriptionPage);
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

   //fonction generique pour afficher le LoadingController
   showLoading(){
     let loading = this.loadingController.create({
         content: "Connexion...",
         duration: 100
      });
      loading.present();
   }

   changeLanguage(lang:string){
      this.translate.use(lang);
      localStorage.setItem('language', lang); 
      console.log(lang); 
   }
}
