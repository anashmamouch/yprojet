import { NgModule } from '@angular/core';
import { IonicApp, IonicModule } from 'ionic-angular';
import { MyApp } from './app.component';
import { BrowserModule } from '@angular/platform-browser';
import { SwingModule } from 'angular2-swing';

//Pages
import { LoginPage } from '../pages/login/login';
import { AccueilPage } from '../pages/accueil/accueil';
import { InscriptionPage } from '../pages/inscription/inscription';
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
import { CgiPage } from '../pages/cgi/cgi';
import { CodebonsensPage } from '../pages/codebonsens/codebonsens';
import { ConceptPage } from '../pages/concept/concept';
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

//NOSREZO
import { AperorezoPage } from '../pages/aperorezo/aperorezo';
import { MiseenrelationPage } from '../pages/miseenrelation/miseenrelation';
import { Miseenrelation2Page } from '../pages/miseenrelation2/miseenrelation2'; 
import { PreferencesPage } from '../pages/preferences/preferences';
import { RecommandationsPage } from '../pages/recommandations/recommandations'; 
import { Recommandations2Page } from '../pages/recommandations2/recommandations2'; 
import { Recommandations3Page } from '../pages/recommandations3/recommandations3'; 
import { PaiementPage } from '../pages/paiement/paiement'; 
import { MajrecommandationsPage } from '../pages/majrecommandations/majrecommandations'; 
import { Majrecommandations2Page } from '../pages/majrecommandations2/majrecommandations2'; 
import { Majrecommandations3Page } from '../pages/majrecommandations3/majrecommandations3'; 
import { Majrecommandations4Page } from '../pages/majrecommandations4/majrecommandations4'; 
import { SimulateurfinancementPage } from '../pages/simulateurfinancement/simulateurfinancement'; 
import { SimulateurnotairePage } from '../pages/simulateurnotaire/simulateurnotaire';
import { SimulateurgainsPage } from '../pages/simulateurgains/simulateurgains'; 
import { SimulateurrevenuPage } from '../pages/simulateurrevenu/simulateurrevenu'; 
import { AproposPage } from '../pages/apropos/apropos'; 
import { Miseenrelation3Page } from '../pages/miseenrelation3/miseenrelation3'; 
import { Miseenrelation4Page } from '../pages/miseenrelation4/miseenrelation4'; 
import { Miseenrelation41Page } from '../pages/miseenrelation41/miseenrelation41'; 
import { Miseenrelation5Page } from '../pages/miseenrelation5/miseenrelation5'; 
import { Miseenrelation51Page } from '../pages/miseenrelation51/miseenrelation51'; 
import { Miseenrelation6Page } from '../pages/miseenrelation6/miseenrelation6'; 
import { ModalPage } from '../pages/modal/modal'; 
import { VideosPage } from '../pages/videos/videos'; 
import { TabsPage } from '../pages/tabs/tabs'; 

import { Ng2AutoCompleteModule } from 'ng2-auto-complete';

//import services
import { Api } from '../providers/api';
import { UserService } from '../providers/user-service';
import { ChatService } from '../providers/chat-service';
import { YoutubeService } from '../providers/youtube-service/youtube-service';

import { Youtube } from '../providers/youtube';
import { Safe } from '../pipes/safe';

//Facebook
import { Facebook } from 'ionic-native';

//http
import { Http } from '@angular/http';

//storage
import { Storage } from '@ionic/storage';

import { MultiPickerModule } from 'ion-multi-picker';


//Components
import { ScrollTabsComponent } from '../components/scrolltabs';
import { ionSlideTabs } from '../components/swipedtab/swipedtab';
import { IonProfileHeader } from '../components/ion-profile-header';
import { FlashCardComponent } from '../components/flash-card/flash-card';

//Translate
import { TranslateService, TranslateModule, TranslateStaticLoader, TranslateLoader } from 'ng2-translate/ng2-translate';

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
    CgiPage,
    CodebonsensPage,
    ConceptPage,
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
    Miseenrelation2Page,
    PreferencesPage,
    RecommandationsPage,
    Recommandations2Page,
    Recommandations3Page,
    PaiementPage,
    MajrecommandationsPage,
    Majrecommandations2Page,
    Majrecommandations3Page,
    Majrecommandations4Page,
    SimulateurfinancementPage,
    SimulateurnotairePage,
    SimulateurgainsPage,
    SimulateurrevenuPage,
    AproposPage, 
    TabsPage,

    Miseenrelation3Page,
    Miseenrelation4Page,
	  Miseenrelation41Page,
    Miseenrelation5Page,
    Miseenrelation51Page,
    Miseenrelation6Page,
    VideosPage,
	  
	  ModalPage,

    ionSlideTabs,
    IonProfileHeader,
    FlashCardComponent,
    ScrollTabsComponent,

    Safe

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
      }),
    Ng2AutoCompleteModule,
    TranslateModule.forRoot({
      provide: TranslateLoader, 
      useFactory: (http: Http) => new TranslateStaticLoader(http, '/assets/i18n', '.json'), 
      deps: [Http]
    }),
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
    CgiPage,
    CodebonsensPage,
    ConceptPage,
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
    TabsPage,

    AperorezoPage,
    MiseenrelationPage,
    Miseenrelation2Page,
    PreferencesPage,
    RecommandationsPage,
    Recommandations2Page,
    Recommandations3Page,
    PaiementPage,
    MajrecommandationsPage,
    Majrecommandations2Page,
    Majrecommandations3Page,
    Majrecommandations4Page,
    SimulateurfinancementPage,
    SimulateurnotairePage,
    SimulateurgainsPage,
    SimulateurrevenuPage,
    AproposPage, 
    VideosPage,

    Miseenrelation3Page,
    Miseenrelation4Page,
	  Miseenrelation41Page,
    Miseenrelation5Page,
    Miseenrelation51Page,
    Miseenrelation6Page,
	  
	  ModalPage,

    ionSlideTabs,
    IonProfileHeader,
    FlashCardComponent

  ],
  providers: [
    Storage, 
    Api,
    ChatService,
    UserService,
    Facebook, 
    TranslateService, 
    YoutubeService, 

    Youtube,
  ]
})
export class AppModule {}
