import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

declare var FusionCharts:any; 

/*
  Generated class for the Stats5 page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-stats5',
  templateUrl: 'stats5.html'
})
export class Stats5Page {
    data:any; 

  constructor(public navCtrl: NavController) {
    console.log("hello Stats5"); 
  }

  ionViewDidLoad(){
      this.data = [{
                        "minValue": "0",
                        "maxValue": "45",
                        "code": "#8e0000"
                    }, {
                        "minValue": "45",
                        "maxValue": "75",
                        "code": "#f2c500"
                    }, {
                        "minValue": "75",
                        "maxValue": "100",
                        "code": "#1aaf5d"
                    }]; 

      this.LedGaugeChart(this.data);
  }

  LedGaugeChart(data){    
    FusionCharts.ready(function () {
        new FusionCharts({
            type: 'hled',
            renderAt: 'chart-container-5',
            width: '100%',
            height: '150',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "",
                    "subcaption": "",
                    "subcaptionFontBold": "0",
                    "lowerLimit": "0",
                    "upperLimit": "100",
                    "lowerLimitDisplay": "Mauvais",
                    "upperLimitDisplay": "Excellent",
                    "numberSuffix": "%",
                    "showValue": "0",                
                    "showBorder": "0",
                    "bgColor": "#ffffff",
                    "bgAlpha": "0",
                    "borderAlpha": "0",
                    "canvasBorderAlpha": "0",
                    "canvasBgAlpha": "0",
                    "showLabels": "0",
                    "showValues": "0",
                    "showToolTip": "0",
                    "valueFontColor": "#ffffff", 
                    "baseFontColor": "#fff",
                    "baseFontSize": "10",
                    "baseFont": "lato-bold-webfont",
                    "showShadow": "0",
                    "tickMarkDistance": "5"
                },
                "colorRange": {
                    "color": data,
                },
                "value": "92"
            }
        }).render();
    });
  }

}
