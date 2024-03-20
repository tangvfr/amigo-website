import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GalerieEventPageComponent } from './galerie-event-page.component';

describe('GalerieEventPageComponent', () => {
  let component: GalerieEventPageComponent;
  let fixture: ComponentFixture<GalerieEventPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [GalerieEventPageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(GalerieEventPageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
