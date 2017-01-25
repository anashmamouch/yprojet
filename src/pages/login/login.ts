import { Component } from '@angular/core';
import { NavController, MenuController, AlertController, LoadingController} from 'ionic-angular';
import { MiseenrelationPage } from '../miseenrelation/miseenrelation';
import { InscriptionPage } from '../inscription/inscription';
import { Http } from '@angular/http';

import { MotpasseoubliePage } from '../motpasseoublie/motpasseoublie';

import { Validators, FormBuilder, FormGroup } from '@angular/forms';

import { Api } from '../../providers/api';

import { Facebook } from 'ionic-native';

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

  constructor(public navCtrl: NavController, public menu: MenuController, public api:Api, public fb:FormBuilder, public http: Http, public alertController: AlertController, public loadingController: LoadingController) {

    this.API = localStorage.getItem('api');
    this.menu.swipeEnable(false);
    this.backgroundImage = "assets/images/bg_home.jpg";

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
    let link = 'http://'+this.API+'/NOS_REZO/scripts/api_mobile/api_connection.php'; 
    let data = JSON.stringify({
                    id_affiliate: this.user.username, 
                    password: this.user.password, 
                    version_application: '2.1.0'
                })

    this.showLoading();

    this.http.post(link, data).subscribe(
        data => {
          let response = JSON.parse(data['_body']); 
          console.log("login-->>", response); 
        }, 
        error => { 
          console.log('error', error); 
        }
    )

    // this.http.get(URL).subscribe(data =>{
    //   let response = JSON.parse(data['_body']);

    //   if(response.data == 100){
    //     this.getInfo();
    //     this.api.getInfo(this.user.username);

    //     localStorage.setItem('id_affiliate', this.user.username);
    //     localStorage.setItem('password', this.user.password);
    //     this.navCtrl.setRoot(MiseenrelationPage, {params: this.user});

    //   }

    //   else if(response.data == 1) {
    //     this.showAlert("Erreur", "Erreur de format", "OK");
    //   }
    //   else if(response.data == 2){
    //     this.showAlert("Erreur", "Membre non reconnu ou inactif", "OK");
    //   }
    //   else if(response.data == 3){
    //     this.showAlert("Erreur", "ID ou mot de passe incorrecte", "OK");
    //   }

    // }, error => {
    //   console.log(error);
    // });
  }

  getInfo(){
    let URLInfo: string = 'http://' + this.API + '/NOS_REZO/scripts/api_mobile/api_infos_affiliate.php?term='+this.user.username;

    this.http.get(URLInfo).subscribe(data=>{

        let responseInfo = JSON.parse(data['_body']);

        localStorage.setItem('email', responseInfo.email);
        localStorage.setItem('nom', responseInfo.first_and_last_name);
        localStorage.setItem('id_affiliate', this.user.username);

    }, error =>{
        console.log("ERROR info", error);
    });
  }

  forgotPassword(){
    console.log("Mot de passe oublié");
    this.navCtrl.push(MotpasseoubliePage);
  }

  register(){
    console.log("Inscription...");
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
}
