import { Component } from '@angular/core';

import { NavController, AlertController } from 'ionic-angular';

import { Http } from '@angular/http'; 


declare var Stripe: any;

@Component({
  selector: 'paiement',
  templateUrl: 'paiement.html',
})

export class PaiementPage {

  disabled:any; 
  idAffiliate:any; 

  constructor(public navCtrl: NavController, public http:Http, public alertController:AlertController) {
    this.disabled = false; 
    this.idAffiliate = localStorage.getItem('id_affiliate'); 
  }

  /**
  * Init
  */
  inputForm = {
    currency: 'EUR',
    amountCents: 500,
    date: this.todayFormatted(),   // init
    number: 4242424242424242,      // remove this for production
    name: " ",           // remove this for production
    cvc: 123,                      // remove this for production
  }
  status = {
    message: '',
    loading: false,
    success: null,
  }

  /**
  * fn Charge Card
  */
  charge() {

    // obtain the exp_month and exp_year
    var split = this.inputForm['date'].split('-');
    this.inputForm['exp_month'] = split[1];
    this.inputForm['exp_year']  = split[0];

    this.status['message'] = '';
    this.status['loading'] = true;
    this.status['success'] = null;

    console.log('<<--input-form-->>', this.inputForm);
    
    this.disabled = true; 

    let URL = 'https://paiements.nosrezo.com/OVH_paiement_facture_traitement_mobile.php' 
      + '?card_number=' + this.inputForm['number']
      + '&exp_month=' + this.inputForm['exp_month']
      + '&exp_year=' + this.inputForm['exp_year']
      + '&cvc=' + this.inputForm['cvc']
      + '&amount=5'
      + '&mode=checkout'
      + '&id_affiliate=' + this.idAffiliate
      + '&id_recommandation=1234'
      + '&secret_key=sk_test_bFQYhyGyTJ8ngNVzl0NXk8a9'; 

    console.log('URL--URL', URL); 

    this.http
        .get(URL)
        .subscribe(
          data => {
            console.log('<-DATA-DATA->', data); 
            let response = JSON.parse(data['_body']); 
            console.log('<RESPONSE>', response); 

            if(response['data'] == 100){

              this.status['message'] = 'Paiement effectué avec succèes';
              this.status['loading'] = false;
              this.status['success'] = true;
            }else { 
              this.disabled = false; 
              this.status['message'] = 'Opération échouée';
              this.status['loading'] = false;
              this.status['success'] = false;
              this.showAlert('', response['msg_alert'], 'OK'); 
            }

          }, 
          error => {
            console.log('ERROR', error); 
          }
        )

  };


  /*
  * Helper functions
  */
  todayFormatted() {
    var d = new Date();
    var m = d.getMonth() + 1;
    var y = d.getFullYear();
    if (m < 10) {
      return y + '-0' + m;
    } else {
      return y + '-' + m;
    }
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
