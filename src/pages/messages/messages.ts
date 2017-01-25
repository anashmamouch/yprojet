import {Component} from '@angular/core';
import {NavController, App} from 'ionic-angular';
import {ChatService} from "../../providers/chat-service";
import {MessagedetailPage} from "../messagedetail/messagedetail";

/*
  Generated class for the LoginPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-messages',
  templateUrl: 'messages.html',
})
export class MessagesPage {
  public chats;

  constructor(public nav: NavController, public chatService: ChatService, public app: App) {
   // set sample data
    this.chats = chatService.getAll();
  }

  // view chat detail
  viewChat(id) {
    this.app.getRootNav().push(MessagedetailPage, {id: id});
  }

}
