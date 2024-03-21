import {Component} from '@angular/core';
import {LeafletMapComponent} from "../leaflet-map/leaflet-map.component";
import {NamedPosition} from "../../models/map/named-position";
import {Location} from "../../models/map/location";
import {MatDialog} from "@angular/material/dialog";
import {MatButton} from "@angular/material/button";
import {MapService} from "../../services/map.service";

@Component({
  selector: 'app-test-leaflet-map',
  standalone: true,
  imports: [
    LeafletMapComponent,
    MatButton
  ],
  templateUrl: './test-leaflet-map.component.html',
  styleUrl: './test-leaflet-map.component.css'
})
export class TestLeafletMapComponent {

  //pos: NamedPosition[] = this.generateManyPos();

  constructor(
    private mapService: MapService
  ) {}

  test(): void
  {
    this.mapService.showMap('A test', this.generateManyLoc());
  }

  generateManyPos(): NamedPosition[]
  {
    let pos = [];
    const dezoom = 50;
    const len = Math.random() * 10;
    for (let i = 0; i < len; i++) {
      pos.push(this.generatePos(i, Math.random()/dezoom, Math.random()/dezoom))
    }
    return pos;
  }

  generatePos(nb: number, dla: number, dlo: number): NamedPosition
  {
    return new NamedPosition(
      40.0002 + dla,
      40.0002 + dlo,
      'Label ' + nb,
      'Addresse ' + nb,
    );
  }

  generateManyLoc(): Location[]
  {
    let loc = [];
    const dezoom = 50;
    const len = Math.random() * 10;
    for (let i = 0; i < len; i++) {
      loc.push(this.generateLoc(i, Math.random()/dezoom, Math.random()/dezoom))
    }
    return loc;
  }

  generateLoc(nb: number, dla: number, dlo: number): Location
  {
    return {
      latitude: 48.858370 + dla,
      longitude: 2.294481 + dlo,
      label: 'Label ' +nb,
      adresse: 'Addresse ' +nb,
      country: 'A Country'
    };
  }

}
