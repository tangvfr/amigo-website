import {AfterViewInit, Component, Input} from '@angular/core';
import * as L from "leaflet";
import {NamedPosition} from "../../models/map/named-position";
import {Position} from "../../models/map/position";
import {NgStyle} from "@angular/common";

const eiffelPos = new Position(48.858370, 2.294481);
const defaultZoom = 14;
const maxZoom = 18;
const minZoom = 3;

@Component({
  selector: 'app-leaflet-map',
  standalone: true,
  imports: [
    NgStyle
  ],
  templateUrl: './leaflet-map.component.html',
  styleUrl: './leaflet-map.component.css'
})
export class LeafletMapComponent implements AfterViewInit {

  @Input() posistions?: NamedPosition[];
  @Input() width?: string;
  @Input() height?: string;
  private map?: L.Map;

  centerMap(position: Position) {
    this.map!.panTo(position.convertToLatLon());
  }

  private initMaker() {
    for (let pos of this.posistions!) {
      pos.convertToMaker().addTo(this.map!);
    }
  }

  private initMap(): void {
    let first = this.posistions!.length === 0 ? eiffelPos : this.posistions![0];

    this.map = L.map('map', {
      center: first.convertToLatLon(),
      zoom: defaultZoom
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: maxZoom,
      minZoom: minZoom,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(this.map);
  }

  ngAfterViewInit(): void
  {
    this.initMap();
    this.initMaker();
  }

}
