import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Youtube } from '../../providers/youtube';

  // channelID: string = 'UC020AAJyyPtZwa2f4806J9A';

@Component({
  selector:'page-videos',
  templateUrl: 'videos.html',
})
export class VideosPage {
  
  channel = 'UC020AAJyyPtZwa2f4806J9A';
  datas:any;
  nextPageToken:any;
  id:any;

   constructor(public navCtrl: NavController, private yt: Youtube) {
      yt.playlist(this.channel).then(data => {
        
        console.log('...YOUTUBE...data...', data);

        this.id = data.items[0].id;

        yt.playlistList(this.id).then(data => {
          this.datas = data.items;
          if(data.nextPageToken){
            this.nextPageToken = data.nextPageToken;
          }
        })

    });
   }

   infiniteScrool(ev){
    if(this.nextPageToken){
      this.yt.playlistList_page(this.id, this.nextPageToken).then(data=>{
        for(let i of data.items){
          this.datas.push(i);
        }
        if(!data.nextPageToken){
          this.nextPageToken = null;
        }else{
          this.nextPageToken = data.nextPageToken;
        }
        ev.complete();
      });
    }else{
      ev.complete();
    }
  }

}
