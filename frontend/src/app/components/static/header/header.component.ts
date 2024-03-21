import { Component } from '@angular/core';
import {NgForOf, NgOptimizedImage} from "@angular/common";
import {RouterLink, RouterModule} from "@angular/router";
import {PosterComponent} from "../../poster/poster.component";
import {MatIcon} from "@angular/material/icon";
import {MatButton, MatFabAnchor} from "@angular/material/button";

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [
    NgOptimizedImage,
    RouterLink,
    RouterModule,

  ],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {

}
