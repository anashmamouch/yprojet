import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { Http } from '@angular/http'

@Component({
  selector: 'page-aperorezo',
  templateUrl: 'aperorezo.html'
})
export class AperorezoPage {

  aperosrezo:any;

  constructor(public navCtrl: NavController, public http: Http) {
    let URL:string = 'http://www.nosrezo.com/scripts/api_mobile/api_return_aperorezo.php?term=12';

    this.http.get(URL).subscribe((data) => {
        let response = JSON.parse(data['_body']);
        console.log('response', response);
        this.aperosrezo = response ;
    });
  }
  }
