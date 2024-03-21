import {Component, Input} from '@angular/core';
import {components} from "../../models/schema.api";
import {NgForOf, NgOptimizedImage} from "@angular/common";
import {environment} from "../../../environments/environment";
import {MatButton} from "@angular/material/button";
import {MapService} from "../../services/map.service";

@Component({
  selector: 'app-company-card',
  standalone: true,
  imports: [
    NgOptimizedImage,
    MatButton,
    NgForOf
  ],
  templateUrl: './company-card.component.html',
  styleUrl: './company-card.component.css'
})
export class CompanyCardComponent {
  constructor(
    public mapService: MapService
  ) {}

  @Input({required: true}) public company!: components['schemas']['Company.jsonld-infoCompany']

  protected readonly environment = environment;
}
