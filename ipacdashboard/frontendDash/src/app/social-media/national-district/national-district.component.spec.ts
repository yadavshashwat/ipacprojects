import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NationalDistrictComponent } from './national-district.component';

describe('NationalDistrictComponent', () => {
  let component: NationalDistrictComponent;
  let fixture: ComponentFixture<NationalDistrictComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NationalDistrictComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NationalDistrictComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
