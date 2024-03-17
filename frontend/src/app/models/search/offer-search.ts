import {HttpParams} from "@angular/common/http";
import {AFTER, BEFORE, setDateParam, setBoolParam, setSearchStringParam} from "./search-http-params";
import {AbstractTextSearch} from "./abstract-text-search";

export class EventSearch extends AbstractTextSearch {

  public onlyMiagist?: boolean;
  public beginAfter?: Date;
  public endBefore?: Date;

  /*override*/
  public toParams(): HttpParams
  {
    let params = new HttpParams();//attention HttpParams c'est immutable donc à chaque action ça crée un nouvel object
    //definition de critère de recherche
    params = setSearchStringParam(params, 'name', this.searchText);
    params = setDateParam(params, 'bgedDate.beginDate', AFTER, this.beginAfter);
    params = setDateParam(params, 'bgedDate.endDate', BEFORE, this.endBefore);
    console.log(params);
    //retour les parametre
    return params;
  }

}

//a revoir car que sur un seul truc 'name'
//onlyMiagist
//'name', 'types.label', 'situated.label' ,
//?bgedDate.beginDate[after]=2024-03-11&bgedDate.endDate[before]=2024-03-20
