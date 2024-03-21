import {Component, OnInit} from '@angular/core';
import {NgFor, NgIf, NgOptimizedImage} from "@angular/common";
import {AmigowsApiService} from "../../../services/amigows.api.service";
import {EMPTY_HYDRA_LIST, HydraList} from "../../../models/hydra-list";
import {components} from "../../../models/schema.api";
import {EventSearchFieldsComponent} from "../event-search-fields/event-search-fields.component";
import {OfferSearch} from "../../../models/search/offer-search";
import {EventSearch} from "../../../models/search/event-search";
import {MatProgressSpinner} from "@angular/material/progress-spinner";
import {Observable} from "rxjs";
import {MatButton} from "@angular/material/button";
import {environment} from "../../../../environments/environment";

export const enum Stat {
  LOADING,
  PARTIAL,
  NORMAL,
  SEARCH,
}

@Component({
  selector: 'app-events',
  standalone: true,
  imports: [NgFor, EventSearchFieldsComponent, NgIf, MatProgressSpinner, NgOptimizedImage, MatButton],
  templateUrl: './events.component.html',
  styleUrl: './events.component.css'
})
export class EventsComponent implements OnInit {

  events?: HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>;
  pastEvents?: HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>;
  stat: Stat = Stat.LOADING;
  selectedEvent: components["schemas"]["Event.jsonld-detailEvent"] | undefined; // ou utilisez un type plus spécifique si possible

  constructor(private amigowsApiService: AmigowsApiService
  ) {}

  showEventDetails(event: components["schemas"]["Event.jsonld-minimalEvent"]) {
    let eventid: number = event.id;
    this.amigowsApiService.getEvent(eventid).subscribe((eventDetail: components["schemas"]["Event.jsonld-detailEvent"]) => {
      this.selectedEvent = eventDetail;
    });
  }


  beNormal(): boolean
  {
    return this.stat === Stat.NORMAL;
  }

  beSearch(): boolean
  {
    return this.stat === Stat.SEARCH;
  }

  beLoading(): boolean
  {
    return this.stat === Stat.LOADING
      || this.stat === Stat.PARTIAL;
  }

  /*old
  ngOnInit(): void
  {
    this.amigowsApiService.getNowEvents().subscribe(
      data => this.nowEvents = data
    );
  }*/

  ngOnInit(): void
  {
    //this.search(undefined);
    //equivalent
    this.search();
  }

  search(search?: EventSearch): void
  {
    this.resetStat();
    if (search !== undefined && search.hasCritera()) {
      this.searchCustom(search);
    } else {
      this.searchSimple();
    }
  }

  private resetStat(): void
  {
    this.events = undefined;
    this.pastEvents = undefined
    this.stat = Stat.LOADING;
  }

  private searchCustom(search: EventSearch): void
  {
    this.amigowsApiService.getEvents(search)//récupère la requet pret a etre executé
      .subscribe({//executé la requet
        //stock le resultat de la requet dans une varible
        next: data => {
          this.events = data;
          this.stat = Stat.SEARCH;
        },
        //en cas d'erreur
        error: () => this.amigowsApiService.showErrorApiError()
      });
  }

  private searchSimple(): void
  {
    this.amigowsApiService.getNowEvents().subscribe({
      next: data => {
        this.events = data;
        this.updateNormalStat();
      },
      error: () => this.amigowsApiService.showErrorApiError()
    });
    this.amigowsApiService.getPastEvents().subscribe({
      next: data => {
        this.pastEvents = data;
        this.updateNormalStat();
      },
      error: () => this.amigowsApiService.showErrorApiError()
    });
  }

  private updateNormalStat(): void
  {
    this.stat = this.stat === Stat.PARTIAL ? Stat.NORMAL : Stat.PARTIAL;
  }

    protected readonly environment = environment;
}
