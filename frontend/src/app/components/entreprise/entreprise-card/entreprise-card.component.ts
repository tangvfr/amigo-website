import {Component, Input} from '@angular/core';
import {Post} from "../../../models/office/post";
import {components} from "../../../models/schema.api";
import {NgOptimizedImage} from "@angular/common";

@Component({
  selector: 'app-entreprise-card',
  standalone: true,
  imports: [
    NgOptimizedImage
  ],
  templateUrl: './entreprise-card.component.html',
  styleUrl: './entreprise-card.component.css'
})
export class EntrepriseCardComponent {
  @Input() parther?: components["schemas"]["Partner.jsonld-challengerCompany"] ;
}
