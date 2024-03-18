import {AbstractTextSearch} from "./abstract-text-search";
import {HttpParams} from "@angular/common/http";
import {AFTER, BEFORE, setDateParam} from "./search-http-params";

export abstract class AbstractBgedDateWithTextSearch extends AbstractTextSearch {

  public beginAfter?: Date;
  public endBefore?: Date;

  public applyDateParams(params: HttpParams): HttpParams
  {
    params = setDateParam(params, 'bgedDate.beginDate', AFTER, this.beginAfter);
    params = setDateParam(params, 'bgedDate.endDate', BEFORE, this.endBefore);
    return params;
  }

  override hasCritera(): boolean {
    return super.hasCritera()
      || this.beginAfter !== undefined
      || this.endBefore !== undefined;
  }

  override resetCritera() {
    super.resetCritera();
    this.beginAfter = undefined;
    this.endBefore = undefined;
  }

}
