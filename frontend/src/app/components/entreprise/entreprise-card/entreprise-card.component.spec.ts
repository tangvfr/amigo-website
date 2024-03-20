import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EntrepriseCardComponent } from './entreprise-card.component';

describe('EntrepriseCardComponent', () => {
  let component: EntrepriseCardComponent;
  let fixture: ComponentFixture<EntrepriseCardComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EntrepriseCardComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(EntrepriseCardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
