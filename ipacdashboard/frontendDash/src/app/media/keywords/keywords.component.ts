/**
 * @author Victor
 * Component for keyword Management
 */
import {
  Component,
  OnInit,
  ElementRef,
  ViewChild
} from '@angular/core';
import {
  MatDialog,
  MatDialogRef,
  MAT_DIALOG_DATA
} from '@angular/material';
import {
  FormGroup,
  FormBuilder,
  Validators
} from '@angular/forms';
import { KeywordService } from "../../services/keyword.service";
import { Inject } from "@angular/core";
import { MatSnackBar } from '@angular/material';
import {
  COMMA,
  ENTER
} from '@angular/cdk/keycodes';
import {
  MatAutocompleteSelectedEvent,
  MatChipInputEvent
} from '@angular/material';
import { Observable } from 'rxjs';
import {
  map,
  startWith
} from 'rxjs/operators';
import { PageEvent } from '@angular/material';
import { Store } from "@ngrx/store";
import * as fromStore from '../../reducers';
import { LogoutConfirmed } from "../../actions/auth.actions";

@Component({
  selector: 'app-keywords',
  templateUrl: './keywords.component.html',
  styleUrls: ['./keywords.component.css']
})
export class KeywordsComponent implements OnInit {

  keyWordList: any[] = [];
  displayedColumns: string[] = ['keyword', 'synonyms', 'is_active', 'keyword_type', 'edit_keyword', 'delete_keyword'];
  keyWordSwitch: string;
  keywordAccordionSwitch: string;

  // Pagination Variables
  pageNumber: number;
  pageSize: number;
  totalRecords: number;


  constructor(
    private _keyword: KeywordService,
    public dialog: MatDialog,
    private fb: FormBuilder,
    public snackBar: MatSnackBar,
    private store: Store<fromStore.State>
  ) {
    this.pageNumber = 1;
    this.pageSize = 10;
  }

  pageEvent(event: PageEvent) {
    this.keywordAccordionSwitch = 'loading';
    this.pageNumber = event.pageIndex + 1;
    this.pageSize = event.pageSize;
    this._keyword.getKeyWord(this.pageNumber, this.pageSize).subscribe((keywords) => {
      this.keyWordList = keywords.result;
      this.keywordAccordionSwitch = 'active';
    });
  }

  logout() {
    this.store.dispatch(new LogoutConfirmed());
  }

  ngOnInit() {
    this.keyWordSwitch = 'loading';
    this._keyword.getKeyWord(this.pageNumber, this.pageSize).subscribe((keywords) => {
      console.log(keywords);
      this.keyWordList = keywords.result;
      this.totalRecords = keywords.total_records;
      this.keyWordSwitch = 'active';
      this.keywordAccordionSwitch = 'active';
    });
  }

  openKeywordDialog(): void {
    const dialogRef = this.dialog.open(DialogContentKeyWordDialogComponent, {
      height: '80%',
      width: '80%',
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log(`KeyWord Dialog result: ${result}`);
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

  openEditKeyWordDialog(element) {
    const dialogRef = this.dialog.open(DialogContentKeyWordEditDialogComponent, {
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

  deleteKeyWord(keyword) {
    this.keyWordSwitch = 'loading';
    this._keyword.deleteKeyword(keyword).subscribe(
      (data) => {
        console.log('DELETED KEYWORD DATA', data);
        if (data.status) {
          // close the dialog
          this.snackBar.open(data.message, 'Close', {
            duration: 3000
          });
          this.ngOnInit();
        } else {
          // Error Handling
          this.snackBar.open('Error while deleting keyword', 'Close', {
            duration: 3000
          });
          this.keyWordSwitch = 'active';
        }
      }
    );
  }

}

@Component({
  selector: 'app-dialog-content-keyword-dialog',
  templateUrl: 'dialog-content-keyword.html',
  styleUrls: ['./keywords.component.css']
})

export class DialogContentKeyWordDialogComponent implements OnInit {

  keyWordTypes: any[] = [
    { value: 'Leader', viewValue: 'Leader' },
    { value: 'Party', viewValue: 'Party' },
    { value: 'Campaign', viewValue: 'Campaign' },
    { value: 'Others', viewValue: 'Others' }
  ];

  submitted = false;
  addKeywordForm: FormGroup;
  visible = true;
  selectable = true;
  removable = true;
  addOnBlur = false;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  filteredSynonyms: Observable<string[]>;
  synonyms: string[] = [];
  allSynonyms: string[] = [];
  apiCall = false;

  @ViewChild('synonymsInput') synonymsInput: ElementRef<HTMLInputElement>;

  constructor(
    private _keyword: KeywordService,
    private fb: FormBuilder,
    private dialogRef: MatDialogRef<DialogContentKeyWordDialogComponent>
  ) {
    this.buildAddKeyWordForm();
    this.filteredSynonyms = this.addKeywordForm.controls['synonyms'].valueChanges.pipe(
      startWith(null),
      map((synonym: string | null) => synonym ? this._filter(synonym) : this.allSynonyms.slice()));
  }

  add(event: MatChipInputEvent): void {
    const input = event.input;
    const value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.synonyms.push(value.trim());
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }

    this.addKeywordForm.controls['synonyms'].setValue(null);
  }

  remove(fruit: string): void {
    const index = this.synonyms.indexOf(fruit);

    if (index >= 0) {
      this.synonyms.splice(index, 1);
    }
  }

  selected(event: MatAutocompleteSelectedEvent): void {
    this.synonyms.push(event.option.viewValue);
    this.synonymsInput.nativeElement.value = '';
    this.addKeywordForm.controls['synonyms'].setValue(null);
  }

  private _filter(value: string): string[] {
    const filterValue = value.toLowerCase();

    return this.allSynonyms.filter(synonym => synonym.toLowerCase().indexOf(filterValue) === 0);
  }


  ngOnInit() { }

  buildAddKeyWordForm(): void {
    this.addKeywordForm = this.fb.group({
      'keyword': ['', [
        Validators.required
      ]],
      'synonyms': ['', []],
      'is_active': [false, [
        Validators.required
      ]],
      'keyword_type': ['', [
        Validators.required
      ]]
    });
    this.addKeywordForm.valueChanges
      .subscribe(data => this.onAddKeyWordValueChanged(data));
    this.onAddKeyWordValueChanged(); // (re)set validation messages now
  }

  onAddKeyWordValueChanged(data?: any) {
    if (!this.addKeywordForm) { return; }
    const form = this.addKeywordForm;
    for (const field in this.addKeyWordFormErrors) {
      // clear previous error message (if any)
      this.addKeyWordFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.addKeyWordFormValidationMessages[field];
        for (const key in control.errors) {
          this.addKeyWordFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  addKeyWordFormErrors = {
    'keyword': '',
    'is_active': '',
    'keyword_type': ''
  };
  addKeyWordFormValidationMessages = {
    'keyword': {
      'required': 'Keyword is required.'
    },
    'is_active': {
      'required': 'Active is required.'
    },
    'keyword_type': {
      'required': 'Keyword type is required.'
    }
  };

  onAddKeyWordSubmit() {
    this.apiCall = true;
    this.submitted = true;
    // make a deep copy of the input items
    console.log(this.addKeywordForm.value);
    const formModel = this.addKeywordForm.value;
    const synonymRequestPayloadArray: Array<{ synonym: string }> = [];
    this.synonyms.forEach((synonym) => {
      synonymRequestPayloadArray.push(<{ synonym: string }>{ synonym: synonym });
    });
    formModel.synonyms = JSON.stringify(synonymRequestPayloadArray);
    console.log('After Modification', formModel);
    this._keyword.addKeyWord(formModel).subscribe(
      (data) => {
        console.log('ADD KEYWORD DATA', data);
        if (data.status) {
          // close the dialog
          this.dialogRef.close(data.message);
          this.apiCall = false;
        } else {
          // Error Handling
          this.dialogRef.close('Error while adding keyword');
          this.apiCall = false;
        }
      }
    );
  }

}

@Component({
  selector: 'app-dialog-content-keyword-edit-dialog',
  templateUrl: 'dialog-content-keyword-edit.html',
  styleUrls: ['./keywords.component.css']
})

export class DialogContentKeyWordEditDialogComponent implements OnInit {

  keyWordTypes: any[] = [
    { value: 'Leader', viewValue: 'Leader' },
    { value: 'Party', viewValue: 'Party' },
    { value: 'Campaign', viewValue: 'Campaign' },
    { value: 'Others', viewValue: 'Others' }
  ];
  submitted = false;
  editKeywordForm: FormGroup;
  editFormData: any;
  visible = true;
  selectable = true;
  removable = true;
  addOnBlur = false;
  separatorKeysCodes: number[] = [ENTER, COMMA];
  filteredSynonyms: Observable<string[]>;
  synonyms: string[] = [];
  allSynonyms: string[] = [];
  apiCall = false;
  diameter = 10;
  strokeWidth = 5;

  @ViewChild('synonymsInput') synonymsInput: ElementRef<HTMLInputElement>;

  constructor(
    private _keyword: KeywordService,
    private fb: FormBuilder,
    private dialogRef: MatDialogRef<DialogContentKeyWordEditDialogComponent>,
    @Inject(MAT_DIALOG_DATA) data
  ) {
    console.log('To dialog', data);
    this.editFormData = data.toSend;
    this.buildEditKeyWordForm();
    this.patchEditKeyWordForm();
    this.filteredSynonyms = this.editKeywordForm.controls['synonyms'].valueChanges.pipe(
      startWith(null),
      map((synonym: string | null) => synonym ? this._filter(synonym) : this.allSynonyms.slice()));
  }

  add(event: MatChipInputEvent): void {
    const input = event.input;
    const value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.synonyms.push(value.trim());
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }

    this.editKeywordForm.controls['synonyms'].setValue(null);
  }

  remove(synonym: string): void {
    const index = this.synonyms.indexOf(synonym);

    if (index >= 0) {
      this.synonyms.splice(index, 1);
    }
  }

  selected(event: MatAutocompleteSelectedEvent): void {
    this.synonyms.push(event.option.viewValue);
    this.synonymsInput.nativeElement.value = '';
    this.editKeywordForm.controls['synonyms'].setValue(null);
  }

  private _filter(value: string): string[] {
    const filterValue = value.toLowerCase();

    return this.allSynonyms.filter(synonym => synonym.toLowerCase().indexOf(filterValue) === 0);
  }

  ngOnInit() {
  }
  patchEditKeyWordForm(): void {
    this.editKeywordForm.patchValue({
      keyword: this.editFormData.keyword,
      is_active: this.editFormData.is_active,
      keyword_type: this.editFormData.keyword_type
    });
    this.synonyms = this.editFormData.synonyms;
  }

  buildEditKeyWordForm(): void {
    this.editKeywordForm = this.fb.group({
      'keyword': ['', [
        Validators.required
      ]],
      'synonyms': ['', []],
      'is_active': [false, [
        Validators.required
      ]],
      'keyword_type': ['', [
        Validators.required
      ]]
    });
    this.editKeywordForm.valueChanges
      .subscribe(data => this.onEditKeyWordValueChanged(data));
    this.onEditKeyWordValueChanged(); // (re)set validation messages now
  }

  onEditKeyWordValueChanged(data?: any) {
    if (!this.editKeywordForm) { return; }
    const form = this.editKeywordForm;
    for (const field in this.editKeyWordFormErrors) {
      // clear previous error message (if any)
      this.editKeyWordFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.editKeyWordFormValidationMessages[field];
        for (const key in control.errors) {
          this.editKeyWordFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  editKeyWordFormErrors = {
    'keyword': '',
    'is_active': '',
    'keyword_type': ''
  };
  editKeyWordFormValidationMessages = {
    'keyword': {
      'required': 'Keyword is required.'
    },
    'is_active': {
      'required': 'Active is required.'
    },
    'keyword_type': {
      'required': 'Keyword type is required.'
    }
  };

  onEditKeyWordSubmit() {
    this.apiCall = true;
    this.submitted = true;
    // make a deep copy of the input items
    console.log(this.editKeywordForm.value);
    const formModel = this.editKeywordForm.value;
    formModel.id = this.editFormData.id;
    const synonymRequestPayloadArray: Array<{ synonym: string }> = [];
    this.synonyms.forEach((synonym) => {
      synonymRequestPayloadArray.push(<{ synonym: string }>{ synonym: synonym });
    });
    formModel.synonyms = JSON.stringify(synonymRequestPayloadArray);
    console.log('After Modification', formModel);
    this._keyword.editKeyWord(formModel).subscribe(
      (data) => {
        console.log('Edit KEYWORD DATA', data);
        if (data.status) {
          // close the dialog
          this.dialogRef.close(data.message);
          this.apiCall = false;
        } else {
          // Error Handling
          this.dialogRef.close('Error while editing keyword');
          this.apiCall = false;
        }
      }
    );
  }

}
