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
import {components} from "../../models/schema.api";

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
  templateUrl: './company-dialog.component.html',
  styleUrl: './company-dialog.component.css'
})
export class CompanyDialogComponent {

  constructor(
    @Inject(MAT_DIALOG_DATA) public comp: components['schemas']['Company.jsonld-infoCompany']
  ) {}

}
