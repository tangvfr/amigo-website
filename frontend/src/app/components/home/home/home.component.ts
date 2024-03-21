import { Component } from '@angular/core';
import {AboutHomePageComponent} from "../about-home-page/about-home-page.component";
import {
  PartenaireEntrepriseHomePageComponent
} from "../partenaire-entreprise-home-page/partenaire-entreprise-home-page.component";
import {PartenairePromoHomePageComponent} from "../partenaire-promo-home-page/partenaire-promo-home-page.component";
import {EventHomePageComponent} from "../event-home-page/event-home-page.component";

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    AboutHomePageComponent,
    PartenaireEntrepriseHomePageComponent,
    PartenairePromoHomePageComponent,
    EventHomePageComponent
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {

}
