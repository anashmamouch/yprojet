import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http'; 

import { LoginPage } from '../login/login'; 
import { Validators, FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'page-motpasseoublie',
  templateUrl: 'motpasseoublie.html'
})

export class MotpasseoubliePage {

    email:any; 
    backgroundImage:any; 

    motpasseoublieForm: FormGroup;

    API:any; 

    constructor(public navCtrl: NavController, public fb: FormBuilder, public http:Http, public alertController:AlertController) {
      console.log("Hello Login Page");
      this.validateForm();

      this.backgroundImage = "assets/images/bg_home.jpg"; 

      this.API = localStorage.getItem('api'); 
    }

    validateForm(){
      this.motpasseoublieForm = this.fb.group({
        "email" : ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$')])],
      })
    }

    reinitialiserMotPasse(){
      let URL = this.API + 'api_forgot_password.php'; 

      let dataForgotPassword = JSON.stringify({email: this.email}); 

      this.http
          .post(URL, dataForgotPassword)
          .subscribe(data => {

              let response = JSON.parse(data['_body']); 
              console.log("FORGOT PASSWORD", response); 

              if(response['data'] == '10'){
                this.showAlert(" ", "un email vous a été envoyé pour reinitialiser votre mot de passe" , "OK"); 
                this.navCtrl.setRoot(LoginPage); 
              }else if (response['data'] == '0'){
                this.showAlert(" ", "Email non inscrit", "OK"); 
              }

            }, (error) => {
              console.log("::ERROR MOT DE PASSE OUBLIE::", error); 
            }); 

    }

    showAlert(mytitle,mysubTitle,mybuttons) {
       let alert = this.alertController.create({
           title: mytitle,
           subTitle: mysubTitle,
           buttons: [mybuttons]
       });
       alert.present();
   }

}
