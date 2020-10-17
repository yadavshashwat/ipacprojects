from django.conf.urls import patterns, include, url
from django.conf import settings

urlpatterns=[
    url(r'temp/$', 'social2.views.temp', name="temp"),
    url(r'login/$', 'social2.views.login', name="login"),
    url(r'post_user_token/$', 'social2.views.xhr_user_token', name="xhr_user_token"),
    url(r'post_page_data/$', 'social2.views.xhr_page_data', name="xhr_page_data"),
    url(r'pages/$', 'social2.views.page', name='page'),
]
