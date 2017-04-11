import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { TranslateService } from 'ng2-translate';

@Component({
  selector: 'page-preferences',
  templateUrl: 'preferences.html'
})
export class PreferencesPage {

  language:any; 

  constructor(public navCtrl: NavController, public translate: TranslateService) {
    this.language = localStorage.getItem('language'); 
  }

  changeLanguage(){
    this.translate.use(this.language);
    console.log('language <--> ', this.language);
    localStorage.setItem('language', this.language); 
  }

}
