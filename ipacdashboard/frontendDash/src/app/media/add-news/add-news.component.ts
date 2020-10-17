/**
 * @author Victor
 * Component for the add news form
 */
import {
  Component,
  OnInit,
  ElementRef,
  ViewChild,
  Input,
  OnChanges,
  SimpleChanges,
  Output,
  EventEmitter,
  AfterViewInit,
  OnDestroy
} from '@angular/core';
import { Location } from "@angular/common";
import {
  FormGroup,
  FormBuilder,
  FormArray,
  Validators,
  FormControl
} from '@angular/forms';
import { StateService } from "../../services/state.service";
import { NewsCategoryService } from "../../services/news-category.service";
import { PartyService } from "../../services/party.service";
import { LeaderService } from "../../services/leader.service";
import { PublicationService } from "../../services/publication.service";
import { AuthorService } from "../../services/author.service";
import { MediaScanService } from "../../services/media-scan.service";
import { COMMA, ENTER } from '@angular/cdk/keycodes';
import {
  MatAutocompleteSelectedEvent,
  MatChipInputEvent,
  MatSelect
} from '@angular/material';
import { Observable } from 'rxjs';
import {
  map,
  startWith,
  takeUntil,
  take
} from 'rxjs/operators';
import { MatSnackBar } from '@angular/material';
import {
  MatDialog,
  MatDialogRef,
  MAT_DIALOG_DATA
} from '@angular/material';

import {
  ReplaySubject,
  Subject
} from "rxjs";

export interface AddNewsRequestPayload {
  scan_id?: string;
  channel_id: string;
  link: string;
  headline: string;
  summary: string;
  content: string;
  author_id: string;
  categories: string;
  segmentation: string;
  districts: string;
  language: string;
  sentiment_pair_leader: string;
  sentiment_pair_party: string;
  news_feed_id?: string;
}

export interface Segmentation {
  dashboard_type: string;
  id: string;
  segment_active: boolean;
  segment_name: string;
  segmentation_id: string;
  segmentation_type: string;
}

@Component({
  selector: 'app-add-news',
  templateUrl: './add-news.component.html',
  styleUrls: ['./add-news.component.css']
})
export class AddNewsComponent implements OnInit, OnChanges, OnDestroy, AfterViewInit {
  //  Hoist variables
  addNewsSwitch = 'active';
  mediaScanValue: any = undefined;
  scrapedNewsValue: any = undefined;
  scrapedNewsMediaScan: any = undefined;
  partyValues: any[] = [];
  leaderValues: any[] = [];
  allTopics: any[] = [];
  stateList: any[];
  districtList: any[];
  publicationList: any[];
  authorList: any[];
  addNewsForm: FormGroup;

  /** control for the MatSelect filter keyword */
  public langFilterControl: FormControl = new FormControl();
  public stateMultiFilterCtrl: FormControl = new FormControl();
  public districtMultiFilterCtrl: FormControl = new FormControl();
  public publiFilterCtrl: FormControl = new FormControl();
  public authorFilterCtrl: FormControl = new FormControl();
  public topicFilterCtrl: FormControl = new FormControl();
  public partyFilterCtrl: FormControl = new FormControl();
  public leaderFilterCtrl: FormControl = new FormControl();

  /** list of banks filtered by search keyword */
  public filteredLanguages: ReplaySubject<String[]> = new ReplaySubject<String[]>(1);
  /** list of banks filtered by search keyword */
  public filteredStates: ReplaySubject<Segmentation[]> = new ReplaySubject<Segmentation[]>(1);

  public filteredDistricts: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredPubli: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredAuthor: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredTopics: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredParties: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredLeaders: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);

  @ViewChild('singleSelectLang') singleSelectLang: MatSelect;
  @ViewChild('multiSelectState') multiSelectState: MatSelect;
  @ViewChild('multiSelectDistrict') multiSelectDistrict: MatSelect;
  @ViewChild('singleSelectPubli') singleSelectPubli: MatSelect;
  @ViewChild('singleSelectAuthor') singleSelectAuthor: MatSelect;
  @ViewChild('singleSelectTopic') singleSelectTopic: MatSelect;
  @ViewChild('singleSelectParty') singleSelectParty: MatSelect;
  @ViewChild('singleSelectLeader') singleSelectLeader: MatSelect;


  /** Subject that emits when the component has been destroyed. */
  private _onDestroy = new Subject<void>();

  languages: any[] = [
    'English', 'Hindi', 'Telugu', 'Tamil', 'Gujarati', 'Marathi', 'Bengali', 'Urdu', 'Punjabi', 'Kannada', 'Malayalam'
  ];
  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#FFD238' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];
  sentimentScale: any[] = [
    { value: '-1', viewValue: 'Negative', color: '#EF3333' },
    { value: '-0.5', viewValue: 'Slightly negative', color: '#FE6763' },
    { value: '0', viewValue: 'Neutral', color: '#FFD238' },
    { value: '0.5', viewValue: 'Slightly positive', color: '#88AC76' },
    { value: '1', viewValue: 'Positive', color: '#308446' }
  ];

  @Input() media: any;
  @Input() scrapedNews: any;
  @Input() scanData: any;
  @Output() closeDialog = new EventEmitter();
  @Output() closeDialogScraped = new EventEmitter();

  /**
   * get the parties values by getter method
   */
  get parties() {
    return this.addNewsForm.get('parties') as FormArray;
  }

  /**
   * get the leaders values by getter method
   */
  get leaders() {
    return this.addNewsForm.get('leaders') as FormArray;
  }

  constructor(
    private _location: Location,
    private _state: StateService,
    private _topic: NewsCategoryService,
    private _party: PartyService,
    private _leader: LeaderService,
    private _publication: PublicationService,
    private _author: AuthorService,
    private _addnews: MediaScanService,
    public fb: FormBuilder,
    private snackBar: MatSnackBar,
    public dialog: MatDialog
  ) {
    this.buildAddNewsForm();

    this.filteredLanguages.next(this.languages);

    this.langFilterControl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterLanguages();
      });

    this.stateMultiFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterSegmentation();
      });

    this.districtMultiFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterDistricts();
      });

    this.publiFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterPublication();
      });

    this.authorFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterAuthor();
      });

    this.topicFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterTopics();
      });

    this.partyFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterParties();
      });

    this.leaderFilterCtrl.valueChanges
      .pipe(takeUntil(this._onDestroy))
      .subscribe(() => {
        this.filterLeaders();
      });

    this.addNewsForm.controls['states'].valueChanges.pipe(
      takeUntil(this._onDestroy)
    ).subscribe((value) => {
      if (value === "") {
        return;
      } else {
        this._state.getDist(value.map(el => el.segmentation_id).join(',')).subscribe((data) => {
          if (!data) {
            return;
          }
          if (!data.hasOwnProperty('result')) {
            return;
          }
          this.districtList = data['result'];
          this.filteredDistricts.next(this.districtList.slice());
        });
      }
    });
  }

  ngAfterViewInit() {
    this.setInitialValueLanguage(); // languages
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  private filterLanguages() {
    if (!this.languages) {
      return;
    }
    // get the search keyword
    let search = this.langFilterControl.value;
    if (!search) {
      this.filteredLanguages.next(this.languages.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredLanguages.next(
      this.languages.filter(language => language.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterSegmentation() {
    if (!this.stateList) {
      return;
    }
    // get the search keyword
    let search = this.stateMultiFilterCtrl.value;
    if (!search) {
      this.filteredStates.next(this.stateList.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredStates.next(
      this.stateList.filter(state => state.segment_name.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterDistricts() {
    if (!this.districtList) {
      return;
    }
    // get the search keyword
    let search = this.districtMultiFilterCtrl.value;
    if (!search) {
      this.filteredDistricts.next(this.districtList.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredDistricts.next(
      this.districtList.filter(district => district.district_name.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterPublication() {
    if (!this.publicationList) {
      return;
    }
    // get the search keyword
    let search = this.publiFilterCtrl.value;
    if (!search) {
      this.filteredPubli.next(this.publicationList.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredPubli.next(
      this.publicationList.filter(publi => publi.media_name.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterAuthor() {
    if (!this.authorList) {
      return;
    }
    // get the search keyword
    let search = this.authorFilterCtrl.value;
    if (!search) {
      this.filteredAuthor.next(this.authorList.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredAuthor.next(
      this.authorList.filter(author => author.author_name.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterTopics() {
    if (!this.allTopics) {
      return;
    }
    // get the search keyword
    let search = this.topicFilterCtrl.value;
    if (!search) {
      this.filteredTopics.next(this.allTopics.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredTopics.next(
      this.allTopics.filter(topic => topic.category.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterParties() {
    if (!this.partyValues) {
      return;
    }
    // get the search keyword
    let search = this.partyFilterCtrl.value;
    if (!search) {
      this.filteredParties.next(this.partyValues.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredParties.next(
      this.partyValues.filter(party => party.party.toLowerCase().indexOf(search) > -1)
    );
  }

  private filterLeaders() {
    if (!this.leaderValues) {
      return;
    }
    // get the search keyword
    let search = this.leaderFilterCtrl.value;
    if (!search) {
      this.filteredLeaders.next(this.leaderValues.slice());
      return;
    } else {
      search = search.toLowerCase();
    }
    // filter the banks
    this.filteredLeaders.next(
      this.leaderValues.filter(leader => leader.leader_name.toLowerCase().indexOf(search) > -1)
    );
  }

  /**
   * Sets the initial value after the filteredBanks are loaded initially
   */
  private setInitialValueLanguage() {
    this.filteredLanguages
      .pipe(take(1), takeUntil(this._onDestroy))
      .subscribe(() => {
        // setting the compareWith property to a comparison function
        // triggers initializing the selection according to the initial value of
        // the form control (i.e. _initializeSelection())
        // this needs to be done after the filteredBanks are loaded initially
        // and after the mat-option elements are available
        this.singleSelectLang.compareWith = (a: any, b: any) => a === b;
        // this.multiSelectState.compareWith = (a: Segmentation, b: Segmentation) => a.segmentation_id === b.segmentation_id;
        // this.singleSelectPubli.compareWith = (a: any, b: any) => a.media_name === b.media_name;
        // this.singleSelectAuthor.compareWith = (a: any, b: any) => a.id === b.id;
        // this.singleSelectTopic.compareWith = (a: any, b: any) => a.id === b.id;
        // this.singleSelectParty.compareWith = (a: any, b: any) => a.id === b.id;
      });
  }

  ngOnInit() {
    this._state.getStates().subscribe((states) => {
      console.log(states);
      this.stateList = states.result;
      this.filteredStates.next(this.stateList);
    });

    this._topic.getTopics().subscribe((topics) => {
      console.log(topics);
      this.allTopics = topics.result;
      this.filteredTopics.next(this.allTopics);
    });

    this._party.getParties().subscribe((parties) => {
      console.log(parties);
      this.partyValues = parties.result;
      this.filteredParties.next(this.partyValues);
    });

    this._leader.getLeaders().subscribe((leaders) => {
      console.log(leaders);
      this.leaderValues = leaders.result;
      this.filteredLeaders.next(this.leaderValues);
    });

    this._publication.getPublication().subscribe((publications) => {
      console.log(publications);
      if (publications.hasOwnProperty('result')) {
        this.publicationList = publications.result;
        this.filteredPubli.next(this.publicationList);
      } else {
        if (this.scanData) {
          this.closeDialogScraped.emit('');
          this.snackBar.open(`Publication API failed. Please try again`, 'Close', {
            duration: 3000
          });
          return;
        }
      }
    });

    this._author.getAuthor().subscribe((authors) => {
      console.log(authors);
      this.authorList = authors.result;
      this.filteredAuthor.next(this.authorList);
    });

  }

  ngOnChanges(changes: SimpleChanges): void {
    console.log(changes);
    if (changes.scrapedNews && changes.scanData) {
      this.patchAddNewsScrapedForm(changes);
    } else {
      this.patchAddNewsForm(changes);
    }
  }

  openAuthorDialog() {
    let dialogRef;
    if (this.scrapedNews) {
      if (this.scrapedNews.author !== '') {
        dialogRef = this.dialog.open(DialogAddAuthorComponent, {
          width: '80%',
          height: '80%',
          data: this.scrapedNews.author
        });
      } else {
        dialogRef = this.dialog.open(DialogAddAuthorComponent, {
          width: '80%',
          height: '80%'
        });
      }
    } else {
      dialogRef = this.dialog.open(DialogAddAuthorComponent, {
        width: '80%',
        height: '80%'
      });
    }


    dialogRef.afterClosed().subscribe((data) => {
      if (!data) {
        return;
      } else {
        this.snackBar.open(data, 'Close', {
          duration: 3000
        });
        this._author.getAuthor().subscribe((authors) => {
          console.log(authors);
          this.authorList = authors.result;
          this.filteredAuthor.next(this.authorList.slice());
        });
      }
    });
  }

  compareFn(x: any, y: any): boolean {
    return x && y ? x.id === y.id : x === y;
  }

  /**
   * Patching the form with input values
   */
  patchAddNewsForm(changes: SimpleChanges) {
    this.mediaScanValue = changes.media.currentValue;
    console.log(this.mediaScanValue);
    // patch input fields first
    this.addNewsForm.patchValue({
      headline: this.mediaScanValue.headline,
      webLink: this.mediaScanValue.link,
      summary: this.mediaScanValue.summary,
      content: this.mediaScanValue.content,
      lang: this.mediaScanValue.language
    });
    // TODO: Remove the API call later
    // Desired Blueprint { }
    // hello hello
    this._state.getStates().subscribe((data) => {
      const segmentList = data.result;
      if (segmentList.length > 0) {
        this.filteredStates.next(segmentList.slice());
        const desiredStates = [];
        if (this.mediaScanValue.segmentation.length > 0) {
          this.mediaScanValue.segmentation.forEach((id) => {
            segmentList.forEach((segment) => {
              if (segment.segmentation_id === id) {
                desiredStates.push(segment);
              }
            });
          });
        } else {
          return;
        }
        this.addNewsForm.controls['states'].setValue(desiredStates);
      }
    });
    // districts
    this._state.getDist(this.mediaScanValue.segmentation.join(',')).subscribe((data) => {
      if (!data) {
        this.snackBar.open('Error while fetching the districts', 'Close', {
          duration: 1000
        });
        return;
      }
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const districts = data.result;
      this.filteredDistricts.next(districts.slice());
      const desiredDistricts = [];
      this.mediaScanValue.districts.forEach((el) => {
        districts.forEach((district) => {
          if (district.district_name === el) {
            desiredDistricts.push(district);
          }
        });
      });
      this.addNewsForm.controls['districts'].setValue(desiredDistricts);
    });
    // publication
    // TODO: Remove the API call later
    // Desired Blueprint { }
    // all good
    this._publication.getPublication().subscribe((data) => {
      const publiList = data.result;
      if (publiList.length > 0) {
        const desiredPubli = publiList.filter((publi) => {
          return publi.id === this.mediaScanValue.channel_id;
        }).pop();
        console.log('Desired Publication', desiredPubli);
        this.addNewsForm.controls['publications'].setValue(desiredPubli);
      }
    });
    // TODO: Remove the API call later
    // Desired Blueprint { }
    // all good
    this._author.getAuthor().subscribe((data) => {
      const segmentList = data.result;
      if (segmentList.length > 0) {
        const desiredAuthor = segmentList.filter((author) => {
          return author.id === this.mediaScanValue.author_id;
        }).pop();
        console.log('Desired Author', desiredAuthor);
        this.addNewsForm.controls['authors'].setValue(desiredAuthor);
      }
    });
    // topics
    this._topic.getTopics().subscribe((data) => {
      if (!data) {
        this.snackBar.open('Error while fetching topics', 'Close', {
          duration: 1000
        });
        return;
      }
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const topics = data.result;
      this.filteredTopics.next(topics.slice());
      const desiredTopics = [];
      this.mediaScanValue.category.forEach((el) => {
        topics.forEach((topic) => {
          if (topic.category === el) {
            desiredTopics.push(topic);
          }
        });
      });
      this.addNewsForm.controls['topicCtrl'].setValue(desiredTopics);
    });
    this.patchParties();
    this.patchLeaders();
  }

  /**
   * Patching the form with input values
   */
  patchAddNewsScrapedForm(changes: SimpleChanges) {
    this.scrapedNewsValue = changes.scrapedNews.currentValue;
    this.scrapedNewsMediaScan = changes.scanData.currentValue;
    console.log(this.scrapedNewsValue);
    // patch input fields first
    this.addNewsForm.patchValue({
      headline: this.scrapedNewsValue.headline,
      webLink: this.scrapedNewsValue.link,
      summary: this.scrapedNewsValue.summary,
      content: this.scrapedNewsValue.content,
      lang: this.scrapedNewsValue.language
    });
    // states
    this._state.getStates().subscribe((data) => {
      const segmentList = data.result;
      if (segmentList.length > 0) {
        this.filteredStates.next(segmentList.slice());
        const desiredStates = [];
        if (this.scrapedNewsValue.segmentation.length > 0) {
          this.scrapedNewsValue.segmentation.forEach((id) => {
            segmentList.forEach((segment) => {
              if (segment.segmentation_id === id) {
                desiredStates.push(segment);
              }
            });
          });
        } else {
          return;
        }
        this.addNewsForm.controls['states'].setValue(desiredStates);
      }
    });
    // publication
    // TODO: Remove the API call later
    // Desired Blueprint { }
    this._publication.getPublication().subscribe((data: any) => {
      if (data.hasOwnProperty('result')) {
        const publiList = data.result;
        if (publiList.length > 0) {
          const desiredPubli = publiList.filter((publi) => {
            return publi.media_name === this.scrapedNewsValue.channel_name;
          }).pop();
          console.log('Desired Publication', desiredPubli);
          this.addNewsForm.controls['publications'].setValue(desiredPubli);
        }
      } else {
        this.closeDialogScraped.emit('');
        this.snackBar.open(`Publication API failed. Please try again`, 'Close', {
          duration: 3000
        });
        return;
      }

    });
    // TODO: Remove the API call later
    // Desired Blueprint { }
    if (typeof (this.scrapedNewsMediaScan.author_id) === 'object' && this.scrapedNewsMediaScan.author_id !== null) {
      this._author.getAuthor().subscribe((data) => {
        if (data.hasOwnProperty('result')) {
          const segmentList = data.result;
          if (segmentList.length > 0) {
            const desiredAuthor = segmentList.filter((author) => {
              return author.id === this.scrapedNewsMediaScan.author_id;
            }).pop();
            console.log('Desired Author', desiredAuthor);
            this.addNewsForm.controls['authors'].setValue(desiredAuthor);
          }
        } else {
          this.closeDialogScraped.emit('');
          this.snackBar.open(`Author API failed. Please try again`, 'Close', {
            duration: 3000
          });
          return;
        }
      });
    } else {
      this._author.getAuthor().subscribe((data) => {
        if (data.hasOwnProperty('result')) {
          const segmentList = data.result;
          if (segmentList.length > 0) {
            const desiredAuthor = segmentList.filter((author) => {
              return author.author_name === 'Unknown';
            }).pop();
            console.log('Desired Author', desiredAuthor);
            this.addNewsForm.controls['authors'].setValue(desiredAuthor);
          }
        }
      });
    }
    // topics
    this._topic.getTopics().subscribe((data) => {
      if (!data) {
        this.snackBar.open('Error while fetching topics', 'Close', {
          duration: 1000
        });
        return;
      }
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const topics = data.result;
      this.filteredTopics.next(topics.slice());
      const desiredTopics = [];
      if (this.scrapedNewsValue.category.length > 0) {
        this.scrapedNewsValue.category.forEach((el) => {
          topics.forEach((topic) => {
            if (topic.category === el) {
              desiredTopics.push(topic);
            }
          });
        });
      } else {
        return;
      }
      this.addNewsForm.controls['topicCtrl'].setValue(desiredTopics);
    });

  }

  /**
   * @author victor
   * Patching the selecting parties selected before
   * Higher end angular programming!
   * You are welcome ;) !
   */
  patchParties(): void {
    const control = <FormArray>this.addNewsForm.controls.parties;
    this._party.getParties().subscribe((parties) => {
      if (!parties) {
        return;
      }
      if (!parties.hasOwnProperty('result')) {
        return;
      }
      const allparties = parties.result;
      this.filteredParties.next(allparties.slice());
      this.mediaScanValue.user_sentiment_pair_party.forEach((el) => {
        allparties.forEach((party) => {
          if (party.party === el.party) {
            control.push(this.fb.group({
              party: party,
              sentiment: el.sentiment.replace(/\s/g, "")
            }));
          }
        });
      });
    });
  }

  patchLeaders(): void {
    const control = <FormArray>this.addNewsForm.controls.leaders;
    this._leader.getLeaders().subscribe((data) => {
      if (!data) {
        return;
      }
      if (!data.hasOwnProperty('result')) {
        return;
      }
      const allleaders = data.result;
      this.filteredLeaders.next(allleaders.slice());
      this.mediaScanValue.user_sentiment_pair_leader.forEach((el) => {
        allleaders.forEach((leader) => {
          if (leader.leader_name === el.leader) {
            control.push(this.fb.group({
              leader: leader,
              sentiment: el.sentiment.replace(/\s/g, "")
            }));
          }
        });
      });
    });
  }


  /**
   * Construction of add news form
   */
  public buildAddNewsForm() {
    this.addNewsForm = this.fb.group({
      'headline': ['', [
        Validators.required
      ]],
      'webLink': ['', [
        Validators.required
      ]],
      'summary': ['', [
        Validators.required
      ]],
      'states': ['', []],
      'districts': ['', []],
      'publications': ['', [
        Validators.required
      ]],
      'authors': ['', [
        Validators.required
      ]],
      'content': ['', [
        Validators.required
      ]],
      'lang': ['', [
        Validators.required
      ]],
      'topicCtrl': ['', [
        Validators.required
      ]],
      'parties': this.fb.array([
        // this.createPartyGroup()
      ]),
      'leaders': this.fb.array([
        // this.createLeaderGroup()
      ])
    });

    this.addNewsForm.valueChanges
      .subscribe(data => this.onAddNewsFormValueChanged(data));
    this.onAddNewsFormValueChanged(); // (re)set validation messages now
  }

  /**
   * creates party group
   * containing party drop down and sentiment scale
   */
  createPartyGroup(): FormGroup {
    return this.fb.group({
      'party': ['', []],
      'sentiment': ['', []]
    });
  }

  /**
   * creates leader group
   * containing leaders drop down and sentiment scale
   */
  createLeaderGroup(): FormGroup {
    return this.fb.group({
      'leader': ['', []],
      'sentiment': ['', []]
    });
  }

  /**
   * Add Party
   */
  addParty(): void {
    this.parties.push(this.createPartyGroup());
    // this.setInitialValueLanguage();
  }

  /**
   * Add Leader
   */
  addLeader(): void {
    this.leaders.push(this.createLeaderGroup());
  }

  /**
   * Remove Party Group
   */
  removePartyGroup(index: number) {
    this.parties.removeAt(index);
  }

  /**
   * Remove Leader Group
   */
  removeLeaderGroup(index: number) {
    this.leaders.removeAt(index);
  }


  /**
   * When Form Value changes
   * @param data any
   */
  onAddNewsFormValueChanged(data?: any) {
    if (!this.addNewsForm) { return; }
    const form = this.addNewsForm;
    for (const field in this.addNewsFormErrors) {
      // clear previous error message (if any)
      this.addNewsFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.addNewsFormValidationMessages[field];
        for (const key in control.errors) {
          this.addNewsFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  /**
   * add news form errors
   */
  addNewsFormErrors = {
    'headline': '',
    'webLink': '',
    'summary': '',
    'states': '',
    'districts': '',
    'publications': '',
    'authors': '',
    'content': '',
    'lang': '',
    'topicCtrl': ''
  };

  /**
   * Validation messages for the input fields
   */
  addNewsFormValidationMessages = {
    'headline': {
      'required': 'Headline is required.'
    },
    'webLink': {
      'required': 'Web link is required.'
    },
    'summary': {
      'required': 'Summary is required.'
    },
    'states': {},
    'districts': {},
    'publications': {
      'required': 'Please select atleast 1 publication'
    },
    'authors': {
      'required': 'Author field is required'
    },
    'lang': {
      'required': 'Language is required'
    },
    'content': {
      'required': 'Content is required'
    },
    'topicCtrl': {
      'required': 'Topic is required'
    }
  };

  goBack() {
    this._location.back();
  }

  /**
   * Whole add news form submit
   */
  onAddNewsFormSubmit() {
    // this.submitted = true;
    // make a deep copy of the input items
    this.addNewsSwitch = 'message';
    const formModel = this.addNewsForm.value;

    const categories: Array<{ category: string }> = formModel.topicCtrl.map((topic) => {
      return Object.assign({}, { category: topic.category });
    });

    let states: Array<any>;

    if (formModel.states.length > 0) {
      states = formModel.states.map((state) => {
        return Object.assign({}, { segmentation: state.segmentation_id });
      });
    } else {
      states = [];
    }

    let parties: Array<any>;

    if (formModel.parties.length > 0) {
      parties = formModel.parties.map((party) => {
        return party.party = party.party.party;
      });
    } else {
      parties = [];
    }

    let leaders: Array<any>;

    if (formModel.leaders.length > 0) {
      leaders = formModel.leaders.map((leader) => {
        return leader.leader = leader.leader.leader_name;
      });
    } else {
      leaders = [];
    }

    let districts: string;

    if (formModel.districts.length > 0) {
      districts = formModel.districts.map(el => el.district_name).join(',');
    } else {
      districts = '';
    }


    let requestPayloadSource: AddNewsRequestPayload;
    debugger;
    // common object
    const commonPayload = {
      channel_id: formModel.publications.id,
      link: formModel.webLink,
      headline: formModel.headline,
      summary: formModel.summary === '' ? 'summary' : formModel.summary,
      content: formModel.content,
      language: formModel.lang,
      author_id: formModel.authors.id,
      categories: JSON.stringify(categories),
      segmentation: JSON.stringify(states),
      districts: districts,
      sentiment_pair_leader: JSON.stringify(formModel.leaders),
      sentiment_pair_party: JSON.stringify(formModel.parties)
    };
    // mediaScanValue is coming from media scan edit
    if (this.mediaScanValue) {
      const mediaScanPayload = {
        scan_id: this.mediaScanValue.id
      };
      requestPayloadSource = Object.assign({}, commonPayload, mediaScanPayload);
    }
    // scrapedNewsValue is coming after adding scraped news to media scan and edit
    if (this.scrapedNewsValue && this.scanData) {
      const scrapedViaMediaPayload = {
        scan_id: this.scanData.mediascan_id,
        news_feed_id: this.scanData.news_feed_id
      };
      requestPayloadSource = Object.assign({}, commonPayload, scrapedViaMediaPayload);
    }
    // normal add request payload
    if (!this.mediaScanValue && !this.scrapedNewsValue && !this.scanData) {
      requestPayloadSource = Object.assign({}, commonPayload);
    }

    const requestPayload = Object.assign({}, requestPayloadSource);
    // console.log('MEDIA SCAN REQUEST PAYLOAD', requestPayload);
    this._addnews.addnews(requestPayload).subscribe(
      (data) => {
        // console.log(`MEDIA SCAN DATA ${this.mediaScanValue ? 'EDITED' : 'ADDED'}`, data);
        if (data.status) {

          this.addNewsSwitch = 'active';

          if (!this.mediaScanValue && !this.scrapedNewsValue && !this.scanData) {
            // normal add news
            this.snackBar.open(data.message, 'CLOSE', {
              duration: 3000
            });
          }
          if (this.mediaScanValue) {
            // close the dialog
            this.closeDialog.emit(data);
          }

          if (this.scrapedNewsValue && this.scanData) {
            // close the dialog
            this.closeDialogScraped.emit(data);
          }
        } else {
          // show snack bar
          this.addNewsSwitch = 'active';
          if (!this.mediaScanValue && !this.scrapedNewsValue && !this.scanData) {
            // normal add news
            this.snackBar.open(`Error while ${this.mediaScanValue ? 'editing' : 'adding'}adding the media scan`, 'Close', {
              duration: 3000
            });
          }

          if (this.mediaScanValue) {
            // close the dialog
            this.closeDialog.emit(`Error while registering the media scan`);
          }

          if (this.scrapedNewsValue && this.scanData) {
            // close the dialog
            this.closeDialogScraped.emit(`Error while registering the media scan`);
          }

        }
      }
    );
  }

}

@Component({
  selector: 'app-dialog-add-news-dialog',
  templateUrl: 'dialog-add-news-dialog.html',
})
export class DialogAddAuthorComponent {

  constructor(
    public dialogRef: MatDialogRef<DialogAddAuthorComponent>) { }

  onNoClick(): void {
    this.dialogRef.close();
  }

}
