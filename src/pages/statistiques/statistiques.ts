import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

//pages
import { Stats1Page } from '../stats1/stats1'; 
import { Stats2Page } from '../stats2/stats2'; 
import { Stats3Page } from '../stats3/stats3'; 
import { Stats4Page } from '../stats4/stats4'; 
import { Stats5Page } from '../stats5/stats5'; 

@Component({
  selector: 'page-statistiques',
  templateUrl: 'statistiques.html'
})

export class StatistiquesPage {

  constructor(public navCtrl: NavController) {
    console.log("Hello Page Statistiques"); 
  }

    onStats1(){
        this.navCtrl.push(Stats1Page); 
    }

    onStats2(){
        this.navCtrl.push(Stats2Page); 
    }
    onStats3(){
        this.navCtrl.push(Stats3Page); 
    }
    onStats4(){
        this.navCtrl.push(Stats4Page); 
    }
    onStats5(){
        this.navCtrl.push(Stats5Page); 
    }
	
}
