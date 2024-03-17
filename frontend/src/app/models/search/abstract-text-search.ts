import {HttpParams} from "@angular/common/http";

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

  public abstract toParams(): HttpParams;

}
