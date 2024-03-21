import {Component} from '@angular/core';
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatOption, MatSelect} from "@angular/material/select";
import {MatIcon} from "@angular/material/icon";
import {MatInput} from "@angular/material/input";
import {FormsModule} from "@angular/forms";
import {MatButton, MatFabButton, MatMiniFabButton} from "@angular/material/button";
import {MatDatepickerModule} from "@angular/material/datepicker";
import {provideLuxonDateAdapter} from "@angular/material-luxon-adapter";
import {MAT_DATE_LOCALE} from "@angular/material/core";
import {
  AbstractBgedSearchFieldsComponent
} from "../../abstract-bged-search-fields/abstract-bged-search-fields.component";
import {EventSearch} from "../../../models/search/event-search";
import {MessageService} from "../../../services/message.service";

@Component({
  selector: 'app-event-search-fields',
  standalone: true,
  imports: [MatFormFieldModule, MatSelect, MatOption, MatIcon, MatInput, FormsModule, MatButton, MatDatepickerModule, MatFabButton, MatMiniFabButton],
  providers: [
    {provide: MAT_DATE_LOCALE, useValue: 'fr-FR'},
    provideLuxonDateAdapter(),
  ],
  templateUrl: './event-search-fields.component.html',
  styleUrl: './event-search-fields.component.css'
})
export class EventSearchFieldsComponent extends AbstractBgedSearchFieldsComponent<EventSearch>{

  constructor(messageService: MessageService) {
    super(messageService);
  }

  protected newSearchData(): EventSearch {
    return new EventSearch();
  }

}
