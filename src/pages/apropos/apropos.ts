import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { ContactPage } from '../contact/contact';
import { FaqPage } from '../faq/faq';
import { CguPage } from '../cgu/cgu';
/*
  Generated class for the About page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-apropos',
  templateUrl: 'apropos.html'
})
export class AproposPage {

  constructor(public navCtrl: NavController) {
    console.log("Hello Apropos Page");
  }

  openFAQ(){
  this.navCtrl.push(FaqPage);
  }

  openContact(){
    this.navCtrl.push(ContactPage);
  }

  openCGU(){
    this.navCtrl.push(CguPage); 
  }

  openFacebook(){
    window.open('http://www.amazon.com', '_system', 'location=yes');
    return false;
  }


}
