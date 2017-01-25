import { Component, ViewChild } from '@angular/core';
import { Nav, Platform } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';

//import pages
import { LoginPage } from '../pages/login/login';
import { MiseenrelationPage } from '../pages/miseenrelation/miseenrelation';
import { ParrainerPage } from '../pages/parrainer/parrainer';
import { MonequipePage } from '../pages/monequipe/monequipe';
import { AperorezoPage } from '../pages/aperorezo/aperorezo';
import { RecommandationsPage } from '../pages/recommandations/recommandations';
import { OutilsPage } from '../pages/outils/outils';
import { PreferencesPage } from '../pages/preferences/preferences';

import { PersonnelPage } from '../pages/personnel/personnel';

//import services
import { Api } from '../providers/api';
// import { ChatService } from '../providers/chat-service';
// import { UserService } from '../providers/user-service';

//import menu
import { MenuController } from 'ionic-angular'

@Component({
  templateUrl: 'app.html'

})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  rootPage: any = LoginPage;
  pages: Array<{title: string, component: any}>;

  nom:string;
  image:string;

  constructor(public platform: Platform, private api:Api, public menuCtrl: MenuController/*, public push:Push*/) {
    this.initializeApp();

    // used for an example of ngFor and navigation
    this.pages = [
      { title: 'Mise en relation', component: MiseenrelationPage },
      { title: 'Parrainer un ami', component: ParrainerPage},
      { title: 'Mon Equipe', component: MonequipePage },
      { title: 'AperoRezo', component: AperorezoPage},
      { title: 'Recommandations à traiter', component: RecommandationsPage },
      { title: 'Outils', component: OutilsPage},
      { title: 'Préférences', component: PreferencesPage },
	     { title: 'Mon profil', component: PersonnelPage },
    ];

      this.nom = localStorage.getItem('nom');
      this.image = api.image;
  }

  initializeApp() {
    console.log("Hello App Component");
     Splashscreen.hide();
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();

      console.log("Platform is ready...");
    });

  }

  openPage(page) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    this.nav.setRoot(page.component);
  }

  goToProfile(){
    this.nav.setRoot(PersonnelPage);
  }


  ionViewDidLoad(){
    this.nom = localStorage.getItem('nom');
    this.image = localStorage.getItem('image');
  }

}
