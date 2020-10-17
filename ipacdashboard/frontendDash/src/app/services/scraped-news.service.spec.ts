import { TestBed, inject } from '@angular/core/testing';

import { ScrapedNewsService } from './scraped-news.service';

describe('ScrapedNewsService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ScrapedNewsService]
    });
  });

  it('should be created', inject([ScrapedNewsService], (service: ScrapedNewsService) => {
    expect(service).toBeTruthy();
  }));
});
