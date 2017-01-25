import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { Http } from '@angular/http'; 

declare var FusionCharts:any; 

/*
  Generated class for the Stats2 page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-stats2',
  templateUrl: 'stats2.html'
})
export class Stats2Page {

    idAffiliate:any; 
    API:any; 

    response:any; 

    data:any = []; 
    element:any; 

    values:any = [];
    colors:any = []; 
    sum:any = 0; 

    remuneration:any; 

  constructor(public navCtrl: NavController, public http:Http) {
    console.log("Hello Stats 2"); 

    this.element = document.getElementById('description'); 
  }

  getData(){
    this.idAffiliate = localStorage.getItem('id_affiliate'); 
    this.API = localStorage.getItem('api'); 

    let URL = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_statistique_remuneration_equipe.php?term="+this.idAffiliate; 
    
    this.http.get(URL).subscribe((data) => {
        this.response = JSON.parse(data['_body']); 

        console.log("JSON Response:", this.response);

        //calcul de somme
        for(var j = 0; j < (this.response.length - 1); j++){
            this.sum += this.response[j][1]; 
        }

        for(var i = 0; i < (this.response.length - 1); i++){

                this.data.push({
                    "label": this.response[i][0], 
                    "value": this.response[i][1],
                    "color": this.response[i][2], 
                    "link" : "Javascript:onClick(" + JSON.stringify(this.response[i][0]) + " , " + this.response[i][1] + ", "+ (this.response[i][1]/this.sum) +");"
                 }); 
        }

        console.log("data", this.data);

        this.DonutChart(this.data);

    }, (error) => {
        console.error("error rem equipe", error); 
    }); 


}

  ionViewDidLoad(){

    this.getData(); 
  }

DonutChart(data){
    FusionCharts.ready(function () {
        new FusionCharts({
            type: 'doughnut2d',
            renderAt: 'chart-container-2',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "",
                    "subCaption": "",
                    "numberPrefix": "",
                    "startingAngle": "20",
                    "paletteColors" : "#eed17f, #97cbe7, #b0d67a",
                    "showPercentValues": "0",
                    "showPercentInTooltip": "0",
                    "enableSmartLabels": "0",
                    "enableMultiSlicing": "0",
                    "decimals": "0",
                    "bgColor": "#ffffff",
                    "bgAlpha": "0",
                    "borderAlpha": "0",
                    "canvasBorderAlpha": "0",
                    "canvasBgAlpha": "0",
                    "showLabels": "0",
                    "showValues": "0",
                    "showToolTip": "0",
                    //theme
                    "theme": "fint"  
                },

                //data
                "data": data,
            }, 
        }).render();   
    });	
}

}
