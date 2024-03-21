import {Component, Inject} from '@angular/core';
import {LeafletMapComponent} from "../leaflet-map/leaflet-map.component";
import {MatButton} from "@angular/material/button";
import {Location} from "../../models/map/location";
import {
  MAT_DIALOG_DATA,
  MatDialog,
  MatDialogActions,
  MatDialogClose,
  MatDialogContent,
  MatDialogTitle
} from "@angular/material/dialog";
import {createNamedPositionFromLocation, NamedPosition} from "../../models/map/named-position";

@Component({
  selector: 'app-addresse-map-dialog',
  standalone: true,
  imports: [
    LeafletMapComponent,
    MatButton,
    MatDialogActions,
    MatDialogClose,
    MatDialogContent,
    MatDialogTitle,
  ],
  templateUrl: './addresse-map-dialog.component.html',
  styleUrl: './addresse-map-dialog.component.css'
})
export class AddresseMapDialogComponent {

  locs: NamedPosition[];
  title: string;

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: MapData
  ) {
    this.title = data.title;

    let locations = [];
    for (let loc of data.locations) {
      locations.push(createNamedPositionFromLocation(loc));
    }
    this.locs = locations;
  }

}

export interface MapData {
  title: string,
  locations : Location[],
}
