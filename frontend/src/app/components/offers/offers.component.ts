import {Component, OnInit} from '@angular/core';
import {EMPTY_HYDRA_LIST, HydraList} from "../../models/hydra-list";
import {components} from "../../models/schema.api";
import {AmigowsApiService} from "../../services/amigows.api.service";
import {NgFor} from "@angular/common";
import {MarkdownComponent} from "ngx-markdown";

//https://blog.markdowntools.com/posts/how-to-render-markdown-in-angular

@Component({
  selector: 'app-offers',
  standalone: true,
  imports: [NgFor, MarkdownComponent],
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

    /*
    message qui sont en dialog message
    this.messageService.appendMessage({
      title: 'a ttile',
      body: 'corp 1'
    });
    this.messageService.appendMessage({
      title: 'to ttile',
      body: 'corp 2'
    });
    this.messageService.appendMessage({
      title: '3 ttile',
      body: 'corp 3'
    });*/
  }

}
