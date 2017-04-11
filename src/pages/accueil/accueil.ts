import { Component , ViewChild } from '@angular/core';
import { NavController, ViewController, NavParams} from 'ionic-angular';
import { Http } from '@angular/http';

import CountUp from 'countup.js';

import { Stats1Page } from '../stats1/stats1';
import { Stats2Page } from '../stats2/stats2';
import { Stats3Page } from '../stats3/stats3';
import { PacksPage } from '../packs/packs';
import { BundlesPage } from '../bundles/bundles';
import { FilleulsPage } from '../filleuls/filleuls';
import { Slides, Platform } from 'ionic-angular';

import { Youtube } from '../../providers/youtube';

import { Api } from '../../providers/api';

import { IScrollTab, ScrollTabsComponent } from '../../components/scrolltabs';

//pages
import { SimulateurfinancementPage } from '../simulateurfinancement/simulateurfinancement'; 
import { SimulateurnotairePage } from '../simulateurnotaire/simulateurnotaire';
import { SimulateurgainsPage } from '../simulateurgains/simulateurgains'; 

import 'rxjs/add/operator/map';

import {YoutubeService} from '../../providers/youtube-service/youtube-service';


@Component({
  selector: 'page-accueil',
  templateUrl: 'accueil.html',
  providers:[YoutubeService]
})

export class AccueilPage {


    //youtube variables
    channelID: string = 'UC020AAJyyPtZwa2f4806J9A';
    maxResults: string = '10';
    pageToken: string; 
    googleToken: string = 'AIzaSyD_jvCjEOtaghictkl1IR0NurzB13Yrb4I';
    searchQuery: string = ' ';
    posts: any = [];
    onPlaying: boolean = false; 
    //end youtube variables

    //mes affiliés
    totalAffiliesEquipe:any; 
    affiliesNiv1:any;
    affiliesNiv2:any;
    affiliesNiv3:any;
    affiliesNiv4:any;
    affiliesNiv5:any;
    affiliesNiv6:any;
    //end mes affiliés

    //mes recommandations
    totalRecoEquipe:any; 
    recosNiv0:any;
    recosNiv1:any;
    recosNiv2:any;
    recosNiv3:any;
    recosNiv4:any;
    recosNiv5:any;
    recosNiv6:any;
    //end mes recommandations

    //ma remunération
    commissionEncaisser:any; 
    remunerationPotentielle:any;
    remNiv0:any; 
    remNiv1:any;
    remNiv2:any;
    remNiv3:any;
    remNiv4:any;
    remNiv5:any;
    remNiv6:any;
    //end ma remunération
    
    //videos
    channel = 'UC020AAJyyPtZwa2f4806J9A';
    datas:any;
    nextPageToken:any;
    id:any;
    //end videos

   tabs: IScrollTab[] = [
    {
      name: 'Mes affiliés'
    },
    {
      name: 'Mes recommandations'
    },
    {
      name: 'Ma rémunération'
    },
    {
      name: 'Mes outils'
    },
    {
      name: 'Vidéos '
    },
  ];
  selectedTab: IScrollTab;
  @ViewChild('scrollTab') scrollTab: ScrollTabsComponent;

  // @ViewChild('counter') counter:any;
  // @ViewChild('counter1') counter1:any;
  // @ViewChild('counter2') counter2:any;

  @ViewChild('mySlider') slider: Slides;

  public selected = 0;
  public indicator = null;
  public mySlideOptions2 =
  {
    loop: false,
    effect: 'slide',
    onSlideChangeStart: s => {

      let currentIndex = this.slider.getActiveIndex();

      if (currentIndex === 4) {
        this.selected = 4;
        this.indicator.style.webkitTransform = 'translate3d(400%,0,0)';
      }
      if (currentIndex === 3) {
        this.selected = 3;
        this.indicator.style.webkitTransform = 'translate3d(300%,0,0)';
      }
      if (currentIndex === 2) {
        this.selected = 2;
        this.indicator.style.webkitTransform = 'translate3d(200%,0,0)';
      }
      if (currentIndex === 1) {
        this.selected = 1;
        this.indicator.style.webkitTransform = 'translate3d(100%,0,0)';
      }
      if (currentIndex === 0) {
        this.selected = 0;
        this.indicator.style.webkitTransform = 'translate3d(0%,0,0)';
      }
    },
    onTransitionStart: s => {
      let currentIndex = this.slider.getActiveIndex();

      if (currentIndex === 4) {
        this.selected = 4;
        this.indicator.style.webkitTransform = 'translate3d(400%,0,0)';
      }

      if (currentIndex === 3) {
        this.selected = 3;
        this.indicator.style.webkitTransform = 'translate3d(300%,0,0)';
      }
      if (currentIndex === 2) {
        this.selected = 2;
        this.indicator.style.webkitTransform = 'translate3d(200%,0,0)';
      }
      if (currentIndex === 1) {
        this.selected = 1;
        this.indicator.style.webkitTransform = 'translate3d(100%,0,0)';
      }
      if (currentIndex === 0) {
        this.selected = 0;
        this.indicator.style.webkitTransform = 'translate3d(0%,0,0)';
      }
    }
  };

  constructor(public navCtrl: NavController, public platform: Platform, public http: Http, public ytPlayer: YoutubeService, public yt:Youtube) {
    this.platform = platform;
    this.initialise(); 


    //youtube 
    this.loadSettings();

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

  initialise(){

    this.totalAffiliesEquipe = localStorage.getItem('nb_filleul_total'); 
    this.affiliesNiv1 = localStorage.getItem('nb_affiliate_level_1');
    this.affiliesNiv2 = localStorage.getItem('nb_affiliate_level_2');
    this.affiliesNiv3 = localStorage.getItem('nb_affiliate_level_3');
    this.affiliesNiv4 = localStorage.getItem('nb_affiliate_level_4');
    this.affiliesNiv5 = localStorage.getItem('nb_affiliate_level_5');
    this.affiliesNiv6 = localStorage.getItem('nb_affiliate_level_6');

    this.totalRecoEquipe = localStorage.getItem('nb_reco'); 
    this.recosNiv0 = localStorage.getItem('nb_reco_level_0')
    this.recosNiv1 = localStorage.getItem('nb_reco_level_1'); 
    this.recosNiv2 = localStorage.getItem('nb_reco_level_2'); 
    this.recosNiv3 = localStorage.getItem('nb_reco_level_3'); 
    this.recosNiv4 = localStorage.getItem('nb_reco_level_4'); 
    this.recosNiv5 = localStorage.getItem('nb_reco_level_5'); 
    this.recosNiv6 = localStorage.getItem('nb_reco_level_6'); 

    this.commissionEncaisser = localStorage.getItem('commission_a_encaisser'); 
    this.remunerationPotentielle = localStorage.getItem('gain_potentiel'); 
    this.remNiv0 = localStorage.getItem('remuneration_level_0'); 
    this.remNiv1 = localStorage.getItem('remuneration_level_1'); 
    this.remNiv2 = localStorage.getItem('remuneration_level_2'); 
    this.remNiv3 = localStorage.getItem('remuneration_level_3'); 
    this.remNiv4 = localStorage.getItem('remuneration_level_4'); 
    this.remNiv5 = localStorage.getItem('remuneration_level_5'); 
    this.remNiv6 = localStorage.getItem('remuneration_level_6'); 

  }

  //YOUTUBE
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
  //END YOUTUBE

  ionViewDidEnter() {
    this.scrollTab.go2Tab(0);
  }

  tabChange(data: any) {
    this.selectedTab = data.selectedTab;
  }

  select(index) {
    this.selected = index;
    if (index === 4) 
      this.indicator.style.webkitTransform = 'translate3d(400%,0,0)';
    if (index === 3) 
      this.indicator.style.webkitTransform = 'translate3d(300%,0,0)';
    if (index === 2)
      this.indicator.style.webkitTransform = 'translate3d(200%,0,0)';
    if (index === 1)
      this.indicator.style.webkitTransform = 'translate3d(100%,0,0)';
    if (index === 0)
      this.indicator.style.webkitTransform = 'translate3d(0%,0,0)';
    this.slider.slideTo(index, 500);
  }

  onSlideChanged($event) {
    if (!(((($event.touches.startX - $event.touches.currentX) <= 100) || (($event.touches.startX - $event.touches.currentX) > 0)) && (this.slider.isBeginning() || this.slider.isEnd()))) {
      this.indicator.style.webkitTransform = 'translate3d(' + (-($event.translate) / 4) + 'px,0,0)';
    }

  }

  panEvent(e) {
    let currentIndex = this.slider.getActiveIndex();
    if (currentIndex === 4) {
      this.selected = 4;
      this.indicator.style.webkitTransform = 'translate3d(300%,0,0)';
    }
    if (currentIndex === 3) {
      this.selected = 3;
      this.indicator.style.webkitTransform = 'translate3d(300%,0,0)';
    }
    if (currentIndex === 2) {
      this.selected = 2;
      this.indicator.style.webkitTransform = 'translate3d(200%,0,0)';
    }
    if (currentIndex === 1) {
      this.selected = 1;
      this.indicator.style.webkitTransform = 'translate3d(100%,0,0)';
    }
    if (currentIndex === 0) {
      this.selected = 0;
      this.indicator.style.webkitTransform = 'translate3d(0%,0,0)';
    }
  }

  getData() {
    // this.nombreFilleuls = localStorage.getItem('nb_filleul_total'); 
    // this.affiliesNiv1 = localStorage.getItem('nb_affiliate_level_1'); 
    // this.affiliesNiv2 = localStorage.getItem('nb_affiliate_level_2'); 
    // this.demo = new CountUp(this.counter.nativeElement, 0, Math.round(parseInt(this.nombreFilleuls)), 0,  2.5, this.options);
    // this.demo1 = new CountUp(this.counter1.nativeElement, 0, Math.round(parseInt(this.affiliesNiv1)), 0,  2.5, this.options);
    // this.demo2 = new CountUp(this.counter2.nativeElement, 0, Math.round(parseInt(this.affiliesNiv2)), 0,  2.5, this.options);  
  }

  ngAfterViewInit() {
    // this.getData();

    // this.indicator = document.getElementById("indicatorFor4");
    // if (this.platform.is('windows')) {
    //   this.indicator.style.opacity = '0';
    // }

    // setInterval(() => {
    //   this.demo.start();
    //   this.demo1.start();
    //   this.demo2.start();
    // }, 500);
  }

  goAffiliesNiv1(){
    this.navCtrl.push(FilleulsPage); 
  }
 
	goFinancement(){ 
		this.navCtrl.push(SimulateurfinancementPage); 
	  }

	  goNotaire(){
		this.navCtrl.push(SimulateurnotairePage); 
	  }

	  goGains(){
		this.navCtrl.push(SimulateurgainsPage); 
	  }

    //YOUTUBE LOGIC 

    launchYTPlayer(id, title): void {
    this.ytPlayer.launchPlayer(id, title);
  }

  fetchData(): void {

    let url = 'https://www.googleapis.com/youtube/v3/search?part=id,snippet&channelId=' 
              + this.channelID 
              + '&q=' + this.searchQuery 
              + '&type=video&order=viewCount&maxResults=' + this.maxResults 
              + '&key=' + this.googleToken;

    console.log(url); 

    if(this.pageToken) {
      url += '&pageToken=' + this.pageToken;
    }

    this.http.get(url).map(res => res.json()).subscribe(data => {
      
      console.log (data.items);
      // *** Get individual video data like comments, likes and viewCount. Enable this if you want it.
      // let newArray = data.items.map((entry) => {
      //   let videoUrl = 'https://www.googleapis.com/youtube/v3/videos?part=id,snippet,contentDetails,statistics&id=' + entry.id.videoId + '&key=' + this.googleToken;
      //   this.http.get(videoUrl).map(videoRes => videoRes.json()).subscribe(videoData => {
      //     console.log (videoData);
      //     this.posts = this.posts.concat(videoData.items);
      //     return entry.extra = videoData.items;
      //   });
      // });
      this.posts = this.posts.concat(data.items);
    });
    }
    loadSettings(): void {
        this.fetchData();
    }
    openSettings(): void {
        console.log("TODO: Implement openSettings()");
    }
    playVideo(e, post): void {
        console.log(post);
        this.onPlaying = true;
        this.ytPlayer.launchPlayer(post.id, post.snippet.title);
    }
    loadMore(): void {
        console.log("TODO: Implement loadMore()");
    }



}
