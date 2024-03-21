import {Component, Input} from '@angular/core';
import {Post} from "../../../models/office/post";
import {components} from "../../../models/schema.api";
import {NgForOf, NgOptimizedImage} from "@angular/common";
import {environment} from "../../../../environments/environment";
import {MatButton} from "@angular/material/button";
import {MapService} from "../../../services/map.service";

@Component({
  selector: 'app-entreprise-card',
  standalone: true,
  imports: [
    NgOptimizedImage,
    MatButton,
    NgForOf
  ],
  templateUrl: './entreprise-card.component.html',
  styleUrl: './entreprise-card.component.css'
})
export class EntrepriseCardComponent {
  constructor(
    public mapService: MapService
  ) {}
  @Input({required: true}) partner!: components["schemas"]["Partner.jsonld-challengerCompany"] ;
  protected readonly environment = environment;
}
