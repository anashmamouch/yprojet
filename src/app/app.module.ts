import { NgModule } from '@angular/core';
import { IonicApp, IonicModule } from 'ionic-angular';
import { MyApp } from './app.component';
import { BrowserModule } from '@angular/platform-browser';
import { SwingModule } from 'angular2-swing';

//Pages
import { LoginPage } from '../pages/login/login';
import { AccueilPage } from '../pages/accueil/accueil';
import { InscriptionPage } from '../pages/inscription/inscription';
import { AproposPage } from '../pages/apropos/apropos';
import { ParrainerPage } from '../pages/parrainer/parrainer';
import { ProfilePage } from '../pages/profile/profile';
import { StatistiquesPage } from '../pages/statistiques/statistiques';
import { OffresPage } from '../pages/offres/offres';
import { ParrainPage } from '../pages/parrain/parrain';
import { PersonnelPage } from '../pages/personnel/personnel';
import { VirementsPage } from '../pages/virements/virements';
import { BundlesPage } from '../pages/bundles/bundles';
import { ContactPage } from '../pages/contact/contact';
import { FaqPage } from '../pages/faq/faq';
import { CguPage } from '../pages/cgu/cgu';
import { ModepaiementPage} from '../pages/modepaiement/modepaiement';
import { EntreprisePage} from '../pages/entreprise/entreprise';
import { MotpasseoubliePage } from '../pages/motpasseoublie/motpasseoublie';
import { LocalisationPage } from '../pages/localisation/localisation';
import { TestPage } from '../pages/test/test';
import { MonequipePage } from '../pages/monequipe/monequipe';
import { FilleulsPage } from '../pages/filleuls/filleuls';
import { PlanningPage } from '../pages/planning/planning';
import { PlanninganneePage } from '../pages/planningannee/planningannee';
import { PlanningmoisPage } from '../pages/planningmois/planningmois';
import { PlanningjourPage } from '../pages/planningjour/planningjour';
import { TinderPage } from '../pages/tinder/tinder';
import { MessagesPage } from '../pages/messages/messages';
import { MessagedetailPage } from '../pages/messagedetail/messagedetail';
import { MatchPage } from '../pages/match/match';
import { OutilsPage } from '../pages/outils/outils';
import { Stats1Page } from '../pages/stats1/stats1';
import { Stats2Page } from '../pages/stats2/stats2';
import { Stats3Page } from '../pages/stats3/stats3';
import { Stats4Page } from '../pages/stats4/stats4';
import { Stats5Page } from '../pages/stats5/stats5';
import { PacksPage } from '../pages/packs/packs';
import { PacksHistoriquePage } from '../pages/packs-historique/packs-historique';
import { DetailsPackPage } from '../pages/detailspack/detailspack';

import { AperorezoPage } from '../pages/aperorezo/aperorezo';
import { MiseenrelationPage } from '../pages/miseenrelation/miseenrelation';
import { PreferencesPage } from '../pages/preferences/preferences';
import { RecommandationsPage } from '../pages/recommandations/recommandations'; 

//import services
import { Api } from '../providers/api';
import { UserService } from '../providers/user-service';
import { ChatService } from '../providers/chat-service';

//Facebook
import { Facebook } from 'ionic-native';

//Components
import { IonProfileHeader } from '../components/ion-profile-header';
import { FlashCardComponent } from '../components/flash-card/flash-card';

@NgModule({
  declarations: [
    MyApp,
    //pages
    LoginPage,
    AccueilPage,
    InscriptionPage,
    AproposPage,
    ParrainerPage,
    ProfilePage,
    StatistiquesPage,
    OffresPage,
    ParrainPage,
    PersonnelPage,
    VirementsPage,
    BundlesPage,
    ContactPage,
    FaqPage,
    CguPage,
    MotpasseoubliePage,
    ModepaiementPage,
    EntreprisePage,
    LocalisationPage,
    TestPage,
    MonequipePage,
    FilleulsPage,
    PlanningPage,
    PlanninganneePage,
    PlanningmoisPage,
    PlanningjourPage,
    TinderPage,
    MessagesPage,
    MessagedetailPage,
    MatchPage,
    OutilsPage,
    Stats1Page,
    Stats2Page,
    Stats3Page,
    Stats4Page,
    Stats5Page,
    PacksPage,
    PacksHistoriquePage,
    DetailsPackPage,

    AperorezoPage,
    MiseenrelationPage,
    PreferencesPage,
    RecommandationsPage,

    IonProfileHeader,
    FlashCardComponent

  ],
  imports: [
    IonicModule.forRoot(MyApp, {
        platforms: {
          android: {
            tabsPlacement: 'top',
            tabsLayout: 'title-hide',
            color: 'primary'
          },
          ios: {
            backButtonText: ' ',
          },
          windows: {
            tabsLayout: 'title-hide'
          }
        }
      }
      ),
    BrowserModule,
    SwingModule,
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    LoginPage,
    AccueilPage,
    InscriptionPage,
    AproposPage,
    ParrainerPage,
    ProfilePage,
    StatistiquesPage,
    OffresPage,
    ParrainPage,
    PersonnelPage,
    VirementsPage,
    BundlesPage,
    ContactPage,
    CguPage,
    FaqPage,
    MotpasseoubliePage,
    ModepaiementPage,
    EntreprisePage,
    LocalisationPage,
    TestPage,
    MonequipePage,
    FilleulsPage,
    PlanningPage,
    PlanninganneePage,
    PlanningmoisPage,
    PlanningjourPage,
    TinderPage,
    MessagesPage,
    MessagedetailPage,
    MatchPage,
    OutilsPage,
    Stats1Page,
    Stats2Page,
    Stats3Page,
    Stats4Page,
    Stats5Page,
    PacksPage,
    PacksHistoriquePage,
    DetailsPackPage,

    AperorezoPage,
    MiseenrelationPage,
    PreferencesPage,
    RecommandationsPage,
  ],
  providers: [
    Api,
    ChatService,
    UserService,
    Facebook
  ]
})
export class AppModule {}
