from django.db import models
from djangotoolbox.fields import DictField, ListField
from datetime import datetime, timedelta
import requests

# Create your models here.

class App(models.Model):
  name = models.CharField(max_length=80)
  client_id = models.CharField(max_length=32)
  client_secret = models.CharField(max_length=256)

  def __str__(self):
    return self.name

class User(models.Model):
  linked_app = models.ForeignKey(App, on_delete=models.CASCADE,null=True)
  user_id = models.CharField(max_length=32)
  user_name = models.CharField(max_length=80)
  user_access_token = models.CharField(max_length=256)
  user_access_expiry = models.DateTimeField()
  user_email = models.CharField(max_length=128)

  def __str__(self):
    return self.user_name

  def upgrade_token(self):
    token_data = requests.get("https://graph.facebook.com/v3.1/oauth/access_token",
      params=(
            ('grant_type', 'fb_exchange_token'),
            ('client_id', self.linked_app.client_id),
            ('client_secret', self.linked_app.client_secret),
            ('fb_exchange_token', self.user_access_token)
        )
    ).json()
    if "access_token" not in token_data.keys():
        return False
    else:
        self.user_access_token = token_data["access_token"]
        self.user_access_expiry = datetime.now()+timedelta(days=30)
        self.save()
        return True

class Page(models.Model):
    linked_user = models.ForeignKey(User, on_delete=models.CASCADE,null=True)
    def __str__(self):
        return self.page_id

    page_category                                           = models.CharField(max_length=100)
    page_district                                           = models.CharField(max_length=100)
    page_state                                              = models.CharField(max_length=100)
    page_id                                                 = models.CharField(max_length=50)
    page_name                                               = models.CharField(max_length=50)
    page_management                                         = models.CharField(max_length=50,null=True)
    page_poc                                                = models.CharField(max_length=50,null=True)
    page_access_token                                       = models.CharField(max_length=256)
    page_access_expiry                                      = models.DateTimeField(auto_now_add=True, blank=True)
    page_permissions                                        = ListField()
    page_category_list                                      = ListField(DictField())
    page_fans                                               = ListField(DictField())
    # attributes below has info of a day,week,28 days in dict format
    page_fan_adds                                           = ListField(DictField())
    page_fan_adds_unique_day                                = ListField(DictField())
    page_fan_adds_unique_week                               = ListField(DictField())
    page_fan_adds_unique_days_28                            = ListField(DictField())
    page_fan_removes                                        = ListField(DictField())
    page_fan_removes_unique_day                             = ListField(DictField())
    page_fan_removes_unique_week                            = ListField(DictField())
    page_fan_removes_unique_days_28                         = ListField(DictField())
    page_fans_by_like_source                                = ListField(DictField())
    page_fans_by_unlike_source_unique                       = ListField(DictField())
    page_impressions_day                                    = ListField(DictField())
    page_impressions_week                                   = ListField(DictField())
    page_impressions_days_28                                = ListField(DictField())
    page_impressions_unique_day                             = ListField(DictField())
    page_impressions_unique_week                            = ListField(DictField())
    page_impressions_unique_days_28                         = ListField(DictField())
    page_impressions_organic_day                            = ListField(DictField())
    page_impressions_organic_week                           = ListField(DictField())
    page_impressions_organic_days_28                        = ListField(DictField())
    page_impressions_organic_unique_day                     = ListField(DictField())
    page_impressions_organic_unique_week                    = ListField(DictField())
    page_impressions_organic_unique_days_28                 = ListField(DictField())
    page_impressions_paid_day                               = ListField(DictField())
    page_impressions_paid_week                              = ListField(DictField())
    page_impressions_paid_days_28                           = ListField(DictField())
    page_impressions_paid_unique_day                        = ListField(DictField())
    page_impressions_paid_unique_week                       = ListField(DictField())
    page_impressions_paid_unique_days_28                    = ListField(DictField())
    page_impressions_viral_day                              = ListField(DictField())
    page_impressions_viral_week                             = ListField(DictField())
    page_impressions_viral_days_28                          = ListField(DictField())
    page_impressions_viral_unique_day                       = ListField(DictField())
    page_impressions_viral_unique_week                      = ListField(DictField())
    page_impressions_viral_unique_days_28                   = ListField(DictField())
    page_impressions_nonviral_day                           = ListField(DictField())
    page_impressions_nonviral_week                          = ListField(DictField())
    page_impressions_nonviral_days_28                       = ListField(DictField())
    page_impressions_nonviral_unique_day                    = ListField(DictField())
    page_impressions_nonviral_unique_week                   = ListField(DictField())
    page_impressions_nonviral_unique_days_28                = ListField(DictField())
    page_impressions_frequency_distribution_day	            = ListField(DictField())
    page_impressions_frequency_distribution_week	        = ListField(DictField())
    page_impressions_frequency_distribution_days_28     	= ListField(DictField())
    page_engaged_users_day                                  = ListField(DictField())
    page_engaged_users_week                                 = ListField(DictField())
    page_engaged_users_days_28                              = ListField(DictField())
    # lifetime attributes
    page_fans_city                                          = ListField(DictField())
    page_fans_locale                                        = ListField(DictField())
    page_fans_gender_age                                    = ListField(DictField())
    page_negative_feedback_day                              = ListField(DictField())
    page_negative_feedback_week                             = ListField(DictField())
    page_negative_feedback_days_28                          = ListField(DictField())
    page_negative_feedback_unique_day                       = ListField(DictField())
    page_negative_feedback_unique_week                      = ListField(DictField())
    page_negative_feedback_unique_days_28                   = ListField(DictField())
    page_views_total_day                                    = ListField(DictField())
    page_views_total_week                                   = ListField(DictField())
    page_views_total_days_28                                = ListField(DictField())
    page_fan_adds_by_paid_non_paid_unique                   = ListField(DictField())

    def upgrade_token(self):
        token_data = requests.get("https://graph.facebook.com/v3.1/"+self.page_id,
        params=(
            ('fields', 'access_token'),
            ('access_token', self.linked_user.user_access_token)
        )
        ).json()
        if "access_token" not in token_data.keys():
            print(token_data)
            return False
        else:
            self.page_access_token=token_data["access_token"]
            self.save()
            return True

class Post(models.Model):
    page_id =  models.CharField(max_length=50)
    page_name = models.CharField(max_length=50)
    page_state = models.CharField(max_length=50)
    page_district = models.CharField(max_length=50)
    page_category = models.CharField(max_length=50)
    page_management = models.CharField(max_length=50,null=True)
    page_poc  = models.CharField(max_length=50,null=True)
    page_object_id = models.CharField(max_length=50)
    post_id   = models.CharField(max_length=50)
    post_message = models.CharField(max_length=1000)
    post_link = models.CharField(max_length=100)
    post_created_time = models.DateTimeField(default=datetime.now(), blank=True)
    post_comments_count = ListField(models.CharField(max_length=20))
    post_shares_count = ListField(models.CharField(max_length=20))
    # lifetime attributes
    post_impressions = ListField(DictField())
    post_impressions_unique = ListField(DictField())
    post_impressions_fan = ListField(DictField())
    post_impressions_fan_unique = ListField(DictField())
    post_impressions_organic = ListField(DictField())
    post_impressions_organic_unique = ListField(DictField())
    # post_impressions_fan_paid = ListField(DictField())
    # post_impressions_fan_paid_unique = ListField(DictField())
    post_impressions_viral = ListField(DictField())
    post_impressions_viral_unique = ListField(DictField())
    post_impressions_nonviral = ListField(DictField())
    post_impressions_nonviral_unique = ListField(DictField())
    post_impressions_by_story_type = ListField(DictField())
    post_negative_feedback_unique = ListField(DictField())
    post_impressions_by_story_type_unique = ListField(DictField())
    post_reactions_like_total  = ListField(DictField())
    post_reactions_love_total = ListField(DictField())
    post_reactions_wow_total = ListField(DictField())
    post_reactions_haha_total = ListField(DictField())
    post_reactions_sorry_total = ListField(DictField())
    post_reactions_anger_total = ListField(DictField())
    post_reactions_by_type_total = ListField(DictField())
    post_clicks              = ListField(DictField())
    post_clicks_unique       = ListField(DictField())
    post_engaged_users       = ListField(DictField())
    post_engaged_fan         = ListField(DictField())
    post_video_views_10s_unique = ListField(DictField())

class scheduledJob(models.Model):
    job_id = models.CharField(max_length=32)
    job_created_time = models.DateTimeField("Created Time", auto_now=True)
    job_scheduled_time = models.DateTimeField("Scheduled Time")
    job_type = models.CharField(max_length=16)
    job_scheduled_page_ids = ListField()
    job_finished_page_ids = ListField(DictField())
    job_failed_id = models.CharField(max_length=50)
    job_meta = DictField()
    job_status = models.CharField("Status",max_length=16)

    def delete_job(self):
        data = {}
        for job_part in self.job_finished_page_ids:
            data.update({
                "access_token" : Page.objects.get(page_id=job_part['page_id']).page_access_token
            })
            response = requests.delete("https://graph.facebook.com/v3.1/"+job_part['post_id'],data=data).json()
            if not response['success']:
                print(response)
        self.job_status = "Deleted"
        self.save()

# dict fields attributes are
# {
#   "name": "post_impressions",
#   "period": "lifetime",
#   "values": [
#     {
#       "value": 2868
#     }
#   ],
#   "title": "Lifetime Post Total Impressions",
#   "description": "Lifetime: The number of times your Page's post entered a person's screen. Posts include statuses, photos, links, videos and more. (Total Count)",
#   "id": "1353902471330279_1812895292097659/insights/post_impressions/lifetime"
# }
