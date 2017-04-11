import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';


@Component({
  selector: 'page-codebonsens',
  templateUrl: 'codebonsens.html'
})
export class CodebonsensPage {

  constructor(public navCtrl: NavController, public navParams: NavParams) {
    console.log('Code Bon Sens'); 
  }


}
