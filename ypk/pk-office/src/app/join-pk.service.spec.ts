import { TestBed, inject } from '@angular/core/testing';

import { JoinPkService } from './join-pk.service';

describe('JoinPkService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [JoinPkService]
    });
  });

  it('should be created', inject([JoinPkService], (service: JoinPkService) => {
    expect(service).toBeTruthy();
  }));
});
