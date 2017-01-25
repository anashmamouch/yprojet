import { Component } from '@angular/core';
import { NavController, Platform } from 'ionic-angular';

import { Geolocation } from 'ionic-native';

declare var google: any;

/*
  Generated class for the Localisation page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-localisation',
  templateUrl: 'localisation.html', 
})

export class LocalisationPage {
  // Map
  public map: any;

  // Map params
  mapLat: number;
  mapLng: number;
  

  constructor(public navCtrl: NavController, public platform: Platform) {
    console.log('Hello Localisation Page');

    Geolocation.getCurrentPosition().then(pos => {
      // mapLat = pos.coords.latitude;
      // mapLng = pos.coords.longitude;
      console.log("My location: lat= "+pos.coords.latitude+" / lng= "+pos.coords.longitude ); 
    });

    // when platform ready, init map
      platform.ready().then(() => {
        console.log('ready');
        // init map
        //Paris - France
        this.initializeMap(48.866667, 2.333333);
      });
  }

    initializeMap(latitude, longitude){
      let latLng = new google.maps.LatLng(latitude, longitude);

      console.log(latLng); 

      let mapOptions = {
        center: latLng,
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        zoomControl: false,
        streetViewControl: false
      }

      this.map = new google.maps.Map(document.getElementById("map-detail"), mapOptions);
      new google.maps.Marker({
        map: this.map,
        animation: google.maps.Animation.DROP,
        position: this.map.getCenter()
      });

      // refresh map
      setTimeout(() => {
        google.maps.event.trigger(this.map, 'resize');
      }, 300);
    }
  }

