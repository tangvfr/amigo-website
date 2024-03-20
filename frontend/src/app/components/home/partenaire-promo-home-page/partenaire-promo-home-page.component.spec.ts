import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartenairePromoHomePageComponent } from './partenaire-promo-home-page.component';

describe('PartenairePromoHomePageComponent', () => {
  let component: PartenairePromoHomePageComponent;
  let fixture: ComponentFixture<PartenairePromoHomePageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PartenairePromoHomePageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(PartenairePromoHomePageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
