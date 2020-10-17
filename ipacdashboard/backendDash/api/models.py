from django.db import models
from djangotoolbox.fields import DictField, ListField
from django.contrib.auth.models import (
    BaseUserManager, AbstractBaseUser, AbstractUser
)
import datetime
#from dbpreferences.fields import DictField
# Create your models here.



state_dict = [  {'1' : dict(segmentation_id=1,  segmentation_type = 'state',segment_active = True, segment_name='Andaman and Nicobar Islands', read=True, write=False)},
                {'2' : dict(segmentation_id=2,  segmentation_type = 'state',segment_active = True, segment_name='Andhra Pradesh', read=True, write=False)},
                {'3' : dict(segmentation_id=3,  segmentation_type = 'state',segment_active = True, segment_name='Arunachal Pradesh', read=True, write=False)},
                {'4' : dict(segmentation_id=4,  segmentation_type = 'state',segment_active = True, segment_name='Assam', read=True, write=False)},
                {'5' : dict(segmentation_id=5,  segmentation_type = 'state',segment_active = True, segment_name='Bihar', read=True, write=False)},
                {'6' : dict(segmentation_id=6,  segmentation_type = 'state',segment_active = True, segment_name='Chandigarh', read=True, write=False)},
                {'7' : dict(segmentation_id=7,  segmentation_type = 'state',segment_active = True, segment_name='Chhattisgarh', read=True, write=False)},
                {'8' : dict(segmentation_id=8,  segmentation_type = 'state',segment_active = True, segment_name='Dadra and Nagar Haveli', read=True, write=False)},
                {'9' : dict(segmentation_id=9,  segmentation_type = 'state',segment_active = True, segment_name='Daman and Diu', read=True, write=False)},
                {'10': dict(segmentation_id=10, segmentation_type = 'state',segment_active = True, segment_name='Goa', read=True, write=False)},
                {'11': dict(segmentation_id=11, segmentation_type = 'state',segment_active = True, segment_name='Gujarat', read=True, write=False)},
                {'12': dict(segmentation_id=12, segmentation_type = 'state',segment_active = True, segment_name='Haryana', read=True, write=False)},
                {'13': dict(segmentation_id=13, segmentation_type = 'state',segment_active = True, segment_name='Himachal Pradesh', read=True, write=False)},
                {'14': dict(segmentation_id=14, segmentation_type = 'state',segment_active = True, segment_name='Jammu and Kashmir', read=True, write=False)},
                {'15': dict(segmentation_id=15, segmentation_type = 'state',segment_active = True, segment_name='Jharkhand', read=True, write=False)},
                {'16': dict(segmentation_id=16, segmentation_type = 'state',segment_active = True, segment_name='Karnataka', read=True, write=False)},
                {'17': dict(segmentation_id=17, segmentation_type = 'state',segment_active = True, segment_name='Kerala', read=True, write=False)},
                {'18': dict(segmentation_id=18, segmentation_type = 'state',segment_active = True, segment_name='Lakshadweep', read=True, write=False)},
                {'19': dict(segmentation_id=19, segmentation_type = 'state',segment_active = True, segment_name='Madhya Pradesh', read=True, write=False)},
                {'20': dict(segmentation_id=20, segmentation_type = 'state',segment_active = True, segment_name='Maharashtra', read=True, write=False)},
                {'21': dict(segmentation_id=21, segmentation_type = 'state',segment_active = True, segment_name='Manipur', read=True, write=False)},
                {'22': dict(segmentation_id=22, segmentation_type = 'state',segment_active = True, segment_name='Meghalaya', read=True, write=False)},
                {'23': dict(segmentation_id=23, segmentation_type = 'state',segment_active = True, segment_name='Mizoram', read=True, write=False)},
                {'24': dict(segmentation_id=24, segmentation_type = 'state',segment_active = True, segment_name='Nagaland', read=True, write=False)},
                {'25': dict(segmentation_id=25, segmentation_type = 'state',segment_active = True, segment_name='Delhi', read=True, write=False)},
                {'26': dict(segmentation_id=26, segmentation_type = 'state',segment_active = True, segment_name='Odisha', read=True, write=False)},
                {'27': dict(segmentation_id=27, segmentation_type = 'state',segment_active = True, segment_name='Puducherry', read=True, write=False)},
                {'28': dict(segmentation_id=28, segmentation_type = 'state',segment_active = True, segment_name='Punjab', read=True, write=False)},
                {'29': dict(segmentation_id=29, segmentation_type = 'state',segment_active = True, segment_name='Rajasthan', read=True, write=False)},
                {'30': dict(segmentation_id=30, segmentation_type = 'state',segment_active = True, segment_name='Sikkim', read=True, write=False)},
                {'31': dict(segmentation_id=31, segmentation_type = 'state',segment_active = True, segment_name='Tamil Nadu', read=True, write=False)},
                {'32': dict(segmentation_id=32, segmentation_type = 'state',segment_active = True, segment_name='Telangana', read=True, write=False)},
                {'33': dict(segmentation_id=33, segmentation_type = 'state',segment_active = True, segment_name='Tripura', read=True, write=False)},
                {'34': dict(segmentation_id=34, segmentation_type = 'state',segment_active = True, segment_name='Uttar Pradesh', read=True, write=False)},
                {'35': dict(segmentation_id=35, segmentation_type = 'state',segment_active = True, segment_name='Uttarakhand', read=True, write=False)},
                {'36': dict(segmentation_id=36, segmentation_type = 'state',segment_active = True, segment_name='West Bengal', read=True, write=False)},
                {'37': dict(segmentation_id=37, segmentation_type = 'state',segment_active = True, segment_name='National', read=True, write=False)}
            ]


# Create your models here.

class Segmentation(models.Model):
    dashboard_type      = models.CharField(max_length=150)
    segmentation_type   = models.CharField(max_length=150)
    segmentation_id     = models.CharField(max_length=150)
    segment_active      = models.BooleanField(default=True)
    segment_name        = models.CharField(max_length=150)

class StateDistrict(models.Model):
    state_id        = models.IntegerField()
    state_name      = models.CharField(max_length=150, default=None)
    district_id     = models.IntegerField()
    district_name   = models.CharField(max_length=150, default=None)

class Leaders(models.Model):
    leader_id   = models.CharField(max_length=200)
    leader_name = models.CharField(max_length=200)
    party       = models.CharField(max_length=200,null=True)

class Party(models.Model):
    party_code   = models.CharField(max_length=200)
    party        = models.CharField(max_length=200)
    party_leader = models.CharField(max_length=200)
    party_abbr   = models.CharField(max_length=200)
    party_type   = models.CharField(max_length=200)

class StaffUser(AbstractUser):
    name                   = models.CharField(max_length=150)
    # user_email             = models.CharField(max_length=150)
    ipac_id                = models.CharField(max_length=150,null=True)
    contact_no             = models.CharField(max_length=10, default=None,null=True)
    is_admin               = models.BooleanField(default=False)
    is_media_admin         = models.BooleanField(default=False)
    is_media               = models.BooleanField(default=False)
    is_media_write         = models.BooleanField(default=False)
    is_digital_admin       = models.BooleanField(default=False)
    is_demo_admin          = models.BooleanField(default=False)
    media_seg_sub_access   = ListField(DictField())
    login_string           = models.CharField(max_length=50,null=True)

class login_log(AbstractUser):
    token               =   models.CharField(max_length=255)
    login_timestamp     =   models.DateTimeField(null=True,blank=True)
    logout_timestamp    =   models.DateTimeField(null=True,blank=True)
    user_id             =   models.CharField(max_length=200)
    status              =   models.CharField(max_length=200)
    # email            =   models.CharField(max_length=200)      #sudo email id exist
    # username           =   models.CharField(max_length=200)

class activity_log(AbstractUser):
    token               = models.CharField(max_length=255)
    timestamp           = models.DateTimeField(null=True, blank=True)
    user_id             = models.CharField(max_length=200)
    # user_name           = models.CharField(max_length=200)
    activity            = models.CharField(max_length=200)
    # email_id            = models.CharField(max_length=200)


class ComUser(AbstractUser):
    name                    = models.CharField(max_length=150, default=None)
    contact_no              = models.CharField(max_length=10, default=None)
    whatsapp_no             = models.CharField(max_length=10, default=None, null=True)
    is_ass_active           = models.BooleanField(default=True)
    is_subscribed           = models.BooleanField(default=True)
    birth_date              = models.DateField(null=True)
    anniversary             = models.DateField(null=True)
    user_email              = models.CharField(max_length=100,default=None,null=True)
    home_state              = models.CharField(max_length=50,default=None,null=True)
    home_district           = models.CharField(max_length=50, default=None, null=True)
    college_state           = models.CharField(max_length=50, default=None, null=True)
    college_district        = models.CharField(max_length=50, default=None, null=True)
    gender                  = models.CharField(max_length=50, default=None, null=True)
    is_student              = models.BooleanField()
    assembly                = models.CharField(max_length=50, default=None, null=True)
    parliamentary           = models.CharField(max_length=50, default=None, null=True)
    lanugage_pref1          = models.CharField(max_length=50, default=None, null=True)
    lanugage_pref2          = models.CharField(max_length=50, default=None, null=True)
    facebook_handle         = models.CharField(max_length=50, default=None, null=True)
    twitter_handle          = models.CharField(max_length=50, default=None, null=True)
    instagram_handle        = models.CharField(max_length=50, default=None, null=True)
    college_name            = models.CharField(max_length=200, default=None, null=True)
    education_cat           = models.CharField(max_length=50,default=None, null=True)
    current_company         = models.CharField(max_length=50,default=None, null=True)
    financial_category      = models.CharField(max_length=50,default=None, null=True)
    marital_status          = models.CharField(max_length=50,default=None, null=True)
    subscription_ip         = models.CharField(max_length=50,default=None, null=True)
    referral_code           = models.CharField(max_length=50,default=None, null=True)
    referee_code            = models.CharField(max_length=50,default=None, null=True)
    religion                = models.CharField(max_length=50,default=None, null=True)
    caste                   = models.CharField(max_length=50,default=None, null=True)
    profession              = models.CharField(max_length=50,default=None, null=True)

# Media Dashboard Models Start

class Categories(models.Model):
    category        = models.CharField(max_length=100)
    cat_description = models.CharField(max_length=200)

class news_type_category(models.Model):
    news_type        = models.CharField(max_length=100)
    type_description = models.CharField(max_length=200)

class Keywords(models.Model):
    keyword      = models.CharField(max_length=100)
    synonyms     = ListField(models.CharField(max_length=100))
    keyword_type = models.CharField(max_length=100, null=True)
    is_active    = models.BooleanField(default=True)
    article_list = ListField(models.CharField(max_length=100))

class MediaChannel(models.Model):
    media_name          = models.CharField(max_length=200)
    article_type        = models.CharField(max_length=200)
    rss_feed            = ListField(DictField())
    inclination_party   = ListField(DictField())
    inclination_leader  = ListField(DictField())
    is_active           = models.BooleanField(default=True)
    title_str_name      = models.CharField(max_length=50,null=True)
    author_str_name     = models.CharField(max_length=50,null=True)
    summary_str_name    = models.CharField(max_length=50,null=True)
    link_str_name       = models.CharField(max_length=50,null=True)
    pubdate_str_name    = models.CharField(max_length=50,null=True)
    page_content_str    = models.CharField(max_length=50,null=True)
    author_content_str  = models.CharField(max_length=50,null=True)
    language            = models.CharField(max_length=50)

# ListField(DictField())
class NewsFeedAll(models.Model):
    channel_name                = models.CharField(max_length=100)
    article_type                = models.CharField(max_length=200)
    channel_id                  = models.CharField(max_length=100,null=True)
    author_id                   = models.CharField(max_length=100,null=True)
    feedtype                    = models.CharField(max_length=200)
    link                        = models.CharField(max_length=500)
    headline                    = models.CharField(max_length=500)
    summary                     = models.CharField(max_length=500)
    content                     = models.CharField(max_length=10000)
    author                      = models.CharField(max_length=100)
    created_at                  = models.DateTimeField()
    segmentation                = ListField(models.CharField(max_length=100))
    api_sentiment_pair_headline = ListField(DictField())
    api_sentiment_pair_content  = ListField(DictField())
    keyword_list                = ListField(models.CharField(max_length=100))
    category                    = ListField(models.CharField(max_length=100))
    keyword_searched            = models.BooleanField(default=False)
    keyword_found               = models.BooleanField(default=False)
    # keyword_synonym             = ListField(models.CharField(max_length=100))
    marked_important            = models.BooleanField(default=False)
    language                    = models.CharField(max_length=500)
    relevance_score            = models.CharField(max_length=10,default="0")
    # news_state                  = models.CharField(max_length=200)
    state_found                 = models.BooleanField(default=False)
    state_searched              = models.BooleanField(default=False)

class MediaScan(models.Model):
    channel_id                   = models.CharField(max_length=100)
    channel_name                 = models.CharField(max_length=100)
    link                         = models.CharField(max_length=500)
    headline                     = models.CharField(max_length=500)
    summary                      = models.CharField(max_length=500)
    content                      = models.CharField(max_length=10000)
    content_en                   = models.CharField(max_length=10000)
    language                     = models.CharField(max_length=50, default="English")
    author_id                    = models.CharField(max_length=100,null=True)
    author_name                  = models.CharField(max_length=100,null=True)
    created_at                   = models.DateTimeField(null=True, blank=True)
    api_sentiment_pair_keywords  = ListField(DictField())
    api_sentiment_pair_all       = ListField(DictField())
    keyword_list                 = ListField(models.CharField(max_length=100))
    category                     = ListField(models.CharField(max_length=100))
    news_type                    = ListField(models.CharField(max_length=100))
    user_sentiment_pair_keyword  = ListField(DictField())
    user_sentiment_pair_leader   = ListField(DictField())
    user_sentiment_pair_party    = ListField(DictField())
    segmentation                 = ListField(models.CharField(max_length=100))
    district                     = ListField(models.CharField(max_length=100))
    author_inclination_party     = ListField(DictField())
    author_inclination_leader    = ListField(DictField())
    media_inclination_party      = ListField(DictField())
    media_inclination_leader     = ListField(DictField())
    edit_log                     = ListField(DictField())
    added_by                     = models.CharField(max_length=100)

class Authors(models.Model):
    media_name         = ListField(models.CharField(max_length=100))
    author_name        = models.CharField(max_length=100)
    caste_author       = models.CharField(max_length=100,null=True)
    inclination_party  = ListField(DictField())
    inclination_leader = ListField(DictField())

class LoginLog(models.Model):
    time_stamp   = models.DateTimeField()
    user_id      = models.CharField(max_length=200)
    login_logout = models.CharField(max_length=200)


# Not Yet Sorted Models

class Otp(models.Model):
    mobile       = models.CharField(max_length=50)
    # country_code = models.CharField(max_length=50)
    otp          = models.CharField(max_length=50)
    created      = models.DateTimeField(default=None)
    updated      = models.DateTimeField(default=None)

class SendEmailUsers(models.Model):
    name  = models.CharField(max_length=100)
    email = models.CharField(max_length=100)
    sent_status = models.BooleanField(default=False)

class TwitterUsers(models.Model):
    twitter_handle       = models.CharField(max_length=100)
    twitter_followers    = models.CharField(max_length=100)
    num_likes_last100    = models.CharField(max_length=100)
    num_retweets_last100 = models.CharField(max_length=100)
    efficiency_quotient  = models.CharField(max_length=100)
    list_followers       = ListField()
    list_following       = ListField()

class InstagramUsers(models.Model):
    instagram_handle         = models.CharField(max_length=100)
    instagram_id             = models.CharField(max_length=100)
    instagram_followers      = models.CharField(max_length=100)
    # instagram_following      = models.CharField(max_length=100)
    instagram_following_list = ListField(DictField())
    followers_scraped        = models.BooleanField(default=False)

class Tweets(models.Model):
    tweet = models.CharField(max_length=100)
    likes = models.CharField(max_length=100)
    retweets = models.CharField(max_length=100)

# class DataCheck(models.Model):
#     test = models.CharField(max_length=100)


# class