import {Component, OnInit} from '@angular/core';
import {NgFor} from "@angular/common";
import {AmigowsApiService} from "../../services/amigows.api.service";
import {EMPTY_HYDRA_LIST, HydraList} from "../../models/hydra-list";
import {components} from "../../models/schema.api";

@Component({
  selector: 'app-events',
  standalone: true,
  imports: [NgFor],
  templateUrl: './events.component.html',
  styleUrl: './events.component.css'
})
export class EventsComponent implements OnInit {

  nowEvents: HydraList<components["schemas"]["Event.jsonld-minimalEvent"]> = EMPTY_HYDRA_LIST;

  constructor(private amigowsApiService: AmigowsApiService) {}

  ngOnInit(): void
  {
    this.amigowsApiService.getNowEvents().subscribe(
      data => this.nowEvents = data
    );
  }

}
