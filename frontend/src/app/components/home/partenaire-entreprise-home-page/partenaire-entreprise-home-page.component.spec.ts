import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartenaireEntrepriseHomePageComponent } from './partenaire-entreprise-home-page.component';

describe('PartenaireEntrepriseHomePageComponent', () => {
  let component: PartenaireEntrepriseHomePageComponent;
  let fixture: ComponentFixture<PartenaireEntrepriseHomePageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PartenaireEntrepriseHomePageComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(PartenaireEntrepriseHomePageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
