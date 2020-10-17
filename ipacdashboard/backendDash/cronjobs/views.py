# Create your views here.

from django_cron import CronJobBase, Schedule
from api import scrape_rss
from social import social_scrape
from social import posts_cron

# class MediaScanCron(CronJobBase):
#     RUN_EVERY_MINS = 720
#     schedule = Schedule(run_every_mins=RUN_EVERY_MINS)
#     code = scrape_rss    # a unique code
#     def do(self):
#         pass

class SocialMediaCron(CronJobBase):
    RUN_EVERY_MINS = 1440
    schedule = Schedule(run_every_mins=RUN_EVERY_MINS)
    code = social_scrape    # a unique code
    def do(self):
        pass

# class SocialCron(CronJobBase):
#     RUN_EVERY_MINS = 1440
#     schedule = Schedule(run_every_mins=RUN_EVERY_MINS)
#     code = posts_cron    # a unique code
#     def do(self):
#         pass


# To Run All Cron Jobs Once
# python manage.py runcrons

# To run a specific cron
# python manage.py runcrons cron_class ...




# crontab -e
# */5 * * * * source /home/ipactesting/.bashrc && source /home/ipactesting/public_html/dbackend/VE2710/bin/activate && python /home/ipactesting/public_html/dbackend/comdash/manage.py runcrons > /home/ipactesting/cronjob.log
# */5 * * * * source /home/akshay/.bashrc && source /home/akshay/Desktop/prodash/bin/activate && python /home/akshay/Desktop/prodash/comdash/manage.py runcrons > /home/akshay/Desktop/prodash/cronjob.log


# 5 */12 * * * source /home/ipactesting/.bashrc && source /home/ipactesting/public_html/dbackend/VE2710/bin/activate && python /home/ipactesting/public_html/dbackend/comdash/manage.py runcrons "cronjobs.tests.scrapecron"> /home/ipactesting/cronjob.log
# 5 */1 * * * source /home/ipactesting/.bashrc && source /home/ipactesting/public_html/dbackend/VE2710/bin/activate && python /home/ipactesting/public_html/dbackend/comdash/manage.py runcrons "cronjobs.views.logcron"> /home/ipactesting/cronjob.log



