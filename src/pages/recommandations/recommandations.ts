import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { AlertController } from 'ionic-angular';

import {Validators, FormBuilder, FormGroup } from '@angular/forms';

import { Http } from '@angular/http';

@Component({
    selector: 'page-recommandations',
    templateUrl: 'recommandations.html'
})
export class RecommandationsPage {

    recommandations: any;
    page : any;
    nombre_reco_total : any;
    reco_a_traiter : any; 
    API:any; 

    recommandationForm: FormGroup;

    constructor(public navCtrl: NavController, public params:NavParams, public fb:FormBuilder, public http: Http, public alertCtrl: AlertController) {
        let idAffiliate = localStorage.getItem('id_affiliate');
        this.page = 1;
        this.recommandations = [];
        this.reco_a_traiter = [];
        this.API = localStorage.getItem('api'); 

        let pair = this.params.get('page'); 

        console.log('||PAGE||', pair); 

        let URL: string = this.API + 'api_return_recommandations.php?term='+idAffiliate;
        console.log('<<url recommandations>>', URL); 

        this.http.get(URL).subscribe((data) => {
            let response = JSON.parse(data['_body']);
            this.nombre_reco_total = response.length;
            this.recommandations = response;
        });  

        // this.validateForm(); 
    }


    traitementRecommandation(id_recommandation) {
        this.page = 2;
        
        let URL2: string = this.API + 'api_return_info_recommandation.php?term='+id_recommandation;

        console.log('URL RECOMMANDATION', URL2); 

        this.http.get(URL2).subscribe((data) => {
            let response2 = JSON.parse(data['_body']);
            console.log(response2[0]);
            this.reco_a_traiter = response2[0];                                           
        });
    }

    majRecommandation(reco_a_traiter){
        
        console.log('Reco a traiter',reco_a_traiter);
        
        var data_reco = {
                    montant_honoraires: reco_a_traiter.r_devis_ttc,
                    etape_reco: reco_a_traiter.etape_reco,
                    id_iad_transaction: reco_a_traiter.id_iad_transaction,
                    delai_relance: reco_a_traiter.delai_relance,
                    id_recommandation: reco_a_traiter.id_recommandation,
                    description: reco_a_traiter.description
                };
        
        let URL: string = this.API + 'api_maj_recommandation.php';
        
        this.http
            .post(URL,data_reco)
            .subscribe(
              data => {
                  console.log('datatata', data); 
                let response = JSON.parse(data['_body']);
                console.log('Response',response[0]); 
                
                var msg_info = response[0].msg_info;
                var msg_success = response[0].msg_success;
                var msg_success2 = response[0].msg_success2;
                var msg_danger = response[0].msg_danger;
                var msg_danger2 = response[0].msg_danger2;  
                
                  if (response[0].msg_danger2 != "") {
                        this.showAlert('',response[0].msg_danger2);
                    } else
                    if (response[0].msg_danger != "") {
                        this.showAlert('', response[0].msg_danger);
                    } else
                    if (response[0].msg_success != "") {
                        
                        this.showAlert('', response[0].msg_success);
                        this.loadRecommandations();
                        this.page = 1;

                    } else
                    if (response[0].msg_success2 != "") {
                        this.showAlert('', response[0].msg_success2);
                        this.loadRecommandations();
                        this.page = 1;

                    }else
                    if (response[0].msg_info != "") {
                        this.showAlert('', response[0].msg_info);
                        this.loadRecommandations();
                        this.page = 1;
                    } 
                
            });
    }
    
    showAlert(title,subTitle){
        
        let alert = this.alertCtrl.create({
            title: title,
            subTitle: subTitle,
          buttons: ['OK']
        });

        alert.present();
    }
    
    loadRecommandations(){
        this.navCtrl.setRoot(RecommandationsPage, {page: 1});
    }

}
