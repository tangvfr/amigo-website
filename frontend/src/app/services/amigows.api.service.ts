import {Injectable} from '@angular/core';
import {catchError, Observable, throwError} from "rxjs";
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {components} from "../models/schema.api";
import {HydraList} from "../models/hydra-list";
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class AmigowsApiService {

  private readonly baseApiUrl: string;

  constructor(private http: HttpClient) {
    this.baseApiUrl = environment.apiURL;
  }

  /**
   * Permet de gérer les erreurs avec l'api
   * @param error l'erreur
   * @private
   */
  private handleError(error: HttpErrorResponse)
  {
    if (error.status === 0) {
      console.error('An error occurred:', error.error);
    } else {
      console.error(
        `Backend returned code ${error.status}, body was: `, error.error);
    }
    return throwError(() => new Error('Something bad happened; please try again later.'));
  }

  getNowEvents(): Observable<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
    (`${this.baseApiUrl}/events/now`)
      .pipe(catchError(this.handleError));
  }

  getPastEvents(): Observable<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
    (`${this.baseApiUrl}/events/past`)
      .pipe(catchError(this.handleError));
  }

  getOffers(): Observable<HydraList<components["schemas"]["Offer.jsonld-listOffer"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Offer.jsonld-listOffer"]>>
    (`${this.baseApiUrl}/offers`)
      .pipe(catchError(this.handleError));
  }

  getChallengerPartner(): Observable<HydraList<components["schemas"]["Partner.jsonld-challengerCompany"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Partner.jsonld-challengerCompany"]>>
    (`${this.baseApiUrl}/parther/challenger`)
      .pipe(catchError(this.handleError));
  }

  getDiscountPartner(): Observable<HydraList<components["schemas"]["Partner.jsonld-discountCompany"]>>
  {
    return this.http.get<HydraList<components["schemas"]["Partner.jsonld-discountCompany"]>>
    (`${this.baseApiUrl}/parther/discount`)
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
