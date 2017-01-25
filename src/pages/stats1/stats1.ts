import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

import { Http } from "@angular/http";

declare var FusionCharts:any;

/*
  Generated class for the Stats1 page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-stats1',
  templateUrl: 'stats1.html'
})
export class Stats1Page {

    data:any = [];

    API:any;

    idAffiliate:any;

    response:any;

    average:any;

    cagnotte:any = '';

constructor(public navCtrl: NavController, public http:Http) {
    console.log("Hello Stats1 Page");
 }

 getData(){
    this.idAffiliate = localStorage.getItem('id_affiliate');
    this.API = localStorage.getItem('api');

     let URL = "http://" + this.API + "/Y_PROJECT/scripts/api_mobile/api_statistique_remuneration_en_cours.php?term="+this.idAffiliate;

     this.http.get(URL).subscribe((data) => {
        this.response = JSON.parse(data['_body']);

        console.log(this.response);

        var sum = 0

        for(var i = 1; i < this.response.length; i++){
            console.log(this.response[i-1]);

            this.data.push({
                "label": ""+i,
                "value": this.response[i-1],
            });

            sum += this.response[i-1];
        }

        this.cagnotte = this.response[this.response.length - 1 ];

        this.average = Math.round(sum/this.response.length);

        console.log("data", this.data)
        console.log("somme", sum);
        console.log("average", this.average);
        console.log("cagnotte", this.cagnotte);

        this.YAxisChart(this.data, this.average);

     }, (error) =>{
         console.log("error statistiques en cours", error);
     });
 }

ionViewDidLoad(){
    this.getData();
  }

YAxisChart(data, average){
    FusionCharts.ready(function () {
        new FusionCharts({
          type: 'column2d',
          renderAt: 'chart-container',
          width: '100%',
          height: '400',
          dataFormat: 'json',
          dataSource: {
              "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisName": "",
                "yAxisName": "",
                "numberPrefix": "",
                "numberSuffix": "",
                "paletteColors": "#24ccf8",
                "bgColor": "#ffffff",
                "bgAlpha": "0",
                "borderAlpha": "0",
                "canvasBorderAlpha": "0",
                "canvasBgAlpha": "0",
                "usePlotGradientColor": "1",
                "PlotGradientColor": "#a800fc",
                "plotBorderAlpha": "0",
                "displayValue": "none",
                "placevaluesInside": "0",
                "rotatevalues": "0",
                "valueFontColor": "#fff",
                "baseFontColor": "#fff",
				        "baseFontAlpha": "30",
                "baseFontSize": "13",
                "baseFont": "lato-bold-webfont",
                "xAxisLineColor": "#fff",
				        "xAxisLineAlpha": "40",
                "yAxisLineColor": "#fff",
				        "yAxisLineAlpha": "40",
                "divlineColor": "#fff",
                "divLineAlpha": "0",
                "divLineIsDashed": "0",
                "showAlternateHGridColor": "0",
                "showLabels": "1",
                "showValues": "1",
                "showXAxisLine": "1",
                "showYAxisLine": "1",
				        "showLimits": "1",
				        "showYAxisValues": "0",
                "showToolTip": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"

              },
              "data": data,
              "trendlines": [
                  {
                      "line": [
                          {
                              "startvalue": average,
                              "color": "#1aaf5d",
                              "valueOnRight": "0",
                              "displayvalue": ""
                          }
                      ]
                  }
              ]
          }

      }).render();
  });
}

}
