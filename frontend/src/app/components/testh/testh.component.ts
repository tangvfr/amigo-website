import { Component } from '@angular/core';
import {RouterLink} from "@angular/router";
import {NgForOf} from "@angular/common";
import {PosterComponent} from "../poster/poster.component";

@Component({
  selector: 'app-testh',
  standalone: true,
  imports: [RouterLink, NgForOf, PosterComponent],
  templateUrl: './testh.component.html',
  styleUrl: './testh.component.css'
})
export class TesthComponent {

  testList: Array<string> = ['salut', 'bg', 'tu es super beau'];

}
