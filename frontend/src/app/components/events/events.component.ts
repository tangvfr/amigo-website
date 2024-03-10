import {Component, OnInit} from '@angular/core';
import {NgFor} from "@angular/common";
import {AmigowsApiService} from "../../services/amigows.api.service";
import {EMPTY_HYDRA_LIST, HydraList} from "../../models/hydra-list";
import {components} from "../../models/schema.api";
type MinimalEvent = components["schemas"]["Event.jsonld-minimalEvent"];

@Component({
  selector: 'app-events',
  standalone: true,
  imports: [NgFor],
  templateUrl: './events.component.html',
  styleUrl: './events.component.css'
})
export class EventsComponent implements OnInit {

  nowEvents: HydraList<MinimalEvent> = EMPTY_HYDRA_LIST;//components['schemas']['Event.jsonld-minimalEvent'][] | undefined;

  constructor(private amigowsApiService: AmigowsApiService) {}

  ngOnInit(): void
  {
    this.amigowsApiService.getNowEvents().subscribe(
      data => this.nowEvents = data
    );
  }

}
