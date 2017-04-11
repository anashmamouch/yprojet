import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Http } from '@angular/http'; 


import { MajrecommandationsPage } from '../majrecommandations/majrecommandations'; 
import { Majrecommandations2Page } from '../majrecommandations2/majrecommandations2'; 

@Component({
  selector: 'page-recommandations2',
  templateUrl: 'recommandations2.html'
})

export class Recommandations2Page {

  recommandations: any;
  nombre_reco_total:any; 
  reco_a_traiter:any;

  API:any; 

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:Http) {

    this.API = localStorage.getItem('api'); 
    this.recommandations = [ ]; 
    this.nombre_reco_total = '';
    this.reco_a_traiter = '';  

    let URL: string = this.API + 'api_return_recommandations.php?term='+localStorage.getItem('id_affiliate');
    console.log('<<<url recommandations>>>', URL); 

    this.http.get(URL).subscribe((data) => {
        this.recommandations = JSON.parse(data['_body']);
        this.nombre_reco_total =  this.recommandations.length;

        console.log('RECOMMANDATIONS', this.recommandations); 

        for(let i = 0; i < this.recommandations.length; i++){
            if(this.recommandations[i].date_max >= 3){
                this.recommandations[i]['color'] = 'verte' ; 
            }else if (this.recommandations[i].date_max < 3 && this.recommandations[i].date_max > 0){
                this.recommandations[i]['color'] = 'orange'; 
            }else if (this.recommandations[i].date_max <= 0){
                this.recommandations[i]['color'] = 'rouge';
            }
        }
     });  
  }

    traitementRecommandation(id_recommandation) {

        let URL: string = this.API + 'api_return_info_recommandation.php?term='+id_recommandation;

        console.log('||__________________  URL RECOMMANDATION  __________________||', URL); 

        this.http
            .get(URL)
            .subscribe(
                data => {
                    let response = JSON.parse(data['_body'])[0];
                    console.log(response);
                    this.navCtrl.push(Majrecommandations2Page, {reco_traiter: response});                                         
                }, 
                error => {
                    console.log('ERROR RECO TRAITER', error); 
            });
    }


}
