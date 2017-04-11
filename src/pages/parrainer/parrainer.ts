import { Component } from '@angular/core';
import { NavController, AlertController, LoadingController } from 'ionic-angular';

import { Http } from '@angular/http';

import {Validators, FormBuilder, FormGroup} from '@angular/forms';

export interface CountdownTimer {
  daysString:string;
  hoursString:string;
  minutesString:string;
  secondsString:string;

  seconds: number;
  secondsRemaining: number;
  runTimer: boolean;
  hasStarted: boolean;
  hasFinished: boolean;
  displayTime: any;
}


@Component({
  selector: 'page-parrainer',
  templateUrl: 'parrainer.html'
})
export class ParrainerPage {

    timeInSeconds: number;
    private timer:CountdownTimer = null;

    user:any; 

    API:any;
    parrainerForm: FormGroup;

    sec_num:any;

    response:any;

    daysString:string = '';
    hoursString:string = '';
    minutesString:string = '';
    secondsString:string = '';

  constructor(public navCtrl: NavController, public alertController:AlertController, public loadingController:LoadingController, public fb:FormBuilder, public http:Http) {


    this.API = localStorage.getItem('api');

    this.user = {
        "gender": '',
        "nom": '',
        "prenom": '',
        "mobile": '',
        "email": '',
        "email2":'',
        "cp": '',
        "ville": '',
        "name_parrain": localStorage.getItem('first_name'), 
        "id_parrain": localStorage.getItem('id_affiliate'), 
    }

    this.validateForm();
  }

  //fonction pour valider les champs cote client
  validateForm(){
    this.parrainerForm = this.fb.group({
       "gender": ['', Validators.required],
       "nom": ['', Validators.compose([Validators.required, Validators.maxLength(20), Validators.pattern('^[a-zA-Z\. ]+$')])],
       "prenom":  ['', Validators.compose([Validators.required, Validators.maxLength(20), Validators.pattern('^[a-zA-Z àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
       "telephone" : ['', Validators.compose([Validators.required, Validators.pattern('^[\+0-9]+$')])],
       "email":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9-_]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$')])],
       "confirmEmail":['', Validators.compose([Validators.required, Validators.pattern('^[a-zA-Z0-9-_]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$')])],
       "codePostal" :  ['', Validators.compose([Validators.required, Validators.minLength(3), Validators.pattern('^[0-9\. ]+$')])],
       "ville": ['', Validators.compose([Validators.required, Validators.maxLength(20), Validators.pattern('^[a-zA-Z - àâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇ\. ]+$')])],
    });
  }

parrainer(){

    this.showLoading();

    let URL:string = this.API + 'api_inscription_mobile.php'; 

    console.log("user parrainer", this.user);
    console.log("URL parrainer", URL);

    this.http
        .post(URL, this.user)
        .subscribe(
            data => { 
                console.log('datatata', data);
                this.response = JSON.parse(data['_body']);

                

                if(this.response['data'] == 100){
                    this.showAlert(" ", "VOTRE AMI EST MAINTENANT INSCRIT.", "OK"); 
                    
                    this.user = {
                        "gender": '',
                        "nom": '',
                        "prenom": '',
                        "mobile": '',
                        "email": '',
                        "email2":'',
                        "cp": '',
                        "ville": '',
                        "name_parrain": localStorage.getItem('first_name'), 
                        "id_parrain": localStorage.getItem('id_affiliate'), 
                    }

                }else{
                    this.showAlert(" ", this.response['ERROR_MESSAGE'], "OK"); 
                }

            }, 
            error => {
                console.log('error', error); 
            }
        );
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
         content: " ",
         duration: 1000
      });
      loading.present();
   }


  //timer
  ngOnInit() {
        this.initTimer();
        this.startTimer();

        console.log(this.timer.displayTime);
    }

    hasFinished() {
        return this.timer.hasFinished;
    }

    initTimer() {
        this.timeInSeconds = 10 * 24 * 3600;
        if(!this.timeInSeconds) { this.timeInSeconds = 0; }

        this.timer = <CountdownTimer>{


            seconds: this.timeInSeconds,
            runTimer: false,
            hasStarted: false,
            hasFinished: false,
            secondsRemaining: this.timeInSeconds
        };

        this.timer.displayTime = this.getSecondsAsDigitalClock(this.timer.secondsRemaining);
        //this.getSecondsAsDigitalClock(this.timer.secondsRemaining);
    }

    startTimer() {
        this.timer.hasStarted = true;
        this.timer.runTimer = true;
        this.timerTick();
    }

    pauseTimer() {
        this.timer.runTimer = false;
    }

    resumeTimer() {
        this.startTimer();
    }

    timerTick() {
        setTimeout(() => {
            if (!this.timer.runTimer) { return; }
            this.timer.secondsRemaining--;
            this.timer.displayTime = this.getSecondsAsDigitalClock(this.timer.secondsRemaining);
            this.getSecondsAsDigitalClock(this.timer.secondsRemaining);
            if (this.timer.secondsRemaining > 0) {
                this.timerTick();
            }
            else {
                this.timer.hasFinished = true;
            }
        }, 1000);
    }

    getSecondsAsDigitalClock(inputSeconds: number) {
        var sec_num = parseInt(inputSeconds.toString(), 10); // don't forget the second param
        var days = Math.floor(sec_num / 86400);
        var hours   = Math.floor((sec_num - (days*24*60*60) ) / 3600)
        var minutes = Math.floor((sec_num - (days*24*60*60)-(hours * 3600)) / 60);
        var seconds = sec_num - (days*24*60*60)- (hours * 3600) - (minutes * 60);

        // this.daysString = (days < 10) ? "0" + days : days.toString();
        // this.hoursString = (hours < 10) ? "0" + hours : hours.toString();
        // this.minutesString = (minutes < 10) ? "0" + minutes : minutes.toString();
        // this.secondsString = (seconds < 10) ? "0" + seconds : seconds.toString();

        var daysString = (days < 10) ? "0" + days : days.toString();
        var hoursString = (hours < 10) ? "0" + hours : hours.toString();
        var minutesString = (minutes < 10) ? "0" + minutes : minutes.toString();
        var secondsString = (seconds < 10) ? "0" + seconds : seconds.toString();

        return '<span class="days">'+ daysString + '</span> jours <span class="hours">' +  hoursString + '</span> heures <span class="minutes">' +  minutesString + '</span> minutes <span class="seconds">' + secondsString + '</span> secondes';
    }



}
