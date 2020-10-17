"""
This file demonstrates writing tests using the unittest module. These will pass
when you run "manage.py test".

Replace this with more appropriate tests for your application.
"""

from django.test import TestCase
from django_cron import CronJobBase, Schedule
from api.views import emailapi
from api.views import scrape_rss
from api.views import logwrite1
# from api.views import logwrite2

class scrapecron(CronJobBase):
    RUN_EVERY_MINS = 720
    schedule = Schedule(run_every_mins=RUN_EVERY_MINS)
    code = scrape_rss    # a unique code
    def do(self):
        pass

class emailcron(CronJobBase):
    RUN_EVERY_MINS = 15
    schedule = Schedule(run_every_mins=RUN_EVERY_MINS)
    code = emailapi    # a unique code
    def do(self):
        pass

class logcron(CronJobBase):
    RUN_EVERY_MINS = 1            # ignore this line
    schedule = Schedule(run_every_mins=RUN_EVERY_MINS) # ignore this line
    code = logwrite1    # a unique code
    def do(self):
        pass
