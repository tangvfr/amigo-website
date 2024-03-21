import { Component } from '@angular/core';
import {EntrepriseCardComponent} from "../../entreprise/entreprise-card/entreprise-card.component";
import {MatProgressSpinner} from "@angular/material/progress-spinner";
import {HydraList} from "../../../models/hydra-list";
import {components} from "../../../models/schema.api";
import {AmigowsApiService} from "../../../services/amigows.api.service";

@Component({
  selector: 'app-partenaire-promotionnel',
  standalone: true,
    imports: [
        EntrepriseCardComponent,
        MatProgressSpinner
    ],
  templateUrl: './partenaire-promotionnel.component.html',
  styleUrl: './partenaire-promotionnel.component.css'
})
export class PartenairePromotionnelComponent {

  partners?: HydraList<components["schemas"]["Partner.jsonld-discountCompany"]>;
  ready: boolean;

  constructor(
    private amigowsApiService: AmigowsApiService
  ) {
    this.ready = false;
  }

  ngOnInit() {
    this.amigowsApiService.getDiscountPartner()
      .subscribe({//executé la requête
        next: partners => {
          this.partners = partners;
          this.ready = true;
        },
        //en cas d'erreur
        error: () => this.amigowsApiService.showErrorApiError()
      });
  }
}
