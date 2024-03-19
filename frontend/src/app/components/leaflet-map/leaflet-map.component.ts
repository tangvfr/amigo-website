import {AfterViewInit, Component} from '@angular/core';
import * as L from "leaflet";

@Component({
  selector: 'app-leaflet-map',
  standalone: true,
  imports: [],
  templateUrl: './leaflet-map.component.html',
  styleUrl: './leaflet-map.component.css'
})
export class LeafletMapComponent implements AfterViewInit {

  private map?: L.Map;

  private initMap(): void {
    this.map = L.map('amap', {
      center: [ 39.8282, -98.5795 ],
      zoom: 3
    });

    const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      minZoom: 3,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    const coord = L.latLng(47.4909252, 2.4481896);

    this.map.setZoom(14);
    this.map.panTo(coord);//permet de centré la map

    const tMaker = L.marker(coord, {
      alt: 'Try',
      title: 'A Title ?',
    }).addTo(this.map);

    //tMaker.bindPopup("<b>Hé ouais</b><br /> T bien la !").openPopup(); ouvrir par default le pop up
    tMaker.bindPopup("<b>Hé ouais</b><br /> T bien la !");

    tiles.addTo(this.map);
  }

  constructor() { }

  ngAfterViewInit(): void
  {
    this.initMap();
  }

}
