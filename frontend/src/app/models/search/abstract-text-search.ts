import {HttpParams} from "@angular/common/http";
import {AFTER, BEFORE, SearchHttpParams} from "./search-http-params";

export abstract class AbstractSearch {

constructor(
  public onlyMiagist?: boolean,
  public searchText: string[] = [],//a revoir car que sur un seul truc 'name'
  public beginAfter?: Date,
  public endBefore?: Date,
) {};

set searching(value: string)
{
  this.searchText = value.split(' ');
}

get searching(): string
{
  return this.searchText.join(' ');
}

toParams(): HttpParams
{
  const params = new SearchHttpParams();
  //definition de critère de recherche
  params.setBoolParam('onlyMiagist', this.onlyMiagist);
  params.setSearchStringParam('name', this.searchText);
  params.setDateParam('bgedDate.beginDate', AFTER, this.beginAfter);
  params.setDateParam('bgedDate.endDate', BEFORE, this.endBefore);

  console.log(params)
  //retour de l'objet
  return params;
}
