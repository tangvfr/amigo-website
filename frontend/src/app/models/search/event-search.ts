import {HttpParams} from "@angular/common/http";
import {AFTER, BEFORE, setBoolParam, setDateParam, setSearchStringParam} from "./search-http-params";
import {AbstractBgedDateWithTextSearch} from "./abstract-bged-date-with-text-search";

export class EventSearch extends AbstractBgedDateWithTextSearch {

  public onlyMiagist?: boolean;

  /*override*/
  override toParams(): HttpParams
  {
    let params = this.createHttpParams();//attention HttpParams c'est immutable donc à chaque action ça crée un nouvel object
    //definition de critère de recherche
    params = setBoolParam(params, 'onlyMiagist', this.onlyMiagist);
    params = this.applySearchingParam(params, 'name');
    params = this.applyDateParams(params);

    //retour les parametre
    return params;
  }

  override hasCritera(): boolean {
    return super.hasCritera()
      || this.onlyMiagist !== undefined;
  }

  override resetCritera() {
    super.resetCritera();
    this.onlyMiagist = true;
  }

}

//a revoir car que sur un seul truc 'name'
//onlyMiagist
//'name', 'types.label', 'situated.label' ,
//?bgedDate.beginDate[after]=2024-03-11&bgedDate.endDate[before]=2024-03-20
