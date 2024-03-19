import {HttpParams} from "@angular/common/http";
import {setSearchStringParam} from "./search-http-params";

export abstract class AbstractTextSearch {

  public searchText: string[] = [];

  public set searching(value: string | undefined)
  {
    this.searchText = value ? value.split(' ') : [];
  }

  public get searching(): string
  {
    return this.searchText.join(' ');
  }

  public applySearchingParam(params: HttpParams, property: string): HttpParams
  {
    return setSearchStringParam(params, property, this.searchText);
  }

  public createHttpParams(): HttpParams
  {
    return new HttpParams({encoder: {
      encodeKey(key: string): string {return key},
      encodeValue(value: string): string {return encodeURI(value)},
      decodeKey(key: string): string {return key},
      decodeValue(value: string): string {return decodeURI(value)},
    }});
  }

  public abstract toParams(): HttpParams;

  /**
   * @return boolean return true si le formulaire a un parametre de recherche
   */
  public hasCritera(): boolean
  {
    return this.searchText.length !== 0;
  }

  public resetCritera(): void
  {
    this.searchText = [];
  }

}
