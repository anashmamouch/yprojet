import { Component } from '@angular/core';
import { MatchPage } from '../match/match'; 
import { MessagesPage } from '../messages/messages';

/*
  Generated class for the Tinder page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  templateUrl: 'tinder.html'
})
export class TinderPage {
  // this tells the tabs component which Pages
  // should be each tab's root Page
  match: any = MatchPage;
  messages: any = MessagesPage;

  constructor() {}
  
}
