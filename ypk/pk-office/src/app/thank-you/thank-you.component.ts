import { Component, OnInit } from '@angular/core';
import { Router, NavigationEnd } from '@angular/router';

@Component({
  selector: 'app-thank-you',
  templateUrl: './thank-you.component.html',
  styleUrls: ['./thank-you.component.css']
})
export class ThankYouComponent implements OnInit {

  constructor(
    private router: Router
  ) {
    // this.router.events.subscribe(event => {
    //   if (event instanceof NavigationEnd) {
    //     (<any>window).ga('set', 'page', event.urlAfterRedirects);
    //     (<any>window).ga('send', 'pageview');
    //   }
    // });
  }

  ngOnInit() {
  }

}
