import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';

declare var FusionCharts:any; 

/*
  Generated class for the Stats4 page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-stats4',
  templateUrl: 'stats4.html'
})
export class Stats4Page {

    data:any; 

  constructor(public navCtrl: NavController) {
    console.log('Hello Stats4 Page');
  }

  ionViewDidLoad(){
    this.data =  [
                        {
                            "minValue": "0",
                            "maxValue": "50",
                            "Alpha": "30",
                            "code": "#233a71"
                        },
                        {
                            "minValue": "50",
                            "maxValue": "75",
                            "Alpha": "50",
                            "code": "#3266c7"
                        },
                        {
                            "minValue": "75",
                            "maxValue": "100",
                             "Alpha": "80",
                            "code": "#29f0c7"
                        }
                    ]; 

    this.GaugeChart(this.data);
  }

  GaugeChart(data){
      FusionCharts.ready(function () {
        new FusionCharts({
            type: 'angulargauge',
            renderAt: 'chart-container-4',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "",
                    "subcaption": "",
                    "lowerLimit": "0",
                    "upperLimit": "100",
                    "showGaugeBorder": "0",
                    "showValue": "1",
                    "valueBelowPivot": "1",
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
                    "pivotBorderAlpha": "0",
                    "pivotFillAlpha": "0",
                    "showTickValues": "0",
                    "showTickMarks": "0",
                    "theme": "fint"
                },
                "colorRange": {
                    "color": data,
                },
                "dials": {
                    "dial": [{
                        "value": "32"
                    }]
                }
            }
        }).render();
    });
  }

}
