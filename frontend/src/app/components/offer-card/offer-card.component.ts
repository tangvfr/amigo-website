import {Component, Input} from '@angular/core';
import {components} from "../../models/schema.api";
import {environment} from "../../../environments/environment";
import {MarkdownComponent} from "ngx-markdown";
import {NgForOf} from "@angular/common";
import {MapService} from "../../services/map.service";
import {MatButton} from "@angular/material/button";
import {AmigowsApiService} from "../../services/amigows.api.service";
import {MatDialog} from "@angular/material/dialog";
import {divIcon} from "leaflet";
import {CompanyDialogComponent} from "../company-dialog/company-dialog.component";

@Component({
  selector: 'app-offer-card',
  standalone: true,
  imports: [
    MarkdownComponent,
    NgForOf,
    MatButton
  ],
  templateUrl: './offer-card.component.html',
  styleUrl: './offer-card.component.css'
})
export class OfferCardComponent {

  @Input({required: true}) offer!: components['schemas']['Offer.jsonld-listOffer'];

  constructor(
    public mapService: MapService,
    public amigo: AmigowsApiService,
    public dialog: MatDialog,
  ) {
  }

  detail(id: number) {
    this.amigo.getCompany(id).subscribe({
      next: data => this.showComp(data),
      error: () => this.amigo.showErrorApiError()
    });
  }

  showComp(comp: components['schemas']['Company.jsonld-infoCompany']) {
    this.dialog.open(CompanyDialogComponent, {data: comp})
  }

  protected readonly environment = environment;
}
