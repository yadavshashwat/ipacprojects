import { TestBed, inject } from '@angular/core/testing';

import { NewsCategoryService } from './news-category.service';

describe('NewsCategoryService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [NewsCategoryService]
    });
  });

  it('should be created', inject([NewsCategoryService], (service: NewsCategoryService) => {
    expect(service).toBeTruthy();
  }));
});
