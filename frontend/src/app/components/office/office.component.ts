import {Component, OnInit} from '@angular/core';
import {AmigowsApiService} from "../../services/amigows.api.service";
import {Office} from "../../models/office/office";
import {MatProgressSpinner} from "@angular/material/progress-spinner";
import {NgForOf, NgIf} from "@angular/common";
import {RouterLink} from "@angular/router";
import {MatAnchor} from "@angular/material/button";
import {delay} from "rxjs";
import {MatCardModule} from "@angular/material/card";
import {MatIcon} from "@angular/material/icon";
import {MatProgressBar} from "@angular/material/progress-bar";
import {MatDivider} from "@angular/material/divider";
import {MatChip} from "@angular/material/chips";
import {CdkListbox} from "@angular/cdk/listbox";

@Component({
  selector: 'app-office',
  standalone: true,
  imports: [
    MatProgressSpinner,
    NgIf,
    RouterLink,
    MatAnchor,
    MatCardModule,
    MatIcon,
    MatProgressBar,
    MatDivider,
    MatChip,
    NgForOf,
    CdkListbox,
  ],
  templateUrl: './office.component.html',
  styleUrl: './office.component.css'
})
export class OfficeComponent implements OnInit {

  office?: Office;
  ready: boolean;

  constructor(
    private amigowsApiService: AmigowsApiService
  ) {
    this.ready = false;
  }

  ngOnInit() {
    this.amigowsApiService.getOffice()
      .pipe(delay(2000))//cette ligne met un temps de réponse artificiellement plus long
      .subscribe({//executé la requête
        next: office => {
          //pour tester, attente artificielle
          this.office = office;
          this.ready = true;
        },
        //en cas d'erreur
        error: () => this.amigowsApiService.showErrorApiError()
      });
  }

}
