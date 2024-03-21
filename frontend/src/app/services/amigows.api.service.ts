import {Injectable} from '@angular/core';
import {catchError, map, Observable, throwError} from "rxjs";
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {components} from "../models/schema.api";
import {HydraList} from "../models/hydra-list";
import {environment} from "../../environments/environment";
import {Office} from "../models/office/office";
import {DialogMessage, MessageService} from "./message.service";
import {EventSearch} from "../models/search/event-search";
import {OfferSearch} from "../models/search/offer-search";
import {AbstractTextSearch} from "../models/search/abstract-text-search";

export const API_ERROR_TITLE: string = 'Erreur API';
export const API_ERROR_MSG: string = 'Une erreur est survenue lors de la communication avec le serveur ! Ressayer plus tard !';
export const API_ERROR: Error = new Error(API_ERROR_MSG);
export const DIAGLOG_API_ERROR_MSG: DialogMessage = {title: API_ERROR_TITLE, body: API_ERROR_MSG}

@Injectable({
  providedIn: 'root'
})
export class AmigowsApiService {

  private readonly baseApiUrl: string;

  constructor(
    private http: HttpClient,
    private messageService: MessageService,
  ) {
    this.baseApiUrl = environment.apiURL;
  }

  public showErrorApiError(): void
  {
    //erreur afficher a l'utilisateur
    this.messageService.appendMessage(DIAGLOG_API_ERROR_MSG);
  }

  /**
   * Permet de gérer les erreurs avec l'api
   * @param error l'erreur
   * @private
   */
  private handleError(error: HttpErrorResponse)
  {
    //erreur detaillé dans la console
    if (error.status === 0) {
      console.error('An error occurred:', error.error);
    } else {
      console.error(`Backend returned code ${error.status}, body was: `, error.error);
    }

    //retorune une erreur
    return throwError(() => API_ERROR);
  }

  getOffice(): Observable<Office>
  {
    return this.http.get<HydraList<components["schemas"]["Mandate.jsonld-office"]>>(
      `${this.baseApiUrl}/office`
    ).pipe(catchError(this.handleError), map(office => new Office(office)));
  }

  getNowEvents(search?: EventSearch): Observable<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
  {
    return this.getEvents(search, '/now');
  }

  getPastEvents(search?: EventSearch): Observable<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
  {
    return this.getEvents(search, '/past');
  }

  getEvents(search?: EventSearch, specified: string = ''): Observable<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
  {
    type list = HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>;
    const url = `${this.baseApiUrl}/events${specified}`;
    return this.getAPISearch<list>(url, search);
  }

  getOffers(search?: OfferSearch): Observable<HydraList<components["schemas"]["Offer.jsonld-listOffer"]>>
  {
    type list = HydraList<components["schemas"]["Offer.jsonld-listOffer"]>;
    const url = `${this.baseApiUrl}/offers`;
    return this.getAPISearch<list>(url, search);
  }

  getAPISearch<T>(url: string, search?: AbstractTextSearch): Observable<T>
  {
    let get;
    if (search === undefined || !search.hasCritera()) {
      get = this.http.get<T>(url);
    } else {
      get = this.http.get<T>(url, {params: search.toParams()});
    }

    return get.pipe(catchError(this.handleError));
  }

  getChallengerPartner(): Observable<HydraList<components["schemas"]["Partner.jsonld-challengerCompany"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Partner.jsonld-challengerCompany"]>>
    (`${this.baseApiUrl}/partner/challenger`)
      .pipe(catchError(this.handleError));
  }

  getDiscountPartner(): Observable<HydraList<components["schemas"]["Partner.jsonld-discountCompany"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Partner.jsonld-discountCompany"]>>
    (`${this.baseApiUrl}/partner/discount`)
      .pipe(catchError(this.handleError));
  }

  getCompany(id: bigint): Observable<components["schemas"]["Company.jsonld-infoCompany"]>
  {
    return this.http.get<components["schemas"]["Company.jsonld-infoCompany"]>
    (`${this.baseApiUrl}/companies/${id}`)
      .pipe(catchError(this.handleError));
  }

  getEvent(id: bigint): Observable<components["schemas"]["Event.jsonld-detailEvent"]>
  {
    return this.http.get<components["schemas"]["Event.jsonld-detailEvent"]>
    (`${this.baseApiUrl}/events/${id}`)
      .pipe(catchError(this.handleError));
  }

  getEventType(id: bigint): Observable<components["schemas"]["EventType.jsonld-detailEventType"]>
  {
    return this.http.get<components["schemas"]["EventType.jsonld-detailEventType"]>
    (`${this.baseApiUrl}/event_types/${id}`)
      .pipe(catchError(this.handleError));
  }

  getLocations(id: bigint): Observable<components["schemas"]["Location.jsonld"]>
  {
    return this.http.get<components["schemas"]["Location.jsonld"]>
    (`${this.baseApiUrl}/locations/${id}`)
      .pipe(catchError(this.handleError));
  }

}
