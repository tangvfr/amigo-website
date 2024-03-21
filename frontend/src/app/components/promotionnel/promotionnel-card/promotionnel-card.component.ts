import {Component, Input} from '@angular/core';
import {components} from "../../../models/schema.api";
import {environment} from "../../../../environments/environment";
import {MapService} from "../../../services/map.service";

@Component({
  selector: 'app-promotionnel-card',
  standalone: true,
  imports: [],
  templateUrl: './promotionnel-card.component.html',
  styleUrl: './promotionnel-card.component.css'
})
export class PromotionnelCardComponent {
  constructor(
    public mapService: MapService
  ) {}

  @Input() partner!: components["schemas"]["Partner.jsonld-discountCompany"] ;
  protected readonly environment = environment;
}
