import {Component, Inject} from '@angular/core';
import {LeafletMapComponent} from "../leaflet-map/leaflet-map.component";
import {MatButton} from "@angular/material/button";
import {
  MAT_DIALOG_DATA,
  MatDialogActions,
  MatDialogClose,
  MatDialogContent,
  MatDialogTitle
} from "@angular/material/dialog";
import {components} from "../../models/schema.api";
import {EntrepriseCardComponent} from "../entreprise/entreprise-card/entreprise-card.component";
import {CompanyCardComponent} from "../company-card/company-card.component";

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
    EntrepriseCardComponent,
    CompanyCardComponent,
  ],
  templateUrl: './company-dialog.component.html',
  styleUrl: './company-dialog.component.css'
})
export class CompanyDialogComponent {

  constructor(
    @Inject(MAT_DIALOG_DATA) public company: components['schemas']['Company.jsonld-infoCompany']
  ) {}

}
