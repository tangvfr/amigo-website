import { Component } from '@angular/core';
import {RouterLink} from "@angular/router";
import {NgForOf} from "@angular/common";
import {PosterComponent} from "../poster/poster.component";
import {AmigowsApiService} from "../../services/amigows.api.service";
import {MatSlideToggle, MatSlideToggleModule} from "@angular/material/slide-toggle";
import {MatFabAnchor} from "@angular/material/button";
import {MatIcon} from "@angular/material/icon";

@Component({
  selector: 'app-testh',
  standalone: true,
  imports: [RouterLink, NgForOf, PosterComponent, MatIcon, MatFabAnchor],
  templateUrl: './testh.component.html',
  styleUrl: './testh.component.css'
})
export class TesthComponent {

  testList: Array<string> = ['salut', 'bg', 'tu es super beau'];

}
