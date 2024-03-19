import { Component } from '@angular/core';
import {LeafletMapComponent} from "../leaflet-map/leaflet-map.component";

@Component({
  selector: 'app-test-leaflet-map',
  standalone: true,
  imports: [
    LeafletMapComponent
  ],
  templateUrl: './test-leaflet-map.component.html',
  styleUrl: './test-leaflet-map.component.css'
})
export class TestLeafletMapComponent {

}
