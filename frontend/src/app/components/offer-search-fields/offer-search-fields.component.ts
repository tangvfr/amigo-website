import {Component, EventEmitter, Output} from '@angular/core';
import {EventSearch} from "../../models/search/event-search";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatOption, MatSelect} from "@angular/material/select";
import {MatIcon} from "@angular/material/icon";
import {MatInput} from "@angular/material/input";
import {FormsModule} from "@angular/forms";
import {MatButton, MatFabButton, MatMiniFabButton} from "@angular/material/button";
import {MatDatepickerModule} from "@angular/material/datepicker";
import {provideLuxonDateAdapter} from "@angular/material-luxon-adapter";
import {MAT_DATE_LOCALE} from "@angular/material/core";
import {DialogMessage, MessageService} from "../../services/message.service";

const VALUE_FIELD_ERR: DialogMessage = {
  title: 'Erreur de saisie',
  body: 'Veilliez a respecter le format des champs.',
};

@Component({
  selector: 'app-offer-search-fields',
  standalone: true,
  imports: [MatFormFieldModule, MatSelect, MatOption, MatIcon, MatInput, FormsModule, MatButton, MatDatepickerModule, MatFabButton, MatMiniFabButton],
  providers: [
    {provide: MAT_DATE_LOCALE, useValue: 'fr-FR'},
    provideLuxonDateAdapter(),
  ],
  templateUrl: './offer-search-fields.component.html',
  styleUrl: './offer-search-fields.component.css'
})
export class OfferSearchFieldsComponent {

  public eventSearch = new EventSearch();

  @Output() search = new EventEmitter<EventSearch>();

  constructor(
    private readonly messageService: MessageService,
  ) {}

  onSumbit(): void
  {
    if (this.eventSearch.beginAfter === null || this.eventSearch.endBefore === null) {
      this.messageService.appendMessage(VALUE_FIELD_ERR);
    } else {
      this.search.emit(this.eventSearch);
    }
  }

  onReset() {
    this.eventSearch.searching = undefined;
    this.eventSearch.onlyMiagist = undefined;
    this.eventSearch.beginAfter = undefined;
    this.eventSearch.endBefore = undefined;
  }

  protected readonly console = console;
}
