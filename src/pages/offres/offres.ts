import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { Http } from '@angular/http'; 

@Component({
  selector: 'page-offres',
  templateUrl: 'offres.html'
})
export class OffresPage {

  API:any; 
  idAffiliate:any; 

  response:any; 

  avantages:any = []; 

  images:any = []; 

  constructor(public navCtrl: NavController, public http:Http) {
    console.log('Hello offres');
  }

  getData(){
    this.API = localStorage.getItem('api'); 
    this.idAffiliate = localStorage.getItem('id_affiliate');

    let URL:string   = "http://"+this.API+"/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term="+this.idAffiliate; 

    this.http.get(URL).subscribe((data) => {
      this.response = JSON.parse(data['_body']); 

      this.avantages = this.response['list_avantages_bundle']; 



      console.log(this.avantages); 

      for(var i = 0; i < this.avantages.length; i++){
       this.avantages[i]['avantage_percent'] = "-" + Math.round(this.avantages[i]['avantage_percent']) + "%"; 
        var link = "assets/images/avantages/" + this.avantages[i]['link_background'];
        this.images.push(link); 
      }
  
    }, (error) => {
      console.log("Offres error: ", error); 
    }); 
  }

   // Wait for the components in MyApp's template to be initialized
  // In this case, we are waiting for the Nav with id="my-nav"
  ngAfterViewInit() {
    this.getData();
  }

}
