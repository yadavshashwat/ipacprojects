import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ApDistrictComponent } from './ap-district.component';

describe('ApDistrictComponent', () => {
  let component: ApDistrictComponent;
  let fixture: ComponentFixture<ApDistrictComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ApDistrictComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ApDistrictComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
