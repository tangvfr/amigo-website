import { Component } from '@angular/core';
import {Office} from "../../../models/office/office";
import {AmigowsApiService} from "../../../services/amigows.api.service";
import {delay} from "rxjs";
import {components} from "../../../models/schema.api";
import {HydraList} from "../../../models/hydra-list";
import {EntrepriseCardComponent} from "../entreprise-card/entreprise-card.component";
import {MatProgressSpinner} from "@angular/material/progress-spinner";

@Component({
  selector: 'app-partenaire-entreprise',
  standalone: true,
  imports: [
    EntrepriseCardComponent,
    MatProgressSpinner
  ],
  templateUrl: './partenaire-entreprise.component.html',
  styleUrl: './partenaire-entreprise.component.css'
})
export class PartenaireEntrepriseComponent {

  parthers?: HydraList<components["schemas"]["Partner.jsonld-challengerCompany"]>;
  ready: boolean;

  constructor(
    private amigowsApiService: AmigowsApiService
  ) {
    this.ready = false;
  }

  ngOnInit() {
    this.amigowsApiService.getChallengerPartner()
      .subscribe({//executé la requête
        next: parthers => {
          this.parthers = parthers;
          this.ready = true;
        },
        //en cas d'erreur
        error: () => this.amigowsApiService.showErrorApiError()
      });
  }


}
