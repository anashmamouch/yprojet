import { Component } from '@angular/core';
import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http';

import {Validators, FormBuilder, FormGroup} from '@angular/forms';

/*
  Generated class for the Parrainer page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/

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

    user = {
        "gender": '',
        "nom": '',
        "prenom": '',
        "telephone": '',
        "email": '',
        "confirmEmail":'',
        "codePostal": '',
        "ville": '',
        "dateNaissance": '',
    }

    API:any;
    parrainerForm: FormGroup;

    idParrain:any;
    nomParrain:any;

    sec_num:any;

    response:any;

    daysString:string = '';
    hoursString:string = '';
    minutesString:string = '';
    secondsString:string = '';

  constructor(public navCtrl: NavController, public alertController:AlertController, public fb:FormBuilder, public http:Http) {

    this.API = localStorage.getItem('api');
    this.idParrain =  localStorage.getItem('id_affiliate');
    this.nomParrain = localStorage.getItem('nom').split(' ')[0];

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
       "dateNaissance": ['', Validators.required],
    });
  }

  parrainer(){

      if(this.user.gender == "m"){
          this.user.gender = "1";
      }else if (this.user.gender == "f"){
          this.user.gender = "2";
      }

    let URL:string = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_parrainer.php'
                        +'?civilite=' + this.user.gender
                        +'&first_name='+this.user.prenom
                        +'&last_name='+this.user.nom
                        +'&phone_number='+this.user.telephone
                        +'&email='+this.user.email
                        +'&email2='+this.user.confirmEmail
                        +'&zip_code='+this.user.codePostal
                        +'&city='+this.user.ville
                        +'&birth_date='+this.user.dateNaissance
                        +'&id_parrain='+this.idParrain
                        +'&name_parrain='+this.nomParrain

    console.log("user", this.user);
    console.log("URL parrainer", URL);

    this.http.get(URL).subscribe(data =>{
      let response = JSON.parse(data['_body'])

      this.showAlert(" ", response['msg_error'], "OK");

    },error => {
      console.log(error);
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
