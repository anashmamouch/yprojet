import { Component } from '@angular/core';

import { MiseenrelationPage } from '../miseenrelation/miseenrelation';
import { ParrainerPage } from '../parrainer/parrainer';

@Component({
  selector: 'page-tabs',
  templateUrl: 'tabs.html'
})

export class TabsPage {

  miseenrelation: any = MiseenrelationPage;
  parrainer: any = ParrainerPage;

  constructor() {
    console.log("===============>tabs page")
  }

}
