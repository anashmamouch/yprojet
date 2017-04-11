import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Http } from '@angular/http';

declare var FusionCharts:any;

@Component({
  selector: 'page-stats3',
  templateUrl: 'stats3.html'
})
export class Stats3Page {

    API:string;
    idAffiliate:string;
    response:any;
    nombreFilleuls:any;

    data:any;

  constructor(public navCtrl: NavController, public navParams: NavParams, public http: Http) {
    console.log('Hello Stats3 Page');
    this.nombreFilleuls = this.navParams.get('filleuls');
  }

/*
  getData(){
    this.API = localStorage.getItem('api');
    this.idAffiliate = localStorage.getItem('id_affiliate');

    let URL:string = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_statistique_nbr_filleul.php?term='+this.idAffiliate;

    this.http.get(URL).subscribe((data)=>{
        this.response = JSON.parse(data['_body']);

        console.log("data url", this.response);

        this.data = [];

        for(var res in this.response){

          this.data.push({
            "label": this.response[res]['nom_mois'],
            "value": this.response[res]['nbr_filleul'],
            "color": "#fc1b80"
          })
        }

        console.log("data", this.data);

        this.AreaChart(this.data);

    }, (error) => {
        console.log("Error stats nombre filleuls: ", error);
    });

  }

  ionViewDidLoad(){
    this.getData();
  }

  AreaChart(data){
    FusionCharts.ready(function () {
      new FusionCharts({
          type: 'area2d',
          renderAt: 'chart-container-3',
          width: '95%',
          height: '400',
          dataFormat: 'json',
          dataSource: {
              "chart": {
                "caption": "",
                "subCaption": "",
                "xAxisName": "",
                "yAxisName": "",
                "numberPrefix": "",
                "decimals": "0",
                "bgColor": "#ffffff",
                "bgAlpha": "0",
                "borderAlpha": "0",
                "canvasBorderAlpha": "0",
                "canvasBgAlpha": "0",
                "showLabels": "1",
                "showValues": "0",
				        "showLimits": "1",
				        "showYAxisValues": "0",
                "showToolTip": "0",
                "valueFontColor": "#ffffff",
                "baseFontColor": "#fff",
                "baseFontSize": "13",
                "baseFont": "lato-bold-webfont",
                "xAxisLineColor": "#fff",
                "divlineColor": "#fff",
                "divLineAlpha": "20",
                "divLineIsDashed": "0",
                "showXAxisLine": "0",
                "drawAnchors": "0",

                "theme": "fint",
                  //Setting gradient fill to true
                  "usePlotGradientColor": "1",
                  //Setting the gradient formation color
                  "plotGradientColor": "#fff"
              },
              "data": data,
          }
      }).render();
  });
}
*/

}
