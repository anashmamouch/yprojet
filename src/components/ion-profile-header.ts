import { Component, Input, Output, EventEmitter, SimpleChange} from '@angular/core';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';
import { Content } from 'ionic-angular'

@Component({
  selector: 'ion-profile-header',
  template: `
      <div class="profile-container">
        <div 
          class="background-img-container {{_options.background && _options.background.classes}}"
          [ngStyle]="{
            'background-image': 'url(' + _options.background.url + ')',
            'filter': 'blur(' + _options.background.blur.value + ')'
          }"></div>
        <div class="background-img-blur" [ngStyle]="{
          'background-image': 'linear-gradient(to top right, ' + _options.background.blur.colors.start + ' 0%, 
          ' + _options.background.blur.colors.mid + ' 45%, ' + _options.background.blur.colors.end + ' 60%)'
        }"></div>

        <div class="content-container">
          <div class="img-container">
            <img src="{{_options.img.url}}" class="{{_options.img && _options.img.classes}}" />
          </div>
          <h2 class="{{_options.name && _options.name.classes}}">{{_options.name.text}}</h2>
          <h5 *ngIf="_options.subtext && _options.subtext.text" class="{{_options.subtext && _options.subtext.classes}}"
            [innerHTML]="trustContent(_options.subtext.text)">
           </h5>
        </div>
      </div>
  `,
  styles: [`
    .profile-container {
      width: 100%;
      height: 200px;
      position: relative;
      overflow: hidden;
      transform: translateZ(0);
    }
    .profile-container .background-img-container {
      background-size: cover;
      width: 100%;
      height: 100%;
    }
    .profile-container .background-img-blur {
      position: absolute;
      width: 100%;
      height: 100%;
      filter: blur(70px);
      top: 0px;
      left: 0px;
    }
    .profile-container .content-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .profile-container .content-container h2 {
      color: white;
      font-size: 1.3em;
      margin: 2px auto;
      letter-spacing: 1px;
    }
    .profile-container .content-container h5 {
      color: #CCC;
      font-size: 0.95em;
      margin: 2px auto;
    }
    .profile-container .content-container .img-container img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 4px solid rgba(255,255,255,0.2);
    }
  `]
})
export class IonProfileHeader {
  @Input() options: IonProfileHeaderOptions;

  private _options = {};

  constructor(private _sanitizer: DomSanitizer) { }

  ngOnInit() {
    if (this.options === undefined || this.options === null) {
      console.error('[IonProfileHeader] options are not defined.');
    }
    this._options = this.options;
  }

  ngOnChanges(changes: { [propName: string]: SimpleChange }) {
    let o: SimpleChange = changes['options'];
    if (this.options && o && !o.isFirstChange()) {
      console.log('updating options');
      console.log(o.currentValue);
      this._options = o.currentValue;
    }
  }

  trustContent(content: string): SafeHtml {
    return this._sanitizer.bypassSecurityTrustHtml(content);
  }  
}

export interface IonProfileHeaderOptions {
  background: {
    url: string,
    classes?: string,
    blur?: {
      value?: string,
      colors?: {
        start?: string,
        mid?: string,
        end?: string
      }
    }
  },
  img: {
    url: string,
    classes?: string
  },
  name: {
    text: string,
    classes?: string
  },
  subtext?: {
    text?: string,
    classes?: string
  }
} 