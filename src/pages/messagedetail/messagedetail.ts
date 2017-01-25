import { Component, ViewChild } from '@angular/core';
import { NavController, NavParams, Content } from 'ionic-angular';

import {ChatService} from '../../providers/chat-service';

/*
  Generated class for the Messagedetail page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-messagedetail',
  templateUrl: 'messagedetail.html'
})
export class MessagedetailPage {
  @ViewChild(Content) content: Content;

  public chat: any;
  public newMessage: any;
  public socket:any;


  constructor(public navCtrl: NavController, public navParams:NavParams, public chatService: ChatService) {
     // get sample data only
    //this.chat = chatService.getItem(navParams.get('id'));
    this.chat = chatService.getItem(0);  
  }

  // send message
  sendMessage() {

    if (this.newMessage){
        
        this.chat.messages.push({
          type: 'sent',
          text: this.newMessage,
          image: '',
          time: 'Just now'
        });

      // clear input
      this.newMessage = '';

      // scroll to bottom
        setTimeout(() => {
          // scroll to bottom
          this.content.scrollToBottom();
        }, 200); 
              
    }
  }
}
