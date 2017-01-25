import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http'; 

import {Validators, FormBuilder, FormGroup } from '@angular/forms';

/*
  Generated class for the Motpasseoublie page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-motpasseoublie',
  templateUrl: 'motpasseoublie.html'
})
export class MotpasseoubliePage {


    user = {
      "email": ''
    }

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
        "email" : ['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9-_]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$')])],
      })
    }

    reinitialiserMotPasse(){
      console.log(this.user);
      let URL = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_forgot_password.php" ; 

      this.http.get(URL).subscribe((data) => {
        let response = JSON.parse(data['_body']); 
        console.log("MOT DE PASSE OUBLIE", response); 

        this.showAlert(" ",response['data'],  "OK"); 

      }, (error) => {
        console.log("::ERROR MOT DE PASSE OUBLIE::", error); 
      }); 

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
