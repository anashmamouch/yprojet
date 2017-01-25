import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

/*
  Generated class for the Cgu page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-cgu',
  templateUrl: 'cgu.html'
})
export class CguPage {

  constructor(public navCtrl: NavController) {

    console.log("Hello Page CGU");
  }

}
