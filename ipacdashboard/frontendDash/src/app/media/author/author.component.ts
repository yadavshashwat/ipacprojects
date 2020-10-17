/**
 * @author victor
 * Author Management Component
 * Some deep shit in angular btw :/
 */
import { Component, OnInit, ElementRef, ViewChild, AfterViewInit, OnDestroy } from '@angular/core';
import { AuthorService } from "../../services/author.service";
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { FormGroup, FormBuilder, FormArray, Validators, FormControl } from '@angular/forms';
import { PartyService } from "../../services/party.service";
import { LeaderService } from "../../services/leader.service";
import { PublicationService } from "../../services/publication.service";
import { Inject } from "@angular/core";
import { MatSnackBar, MatSelect } from '@angular/material';
import { COMMA, ENTER } from '@angular/cdk/keycodes';
import { MatAutocompleteSelectedEvent, MatChipInputEvent } from '@angular/material';
import { Observable, ReplaySubject, Subject } from 'rxjs';
import { map, startWith, takeUntil, take } from 'rxjs/operators';
import { PageEvent } from '@angular/material';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";


@Component({
  selector: 'app-author',
  templateUrl: './author.component.html',
  styleUrls: ['./author.component.css']
})
export class AuthorComponent implements OnInit {

  authorList: any[] = [];
  displayedColumns: string[] = ['author_name', 'inclination_leader', 'inclination_party', 'media_name', 'edit_author', 'delete_author'];

  authorSwitch: string;
  authorAccordionSwitch: string;

  // Pagination Variables
  pageNumber: number;
  pageSize: number;
  totalRecords: number;


  constructor(
    private _author: AuthorService,
    public dialog: MatDialog,
    private fb: FormBuilder,
    public snackBar: MatSnackBar,
    public _media: PublicationService,
    private store: Store<fromStore.State>
  ) {
    this.pageNumber = 1;
    this.pageSize = 10;
  }

  pageEvent(event: PageEvent) {
    this.authorAccordionSwitch = 'loading';
    this.pageNumber = event.pageIndex + 1;
    this.pageSize = event.pageSize;
    this._author.getAuthorPaginate(this.pageNumber, this.pageSize).subscribe((authors) => {
      this.authorList = authors.result;
      this.authorAccordionSwitch = 'active';
    });
  }



  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }



  ngOnInit() {
    this.authorSwitch = 'loading';
    this._author.getAuthorPaginate(this.pageNumber, this.pageSize).subscribe((authors) => {
      console.log(authors);
      this.authorList = authors.result;
      this.totalRecords = authors.total_records;
      this.authorSwitch = 'active';
      this.authorAccordionSwitch = 'active';
    });
  }

  deleteAuth(row) {
    this.authorSwitch = 'loading';
    this._author.deleteAuthor({ id: row.id}).subscribe((data) => {
      if (!data) {
        this.snackBar.open('Error while deleting the author', 'Close', {
          duration: 1000
        });
        this.authorSwitch = 'active';
        return;
      }
      this.ngOnInit();
    });
  }



  openAuthorDialog(): void {
    const dialogRef = this.dialog.open(DialogContentAuthorDialogComponent, {
      height: '80%',
      width: '80%',
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log(`Author Dialog result: ${result}`);
      // show snack bar
      if (typeof (result) !== 'undefined') {
        this.snackBar.open(result, 'Close', {
          duration: 3000
        });
        // Make the API call to fetch the authors
        this.ngOnInit();
      }
    });
  }



  openEditAuthorDialog(element) {
    const dialogRef = this.dialog.open(DialogContentAuthorEditDialogComponent, {
      height: '500px',
      width: '900px',
      data: { 'toSend': element }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log(`Edit Author Dialog result: ${result}`);
      // show snack bar
      if (typeof (result) !== 'undefined') {
        this.snackBar.open(result, 'Close', {
          duration: 3000
        });
        // Make the API call to fetch the authors
        this.ngOnInit();
      }
    });
  }

}

@Component({
  selector: 'app-dialog-content-author-dialog',
  templateUrl: 'dialog-content-author.html',
  styleUrls: ['./author.component.css']
})

export class DialogContentAuthorDialogComponent implements OnInit, AfterViewInit, OnDestroy {

  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#D5DED9' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];

  sentimentScale: any[] = [
    { value: '-1', viewValue: 'Negative', color: '#EF3333' },
    { value: '-0.5', viewValue: 'Slightly negative', color: '#FE6763' },
    { value: '0', viewValue: 'Neutral', color: '#D5DED9' },
    { value: '0.5', viewValue: 'Slightly positive', color: '#88AC76' },
    { value: '1', viewValue: 'Positive', color: '#308446' }
  ];

  partyValues: any[] = [];
  leaderValues: any[] = [];
  submitted = false;
  addAuthorForm: FormGroup;
  visible = true;
  selectable = true;
  removable = true;
  addOnBlur = false;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  filteredMediaNames: Observable<string[]>;
  mediaNames: string[] = [];
  allMediaNames: string[] = [];

  /** Subject that emits when the component has been destroyed. */
  private _onDestroy = new Subject<void>();

  public partyFilterCtrl: FormControl = new FormControl();
  public leaderFilterCtrl: FormControl = new FormControl();

  /** list of banks filtered by search keyword */
  public filteredParties: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredLeaders: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);

  @ViewChild('mediaNameInput') mediaNameInput: ElementRef<HTMLInputElement>;
  @ViewChild('singleSelectParty') singleSelectParty: MatSelect;
  @ViewChild('singleSelectLeader') singleSelectLeader: MatSelect;

  constructor(
    private _author: AuthorService,
    private fb: FormBuilder,
    private _party: PartyService,
    private _leader: LeaderService,
    private dialogRef: MatDialogRef<DialogContentAuthorDialogComponent>,
    private _media: PublicationService,
    @Inject(MAT_DIALOG_DATA) public data
  ) {
    this.buildAddAuthorForm();
    this.filteredMediaNames = this.addAuthorForm.controls['media_name'].valueChanges.pipe(
      startWith(null),
      map((mediaName: string | null) => mediaName ? this._filter(mediaName) : this.allMediaNames.slice()));
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

  add(event: MatChipInputEvent): void {
    const input = event.input;
    const value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.mediaNames.push(value.trim());
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }

    this.addAuthorForm.controls['media_name'].setValue(null);
  }

  remove(fruit: string): void {
    const index = this.mediaNames.indexOf(fruit);

    if (index >= 0) {
      this.mediaNames.splice(index, 1);
    }
  }

  selected(event: MatAutocompleteSelectedEvent): void {
    this.mediaNames.push(event.option.viewValue);
    this.mediaNameInput.nativeElement.value = '';
    this.addAuthorForm.controls['media_name'].setValue(null);
  }

  private _filter(value: string): string[] {
    const filterValue = value.toLowerCase();

    return this.allMediaNames.filter(mediaName => mediaName.toLowerCase().indexOf(filterValue) === 0);
  }


  ngOnInit() {
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

    this._media.getPublication().subscribe((mediaData) => {
      console.log(mediaData);
      const mediaValues = mediaData.result;
      this.allMediaNames = mediaValues.map((media) => {
        return media.media_name;
      });
      console.log('Media Names Array', this.allMediaNames);
    });
  }

  ngAfterViewInit() { }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  buildAddAuthorForm(): void {
    this.addAuthorForm = this.fb.group({
      'media_name': ['', []],
      'author_name': [this.data ? this.data : '', [
        Validators.required
      ]],
      'author_caste': ['', [

      ]],
      'parties': this.fb.array([
        this.createPartyGroup()
      ]),
      'leaders': this.fb.array([
        this.createLeaderGroup()
      ])
    });
    this.addAuthorForm.valueChanges
      .subscribe(data => this.onAddAuthorValueChanged(data));
    this.onAddAuthorValueChanged(); // (re)set validation messages now
  }

  onAddAuthorValueChanged(data?: any) {
    if (!this.addAuthorForm) { return; }
    const form = this.addAuthorForm;
    for (const field in this.addAuthorFormErrors) {
      // clear previous error message (if any)
      this.addAuthorFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.addAuthorFormValidationMessages[field];
        for (const key in control.errors) {
          this.addAuthorFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  addAuthorFormErrors = {
    'author_name': ''
  };
  addAuthorFormValidationMessages = {
    'author_name': {
      'required': 'Author name is required.'
    }
  };

  onAddAuthorSubmit() {
    this.submitted = true;
    // make a deep copy of the input items
    console.log(this.addAuthorForm.value);
    const formModel = this.addAuthorForm.value;
    formModel.parties.forEach((element) => {
      element = JSON.stringify(element);
    });
    formModel.leaders.forEach((element) => {
      element = JSON.stringify(element);
    });
    formModel.parties = JSON.stringify(formModel.parties);
    formModel.leaders = JSON.stringify(formModel.leaders);
    const mediaNameRequestPayloadArray: Array<{ media_name: string }> = [];
    this.mediaNames.forEach((mediaName) => {
      mediaNameRequestPayloadArray.push(<{ media_name: string }>{ media_name: mediaName });
    });
    formModel.media_name = JSON.stringify(mediaNameRequestPayloadArray);
    console.log('After Modification', formModel);
    this._author.addAuthor(formModel).subscribe(
      (data) => {
        console.log('ADD AUTHOR DATA', data);
        if (data.status) {
          // close the dialog
          this.dialogRef.close(data.message);
        } else {
          // Error Handling
          this.dialogRef.close('Error while adding author');
        }
      }
    );
  }

  /**
   * get the parties values by getter method
   */
  get parties() {
    return this.addAuthorForm.get('parties') as FormArray;
  }

  /**
   * get the leaders values by getter method
   */
  get leaders() {
    return this.addAuthorForm.get('leaders') as FormArray;
  }

  /**
   * creates party group
   * containing party drop down and sentiment scale
   */
  createPartyGroup(): FormGroup {
    return this.fb.group({
      'party': ['', [
        Validators.required
      ]],
      'sentiment': ['', [
        Validators.required
      ]]
    });
  }

  /**
   * creates leader group
   * containing leaders drop down and sentiment scale
   */
  createLeaderGroup(): FormGroup {
    return this.fb.group({
      'leader': ['', [
        Validators.required
      ]],
      'sentiment': ['', [
        Validators.required
      ]]
    });
  }

  /**
   * Add Party
   */
  addParty(): void {
    this.parties.push(this.createPartyGroup());
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

}

@Component({
  selector: 'app-dialog-content-author-edit-dialog',
  templateUrl: 'dialog-content-author-edit.html',
  styleUrls: ['./author.component.css']
})

export class DialogContentAuthorEditDialogComponent implements OnInit, OnDestroy {

  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#D5DED9' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];
  sentimentScale: any[] = [
    { value: '-1', viewValue: 'Negative', color: '#EF3333' },
    { value: '-0.5', viewValue: 'Slightly negative', color: '#FE6763' },
    { value: '0', viewValue: 'Neutral', color: '#D5DED9' },
    { value: '0.5', viewValue: 'Slightly positive', color: '#88AC76' },
    { value: '1', viewValue: 'Positive', color: '#308446' }
  ];
  submitted = false;
  editAuthorForm: FormGroup;
  editFormData: any;
  visible = true;
  selectable = true;
  removable = true;
  addOnBlur = false;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  filteredMediaNames: Observable<string[]>;
  mediaNames: string[] = [];
  allMediaNames: string[] = [];
  partyValues: any[] = [];
  leaderValues: any[] = [];

  /** Subject that emits when the component has been destroyed. */
  private _onDestroy = new Subject<void>();

  public partyFilterCtrl: FormControl = new FormControl();
  public leaderFilterCtrl: FormControl = new FormControl();

  /** list of banks filtered by search keyword */
  public filteredParties: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);
  /** list of banks filtered by search keyword */
  public filteredLeaders: ReplaySubject<any[]> = new ReplaySubject<any[]>(1);

  @ViewChild('mediaNameInput') mediaNameInput: ElementRef<HTMLInputElement>;

  constructor(
    private _author: AuthorService,
    private fb: FormBuilder,
    private _party: PartyService,
    private _leader: LeaderService,
    private dialogRef: MatDialogRef<DialogContentAuthorDialogComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private _media: PublicationService
  ) {
    console.log('From dialog', data);
    this.editFormData = data.toSend;
    this.buildEditAuthorForm();
    this.patchEditAuthorForm();
    this.filteredMediaNames = this.editAuthorForm.controls['media_name'].valueChanges.pipe(
      startWith(null),
      map((mediaName: string | null) => mediaName ? this._filter(mediaName) : this.allMediaNames.slice()));
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

  add(event: MatChipInputEvent): void {
    const input = event.input;
    const value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.mediaNames.push(value.trim());
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }

    this.editAuthorForm.controls['media_name'].setValue(null);
  }

  remove(fruit: string): void {
    const index = this.mediaNames.indexOf(fruit);

    if (index >= 0) {
      this.mediaNames.splice(index, 1);
    }
  }

  selected(event: MatAutocompleteSelectedEvent): void {
    this.mediaNames.push(event.option.viewValue);
    this.mediaNameInput.nativeElement.value = '';
    this.editAuthorForm.controls['media_name'].setValue(null);
  }

  private _filter(value: string): string[] {
    const filterValue = value.toLowerCase();

    return this.allMediaNames.filter(mediaName => mediaName.toLowerCase().indexOf(filterValue) === 0);
  }

  ngOnInit() {
    this._party.getParties().subscribe((parties) => {
      console.log(parties);
      this.partyValues = parties.result;
      this.filteredParties.next(this.partyValues);
      this.setEditAuthorParties();
    });

    this._leader.getLeaders().subscribe((leaders) => {
      console.log(leaders);
      this.leaderValues = leaders.result;
      this.filteredLeaders.next(this.leaderValues);
      this.setEditAuthorLeaders();
    });

    this._media.getPublication().subscribe((mediaData) => {
      console.log(mediaData);
      const mediaValues = mediaData.result;
      if (mediaValues) {
        this.allMediaNames = mediaValues.map((media) => {
          return media.media_name;
        });
      }
      console.log('Media Names Array', this.allMediaNames);
    });
  }

  ngOnDestroy() {
    this._onDestroy.next();
    this._onDestroy.complete();
  }

  patchEditAuthorForm(): void {
    this.editAuthorForm.patchValue({
      author_name: this.editFormData.author_name,
      author_caste: this.editFormData.author_caste
    });
    this.mediaNames = this.editFormData.media_name;
    // this.setEditAuthorParties();
    // this.setEditAuthorLeaders();
  }

  /**
   * @author victor
   * Patching the selecting parties selected before
   * Higher end angular programming!
   * You are welcome ;) !
   */
  setEditAuthorParties(): void {
    this.filteredParties.next(this.partyValues);
    const control = <FormArray>this.editAuthorForm.controls.parties;
    this.editFormData.inclination_party.forEach((party) => {
      control.push(this.fb.group({
        party: party.party,
        sentiment: party.sentiment.replace(/\s/g, "")
      }));
    });
  }

  setEditAuthorLeaders(): void {
    this.filteredLeaders.next(this.leaderValues);
    const control = <FormArray>this.editAuthorForm.controls.leaders;
    this.editFormData.inclination_leader.forEach((leader) => {
      control.push(this.fb.group({
        leader: leader.leader,
        sentiment: leader.sentiment.replace(/\s/g, "")
      }));
    });
  }

  buildEditAuthorForm(): void {
    this.editAuthorForm = this.fb.group({
      'media_name': ['', []],
      'author_name': ['', [
        Validators.required
      ]],
      'author_caste': ['', [
        Validators.required
      ]],
      'parties': this.fb.array([
        // this.createPartyGroup()
      ]),
      'leaders': this.fb.array([
        // this.createLeaderGroup()
      ])
    });
    this.editAuthorForm.valueChanges
      .subscribe(data => this.onEditAuthorValueChanged(data));
    this.onEditAuthorValueChanged(); // (re)set validation messages now
  }

  onEditAuthorValueChanged(data?: any) {
    if (!this.editAuthorForm) { return; }
    const form = this.editAuthorForm;
    for (const field in this.editAuthorFormErrors) {
      // clear previous error message (if any)
      this.editAuthorFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.editAuthorFormValidationMessages[field];
        for (const key in control.errors) {
          this.editAuthorFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  editAuthorFormErrors = {
    'author_name': ''
  };
  editAuthorFormValidationMessages = {
    'author_name': {
      'required': 'Author name is required.'
    }
  };

  onEditAuthorSubmit() {
    this.submitted = true;
    // make a deep copy of the input items
    console.log(this.editAuthorForm.value);
    const formModel = this.editAuthorForm.value;
    formModel.parties.forEach((element) => {
      element = JSON.stringify(element);
    });
    formModel.leaders.forEach((element) => {
      element = JSON.stringify(element);
    });
    formModel.parties = JSON.stringify(formModel.parties);
    formModel.leaders = JSON.stringify(formModel.leaders);
    formModel.id = this.editFormData.id;
    const mediaNameRequestPayloadArray: Array<{ media_name: string }> = [];
    this.mediaNames.forEach((mediaName) => {
      mediaNameRequestPayloadArray.push(<{ media_name: string }>{ media_name: mediaName });
    });
    formModel.media_name = JSON.stringify(mediaNameRequestPayloadArray);
    console.log('After Modification', formModel);
    this._author.editAuthor(formModel).subscribe(
      (data) => {
        console.log('Edit AUTHOR DATA', data);
        if (data.status) {
          // close the dialog
          this.dialogRef.close(data.message);
        } else {
          // Error Handling
          this.dialogRef.close('Error while Editing author');
        }
      }
    );
  }

  /**
   * get the parties values by getter method
   */
  get parties() {
    return this.editAuthorForm.get('parties') as FormArray;
  }

  /**
   * get the leaders values by getter method
   */
  get leaders() {
    return this.editAuthorForm.get('leaders') as FormArray;
  }

  /**
   * creates party group
   * containing party drop down and sentiment scale
   */
  createPartyGroup(): FormGroup {
    return this.fb.group({
      'party': ['', [
        Validators.required
      ]],
      'sentiment': ['', [
        Validators.required
      ]]
    });
  }

  /**
   * creates leader group
   * containing leaders drop down and sentiment scale
   */
  createLeaderGroup(): FormGroup {
    return this.fb.group({
      'leader': ['', [
        Validators.required
      ]],
      'sentiment': ['', [
        Validators.required
      ]]
    });
  }

  /**
   * Add Party
   */
  addParty(): void {
    this.parties.push(this.createPartyGroup());
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

}
