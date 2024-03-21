import {Component, OnInit} from '@angular/core';
import {NgFor} from '@angular/common';
import {components} from "../../../models/schema.api";
import {AmigowsApiService} from "../../../services/amigows.api.service";
import {EMPTY_HYDRA_LIST, HydraList} from "../../../models/hydra-list";
import {PosterComponent} from "../../poster/poster.component";


@Component({
  selector: 'app-galerie-event-page',
  standalone: true,
  imports: [NgFor, PosterComponent],
  templateUrl: './galerie-event-page.component.html',
  styleUrl: './galerie-event-page.component.css'
})
export class GalerieEventPageComponent implements OnInit {

  nowEvents: HydraList<components["schemas"]["Event.jsonld-minimalEvent"]> = EMPTY_HYDRA_LIST;

  constructor(private amigowsApiService: AmigowsApiService) {}

  ngOnInit(): void
  {
    this.amigowsApiService.getNowEvents().subscribe(
      data => this.nowEvents = data
    );



  }


}
