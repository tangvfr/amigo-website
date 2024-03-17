import {Component, OnInit} from '@angular/core';
import {EMPTY_HYDRA_LIST, HydraList} from "../../models/hydra-list";
import {components} from "../../models/schema.api";
import {AmigowsApiService} from "../../services/amigows.api.service";
import {NgFor} from "@angular/common";
import {MarkdownComponent} from "ngx-markdown";
import {OfferSearchFieldsComponent} from "../offer-search-fields/offer-search-fields.component";
import {OfferSearch} from "../../models/search/offer-search";

//https://blog.markdowntools.com/posts/how-to-render-markdown-in-angular

@Component({
  selector: 'app-offers',
  standalone: true,
  imports: [NgFor, MarkdownComponent, OfferSearchFieldsComponent],
  templateUrl: './offers.component.html',
  //styleUrl: './offers.component.css'
})
export class OffersComponent implements OnInit {

  offers: HydraList<components["schemas"]["Offer.jsonld-listOffer"]> = EMPTY_HYDRA_LIST;

  constructor(private amigowsApiService: AmigowsApiService,
              //private messageService: MessageService
  ) {}

  ngOnInit(): void
  {
    this.amigowsApiService.getOffers()//récupère la requet pret a etre executé
      .subscribe({//executé la requet
        //stock le resultat de la requet dans une varible
        next: data => this.offers = data,
        //en cas d'erreur
        error: () => this.amigowsApiService.showErrorApiError()
      });
  }

  search(search: OfferSearch): void
  {
    /*this.amigowsApiService.getOffers(search)//récupère la requet pret a etre executé
      .subscribe({//executé la requet
        //stock le resultat de la requet dans une varible
        next: data => console.log(data),
        //en cas d'erreur
        error: () => this.amigowsApiService.showErrorApiError()
      });*/
  }

}
