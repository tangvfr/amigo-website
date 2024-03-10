import { Routes } from '@angular/router';
import {TesthComponent} from "./components/testh/testh.component";
import {EventsComponent} from "./components/events/events.component";
import {OffersComponent} from "./components/offers/offers.component";

export const routes: Routes = [
  {path: '', component: TesthComponent},
  {path: 'testh', component: TesthComponent},
  {path: 'events', component: EventsComponent},
  {path: 'offers', component: OffersComponent},
];
