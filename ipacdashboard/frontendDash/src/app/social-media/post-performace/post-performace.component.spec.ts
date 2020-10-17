import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PostPerformaceComponent } from './post-performace.component';

describe('PostPerformaceComponent', () => {
  let component: PostPerformaceComponent;
  let fixture: ComponentFixture<PostPerformaceComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PostPerformaceComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PostPerformaceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
