import { Routes } from '@angular/router';
import {TesthComponent} from "./components/testh/testh.component";
import {EventsComponent} from "./components/events/events.component";

export const routes: Routes = [
  {path: '', component: TesthComponent},
  {path: 'testh', component: TesthComponent},
  {path: 'events', component: EventsComponent},
];
