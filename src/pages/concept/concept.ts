import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';


@Component({
  selector: 'page-concept',
  templateUrl: 'concept.html'
})

export class ConceptPage {

  constructor(public navCtrl: NavController, public navParams: NavParams) {
    console.log('Concept Page');
  }

}
