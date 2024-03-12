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
   * Permet de génrer les erreur avec l'api
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

  getPastEvents()
  {
    return this.http.get<HydraList<components["schemas"]["Event.jsonld-minimalEvent"]>>
    (`${this.baseApiUrl}/events/past`)
      .pipe(catchError(this.handleError));
  }

  getOffers()
  {
    return this.http.get<HydraList<components["schemas"]["Offer.jsonld-listOffer"]>>
    (`${this.baseApiUrl}/offers`)
      .pipe(catchError(this.handleError));
  }

  getChallengerPartner()
  {
    return this.http.get<HydraList<components["schemas"]["Partner.jsonld-challengerCompany"]>>
    (`${this.baseApiUrl}/parther/challenger`)
      .pipe(catchError(this.handleError));
  }

  getDiscountPartner()
  {
    return this.http.get<HydraList<components["schemas"]["Partner.jsonld-discountCompany"]>>
    (`${this.baseApiUrl}/parther/discount`)
      .pipe(catchError(this.handleError));
  }

  getCompany(id: number)
  {
    return this.http.get<HydraList<components["schemas"]["Company.jsonld-infoCompany"]>>
    (`${this.baseApiUrl}/companies/${id}`)
      .pipe(catchError(this.handleError));
  }

  getEventType(id: number)
  {
    return this.http.get<HydraList<components["schemas"]["EventType.jsonld-detailEventType"]>>
    (`${this.baseApiUrl}/event_types/${id}`)
      .pipe(catchError(this.handleError));
  }

  /*getLocations(id: number)
  {
    return this.http.get<HydraList<components["schemas"]["Location.jsonld"]>>
    (`${this.baseApiUrl}/locations/${id}`)
      .pipe(catchError(this.handleError));
  }*/

}
