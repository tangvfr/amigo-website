import {Component} from '@angular/core';
import {NgOptimizedImage} from "@angular/common";
import {environment} from "../../../../environments/environment";
import {components} from "../../../models/schema.api";
import {MapService} from "../../../services/map.service";
import {NamedPosition} from "../../../models/map/named-position";
import {MatButton} from "@angular/material/button";

const pos3ia = new NamedPosition(
  47.84549226303799,
  1.9396956419879343,
  'AMIGO',
  'Bâtiment I.I.I.A. Université, 45100 Orléans France'
)

@Component({
  selector: 'app-footer',
  standalone: true,
  imports: [
    NgOptimizedImage,
    MatButton
  ],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.css'
})
export class FooterComponent {

  protected readonly environment = environment;

  constructor(
    public mapService: MapService,
  ) {
  }

  showLocAMIGO() {
    this.mapService.showMap('Où trouver l\'AMIGO', [pos3ia]);
  }

}
