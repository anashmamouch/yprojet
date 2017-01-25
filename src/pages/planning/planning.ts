import { Component } from '@angular/core';

import { PlanningjourPage } from '../planningjour/planningjour'; 
import { PlanningmoisPage } from '../planningmois/planningmois'; 
import { PlanninganneePage } from '../planningannee/planningannee'; 

/*
  Generated class for the Planning page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  templateUrl: 'planning.html'
})
export class PlanningPage {
  tab1Root: any = PlanningjourPage;
  tab2Root: any = PlanningmoisPage;
  tab3Root: any = PlanninganneePage;
     
  constructor() {
     console.log('Hello Planning Page');

  }
}
