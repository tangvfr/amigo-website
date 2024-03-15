import {Injectable} from '@angular/core';
import {catchError, map, Observable, throwError} from "rxjs";
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {components} from "../models/schema.api";
import {HydraList} from "../models/hydra-list";
import {environment} from "../../environments/environment";
import {Office} from "../models/office/office";

@Injectable({
  providedIn: 'root'
})
export class ErreurService {

  private erreurs WeakSet

  constructor() {
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

}
