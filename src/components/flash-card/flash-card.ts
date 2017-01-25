import { Component } from '@angular/core';

/*
  Generated class for the FlashCard component.

  See https://angular.io/docs/ts/latest/api/core/index/ComponentMetadata-class.html
  for more info on Angular 2 Components.
*/
@Component({
  selector: 'flash-card',
  templateUrl: 'flash-card.html'
})
export class FlashCardComponent {

  flipped: boolean = false;

  constructor() {
    console.log('Hello FlashCard Component');
  }

  flip(){
    this.flipped = !this.flipped;
  }

}
