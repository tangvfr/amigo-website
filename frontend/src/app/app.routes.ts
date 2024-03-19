import {Routes} from '@angular/router';
import {TesthComponent} from "./components/testh/testh.component";
import {EventsComponent} from "./components/events/events.component";
import {OffersComponent} from "./components/offers/offers.component";
import {OfficeComponent} from "./components/office/office.component";
import {TestLeafletMapComponent} from "./components/test-leaflet-map/test-leaflet-map.component";

export const routes: Routes = [
  {path: '', component: TesthComponent},
  {path: 'testh', component: TesthComponent},
  {path: 'events', component: EventsComponent},
  {path: 'offers', component: OffersComponent},
  {path: 'office', component: OfficeComponent},
  {path: 'tmap', component: TestLeafletMapComponent},
];
