"""comdash URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/1.11/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  url(r'^$', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.conf.urls import url, include
    2. Add a URL to urlpatterns:  url(r'^blog/', include('blog.urls'))
"""

from django.conf.urls import patterns, include, url
from django.conf import settings


urlpatterns = [
    # url(r'^admin/', admin.site.urls),
    # url(r'^api/', include('api.urls')),
    # url(r'^$', 'website.views.homepage', name='index'),

    # Site Wide URLS
    # url(r'^termsofuse$', 'social.views.termsofuse', name='termsofuse'),

    # Fetch User Apis
    # url(r'fetch_all_users/$', 'api.views.fetch_all_users', name='fetch_all_users'),
    url(r'fetch_all_staff/$', 'api.views.fetch_all_staff', name='fetch_all_staff'),
    url(r'fetch_emailing_db/$', 'api.views.fetch_emailing_db', name='fetch_emailing_db'),

    # State District Filter Api
    url(r'fetch_state_district/$', 'api.views.fetch_state_district', name='fetch_state_district'),

    # Login Related Apis
    url(r'login_view_staff/$', 'api.views.login_view_staff', name='login_view_staff'),
    url(r'fetch_all_media_staff/$', 'api.views.fetch_all_media_staff', name='fetch_all_media_staff'),
    url(r'logout_view_staff/$', 'api.views.logout_view_staff', name='logout_view_staff'),
    url(r'create_update_user/$', 'api.views.create_update_user', name='create_update_user'),
    url(r'send_password_reset/$', 'api.views.send_password_reset', name='send_password_reset'),
    url(r'reset_pass_staff/$', 'api.views.reset_pass_staff', name='reset_pass_staff'),
    url(r'delete_user/$', 'api.views.delete_user', name='delete_user'),

    # Leader Fetch
    url(r'fetch_all_leaders/$', 'api.views.fetch_all_leaders', name='fetch_all_leaders'),
    # Party Fetch
    url(r'fetch_all_parties/$', 'api.views.fetch_all_parties', name='fetch_all_parties'),
    # News Categories Fetch
    url(r'fetch_all_news_categories/$', 'api.views.fetch_all_news_categories', name='fetch_all_news_categories'),
    # News type Fetch
    url(r'fetch_all_news_type/$', 'api.views.fetch_all_news_type', name='fetch_all_news_type'),
    # Activity log
    url(r'fetch_all_activity_log/$', 'api.views.fetch_all_activity_log', name='fetch_all_activity_log'),
    # Get all media houseslogout_view_staff
    url(r'fetch_all_publication/$', 'api.views.fetch_all_publication', name='fetch_all_publication'),
    url(r'fetch_all_media_check/$', 'api.views.fetch_all_media_check', name='fetch_all_media_check'),
    # Get all Keywords
    url(r'fetch_all_keywords/$', 'api.views.fetch_all_keywords', name='fetch_all_keywords'),
    # Get all news feed data
    url(r'fetch_news_feed/$', 'api.views.fetch_news_feed', name='fetch_news_feed'),

    # Get all media scan
    url(r'send_media_scan/$', 'api.views.send_media_scan', name='send_media_scan'),
    url(r'fetch_all_mediascan/$', 'api.views.fetch_all_mediascan', name='fetch_all_mediascan'),
    url(r'datecheck/$', 'api.tests.datecheck', name='datecheck'),
    url(r'mediascan_summary/$', 'api.views.mediascan_summary', name='mediascan_summary'),

    # Get all segements by dashboard
    url(r'fetch_segments/$', 'api.views.fetch_segments', name='fetch_segments'),
    # Get all authors
    url(r'fetch_all_authors/$', 'api.views.fetch_all_authors', name='fetch_all_authors'),
    # Add update delete keyword
    url(r'add_update_delete_keyword/$', 'api.views.add_update_delete_keyword', name='add_update_delete_keyword'),
    # Add update delete category
    url(r'add_update_delete_category/$', 'api.views.add_update_delete_category', name='add_update_delete_category'),
    # Add update delete news_type
    url(r'add_update_delete_news_type_category/$', 'api.views.add_update_delete_news_type_category', name='add_update_delete_news_type_category'),
    # Add update delete media
    url(r'add_update_delete_media/$', 'api.views.add_update_delete_media', name='add_update_delete_media'),
    # Add update delete author
    url(r'add_update_delete_author/$', 'api.views.add_update_delete_author', name='add_update_delete_author'),
    # Add update delete scan
    url(r'add_update_delete_scan/$', 'api.views.add_update_delete_scan', name='add_update_delete_scan'),
    # Instagram Hashtag Search
    url(r'instagram_hashtag_search/$', 'api.views.instagram_hashtag_search', name='instagram_hashtag_search'),
    # Get all twitter handles
    url(r'fetch_all_twitter/$', 'api.views.fetch_all_twitter', name='fetch_all_twitter'),
    url(r'fetch_all_instagram/$', 'api.views.fetch_all_instagram', name='fetch_all_instagram'),
    url(r'call_fetch_more_instagram_influencer/$', 'api.views.call_fetch_more_instagram_influencer', name='call_fetch_more_instagram_influencer'),
    url(r'fetch_all_tweets/$', 'api.views.fetch_all_tweets', name='fetch_all_tweets'),

    url(r'download_tweet_data/$', 'api.views.download_tweet_data', name='download_tweet_data'),
    url(r'download_tweetrefrence_data/$', 'api.views.download_tweetrefrence_data', name='download_tweetrefrence_data'),

    url(r'scrape_rss/$', 'api.views.scrape_rss', name='scrape_rss'),
    url(r'testapi/$', 'api.views.testapi', name='testapi'),
    url(r'logwrite/$', 'api.views.logwrite', name='logwrite'),
    url(r'cron_job_1/$', 'api.views.cron_job_1', name='cron_job_1'),
    url(r'cron_job_3/$', 'api.views.cron_job_3', name='cron_job_3'),
    url(r'cron_job_6/$', 'api.views.cron_job_6', name='cron_job_6'),
    url(r'cron_job_12/$', 'api.views.cron_job_12', name='cron_job_12'),
    url(r'cron_job_24/$', 'api.views.cron_job_24', name='cron_job_24'),
    # include social urls
    url(r'social/', include('social.urls')),
    url(r'social2/', include('social2.urls')),

]

if settings.PRODUCTION:
    urlpatterns += patterns('django.contrib.staticfiles.views', url(r'static/(?P<path>.*)$', 'serve'))
