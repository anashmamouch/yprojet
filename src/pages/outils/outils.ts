import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

//pages
import { StatistiquesPage } from '../statistiques/statistiques'; 
import { LocalisationPage } from '../localisation/localisation'; 
import { PlanningPage } from '../planning/planning'; 
import { TinderPage } from '../tinder/tinder'; 

/*
  Generated class for the Outils page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-outils',
  templateUrl: 'outils.html'
})
export class OutilsPage {

  constructor(public navCtrl: NavController) {
    console.log('Hello outils page'); 
  }

  goToStatistiques(){ 
    this.navCtrl.push(StatistiquesPage); 
  }

  goToLocalisation(){
    this.navCtrl.push(LocalisationPage); 
  }

  goToPlanning(){
    this.navCtrl.push(PlanningPage); 
  }

  goToTinder(){
    this.navCtrl.push(TinderPage);
  }

}
