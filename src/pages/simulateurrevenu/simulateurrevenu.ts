import { Component } from '@angular/core';
import { NavController, NavParams, AlertController } from 'ionic-angular';

import { Http } from '@angular/http';


@Component({
  selector: 'page-simulateurrevenu',
  templateUrl: 'simulateurrevenu.html'
})
export class SimulateurrevenuPage {

  nombrePersonnesNiv1:any;

  nombreMoyenParrainNiv1:any;
  nombreMoyenParrainNiv2:any;
  nombreMoyenParrainNiv3:any;
  nombreMoyenParrainNiv4:any;
  nombreMoyenParrainNiv5:any; 

  revenuData:any;

  constructor(public navCtrl: NavController, public alertController:AlertController, public navParams: NavParams, public http:Http) {
    console.log('Simulateur Revenu'); 

    this.revenuData = {};

  }

  calculRevenu(){
    console.log('nombre personnes niveau 1', this.nombrePersonnesNiv1);
    console.log('nombre moyen parrain niveau 1', this.nombreMoyenParrainNiv1);
    console.log('nombre moyen parrain niveau 2', this.nombreMoyenParrainNiv2);
    console.log('nombre moyen parrain niveau 3', this.nombreMoyenParrainNiv3);
    console.log('nombre moyen parrain niveau 4', this.nombreMoyenParrainNiv4);
    console.log('nombre moyen parrain niveau 5', this.nombreMoyenParrainNiv5);
    console.log('----------------------------------------------------------');

    let data = {
          nb_personnes_niv1: this.nombrePersonnesNiv1,
          nb_moy_parrain_niv1: this.nombreMoyenParrainNiv1,
          nb_moy_parrain_niv2: this.nombreMoyenParrainNiv2,
          nb_moy_parrain_niv3: this.nombreMoyenParrainNiv3,
          nb_moy_parrain_niv4: this.nombreMoyenParrainNiv4,
          nb_moy_parrain_niv5: this.nombreMoyenParrainNiv5,
    }

    let URL = 'http://www.nosrezo.com/scripts/API_MOBILE/api_calcul_revenu.php'; 

    this.http 
        .post(URL, data)
        .subscribe(
          data => {
            this.revenuData = JSON.parse(data['_body']);
            console.log('response', this.revenuData);

            if(this.revenuData.nb_filleul_total > this.revenuData.population_mondiale){
              this.showAlert(" ", "Nous ne doutons pas de votre talent mais vous avez dépassé la population mondiale. Peut être avez vous du Rezo relationnel hors de notre système solaire? Si c'est le cas, merci de nous informer à contact@nosrezo.com ça nous intéresse.", "OK");
            }

            if(this.revenuData.nb_filleul_total > this.revenuData.population_mondiale/100){
              this.showAlert(" ", "Vous avez dépassé 1% de la population mondiale. Etant donné que NosRezo vise les 3%, vous commencez à devenir déraisonnable.", "OK");
            }
          },
          
          error => {
            console.log('error revenu', error);
          }
        )
  }

  //fonction generique pour afficher les alertes
  showAlert(mytitle,mysubTitle,mybuttons) {
       let alert = this.alertController.create({
           title: mytitle,
           subTitle: mysubTitle,
           buttons: [mybuttons]
       });
       alert.present();
   }
}
