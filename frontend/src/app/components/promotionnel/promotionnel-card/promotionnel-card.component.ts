import {Component, Input} from '@angular/core';
import {components} from "../../../models/schema.api";

@Component({
  selector: 'app-promotionnel-card',
  standalone: true,
  imports: [],
  templateUrl: './promotionnel-card.component.html',
  styleUrl: './promotionnel-card.component.css'
})
export class PromotionnelCardComponent {
  @Input() partner!: components["schemas"]["Partner.jsonld-discountCompany"] ;
}
