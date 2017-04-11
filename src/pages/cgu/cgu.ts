import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

@Component({
  selector: 'page-cgu',
  templateUrl: 'cgu.html'
})
export class CguPage {

  constructor(public navCtrl: NavController) {

    console.log("Hello Page CGU");
  }

}
