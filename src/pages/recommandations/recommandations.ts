import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { Http } from '@angular/http';

@Component({
  selector: 'page-recommandations',
  templateUrl: 'recommandations.html'
})
export class RecommandationsPage {

  recommandations:any;

  constructor(public navCtrl: NavController, public http: Http) {
    let idAffiliate = localStorage.getItem('id_affiliate');

    let URL:string = 'http://www.nosrezo.com/scripts/api_mobile/api_return_recommandations.php?term=12';

    this.http.get(URL).subscribe((data) => {
        let response = JSON.parse(data['_body']);
        this.recommandations = response ; 
    });
  }

}
