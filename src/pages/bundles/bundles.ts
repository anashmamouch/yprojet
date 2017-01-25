import { Component, trigger, state, style, transition, animate} from '@angular/core';
import { Http } from '@angular/http';
import { NavController, NavParams, LoadingController, AlertController, ModalController } from 'ionic-angular';
import { ModepaiementPage } from '../modepaiement/modepaiement';
import { DetailsPackPage } from '../detailspack/detailspack';
/*
  Generated class for the Bundles page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-bundles',
  templateUrl: 'bundles.html',
  animations: [
      trigger('fadeInLeft', [
          state('out', style({
              transform: 'translate3d(-150%, 0, 0)',
              opacity: 0,

          })),
          state('in', style({
              transform: 'none',
              opacity: 1,

          })),
          transition('in => out', animate('1000ms ease-in')),
          transition('out => in', animate('1000ms ease-out'))
    ]),
    ]
})

export class BundlesPage {

  response:any;

  responsePack:any;

  idAffiliate: any;

  idPack:any;
  nomPack:any;
  prixPack:any;

  dateDebutAbonnement:any;

  idPackNew: any;

  publicKey:any;

  button:string;

  mode:any;
  alert:any;

  color:string;
  value:string;
  src:string;

  idParams:any;

  isSubscribe:any;

  colors:any;
  values:any;
  images:any;
  fadeInLeftState:any = ['in', 'in', 'in', 'in', 'in', 'in'];
  ids:any;

  borderWidth:any;
  borderStyle:any;
  borderColor:any;

  disabled:any;

  tva:any;

  idCustomer:any;

  prixPackTTC:any;
  prixPackHT:any;
  prixAncienPack:any;

  API:any;

  prixPacks:any = [];

  email:any;

  constructor(public navCtrl: NavController, public modalCtrl: ModalController, public loadingController: LoadingController,  public navParams: NavParams, public alertController: AlertController, public http: Http) {

    console.log('Hello Page Bundles');

    this.idAffiliate = localStorage.getItem('id_affiliate');

    this.API = localStorage.getItem('api');

    this.colors = ["fresh", "fresh", "fresh", "fresh", "fresh", "fresh"];
    this.values = ["Choisir", "Choisir", "Choisir", "Choisir", "Choisir", "Choisir"];
    this.images = [ "../../assets/images/bg_freemium.jpg", "../../assets/images/bg_blue_sky.jpg", "../../assets/images/bg_orange_mechanic.jpg",  "../../assets/images/bg_green_peace.jpg", "../../assets/images/bg_red_devil.jpg", "../../assets/images/bg_black_star.jpg" ]
    this.ids = [1, 2, 3, 4, 5, 6];
    this.prixPacks = ["Gratuit", "5 €/mois", "10 €/mois", "20 €/mois", "50 €/mois", "100 €/mois"];

    this.borderColor = ["fresh", "fresh", "fresh", "fresh", "fresh", "fresh"];
    this.borderStyle = ["solid", "solid", "solid", "solid", "solid", "solid"];
    this.borderWidth = ["0px", "0px", "0px", "0px","0px", "0px"];

    this.getBundlesInfo();
    this.getInfoAffiliates();

  }

  getInfoAffiliates(){
    let URLInfoAffiliates = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term='+this.idAffiliate;

    this.http.get(URLInfoAffiliates).subscribe((data) => {

      let response = JSON.parse(data['_body']);
      console.log("DATA>>", response);
      this.email = response['email'];

      this.publicKey = response['pk_stripe'];

      this.prixAncienPack = response['prix_ancien_pack'];

      this.idCustomer = response['id_customer'];
      this.prixAncienPack = response['prix_pack_ttc'];
      this.dateDebutAbonnement = response['date_debut_abonnement'].split(" ")[0];

    }, (error) => {
      console.log("::ERROR::", error);
    });
  }

  ionViewDidLoad() {
    this.fadeInLeftState[0]= 'out';

    setInterval(() => {
      this.fadeInLeftState[0] = 'in';
    }, 500);

    this.fadeInLeftState[1]= 'out';

    setInterval(() => {
      this.fadeInLeftState[1] = 'in';
    }, 800);

    this.fadeInLeftState[2]= 'out';

    setInterval(() => {
      this.fadeInLeftState[2] = 'in';
    }, 1100);

    this.fadeInLeftState[3]= 'out';

    setInterval(() => {
      this.fadeInLeftState[3] = 'in';
    }, 1400);
  }

  getBundlesInfo(){
    let URL: string = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_bundle.php?id_affiliate='+this.idAffiliate;

    this.http.get(URL).subscribe(data =>{
        this.response = JSON.parse(data['_body']);

        console.log("<<==RESPONSE==>>", this.response);

         this.prixPacks = [] ;

         this.email = this.response['email'];

        for(let res of this.response){
          this.color = this.colors[res.id_pack];
          this.value = this.values[res.id_pack];
          this.src = this.images[res.id_pack];

          if(res.prix_pack_ttc == 0){
            this.prixPacks[res.id_pack - 1] = "Gratuit";
          }else {
            this.prixPacks[res.id_pack - 1] = Math.round(res.prix_pack_ttc) + " €/mois";
          }

          console.log(res);

          this.isSubscribe =+ res.is_subscribe;

            if(this.isSubscribe == 1){
              this.colors[res.id_pack - 1 ] = "secondary"
              this.values[res.id_pack - 1] = "Sélectionné"
              console.log("THIS IS SUBSCRIBE....");
              this.color = this.colors[res.id_pack];
              this.value = this.values[res.id_pack];

              this.borderColor[res.id_pack - 1 ] = "#32db64";
              this.borderStyle[res.id_pack - 1 ] = "solid";
              this.borderWidth[res.id_pack - 1 ] = "5px";
            }
        }
    },
    error =>{
      console.log(JSON.parse(error));
    });
  }

  onClickPack(pack){

      console.log("pack >>>", pack);

          if(pack.prix_pack_ttc == 0){
            if(pack.is_subscribe == 0){
                console.log("freemium")

                let URL = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_pass_order_pack.php"
                          +"?id_affiliate="+this.idAffiliate
                          +"&id_pack="+pack.id_pack;

                console.log(URL);

                this.http.get(URL).subscribe((data) => {
                  console.log(data);

                  let response = JSON.parse(data['_body']);

                  this.showAlert(" ", response['msg_alert'], "OK");
                  this.navCtrl.setRoot(BundlesPage);

                }, (error) => {
                  console.log("ERROR", error);
                });

            }else {
              console.log("Do nothing");
            }
          }else{
                if(pack.is_subscribe == 0 ){


                this.nomPack = pack.nom_pack;

                let nomPackArray = this.nomPack.split(" ");

                this.nomPack = nomPackArray[0] + nomPackArray[1];

                this.prixPack = Math.round(pack.prix_pack_live);
                this.tva = pack.tva_percent_to_pay;

                this.idPack = pack.id_pack
                this.prixPackTTC = pack.prix_pack_ttc;
                this.prixPackHT = pack.prix_pack_ht;

                this.prixPackTTC = +this.prixPackTTC;

                console.log("prix_ancien_pack", this.prixAncienPack);
                console.log("prix_current_pack", this.prixPackTTC);


                if(this.prixPackTTC < this.prixAncienPack){
                  let URLDowngrade = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_pass_order_pack_upcoming.php"
                                      +"?id_affiliate="+this.idAffiliate
                                      +"&id_pack="+this.idPack
                                      +"&prix_pack_ttc="+this.prixPackTTC
                                      +"&prix_pack_ht="+this.prixPackHT
                                      +"&tva_percent_to_pay="+this.tva
                                      +"&id_customer="+this.idCustomer;
                  this.http.get(URLDowngrade).subscribe((data)=>{
                    let response = JSON.parse(data['_body']);

                    this.showAlert(" ", response['msg_alert'], "OK");
                  }, (error) => {
                    console.log("::--++ERROR downgrade++--::", error);
                  });

                }else{
                  this.showLoading();
                  this.showStripe( pack.nom_pack, "Payer "+ Math.round(pack.prix_pack_ttc) + " €/mois");
                }

              }else {
                console.log("DO NOTHING!")
              }
          }
    console.log(pack);
  }

  onClickDetails(pack){
    this.navCtrl.push(DetailsPackPage, {pack: pack});
  }

   //fonction pour le stripe
  showStripe(desc:string, label:string){
    const idAffiliate = this.idAffiliate;
    const nomPack = this.nomPack;
    const prixPack =+ this.prixPack;
    const prixPackHT = this.prixPackHT;
    const prixPackTTC = this.prixPackTTC;
    const prixAncienPack = this.prixAncienPack;
    const idPack = this.idPack;
    const idCustomer = this.idCustomer;
    const tva = Math.round(this.tva);
    const http:any = this.http;
    const mode:any = this.mode;
    const alert:any = this.alert;
    const navCtrl:any = this.navCtrl;
    const dateDebutAbonnement:any = this.dateDebutAbonnement;
    const API:any = this.API;
    const http2:any = this.http;
    const loadingCtrl:any = this.loadingController;
    const email:any = this.email;
    const publicKey:any = this.publicKey;

    console.log("email", email);
    console.log("public key", publicKey);

      var handler = (<any>window).StripeCheckout.configure({
      key: publicKey,
      locale: 'fr',
      color: 'black',
      email: email,
      image: '../../assets/images/logo_yers.png',
      token: function (token: any) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.

          console.log(nomPack);

          let response:any;

          let URLStripe:string = "http://"+API+"/Y_PROJECT/scripts/api_mobile/api_stripe_mobile.php"
                            +"?stripeToken="+token.id
                            +"&amount="+(prixPack*100)
                            +"&plan="+nomPack
                            +"&tva_percent_to_pay="+tva
                            +"&id_customer="+idCustomer
                            +"&id_affiliate="+idAffiliate
                            +"&id_pack="+idPack
                            +"&prix_pack_ttc="+prixPackTTC
                            +"&prix_pack_ht="+prixPackHT
                            +"&prix_ancien_pack="+prixAncienPack
                            +"&date_debut_abonnement="+dateDebutAbonnement
                            +"&mode=subscription";

          console.log("<<url stripe>>", URLStripe);
          console.log("print this noow");

          http2.get(URLStripe).subscribe((data)=>{
            let responseStripe = JSON.parse(data['_body']);

            if(responseStripe.data == 1){
              console.log("id Pack from tocken ", idPack);
              navCtrl.setRoot(BundlesPage, {params: idPack});
              //navCtrl.pop();
            }

            console.log("data", data);
          }, (error)=>{
            console.log("error", error);
          });

            /**START LOADING**/
              let loading = loadingCtrl.create({
                  content: "Paiement en cours de traitement...",
                  duration: 6000
               });

               loading.present();
             /**STOP LOADING**/
            }
            }, error =>{
                  console.log("ERREUR: ", error);
            });


    handler.open({
      name: 'YERS',
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
