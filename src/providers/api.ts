import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';

/*
  Generated class for the Api provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class Api {
 
  data: any= null;
  image:string = '';
  message: any = "I'm new here";
  API:string = ""; 

  URL:string; 

  autocompleteURL:any; 

  constructor(public http: Http) {
    console.log('Hello Api Provider');
    this.data ={'first_and_last_name': ''};

    //TEST
    localStorage.setItem('api', "localhost:8888");

    //PROD
    //localStorage.setItem('api', "localhost:8888");

    this.API = localStorage.getItem('api');  
  }

  setMessage(message) {
    this.message = message;
  }

  getInfo(id){
    this.URL = 'http://'+this.API+'/Y_PROJECT/scripts/api_mobile/api_infos_affiliate.php?term='+id;

    console.log(this.URL); 
    this.http.get(this.URL).subscribe(data=>{

      console.log(data); 
     
      var fullName = JSON.parse(data['_body'])['first_and_last_name']; 
      var imageURL = JSON.parse(data['_body'])['photo_profil'];

      this.image = 'http://' + this.API + '/Y_PROJECT/'+imageURL ; 
     
      this.data.first_and_last_name = fullName; 

      localStorage.setItem('image', this.image); 
      localStorage.setItem('affiliate', JSON.parse(data['_body'])); 
      localStorage.setItem('URL', this.URL); 

    }, error =>{
      console.log("this is an error ", error); 
    });
  }

}
