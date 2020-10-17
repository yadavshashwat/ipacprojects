import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ApDistrictListComponent } from './ap-district-list.component';

describe('ApDistrictListComponent', () => {
  let component: ApDistrictListComponent;
  let fixture: ComponentFixture<ApDistrictListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ApDistrictListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ApDistrictListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
