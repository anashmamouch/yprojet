import { Component } from '@angular/core';
import { NavController, NavParams, AlertController, LoadingController } from 'ionic-angular';
import { Http } from '@angular/http';
import {BundlesPage} from '../bundles/bundles';

/*
  Generated class for the Modepaiement page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-modepaiement',
  templateUrl: 'modepaiement.html'
})

export class ModepaiementPage {

  idAffiliate: any;
  prixPack: any;
  idPack:any;
  mode :any;
  token:any ;
  API:any

  constructor(public navCtrl: NavController, public navParams: NavParams,public loadingController: LoadingController,  public alert: AlertController ,public http:Http) {
    console.log("Hello Mode Paiement");
    this.prixPack = this.navParams.get('prix_pack');
    this.idPack = this.navParams.get('id_pack');
    this.idAffiliate = localStorage.getItem('id_affiliate');

    this.API = localStorage.getItem('api');

    console.log(this.idAffiliate);

  }

  payer(){
    if(this.mode == "checkout"){
      this.showLoading();
      this.showStripe( "Achat direct", "Payer "+this.prixPack+"€");

    }
    else if(this.mode == "subscription"){
      this.showLoading();
      this.showStripe( "Abonnement "+this.prixPack+ "€/mois", "S'abonner");
    }

  }

  //fonction pour le stripe
  showStripe(desc:string, label:string){
    const idAffiliate = this.idAffiliate;
    const prixPack =+ this.prixPack;
    const idPack = this.idPack;
    const http:any = this.http;
    const mode:any = this.mode;
    const alert:any = this.alert;
    const navCtrl:any = this.navCtrl;
    const API:any = this.API;

      var handler = (<any>window).StripeCheckout.configure({
      key: 'pk_test_JA4p7dlhzAzwoeTs6BIQgtre',
      locale: 'fr',
      image: '../../assets/images/ionic.jpg',
      token: function (token: any) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
        console.log("ANAS");
        console.log(token.id);

          let response:any;


          let URL:string = "http://"+API+"/Y_PROJECT/scripts/api_mobile/api_pass_order_pack.php?id_affiliate="+idAffiliate
                            +"&mode_paiement="+mode
                            +'&id_pack='+idPack
                            +'&prix_pack='+prixPack+'';

          console.log(URL);

          http.get(URL).subscribe(data=>{
              response = JSON.parse(data['_body']);
              console.log("I AM HERE...");
              console.log("PASS ORDER: ", response);

              if(response.data == 1){
                let URLStripe:string = "http://"+API+"/Y_PROJECT/scripts/api_mobile/api_stripe_mobile.php?token_id="+token.id
                                  +"&amount="+(prixPack*100)
                                  +"&mode="+mode;

                http.get(URLStripe).subscribe(data =>{
                  let responseStripe = JSON.parse(data['_body']);
                  console.log("STRIPE RESPONSE: ", responseStripe)
                  if(responseStripe.data == 1){
                    console.log("id Pack from tocken ", idPack);

                    navCtrl.setRoot(BundlesPage, {params: idPack});
                    //navCtrl.pop();
                  }


                }, error =>{
                  console.log("ERREUR STRIPE: ", error);
                })
              }else {
                console.log("DATA = 2 ou 0 ");
                  alert.create({
                    title: "Erreur",
                    subTitle: "Une erreur s'est produite veuillez réesayer plus tard",
                    buttons: [{text: "OK"}]
                  }).present;
              }
            }, error =>{
              console.log("ERREUR: ", error);

          });

      }
    });

    handler.open({
      name: 'PROJET Y',
      description: desc,
      allowRememberMe: false,
      panelLabel: label,
    });
    //console.log(handler);
  }

  //fonction generique pour afficher le LoadingController
  showLoading(){
    let loading = this.loadingController.create({
        content: "Connexion...",
        duration: 5000
     });

     loading.present();
  }

}
