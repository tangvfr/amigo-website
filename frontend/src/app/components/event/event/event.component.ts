import { Component } from '@angular/core';

import {SearchbarEventPageComponent} from "../searchbar-event-page/searchbar-event-page.component";
import {GalerieEventPageComponent} from "../galerie-event-page/galerie-event-page.component";

@Component({
  selector: 'app-event',
  standalone: true,
  imports: [
    SearchbarEventPageComponent,
    GalerieEventPageComponent
  ],
  templateUrl: './event.component.html',
  styleUrl: './event.component.css'
})
export class EventComponent {

}
