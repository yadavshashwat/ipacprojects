from django.conf.urls import patterns, include, url
from django.conf import settings

urlpatterns = [
# <--------------- Social Apis ----------->
    # url(r'fetch_facebook_pages/$', 'social.views.fetch_all_facebook_page_data', name='fetch_all_facebook_page_data'),
    # url(r'fetch_facebook_pages/page_id$', 'social.views.fetch_facebook_page_data', name='fetch_facebook_page_data'),
    # url(r'fetch_facebook_page_posts/$', 'gitsocial.views.fetch_facebook_page_posts', name='fetch_facebook_page_posts'),
    # url(r'fetch_facebook_page_tokens/$', 'social.views.fetch_facebook_page_tokens', name='fetch_facebook_page_tokens')
    # url(r'^social/',include('social.urls')),
    # <----------------------------------------------------------------------------------------------------------------------------->
    # url(r'fetch_all_facebook_pages/$', 'social.views.fetch_all_facebook_page_data', name='fetch_all_facebook_page_data'),
    url(r'fetch_facebook_page/', 'social.views.fetch_facebook_page_data', name='fetch_facebook_page_data'),
    # url(r'fetch_all_facebook_posts/$', 'social.views.fetch_all_facebook_posts', name='fetch_all_facebook_posts'),
    url(r'fetch_facebook_page_posts/$', 'social.views.fetch_facebook_page_posts', name='fetch_facebook_page_posts'),
    url(r'fetch_facebook_page_tokens/$', 'social.views.fetch_facebook_page_tokens', name='fetch_facebook_page_tokens'),
    url(r'fetch_facebook_page_fans_city/$', 'social.views.fetch_facebook_page_fans_city', name='fetch_facebook_page_fans_city'),
    url(r'facebook_page_filter/$', 'social.views.facebook_page_filter', name='facebook_page_filter'),
    url(r'facebook_page_overview/$', 'social.views.facebook_page_overview', name='facebook_page_overview'),
    url(r'facebook_page_overview_daily/$', 'social.views.facebook_page_overview_daily', name='facebook_page_overview_daily'),
    url(r'facebook_page_overview_weekly/$', 'social.views.facebook_page_overview_weekly', name='facebook_page_overview_weekly'),
    url(r'facebook_post_performance/$', 'social.views.facebook_post_performance', name='facebook_post_performance'),
    url(r'facebook_page_update/$', 'social.views.facebook_page_update', name='facebook_page_update'),
    url(r'overall_page_metrics/$', 'social.views.overall_page_metrics', name='overall_page_metrics'),
    url(r'facebook_demographic_breakdown/$', 'social.views.facebook_demographic_breakdown', name='facebook_demographic_breakdown'),
    url(r'facebook_pages_exposure/$', 'social.views.facebook_pages_exposure', name='facebook_pages_exposure'),
    url(r'facebook_post_scheduling/$', 'social.views.facebook_post_scheduling', name='facebook_post_scheduling'),
    url(r'upload_file/$', 'social.views.upload_file', name='upload_file'),
    url(r'termsofuse$', 'social.views.termsofuse', name='termsofuse'),
    url(r'privacypolicy$', 'social.views.privacypolicy', name='privacypolicy'),
    url(r'upload_video_file/$', 'social.views.upload_video_file', name='upload_video_file'),
    url(r'multiple_state_selector/$', 'social.views.multiple_state_selector', name='multiple_state_selector'),
    url(r'facebook_new_page/$', 'social.views.facebook_new_page', name='facebook_new_page'),
    url(r'scheduled_pages/$', 'social.views.scheduled_pages', name='scheduled_pages'),
    url(r'scheduledPosts/$', 'social.views.scheduledPosts', name='scheduledPosts'),
    # multiple_state_selector
    # url(r'facebook_create_poll/$', 'social.views.facebook_create_poll', name='facebook_create_poll'),
    # url(r'social2/', include('social2.urls')),
    url(r'temp/$', 'social.views.temp', name="temp"),
    url(r'login/$', 'social.views.login', name="login"),
    url(r'post_user_token/$', 'social.views.xhr_user_token', name="xhr_user_token"),
    url(r'post_page_data/$', 'social.views.xhr_page_data', name="xhr_page_data"),
    url(r'jobs/$', 'social.views.jobs', name="scheduledJobs"),
    url(r'job_linked_pages/$', 'social.views.job_linked_pages', name="job_linked_pages"),
]
