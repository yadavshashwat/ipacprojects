/**
 * @author Victor
 * Component for publication Management
 */
import { Component, OnInit, ElementRef, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { FormGroup, FormBuilder, FormArray, Validators } from '@angular/forms';
import { PublicationService } from "../../services/publication.service";
import { PartyService } from "../../services/party.service";
import { LeaderService } from "../../services/leader.service";
import { Inject } from "@angular/core";
import { MatSnackBar } from '@angular/material';
import { PageEvent } from '@angular/material';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";

@Component({
  selector: 'app-publication',
  templateUrl: './publication.component.html',
  styleUrls: ['./publication.component.css']
})
export class PublicationComponent implements OnInit {

  publicationList: any[] = [];
  displayedColumns: string[] = ['media_name', 'article_type', 'inclination_leader', 'inclination_party', 'language', 'edit_publication', 'delete'];

  publicationSwitch: string;
  publicationAccordionSwitch: string;

  // Pagination Variables
  pageNumber: number;
  pageSize: number;
  totalRecords: number;

  constructor(
    private _publication: PublicationService,
    public dialog: MatDialog,
    private fb: FormBuilder,
    public snackBar: MatSnackBar,
    private store: Store<fromStore.State>
  ) {
    this.pageNumber = 1;
    this.pageSize = 10;
  }

  pageEvent(event: PageEvent) {
    this.publicationAccordionSwitch = 'loading';
    this.pageNumber = event.pageIndex + 1;
    this.pageSize = event.pageSize;
    this._publication.getPublicationPaginate(this.pageNumber, this.pageSize).subscribe((publications) => {
      this.publicationList = publications.result;
      this.publicationAccordionSwitch = 'active';
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }


  deletePub(row) {
    this.publicationSwitch = 'loading';
    this._publication.deletePublication({ id: row.id }).subscribe((data) => {
      this.snackBar.open(data.message, 'Close', {
        duration: 1000
      });
      this.ngOnInit();
    });
  }


  ngOnInit() {
    this.publicationSwitch = 'loading';
    this._publication.getPublicationPaginate(this.pageNumber, this.pageSize).subscribe((publications) => {
      console.log(publications);
      this.publicationList = publications.result;
      this.totalRecords = publications.total_records;
      this.publicationSwitch = 'active';
      this.publicationAccordionSwitch = 'active';
    }, (error) => {
      this.publicationSwitch = 'active';
      this.publicationAccordionSwitch = 'active';
    });
  }

  openPublicationDialog(): void {
    const dialogRef = this.dialog.open(DialogContentPublicationDialogComponent, {
      height: '80%',
      width: '80%',
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log(`Publication dialog result: ${result}`);
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

  openEditPublicationDialog(element) {
    const dialogRef = this.dialog.open(DialogContentPublicationEditDialogComponent, {
      height: '80%',
      width: '80%',
      data: { 'toSend': element }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log(`Edit keyword dialog result: ${result}`);
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
  selector: 'app-dialog-content-publication-dialog',
  templateUrl: 'dialog-content-publication.html',
  styleUrls: ['./publication.component.css']
})

export class DialogContentPublicationDialogComponent implements OnInit {

  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#D5DED9' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];

  partyValues: any[] = [];
  leaderValues: any[] = [];

  sentimentScale: any[] = [
    { value: '-1', viewValue: 'Negative', color: '#EF3333' },
    { value: '-0.5', viewValue: 'Slightly negative', color: '#FE6763' },
    { value: '0', viewValue: 'Neutral', color: '#D5DED9' },
    { value: '0.5', viewValue: 'Slightly positive', color: '#88AC76' },
    { value: '1', viewValue: 'Positive', color: '#308446' }
  ];

  languages: any[] = [
    'English', 'Telugu', 'Hindi', 'Oriya', 'Punjabi'
  ];

  submitted = false;
  addPublicationForm: FormGroup;

  /**
   * get the parties values by getter method
   */
  get parties() {
    return this.addPublicationForm.get('parties') as FormArray;
  }

  /**
   * get the leaders values by getter method
   */
  get leaders() {
    return this.addPublicationForm.get('leaders') as FormArray;
  }

  /**
   * get the rss feed values by getter method
   */
  get rss_feed() {
    return this.addPublicationForm.get('rss_feed') as FormArray;
  }

  constructor(
    private _publication: PublicationService,
    private fb: FormBuilder,
    private dialogRef: MatDialogRef<DialogContentPublicationDialogComponent>,
    private _party: PartyService,
    private _leader: LeaderService
  ) {
    this.buildAddPublicationForm();
  }


  ngOnInit() {
    this._party.getParties().subscribe((parties) => {
      console.log(parties);
      this.partyValues = parties.result;
    });

    this._leader.getLeaders().subscribe((leaders) => {
      console.log(leaders);
      this.leaderValues = leaders.result;
    });
  }

  buildAddPublicationForm(): void {
    this.addPublicationForm = this.fb.group({
      'media_name': ['', [
        Validators.required
      ]],
      'article_type': ['', [
        Validators.required
      ]],
      'title_str_name': ['', [
        Validators.required
      ]],
      'author_str_name': ['', [
        Validators.required
      ]],
      'summary_str_name': ['', [
        Validators.required
      ]],
      'link_str_name': ['', [
        Validators.required
      ]],
      'page_content_str': ['', [
        Validators.required
      ]],
      'is_active': [false, [
        Validators.required
      ]],
      'pubdate_str_name': ['', [
        Validators.required
      ]],
      'lang': ['', [
        Validators.required
      ]],
      'author_content_str': ['', [
        Validators.required
      ]],
      'parties': this.fb.array([
        this.createPartyGroup()
      ]),
      'leaders': this.fb.array([
        this.createLeaderGroup()
      ]),
      'rss_feed': this.fb.array([
        this.createFeedGroup()
      ])
    });
    this.addPublicationForm.valueChanges
      .subscribe(data => this.onAddPublicationValueChanged(data));
    this.onAddPublicationValueChanged(); // (re)set validation messages now
  }

  onAddPublicationValueChanged(data?: any) {
    if (!this.addPublicationForm) { return; }
    const form = this.addPublicationForm;
    for (const field in this.addPublicationFormErrors) {
      // clear previous error message (if any)
      this.addPublicationFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.addPublicationFormValidationMessages[field];
        for (const key in control.errors) {
          this.addPublicationFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  addPublicationFormErrors = {
    'media_name': '',
    'article_type': '',
    'title_str_name': '',
    'author_str_name': '',
    'summary_str_name': '',
    'link_str_name': '',
    'page_content_str': '',
    'is_active': '',
    'pubdate_str_name': '',
    'lang': '',
    'author_content_str': ''
  };
  addPublicationFormValidationMessages = {
    'media_name': {
      'required': 'Media Name is required.'
    },
    'is_active': {
      'required': 'Active is required.'
    },
    'article_type': {
      'required': 'Arcticle type is required.'
    },
    'title_str_name': {
      'required': 'Title is required.'
    },
    'author_str_name': {
      'required': 'Auhtor Name is required.'
    },
    'summary_str_name': {
      'required': 'Summary is required.'
    },
    'link_str_name': {
      'required': 'Link is required.'
    },
    'page_content_str': {
      'required': 'Page content is required.'
    },
    'pubdate_str_name': {
      'required': 'Published date is required.'
    },
    'lang': {
      'required': 'Language is required.'
    },
    'author_content_str': {
      'required': 'Auhtor content is required.'
    },
  };

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
   * creates leader group
   * containing leaders drop down and sentiment scale
   */
  createFeedGroup(): FormGroup {
    return this.fb.group({
      'feedlink': ['', [
        Validators.required
      ]],
      'active': [false, [
        Validators.required
      ]],
      'feedcat': ['', [
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
   * Add Feed
   */
  addFeed(): void {
    this.rss_feed.push(this.createFeedGroup());
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
   * Remove Leader Group
   */
  removeFeedGroup(index: number) {
    this.rss_feed.removeAt(index);
  }

  onAddPublicationSubmit() {
    this.submitted = true;
    // make a deep copy of the input items
    console.log(this.addPublicationForm.value);
    const formModel = this.addPublicationForm.value;
    formModel.rss_feed.forEach((feed) => {
      feed.active = feed.active ? '1' : '0';
    });
    console.log(formModel.rss_feed);
    formModel.rss_feed = JSON.stringify(formModel.rss_feed);
    formModel.parties = JSON.stringify(formModel.parties);
    formModel.leaders = JSON.stringify(formModel.leaders);
    this._publication.addPublication(formModel).subscribe(
      (data) => {
        console.log('ADD KEYWORD DATA', data);
        if (data.status) {
          // close the dialog
          this.dialogRef.close(data.message);
        } else {
          // Error Handling
          this.dialogRef.close('Error while adding keyword');
        }
      }
    );
  }

}

@Component({
  selector: 'app-dialog-content-publication-edit-dialog',
  templateUrl: 'dialog-content-publication-edit.html',
  styleUrls: ['./publication.component.css']
})

export class DialogContentPublicationEditDialogComponent implements OnInit {

  availableColors: any[] = [
    { name: 'negative', color: '#EF3333' },
    { name: 'slightly negative', color: '#FE6763' },
    { name: 'neutral', color: '#D5DED9' },
    { name: 'slightly positive', color: '#88AC76' },
    { name: 'positive', color: '#308446' }
  ];

  partyValues: any[] = [];
  leaderValues: any[] = [];
  editFormData: any;

  sentimentScale: any[] = [
    { value: '-1', viewValue: 'Negative', color: '#EF3333' },
    { value: '-0.5', viewValue: 'Slightly negative', color: '#FE6763' },
    { value: '0', viewValue: 'Neutral', color: '#D5DED9' },
    { value: '0.5', viewValue: 'Slightly positive', color: '#88AC76' },
    { value: '1', viewValue: 'Positive', color: '#308446' }
  ];

  languages: any[] = [
    'English', 'Telugu', 'Hindi', 'Oriya', 'Punjabi'
  ];

  submitted = false;
  editPublicationForm: FormGroup;
  user: any;

  /**
   * get the parties values by getter method
   */
  get parties() {
    return this.editPublicationForm.get('parties') as FormArray;
  }

  /**
   * get the leaders values by getter method
   */
  get leaders() {
    return this.editPublicationForm.get('leaders') as FormArray;
  }

  /**
   * get the rss feed values by getter method
   */
  get rss_feed() {
    return this.editPublicationForm.get('rss_feed') as FormArray;
  }

  constructor(
    private _publication: PublicationService,
    private fb: FormBuilder,
    private dialogRef: MatDialogRef<DialogContentPublicationEditDialogComponent>,
    @Inject(MAT_DIALOG_DATA) data,
    private _party: PartyService,
    private _leader: LeaderService,
    private store: Store<fromStore.State>
  ) {
    console.log('To dialog', data);
    this.editFormData = data.toSend;
    this.buildEditPublicationForm();
    this.patchEditPublicationForm();
  }

  ngOnInit() {
    this._party.getParties().subscribe((parties) => {
      console.log(parties);
      this.partyValues = parties.result;
    });

    this._leader.getLeaders().subscribe((leaders) => {
      console.log(leaders);
      this.leaderValues = leaders.result;
    });

    this.store.select(fromStore.selectAuthUser).subscribe((data) => {
      if (data !== null) {
        this.user = data.user;
      }
    });
  }


  patchEditPublicationForm(): void {
    this.editPublicationForm.patchValue({
      media_name: this.editFormData.media_name,
      article_type: this.editFormData.article_type,
      title_str_name: this.editFormData.title_str_name,
      author_str_name: this.editFormData.author_str_name,
      summary_str_name: this.editFormData.summary_str_name,
      link_str_name: this.editFormData.link_str_name,
      page_content_str: this.editFormData.page_content_str,
      is_active: this.editFormData.is_active ? '1' : '0',
      pubdate_str_name: this.editFormData.pubdate_str_name,
      lang: this.editFormData.language,
      author_content_str: this.editFormData.author_content_str
    });
    this.setEditPublicationParties();
    this.setEditPublicationLeaders();
    this.setEditPublicationFeed();
  }

  /**
   * @author victor
   * Patching the selecting parties selected before
   * Higher end angular programming!
   * You are welcome bitch!
   */
  setEditPublicationParties(): void {
    const control = <FormArray>this.editPublicationForm.controls.parties;
    this.editFormData.inclination_party.forEach((party) => {
      const sentiment = party.sentiment.replace(/\s/g, "");
      console.log(sentiment);
      control.push(this.fb.group({
        party: party.party,
        sentiment: sentiment
      }));
    });
  }

  setEditPublicationLeaders(): void {
    const control = <FormArray>this.editPublicationForm.controls.leaders;
    this.editFormData.inclination_leader.forEach((leader) => {
      const sentiment = leader.sentiment.replace(/\s/g, "");
      console.log(sentiment);
      control.push(this.fb.group({
        leader: leader.leader,
        sentiment: sentiment
      }));
    });
  }

  setEditPublicationFeed(): void {
    const control = <FormArray>this.editPublicationForm.controls.rss_feed;
    this.editFormData.rss_feed.forEach((feed) => {
      control.push(this.fb.group({
        feedlink: feed.feedlink,
        active: feed.active ? '1' : '0',
        feedcat: feed.feedname
      }));
    });
  }

  buildEditPublicationForm(): void {
    this.editPublicationForm = this.fb.group({
      'media_name': ['', [
        Validators.required
      ]],
      'article_type': ['', [
        Validators.required
      ]],
      'title_str_name': ['', [
        Validators.required
      ]],
      'author_str_name': ['', [
        Validators.required
      ]],
      'summary_str_name': ['', [
        Validators.required
      ]],
      'link_str_name': ['', [
        Validators.required
      ]],
      'page_content_str': ['', [
        Validators.required
      ]],
      'is_active': [false, [
        Validators.required
      ]],
      'pubdate_str_name': ['', [
        Validators.required
      ]],
      'lang': ['', [
        Validators.required
      ]],
      'author_content_str': ['', [
        Validators.required
      ]],
      'parties': this.fb.array([
        // this.createPartyGroup()
      ]),
      'leaders': this.fb.array([
        // this.createLeaderGroup()
      ]),
      'rss_feed': this.fb.array([
        // this.createFeedGroup()
      ])
    });
    this.editPublicationForm.valueChanges
      .subscribe(data => this.onEditPublicationValueChanged(data));
    this.onEditPublicationValueChanged(); // (re)set validation messages now
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
   * creates leader group
   * containing leaders drop down and sentiment scale
   */
  createFeedGroup(): FormGroup {
    return this.fb.group({
      'feedlink': ['', [
        Validators.required
      ]],
      'active': [false, [
        Validators.required
      ]],
      'feedcat': ['', [
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
   * Add Feed
   */
  addFeed(): void {
    this.rss_feed.push(this.createFeedGroup());
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
   * Remove Leader Group
   */
  removeFeedGroup(index: number) {
    this.rss_feed.removeAt(index);
  }

  onEditPublicationValueChanged(data?: any) {
    if (!this.editPublicationForm) { return; }
    const form = this.editPublicationForm;
    for (const field in this.editPublicationFormErrors) {
      // clear previous error message (if any)
      this.editPublicationFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.editPublicationFormValidationMessages[field];
        for (const key in control.errors) {
          this.editPublicationFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  editPublicationFormErrors = {
    'media_name': '',
    'article_type': '',
    'title_str_name': '',
    'author_str_name': '',
    'summary_str_name': '',
    'link_str_name': '',
    'page_content_str': '',
    'is_active': '',
    'pubdate_str_name': '',
    'lang': '',
    'author_content_str': ''
  };
  editPublicationFormValidationMessages = {
    'media_name': {
      'required': 'Media Name is required.'
    },
    'is_active': {
      'required': 'Active is required.'
    },
    'article_type': {
      'required': 'Arcticle type is required.'
    },
    'title_str_name': {
      'required': 'Title is required.'
    },
    'author_str_name': {
      'required': 'Auhtor Name is required.'
    },
    'summary_str_name': {
      'required': 'Summary is required.'
    },
    'link_str_name': {
      'required': 'Link is required.'
    },
    'page_content_str': {
      'required': 'Page content is required.'
    },
    'pubdate_str_name': {
      'required': 'Published date is required.'
    },
    'lang': {
      'required': 'Language is required.'
    },
    'author_content_str': {
      'required': 'Auhtor content is required.'
    },
  };

  onEditPublicationSubmit() {
    this.submitted = true;
    // make a deep copy of the input items
    console.log(this.editPublicationForm.value);
    const formModel = this.editPublicationForm.value;
    formModel.id = this.editFormData.id;
    formModel.parties = JSON.stringify(formModel.parties);
    formModel.leaders = JSON.stringify(formModel.leaders);
    formModel.rss_feed = JSON.stringify(formModel.rss_feed);
    console.log('After Modification', formModel);
    this._publication.editPublication(formModel).subscribe(
      (data) => {
        console.log('Edit PUBLICATION DATA', data);
        if (data.status) {
          // close the dialog
          this.dialogRef.close(data.message);
        } else {
          // Error Handling
          this.dialogRef.close('Error while editing publication');
        }
      }
    );
  }

}
