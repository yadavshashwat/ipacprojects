"""
This file demonstrates writing tests using the unittest module. These will pass
when you run "manage.py test".

Replace this with more appropriate tests for your application.
"""
# from bs4 import BeautifulSoup
# import urllib,urllib2
#
# # page =  urllib2.urlopen("https://www.oneindia.com/india/all-eyess-on-rss-lecture-series-today-opposition-parties-to-skip-event-2777200.html?utm_source=/rss/news-india-fb.xml&utm_medium=124.124.201.183&utm_campaign=client-rss")
# # soup = BeautifulSoup( page )
# # right_table = soup.findAll( 'p' )
# #
# # author=soup.findAll("data-author")
# # print author
# # for i in right_table:
# #     content = author + i.get_text()
# #     print content
# # pandas and python-intercom packages need to be installed via pip
# from intercom.client import Client
# INTERCOM_ACCESS_TOKEN = 'dG9rOjQ2MmM2MzlkXzQwNzRfNGVkYl84YjYwXzkwZDVmNzcyMzcyMjoxOjA='
# EMAILS_HEADER = 'y.shashwat@gmail.com'
#
# intercom = Client(personal_access_token=INTERCOM_ACCESS_TOKEN)
#
# intercom.users.create(email=email)
# user = intercom.users.find(email=email)
# user.social_profiles
# # accepted
# I would recommend using the wonderful requests module.

# The code below will get you logged into the site and persist the cookies for the duration of the session.

# import requests
# import sys
#
# EMAIL = 'y.shashwat@gmail.com'
# PASSWORD = 'eshtudH3085392!!'
#
# URL = 'https://www.linkedin.com/authwall'
#
# def main():
#     # Start a session so we can have persistant cookies
#     session = requests.session(config={'verbose': sys.stderr})
#
#     # This is the form data that the page sends when logging in
#     login_data = {
#         'loginemail': EMAIL,
#         'loginpswd': PASSWORD,
#         'submit': 'login',
#     }
#
#     # Authenticate
#     r = session.post(URL, data=login_data)
#
#     # Try accessing a page that requires you to be logged in
#     r = session.get('http://www.linkedin.com/in/shashwatyadav')
#
# if __name__ == '__main__':
#     main()

#
# page_num = get_param(request, 'page_num', None)
# page_size = get_param(request, 'page_size', None)
#
# num_pages = 1
# total_records = len(qs)
# if page_num != None and page_num != "":
#     page_num = int(page_num)
#     qs = Paginator(qs, int(page_size))
#     try:
#         qs = qs.page(page_num)
#     except:
#         qs = qs
#     num_pages = int(math.ceil(total_records / float(int(page_size))))
#
#
#
#     obj['num_pages'] = num_pages
#     obj['total_records'] = total_records

#<------------------------------------------------------Summary------------------------------------------------------------------------------->

from django.http import HttpResponseRedirect,HttpResponseForbidden,HttpResponse
from django.shortcuts import render_to_response, redirect
from django.contrib.auth import authenticate, login, logout
from django.db import models
from django.db.models import Q
import json
from models import *
import pandas as pd
from tabulate import tabulate
from datetime import datetime
# from datetime import date
def get_param(req, param, default):
    req_param = None
    if req.method == 'GET':
        q_dict = req.GET
        if param in q_dict:
            req_param = q_dict[param]
    elif req.method == 'POST':
        q_dict = req.POST
        if param in q_dict:
            req_param = q_dict[param]
    if not req_param and default:
        req_param = default
    return req_param
import uuid

def datecheck(request):
    NewsFeedAll.objects.values('link')
    .annotate(Count('id'))
    .order_by()
    .filter(id__count__gt=1)
    return HttpResponse(m)



#<------------------------------------------------------Summary closed------------------------------------------------------------------------------->

# TO CALCULATE TOTAL NUMBER OF SENTIMENTS OF ANY ENITITY
#df1=(df[df["Entity_ID"]=="5bea711a520925075643fff5"]).groupby("Sent").size()

# TO CALCULATE NUMBER OF ARTICLE CORRESPONDING TO A LEADER
# df1=(df[df['Entity_ID']=="5bea711a520925075643fff5"])['Article_ID'].nunique()
