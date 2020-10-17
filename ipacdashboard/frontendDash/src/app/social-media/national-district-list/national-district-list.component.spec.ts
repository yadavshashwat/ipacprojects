import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NationalDistrictListComponent } from './national-district-list.component';

describe('NationalDistrictListComponent', () => {
  let component: NationalDistrictListComponent;
  let fixture: ComponentFixture<NationalDistrictListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NationalDistrictListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NationalDistrictListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
