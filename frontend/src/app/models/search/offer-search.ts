import {HttpParams} from "@angular/common/http";
import {AFTER, BEFORE, setDateParam, setBoolParam, setSearchStringParam} from "./search-http-params";
import {AbstractTextSearch} from "./abstract-text-search";
import {AbstractBgedDateWithTextSearch} from "./abstract-bged-date-with-text-search";

export class OfferSearch extends AbstractBgedDateWithTextSearch {

  /*override*/
  override toParams(): HttpParams
  {
    let params = new HttpParams();//attention HttpParams c'est immutable donc à chaque action ça crée un nouvel object
    //definition de critère de recherche
    params = this.applySearchingParam(params, 'keyWords');
    params = this.applyDateParams(params);

    //retour les parametre
    return params;
  }

}
