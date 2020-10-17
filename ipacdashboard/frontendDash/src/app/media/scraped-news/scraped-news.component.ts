/**
 * @author victor
 * @description component for displaying scraped news
 */
import {
  Component,
  OnInit,
  Inject,
  OnDestroy
} from '@angular/core';
import { FormControl } from "@angular/forms";
import { ScrapedNewsService } from "../../services/scraped-news.service";
import { PublicationService } from "../../services/publication.service";
import { AuthorService } from "../../services/author.service";
import { MediaScanService } from "../../services/media-scan.service";
import {
  MatDialog,
  MatDialogRef,
  MAT_DIALOG_DATA
} from '@angular/material';
import { MatSnackBar } from '@angular/material';
import { PageEvent } from '@angular/material';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { Logout, LogoutConfirmed } from "../../actions/auth.actions";
import { KeywordService } from "../../services/keyword.service";
import { CategoryService } from "../../services/category.service";
import { StateService } from "../../services/state.service";
import {
  map,
  startWith,
  takeUntil,
  take, filter, debounceTime, distinctUntilChanged
} from 'rxjs/operators';

import {
  ReplaySubject,
  Subject
} from "rxjs";
import { Category } from '../category/category.component';


@Component({
  selector: 'app-scraped-news',
  templateUrl: './scraped-news.component.html',
  styleUrls: ['./scraped-news.component.css']
})
export class ScrapedNewsComponent implements OnInit, OnDestroy {
  user: any;
  scrapedNewsList: any = [];
  scrapedNewsSwitch: string;
  scrapedAccordionSwitch: string;
  color = 'primary';
  mode = 'query';
  panelOpenState = false;
  addMediaScanScrapedBluePrint: any = {};

  // Pagination Variables
  pageNumber: number;
  pageSize: number;
  totalRecords: number;

  languages: any[] = [
    'English', 'Hindi', 'Telugu', 'Tamil', 'Gujarati', 'Marathi', 'Bengali', 'Urdu', 'Punjabi', 'Kannada', 'Malayalam'
  ];
  private _onDestroy = new Subject<void>();
  // language filter control
  public mediaLangMasterCtrl: FormControl = new FormControl();
  public filterMediaLangCtrl: FormControl = new FormControl();
  public filteredMediaLang: ReplaySubject<String[]> = new ReplaySubject<String[]>(1);

  // keyword filter control
  public mediaKeyMasterCtrl: FormControl = new FormControl();
  public filterMediaKeyCtrl: FormControl = new FormControl();
  public filteredMediaKey: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  private _keywords: any;

  // channel filter control
  public mediaChannelMasterCtrl: FormControl = new FormControl();
  public filterMediaChannelCtrl: FormControl = new FormControl();
  public filteredMediaChannel: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  private _channels: any;

  // author filter control
  public mediaAuthorMasterCtrl: FormControl = new FormControl();
  public filterMediaAuthorCtrl: FormControl = new FormControl();
  public filteredMediaAuthor: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  private _authors: any;


  // cat filter control
  public mediaCatMasterCtrl: FormControl = new FormControl();
  public filterMediaCatCtrl: FormControl = new FormControl();
  public filteredMediaCat: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  private _categories: any;

  // cat filter control
  public mediaSegMasterCtrl: FormControl = new FormControl();
  public filterMediaSegCtrl: FormControl = new FormControl();
  public filteredMediaSeg: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  private _segments: any;

  // start filter control
  public mediaStMasterCtrl: FormControl = new FormControl({ value: '', disabled: true });

  // start filter control
  public mediaEtMasterCtrl: FormControl = new FormControl({ value: '', disabled: true });

  // Article
  public mediaArtMasterCtrl: FormControl = new FormControl();
  payload: any = {
    page_num: this.pageNumber,
    page_size: this.pageSize
  };

  onKey(value: string) {
    this.payload.article = value;
    this.fetchScrapedNewsParamsMethod(this.payload);
  }


  constructor(
    private _scraped_news: ScrapedNewsService,
    public dialog: MatDialog,
    public snackBar: MatSnackBar,
    private _mediaScan: MediaScanService,
    private store: Store<fromStore.State>,
    private _key: KeywordService,
    public _channel: PublicationService,
    private _cat: CategoryService,
    private _segment: StateService,
    public _author: AuthorService
  ) {
    this.pageNumber = 1;
    this.pageSize = 10;
    this.payload.page_num = this.pageNumber;
    this.payload.page_size = this.pageSize;
    this.store
      .select(fromStore.selectAuthUser)
      .subscribe((data) => {
        if (data !== null) {
          this.user = data.user;
        }
      });
    // language changes
    this.filteredMediaLang.next(this.languages.slice());
    this.filterMediaLangCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterLanguages();
      });
    this.mediaLangMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.language = data;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });
    // keywords changes
    this.filterMediaKeyCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterKeywords();
      });
    this.mediaKeyMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.keyword_id = data;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });
    // channel changes
    this.filterMediaChannelCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterChannels();
      });
    this.mediaChannelMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.channel_id = data;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });

    // author changes
    this.filterMediaAuthorCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterAuthors();
      });
    this.mediaAuthorMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.author_id = data;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });

    // Cat changes
    this.filterMediaCatCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterCats();
      });
    this.mediaCatMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.category_name = data;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });

    this.mediaArtMasterCtrl.valueChanges
      .pipe(
        takeUntil(this._onDestroy),
        debounceTime(400),
        distinctUntilChanged()
      )
      .subscribe((value) => {
        this.payload.article = value;
        this.fetchScrapedNewsParamsMethod(this.payload);
      });

    // Seg changes
    this.filterMediaSegCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterSegs();
      });
    this.mediaSegMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.segment = data;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });

    // Start date changes
    this.mediaStMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.start_date = `${data.getFullYear()}-${data.getMonth() + 1}-${data.getDate()}`;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });

    // End date changes
    this.mediaEtMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      this.payload.end_date = `${data.getFullYear()}-${data.getMonth() + 1}-${data.getDate()}`;
      this.fetchScrapedNewsParamsMethod(this.payload);
    });

  }

  resetMedia() {
    this.mediaLangMasterCtrl.patchValue('');
    this.mediaKeyMasterCtrl.patchValue('');
    this.mediaAuthorMasterCtrl.patchValue('');
    this.mediaCatMasterCtrl.patchValue('');
    this.mediaChannelMasterCtrl.patchValue('');
    this.mediaEtMasterCtrl.patchValue('');
    this.mediaStMasterCtrl.patchValue('');
    this.mediaArtMasterCtrl.patchValue('');
    this.mediaSegMasterCtrl.patchValue('');

    this.payload = {
      page_num: 1,
      page_size: 10,
      language: '',
      keyword_id: '',
      channel_id: '',
      author_id: '',
      category_name: '',
      segment: '',
      start_date: '',
      end_date: ''
    };

    this.fetchScrapedNewsParamsMethod(this.payload);

  }

  fetchScrapedInitial() {
    this.scrapedNewsSwitch = <string>'loading';
    this._scraped_news.fetchScrapedNews(this.pageNumber, this.pageSize).subscribe((scrapedNews) => {
      if (!scrapedNews.hasOwnProperty('result')) {
        this.scrapedNewsList = scrapedNews;
      } else {
        scrapedNews.result.forEach((scraped) => {
          scraped.content_mine = scraped.content.split('\n');
        });
        scrapedNews.result.forEach((scraped) => {
          scraped.summary_mine = scraped.summary.split('\n');
        });
        this.scrapedNewsList = scrapedNews.result;
        this.totalRecords = scrapedNews.total_records;
      }
      this.scrapedNewsSwitch = <string>'active';
      this.scrapedAccordionSwitch = 'active';
    });
  }

  fetchScrapedNewsParamsMethod(payload) {
    this.scrapedNewsSwitch = <string>'loading';
    this._scraped_news.fetchScrapedNewsParams(payload).subscribe((scrapedNews) => {
      if (!scrapedNews.hasOwnProperty('result')) {
        this.scrapedNewsList = scrapedNews;
      } else {
        scrapedNews.result.forEach((scraped) => {
          scraped.content_mine = scraped.content.split('\n');
        });
        scrapedNews.result.forEach((scraped) => {
          scraped.summary_mine = scraped.summary.split('\n');
        });
        this.scrapedNewsList = scrapedNews.result;
        this.totalRecords = scrapedNews.total_records;
      }
      this.scrapedNewsSwitch = <string>'active';
      this.scrapedAccordionSwitch = 'active';
    });
  }


  public filterLanguages() {
    if (!this.languages) {
      return;
    }
    let search = this.filterMediaLangCtrl.value;
    if (!search) {
      this.filteredMediaLang.next(this.languages.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    this.filteredMediaLang.next(
      this.languages.filter((lang) => {
        return lang.toLowerCase().indexOf(search) > -1;
      })
    );
  }

  public filterKeywords() {
    let search = this.filterMediaKeyCtrl.value;
    if (!search) {
      return;
    } else {
      search = search.toLowerCase();
    }
    this.filteredMediaKey.next(
      this._keywords.filter((key) => {
        return key.keyword.toLowerCase().indexOf(search) > -1;
      })
    );
  }

  public filterChannels() {
    let search = this.filterMediaChannelCtrl.value;
    if (!search) {
      return;
    } else {
      search = search.toLowerCase();
    }
    this.filteredMediaChannel.next(
      this._channels.filter((channel) => {
        return channel.media_name.toLowerCase().indexOf(search) > -1;
      })
    );
  }

  public filterAuthors() {
    let search = this.filterMediaAuthorCtrl.value;
    if (!search) {
      return;
    } else {
      search = search.toLowerCase();
    }
    this.filteredMediaAuthor.next(
      this._authors.filter((author) => {
        return author.author_name.toLowerCase().indexOf(search) > -1;
      })
    );
  }

  public filterCats() {
    let search = this.filterMediaCatCtrl.value;
    if (!search) {
      return;
    } else {
      search = search.toLowerCase();
    }
    this.filteredMediaCat.next(
      this._categories.filter((cat) => {
        return cat.category.toLowerCase().indexOf(search) > -1;
      })
    );
  }

  public filterSegs() {
    let search = this.filterMediaSegCtrl.value;
    if (!search) {
      return;
    } else {
      search = search.toLowerCase();
    }
    this.filteredMediaSeg.next(
      this._segments.filter((segment) => {
        return segment.segment_name.toLowerCase().indexOf(search) > -1;
      })
    );
  }

  pageEvent(event: PageEvent) {
    this.scrapedAccordionSwitch = 'loading';
    this.payload.page_num = event.pageIndex + 1;
    this.pageNumber = event.pageIndex + 1;
    this.pageSize = event.pageSize;
    this._scraped_news.fetchScrapedNewsParams(this.payload).subscribe((scraped) => {
      scraped.result.forEach((scrape) => {
        scrape.content_mine = scrape.content.split('\n');
      });
      scraped.result.forEach((scrape) => {
        scrape.summary_mine = scrape.summary.split('\n');
      });
      this.scrapedNewsList = scraped.result;
      this.scrapedAccordionSwitch = 'active';
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  ngOnInit() {
    this.fetchScrapedInitial();
    this.fetchKeywords();
    this.fetchChannels();
    this.fetchAuthors();
    this.fetchCats();
    this.fetchSeg();
  }

  fetchKeywords() {
    this._key.getAllKeys().subscribe((response) => {
      if (!response.hasOwnProperty('result')) {
        console.log('Error while fetching key words');
        return;
      } else {
        const keys = response.result;
        this._keywords = keys;
        this.filteredMediaKey.next(keys);
      }
    });
  }

  fetchChannels() {
    this._channel.getPublication().subscribe((data) => {
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const channels = data.result;
      this.filteredMediaChannel.next(channels);
      this._channels = channels;
    });
  }

  fetchAuthors() {
    this._author.getAuthor().subscribe((data) => {
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const authors = data.result;
      this.filteredMediaAuthor.next(authors);
      this._authors = authors;
    });
  }


  fetchCats() {
    this._cat.fetchAllCategories().subscribe((data) => {
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const categories = data.result;
      this.filteredMediaCat.next(categories);
      this._categories = categories;
    });
  }

  fetchSeg() {
    this._segment.getStates().subscribe((data) => {
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const segments = data.result;
      this.filteredMediaSeg.next(segments);
      this._segments = segments;
    });
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  /**
   * taking the values to edit form
   */
  takeToEdit(scrapedNews) {
    this.scrapedNewsSwitch = 'message';
    // ADD_news_submit
    // get channel id
    this.addMediaScanScrapedBluePrint.channel_id = scrapedNews.channel_id;
    this.addMediaScanScrapedBluePrint.link = scrapedNews.link;
    this.addMediaScanScrapedBluePrint.headline = scrapedNews.headline;
    this.addMediaScanScrapedBluePrint.summary = scrapedNews.summary;
    this.addMediaScanScrapedBluePrint.content = scrapedNews.content.length > 0 ? scrapedNews.content : 'content';
    // get author id default 5ba4ef765209255952bb1693
    // if (typeof (scrapedNews.author_id) === 'object' && scrapedNews.author_id !== null) {
    //   this.addMediaScanScrapedBluePrint.author_id = scrapedNews.author_id;
    // } else {
    //   this.addMediaScanScrapedBluePrint.author_id = '';
    // }
    // language
    this.addMediaScanScrapedBluePrint.language = scrapedNews.language;

    // categories
    this.addMediaScanScrapedBluePrint.categories = [];
    if (scrapedNews.segmentation.length > 0) {
      const segmentation = scrapedNews.segmentation.map((segment) => {
        return { segmentation : segment };
      });
      this.addMediaScanScrapedBluePrint.segmentation = segmentation;
    } else {
      this.addMediaScanScrapedBluePrint.segmentation = [];
    }

    if (scrapedNews.districts) {
      if (scrapedNews.districts.length > 0) {
        const districts = scrapedNews.districts.join(',');
        this.addMediaScanScrapedBluePrint.districts = districts;
      } else {
        this.addMediaScanScrapedBluePrint.districts = [];
      }
    } else {
      this.addMediaScanScrapedBluePrint.districts = [];
    }

    this.addMediaScanScrapedBluePrint.sentiment_pair_leader = [];
    this.addMediaScanScrapedBluePrint.sentiment_pair_party = [];
    this.addMediaScanScrapedBluePrint.news_feed_id = scrapedNews.id;
    console.log(this.addMediaScanScrapedBluePrint);
    this._mediaScan.scrapedNewsSubmit(this.addMediaScanScrapedBluePrint).subscribe((response) => {
      if (response.hasOwnProperty('status')) {
        if (response.status) {
          this.scrapedNewsSwitch = 'active';
          this.scrapedAccordionSwitch = 'active';
          const dialogRef = this.dialog.open(DialogContentScrapedNewsDialogComponent, {
            height: '80%',
            width: '80%',
            data: {
              scrapedNewsData: scrapedNews,
              mediaScanData: response
            }
          });
          dialogRef.afterClosed().subscribe(result => {
            console.log(`Scraped News Dialog result: ${result}`);
            // show snack bar
            if (typeof (result) !== 'undefined') {
              this.snackBar.open(result.message, 'Close', {
                duration: 3000
              });
              // Make the API call to fetch the authors
              this.ngOnInit();
            }
          });
        }
      } else {
        this.snackBar.open(`Error while marking the news important. Please try again`, 'Close', {
          duration: 3000
        });
        this.scrapedNewsSwitch = 'active';
        this.scrapedAccordionSwitch = 'active';
        return;
      }
    });
  }

}

@Component({
  selector: 'app-dialog-content-scraped-dialog',
  templateUrl: 'dialog-content-addnews-show.html',
  styleUrls: ['./scraped-news.component.css']
})

export class DialogContentScrapedNewsDialogComponent implements OnInit {
  scrapedNews: any;
  scanData: any;
  constructor(
    private dialogRef: MatDialogRef<DialogContentScrapedNewsDialogComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private _publication: PublicationService,
    public snackBar: MatSnackBar,
    private _author: AuthorService,
    private _mediaScan: MediaScanService
  ) {
    this.scrapedNews = data.scrapedNewsData;
    this.scanData = data.mediaScanData;
  }

  ngOnInit() { }

  closeDialog(data) {
    this.dialogRef.close(data);
  }
}
