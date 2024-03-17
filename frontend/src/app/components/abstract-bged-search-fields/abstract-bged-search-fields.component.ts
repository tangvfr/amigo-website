import {Component, EventEmitter, Output} from '@angular/core';
import {DialogMessage, MessageService} from "../../services/message.service";
import {AbstractBgedDateWithTextSearch} from "../../models/search/abstract-bged-date-with-text-search";

const VALUE_FIELD_ERR: DialogMessage = {
  title: 'Erreur de saisie',
  body: 'Veilliez a respecter le format des champs.',
};

@Component({template: ''})
export abstract class AbstractBgedSearchFieldsComponent<T extends AbstractBgedDateWithTextSearch> {

  public searchData = this.newSearchData();

  @Output() search = new EventEmitter<T>();

  protected abstract newSearchData(): T;

  protected constructor(
    private readonly messageService: MessageService,
  ) {}

  onSumbit(): void
  {
    if (this.searchData.beginAfter === null || this.searchData.endBefore === null) {
      this.messageService.appendMessage(VALUE_FIELD_ERR);
    } else {
      this.search.emit(this.searchData);
    }
  }

  onReset() {
    this.searchData.searching = undefined;
    this.searchData.beginAfter = undefined;
    this.searchData.endBefore = undefined;
  }

}
