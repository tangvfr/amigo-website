import {HttpParams} from "@angular/common/http";

export class EventSearch {
  constructor(
    public onlyMiagist?: boolean,
    public searchText?: string[] | undefined,//a revoir car que sur un seul truc 'name'
    public beginAfter?: Date,
    public endBefore?: Date,
  ) {};

  toParams(): HttpParams
  {
    const params = new HttpParams();

    if () {

    }

    return params;
  }
}

//onlyMiagist
//'name', 'types.label', 'situated.label' ,
//?bgedDate.beginDate[after]=2024-03-11&bgedDate.endDate[before]=2024-03-20
