import { Routes } from '@angular/router';
import {TesthComponent} from "./components/testh/testh.component";
import {EventsComponent} from "./components/event/events/events.component";
import {OffersComponent} from "./components/offers/offers.component";
import {OfficeComponent} from "./components/amigo-office/office/office.component";
import {HomeComponent} from "./components/home/home/home.component";
import {MiagePageComponent} from "./components/miage-page/miage-page.component";
import {
  PartenaireEntrepriseComponent
} from "./components/entreprise/partenaire-entreprise/partenaire-entreprise.component";


export const routes: Routes = [
  {path: '', component: TesthComponent},
  {path: 'home', component: HomeComponent},
  {path: 'events', component: EventsComponent},
  {path: 'testh', component: TesthComponent},
  {path: 'challenger', component: PartenaireEntrepriseComponent},
  {path: 'offers', component: OffersComponent},
  {path: 'office', component: OfficeComponent},
  {path: 'aboutM', component: MiagePageComponent},
];
