/**
 * @author Victor
 * Form for surveying people who wants to be in prashant kishor team
 */
import { Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  FormArray,
  Validators
} from '@angular/forms';
import { JoinPkService } from '../join-pk.service';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MONTHS } from '../app.constant';
import { MatCheckboxModule } from '@angular/material/checkbox';

@Component({
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.css']
})
export class FormComponent implements OnInit {

  @ViewChild('inputEl') public inputEl: ElementRef;
  phoneChecked = false;
  public show = true;
  public show1 = false;
  whatsappDisable = false;
  emailpattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  /**
   * add news form errors
   */
  surveyFormErrors = {
    'email': '',
    'phone': '',
    'whatsapp': '',
    'fullname': '',
    'gender': '',
    'state': '',
    'district': '',
    'university': '',
    'ages': '',
    'living': '',
    'studies': '',
    'college': '',
    'profession': '',
    'partyworkers': '',
    'parties': '',
    'positioninparties': '',
    'message': '',
    'terms': '',
  };

  /**
   * Validation messages for the input fields
   */
  surveyFormValidationMessages = {
    'email': {
      'pattern': 'अवैध ईमेल'
    },
    'phone': {
      'required': 'यह फ़ील्ड आवश्यक है',
      'minlength': '10 अंक आवश्यक है',
      'maxlength': '10 अंक आवश्यक है'
    },
    'whatsapp': {
      'required': 'यह फ़ील्ड आवश्यक है',
      'minlength': '10 अंक आवश्यक है',
      'maxlength': '10 अंक आवश्यक है'
    },
    'fullname': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'gender': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'state': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'district': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'college': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'ages': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'living': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'studies': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'profession': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'partyworkers': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'parties': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'positioninparties': {
      'required': 'यह फ़ील्ड आवश्यक है'
    },
    'terms': {
      'required': 'यह फ़ील्ड आवश्यक है'
    }
  };
  professions: any[] = [];
  states: any[] = [];
  districts: any[] = [];
  blocks: any[] = [];
  acs: any[] = [];
  surveyForm: FormGroup;
  selectedGender: string;

  genders: any[] = [
    { value: 'Male', viewValue: 'पुरुष (Male)' },
    { value: 'Female', viewValue: 'महिला (Female)' },
    { value: 'Others', viewValue: 'अन्य (Others)' }
  ];

  livingPlace: string;
  places: { value: string, viewValue: string }[] = [{ value: 'Rural', viewValue: 'गाँव (Rural)' }, { value: 'Urban', viewValue: 'शहर (Urban)' }];

  partyworkers: any[] = [{ value: 'Yes', viewValue: 'हाँ  (Yes)' }, { value: 'No', viewValue: 'नहीं  (No)' }];
  parties: string[] = ['BJP', 'Congress', 'JD(U)', 'RJD', 'LJP', 'RLSP', 'HAM', 'SP', 'BSP', 'others'];
  positioninparties: any[] = [{ value: 'District President', viewValue: 'जिला अध्यक्ष (District President)'}, { value: 'District Vice President', viewValue: 'जिला उपाध्यक्ष (District Vice President)'}, {value: 'District Secretary', viewValue: 'जिला सचिव (District Secretary)'}, {value: 'District General Secretary', viewValue: 'जिला महासचिव (District General Secretary)'}, {value: 'Block President', viewValue: 'ब्लॉक/ खंड/ प्रखंड अध्यक्ष (Block President)'}, {value: 'Block Vice President', viewValue: 'ब्लॉक/ खंड/ प्रखंड उपाध्यक्ष (Block Vice President)'}, {value: 'Block Secretary', viewValue: 'ब्लॉक/ खंड/ प्रखंड सचिव (Block Secretary)'}, {value: 'Block General Secretary', viewValue: 'ब्लॉक/ खंड/ प्रखंड महासचिव (Block General Secretary)'}, {value: 'District President - Frontals', viewValue: 'जिलाध्यक्ष प्रकोष्ट (District President - Frontals)'}, {value: 'District Vice President - Frontals', viewValue: 'जिला उपाध्यक्ष प्रकोष्ट (District Vice President - Frontals)'}, {value: 'District Secretary - Frontals', viewValue: 'जिला सचिव प्रकोष्ट (District Secretary - Frontals)'}, {value: 'Media Cell', viewValue: 'मीडीया सेल (Media Cell)'}, {value: 'Booth Worker', viewValue: 'बूथ कार्यकर्ता (Booth Worker)'}, {value: 'Any Other', viewValue: 'अन्य (Any Other)'}];
  EduQualification: string;
  studies: any[] = [{ value: 'Below 10th Standard', viewValue: '10वी कक्षा के नीचे (Below 10th Standard)' }, { value: '10th Standard', viewValue: '10वी कक्षा तक (10th Standard)' }, { value: '12th Standard', viewValue: '12वी कक्षा तक (12th Standard)' }, { value: 'Graduate', viewValue: 'ग्रेजुएट (Graduate)' }, { value: 'Post Graduate', viewValue: 'पोस्ट ग्रेजुएट (Post Graduate)' }];

  ages: number[] = this.fillYears();
  partyDisable = false;
  positioninpartyDisable = false;

  constructor(
    public fb: FormBuilder,
    private service: JoinPkService,
    private router: Router,
    private _snackbar: MatSnackBar,
    public dialog: MatDialog
  ) {
    this.buildSurveyForm();
    this.surveyForm.controls['partyworkers'].valueChanges.subscribe((data) => {
      console.log(data);
      if (data === 'No') {
        this.surveyForm.controls['parties'].disable();
        this.surveyForm.get('parties').clearAsyncValidators();
      } else {
        this.surveyForm.controls['parties'].enable();
      }
    });

    this.surveyForm.controls['state'].valueChanges.subscribe((data) => {
      console.log(data);
      /* if (data === 'Bihar') {
         this.surveyForm.controls['mandal'].enable();
         this.show = true;
       } else {
         // this.surveyForm.controls['mandal'].disable();
         this.show = false;
         this.surveyForm.controls['mandal'].clearAsyncValidators();
       }*/
    });

    this.surveyForm.controls['profession'].valueChanges.subscribe((data) => {
      console.log(data);
      if (data === 'Student') {
        this.show1 = true;
      } else {
        this.show1 = false;
        console.log('required hat na chiye')
        // this.surveyForm.controls['college'].clearAsyncValidators();
        this.surveyForm.get('college').clearValidators();
        this.surveyForm.get('college').updateValueAndValidity();
      }
    });

    this.surveyForm.controls['partyworkers'].valueChanges.subscribe((data) => {
      console.log(data);
      if (data === 'Yes') {
        this.partyDisable = true;
      } else {
        this.partyDisable = false;
        // console.log('required hat na chiye')
        // this.surveyForm.controls['college'].clearAsyncValidators();
        this.surveyForm.get('parties').clearValidators();
        this.surveyForm.get('parties').updateValueAndValidity();
      }
    });

    this.surveyForm.controls['parties'].valueChanges.subscribe((data) => {
      console.log(data);
      if (data != '') {
        this.positioninpartyDisable = true;
      } else {
        this.positioninpartyDisable = false;
        // console.log('required hat na chiye')
        // this.surveyForm.controls['college'].clearAsyncValidators();
        this.surveyForm.get('positioninparties').clearValidators();
        this.surveyForm.get('positioninparties').updateValueAndValidity();
      }
    });

    this.surveyForm.controls['phone'].valueChanges.subscribe((data) => {
      if (this.phoneChecked) {
        this.surveyForm.controls['whatsapp'].patchValue(data);
      } else {
        return;
      }
    });

  }
  
  phoneexists(event){
    //console.log(event.length);
    if(event.length == 10){
      console.log(event.length);
      let phoneobj = {
        x: event,
        y: this.surveyForm.controls['fullname'].value
      }
      this.service.addincompleteRecord(phoneobj).subscribe((data) => {
        console.log(data);
        if (data === 'success') {
          //window.location.href = 'https://www.youthinpolitics.in/thankyou.html';
        } else {
          this._snackbar.open('Phone number already exists', 'close', {
            duration: 2000
          });
        }
      });
    }
  }

  fillYears(): number[] {
    const ages = [];
    for (let i = 18; i <= 100; i++) {
      ages.push(i);
    }
    return ages;
  }

  ngOnInit() {
    this.service.getStates().subscribe((data) => {
      console.log(data);
      this.states = data;
    });

    this.service.getProfession().subscribe((data) => {
      console.log(data);
      this.professions = data;
    });
  }

  fetchdistricts(event) {
    this.service.getdistricts(event.value).subscribe((data) => {
      this.districts = data;
    });
  }

  fetchblocks(event) {
    this.service.getblocks(event.value).subscribe((data) => {
      this.blocks = data;
    });

    const state = this.surveyForm.controls['state'].value;

    this.service.getacs({ district: event.value, state: state }).subscribe((data) => {
      this.acs = data;
    });
  }

  onsurveyFormSubmit() {
    this.service.addRecord(this.surveyForm.value).subscribe((data) => {
      console.log(data);
      if (data === 'success') {
        window.location.href = 'https://www.youthinpolitics.in/thankyou.html';
      } else {
        this._snackbar.open('Phone number already exists', 'close', {
          duration: 2000
        });
      }
    });
  }

  openDialog(): void {
    const dialogRef = this.dialog.open(DialogOverviewExampleDialogComponent, {
      width: '650px',
      height: '450px'
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
    });
  }

  /**
   * Construction of add news form
   */
  public buildSurveyForm() {
    this.surveyForm = this.fb.group({
      'email': ['', [
        Validators.pattern(this.emailpattern)
      ]],
      'phone': ['', [
        Validators.required,
        Validators.maxLength(10),
        Validators.minLength(10)
      ]],
      'whatsapp': ['', [
        Validators.required,
        Validators.maxLength(10),
        Validators.minLength(10)
      ]],
      'fullname': ['', [
        Validators.required
      ]],
      'gender': ['', [
        Validators.required
      ]],
      'state': ['', [
        Validators.required
      ]],
      'district': ['', [
        Validators.required
      ]],
      'university': ['', [

      ]],
      'ages': ['', [
        Validators.required
      ]],
      'living': ['', [
        Validators.required
      ]],
      'studies': ['', [
        Validators.required
      ]],
      'college': ['', [
        Validators.required
      ]],
      'profession': ['', [
        Validators.required
      ]],
      'partyworkers': ['', [
        Validators.required
      ]],
      'parties': ['', [
        Validators.required
      ]],
      'positioninparties': ['', [
        Validators.required
      ]],
      'terms': [false, [
        Validators.required
      ]],
      'message': ['', [

      ]]
    });

    this.surveyForm.valueChanges
      .subscribe(data => this.onsurveyFormValueChanged(data));
    this.onsurveyFormValueChanged(); // (re)set validation messages now
  }

  /**
   * When Form Value changes
   * @param data any
   */
  onsurveyFormValueChanged(data?: any) {
    if (!this.surveyForm) { return; }
    const form = this.surveyForm;
    for (const field in this.surveyFormErrors) {
      // clear previous error message (if any)
      this.surveyFormErrors[field] = '';
      const control = form.get(field);
      if (control && control.dirty && !control.valid) {
        const messages = this.surveyFormValidationMessages[field];
        for (const key in control.errors) {
          this.surveyFormErrors[field] += messages[key] + ' ';
        }
      }
    }
  }

  checkWhatsapp(event) {
    if (event.checked) {
      this.surveyForm.controls['whatsapp'].patchValue(this.surveyForm.value.phone);
      // this.surveyForm.get('whatsapp').disable();
      this.inputEl.nativeElement.disabled = true;
      this.phoneChecked = true;
      return;
    } else {
      this.surveyForm.controls['whatsapp'].patchValue('');
      // this.surveyForm.get('whatsapp').enable();
      this.inputEl.nativeElement.disabled = false;
      this.phoneChecked = false;
      return;
    }
  }
}

@Component({
  selector: 'app-dialog-overview-example-dialog',
  templateUrl: 'dialog-overview-example-dialog.html',
  styleUrls: ['./form.component.css']
})
export class DialogOverviewExampleDialogComponent {

  constructor(
    public dialogRef: MatDialogRef<DialogOverviewExampleDialogComponent>) { }

  onNoClick(): void {
    this.dialogRef.close();
  }

}
