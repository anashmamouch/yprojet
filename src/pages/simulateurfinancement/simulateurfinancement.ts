import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Http } from '@angular/http'; 

/*
  Generated class for the Simulateurfinancement page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-simulateurfinancement',
  templateUrl: 'simulateurfinancement.html'
})
export class SimulateurfinancementPage {
  salaireNet:any; 
  creditsMensuel:any;
  dureePret:any;
  idAffiliate:any
  API:any; 

  pretData:any; 

  dateMaj:any; 
  mensualite:any;
  montantPret:any;
  tauxPret:any;

  constructor(public navCtrl: NavController, public http:Http, public navParams: NavParams) {
    this.idAffiliate = localStorage.getItem('id_affiliate'); 
    this.API = localStorage.getItem('api'); 

    this.pretData = {}; 

  }

  calculPret(){

    if(this.salaireNet && this.creditsMensuel && this.dureePret){
        console.log("SALAIRE NET", this.salaireNet); 
        console.log("CREDIT MENSUEL", this.creditsMensuel); 
        console.log("DUREE PRET", this.dureePret);

        let URL = this.API  + 'api_calcul_pret.php?montant_salaire_net=' + this.salaireNet
                                + '&duree_pret=' + this.dureePret
                                + '&charges_mois=' + this.creditsMensuel
                                + '&id_affiliate=' + this.idAffiliate; 

        
        console.log('URL', URL); 

        this.http
            .get(URL)
            .subscribe(
              data => {
                console.log('data', data); 
                this.pretData = JSON.parse(data['_body'])[0];
                console.log('<-----PRET DATA----->', this.pretData); 

                this.dateMaj = this.pretData['date_maj_2']; 
                this.mensualite = this.pretData['mensualite']; 
                this.montantPret = this.pretData['montant_pret']; 
                this.tauxPret =  this.pretData['taux_pret']; 
              }, 
              error => {
                console.log('error', error); 
              }
            )
    }

   
  }

}
