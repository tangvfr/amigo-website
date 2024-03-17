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

  public abstract toParams(): HttpParams;

  /**
   * @return boolean return true si le formulaire a un parametre de recherche
   */
  public hasCritera(): boolean
  {
    return this.searchText.length !== 0;
  }

}
