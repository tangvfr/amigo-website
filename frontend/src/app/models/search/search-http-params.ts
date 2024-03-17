import {HttpParams} from "@angular/common/http";

export const STRICTLY_AFTER: string = 'strictly_after';
export const AFTER: string = 'after';
export const STRICTLY_BEFORE: string = 'strictly_before';
export const BEFORE: string = 'before';

export function setBoolParam(params: HttpParams, property: string, value?: boolean): HttpParams
{
  if (value === undefined) return params;
  return params.set(property, value);
}

export function setSearchStringParam(params: HttpParams, property: string, words: string[]): HttpParams
{
  if (words.length < 1) return params;
  //pour chaque mot
  let par = params;
  for (let word of words) {
    par = par.append(property, word);
  }
  return par;
}

export function  setDateParam(params: HttpParams, property: string, dateCondition: string, date?: Date): HttpParams
{
  if (date === undefined) return params;
  return params.set(property+`[${dateCondition}]`, date.toJSON());
}
