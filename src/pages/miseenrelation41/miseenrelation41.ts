import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';


@Component({
  selector: 'page-miseenrelation41',
  templateUrl: 'miseenrelation41.html'
})
export class Miseenrelation41Page {

  image:any; 
  title:any; 
  description:any; 
  commentParler:any; 
  remMoyenne:any;
  item:any;

  constructor(public navCtrl: NavController, public navParams: NavParams) {

    this.item = this.navParams.get('item'); 
    console.log('item===>', this.item); 

    this.title = this.item['s_sub_category']; 
    this.description = this.item['description_service']; 
    this.commentParler = this.item['comment_en_parler'];
    this.image = '../../assets/images/' + this.item['photo_service']; 

  }

}
