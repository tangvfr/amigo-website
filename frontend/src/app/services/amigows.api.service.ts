import {Injectable} from '@angular/core';
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {components} from "../models/schema.api";
import {HydraList} from "../models/hydra-list";
type MinimalEvent = components["schemas"]["Event.jsonld-minimalEvent"];

@Injectable({
  providedIn: 'root'
})
export class AmigowsApiService {

  private apiBaseUrl: string = 'http://localhost:8000/api/';

  constructor(private http: HttpClient) {}

  getNowEvents(): Observable<HydraList<MinimalEvent>>
  {
    return this.http.get<HydraList<MinimalEvent>>(`${this.apiBaseUrl}events/now`);
  }

}
