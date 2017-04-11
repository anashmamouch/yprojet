import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

//pages
import { SimulateurfinancementPage } from '../simulateurfinancement/simulateurfinancement'; 
import { SimulateurnotairePage } from '../simulateurnotaire/simulateurnotaire';
import { SimulateurgainsPage } from '../simulateurgains/simulateurgains'; 
import { SimulateurrevenuPage } from '../simulateurrevenu/simulateurrevenu'; 

@Component({
  selector: 'page-outils',
  templateUrl: 'outils.html'
})
export class OutilsPage {

  constructor(public navCtrl: NavController) {
    console.log('Hello outils page'); 
  }

  goFinancement(){ 
    this.navCtrl.push(SimulateurfinancementPage); 
  }

  goNotaire(){
    this.navCtrl.push(SimulateurnotairePage); 
  }

  goGains(){
    this.navCtrl.push(SimulateurgainsPage); 
  }

  goRevenu(){
    this.navCtrl.push(SimulateurrevenuPage);
  }

}
