import { Routes } from '@angular/router';
import {TesthComponent} from "./components/testh/testh.component";
import {EventsComponent} from "./components/events/events.component";
import {OffersComponent} from "./components/offers/offers.component";
import {OfficeComponent} from "./components/office/office.component";
import {HomeComponent} from "./components/home/home/home.component";
import {EventComponent} from "./components/event/event/event.component";

export const routes: Routes = [
  {path: '', component: TesthComponent},
  {path: 'home', component: HomeComponent},
  {path: 'event', component: EventComponent},
  {path: 'testh', component: TesthComponent},
  {path: 'events', component: EventsComponent},
  {path: 'offers', component: OffersComponent},
  {path: 'office', component: OfficeComponent},
];
