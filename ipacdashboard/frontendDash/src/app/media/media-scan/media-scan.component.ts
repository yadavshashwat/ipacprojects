/**
 * @author victor
 * @description component for displaying media scan
 */
import {
  Component,
  OnInit,
  Inject,
  AfterViewInit,
  OnDestroy,
  ViewChild
} from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  FormArray,
  Validators,
  FormControl
} from '@angular/forms';
import { MediaScanService } from "../../services/media-scan.service";
import { KeywordService } from "../../services/keyword.service";
import { PublicationService } from "../../services/publication.service";
import { AuthorService } from "../../services/author.service";
import { CategoryService } from "../../services/category.service";
import { StateService } from "../../services/state.service";
import {
  MatDialog,
  MatDialogRef,
  MAT_DIALOG_DATA,
  MatSelect
} from '@angular/material';
import {
  MatSnackBar,
  PageEvent
} from '@angular/material';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";
import {
  takeUntil,
  distinctUntilChanged,
  debounceTime
} from 'rxjs/operators';

import {
  ReplaySubject,
  Subject
} from "rxjs";

import { API_URL } from "../../app.constant";


@Component({
  selector: 'app-media-scan',
  templateUrl: './media-scan.component.html',
  styleUrls: ['./media-scan.component.css']
})
export class MediaScanComponent implements OnInit, AfterViewInit, OnDestroy {

  // Filters\
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

  public date = new Date();
  public mediaStMasterCtrl: FormControl = new FormControl({ value: new Date(Date.now() - 86400000), disabled: true });

  // start filter control
  public mediaEtMasterCtrl: FormControl = new FormControl({ value: new Date(), disabled: true });

  // Article
  public mediaArtMasterCtrl: FormControl = new FormControl();
  payload: any = {
    page_num: this.pageNumber,
    page_size: this.pageSize
  };

  user: any;
  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#e0ce47' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];
  mediaScanList: any = [];
  mediaScanSwitch: string;
  mediaAccordionSwitch: string;
  color = 'primary';
  mode = 'query';
  panelOpenState = false;

  delete(media) {
    this.mediaScanSwitch = 'loading';
    this._mediascan.deleteScan({ id: media.id }).subscribe((data) => {
      if (data.length === 0) {
        this.snackBar.open('Error while deleting the scan', 'Close', {
          duration: 1000
        });
        this.mediaAccordionSwitch = 'active';
        this.mediaScanSwitch = 'active';
        return;
      }
      this.snackBar.open(data.message, 'Close', {
        duration: 1000
      });
      this.mediaAccordionSwitch = 'active';
      this.mediaScanSwitch = 'active';
    });
    this.resetMedia();
  }


  get_csv() {
    this.payload.get_csv = 1;
    let string = '?secret_id=ahgsdghsaiughdlashsiuanichskuhlcbnhjsailsyfo8uyy2376547653';
    Object.entries(this.payload).forEach((entry) => {
      string += `&${entry[0]}=${entry[1].toString()}`;
    });
    const final = `${API_URL}fetch_all_mediascan/${string}`;
    window.open(final, '_blank');
  }

  constructor(
    private _mediascan: MediaScanService,
    public dialog: MatDialog,
    public snackBar: MatSnackBar,
    private store: Store<fromStore.State>,
    private _key: KeywordService,
    private _channel: PublicationService,
    private _author: AuthorService,
    private _cat: CategoryService,
    private _segment: StateService
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
      delete this.payload.get_csv;
      this.payload.language = data;
      this.fetchMediaScanParamsMethod(this.payload);
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
      delete this.payload.get_csv;
      this.payload.keyword_id = data;
      this.fetchMediaScanParamsMethod(this.payload);
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
      delete this.payload.get_csv;
      this.payload.channel_id = data;
      this.fetchMediaScanParamsMethod(this.payload);
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
      delete this.payload.get_csv;
      this.payload.author_id = data;
      this.fetchMediaScanParamsMethod(this.payload);
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
      delete this.payload.get_csv;
      this.payload.category_name = data;
      this.fetchMediaScanParamsMethod(this.payload);
    });

    this.mediaArtMasterCtrl.valueChanges
      .pipe(
        takeUntil(this._onDestroy),
        debounceTime(400),
        distinctUntilChanged()
      )
      .subscribe((value) => {
        this.payload.article = value;
        this.fetchMediaScanParamsMethod(this.payload);
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
      delete this.payload.get_csv;
      this.payload.segment = data;
      this.fetchMediaScanParamsMethod(this.payload);
    });

    // Start date changes
    this.mediaStMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      delete this.payload.get_csv;
      this.payload.start_date = `${data.getFullYear()}-${data.getMonth() + 1}-${data.getDate()}`;
      this.fetchMediaScanParamsMethod(this.payload);
    });

    // End date changes
    this.mediaEtMasterCtrl.valueChanges.subscribe((data) => {
      if (!data) {
        return;
      }
      delete this.payload.get_csv;
      this.payload.end_date = `${data.getFullYear()}-${data.getMonth() + 1}-${data.getDate()}`;
      this.fetchMediaScanParamsMethod(this.payload);
    });


  }

  fetchMediaScanParamsMethod(payload) {
    this.mediaScanSwitch = <string>'loading';
    this._mediascan.fetchMediaScanParams(payload).subscribe((mediaScan) => {
      if (!mediaScan.hasOwnProperty('result')) {
        this.mediaScanList = mediaScan;
      } else {
        mediaScan.result.forEach((scraped) => {
          scraped.content = scraped.content.split('\n');
        });
        mediaScan.result.forEach((scraped) => {
          scraped.summary = scraped.summary.split('\n');
        });
        this.mediaScanList = mediaScan.result;
        this.mediaScanList.forEach(element => {
          if (element.language !== 'English') {
            element.content_en_headline = element.content_en.split('</br>')[0];
            element.content_en_summary = element.content_en.split('</br>')[1].split('\n');
            element.content_en_content = element.content_en.split('</br>')[2].split('\n');
          }
        });
        this.totalRecords = mediaScan.total_records;
      }
      this.mediaScanSwitch = <string>'active';
      this.mediaAccordionSwitch = 'active';
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

    delete this.payload.get_csv;

    this.fetchMediaScanParamsMethod(this.payload);

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
    this.mediaAccordionSwitch = 'loading';
    this.payload.page_num = event.pageIndex + 1;
    this.pageSize = event.pageSize;
    delete this.payload.get_csv;
    this._mediascan.fetchMediaScanParams(this.payload).subscribe((mediaScan) => {
      if (!mediaScan.hasOwnProperty('result')) {
        this.mediaScanList = mediaScan;
      } else {
        mediaScan.result.forEach((scraped) => {
          scraped.content = scraped.content.split('\n');
        });
        mediaScan.result.forEach((scraped) => {
          scraped.summary = scraped.summary.split('\n');
        });
        this.mediaScanList = mediaScan.result;
        this.mediaScanList.forEach(element => {
          if (element.language !== 'English') {
            element.content_en_headline = element.content_en.split('</br>')[0];
            element.content_en_summary = element.content_en.split('</br>')[1].split('\n');
            element.content_en_content = element.content_en.split('</br>')[2].split('\n');
          }
        });
      }
      this.mediaAccordionSwitch = 'active';
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  ngOnInit() {
    this.fetchMediaInitial();
    this.fetchKeywords();
    this.fetchChannels();
    this.fetchAuthors();
    this.fetchCats();
    this.fetchSeg();
  }

  fetchMediaInitial() {
    this.mediaScanSwitch = <string>'loading';
    this._mediascan.fetchMediaScan(this.pageNumber, this.pageSize).subscribe((mediaScan) => {
      if (!mediaScan.hasOwnProperty('result')) {
        this.mediaScanList = mediaScan;
      } else {
        mediaScan.result.forEach((scraped) => {
          scraped.content = scraped.content.split('\n');
        });
        mediaScan.result.forEach((scraped) => {
          scraped.summary = scraped.summary.split('\n');
        });
        this.mediaScanList = mediaScan.result;
        this.mediaScanList.forEach(element => {
          if (element.language !== 'English') {
            element.content_en_headline = element.content_en.split('</br>')[0];
            element.content_en_summary = element.content_en.split('</br>')[1].split('\n');
            element.content_en_content = element.content_en.split('</br>')[2].split('\n');
          }
        });
        this.totalRecords = mediaScan.total_records;
      }
      this.mediaScanSwitch = <string>'active';
      this.mediaAccordionSwitch = 'active';
    });
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

  ngAfterViewInit() {
    // Lets see
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  /**
   * taking the values to edit form
   */
  takeToEdit(media) {
    console.log(media);
    const dialogRef = this.dialog.open(DialogContentAddNewsDialogComponent, {
      height: '80%',
      width: '80%',
      data: { toDialog: media }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log(`Media Scan Dialog result: ${result}`);
      // show snack bar
      if (typeof (result) !== 'undefined') {
        this.snackBar.open(result.message, 'Close', {
          duration: 3000
        });
        // Make the API call to fetch the authors
        this.fetchMediaInitial();
      }
    });
  }


  openkeyDialog(data) {
    const dialogRef = this.dialog.open(DialogKeyComponent, {
      height: '80%',
      width: '80%',
      data: data
    });
    dialogRef.afterClosed().subscribe(result => {
      // console.log(`keys Dialog result: ${result}`);
      // // show snack bar
      // if (typeof (result) !== 'undefined') {
      //   this.snackBar.open(result.message, 'Close', {
      //     duration: 3000
      //   });
      //   // Make the API call to fetch the authors
      //   this.fetchMediaInitial();
      // }
    });
  }

}

@Component({
  selector: 'app-dialog-content-addnews-dialog',
  templateUrl: 'dialog-content-addnews.html',
  styleUrls: ['./media-scan.component.css']
})

export class DialogContentAddNewsDialogComponent implements OnInit {
  media: any;
  constructor(
    private dialogRef: MatDialogRef<DialogContentAddNewsDialogComponent>,
    @Inject(MAT_DIALOG_DATA) data
  ) {
    this.media = data.toDialog;
  }

  ngOnInit() { }

  closeDialog(data) {
    this.dialogRef.close(data);
  }
}

@Component({
  selector: 'app-dialog-key-dialog',
  templateUrl: 'dialog-key.html',
  styleUrls: ['./media-scan.component.css']
})

export class DialogKeyComponent implements OnInit {
  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#e0ce47' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];
  key: any;
  constructor(
    private dialogRef: MatDialogRef<DialogKeyComponent>,
    @Inject(MAT_DIALOG_DATA) data
  ) {
    this.key = data;
  }

  ngOnInit() { }
}

