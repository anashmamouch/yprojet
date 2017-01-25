import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

/*
  Generated class for the Preferences page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-preferences',
  templateUrl: 'preferences.html'
})
export class PreferencesPage {

  constructor(public navCtrl: NavController) {
    console.log('::Preferences page::');
  }

}
