
from django.shortcuts import render
from django.http import HttpResponseRedirect,HttpResponseForbidden,HttpResponse
from django.shortcuts import render_to_response, redirect
from django.contrib.auth import authenticate, login, logout
from django.db import models
from django.db.models import Q
import copy
import uuid
from models import *
# from social.models import *
# from social import views as socialviews


from mailing import views as mailing
# from mailing import emails as emails
# import detectlanguage
import urllib, urllib2
import random
import datetime as dateTIME
import calendar
import time as timenew
from datetime import datetime,timedelta,date,time
from dateutil.parser import *
# from datetime import *f
import parsedatetime
import json
import requests
import feedparser
import string
import re
import operator
import pandas as pd
from tabulate import tabulate
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import smtplib
# import xlsxwriter
import xlwt
import os
import math
# import unicodecsv as csv
from google.cloud import language
from google.cloud.language import enums
from google.cloud.language import types
from google.cloud import translate
import six
import sys
import urllib
from lxml.html import document_fromstring
import requests
from lxml.html import fromstring
from six import binary_type
from bs4 import BeautifulSoup
# from string import punctuation
from fuzzywuzzy import fuzz
from django.core.paginator import Paginator
from social import views as socialviews
super_admin = ['shashwat.yadav@indianpac.com','rajesh.hanswal@indianpac.com','subhash.tanan@indianpac.com','akshay.saini@indianpac.com']
backup_admin = "qKNV2dTJri"


def random_str_generator(size=6, chars=string.ascii_uppercase + string.digits):
    return ''.join(random.choice(chars) for x in range(size))

def multiplebr(raw_html):
    sbr = raw_html.replace('\r','\n')
    sbr1 = re.sub('\n+', '\n', sbr)
    return sbr1

def cleanhtml(raw_html):
  cleanr = re.compile('<.*?>')
  cleantext = re.sub(cleanr, '', raw_html)
  return cleantext

def cleanhtml2(raw_html):
  cleanr = re.compile('&lt.*?&gt')
  cleantext = re.sub(cleanr, '', raw_html)
  return cleantext

def cleanstring(query):
    query = query.strip()
    query1 = re.sub('\s{2,}', ' ', query)
    query2 = re.sub(r'^"|"$', '', query1)
    query3 = re.sub(";","",query2)
    return query3

def cleanauthor(query):
    query = query.lower()
    collection = ["written" , "by" , "reporting" , "editing" , "source" , "bloomberg" , "sifiby","compiled"]
    collection1 = [":" , "\|" , ","]
    for i in collection:
        t = r"\b" + i + r"\b"
        query = re.sub( t , '' , query )
    for i in collection1:
        query = re.sub( i , '' , query )
        query = re.sub( ' +' , ' ' , query )

    if query in ["pti", "press trust of india"]:
        query = "Press Trust of India"

    if query in ["agency", "agencies"]:
        query = "Agency"

    return query


# <---------------- Get parameters in an api from request  start ------------------->

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

# <---------------- Set Cookie ------------------->

def set_cookie(response, key, value, days_expire = 7):
    if days_expire is None:
        max_age = 365 * 24 * 60 * 60  #one year
    else:
        max_age = days_expire * 24 * 60 * 60
    expires = datetime.strftime(datetime.utcnow() + datetime.timedelta(seconds=max_age), "%a, %d-%b-%Y %H:%M:%S GMT")
    response.set_cookie(key, value, max_age=max_age, expires=expires)

# <---------------- Fetch Saved Data ------------------->

# Fetch Activity Log

# def fetch_all_activity_log(request):
#     obj = {}
#     obj['status'] = False
#     obj['result'] = []
#     transObjs=activity_log.objects.all()
#     for trans in transObjs:
#         obj['result'].append({'token':trans.token,
#                                'login_time':str(trans.timestamp),
#                                'userid':trans.user_id,
#                                'user_name':trans.username,
#                                'activity':trans.activity})
#     obj['status'] = True
#     return HttpResponse(json.dumps(obj),content_type='application/json')

# To get all staff users
def fetch_all_staff(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    # Search Fields
    email       = get_param(request, 'email', None)
    contact = get_param(request, 'contact', None)
    search_id = get_param(request, 'id', None)

    tranObjs = None
    # if request.user.is_authenticated() and request.user.is_admin:
    tranObjs = StaffUser.objects.all()


    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)

    else:
        if email != None and email != "":
            tranObjs = tranObjs.filter(email__icontains=email)

        if contact != None and contact != "":
            tranObjs = tranObjs.filter(contact_no__icontains=contact)


    # if request.user.is_authenticated() and not request.user.is_admin and request.user.is_media_admin:
    #     tranObjs = StaffUser.objects.filter(is_media=True)
        # i = 0

    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    if tranObjs != None:
        for trans in tranObjs:
            # collect=[]
            # activitylog=activity_log.objects.all()
            # activity_log_filtered=activitylog.filter(email__icontains=trans.email)
            # for act in activity_log_filtered:
            #     collect.append({'timestamp': str(act.timestamp),
            #                     'user_id': act.user_id,
            #                     'name': act.username,
            #                     'email': act.email,
            #                     'activity': act.activity})

            obj['result'].append({
                'id'   :trans.id
                , 'name': trans.name
                , 'user_email': trans.email
                , 'contact_no': trans.contact_no
                , 'is_admin': trans.is_admin
                , 'is_media': trans.is_media
                , 'is_digital_admin': trans.is_digital_admin
                , 'is_demo_admin': trans.is_demo_admin
                , 'is_media_admin': trans.is_media_admin
                , 'is_media_write': trans.is_media_write
                , 'media_state_access': trans.media_seg_sub_access
                , 'login_string': trans.login_string
                # , 'user_log':collect
            })

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

# To get info of all registered users

# To get info of all registered media users
def fetch_all_media_staff(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    # Search Fields
    email       = get_param(request, 'email', None)
    contact = get_param(request, 'contact', None)
    search_id = get_param(request, 'id', None)

    tranObjs = None
    # if request.user.is_authenticated() and request.user.is_admin:
    tranObjs = StaffUser.objects.all()


    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)

    else:
        if email != None and email != "":
            tranObjs = tranObjs.filter(email__icontains=email)

        if contact != None and contact != "":
            tranObjs = tranObjs.filter(contact_no__icontains=contact)

    tranObjs = tranObjs.filter(is_media="1")
    # if request.user.is_authenticated() and not request.user.is_admin and request.user.is_media_admin:
    #     tranObjs = StaffUser.objects.filter(is_media=True)
        # i = 0

    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    if tranObjs != None:
        for trans in tranObjs:
            collect=[]
            activitylog=activity_log.objects.all()
            activity_log_filtered=activitylog.filter(email__icontains=trans.email)
            for act in activity_log_filtered:
                collect.append({'timestamp': str(act.timestamp.strftime("%d-%b-%Y %I:%M %p")),
                                'user_id': act.user_id,
                                'name': act.username,
                                'email': act.email,
                                'activity': act.activity})

            obj['result'].append({
                'id'   :trans.id
                , 'name': trans.name
                , 'user_email': trans.email
                , 'contact_no': trans.contact_no
                , 'is_admin': trans.is_admin
                , 'is_media': trans.is_media
                , 'is_digital_admin': trans.is_digital_admin
                , 'is_media_admin': trans.is_media_admin
                , 'is_media_write': trans.is_media_write
                , 'media_state_access': trans.media_seg_sub_access
                , 'login_string': trans.login_string
                , 'user_log':collect
            })

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')



def fetch_all_users(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    tranObjs = None
    i = 0
    tranObjs = ComUser.objects.all()

    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))


    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id'   :trans.id
            , 'name': trans.name
            , 'contact_no': trans.contact_no
            , 'whatsapp_no': trans.whatsapp_no
            , 'is_ass_active': trans.is_ass_active
            , 'is_subscribed': trans.is_subscribed
            , 'birth_date': str(trans.birth_date)
            , 'anniversary': str(trans.anniversary)
            , 'user_email': trans.user_email
            , 'home_state': trans.home_state
            , 'home_district': trans.home_district
            , 'college_state': trans.college_state
            , 'college_district': trans.college_district
            , 'gender': trans.gender
            , 'is_student': trans.is_student
            , 'assembly': trans.assembly
            , 'parliamentary': trans.parliamentary
            , 'lanugage_pref1': trans.lanugage_pref1
            , 'lanugage_pref2': trans.lanugage_pref2
            , 'facebook_handle': trans.facebook_handle
            , 'twitter_handle': trans.twitter_handle
            , 'instagram_handle': trans.instagram_handle
            , 'college_name': trans.college_name
            , 'education_cat': trans.education_cat
            , 'current_company': trans.current_company
            , 'financial_category': trans.financial_category
            , 'marital_status': trans.marital_status
            , 'subscription_ip': trans.subscription_ip
            , 'referral_code': trans.referral_code
            , 'referee_code': trans.referee_code
            , 'religion': trans.religion
            , 'caste': trans.caste
            , 'profession': trans.profession
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"

    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

# To get info of all users to be emailed
def fetch_emailing_db(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []

    tranObjs = None
    i = 0
    tranObjs = SendEmailUsers.objects.all()
    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'name': trans.name
            , 'email': trans.email
            , 'sent_status': trans.sent_status

        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"

    return HttpResponse(json.dumps(obj), content_type='application/json')

# To get info of all states and districts in India
def fetch_state_district(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    state_id = get_param(request, 'state_id', None)
    state_ids = get_param(request, 'state_ids', None)

    tranObjs = None
    transObjlist = []
    # if request.user.is_superuser:

    if state_id:
        tranObjs = StateDistrict.objects.filter(state_id=state_id)
        transObjlist = [tranObjs]

    elif state_ids:
        list_state_ids = state_ids.split(',')

        for state_id_a in list_state_ids:
            tranObjs = StateDistrict.objects.filter(state_id=state_id_a)
            transObjlist.append(tranObjs)
    else:
        tranObjs = StateDistrict.objects.all().order_by('state_id')
        transObjlist = [tranObjs]
    i = 0
    for tranobjs_i in transObjlist:
        for trans in tranobjs_i:
            i = i + 1
            if state_id or state_ids:
                obj['result'].append({
                    'id': trans.id
                    , 'state_id': trans.state_id
                    , 'state_name': trans.state_name
                    , 'district_id': trans.district_id
                    , 'district_name': trans.district_name
                })
            else:
                obj['result'].append({
                    'id': trans.id
                    , 'state_id': trans.state_id
                    , 'state_name': trans.state_name
                    # , 'district_id': trans.district_id
                    # , 'district_name': trans.district_name
                })
    if state_id == None and state_ids == None:
        obj['result'] = {v['state_id']:v for v in obj['result']}.values()
        obj['result'] = sorted(obj['result'], key=operator.itemgetter('state_id'))

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    # obj['num_pages'] = num_pages
    # obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_leaders(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []


    party = get_param(request, 'party', None)
    leader = get_param(request, 'leader', None)
    search_id = get_param(request, 'id', None)
    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)



    tranObjs = None
    i = 0
    tranObjs = Leaders.objects.all()

    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)
    else:
        if party != None and party != "":
            tranObjs = tranObjs.filter(party__icontains = party)

        if leader != None and leader != "":
            tranObjs = tranObjs.filter(leader_name__icontains = leader)


    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))


    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'leader_id': trans.leader_id
            , 'leader_name': trans.leader_name
            , 'party': trans.party
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_parties(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    party_type = get_param(request, 'party_type', None)
    party_leader = get_param(request, 'party_leader', None)
    party_abbr = get_param(request, 'party_abbr', None)
    party = get_param(request, 'party', None)
    search_id = get_param(request, 'id', None)


    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    tranObjs = None
    i = 0
    tranObjs = Party.objects.all()
    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)

    else:
        if party_type != None and party_type != "":
            tranObjs = tranObjs.filter(party_type__icontains = party_type)

        if party_leader != None and party_leader != "":
            tranObjs = tranObjs.filter(party_leader__icontains = party_leader)

        if party_abbr != None and party_abbr != "":
            tranObjs = tranObjs.filter(party_abbr__icontains = party_abbr)

        if party != None and party != "":
            tranObjs = tranObjs.filter(party__icontains = party)


    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'party_code': trans.party_code
            , 'party': trans.party
            , 'party_leader': trans.party_leader
            , 'party_abbr': trans.party_abbr
            , 'party_type': trans.party_type
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"

    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_news_feed(request):      # fetch all scrape news of last 7 days
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    i = 0
    num_pages = 1

    # tranObjs = NewsFeedAll.objects.all().order_by('-created_at')
    # tranObjs = NewsFeedAll.objects.all()
    # tranObjs = NewsFeedAll.objects.filter(created_at__gte=datetime.date(startdate),
    #                                       created_at__lte = datetime.date(enddate))


    keyword_present = get_param(request, 'keyword_present', None)
    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)
    keyword_id = get_param(request, 'keyword_id', None)
    channel_id = get_param(request, 'channel_id', None)
    channel_name = get_param(request, 'channel_name', None)
    article = get_param(request, 'article', None)
    author = get_param(request, 'author', None)
    author_id = get_param(request, 'author_id', None)
    category_name = get_param(request, 'category_name', None)
    lang = get_param(request, 'language', None)
    marked_important = get_param(request, 'marked_important', None)
    start_date = get_param(request, 'start_date', default=None)
    end_date = get_param(request, 'end_date', default=None)
    segment = get_param(request, 'segment', None)
    search_id = get_param(request, 'id', None)

    # tranObjs = NewsFeedAll.objects.all().order_by('-created_at')
    if start_date==None or start_date=="" or end_date==None or end_date=="":
        current_date=dateTIME.datetime.now()
        d1=dateTIME.timedelta(days=7)
        ending_date=(current_date-d1).strftime("%Y-%m-%d")
        current_date=current_date.strftime("%Y-%m-%d")
        # tranObjs = NewsFeedAll.objects.all()
        tranObjs = NewsFeedAll.objects.filter(created_at__range=(ending_date,current_date)).order_by('-created_at')
    else:
        startdate = datetime.strptime(start_date, "%Y-%m-%d")
        enddate = datetime.strptime(end_date, "%Y-%m-%d")
        tranObjs = NewsFeedAll.objects.filter(created_at__range=(startdate,enddate)).order_by('-created_at')

    if keyword_present:
        if keyword_present == "1":
            tranObjs = tranObjs.filter(keyword_found = True)


    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)
    else:
        if keyword_id != None and keyword_id != "":
            tranObjs = tranObjs.filter(keyword_list__icontains = keyword_id)

        if channel_id != None and channel_id != "":
            tranObjs = tranObjs.filter(channel_id = channel_id)

        if channel_name != None and channel_name != "":
            tranObjs = tranObjs.filter(channel_name__icontains = channel_name)

        if article != None and article != "":
            tranObjs = tranObjs.filter(Q(headline__icontains=article) | Q(summary__icontains=article) | Q(content__icontains=article))

        if author != None and author != "":
            tranObjs = tranObjs.filter(author__icontains = author)

        if author_id != None and author_id != "":
            tranObjs = tranObjs.filter(author_id = author_id)

        if category_name != None and category_name != "":
            tranObjs = tranObjs.filter(category__icontains = category_name)

        if lang != None and lang != "":
            tranObjs = tranObjs.filter(language = lang)

        if marked_important != None and marked_important != "":
            if marked_important == "1":
                tranObjs = tranObjs.filter(marked_important = True)

        if segment != None and segment != "":
            tranObjs = tranObjs.filter(segmentation__icontains = segment)

        # if start_date !=None and start_date != "" and end_date !=None and end_date !="":
        #     tranObjs = tranObjs.filter(created_at__range=(start_date, end_date))

    # news_id_list = map(lambda x : x.id,tranObjs)
    # Changed to handle large data
    total_records = tranObjs.count()

    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs

        num_pages  = int(math.ceil(total_records/float(int(page_size))))
    i = 0
    # num_range = transObjs.count()


    # for i in range(num_range:
        # trans

    for trans in tranObjs:
        # trans = NewsFeedAll.objects.filter(id = news)
        i = i + 1
        keyword_dict_list = []
        for keyword in trans.keyword_list:
            try:
                keyword_name = ((Keywords.objects.filter(id=keyword))[0]).keyword
            except:
                keyword_name = None
            if keyword_name:
                key = {"keyword_id":keyword,"keyword":keyword_name}
                keyword_dict_list.append(key)

        obj['result'].append({
            'id': trans.id,
            'channel_id':trans.channel_id,
            'channel_name' : trans.channel_name,
            'link' : trans.link,
            'headline' : trans.headline,
            'summary' : trans.summary,
            'content' : trans.content,
            'author' : trans.author,
            'author_id': trans.author_id,
            'created_at' : str(trans.created_at),
            'api_sentiment_pair_headline' : trans.api_sentiment_pair_headline,
            'api_sentiment_pair_content' : trans.api_sentiment_pair_content,
            'keyword_list' : trans.keyword_list,
            'keyword_found': trans.keyword_found,
            'keyword_dict_list' :keyword_dict_list,
            'category' : trans.category,
            'relevance_score': trans.relevance_score,
            'keyword_searched': trans.keyword_searched,
            'segmentation': trans.segmentation,
            'num_keywords':len(trans.keyword_list),
            'marked_important':trans.marked_important,
            'language': trans.language
        })

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    obj['msg'] = "Success"

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_keywords(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    keyword_type = get_param(request, 'keyword_type', None)

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    tranObjs = None
    i = 0
    tranObjs = Keywords.objects.all()
    if keyword_type:
        tranObjs = tranObjs.filter(keyword_type = keyword_type)


    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'keyword': trans.keyword
            , 'synonyms': trans.synonyms
            , 'article_list': trans.article_list
            , 'keyword_type': trans.keyword_type
            , 'is_active': trans.is_active
            ,'num_articles': len(trans.article_list)

        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    # obj['num_pages'] = num_pages
    # obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_news_categories(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    i = 0
    tranObjs = Categories.objects.all()
    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)
    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'category': trans.category
            , 'cat_description': trans.cat_description
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_news_type(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    i = 0
    tranObjs = news_type_category.objects.all()
    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)
    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'news_type': trans.news_type
            , 'type_description': trans.type_description
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_publication(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    # i = 0
    # tranObjs = MediaChannel.objects.all()

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    search_id = get_param(request, 'search_id', None)
    lang = get_param(request, 'language', None)


    tranObjs = None
    # i = 0
    tranObjs = MediaChannel.objects.all().order_by("-id")


    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)
    else:
        if lang != None and lang != "":
            tranObjs = tranObjs.filter(language = lang)



    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))


    for trans in tranObjs:
        obj['result'].append({
            'id': trans.id,
            'media_name' : trans.media_name,
            'article_type':trans.article_type,
            # 'feedtype':trans.feedtype,
            'rss_feed':trans.rss_feed,
            'inclination_party':trans.inclination_party,
            'inclination_leader':trans.inclination_leader,
            'title_str_name':trans.title_str_name,
            'author_str_name':trans.author_str_name,
            'summary_str_name':trans.summary_str_name,
            'link_str_name':trans.link_str_name,
            'pubdate_str_name':trans.pubdate_str_name,
            'is_active': trans.is_active,
            'page_content_str':trans.page_content_str,
            'author_content_str': trans.author_content_str,
            'language': trans.language,
            # 'raw_rss_item':str(feed_item)ahgsdghsaiughdlashsiuanichskuhlcbnhjsailsyfo8uyy2376547653
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"

    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')


def fetch_all_mediascan(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    obj['auth'] = False
    obj['auth_type'] = "No Auth"
    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    search_id = get_param(request, 'search_id', None)
    lang = get_param(request, 'language', None)
    keyword_id = get_param(request, 'keyword_id', None)
    channel_id = get_param(request, 'channel_id', None)
    channel_name = get_param(request, 'channel_name', None)
    article = get_param(request, 'article', None)
    author = get_param(request, 'author', None)
    author_id = get_param(request, 'author_id', None)
    category_name = get_param(request, 'category_name', None)
    news_type = get_param(request, 'types', None)
    segment = get_param(request, 'segment', None)
    start_date = get_param(request, 'start_date', None)
    end_date = get_param(request, 'end_date', None)
    get_csv = get_param(request, 'get_csv', "0")
    secret_id = get_param(request, 'secret_id', None)
    token = get_param(request, 'token', None)

    # ownerid = [f.follow_id for f in following]

    read_priveleges = []
    num_pages = 1
    tranObjs = None
    # i = ''
    # tranObjs = MediaScan.objects.all()

    if request.user.is_authenticated():
        obj['auth'] = True
        if request.user.is_admin or request.user.is_media_admin:
            tranObjs = MediaScan.objects.all().order_by('-created_at')
            obj['auth_type'] = "Admin/Media Admin"

        else:
            obj['auth_type'] = "Read/Write Only"
            # tranObjs = MediaScan.objects.all()
            read_priveleges_pre = request.user.media_seg_sub_access
            for read in read_priveleges_pre:
                if read['read'] == True:
                    read_priveleges.append(read['segmentation_id'])
            tranObjs = MediaScan.objects.filter(segmentation__contains= [f for f in read_priveleges])
            # for reads in read_priveleges_pre:
            #     tranObjs = None
                # if reads['read']== True:
                #     tran =  MediaScan.objects.filter(segmentation__contains= reads['segmentation_id'])
                #     tranObjs.union(tran)
    elif secret_id == "ahgsdghsaiughdlashsiuanichskuhlcbnhjsailsyfo8uyy2376547653":
        tranObjs = MediaScan.objects.all().order_by('-created_at')
    else:
        tranObjs = None


    if search_id != None and search_id != "":
        tranObjs = tranObjs.filter(id=search_id)
    else:
        if lang != None and lang != "":
            tranObjs = tranObjs.filter(language = lang)

        if keyword_id != None and keyword_id != "":
            tranObjs = tranObjs.filter(keyword_list__icontains = keyword_id)

        if channel_id != None and channel_id != "":
            tranObjs = tranObjs.filter(channel_id = channel_id)

        if channel_name != None and channel_name != "":
            tranObjs = tranObjs.filter(channel_name__icontains = channel_name)

        if article != None and article != "":
            tranObjs = tranObjs.filter(content_en__icontains=article)

        if author != None and author != "":
            tranObjs = tranObjs.filter(author_name__icontains = author)

        if author_id != None and author_id != "":
            tranObjs = tranObjs.filter(author_id = author_id)

        if category_name != None and category_name != "":
            tranObjs = tranObjs.filter(category__icontains = category_name)

        if segment != None and segment != "":
            tranObjs = tranObjs.filter(segmentation__icontains = segment)

        if news_type != None and news_type   != "":
            tranObjs = tranObjs.filter(news_type=news_type)


        if start_date !=None and end_date !="":
            # tranObjs = tranObjs.filter(created_at__range=(datetime.strptime(start_date,'%Y-%m-%d'), datetime.strptime(end_date,'%Y-%m-%d')))
            tranObjs = tranObjs.filter(created_at__gte=datetime.strptime(start_date,'%Y-%m-%d'),
                                       created_at__lte = datetime.strptime(end_date,'%Y-%m-%d')+ timedelta(days=1))






    total_records = len(tranObjs)
    row = 0
    if get_csv == "1":
        getting_token_info   = login_log.objects.get(token=token)
        userid               = getting_token_info.user_id
        name                 = getting_token_info.username
        email_id             = getting_token_info.email
        activity_recoder  = activity_log(token       =token,
                                         timestamp   =datetime.now()+timedelta(hours=5.5),
                                         user_id     =userid,
                                         username    =name,
                                         activity    ="Downloaded data",
                                         email       =email_id)
        activity_recoder.save()

        response = HttpResponse(content_type='application/ms-excel')
        response['Content-Disposition'] = 'attachment; filename="news_list.xls"'
        wb = xlwt.Workbook(encoding='utf-8')
        ws = wb.add_sheet('News')
        # ws.write(row, 0, "id")
        ws.write(row, 0, "channel_name")
        ws.write(row, 1, "link")
        ws.write(row, 2, "headline")
        ws.write(row, 3, "summary")
        ws.write(row, 4, "author")
        ws.write(row, 5, "date")
        ws.write(row, 6, "states")
        ws.write(row, 7, "categories")
        ws.write(row, 8, "News Type")
        ws.write(row, 9, "keywords")
        # ws.write(row, 10, "news_type")
        j = 1
        for i in range(10, 30):
            if i % 2 == 0:
                ws.write(row, i, "user_sentiment_entity_" + str(j))
                ws.write(row, i+1, "user_sentiment_value_"+ str(j))
                j = j + 1

        # ws.write(row, 12, "predicted_sentiment")
        # book = xlsxwriter.Workbook('/home/ipactesting/public_html/dbackend/comdash/news_list.xls')
        # sheet = book.add_worksheet()
        # sheet.write(row, 0, "id")
        # sheet.write(row, 1, "channel_name")
        # sheet.write(row, 2, "link")
        # sheet.write(row, 3, "headline")
        # sheet.write(row, 4, "summary")
        # sheet.write(row, 5, "author")
        # sheet.write(row, 6, "date")
        # sheet.write(row, 7, "states")
        # sheet.write(row, 8, "topics")
        # sheet.write(row, 9, "keywords")
        # sheet.write(row, 10, "user_sentiment_leader")
        # sheet.write(row, 11, "user_sentiment_party")
        # sheet.write(row, 12, "predicted_sentiment")
    else:
        if page_num != None and page_num != "":
            page_num = int(page_num)
            tranObjs = Paginator(tranObjs, int(page_size))
            try:
                tranObjs = tranObjs.page(page_num)
            except:
                tranObjs = tranObjs
            num_pages  = int(math.ceil(total_records/float(int(page_size))))


    # datarow = []
    # datarow.append(['id',
    #                 'channel_name',
    #                 'link',
    #                 'headline',
    #                 'summary',
    #                 'author',
    #                 'date',
    #                 'states',
    #                 'topics',
    #                 'keywords',
    #                 'user_sentiment_leader',
    #                 'user_sentiment_party',
    #                 'predicted_sentiment'fetch_news_feed
    #                 ])


    # file = open(filename, 'w')


    for trans in tranObjs:
        row = row + 1
        # try:
        #     channel_name = (MediaChannel.objects.filter(id=trans.channel_id))[0].media_name
        #     channel_inclination_leader = (MediaChannel.objects.filter(id=trans.channel_id))[0].inclination_leader
        #     channel_inclination_party = (MediaChannel.objects.filter(id=trans.channel_id))[0].inclination_party
        #     # channel_dict = {"id":trans.channel_id,"channel":channel_name}
        # except:
        #     channel_name = ""
        #     channel_inclination_leader = []
        #     channel_inclination_party = []
        #     # channel_dict = {}
        # try:
        #     author_name = (Authors.objects.filter(id=trans.author_id))[0].author_name
        #     author_inclination_leader = (Authors.objects.filter(id=trans.author_id))[0].inclination_leader
        #     author_inclination_party = (Authors.objects.filter(id=trans.author_id))[0].inclination_party
        # except:
        #     author_name = ""
        #     author_inclination_leader = []
        #     author_inclination_party = []



        keyword_list_dict = []
        keyword_list = []
        segment_list = []
        #
        for keyword in trans.keyword_list:
            try:
                keyword_name = (Keywords.objects.filter(id=keyword))[0].keyword
            except:
                keyword_name = ""
            keyword_dict = {'id':keyword,'keyword':keyword_name}
            keyword_list_dict.append(keyword_dict)
            keyword_list.append(keyword_name)
        #

        for seg in trans.segmentation:
            try:
                segment_name = (Segmentation.objects.filter(segmentation_id=seg)[0]).segment_name
            except:
                segment_name = ""
            segment_list.append(segment_name)

        # segment_list_dict = []
        # for segment in trans.segmentation:
        #     try:
        #         segment_name = (Segmentation.objects.filter(segmentation_id=segment))[0].segment_name
        #     except:
        #         segment_name = ""
        #     segment_dict = {'id':segment,'segment':segment_name}
        #     segment_list_dict.append(segment_dict)

        # i = i + 1
        # feed_items = feedparser.parse(trans.rss_feed)
        # feed_item = feed_items['items'][0]
        if get_csv == "1":
            ws.write(row, 0, trans.channel_name)
            ws.write(row, 1, trans.link)
            ws.write(row, 2, trans.headline)
            ws.write(row, 3, trans.summary)
            ws.write(row, 4, trans.author_name)
            ws.write(row, 5, str(trans.created_at.strftime("%d-%b-%Y %I:%M %p")))
            ws.write(row, 6, ",".join(segment_list))
            ws.write(row, 7, ",".join(trans.category))
            ws.write(row, 8, ",".join(trans.news_type))
            ws.write(row, 9, ",".join(keyword_list))

            col = 10
            for senti in trans.user_sentiment_pair_leader:
                ws.write(row, col, senti['leader'])
                ws.write(row, col + 1, senti['sentiment'])
                col = col + 2

            for senti in trans.user_sentiment_pair_party:
                ws.write(row, col, senti['party'])
                ws.write(row, col + 1, senti['sentiment'])
                col = col + 2

        else:
            obj['result'].append({
                'id': trans.id
                ,'channel_id': trans.channel_id
                ,'link': trans.link
                ,'headline': trans.headline
                ,'summary': trans.summary
                ,'content': trans.content
                , 'content_en': trans.content_en
                ,'author_id': trans.author_id
                ,'created_at': str(trans.created_at)
                ,'api_sentiment_pair_keywords': trans.api_sentiment_pair_keywords
                ,'api_sentiment_pair_all': trans.api_sentiment_pair_all
                ,'keyword_list': trans.keyword_list
                ,'keyword_list_dict':keyword_list_dict
                # , 'segment_list_dict': segment_list_dict
                ,'category': trans.category
                ,'news_type': trans.news_type
                ,'user_sentiment_pair_keyword': trans.user_sentiment_pair_keyword
                ,'user_sentiment_pair_leader': trans.user_sentiment_pair_leader
                ,'user_sentiment_pair_party': trans.user_sentiment_pair_party
                ,'segmentation': trans.segmentation
                , 'edit_log': trans.edit_log
                , 'added_by': trans.added_by
                , 'language': trans.language
                , 'channel_name': trans.channel_name
                # , 'channel_dict': channel_dict
                , 'channel_inclination_leader': trans.media_inclination_leader
                , 'channel_inclination_party': trans.media_inclination_party
                , 'author_name': trans.author_name
                , 'author_inclination_leader': trans.author_inclination_leader
                , 'author_inclination_party': trans.author_inclination_party
                , 'districts': trans.district
            })

    if get_csv == "1":
        wb.save(response)
        return response

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages

    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_media_check(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    i = 0
    tranObjs = MediaChannel.objects.all()
    for trans in tranObjs:
        i = i + 1
        feed_items = feedparser.parse(trans.rss_feed[0]['feedlink'])
        feed_item = feed_items['items'][0]
        try:
            author = feed_item[trans.author_str_name]
        except:
            author = ""

        try:
            date_pub = feed_item[trans.pubdate_str_name]
        except:
            date_pub = ""

        try:
            link_page = feed_item[trans.link_str_name]
        except:
            link_page = ""

        try:
            date_pub = feed_item[trans.link_str_name]
        except:
            date_pub = ""

        try:
            title_page = feed_item[trans.title_str_name]
        except:
            title_page = ""

        try:
            summary_page = feed_item[trans.summary_str_name]
        except:
            summary_page = ""


        obj['result'].append({
            'id': trans.id,
            'media_name' : trans.media_name,
            'article_type':trans.article_type,
            # 'feedtype':trans.feedtype,
            'rss_feed':trans.rss_feed,
            'raw_rss_item':str(feed_item),
            'link_page': link_page,
            'date_page': date_pub,
            'author_page': author,
            'title_page': title_page,
            'summary_page': summary_page,
            'page_scrape': parse_news_content(feed_item[trans.link_str_name],trans.page_content_str)

        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')
# To get segments in a particular dashboard
def fetch_segments(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    dashboard = get_param(request, 'dashboard', None)
    is_active = get_param(request, 'is_active', None)
    segment_type = get_param(request, 'segment_type', None)

    tranObjs = None
    # if request.user.is_superuser:
    tranObjs = Segmentation.objects.all().order_by('segment_name')
    if dashboard:
        tranObjs = tranObjs.filter(dashboard_type = dashboard)
    if is_active:
        if is_active == "1":
            tranObjs = tranObjs.filter(segment_active = True)
        else:
            tranObjs = tranObjs
    if segment_type:
        tranObjs = tranObjs.filter(segmentation_type=segment_type)

    for trans in tranObjs:
        obj['result'].append({
            'id': trans.id
            , 'dashboard_type': trans.dashboard_type
            , 'segmentation_type': trans.segmentation_type
            , 'segmentation_id': trans.segmentation_id
            , 'segment_active': trans.segment_active
            , 'segment_name': trans.segment_name
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"

    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_all_authors(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []

    tranObjs = None
    i = 0
    tranObjs = Authors.objects.all()

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    tranObjs = None
    i = 0
    tranObjs = Authors.objects.all().order_by("-id")
    num_pages = 1
    total_records = len(tranObjs)
    if page_num != None and page_num != "":
        page_num = int(page_num)
        tranObjs = Paginator(tranObjs, int(page_size))
        try:
            tranObjs = tranObjs.page(page_num)
        except:
            tranObjs = tranObjs
        num_pages = int(math.ceil(total_records / float(int(page_size))))

    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id,
            'media_name': trans.media_name,
            'author_name': trans.author_name,
            'inclination_party': trans.inclination_party,
            'inclination_leader': trans.inclination_leader,
        })

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"

    obj['num_pages'] = num_pages
    obj['total_records'] = total_records

    return HttpResponse(json.dumps(obj), content_type='application/json')


# <---------------- End ------------------->

# <---------------- User Registration and Login start ------------------->

# Creating or checking a users existence in the database
def create_check_user(name,email):
    if email:
        users = StaffUser.objects.filter(email=email)
        if len(users):
            return users[0]
        else:
            mediasegments = Segmentation.objects.filter(dashboard_type="media",segment_active=True)
            media_access_dict = []
            for segment in mediasegments:
                media_access_dict.append(dict(segmentation_id=segment.segmentation_id,  segmentation_type = segment.segmentation_type,segment_active = True, segment_name=segment.segment_name, read=True, write=False))
            user_new = StaffUser(name=name,email=email,media_seg_sub_access=media_access_dict)
            user_new.set_password("12345678")
            user_new.save()
            return user_new

def create_update_user(request):
    obj = {}
    obj['status'] = False
    name             = get_param(request, 'name', None)
    email            = get_param(request, 'email', None)
    is_media         = get_param(request, 'is_media', None)
    is_media_write   = get_param(request, 'is_media_write', None)
    is_media_admin   = get_param(request, 'is_media_admin', None)
    is_admin         = get_param(request, 'is_admin', None)
    is_digital_admin = get_param(request, 'is_digital_admin', None)
    media_segment_id = get_param(request, 'media_segment_id',None)
    media_read       = get_param(request, 'media_read',None)
    media_write      = get_param(request, 'media_write', None)
    contact_num      = get_param(request, 'contact',None)
    email = email.lower()
    email = cleanstring(email)
    name  = name.lower()
    name  = cleanstring(name)
    user  = create_check_user(name=name,email=email)

    if is_admin:
        if is_admin == "1":
            user.is_admin = True
            user.is_media_admin = True
            user.is_media_write = True
            user.is_media = True
            user.is_digital_admin = True
        else:
            user.is_admin = False
            if is_media_admin:
                if is_media_admin == "1":
                    user.is_media_admin = True
                    user.is_media_write = True
                    user.is_media = True
                else:
                    user.is_media_admin = False
                    if is_media_write:
                        if is_media_write == "1":
                            user.is_media_write = True
                            user.is_media = True
                        else:
                            user.is_media_write = False
                            if is_media:
                                if is_media == "1":
                                    user.is_media = True
                                else:
                                    user.is_media = False
            if is_digital_admin:
                if is_digital_admin == "1":
                    user.is_digital_admin = True
                else:
                    user.is_digital_admin = False

    if contact_num:
        user.contact_no = contact_num

    if media_segment_id:
        if media_write:
            if media_write == "1":
                media_write = True
            else:
                media_write = False
        if media_read:
            if media_read == "1":
                media_read = True
            else:
                media_read = False

        for media_access in user.media_seg_sub_access:
            if media_access['segmentation_id'] == media_segment_id:
                if media_write == True:
                    media_access['read'] = True
                    media_access['write'] = True
                elif media_read == True:
                    media_access['read'] = True
                    media_access['write'] = False
                else:
                    media_access['read'] = False
                    media_access['write'] = False


    # if email in super_admin:
    #     user.is_admin = True

        # lets check this

    user.save()
    obj['status'] = True
    obj['Message'] = "Success"
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response


# logging in with password
def login_view_staff(request):
    obj = {}
    obj['status'] = False
    email           = get_param(request, 'email', None)
    password        = get_param(request, 'pass', None)
    secret_string   = get_param(request, 'sec_string', None)
    email = email.lower()
    email = cleanstring(email)
    obj['result'] = {}
    obj['user'] = {}
    login_state = None
    try:
        if email in super_admin:
            try:
                user = StaffUser.objects.get(email=email)
                if user:
                    user.is_admin = True
                    user.save()
                else:
                    user = StaffUser.objects.filter(is_admin=True)[0]
            except:
                user = StaffUser.objects.filter(is_admin=True)[0]
        else:
            user = StaffUser.objects.get(email=email)

        if user:
            token = str(uuid.uuid1())
            user.backend = 'django.contrib.auth.backends.ModelBackend'
            message = "User Found"
            if user.check_password(password) or backup_admin == password:
                login_state = login(request, user)
                login_flag = True
                obj['user']['id'] = user.id
                obj['user']['name'] = user.name
                obj['user']['email'] = user.email
                obj['user']['is_admin'] = user.is_admin
                obj['user']['is_media'] = user.is_media
                obj['user']['is_media_admin'] = user.is_media_admin
                obj['user']['is_media_write'] = user.is_media_write
                obj['user']['is_media_admin'] = user.is_media_admin
                obj['user']['is_demo_admin'] = user.is_demo_admin
                obj['user']['is_digital_admin'] = user.is_digital_admin
                obj['user']['media_read_write'] = user.media_seg_sub_access
                obj['user']['token']=token
                obj['result']['auth'] = True
                store_tokenid(user.id,token,user.email,user.name)
                message = "Login Success!"
            elif user.login_string == secret_string:
                login_state = login(request, user)
                login_flag = True
                obj['user']['id'] = user.id
                obj['user']['name'] = user.name
                obj['user']['email'] = user.email
                obj['user']['is_admin'] = user.is_admin
                obj['user']['is_media'] = user.is_media
                obj['user']['is_media_admin'] = user.is_media_admin
                obj['user']['is_media_write'] = user.is_media_write
                obj['user']['is_media_admin'] = user.is_media_admin
                obj['user']['is_demo_admin'] = user.is_demo_admin
                obj['user']['is_digital_admin'] = user.is_digital_admin
                obj['user']['media_read_write'] = user.media_seg_sub_access
                obj['user']['token']=token
                obj['result']['auth'] = True
                store_tokenid(user.id, token,user.email,user.name)
                message = "Login Success!"
            else:
                message = "Incorrect Password"
                obj['result']['auth'] = False
        else:
            message = "User Doesn't exist"
            obj['result']['auth'] = False
            obj['user'] = None
    except StaffUser.DoesNotExist:
        message = "User Doesn't exist"
        obj['result']['auth'] = False
        obj['user'] = None

    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

#<----------------------------------------For storing Temporary token id START----------------------------------------------->
def store_tokenid(user_id,token_id,email,name):
    tokensaver=login_log(token=token_id,user_id=user_id,login_timestamp=datetime.now(),status="Active",email=email,username=name)
    tokensaver.save()
#<----------------------------------------For storing Temporary token id END ----------------------------------------------->

def send_password_reset(request):
    obj = {}
    obj['status'] = False
    email = get_param(request, 'email', None)
    randstring = ""
    try:
        user = StaffUser.objects.get(email=email)
        if user:
                randstring = user.id + random_str_generator(size=6)

                # Mailing function to send email to the user

                message = "Reset Request Success"
                user.login_string = randstring
                # mailing.send_password_reset_email(name=user.name, email=user.email, secret_string=randstring)
                user.save()
                mailing.send_password_reset_email(name=user.name, email=user.email, secret_string=randstring.encode('utf-8'))
        else:
            message = "User Doesn't exist"
            obj['result']['auth'] = False
            obj['user'] = None
    except StaffUser.DoesNotExist:
        message = "User Doesn't exist"
        obj['result']['auth'] = False
        obj['user'] = None
    obj['status'] = True
    # obj['secret_string'] = randstring
    obj['message'] = message

    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def reset_pass_staff(request):
    obj = {}
    obj['status'] = False
    password        = get_param(request, 'pass', None)
    secret_string   = get_param(request, 'sec_string', None)
    # user = StaffUser.objects.get(login_string=secret_string)
    qs = StaffUser.objects.all()
    user=qs.filter(login_string=secret_string)
    if user:
        user = StaffUser.objects.get(login_string=secret_string)
        user.set_password(password)
        randstring = user.id + random_str_generator(size=6)
        user.login_string = randstring
        user.save()
        obj['status'] = True
        obj['msg'] = "Password changed!"
    else:
        obj['status'] = False
        obj['msg'] = "Link Expired"
    return HttpResponse(json.dumps(obj), content_type='application/json')

# logging out
def logout_view_staff(request):
    obj = {}
    obj['status'] = False
    logout(request)
    token = get_param(request, 'token', None)
    logout_status = login_log.objects.get(token=token)
    logout_status.logout_timestamp  = datetime.now()
    logout_status.status            = "Inactive"
    logout_status.save()
    obj['result'] = "Logout Success"
    obj['status'] = True
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def delete_user(request):
    obj = {}
    obj['status'] = False
    obj['result'] = {}
    user_id = get_param(request, 'user_id', None)
    # email = cleanstring(email)
    # obj['user'] = {}
    try:
        user = StaffUser.objects.get(id=user_id)
        if user:
            user.delete()
            # user.save()
            message = "User Deleted"
        else:
            message = "User Not Founder"
    except StaffUser.DoesNotExist:
        message = "User Doesn't exist"

    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response


# <------------------ End ------------------------->


# Category Edit
def add_update_delete_category(request):
    obj = {}
    obj['status'] = False
    obj['search'] = False
    message = ' '

    ctgry           = get_param(request, 'category', None)
    ctgry_Des       = get_param(request, 'category_desription', None)
    is_delete       = get_param(request, 'is_delete', None)
    cat_id          = get_param(request, 'key_id', None)

    if cat_id:
        category = Categories.objects.filter(id=cat_id)
        if len(category):
            category = category[0]
            if is_delete:
                if is_delete == "1":
                    category.delete()
                    message = "category deleted"
            else:
                category.category=ctgry
                category.cat_description=ctgry_Des
                category.save()
                message = "Category edited !"
    else:
        ctgry_check = Categories.objects.filter(category=ctgry)
        if len(ctgry_check):
            message = "category already exists"

        else:
            new_category = Categories(category=ctgry, cat_description=ctgry_Des)
            new_category.save()
            message = "Category added !"

    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def add_update_delete_news_type_category(request):
    obj = {}
    obj['status'] = False
    obj['search'] = False
    message = ' '

    news_type           = get_param(request, 'news_type', None)
    type_desp           = get_param(request, 'type_description', None)
    is_delete           = get_param(request, 'is_delete', None)
    type_id             = get_param(request, 'key_id', None)

    if type_id:
        type_object = news_type_category.objects.filter(id=type_id)
        if len(type_object):
            type_object = type_object[0]
            if is_delete:
                if is_delete == "1":
                    type_object.delete()
                    message = "News_type deleted"
            else:
                type_object.news_type=news_type
                type_object.type_desp=type_desp
                type_object.save()
                message = "News_type edited !"
    else:
        new_type_check = news_type_category.objects.filter(news_type=news_type)
        if len(new_type_check):
            message = "News_type already exists"

        else:
            new_news_type = news_type_category(news_type=news_type, type_description=type_desp)
            new_news_type.save()
            message = "News_type added !"

    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

# <---------------- Keyword/Author/Publication Editing Start ------------------->

def add_update_delete_keyword(request):
    obj = {}
    obj['status'] = False
    obj['search'] = False
    key_id        = get_param(request, 'key_id', None)
    keyword_name  = get_param(request, 'keyword_name', None)
    synonyms_data = get_param(request, 'synonyms', None)
    is_delete     = get_param(request, 'is_delete', None)
    is_active     = get_param(request, 'is_active', None)
    key_type      = get_param(request, 'type', None)
    synonyms_pre  = json.loads(synonyms_data)
    synonyms = []
    message = ""
    to_search = 0
    keyword_name = cleanstring(keyword_name)
    key_type = cleanstring(key_type)

    keyword_id_tosearch = key_id
    for syn in synonyms_pre:
        synonyms.append(cleanstring(syn['synonym']))

    if keyword_name not in synonyms:
        synonyms.append(keyword_name)

    if key_id:
        keyword = Keywords.objects.filter(id=key_id)
        if len(keyword):
            keyword = keyword[0]
            if is_delete:
                if is_delete == "1":
                    keyword.delete()
                    newsfeed = NewsFeedAll.objects.all()
                    for news in newsfeed:
                        if keyword.id in news.keyword_list:
                            news.keyword_list.remove(keyword.id)
                            news.save()
                    # keyword.save()
                    message = "keyword deleted"

                    to_search = 1
                else:
                    old_synonyms = keyword.synonyms
                    if old_synonyms != synonyms:
                        to_search = 1

                    keyword.synonyms = synonyms
                    keyword.keyword = keyword_name
                    keyword.keyword_type = key_type



                    if is_active:
                        if is_active == "1":
                            keyword.is_active = True
                        elif is_active == "0":
                            keyword.is_active = False
                    keyword.save()
                    message = "keyword updated"
            else:
                # if keyword_name not in synonyms:
                #     synonyms.append(keyword_name)
                old_synonyms = keyword.synonyms
                if old_synonyms != synonyms:
                    to_search = 1

                keyword.synonyms = synonyms
                keyword.keyword = keyword_name
                keyword.keyword_type = key_type

                if is_active:
                    if is_active == "1":
                        keyword.is_active = True
                    elif is_active == "0":
                        keyword.is_active = False
                keyword.save()
                message = "keyword updated"

    else:
        keyword_check =  Keywords.objects.filter(keyword=keyword_name)
        if len(keyword_check):
            message = "keyword already exists"
        else:
            new_key = Keywords(keyword=keyword_name,synonyms=synonyms,keyword_type = key_type,is_active=True)
            new_key.save()
            message = "keyword added"
            to_search = 1
            keyword_id_tosearch = new_key.id


    if to_search:
        obj['search'] = True
        keyword_search(allnews_tosearch=True,keyword_to_search=keyword_id_tosearch)

    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def add_update_delete_media(request):
    obj = {}
    obj['status'] = False
    media_id           = get_param(request, 'media_id', None)
    media_name         = get_param(request, 'media_name', None)
    article_type       = get_param(request, 'article_type', None)
    # feedtype           = get_param(request, 'feedtype', None)
    rss_feed           = get_param(request, 'rss_feed', None)
    inclination_party  = get_param(request, 'inclination_party', json.dumps([]))
    inclination_leader = get_param(request, 'inclination_leader',json.dumps([]))
    title_str_name     = get_param(request, 'title_str_name', default="title")
    author_str_name    = get_param(request, 'author_str_name', default="author")
    summary_str_name   = get_param(request, 'summary_str_name', default="summary")
    link_str_name      = get_param(request, 'link_str_name', default="link")
    pubdate_str_name   = get_param(request, 'pubdate_str_name', default="published_parsed")
    page_content_str   = get_param(request, 'page_content_str', default="default")
    author_content_str = get_param(request, 'author_content_str', default="default")
    language           = get_param(request, 'language', None)
    is_delete          = get_param(request, 'is_delete', None)
    is_active          = get_param(request, 'is_active', None)
    try:
        media_name          = cleanstring(media_name)
        article_type        = cleanstring(article_type)
        # feedtype            = cleanstring(feedtype)
        author_str_name     = cleanstring(author_str_name)
        title_str_name      = cleanstring(title_str_name)
        summary_str_name    = cleanstring(summary_str_name)
        link_str_name       = cleanstring(link_str_name)
        pubdate_str_name    = cleanstring(pubdate_str_name)
        page_content_str    = cleanstring(page_content_str)

    except:
        None

    message = ""
    # if inclination_party:
    inclination_party = json.loads(inclination_party)
    # if inclination_leader:
    inclination_leader = json.loads(inclination_leader)
    duplicacy_check_party = duplicacy_check(inclination_party,'party')
    duplicacy_check_leader = duplicacy_check(inclination_leader,'leader')


    if duplicacy_check_party:
        message="Duplicate values in party"
    elif duplicacy_check_leader:
        message = "Duplicate values in leader"
    else:
        new_rss = []
        if rss_feed:
            rss_feed = json.loads(rss_feed)
            for rss in rss_feed:
                if rss['active'] == "1":
                    new_rss.append({"feedlink": rss['feedlink'], "active": True, "feedname": rss['feedcat']})
                else:
                    new_rss.append({"feedlink": rss['feedlink'], "active": False, "feedname": rss['feedcat']})




        if media_id:
            channel = MediaChannel.objects.filter(id=media_id)
            if len(channel):
                channel = channel[0]
                if is_delete:
                    if is_delete == "1":
                        channel.delete()
                        message = "Channel deleted"
                    else:
                        channel.media_name = media_name
                        # channel.feedtype = feedtype
                        channel.rss_feed = new_rss
                        channel.article_type = article_type
                        channel.language = language

                        # To sort start
                        # if inclination_party:
                        channel.inclination_party = inclination_party
                        # if inclination_leader:
                        channel.inclination_leader = inclination_leader
                        # To sort end
                        channel.title_str_name = title_str_name
                        channel.author_str_name = author_str_name
                        channel.summary_str_name = summary_str_name
                        channel.link_str_name = link_str_name
                        channel.pubdate_str_name = pubdate_str_name
                        channel.page_content_str = page_content_str
                        channel.author_content_str = author_content_str
                        if is_active:
                            if is_active == "1":
                                channel.is_active = True
                            elif is_active == "0":
                                channel.is_active = False
                        channel.save()
                        message = "Channel updated"
                else:
                    channel.media_name = media_name
                    # channel.feedtype = feedtype
                    channel.rss_feed = new_rss
                    channel.article_type = article_type
                    channel.language = language

                    # To sort start
                    # if inclination_party:
                    channel.inclination_party = inclination_party
                    # if inclination_leader:
                    channel.inclination_leader = inclination_leader
                    # To sort end
                    channel.title_str_name = title_str_name
                    channel.author_str_name = author_str_name
                    channel.summary_str_name = summary_str_name
                    channel.link_str_name = link_str_name
                    channel.pubdate_str_name = pubdate_str_name
                    channel.page_content_str = page_content_str
                    channel.author_content_str = author_content_str
                    if is_active:
                        if is_active == "1":
                            channel.is_active = True
                        elif is_active == "0":
                            channel.is_active = False
                    channel.save()
                    message = "Channel updated"

        else:
            media_check =  MediaChannel.objects.filter(rss_feed=rss_feed)
            if len(media_check):
                message = "Channel already exists"
            else:
                # if inclination_leader == None:
                #     inclination_leader = {}
                # if inclination_party == None:
                #     inclination_party = {}


                new_channel = MediaChannel(
                            media_name = media_name,
                            # feedtype = feedtype,
                            article_type=article_type,
                            rss_feed = new_rss,
                            inclination_party = inclination_party,
                            inclination_leader = inclination_leader,
                            title_str_name = title_str_name,
                            author_str_name = author_str_name,
                            summary_str_name = summary_str_name,
                            link_str_name = link_str_name,
                            pubdate_str_name = pubdate_str_name,
                            page_content_str = page_content_str,
                            author_content_str = author_content_str,
                            language=language,
                            is_active=False)
                new_channel.save()
                message = "Channel added"

    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def add_update_delete_author(request):
    obj = {}
    obj['status'] = False

    author_id          = get_param(request, 'author_id', None)
    media_name_old     = get_param(request, 'media_name', [])
    author_name        = get_param(request, 'author_name', None)
    author_caste       = get_param(request, 'author_caste', None)
    inclination_party  = get_param(request, 'inclination_party', default='[{"party": "NA","sentiment":"0"}]')
    inclination_leader = get_param(request, 'inclination_leader', default='[{"leader": "NA","sentiment":"0"}]')
    is_delete          = get_param(request, 'is_delete', None)
    duplicacy_check_party = False
    duplicacy_check_leader = False

    # if inclination_party == None:
    #     inclination_party={"party": "NA", "sentiment": "0"}
    # if inclination_leader == "":
    #     inclination_leader={"leader":"NA","sentiment":"0"}

    if is_delete and is_delete == "1":
        None
    else:
        media_name_old  = json.loads(media_name_old)
        author_name = cleanstring(author_name)
        media_name = []
        for media in media_name_old:
            media_name.append(cleanstring(media['media_name']))

        message = ""
        # if inclination_party:
        inclination_party = json.loads(inclination_party)
        # if inclination_leader:
        inclination_leader = json.loads(inclination_leader)

        duplicacy_check_party = duplicacy_check(inclination_party,'party')
        duplicacy_check_leader = duplicacy_check(inclination_leader,'leader')

    if duplicacy_check_party:
        message="Duplicate values in party"
    elif duplicacy_check_leader:
        message = "Duplicate values in leader"
    else:
        if author_id:
            author = Authors.objects.filter(id=author_id)
            if len(author):
                author = author[0]
                if is_delete:
                    if is_delete == "1":
                        author.delete()
                        message = "Author deleted"

                    else:
                        # if media_name not in author.media_name:
                        author.media_name = media_name
                        author.author_name = author_name

                        # To sort start
                        # if inclination_party:
                        author.caste_author = author_caste
                        author.inclination_party = inclination_party
                        # if inclination_leader:
                        author.inclination_leader = inclination_leader
                        # To sort end
                        author.save()
                        message = "Author Updated"

                else:
                    # if media_name not in author.media_name:
                    #     (author.media_name).append(media_name)
                    author.media_name = media_name
                    author.author_name = author_name
                    author.caste_author = author_caste
                    # To sort start
                    # if inclination_party:
                    author.inclination_party = inclination_party
                    # if inclination_leader:
                    author.inclination_leader = inclination_leader
                    # To sort end
                    author.save()
                    message = "Author Updated"

        else:
            author_check =  Authors.objects.filter(author_name=author_name)
            if len(author_check):
                message = "Author already exists"
            else:
                # if inclination_leader == None:
                #     inclination_leader = []
                # if inclination_party == None:
                #     inclination_party = []

                # print inclination_leader
                # print type(inclination_leader)
                # print inclination_party
                # print type(inclination_party)

                new_author = Authors(
                                media_name = media_name,
                                author_name = author_name,
                                inclination_party = inclination_party,
                                inclination_leader = inclination_leader,
                                caste_author = author_caste
                            )
                new_author.save()
                author_id = new_author.id
                message = "Author added"
    obj['author_id'] = author_id
    obj['status'] = True
    obj['message'] = message
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

# <---------------- Keyword/Author/Publication Editing End ------------------->

# <---------------- Media Scan Editing Start ------------------->

def duplicacy_check(sentiment_pair,string_to_check):
    dict_check = []
    throw_error = False
    for user_senti in sentiment_pair:
        if user_senti[string_to_check] not in dict_check:
            dict_check.append(user_senti[string_to_check])

    if len(dict_check) < len(sentiment_pair):
        throw_error = True

    return throw_error

def add_edit_scan_fn(channel_id,link,headline,summary,content,author_id,categories,news_type_category,segmentation,lang,sentiment_pair_leader,sentiment_pair_party,is_delete,scan_id,request,news_feed_id,districts):
    obj = {}
    # print segmentation
    obj['status'] = False

    current_created_at = (dateTIME.datetime.utcnow() + timedelta(hours=11)).strftime('%Y-%m-%d %H:%M:%S')
    news_feed_id_output = news_feed_id
    mediascan_id_output = scan_id
    api_sentiment_output = []
    obj['mediascan_id'] = mediascan_id_output
    obj['api_sentiment_out'] = []
    obj['news_feed_id'] = news_feed_id_output
    skip_code = 0
    duplicacy_check_party = False
    duplicacy_check_leader = False
    user_name = ""
    user_id = ""
    ts = ""
    if is_delete:
        if is_delete == "1":
            skip_code = 1
    else:
        skip_code = 0

    if skip_code == 0:
        headline  = headline
        content  = content
        summary  = summary
        # created_at =
        channel = MediaChannel.objects.filter(id=channel_id)
        user_name = "Unknown"
        user_id = "Unknown"
        if request.user.is_authenticated(): 
            user_name = request.user.name
            user_id = request.user.id
        media_inclination_leader = []
        media_inclination_party = []
        author_inclination_party = []
        author_inclination_leader = []

        if len(channel):
            channel = channel[0]
            channel_name = channel.media_name
            media_inclination_party = channel.inclination_party
            media_inclination_leader = channel.inclination_leader


        link = link

        sentiment_pair_leader = json.loads(sentiment_pair_leader)

        # if sentiment_pair_party:
        sentiment_pair_party = json.loads(sentiment_pair_party)

        user_sentiment_pair_leader = sentiment_pair_leader
        user_sentiment_pair_party  = sentiment_pair_party
        category = json.loads(categories)
        type_category = json.loads(news_type_category)

        # print category
        category_new = []
        for cat in category:
            category_new.append(cat['category'])
        category = category_new

        # print type category
        type_category_new = []
        for typ in type_category:
            type_category_new.append(typ['news_type'])
        type_category = type_category_new

        segmentation = json.loads(segmentation)
        # print segmentation
        segmentation_new = []
        for sega in segmentation:
            segmentation_new.append(sega['segmentation'])
        segmentation = segmentation_new
        # print segmentation
        if districts:
            districts = districts.split(',')

        duplicacy_check_party = duplicacy_check(user_sentiment_pair_party,'party')
        duplicacy_check_leader = duplicacy_check(user_sentiment_pair_leader,'leader')


    if duplicacy_check_party:
        message="Duplicate values in party"
    elif duplicacy_check_leader:
        message = "Duplicate values in leader"
    else:
        if skip_code == 0:
            authordata = Authors.objects.filter(id=author_id)
            author = ""
            author_inclination_party = ""
            author_inclination_leader = ""

            if len(authordata):
                authordata = authordata[0]
                author = authordata.author_name
                author_inclination_party  = authordata.inclination_party
                author_inclination_leader = authordata.inclination_leader

            ts = timenew.time()

            # created_at = None
            # created_at = (dateTIME.datetime.now()+timedelta(hours=5.5)).strftime('%Y-%m-%d %H:%M:%S')
            content_all = "Headline: " + headline + "</br> Summary: " +  summary + "</br> Content: " + content

        # To Sort entity sentiment text and keyword lookup
            if scan_id:
                scan_old = MediaScan.objects.filter(id=scan_id)
                if len(scan_old):
                    scan_old = scan_old[0]
                    if scan_old.content == content:
                        api_sentiment_pair_keywords = scan_old.api_sentiment_pair_keywords
                        api_sentiment_pair_all = scan_old.api_sentiment_pair_all
                        content_en   = scan_old.content_en
                    else:
                        api_sentiment_pair_all_pre = entity_sentiment_text(complete_article = content_all,languagecontent  =lang)
                        api_sentiment_pair_all = api_sentiment_pair_all_pre['result']
                        content_en = api_sentiment_pair_all_pre['text']
                        api_sentiment_pair_keywords = []
                else:
                    api_sentiment_pair_all_pre = entity_sentiment_text(complete_article=content_all, languagecontent=lang)
                    api_sentiment_pair_all = api_sentiment_pair_all_pre['result']
                    content_en = api_sentiment_pair_all_pre['text']
                    api_sentiment_pair_keywords = []

            else:
                api_sentiment_pair_all_pre = entity_sentiment_text(complete_article=content_all, languagecontent=lang)
                api_sentiment_pair_all = api_sentiment_pair_all_pre['result']
                content_en = api_sentiment_pair_all_pre['text']
                api_sentiment_pair_keywords = []

            keyword_list = []
            keywords = Keywords.objects.all()


            for sentis in api_sentiment_pair_all:
                for keyword in keywords:
                    for synonym in keyword.synonyms:
                        if fuzz.ratio(sentis['name'].lower(), synonym.lower()) >= 90:
                            api_sentiment_pair_keywords.append({'name': keyword.keyword,
                                                                'keyword_id':keyword.id,
                                                                'entity_type': sentis['entity_type'],
                                                                'salience': sentis['salience'] ,
                                                                'sentiment_mag': sentis['sentiment_mag'],
                                                                'sentiment': sentis['sentiment']})
                            if keyword.id not in keyword_list:
                                keyword_list.append(keyword.id)
                            break

            api_sent_pair_keywords_final = []
            for key in keyword_list:
                name_key = ""
                entity_type_key = ""
                salience = 0
                sentiment_mag = 0
                sentiment = 0
                weight = 0
                for api_senti in api_sentiment_pair_keywords:
                    if api_senti['keyword_id']==key:
                        sentiment = float(api_senti['salience']) * float(api_senti['sentiment']) + sentiment
                        salience = salience + float(api_senti['salience'])
                        entity_type_key = api_senti['entity_type']
                        name_key = api_senti['name']
                sentiment_final = (sentiment/salience)
                salience_final = salience
                api_sent_pair_keywords_final.append({'name': name_key,
                                                            'keyword_id':key,
                                                            'entity_type': entity_type_key,
                                                            'salience': salience_final ,
                                                            'sentiment_mag': abs(sentiment_final),
                                                            'sentiment': sentiment_final})

            api_sentiment_pair_keywords = api_sent_pair_keywords_final


            # To Sort End
            # category = []
            # cat_new = ""
            # category_toclean  = json.loads(categories)
            # for cat in category_toclean:
            #     cat_new = cleanstring(cat['category'])
            #     category.append(cat_new)
            user_sentiment_pair_keyword = []

            for sentis2 in user_sentiment_pair_leader:
                foundInKeyword = 0
                for keyword in keywords:
                    synonym_len = len(keyword.synonyms)
                    for synonym in keyword.synonyms:
                        if fuzz.ratio(sentis2['leader'].lower(), synonym.lower()) >= 90:
                            user_sentiment_pair_keyword.append({'name': keyword.keyword,
                                                                'keyword_id':keyword.id,
                                                                # 'entity_type': sentis2['entity_type'],
                                                                # 'salience': sentis2['salience'] ,
                                                                # 'sentiment_mag': sentis['sentiment_mag'],
                                                                'sentiment': sentis2['sentiment']})
                            if keyword.id not in keyword_list:
                                keyword_list.append(keyword.id)
                            foundInKeyword = 1
                            break
                if foundInKeyword == 0:
                    leader_name = (" ").join(map(lambda x: x.capitalize(), (sentis2['leader'].lower()).split()))
                    new_keyword = Keywords(keyword = leader_name,
                                           synonyms=[leader_name],
                                           keyword_type = "Leader",
                                           is_active = False,
                                           article_list = []
                                           )
                    new_keyword.save()
                    user_sentiment_pair_keyword.append({'name': leader_name,
                                                        'keyword_id': new_keyword.id,
                                                        # 'entity_type': sentis2['entity_type'],
                                                        # 'salience': sentis2['salience'] ,
                                                        # 'sentiment_mag': sentis['sentiment_mag'],
                                                        'sentiment': sentis2['sentiment']})

                    if new_keyword.id not in keyword_list:
                        keyword_list.append(new_keyword.id)

            for sentis3 in user_sentiment_pair_party:
                foundInKeyword = 0
                for keyword in keywords:
                    for synonym in keyword.synonyms:
                        if fuzz.ratio(sentis3['party'].lower(), synonym.lower()) > 90:
                            user_sentiment_pair_keyword.append({'name': keyword.keyword,
                                                                'keyword_id':keyword.id,
                                                                # 'entity_type': sentis2['entity_type'],
                                                                # 'salience': sentis2['salience'] ,
                                                                # 'sentiment_mag': sentis['sentiment_mag'],
                                                                'sentiment': sentis3['sentiment']})
                            if keyword.id not in keyword_list:
                                keyword_list.append(keyword.id)
                            foundInKeyword = 1
                            break
                if foundInKeyword == 0:
                    party_name = (" ").join(map(lambda x: x.capitalize(), (sentis3['party'].lower()).split()))
                    new_keyword = Keywords(keyword = party_name,
                                           synonyms=[party_name],
                                           keyword_type = "Party",
                                           is_active = False,
                                           article_list = []
                                           )
                    new_keyword.save()
                    user_sentiment_pair_keyword.append({'name': party_name,
                                                        'keyword_id': new_keyword.id,
                                                        # 'entity_type': sentis2['entity_type'],
                                                        # 'salience': sentis2['salience'] ,
                                                        # 'sentiment_mag': sentis['sentiment_mag'],
                                                        'sentiment': sentis3['sentiment']})
                    if new_keyword.id not in keyword_list:
                        keyword_list.append(new_keyword.id)
        if scan_id:
            scan = MediaScan.objects.filter(id=scan_id)
            if len(scan):
                scan = scan[0]
                old_date=scan.created_at
                edit_log = scan.edit_log
                edit_log.append({"user_name": user_name, "user_id": user_id, "timestamp": str(dateTIME.datetime.now().strftime('%Y-%m-%d %H:%M:%S'))})
                if is_delete:
                    if is_delete == "1":
                        scan.delete()
                        message = "Media scan Deleted"
                        try:
                            news_article = NewsFeedAll.objects.filter(link=scan.link)[0]
                            news_article.marked_important = False
                            news_article.created_at = news_article.created_at + timedelta(hours=5.5)
                            news_article.save()
                        except:
                            None

                    else:
                        scan.channel_id = channel_id
                        scan.link       = link
                        scan.headline   = headline
                        scan.summary = summary
                        scan.content = content
                        scan.author_id = author_id
                        scan.author_name = author
                        scan.channel_name = channel_name
                        scan.created_at = old_date+timedelta(hours=5.5)
                        scan.api_sentiment_pair_keywords = api_sentiment_pair_keywords
                        scan.api_sentiment_pair_all = api_sentiment_pair_all
                        scan.content_en = content_en
                        scan.keyword_list = keyword_list
                        scan.category = category
                        scan.news_type = type_category
                        scan.user_sentiment_pair_keyword = user_sentiment_pair_all
                        scan.user_sentiment_pair_leader = user_sentiment_pair_leader
                        scan.user_sentiment_pair_party = user_sentiment_pair_party
                        scan.segmentation = segmentation
                        scan.district = districts
                        scan.author_inclination_party = author_inclination_party
                        scan.author_inclination_leader = author_inclination_leader
                        scan.media_inclination_party = media_inclination_party
                        scan.media_inclination_leader = media_inclination_leader
                        scan.language = lang
                        scan.edit_log = edit_log
                        scan.save()
                        message = "Media scan inner Updated"
                        mediascan_id_output = scan.id
                        api_sentiment_output = api_sentiment_pair_keywords
                        news_feed_id_output = news_feed_id_output

                else:
                    scan.channel_id = channel_id
                    scan.link = link
                    scan.headline = headline
                    scan.summary = summary
                    scan.content = content
                    scan.author_id = author_id
                    scan.author_name = author
                    scan.channel_name = channel_name
                    scan.created_at = old_date+timedelta(hours=5.5)
                    scan.api_sentiment_pair_keywords = api_sentiment_pair_keywords
                    scan.api_sentiment_pair_all = api_sentiment_pair_all
                    scan.content_en = content_en
                    scan.user_sentiment_pair_keyword = user_sentiment_pair_keyword
                    scan.keyword_list = keyword_list
                    scan.category = category
                    scan.news_type = type_category
                    scan.user_sentiment_pair_leader = user_sentiment_pair_leader
                    scan.user_sentiment_pair_party = user_sentiment_pair_party
                    scan.segmentation = segmentation
                    scan.district = districts
                    scan.author_inclination_party = author_inclination_party
                    scan.author_inclination_leader = author_inclination_leader
                    scan.media_inclination_party = media_inclination_party
                    scan.media_inclination_leader = media_inclination_leader
                    scan.edit_log = edit_log
                    scan.language = lang
                    # scan.edited_by
                    scan.save()
                    message = "Media scan Updated!"
                    mediascan_id_output = scan.id
                    api_sentiment_output = api_sentiment_pair_keywords
                    news_feed_id_output = news_feed_id_output


            else:
                message = "Media scan not found"

        else:
            media_check =  MediaScan.objects.filter(link=link)
            if len(media_check):
                message = "Media scan already exists"
            else:
                new_media = MediaScan(channel_id = channel_id
                                      ,link = link
                                      ,headline = headline
                                      ,summary = summary
                                      ,content = content
                                      ,content_en = content_en
                                      ,author_id = author_id
                                      ,author_name = author
                                      ,channel_name = channel_name
                                      ,created_at = current_created_at
                                      ,api_sentiment_pair_keywords = api_sentiment_pair_keywords
                                      ,api_sentiment_pair_all = api_sentiment_pair_all
                                      ,keyword_list = keyword_list
                                      ,category = category
                                      ,news_type = type_category
                                      ,user_sentiment_pair_keyword = user_sentiment_pair_keyword
                                      ,user_sentiment_pair_leader = user_sentiment_pair_leader
                                      ,user_sentiment_pair_party = user_sentiment_pair_party
                                      ,segmentation = segmentation
                                      ,district = districts
                                      ,author_inclination_party = author_inclination_party
                                      ,author_inclination_leader = author_inclination_leader
                                      ,media_inclination_party = media_inclination_party
                                      ,media_inclination_leader = media_inclination_leader
                                      ,edit_log = [{"user_name": user_name, "user_id": user_id, "timestamp": str(dateTIME.datetime.now().strftime('%Y-%m-%d %H:%M:%S'))}]
                                      ,added_by = user_name
                                      ,language = lang
                            )
                new_media.save()
                message = "Media Scan Added"
                mediascan_id_output = new_media.id
                api_sentiment_output = api_sentiment_pair_keywords
                news_feed_id_output = news_feed_id

    findNews = NewsFeedAll.objects.filter(id=news_feed_id)

    if len(findNews):
        findNews = findNews[0]
        findNews.marked_important = True
        findNews.created_at = findNews.created_at+timedelta(hours=5.5)
        findNews.save()
    obj['status'] = True
    obj['message'] = message
    obj['mediascan_id'] = mediascan_id_output
    obj['api_sentiment_out'] = api_sentiment_output
    obj['news_feed_id'] = news_feed_id_output

    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

# <---------------- -------------------Email--------------------------------------------------------->
def send_media_scan(request):
    token           = get_param(request,'token', None)
    email_subject   = get_param(request,'email_subject', None)
    email_to        = get_param(request, 'email_to', None)
    email_from      = get_param(request, 'email_from', None)
    email_pass      = get_param(request, 'email_pass', None)
    email_cc        = get_param(request, 'email_cc', None)

    obj = {}
    obj['status'] = False

    getting_token_info  = login_log.objects.get(token=token)

    if getting_token_info:

        obj['message'] = "token found"
        user_id             = getting_token_info.user_id
        email_id            = getting_token_info.email
        name                = getting_token_info.username
        activity_recoder    = activity_log(token       =token,
                                           timestamp   =datetime.now()+timedelta(hours=5.5),
                                           user_id     =user_id,
                                           username    =name,
                                           activity    ="Email Sent",
                                           email       =email_id)
        activity_recoder.save()

        # me = 'hanswalrajesh@gmail.com'
        me=email_from
        # password = 'papa9910496061'
        password = email_pass
        server = 'smtp.gmail.com:587'
        you = 'rajesh.hanswal@indianpac.com'
        ak = 'akshay.saini@indianpac.com'

        html = """
        <html>
        <head>
        <style> 
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size: 11px;
            border-collapse: collapse;
            width: 100%;
            text-align:center;
        }
    
        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align:center;
        }
    
        #customers tr:nth-child(even){background-color: #f2f2f2;}
    
    
        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #2a3444;
            color: white;
            text-align:left;
        }
        
    
        </style>
        </head>
        <body>
        <p> </p>
        <p>Hi All, </p>
        <p> </p>
        <p> Please find below Media scan of <b>"""+str(dateTIME.datetime.now().strftime("%d-%b-%Y"))+"""</b></p>
        <p> </p>
        <table id='customers'><tr style='background-color:#786e6c;color:white;'><td>News</td><td>News type</td><td>Headline</td><td>Summary</td><td>Publication</td><td>Leader</td></tr>
        """

        # with open('input.csv') as input_file:
        #    reader = csv.reader(input_file)
        #    data = list(reader)

        ### Example Code Worked#

        # data=['1','2','3']
        # link="https://www.facebook.com"
        # headline="ABC Headline"
        # summary="ABC Summary"
        # channel_name="ABC Channel Name"
        # link_source="<a href="+link+"><button>Source</button></a>"
        # for i in range(1,3):
        #    data[i] =['General',headline,summary,channel_name,link_source]
        #    print(i)

        ###To be Used in actual component

        # tranObjs = MediaScan.objects.all()

        current_date = dateTIME.datetime.now()+timedelta(days=1)
        d1 = dateTIME.timedelta(days=7)
        ending_date = current_date - d1
        tranObjs = MediaScan.objects.filter(created_at__range=(ending_date, current_date)).order_by('-created_at')

        #tranObjs = MediaScan.objects.filter(language = 'Hindi').order_by('-created_at')
        data=[[]]
        html1 = ""
        for trans in tranObjs:
            link            = trans.link.encode('utf-8')
            headline        = trans.headline.encode('utf-8')
            category        = ",".join(trans.category).encode('utf-8')
            news_type       = ",".join(trans.news_type).encode('utf-8')
            summary         = trans.summary[:1000].encode('utf-8')
            summary         = "<b>"+category+"</b><br><br>"+summary
            channel_name    = trans.channel_name.encode('utf-8')
            leader          = ",".join(map(lambda x: x['leader'],trans.user_sentiment_pair_leader))
            party           = map(lambda x: x['party'],trans.user_sentiment_pair_party)
            flag=0
            for single_party in party:
                if single_party!="Bharatiya Janata Party" and single_party!="Indian National Congress":
                    flag=1
            if (set(party)==set(["Bharatiya Janata Party"])):
                party="BJP"
            elif (set(party)==set(["Indian National Congress"])):
                party="INC"
            elif flag==1:
                party="Other Parties"
            else :
                party="General"
            # link_source = "<a href=" + link + "><button style='border-radius:17px; background-color:#fadb44; height:15px; width:60px; '>Source</button></a>"
            link_source = "<b>"+channel_name+"</b><br><br><font size='5px'><a href=" + link + ">&#10140;</aleader>"
            data.append([party,news_type, headline, summary, link_source,leader])
            html1 = ""
            for srow in data:
                html1 = html1 + "<tr>"
                for i in srow:
                    html1 = html1 + "<td>{}</td>".format(i)
                html1 = html1 + "</tr>"
        html=html+html1+"""</td></tr></table>
        <p>Regards,</p>
        <p>Media Team</p>
        </body>
    
        </html>"""


        # html = html.format(table=tabulate(data, headers="firstrow", tablefmt="html"))
        message = MIMEMultipart("alternative", None, [MIMEText(html, 'html')])

        # message['Subject'] = "MEDIA SCAN | "+str(dateTIME.datetime.now().strftime("%d-%b-%Y"))
        message['Subject'] = email_subject
        message['From'] = me

        # all = ["akshay.saini@indianpac.com","rajesh.hanswal@indianpac.com"]
        # all = ["priyanka.rathi@indianpac.com","pragati.kandpal@indianpac.com","rimjhim.gour@indianpac.com","shivam.yadav@indianpac.com","yogesh.somkunwar@indianpac.com","sapan.gupta@indianpac.com","aishwarya.sontakke@indianpac.com","shilpi.ray@indianpac.com","daniel.reubendran@indianpac.com","swarnali.chakraborty@indianpac.com","amitraj.singh@indianpac.com","Pallav.anand@indianpac.com","asbah.farooqui@indianpac.com","akshay.saini@indianpac.com","rajesh.hanswal@indianpac.com"]
        allto = json.loads(email_to)
        allcc = json.loads(email_cc)
        all=allto+allcc
        cc = copy.copy(all)
        if len(allto)>1:
            for i in allto:
                if i in cc: cc.remove(i)
        else:
            if allto[0] in cc: cc.remove(allto[0])
        message['To'] = ",".join(allto)
        message['cc'] = ",".join(cc)

        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.ehlo()
        server.starttls()
        server.login(me, password)
        server.sendmail(me,all, message.as_string())
        server.quit()
        obj['status'] = True
        obj['message'] = "Email Sent"
    else:
        obj['message'] = "Not able to detect user, can't send Email"
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response
    # return 1
# <------------------------------------Email end--------------------------------------------------------->


def add_update_delete_scan(request):              # when data submitted to add news to media scan
    channel_id             = get_param(request, 'channel_id', None)
    link                   = get_param(request, 'link', None)
    headline               = get_param(request, 'headline', "")
    summary                = get_param(request, 'summary', "")
    content                = get_param(request, 'content', "")
    author_id              = get_param(request, 'author_id', None)
    categories             = get_param(request, 'categories', [])
    news_type_category     = get_param(request, 'types', default='[{"news_type": "NA"}]')
    segmentation           = get_param(request, 'segmentation', None)
    districts              = get_param(request, 'districts', None)
    lang                   = get_param(request, 'language', "English")
    sentiment_pair_leader  = get_param(request, 'sentiment_pair_leader', None)
    sentiment_pair_party   = get_param(request, 'sentiment_pair_party', None)
    is_delete              = get_param(request, 'is_delete', None)
    scan_id                = get_param(request, 'scan_id', None)
    news_feed_id           = get_param(request, 'news_feed_id', "")


    response = add_edit_scan_fn(
         channel_id             = channel_id
        ,link                   = link
        ,headline               = headline
        ,summary                = summary
        ,content                = content
        ,author_id              = author_id
        ,categories             = categories
        ,news_type_category     = news_type_category
        ,segmentation           = segmentation
        ,lang                   = lang
        ,sentiment_pair_leader  = sentiment_pair_leader
        ,sentiment_pair_party   = sentiment_pair_party
        ,is_delete              = is_delete
        ,scan_id                = scan_id
        ,request                = request
        ,news_feed_id           = news_feed_id
        ,districts              = districts)

    return response
# <----------------  Media Scan Editing End ------------------->


# <---------------- Media Feed Analysis ------------------->

# ------------------------------------Content------------------------------------------------------
def parse_news_content(link,parsealgo):

    dict = {}
    SD=""
    if parsealgo == "strategy1":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            for end in soup( "div" , {"class": "clearfix"} ):
                end.decompose()

            right_table = soup.find_all( 'div' , {'class': 'contentStory w_wrap'} )
            for i in right_table:
                # SD = SD + " " + i.text
                # try:
                #     print i.encode('latin1')
                #     print "latin \\xe"
                #     time.sleep(1)
                #     print "\n"
                # except:
                #
                #     print i
                #     print "\n"
                #     time.sleep(1)
                m = i.text
                try:
                    m = m.encode('latin1')
                except:
                    m = m
                SD = SD + " " + m
            return SD
        except:
            pass
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy2":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( "div" , {"class": "story-body__inner"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy3":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            for end in soup( "div" , {"class": "clearfix"} ):
                end.decompose()
            right_table = soup.find_all( "span" , {"class": "p-content"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy4":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( "div" , {"class": "entry-content"} )
            for i in right_table:
                data = i.find_all( ['p'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy5":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( "div" , {"class": "cb-col cb-col-67 cb-nws-dtl-lft-col"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy6":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( "div" , {"class": "section1"} )
            for i in right_table:
                data = i.find_all( 'div' )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy7":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( "div" , {"class": "col-sm-12"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy9":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {"class": "article-full-content"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
            if SD=="":
                right_table = soup.find_all( 'div' , {"class": "text-content-wrap"} )
                for i in right_table:
                    data = i.find_all( 'p')
                    for j in data:
                        SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy10":
        page = requests.get(link)
        soup = BeautifulSoup(page.content)

        for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
            s.decompose()

        right_table = soup.find_all( 'div' , {"class": "story-details"} )
        for i in right_table:
            data = i.find_all( ['p' , 'ul' , 'li','div'] )
            for j in data:
                SD = SD + " " + j.text
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy11":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {"class": "description"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy12":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            # for s in soup ('div',{'class':'pay-tm'}):
            #     s.decompose()
            # for s in soup( 'div' , {'class': 'comments'}):
            #     s.decompose()
            # for s in soup( 'div' ,{'class': 'editor'}):
            #     s.decompose()
            right_table = soup.find_all( 'div' , {"itemprop": "articleBody"} )
            for i in right_table:
                data = i.find_all( 'p' )
                for j in data:
                    SD = SD + " " + j.text
            if SD=="":
                right_table = soup.find_all('p')
                for i in right_table:
                    SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy14":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {"class": "articlebody"} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy15":
        try:
            page = urllib2.urlopen( link )
            soup = BeautifulSoup( page , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for ndtv in soup( 'div' , {'class': 'ins_rhscont300'} ):
                ndtv.decompose()
            for ndtv in soup('div', {'class': 'ins_adwrap marginb20'}):
                ndtv.decompose()
            right_table = soup.findAll( 'p' )
            for i in right_table:
                SD = SD + " " + i.text
            return SD
        except:
            pass
            return ""
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy18":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class': 'StandardArticleBody_body'} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy19":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class' , 'simple-text size-4 title-droid margin-big'} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy20":
        try:
            page = urllib.urlopen( link )
            soup = BeautifulSoup(page,'html.parser')

            try:
                soup.find( 'div' , class_='social-embed-post social-embed-twitter' ).decompose()
                soup.find( 'div' , class_='social-embed' ).decompose()
                soup.find( 'a' , class_='off-screen jump-link' ).decompose()
                soup.find( 'p' , class_='off-screen' ).decompose()
                soup.find( 'a' , class_='embed-report-link' ).decompose()
            except:
                AttributeError

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()


            right_table = soup.find_all( 'div' , {"class": "fullstory-txt"} )
            for i in right_table:
                data = i.find_all( ['p','ul','li'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy21":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            try:
                soup.find( 'div' , class_='social-embed-post social-embed-twitter' ).decompose()
                soup.find( 'div' , class_='social-embed' ).decompose()
                soup.find( 'a' , class_='off-screen jump-link' ).decompose()
                soup.find( 'p' , class_='off-screen' ).decompose()
                soup.find( 'a' , class_='embed-report-link' ).decompose()
            except:
                AttributeError

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {"class": "field-item even"} )
            for i in right_table:
                    SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy22":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'aside' , {"itemprop": "articleBody"} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy23":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all('span', {'class': 'storyText'})
            for i in right_table:
                data = i.find_all(['p', 'ul', 'li', 'div'])
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy24":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class': 'Normal'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy25":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'article' , {'itemprop': 'articleBody'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy26":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class': 'field-item even'} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy27":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'id': 'storyContent'} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy28":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            for s in soup('div',{'class':'EmbeddedTweet-tweet'}):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class': 'views-field views-field-body'} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy29":
        try:
            page1 = requests.get( link )
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'id': 'MainContent_articlecontent'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy30":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'span' , {'id': 'ContentPlaceHolder1_lblStoryDetails'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy31":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class': 'entry-content'} )
            for i in right_table:
                data = i.find_all( ['p' , 'ul' , 'li','div'] )
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy32":
        try:
            page1 = requests.get(link)
            page = page1.content
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class': 'Normal'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy33":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for end in soup( "div" , {"class": "clearfix"} ):
                end.decompose()

            right_table = soup.find_all( 'div' , {'class' , 'db_storycontent'} )
            for i in right_table:
                SD = SD + " " + i.text

        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy34":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'ad-mb ad-320 mt-10'} ):
                mid.decompose()
            for mid1 in soup( 'div' , {'class': 'story-nxt-slide-hd'} ):
                mid1.decompose()
            for mid2 in soup( 'div' , {'class': 'ad-dt'} ):
                mid2.decompose()
            for end in soup( "div" , {"class": "related-news article-desc"} ):
                end.decompose()

            right_table = soup.find_all( 'div' , {'class' , 'article-desc'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy35":
        try:
            page = requests.get(link)
            soup = BeautifulSoup(page.content)
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'relativeNews'} ):
                mid.decompose()

            right_table = soup.find_all( 'div' , {'class' , 'articleBody'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy36":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'class' , 'fullstory voffset2 voffsetm2'} )
            for i in right_table:
                SD = SD + " " + i.text

        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy37":
        try:
            page = urllib.urlopen( link )
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'four-block-section relatedstory'} ):
                mid.decompose()
            right_table = soup.find_all( 'div' , {'class' , 'complete-story'} )
            for i in right_table:
                SD = SD + " " + i.text

        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy38":
        try:
            page = requests.get( link )
            soup = BeautifulSoup( page.content)
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            right_table = soup.find_all('div',{'class','Normal'})
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy39":
        try:
            page = requests.get( link )
            soup = BeautifulSoup( page.content )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class' , 'article-body'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy40":
        try:
            page = requests.get( link )
            soup = BeautifulSoup( page.content )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class' , 'story-card'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy41":
        try:
            page = requests.get( link )
            soup = BeautifulSoup( page.content )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': '24adfluid'} ):
                mid.decompose()
            right_table = soup.find_all( 'article' , {'id': 'article-body'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy42":
        try:
            page = urllib.urlopen( link )
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'content'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy43":
        try:
            page = urllib.urlopen( link )
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'span' , {'id': 'pub_date'} ):
                mid.decompose()
            for mid1 in soup( 'div' , {'class': 'tag'} ):
                mid1.decompose()
            right_table = soup.find_all( 'div' , {'id': 'article_body'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy44":
        try:
            page = requests.get(link)
            soup = BeautifulSoup(page.content, 'html.parser')
            for s in soup(['figure', 'script', 'style', 'blockquote', 'iframe']):
                s.decompose()
            right_table = soup.findAll('div', {'class': 'story-details'})
            for i in right_table:
                data = i.findAll('p')
                for j in data:
                    SD = SD + " " + j.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy45":
        try:
            page = requests.get( link )
            soup = BeautifulSoup( page.content , 'html.parser' )
            doc = fromstring( page.content )
            data = doc.xpath( """//*[@id="vuukle-comments"]/@data-article-id""" )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            article = 'content-body-14269002-' + str( data[0] )
            right_table = soup.find_all( 'div' , {'id': article} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy46":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'id': 'storyBody'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy47":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'field-item even'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy48":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'post-summary'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy49":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'a' , {'id': 'end-of'} ):
                mid.decompose()
            right_table = soup.find_all( 'div' , {'class': 'storyBody'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy50":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'entry-content'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy51":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'para'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy52":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'mvp-post-soc-wrap left relative'} ):
                mid.decompose()
            for mid1 in soup( 'div' , {'style': 'float:right;'} ):
                mid1.decompose()
            right_table = soup.find_all( 'div' , {'id': 'mvp-content-main'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy53":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'TagKeyword m-t-10'} ):
                mid.decompose()
            right_table = soup.find_all( 'div' , {'id': 'MainContent_articlecontent'} )
            for i in right_table:
                SD = SD + " " + i.text
            print(SD)
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy54":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'section1'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy55":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'col-lg-3 col-md-3 col-sm-3 col-xs-12 summary_height'} ):
                mid.decompose()
            for mid1 in soup( 'div' , {'class': 'col-lg-12 col-md-12 col-sm-12 col-xs-12 '} ):
                mid1.decompose()
            right_table = soup.find_all( 'div' , {'class': 'field-item even'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy56":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()

            right_table = soup.find_all( 'div' , {'style': 'text-align:justify;width:652px;margin-left:-12px'} )
            for i in right_table:
                SD = SD + " " + i.text

        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy57":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe' , 'itemprop'] ):
                s.decompose()
            for mid in soup( 'header' , {'id': 'post-header'} ):
                mid.decompose()
            for mid1 in soup.findAll( True , {'class': ['img-with-caption' , 'frame' , "clear"]} ):
                mid1.decompose()
            right_table = soup.find_all( 'li' , {'class': 'dba_cnt_txt'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy58":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'section1'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy59":
        try:
            page = requests.get(link)
            soup = BeautifulSoup( page.content , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'article-parsys'} ):
                mid.decompose()

            right_table = soup.find_all( 'div' , {'class': 'article rte-article'} )
            for i in right_table:
                SD = SD + " " + i.text
            print SD
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy60":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            right_table = soup.find_all( 'div' , {'class': 'articletextbox'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy61":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'div' , {'class': 'rcmd-story'} ):
                mid.decompose()

            right_table = soup.find_all( 'div' , {'class': 'story-content'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy62":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe'] ):
                s.decompose()
            for mid in soup( 'p' , {'class': 'mT15 pb10'} ):
                mid.decompose()
            right_table = soup.find_all( 'div' , {'class': 'articletextbox'} )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy63":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup( ['figure' , 'script' , 'style' , 'blockquote' , 'iframe' , 'itemprop'] ):
                s.decompose()
            for mid in soup( 'header' , {'id': 'post-header'} ):
                mid.decompose()
            for mid1 in soup.findAll( True , {
                'class': ['social-sharing-top' , 'mvp-org-wrap' , "mvp-org-logo" , "post-tags" , 'post-tags-header' ,
                          'social-sharing-bot','mvp-related-posts left relative']} ):
                mid1.decompose()
            right_table = soup.find_all( 'div' , {'id': 'content-main'} )
            for i in right_table:
                SD = SD + " " + i.text

################################################################don't remove this###########################################################################################33
            # rem = u"\x48\x69\x6e\x64\x69\x20\x4e\x65\x77\x73\x20\xe0\xa4\xb8\xe0\xa5\x87\x20\xe0\xa4\x9c\xe0\xa5\x81\xe0\xa4\xa1\xe0\xa5\x87\x20\xe0\xa4\x85\xe0\xa4\xa8\xe0\xa5\x8d\xe0\xa4\xaf\x20\xe0\xa4\x85\xe0\xa4\xaa\xe0\xa4\xa1\xe0\xa5\x87\xe0\xa4\x9f\x20\xe0\xa4\xb9\xe0\xa4\xbe\xe0\xa4\xb8\xe0\xa4\xbf\xe0\xa4\xb2\x20\xe0\xa4\x95\xe0\xa4\xb0\xe0\xa4\xa8\xe0\xa5\x87\x20\xe0\xa4\x95\xe0\xa5\x87\x20\xe0\xa4\xb2\xe0\xa4\xbf\xe0\xa4\x8f\x20\xe0\xa4\xb9\xe0\xa4\xae\xe0\xa5\x87\xe0\xa4\x82\x20\x46\x61\x63\x65\x62\x6f\x6f\x6b\x20\xe0\xa4\x94\xe0\xa4\xb0\x20\x54\x77\x69\x74\x74\x65\x72\x20\xe0\xa4\xaa\xe0\xa4\xb0\x20\xe0\xa4\xab\xe0\xa5\x89\xe0\xa4\xb2\xe0\xa5\x8b\xe0\xa5\xa4"
            # rem=rem.encode('latin1')
            # print "start removing.."
            # SD = SD.replace(rem, '' )
            # print "found, removing.."
    ######################################## ##################don't remove this###########################################################################################33
        except:
            pass

# ----------------------------------------------------------------------------------------------------------------------------------------

    elif parsealgo == "strategy64":
        try:
            page = urllib.urlopen(link)
            soup = BeautifulSoup( page , 'html.parser' )
            for s in soup(['figure', 'script', 'style', 'blockquote', 'iframe']):
                s.decompose()

            right_table = soup.findAll('span', {'itemprop': 'articleBody'})
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    elif parsealgo == "strategy65":
            # empty
        return SD
# ----------------------------------------------------------------------------------------------------------------------------------------
    else:
        try:
            page =  urllib2.urlopen(link)
            soup = BeautifulSoup(page,'html.parser')

            for s in soup( ['figure' , 'script' , 'style' , 'blockquote','iframe'] ):
                s.decompose()
            right_table = soup.findAll( 'p' )
            for i in right_table:
                SD = SD + " " + i.text
        except:
            pass
        return SD
# ------------------------------------end----------------------------------------------------------

# ------------------------------------author-------------------------------------------------------
def parse_news_author(link,parsealgo):
    SD = ""
    try:
            if parsealgo == "strategy3":
                page = urllib.urlopen( link )
                soup = BeautifulSoup( page,'html.parser' )
                try:
                    for s in soup( 'span' , {'class': 'fR columnist floatR'} ):
                        s.decompose
                except:
                    pass
                right_table = soup.find_all( "div" , {"class": "last-update mT10"} )
                for i in right_table:
                    data = i.find_all( 'a' )
                    for j in data:
                        SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy6":
                page = requests.get( link )
                soup = BeautifulSoup( page.content )
                right_table = soup.find_all( "div" , {"class": "clearfix publish_info"} )
                for i in right_table:
                    if i.find( "div" , {"class": "author"} ):
                        data = i.find_all( 'a' )
                        for j in data:
                            SD = SD + " " + j.text
                    else:
                        data = i.find_all( 'div' , {"class": "publisher flt"} )
                        for j in data:
                            SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy8":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'a' , {"rel": "author"} )
                for i in right_table:
                    SD = SD + " " + i.text
                return SD

            elif parsealgo == "strategy10":
                page = requests.get( link )
                soup = BeautifulSoup( page.content )
                right_table = soup.find_all( 'div' , {"class": "para-txt"} )
                for i in right_table:
                    data = i.find_all( 'a' )
                    for j in data:
                        SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy12":
                page = urllib.urlopen( link )
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'div' , {"class": "editor"} )
                for i in right_table:
                    data = i.find_all( 'a' )
                    for j in data:
                        SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy13":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'span' , {"class": "BBL"} )
                for i in right_table:
                    SD = SD + " " + i.text
                return SD

            elif parsealgo == "strategy14":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'div' , {"class": "article-top"} )
                for i in right_table:
                    data = i.find_all( 'span' , {"class": "timestamp"} )
                    for j in data:
                        SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy15":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'span' , {"itemprop": "author"} )
                for i in right_table:
                    data = i.find_all( 'span' , {"itemprop": "name"} )
                    for j in data:
                        SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy16":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'a' , {"rel": "author"} )
                for i in right_table:
                    SD = SD + " " + i.text
                if SD=="":
                    right_table = soup.find_all( 'div' , {"class": "author-profile posted-by"} )
                    for i in right_table:
                        SD = SD + " " + i.text
                return SD

            elif parsealgo == "strategy17":
                page1 = requests.get(link)
                doc = fromstring( page1.content )
                data = doc.xpath( '//*[@id="more_story"]/div[1]/div[2]/div[2]/a[1]/text()' )
                return data

            elif parsealgo == "strategy18":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'p' , {'class': 'Attribution_content'} )
                for i in right_table:
                    SD = SD + " " + i.text
                return SD

            elif parsealgo == "strategy20":
                page = urllib.urlopen(link)
                soup = BeautifulSoup( page,'html.parser' )
                right_table = soup.find_all( 'div' , {'id': 'fullstory-source'} )
                for i in right_table:
                    data = i.find_all( 'a' )
                    for j in data:
                        SD = SD + " " + i.text
                if (j.text == ""):
                    data = soup.find_all( 'div' , {'id': 'fullstory-source'} )
                    for d in data:
                        for img in d.find_all( "img" ):
                            data=img.get( 'alt' , '' )
                            SD = data
                return SD

            elif parsealgo == "strategy23":
                page1 = requests.get(link)
                page = page1.content
                soup = BeautifulSoup(page,'html.parser')
                right_table = soup.find_all( 'div' , {'class': 'tg-tlc-storymeta_author'} )
                for i in right_table:
                    SD = SD + " " + i.text
                return SD

            elif parsealgo == "strategy24":
                page = urllib.urlopen(link)
                soup = BeautifulSoup(page,'html.parser')
                right_table = soup.find_all( 'span' , {'itemprop': 'author'} )
                for i in right_table:
                    data = i.find_all( 'span' )
                    for j in data:
                        SD = SD + " " + j.text
                if SD=="":
                    SD = SD + " " + i.text
                return SD

            elif parsealgo == "strategy25":
                page = urllib.urlopen(link)
                soup = BeautifulSoup(page,'html.parser')
                right_table = soup.find_all( 'span' , {'class': 'provider-link'} )
                for i in right_table:
                    data = i.find_all( 'a' )
                    for j in data:
                        SD = SD + " " + j.text
                return SD

            elif parsealgo == "strategy26":
                page = urllib.urlopen(link)
                soup = BeautifulSoup(page,'html.parser')
                for s in soup("div",{"class":"article-share-block margin-bt30px inner static"}):
                    s.decompose()
                right_table = soup.find_all( 'div' , {'class': 'write-block margin-bt20px'} )
                for i in right_table:
                    SD = SD + " " + i.text
                return SD

            elif parsealgo == "BBC":
                page = urllib.urlopen( link )
                soup = BeautifulSoup(page,'html.parser')
                right_table = soup.find_all( 'span' , {'class': 'byline__name'} )
                for i in right_table:
                    SD = SD + " " + i.text
                return SD
    except:
        pass
# ------------------------------------end----------------------------------------------------------

    # Need to improve this no need to scrape if already existing
def read_rss(channel,article_type,feedtype,feedlink,link_str,title_str,published_str,summary_str,author_str,strategy_str,author_page_str,language,channel_id):
    obj = {}
    obj['status'] = False
    feedData = {}
    feedData['feed'] = {}
    count = 0
    while (count < 3 and feedData['feed'] == {}):
        print 'attempt',count+1
        # try:
        feedData = feedparser.parse(feedlink)
        # except:
        #     feedData['items']=[]
        #     print "feedparser not working"
        #     pass
        count = count + 1
    i = 0
    # try:
    #     feed = feedData['items'][0]
    # except:
    #     feed = ""
    for feed in feedData['items']:
        try:
            feedlink    = cleanhtml(feed[link_str])
            print feedlink
        except:
            feedlink = ""
        findFeed   = NewsFeedAll.objects.filter(link=feedlink)
        if len(findFeed):
            findFeed = []
            print "feed already exist"
            break
        else:
            try:
                title = cleanhtml(feed[title_str])
            except:
                title = ""
            dt=0
            try:
                time_struct = feed[published_str]
                start = datetime(*time_struct[:6])
                start = str(start)
                dt = datetime.strptime(start, "%Y-%m-%d %H:%M:%S")
                published = dt

            except:
                try:
                    now = parse(feed['published'])
                    now = str(now)
                    dt = datetime.strptime(now, "%Y-%m-%d %H:%M:%S")
                    published = dt
                except:
                    published = "1900-01-01 01:01:01"

            try:
                summary = cleanstring(cleanhtml(cleanhtml2(feed[summary_str])))
            except:
                summary = ""
            try:
                author = cleanauthor(cleanhtml(cleanhtml2(feed[author_str])))
            except:
                try:
                    author = cleanauthor(cleanhtml(parse_news_author(link=feedlink, parsealgo=author_page_str)))
                except:
                    author = ""
            try:
                content = multiplebr(cleanhtml(parse_news_content(link=feedlink, parsealgo=strategy_str)))
            except:
                content = ""
            status_dict=keyword_filter(content,summary,title)
            keyword_searched  = False
            keyword_found     = False
            if status_dict['found'] == False:
                continue
            else:
                keyword_list = status_dict['keyword_list']
                keyword_searched  = True
                keyword_found     = True
                newfeed = NewsFeedAll(channel_name = channel,article_type=article_type,feedtype=feedtype,link=feedlink, headline= title, created_at=published, summary=summary, content = content, author=author,language=language,channel_id=channel_id,keyword_list=keyword_list,keyword_searched=keyword_searched,keyword_found=keyword_found)
            try:
                newfeed.save()
                add_to_keyword(keyword_list=keyword_list,article_id = newfeed.id)
            except:
                None
            # try:
            #     if language != "English":
            #         author =  lang_translator(author)
            #
            #     if author.lower() in ["pti","press trust of india"]:
            #         author = "Press Trust of India"
            #
            #     if author.lower() in ["agency","agencies"]:
            #         author = "Agency"
            # except:
            #     pass

            # findAuthor = Authors.objects.filter(author_name=author.lower())
            # if len(findAuthor):
            #     findAuthor = findAuthor[0]
            #     author_id = findAuthor.id
            #     if channel in findAuthor.media_name:
            #         None
            #     else:
            #         (findAuthor.media_name).append(channel)
            # else:
            #     author_add = Authors(media_name=[channel],author_name=author.lower())
            #     author_id = author_add.id
            #     author_add.save()
            # newfeed.author_id = author_id
            i = i + 1

    obj['status'] = True
    obj['counter'] = i
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')
def scrape_rss(request):
    obj = {}
    obj['status'] = False
    obj['msg'] = ""
    findRss = MediaChannel.objects.filter(is_active=True)
    for rss in findRss:
        for feed in rss.rss_feed:
        # feed = rss.rss_feed[0]
            print rss.media_name + "|" + feed['feedname'] + " : "+  feed['feedlink']
            if feed['active'] == True:
                read_rss(channel        =rss.media_name,
                         article_type   =rss.article_type,
                         feedtype       =feed['feedname'],
                         feedlink       =feed['feedlink'],
                         link_str       =rss.link_str_name,
                         title_str      =rss.title_str_name,
                         published_str  =rss.pubdate_str_name,
                         summary_str    =rss.summary_str_name,
                         author_str     =rss.author_str_name,
                         strategy_str   =rss.page_content_str,
                         author_page_str = rss.author_content_str,
                         language       = rss.language,
                         channel_id     = rss.id)
    # keyword_search()
    state_search()
    obj['status'] = True
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')

# def test_scrape():
#     print "check"
#     cc = DataCheck(test = "1")
#     cc.save()

def add_to_keyword(keyword_list,article_id):
    # article= article
    article_list = []
    keyword = None
    for key in keyword_list:
        keyword = Keywords.objects.filter(id=key)[0]
        article_list = keyword.article_list
        if article_id not in article_list:
            article_list.append(article_id)
            keyword.article_list = article_list
            keyword.save()

def keyword_search(allnews_tosearch=False,keyword_to_search="all"):
    obj={}
    obj['status'] = False
    obj['result']=[]

    allkeywords = None
    allnews = None

    if keyword_to_search == "all":
        allkeywords = Keywords.objects.filter(is_active=True)
    else:
        allkeywords = Keywords.objects.filter(id=keyword_to_search)

    # keyword_id_list = map(lambda x : x.id,allkeywords)

    if allnews_tosearch:
        allnews     = NewsFeedAll.objects.all()
    else:
        allnews     = NewsFeedAll.objects.filter(keyword_searched=allnews_tosearch)

    # allnews_id_list = map(lambda x : x.id,allnews)
    # count = 0
    # for keyword in allkeywords:
    #
    #     key_synonyms      =  keyword.synonyms
    #     keyword_id        =  keyword.id
    #     synonym_list_to_check = []
    #     for key_old in key_synonyms:
    #         synonym_list_to_check.extend(
    #             [" " + key_old.lower() + " ", " " + key_old.lower() + ".", " " + key_old.lower() + ","," " + key_old.lower() + "'"])
    #     for article in allnews:
    #         # print article
    #         try:
    #             complete_article = article.headline + ' ' + article.summary + ' ' + article.content
    #             complete_article = complete_article.lower()
    #             article_id  = article.id
    #             for key in synonym_list_to_check:
    #                 # key = " " + key.lower() + " "
    #                 if key in complete_article:
    #                     article.keyword_found = True
    #                     if keyword_id not in (article.keyword_list):
    #                         (article.keyword_list).append(keyword_id)
    #                         article.keyword_found = True
    #                         # (article.keyword_synonym).append(key)
    #                     if article_id not in (keyword.article_list):
    #                         (keyword.article_list).append(article_id)
    #                     obj['result'].append({'article id': article.id,'Keyword' : keyword.keyword, 'Result':True})
    #                     keyword.save()
    #                     article.save()
    #                     break
    #                 else:
    #                     try:
    #                         (article.keyword_list).remove(keyword_id)
    #                     except:
    #                         None
    #                     try:
    #                         (keyword.article_list).remove(article_id)
    #                     except:
    #                         None
    #
    #                 if len(article.keyword_list):
    #                     article.keyword_found = True
    #                 else:
    #                     article.keyword_found = False
    #
    #                 keyword.save()
    #                 article.save()
    #         except:
                # None
    # count = 0
    if len(allkeywords):
        for keyword in allkeywords:
            key_synonyms      =  keyword.synonyms
            keyword_id        =  keyword.id
            synonym_list_to_check = []
            for key_old in key_synonyms:
                synonym_list_to_check.extend(
                    [" " + key_old.lower() + " ", " " + key_old.lower() + ".", " " + key_old.lower() + ","," " + key_old.lower() + "'"])
            for article in allnews:
                # print article
                try:
                    complete_article = article.headline + ' ' + article.summary + ' ' + article.content
                    complete_article = complete_article.lower()
                    article_id  = article.id
                    for key in synonym_list_to_check:
                        # key = " " + key.lower() + " "
                        if key in complete_article:
                            if keyword_id not in (article.keyword_list):
                                (article.keyword_list).append(keyword_id)
                                # (article.keyword_synonym).append(key)
                            if article_id not in (keyword.article_list):
                                (keyword.article_list).append(article_id)
                            obj['result'].append({'article id': article.id,'Keyword' : keyword.keyword, 'Result':True})
                            keyword.save()
                            article.save()
                            break
                        else:
                            try:
                                (article.keyword_list).remove(keyword_id)
                            except:
                                None
                            try:
                                (keyword.article_list).remove(article_id)
                            except:
                                None

                        if len(article.keyword_list):
                            article.keyword_found = True
                        else:
                            article.keyword_found = False

                        keyword.save()
                        article.save()
                except:
                    None
    else:
        # print "loop 2"
        for article in allnews:
            try:
                (article.keyword_list).remove(keyword_to_search)
            except:
                None

            if len(article.keyword_list):
                article.keyword_found = True
            else:
                article.keyword_found = False

            article.save()

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def keyword_filter(content,summary,title):
    flag = 0
    allkeywords = Keywords.objects.filter(is_active=True)
    keyword_list = []
    for keyword in allkeywords:
        key_synonyms = keyword.synonyms
        synonym_list_to_check = []
        for key_old in key_synonyms:
            synonym_list_to_check.extend([" " + key_old.lower() + " ", " " + key_old.lower() + ".", " " + key_old.lower() + ","," " + key_old.lower() + "'"])
        try:
            complete_article = title + ' ' + summary + ' ' + content
            complete_article = complete_article.lower()
            for key in synonym_list_to_check:
                if key in complete_article:
                    flag = 1
                    keyword_list.append(keyword.id)
                    print "keyword found"
                    break
        except:
            None
    if flag == 1:
        return {'found':True,'keyword_list':keyword_list}
    else:
        return {'found':False,'keyword_list':keyword_list}


def keyword_search_new(allnews_tosearch=False,keyword_to_search="all"):
    obj={}
    obj['status'] = False
    obj['result']=[]

    allkeywords = None
    allnews = None

    if keyword_to_search == "all":
        allkeywords = Keywords.objects.filter(is_active=True)
    else:
        allkeywords = Keywords.objects.filter(id=keyword_to_search)

    keyword_id_list = map(lambda x : x.id,allkeywords)

    if allnews_tosearch:
        allnews     = NewsFeedAll.objects.all()
    else:
        allnews     = NewsFeedAll.objects.filter(keyword_searched=allnews_tosearch)

    allnews_id_list = map(lambda x : x.id,allnews)

    if len(allkeywords):
        total_counter = len(allnews_id_list)
        counter = 0
        for article_id in allnews_id_list:
            counter = counter + 1
            percent_complete = (counter/total_counter) * 100
            print "Loop Completion Counter: " + str(counter) + "/" + str(total_counter) + " | " + str(percent_complete) + "%"
            article = NewsFeedAll.objects.filter(id=article_id)[0]
            for keywordid in keyword_id_list:
                keyword = Keywords.objects.filter(id=keywordid)[0]
                key_synonyms      =  keyword.synonyms
                keyword_id        =  keyword.id
                synonym_list_to_check = []
                for key_old in key_synonyms:
                    synonym_list_to_check.extend([" " + key_old.lower() + " ", " " + key_old.lower() + ".", " " + key_old.lower() + ","," " + key_old.lower() + "'"])
                # print article
                try:
                    complete_article = article.headline + ' ' + article.summary + ' ' + article.content
                    complete_article = complete_article.lower()
                    article_id  = article.id
                    for key in synonym_list_to_check:
                        # key = " " + key.lower() + " "
                        if key in complete_article:
                            article.keyword_found = True
                            if keyword_id not in (article.keyword_list):
                                (article.keyword_list).append(keyword_id)
                                article.keyword_found = True
                                # (article.keyword_synonym).append(key)
                            if article_id not in (keyword.article_list):
                                (keyword.article_list).append(article_id)
                            obj['result'].append({'article id': article.id,'Keyword' : keyword.keyword, 'Result':True})
                            keyword.save()
                            article.save()
                            break
                        else:
                            try:
                                (article.keyword_list).remove(keyword_id)
                            except:
                                None
                            try:
                                (keyword.article_list).remove(article_id)
                            except:
                                None
                        if len(article.keyword_list):
                            article.keyword_found = True
                        else:
                            article.keyword_found = False
                        keyword.save()
                        article.save()
                except:
                    None
            article.keyword_searched = True
            article.save()
    else:
        # print "loop 2"
        for article in allnews:
            try:
                (article.keyword_list).remove(keyword_to_search)
            except:
                None

            if len(article.keyword_list):
                article.keyword_found = True
            else:
                article.keyword_found = False

            article.save()

    obj['status'] = True
    obj['counter'] = len(obj['result'])
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def state_search():
    obj = {}
    obj['status'] = False
    obj['result'] = []
    seg=Segmentation.objects.filter(dashboard_type="media",segmentation_type="state")
    allnews = NewsFeedAll.objects.filter(state_searched=False)
    allnews_id_list = map(lambda x : x.id,allnews)
    for article_id in allnews_id_list:
        article = NewsFeedAll.objects.filter(id=article_id)[0]
        complete_article = article.headline + ' ' + article.summary + ' ' + article.content
        complete_article = complete_article.lower()
        for state in seg:
            statename = state.segment_name
            statename = statename.lower()
            if statename == "national":
                statelist = ['india','national']
                for ind in statelist:
                    if ind in complete_article:
                        article.state_found = True
                        list_segmentation = article.segmentation
                        if state.segmentation_id not in list_segmentation:
                            list_segmentation.append(state.segmentation_id)
                        article.segmentation = list_segmentation
                        article.save()
                        break
            else:
                if statename in complete_article:
                    article.state_found = True
                    list_segmentation = article.segmentation
                    if state.segmentation_id not in list_segmentation:
                        list_segmentation.append(state.segmentation_id)
                    article.segmentation = list_segmentation
                    article.save()


# <------------------ End ------------------------->

# <---------------- Sentiment Analysis Start ------------------->

def lang_translator(text):
    BASE_DIR = os.path.dirname( os.path.dirname( os.path.abspath( __file__ ) ) )
    google_credential_path = os.path.normpath( os.path.join( BASE_DIR , 'api/credentials' ) )
    os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = os.path.join( google_credential_path , 'sento-tech.json' )
    translate_client = translate.Client()

    if isinstance( text , six.binary_type ):
        text = text.decode( 'utf-8' )

    result = translate_client.translate( text , target_language='en' )
    # print(u'Text: {}'.format( result['input'] ))
    # print(u'Translation: {}'.format( result['translatedText'] ))
    # print(u'Detected source language: {}'.format( result['detectedSourceLanguage'] ))

    return result['translatedText']


def entity_sentiment_text(complete_article,languagecontent  = "English"):
    BASE_DIR = os.path.dirname( os.path.dirname( os.path.abspath( __file__ ) ) )
    google_credential_path = os.path.normpath( os.path.join( BASE_DIR , 'api/credentials' ) )
    dict = {}
    dict['status'] = False
    dict['result'] = []
    text = complete_article.lower()
    dict['text']= text
    if languagecontent != "English":
        text = lang_translator(text)
        dict['text'] = text

    dict_type_mapping = {1:"Person",
     2: "Location",
     3: "Organization",
     4: "Event",
     5: "Work of Art",
     }

    os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = os.path.join( google_credential_path , 'sento-tech.json' )
    client = language.LanguageServiceClient()
    try:
        if isinstance(text, six.binary_type):
            text = text.decode('utf-8')
    except:
        pass
    document = types.Document(content=text.encode('utf-8'),type=enums.Document.Type.PLAIN_TEXT)
    encoding = enums.EncodingType.UTF32
    if sys.maxunicode == 65535:
        encoding = enums.EncodingType.UTF16

    result = client.analyze_entity_sentiment(document, encoding)
    for entity in result.entities:
        name =                  ""
        type =                  ""
        salience =              0
        sentiment_magnitude =   0
        sentiment_score =       0
        # print result
        if entity.name:
            name=entity.name
        if entity.type:
            type = entity.type
            try:
                type = dict_type_mapping[type]
            except:
                type = "Other"

        if entity.salience:
            salience = entity.salience
        if entity.sentiment.magnitude:
            sentiment_magnitude = entity.sentiment.magnitude
        if entity.sentiment.score:
            sentiment_score = entity.sentiment.score
        out =  {'name': name ,
               'entity_type': type,
               'salience': salience ,
               'sentiment_mag': sentiment_magnitude,
               'sentiment': sentiment_score}
        dict['result'].append(out)

    return dict
    # return {'result':result,'dict':dict}



# <---------------- Sentiment Analysis End ------------------->




# <------------------ Instagram Code Start------------------------->

def get_ig_page(url, session=None):
    session = session or requests.Session()
    r = session.get(url)
    r_code = r.status_code
    if r_code == requests.codes.ok:
        return r
    else:
        return None


def instagram_hashtag_search(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tag = get_param(request, 'keyword', "Indian PAC")
    # print tag
    url = 'https://www.instagram.com/explore/tags/' + tag + '/?__a=1'
    # url = 'https://www.instagram.com/explore/tags/ny/?__a=1'
    dict_data_dump = get_ig_page(url)
    dict_json = dict_data_dump.json()
    feed_items_list = dict_json['graphql']['hashtag']['edge_hashtag_to_media']['edges']

    for item in feed_items_list:
        post_content = {}
        # print item['node']['edge_media_to_caption']['edges'][0]['text']
        post_text = item['node']['edge_media_to_caption']['edges'][0]['node']['text']
        post_display_url = item['node']['display_url']
        post_owner_id = item['node']['owner']['id']
        post_id = item['node']['id']
        post_likes = item['node']['edge_liked_by']['count']
        post_comments = item['node']['edge_media_to_comment']['count']
        post_content = {'post_caption':post_text,'post_display_url':post_display_url,
                        'post_owner_id':post_owner_id,'post_id':post_id,
                        'post_likes':post_likes,'post_comments':post_comments}

        obj['result'].append(post_content)
    # obj['result'] = feed_items_list
    # data_items = dict_data_dump['']
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')



import requests

influencer_floor = 5000

# 174613709

def fetch_instagram_follower(id):
    try:
        findId = InstagramUsers.objects.filter(instagram_id = id)
    except:
        findId = []

    if len(findId):
        None
    else:
        headers2 = {
            'pragma': 'no-cache',
            'cookie': 'mid=W6jwWAAEAAG4Icjh44gcWiEn_mul; mcd=3; csrftoken=8ziw2pbr2hJdjfBR1uveVFp2rAiPMrFa; shbid=563; ds_user_id=8573744326; sessionid=IGSC11868faf70f1a716baa011ff4cbf205199224394c89f166d65e12be8b7ed3744%3A6RLA5l7znmy9CD3QS3v3mvVwk1L5uj2g%3A%7B%22_auth_user_id%22%3A8573744326%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22_auth_user_hash%22%3A%22%22%2C%22_platform%22%3A4%2C%22_token_ver%22%3A2%2C%22_token%22%3A%228573744326%3AdXvnndQap2o8yLO95Q3eOOtPQA9ulHsv%3Adf09a4aca1536254f8b75478b6a175b5111604d6cf719720a6d1ad088433502f%22%2C%22last_refreshed%22%3A1537802542.9105689526%7D; rur=FRC; csrftoken=8ziw2pbr2hJdjfBR1uveVFp2rAiPMrFa; shbts=1537802555.4721053; urlgen="{\\"220.225.234.100\\": 18101}:1g4ShG:2U71OCD837TBKXitOyQKNGALWD8"',
            'accept-encoding': 'gzip, deflate, br',
            'accept-language': 'en-US,en;q=0.9',
            'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
            'accept': '*/*',
            'cache-control': 'no-cache',
            'authority': 'www.instagram.com',
            'x-requested-with': 'XMLHttpRequest',
            'x-instagram-gis': '434e36cce6d90c78d1ceba172533e1df',
            'referer': 'https://www.instagram.com/anjalinegi1238/followers/',
        }

        params2 = (
            ('query_hash', '56066f031e6239f35a904ac20c9f37d9'),
            ('variables', '{"id":"'+id+'","include_reel":true,"fetch_mutual":true,"first":24}'),
        )

        response2 = requests.get('https://www.instagram.com/graphql/query/', headers=headers2, params=params2)
        output2 = response2.json()

        try:
            num_follower = output2['data']['user']['edge_followed_by']['count']
        except:
            num_follower = 1000

        if int(num_follower) >= influencer_floor:
            headers = {
                'pragma': 'no-cache',
                'cookie': 'mid=W6jwWAAEAAG4Icjh44gcWiEn_mul; mcd=3; csrftoken=8ziw2pbr2hJdjfBR1uveVFp2rAiPMrFa; shbid=563; ds_user_id=8573744326; sessionid=IGSC11868faf70f1a716baa011ff4cbf205199224394c89f166d65e12be8b7ed3744%3A6RLA5l7znmy9CD3QS3v3mvVwk1L5uj2g%3A%7B%22_auth_user_id%22%3A8573744326%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22_auth_user_hash%22%3A%22%22%2C%22_platform%22%3A4%2C%22_token_ver%22%3A2%2C%22_token%22%3A%228573744326%3AdXvnndQap2o8yLO95Q3eOOtPQA9ulHsv%3Adf09a4aca1536254f8b75478b6a175b5111604d6cf719720a6d1ad088433502f%22%2C%22last_refreshed%22%3A1537802542.9105689526%7D; rur=FRC; csrftoken=8ziw2pbr2hJdjfBR1uveVFp2rAiPMrFa; shbts=1537802555.4721053; urlgen="{\\"220.225.234.100\\": 18101}:1g4Sh1:btnezJZwU0Jf1YtUJFqdzl6_15c"',
                'accept-encoding': 'gzip, deflate, br',
                'accept-language': 'en-US,en;q=0.9',
                'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
                'accept': '*/*',
                'cache-control': 'no-cache',
                'authority': 'www.instagram.com',
                'x-requested-with': 'XMLHttpRequest',
                'x-instagram-gis': '64244970d7494b2d690c4a1464fdcefe',
                'referer': 'https://www.instagram.com/anjalinegi1238/',
            }

            params = (
                ('query_hash', '7c16654f22c819fb63d1183034a5162f'),
                ('variables', '{"user_id":"'+ id +'","include_chaining":true,"include_reel":true,"include_suggested_users":true,"include_logged_out_extras":false,"include_highlight_reels":false}'),
            )
    # params = (
    #     ('query_hash', '7c16654f22c819fb63d1183034a5162f'),
    #     ('variables', '{"user_id":"8573744326","include_chaining":true,"include_reel":true,"include_suggested_users":true,"include_logged_out_extras":false,"include_highlight_reels":false}'),
    # )
            response = requests.get('https://www.instagram.com/graphql/query/', headers=headers, params=params)
            output = response.json()
            try:
                username = output['data']['user']['reel']['owner']['username']
                # num_following = len(output['data']['user']['edge_chaining']['edges'])
                list_following = output['data']['user']['edge_chaining']['edges']
                final_list_following = []
                for follow in list_following:
                    following_dict = follow['node']
                    final_list_following.append(following_dict)

                instagram = InstagramUsers(instagram_handle = username,
                                            instagram_id = id,
                                            instagram_followers = num_follower,
                                            # instagram_following = num_following,
                                            instagram_following_list = final_list_following
                                            )
                instagram.save()
            except:
                None

def fetch_all_following():
    allusers = InstagramUsers.objects.filter(followers_scraped=False)
    for user in allusers:
        for follow in user.instagram_following_list:
            fetch_instagram_follower(follow['id'])
        user.followers_scraped = True
        user.save()

def fetch_all_instagram(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    tranObjs = InstagramUsers.objects.all()
    for trans in tranObjs:
        # i = i + 1
        obj['result'].append({
            'instagram_handle': trans.instagram_handle,
            'instagram_id': trans.instagram_id,
            'instagram_followers': trans.instagram_followers,
            # 'instagram_following': trans.instagram_following,
            # 'instagram_following_list': trans.instagram_following_list,
            'followers_scraped': trans.followers_scraped
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')

def call_fetch_more_instagram_influencer(request):
    i = 0
    while i <50:
        fetch_all_following()
        i = i + 1


# <------------------ Instagram Code End ------------------------->

# <------------------ Twitter Code Start ------------------------->



def fetch_twitter_followers(profile):
    total_list_follower = []
    headers1 = {
    'accept-encoding': 'gzip, deflate, br',
    'accept-language': 'en-US,en;q=0.9',
    'x-requested-with': 'XMLHttpRequest',
    'cookie': 'ct0=0507725871c128f5ca55cf58e14a3620; _ga=GA1.2.441802152.1538373860; _gid=GA1.2.1416575602.1538373860; dnt=1; kdt=kokSbUa5JKGQDLIa0EMsgInRVcdAua66ipAIWNVA; remember_checked_on=0; csrf_same_site_set=1; lang=en; csrf_same_site=1; personalization_id="v1_5SBqABLK7W6lZSe+ITAhcA=="; guest_id=v1%3A153837690250666575; ads_prefs="HBESAAA="; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCGg2Oi5mAToMY3NyZl9p%250AZCIlOTM5ZTc1ZTk2MzJhNDE0OTBkYWMxNjAwODE4NDAzM2I6B2lkIiU3YzE2%250ANGU0YjE4NjVkYWM4MWI1OWMzM2ZjOTc5NTkyNToJdXNlcmwrCQDAlOp9cRoO--8d697ae01e9000ba2eb01ccc739132d6469d1e82; twid="u=1016249451545935872"; auth_token=1a336c130c832bbda3fe8433f314ddeb413ae2f5',
    'pragma': 'no-cache',
    'x-push-state-request': 'true',
    'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    'accept': 'application/json, text/javascript, */*; q=0.01',
    'cache-control': 'no-cache',
    'authority': 'twitter.com',
    'referer': 'https://twitter.com/',
    'x-twitter-active-user': 'yes',
    'x-asset-version': '02a322',
    }


    response1 = requests.get('https://twitter.com/'+profile+'/followers', headers=headers1)
    output1 = response1.json()
    doc1 = document_fromstring(output1['page'])
    max_pos =  (doc1.xpath("//div/@data-min-position"))[0]
    total_list_follower = (doc1.xpath("//div[contains(@class, 'ProfileCard')]/@data-screen-name"))
    headers = {
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'x-requested-with': 'XMLHttpRequest',
        'cookie': 'ct0=0507725871c128f5ca55cf58e14a3620; _ga=GA1.2.441802152.1538373860; _gid=GA1.2.1416575602.1538373860; dnt=1; kdt=kokSbUa5JKGQDLIa0EMsgInRVcdAua66ipAIWNVA; remember_checked_on=0; csrf_same_site_set=1; lang=en; csrf_same_site=1; personalization_id="v1_5SBqABLK7W6lZSe+ITAhcA=="; guest_id=v1%3A153837690250666575; ads_prefs="HBESAAA="; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCGg2Oi5mAToMY3NyZl9p%250AZCIlOTM5ZTc1ZTk2MzJhNDE0OTBkYWMxNjAwODE4NDAzM2I6B2lkIiU3YzE2%250ANGU0YjE4NjVkYWM4MWI1OWMzM2ZjOTc5NTkyNToJdXNlcmwrCQDAlOp9cRoO--8d697ae01e9000ba2eb01ccc739132d6469d1e82; twid="u=1016249451545935872"; auth_token=1a336c130c832bbda3fe8433f314ddeb413ae2f5',
        'pragma': 'no-cache',
        'x-push-state-request': 'true',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'referer': 'https://twitter.com/',
        'x-twitter-active-user': 'yes',
        'x-asset-version': '02a322',
    }


    count = len(total_list_follower)
    i = 0
    # print total_list_follower
    # print count
    while i < 1:
        params = (
            ('include_available_features', '1'),
            ('include_entities', '1'),
            ('max_position', str(max_pos)),
            ('reset_error_state', 'false'),
        )

        response = requests.get('https://twitter.com/'+profile+'/followers/users', headers=headers, params=params)
        output = response.json()
        max_pos = output['min_position']
        has_more_item = output['has_more_items']
        try:
            doc = document_fromstring(output['items_html'])
            list_followers = (doc.xpath("//div[contains(@class, 'ProfileCard')]/@data-screen-name"))
        # for follower in list_followers:
        # total_list_follower_pre = total_list_follower
        # if follower not in total_list_follower:
            total_list_follower.extend(list_followers)
            count = len(total_list_follower)
            # print count
        except:
            None
        # print list_followers
        # time.sleep(1)
        if not has_more_item:
            i = 1
    return {"num_followers":len(total_list_follower),"followers":total_list_follower}

def check_like(profile,postid):
    total_list_likes = []
    headers1 = {
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'x-requested-with': 'XMLHttpRequest',
        'cookie': 'personalization_id="v1_6oeebYoixN4zaGryJd2dpg=="; guest_id=v1%3A153358315639952327; __utma=43838368.1908293028.1533893229.1533893229.1533893229.1; __utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; tfw_exp=1; dnt=1; ads_prefs="HBISAAA="; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; remember_checked_on=1; twid="u=141564323"; auth_token=5d312aeedd80e1b38483f41fb65fcc944bebc160; csrf_same_site_set=1; csrf_same_site=1; lang=en; _twitter_sess=BAh7CSIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCOksTgVmAToHaWQiJWFm%250ANTk1ZWQ1YTYxZTlkMDVmMWEwOTRhZmRmMGQ4MDZkOgxjc3JmX2lkIiU1OTI1%250AYzlhZGZiOGM0N2U5ODVhYzZiZGUzMDU3OGUxMg%253D%253D--f0358cc72c485624a663b38742226c4c12ed994e; _gid=GA1.2.578831464.1537687327; gsScrollPos-285783303=0; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D; ct0=d302a3eada1ae8201657b92e68ccfe59; _gat=1',
        'pragma': 'no-cache',
        'x-push-state-request': 'true',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'referer': 'https://twitter.com/prasadreddy_m/following',
        'x-twitter-active-user': 'yes',
        'x-asset-version': 'fb2681',
    }

    response1 = requests.get('https://twitter.com/'+profile+'/likes', headers=headers1)
    # response1 = requests.get('https://twitter.com/shashwatyadav/likes', headers=headers1)

    output1 = response1.json()
    doc1 = document_fromstring(output1['page'])
    max_pos =  (doc1.xpath("//div/@data-min-position"))[0]
    total_list_likes = (doc1.xpath("//li/@data-item-id"))
    if postid in total_list_likes:
        return True
    else:
        i = 0
        headers = {
            'pragma': 'no-cache',
            'cookie': 'personalization_id="v1_6oeebYoixN4zaGryJd2dpg=="; guest_id=v1%3A153358315639952327; __utma=43838368.1908293028.1533893229.1533893229.1533893229.1; __utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; tfw_exp=1; dnt=1; ads_prefs="HBISAAA="; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; remember_checked_on=1; twid="u=141564323"; auth_token=5d312aeedd80e1b38483f41fb65fcc944bebc160; csrf_same_site_set=1; csrf_same_site=1; lang=en; _twitter_sess=BAh7CSIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCOksTgVmAToHaWQiJWFm%250ANTk1ZWQ1YTYxZTlkMDVmMWEwOTRhZmRmMGQ4MDZkOgxjc3JmX2lkIiU1OTI1%250AYzlhZGZiOGM0N2U5ODVhYzZiZGUzMDU3OGUxMg%253D%253D--f0358cc72c485624a663b38742226c4c12ed994e; _gid=GA1.2.578831464.1537687327; gsScrollPos-285783303=0; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D; ct0=d302a3eada1ae8201657b92e68ccfe59',
            'accept-encoding': 'gzip, deflate, br',
            'accept-language': 'en-US,en;q=0.9',
            'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
            'accept': 'application/json, text/javascript, */*; q=0.01',
            'cache-control': 'no-cache',
            'authority': 'twitter.com',
            'x-requested-with': 'XMLHttpRequest',
            'x-twitter-active-user': 'yes',
            'referer': 'https://twitter.com/prasadreddy_m/likes',
        }

        while i < 1:

            params = (
                ('include_available_features', '1'),
                ('include_entities', '1'),
                ('max_position', str(max_pos)),
                ('reset_error_state', 'false'),
            )
            response = requests.get('https://twitter.com/'+profile+'/likes/timeline', headers=headers, params=params)
            output = response.json()
            max_pos = output['min_position']
            has_more_item = output['has_more_items']
            try:
                doc = document_fromstring(output['items_html'])
                list_likes = (doc.xpath("//li/@data-item-id"))
                total_list_likes.extend(list_likes)
                if postid in list_likes:
                    return True
            except:
                None
            if not has_more_item:
                i = 1
        # return {"num_likes":len(total_list_likes),"like_ids":total_list_likes}
        return False

def fetch_twitter_following(profile):
    total_list_following = []
    headers1 = {
    'accept-encoding': 'gzip, deflate, br',
    'accept-language': 'en-US,en;q=0.9',
    'x-requested-with': 'XMLHttpRequest',
    'cookie': 'ct0=0507725871c128f5ca55cf58e14a3620; _ga=GA1.2.441802152.1538373860; _gid=GA1.2.1416575602.1538373860; dnt=1; kdt=kokSbUa5JKGQDLIa0EMsgInRVcdAua66ipAIWNVA; remember_checked_on=0; csrf_same_site_set=1; lang=en; csrf_same_site=1; personalization_id="v1_5SBqABLK7W6lZSe+ITAhcA=="; guest_id=v1%3A153837690250666575; ads_prefs="HBESAAA="; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCGg2Oi5mAToMY3NyZl9p%250AZCIlOTM5ZTc1ZTk2MzJhNDE0OTBkYWMxNjAwODE4NDAzM2I6B2lkIiU3YzE2%250ANGU0YjE4NjVkYWM4MWI1OWMzM2ZjOTc5NTkyNToJdXNlcmwrCQDAlOp9cRoO--8d697ae01e9000ba2eb01ccc739132d6469d1e82; twid="u=1016249451545935872"; auth_token=1a336c130c832bbda3fe8433f314ddeb413ae2f5',
    'pragma': 'no-cache',
    'x-push-state-request': 'true',
    'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    'accept': 'application/json, text/javascript, */*; q=0.01',
    'cache-control': 'no-cache',
    'authority': 'twitter.com',
    'referer': 'https://twitter.com/',
    'x-twitter-active-user': 'yes',
    'x-asset-version': '02a322',
}


    response1 = requests.get('https://twitter.com/'+profile+'/following', headers=headers1)
    output1 = response1.json()
    doc1 = document_fromstring(output1['page'])
    max_pos =  (doc1.xpath("//div/@data-min-position"))[0]
    total_list_following = (doc1.xpath("//div[contains(@class, 'ProfileCard')]/@data-screen-name"))


    headers = {
    'accept-encoding': 'gzip, deflate, br',
    'accept-language': 'en-US,en;q=0.9',
    'x-requested-with': 'XMLHttpRequest',
    'cookie': 'ct0=0507725871c128f5ca55cf58e14a3620; _ga=GA1.2.441802152.1538373860; _gid=GA1.2.1416575602.1538373860; dnt=1; kdt=kokSbUa5JKGQDLIa0EMsgInRVcdAua66ipAIWNVA; remember_checked_on=0; csrf_same_site_set=1; lang=en; csrf_same_site=1; personalization_id="v1_5SBqABLK7W6lZSe+ITAhcA=="; guest_id=v1%3A153837690250666575; ads_prefs="HBESAAA="; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCGg2Oi5mAToMY3NyZl9p%250AZCIlOTM5ZTc1ZTk2MzJhNDE0OTBkYWMxNjAwODE4NDAzM2I6B2lkIiU3YzE2%250ANGU0YjE4NjVkYWM4MWI1OWMzM2ZjOTc5NTkyNToJdXNlcmwrCQDAlOp9cRoO--8d697ae01e9000ba2eb01ccc739132d6469d1e82; twid="u=1016249451545935872"; auth_token=1a336c130c832bbda3fe8433f314ddeb413ae2f5',
    'pragma': 'no-cache',
    'x-push-state-request': 'true',
    'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    'accept': 'application/json, text/javascript, */*; q=0.01',
    'cache-control': 'no-cache',
    'authority': 'twitter.com',
    'referer': 'https://twitter.com/',
    'x-twitter-active-user': 'yes',
    'x-asset-version': '02a322',
}
    i = 0
    while i < 1:
        params = (
            ('include_available_features', '1'),
            ('include_entities', '1'),
            ('max_position', str(max_pos)),
            ('reset_error_state', 'false'),
        )

        response = requests.get('https://twitter.com/'+profile+'/following/users', headers=headers, params=params)
        output = response.json()
        max_pos = output['min_position']
        has_more_item = output['has_more_items']
        try:
            doc = document_fromstring(output['items_html'])
            list_following = (doc.xpath("//div[contains(@class, 'ProfileCard')]/@data-screen-name"))
        # for follower in list_followers:
        # total_list_follower_pre = total_list_follower
        # if follower not in total_list_follower:
            total_list_following.extend(list_following)
        except:
            None

        if not has_more_item:
            i = 1
    return {"num_following":len(total_list_following),"followers":total_list_following}

def check_following(profile,tocheck_profile):
    total_list_following = []
    headers1 = {
    'accept-encoding': 'gzip, deflate, br',
    'accept-language': 'en-US,en;q=0.9',
    'x-requested-with': 'XMLHttpRequest',
    'cookie': 'ct0=0507725871c128f5ca55cf58e14a3620; _ga=GA1.2.441802152.1538373860; _gid=GA1.2.1416575602.1538373860; dnt=1; kdt=kokSbUa5JKGQDLIa0EMsgInRVcdAua66ipAIWNVA; remember_checked_on=0; csrf_same_site_set=1; lang=en; csrf_same_site=1; personalization_id="v1_5SBqABLK7W6lZSe+ITAhcA=="; guest_id=v1%3A153837690250666575; ads_prefs="HBESAAA="; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCGg2Oi5mAToMY3NyZl9p%250AZCIlOTM5ZTc1ZTk2MzJhNDE0OTBkYWMxNjAwODE4NDAzM2I6B2lkIiU3YzE2%250ANGU0YjE4NjVkYWM4MWI1OWMzM2ZjOTc5NTkyNToJdXNlcmwrCQDAlOp9cRoO--8d697ae01e9000ba2eb01ccc739132d6469d1e82; twid="u=1016249451545935872"; auth_token=1a336c130c832bbda3fe8433f314ddeb413ae2f5',
    'pragma': 'no-cache',
    'x-push-state-request': 'true',
    'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    'accept': 'application/json, text/javascript, */*; q=0.01',
    'cache-control': 'no-cache',
    'authority': 'twitter.com',
    'referer': 'https://twitter.com/',
    'x-twitter-active-user': 'yes',
    'x-asset-version': '02a322',
}


    response1 = requests.get('https://twitter.com/'+profile+'/following', headers=headers1)
    output1 = response1.json()
    doc1 = document_fromstring(output1['page'])
    max_pos =  (doc1.xpath("//div/@data-min-position"))[0]
    total_list_following = (doc1.xpath("//div[contains(@class, 'ProfileCard')]/@data-screen-name"))

    if tocheck_profile in total_list_following:
        return True
    headers = {
    'accept-encoding': 'gzip, deflate, br',
    'accept-language': 'en-US,en;q=0.9',
    'x-requested-with': 'XMLHttpRequest',
    'cookie': 'ct0=0507725871c128f5ca55cf58e14a3620; _ga=GA1.2.441802152.1538373860; _gid=GA1.2.1416575602.1538373860; dnt=1; kdt=kokSbUa5JKGQDLIa0EMsgInRVcdAua66ipAIWNVA; remember_checked_on=0; csrf_same_site_set=1; lang=en; csrf_same_site=1; personalization_id="v1_5SBqABLK7W6lZSe+ITAhcA=="; guest_id=v1%3A153837690250666575; ads_prefs="HBESAAA="; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCGg2Oi5mAToMY3NyZl9p%250AZCIlOTM5ZTc1ZTk2MzJhNDE0OTBkYWMxNjAwODE4NDAzM2I6B2lkIiU3YzE2%250ANGU0YjE4NjVkYWM4MWI1OWMzM2ZjOTc5NTkyNToJdXNlcmwrCQDAlOp9cRoO--8d697ae01e9000ba2eb01ccc739132d6469d1e82; twid="u=1016249451545935872"; auth_token=1a336c130c832bbda3fe8433f314ddeb413ae2f5',
    'pragma': 'no-cache',
    'x-push-state-request': 'true',
    'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    'accept': 'application/json, text/javascript, */*; q=0.01',
    'cache-control': 'no-cache',
    'authority': 'twitter.com',
    'referer': 'https://twitter.com/',
    'x-twitter-active-user': 'yes',
    'x-asset-version': '02a322',
}
    i = 0
    while i < 1:
        params = (
            ('include_available_features', '1'),
            ('include_entities', '1'),
            ('max_position', str(max_pos)),
            ('reset_error_state', 'false'),
        )

        response = requests.get('https://twitter.com/'+profile+'/following/users', headers=headers, params=params)
        output = response.json()
        max_pos = output['min_position']
        has_more_item = output['has_more_items']
        try:
            doc = document_fromstring(output['items_html'])
            list_following = (doc.xpath("//div[contains(@class, 'ProfileCard')]/@data-screen-name"))
        # for follower in list_followers:
        # total_list_follower_pre = total_list_follower
        # if follower not in total_list_follower:
            total_list_following.extend(list_following)
            if tocheck_profile in list_following:
                return True
        except:
            None

        if not has_more_item:
            i = 1
    return False







# Some error in this code
def fetch_tweets(profile,number):
    headers1 = {
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'x-requested-with': 'XMLHttpRequest',
        'cookie': 'personalization_id="v1_6oeebYoixN4zaGryJd2dpg=="; guest_id=v1%3A153358315639952327; __utma=43838368.1908293028.1533893229.1533893229.1533893229.1; __utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; tfw_exp=1; dnt=1; ads_prefs="HBISAAA="; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; remember_checked_on=1; twid="u=141564323"; auth_token=5d312aeedd80e1b38483f41fb65fcc944bebc160; csrf_same_site_set=1; csrf_same_site=1; lang=en; _twitter_sess=BAh7CSIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCOksTgVmAToHaWQiJWFm%250ANTk1ZWQ1YTYxZTlkMDVmMWEwOTRhZmRmMGQ4MDZkOgxjc3JmX2lkIiU1OTI1%250AYzlhZGZiOGM0N2U5ODVhYzZiZGUzMDU3OGUxMg%253D%253D--f0358cc72c485624a663b38742226c4c12ed994e; _gid=GA1.2.578831464.1537687327; gsScrollPos-285783303=0; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D; ct0=d302a3eada1ae8201657b92e68ccfe59; _gat=1',
        'pragma': 'no-cache',
        'x-push-state-request': 'true',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'referer': 'https://twitter.com/prasadreddy_m/following',
        'x-twitter-active-user': 'yes',
        'x-asset-version': 'fb2681',
    }

    response1 = requests.get('https://twitter.com/'+profile, headers=headers1)
    output1 = response1.json()
    doc1 = document_fromstring(output1['page'])
    max_pos =  (doc1.xpath("//div/@data-min-position"))[0]
    tweet_id_list = (doc1.xpath("//li/@data-item-id"))
    tweet_content_list = (doc1.xpath("//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]//p"))
    tweet_reply_list = (doc1.xpath("//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]/div[contains(@class, 'stream-item-footer')]/div[contains(@class, 'ProfileTweet-actionList')]/div[contains(@class, 'ProfileTweet-action--reply')]//span[contains(@class, 'ProfileTweet-actionCountForPresentation')]"))
    tweet_retweet_list = (doc1.xpath("//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]/div[contains(@class, 'stream-item-footer')]/div[contains(@class, 'ProfileTweet-actionList')]/div[contains(@class, 'ProfileTweet-action--retweet')]//span[contains(@class, 'ProfileTweet-actionCountForPresentation')]"))
    tweet_like_list = (doc1.xpath("//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]/div[contains(@class, 'stream-item-footer')]/div[contains(@class, 'ProfileTweet-actionList')]/div[contains(@class, 'ProfileTweet-action--favorite')]//span[contains(@class, 'ProfileTweet-actionCountForPresentation')]"))
    headers = {
        'pragma': 'no-cache',
        'cookie': 'personalization_id="v1_6oeebYoixN4zaGryJd2dpg=="; guest_id=v1%3A153358315639952327; __utma=43838368.1908293028.1533893229.1533893229.1533893229.1; __utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; tfw_exp=1; dnt=1; ads_prefs="HBISAAA="; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; remember_checked_on=1; twid="u=141564323"; auth_token=5d312aeedd80e1b38483f41fb65fcc944bebc160; csrf_same_site_set=1; csrf_same_site=1; lang=en; _twitter_sess=BAh7CSIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCOksTgVmAToHaWQiJWFm%250ANTk1ZWQ1YTYxZTlkMDVmMWEwOTRhZmRmMGQ4MDZkOgxjc3JmX2lkIiU1OTI1%250AYzlhZGZiOGM0N2U5ODVhYzZiZGUzMDU3OGUxMg%253D%253D--f0358cc72c485624a663b38742226c4c12ed994e; _gid=GA1.2.578831464.1537687327; gsScrollPos-285783303=0; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D; ct0=d302a3eada1ae8201657b92e68ccfe59',
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'x-requested-with': 'XMLHttpRequest',
        'x-twitter-active-user': 'yes',
        'referer': 'https://twitter.com/arunjaitley',
    }

    i = 0
    while i < 1:

        params = (
            ('include_available_features', '1'),
            ('include_entities', '1'),
            ('max_position', str(max_pos)),
            ('reset_error_state', 'false'),
        )
        response = requests.get('https://twitter.com/i/profiles/show/'+profile+'/timeline/tweets', headers=headers,params=params)
        output = response.json()
        max_pos = output['inner']['min_position']
        has_more_item = output['inner']['has_more_items']
        try:
            doc = document_fromstring(output['inner']['items_html'])
            list_tweet_ids_new = (doc.xpath("//li/@data-item-id"))
            list_tweets_content_new = (doc.xpath("//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]//p"))
            tweet_reply_list_new = (doc.xpath(
                "//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]/div[contains(@class, 'stream-item-footer')]/div[contains(@class, 'ProfileTweet-actionList')]/div[contains(@class, 'ProfileTweet-action--reply')]//span[contains(@class, 'ProfileTweet-actionCountForPresentation')]"))
            tweet_retweet_list_new = (doc.xpath(
                "//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]/div[contains(@class, 'stream-item-footer')]/div[contains(@class, 'ProfileTweet-actionList')]/div[contains(@class, 'ProfileTweet-action--retweet')]//span[contains(@class, 'ProfileTweet-actionCountForPresentation')]"))
            tweet_like_list_new = (doc.xpath(
                "//div[contains(@class, 'tweet')]/div[contains(@class, 'content')]/div[contains(@class, 'stream-item-footer')]/div[contains(@class, 'ProfileTweet-actionList')]/div[contains(@class, 'ProfileTweet-action--favorite')]//span[contains(@class, 'ProfileTweet-actionCountForPresentation')]"))

            tweet_content_list.extend(list_tweets_content_new)
            tweet_id_list.extend(list_tweet_ids_new)
            tweet_reply_list.extend(tweet_reply_list_new)
            tweet_retweet_list.extend(tweet_retweet_list_new)
            tweet_like_list.extend(tweet_like_list_new)
        except:
            None
        if len(tweet_id_list)>=number:
            i = 1
        if not has_more_item:
            i = 1

    final_tweet_list = []
    j = 0
    for tweet in tweet_id_list:
        dict = {}

        tweet_reply = "0"
        tweet_retweet = "0"
        tweet_like = "0"

        if tweet_reply_list[j].text_content() != "":
            tweet_reply = tweet_reply_list[j].text_content()

        if tweet_retweet_list[j].text_content() != "":
            tweet_retweet = tweet_retweet_list[j].text_content()

        if tweet_like_list[j].text_content() != "":
            tweet_like = tweet_like_list[j].text_content()

        dict = {'tweet_id':tweet,'tweet_content':tweet_content_list[j].text_content(),'tweet_comment':tweet_reply,'tweet_retweet':tweet_retweet,'tweet_like':tweet_like}
        final_tweet_list.append(dict)
        j = j + 1
    return final_tweet_list

def download_tweet_data(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    profile = get_param(request, 'profile_id', None)
    tweet_id = get_param(request, 'tweet_id', None)
    auth_token = get_param(request, 'auth_token', None)

    data = fetch_tweet_replies(profile_id=profile,tweet_id=tweet_id,auth_token=auth_token)
    response = HttpResponse(content_type='application/ms-excel')
    response['Content-Disposition'] = 'attachment; filename="reply_list_'+tweet_id+'.xls"'
    wb = xlwt.Workbook(encoding='utf-8')
    ws = wb.add_sheet('Replies')
    row = 0
    ws.write(row, 0, "Twitter Handle")
    ws.write(row, 1, "Tweet_id")
    ws.write(row, 2, "Reply")
    ws.write(row, 3, "Reply - Retweet Count")
    ws.write(row, 4, "Reply - Like Count")
    for datum in data:
        row = row + 1
        ws.write(row, 0, datum['tweet_user'])
        ws.write(row, 1, datum['tweet_id'])
        ws.write(row, 2, datum['tweet'])
        ws.write(row, 3, datum['retweet_count'])
        ws.write(row, 4, datum['like_count'])
    wb.save(response)
    return response

def fetch_tweet_replies(profile_id = "PrashantKishor",tweet_id="1052117355646672896",auth_token = 'a462954203d8c6a4911c5d7529278f0dd419cc6b'):
    # profile_id = "PrashantKishor"
    # tweet_id = "1052117355646672896"
    # auth_token = 'a462954203d8c6a4911c5d7529278f0dd419cc6b'
    headers = {
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'x-requested-with': 'XMLHttpRequest',
        'cookie': '__utma=43838368.1908293028.1533893229.1533893229.1533893229.1; __utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; dnt=1; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; csrf_same_site_set=1; csrf_same_site=1; tfw_exp=0; lang=en; ct0=69880596b54dfd1846219730f1182e31; _gid=GA1.2.956778234.1540542441; personalization_id="v1_5ehZCcb1qkOGng18Q71Zhw=="; guest_id=v1%3A154054244619318842; ads_prefs="HBESAAA="; remember_checked_on=0; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCAXf0XNmAToHaWQiJTcz%250ANzZiNzg5YzRkODg3Zjg5YjRlMjIyMjFhYmM2ZGUzOgxjc3JmX2lkIiU0ODZk%250ANzY1NTEzOTRiNTExYjVlZDU2NzJjMzFkODk3OToJdXNlcmwrCQDQlCje0wAO--19e2f0d02ec8c8ba6e118b9498d3bb00162f56b5; twid="u=1009039267648032768"; auth_token='+auth_token+'; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D',
        'pragma': 'no-cache',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'x-overlay-request': 'true',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'referer': 'https://twitter.com/prashantkishor/status/1052117355646672896',
        'x-previous-page-name': 'permalink',
        'x-twitter-active-user': 'yes',
    }
    response1 = requests.get('https://twitter.com/'+profile_id +'/status/'+ tweet_id, headers=headers)
    tweet_replies = []
    output1 = response1.json()
    doc1 = document_fromstring(output1['page'])
    max_pos =  (doc1.xpath("//div/@data-min-position"))[0]
    tweet_id_list = (doc1.xpath("//li/@data-item-id"))
    tweet_content_list = (doc1.xpath("//div[contains(@class, 'js-tweet-text-container')]//p"))
    tweet_user_list = (doc1.xpath("//div[contains(@class, 'js-stream-tweet')]/@data-screen-name"))
    tweet_content_retweet_list = (doc1.xpath("//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--retweet')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))
    tweet_content_like_list = (doc1.xpath("//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--favorite')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))
    for q in range(len(tweet_id_list)):
        obj = {}
        obj['tweet_id'] = tweet_id_list[q]
        obj['tweet_user'] = tweet_user_list[q]
        obj['tweet'] = (tweet_content_list[(q + 1)].text_content())
        obj['retweet_count'] = tweet_content_retweet_list[(q + 1)]
        obj['like_count'] = tweet_content_like_list[(q + 1)]
        tweet_replies.append(obj)
    i = 0
    while i < 1:
        params = {
            'include_available_features': '1',
            'include_entities': '1',
            'max_position':max_pos,
            'reset_error_state': 'false'
        }

        response = requests.get('https://twitter.com/i/'+profile_id+'/conversation/'+tweet_id,
                                headers=headers, params=params)

        output = response.json()
        max_pos = output['descendants']['min_position']
        has_more_item = output['descendants']['has_more_items']
        try:
            doc = document_fromstring(output['descendants']['items_html'])
            list_tweet_ids_new = (doc.xpath("//li/@data-item-id"))
            tweet_user_list = (doc.xpath("//div[contains(@class, 'js-stream-tweet')]/@data-screen-name"))
            list_tweets_content_new = (doc.xpath("//div[contains(@class, 'js-tweet-text-container')]//p"))
            tweet_retweet_list_new = (doc.xpath("//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--retweet')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))
            tweet_like_list_new = (doc.xpath("//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--favorite')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))

            for q in range(len(list_tweet_ids_new)):
                obj = {}
                obj['tweet_id']     = list_tweet_ids_new[q]
                obj['tweet_user']   = tweet_user_list[q]
                obj['tweet'] = (list_tweets_content_new[q].text_content())
                obj['retweet_count'] = tweet_retweet_list_new[q]
                obj['like_count'] = tweet_like_list_new[q]
                tweet_replies.append(obj)
        except:
            None

        if not has_more_item:
            i = 1

    return tweet_replies

def download_tweetrefrence_data(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    keyword = get_param(request, 'keyword', None)
    auth_token = get_param(request, 'auth_token', None)
    days = get_param(request, 'days', None)
    days = int(days)
    data = tweet_references(keyword=keyword,auth_token=auth_token,days=days)
    response = HttpResponse(content_type='application/ms-excel')
    response['Content-Disposition'] = 'attachment; filename="tweet_list.xls"'
    wb = xlwt.Workbook(encoding='utf-8')
    ws = wb.add_sheet('Tweets')
    row = 0
    ws.write(row, 0, "Twitter Handle")
    ws.write(row, 1, "Tweet_id")
    ws.write(row, 2, "Tweet")
    ws.write(row, 3, "Retweet")
    ws.write(row, 4, "Likes")
    ws.write(row, 5, "Timestamps")
    ws.write(row, 6, "Accounts Mentioned")
    ws.write(row, 7, "Hashtag Mentioned")
    for datum in data:
        row = row + 1
        ws.write(row, 0, datum['tweet_user'])
        ws.write(row, 1, datum['tweet_id'])
        ws.write(row, 2, datum['tweet'])
        ws.write(row, 3, datum['retweet_count'])
        ws.write(row, 4, datum['like_count'])
        ws.write(row, 5, datetime.fromtimestamp(int(datum['time_stamp'])).strftime('%Y-%m-%d %H:%M:%S'))
        ws.write(row, 6, datum['tweet_account_tags'])
        ws.write(row, 7, datum['tweet_account_hashtags'])
    wb.save(response)
    return response

def tweet_references(keyword="Prashant Kishor",auth_token="a462954203d8c6a4911c5d7529278f0dd419cc6b",days=1):
    # keyword = "Prashant Kishor"
    # auth_token = "a462954203d8c6a4911c5d7529278f0dd419cc6b"
    # url = "https://twitter.com/search?f=tweets&vertical=default&q="+keyword+"&src=typd"

    headers = {
        'pragma': 'no-cache',
        'cookie': '__utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; dnt=1; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; csrf_same_site_set=1; csrf_same_site=1; lang=en; _gid=GA1.2.956778234.1540542441; personalization_id="v1_5ehZCcb1qkOGng18Q71Zhw=="; guest_id=v1%3A154054244619318842; ads_prefs="HBESAAA="; remember_checked_on=0; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCAXf0XNmAToHaWQiJTcz%250ANzZiNzg5YzRkODg3Zjg5YjRlMjIyMjFhYmM2ZGUzOgxjc3JmX2lkIiU0ODZk%250ANzY1NTEzOTRiNTExYjVlZDU2NzJjMzFkODk3OToJdXNlcmwrCQDQlCje0wAO--19e2f0d02ec8c8ba6e118b9498d3bb00162f56b5; twid="u=1009039267648032768"; auth_token='+auth_token+'; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D; tfw_exp=1; __utma=43838368.1908293028.1533893229.1533893229.1540563423.2; __utmc=43838368; ct0=85af559327b825c3fad5720bf55fe69f; _gat=1',
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'x-requested-with': 'XMLHttpRequest',
        'x-twitter-active-user': 'yes',
        'referer': 'https://twitter.com/search?f=tweets&vertical=default&q=prashant%20kishor&src=typd',
    }

    params = {
        'f': 'tweets',
        'q': keyword.lower(),
        'src': 'typd',
    }

    response1 = requests.get('https://twitter.com/search', headers=headers, params=params)
    output1 = response1.content
    doc1 = document_fromstring(output1)
    max_pos = (doc1.xpath("//div/@data-min-position"))[0]
    tweet_replies = []
    tweet_id_list = (doc1.xpath("//li/@data-item-id"))
    tweet_timestamp = (doc1.xpath("//div[contains(@class,'stream-item-header')]//span[contains(@class,'js-short-timestamp')]/@data-time"))
    tweet_content_list = (doc1.xpath("//div[contains(@class, 'js-tweet-text-container')]/p"))

    # tweet_content_ref  = (doc1.xpath("//div[contains(@class, 'js-tweet-text-container')][0]//a/@href"))
    tweet_user_list = (doc1.xpath("//div[contains(@class, 'js-stream-tweet')]/@data-screen-name"))
    tweet_content_retweet_list = (doc1.xpath(
        "//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--retweet')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))
    tweet_content_like_list = (doc1.xpath(
        "//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--favorite')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))

    for q in range(len(tweet_id_list)):
        obj = {}
        obj['tweet_id'] = tweet_id_list[q]
        obj['tweet_user'] = tweet_user_list[q]
        obj['tweet'] = (tweet_content_list[q].text_content())
        tweet_mentions = (tweet_content_list[q].xpath("./a[contains(@class, 'twitter-atreply')]/@href"))
        obj['tweet_account_tags'] = (",".join(tweet_mentions))
        tweet_hashtags = tweet_content_list[q].xpath("./a[contains(@class, 'twitter-hashtag')]/b")
        hash_list = []
        for hash in tweet_hashtags:
            hash_new = hash.text_content()
            hash_list.append(hash_new)
        obj['tweet_account_hashtags'] = (",".join(hash_list))
        obj['retweet_count'] = tweet_content_retweet_list[q]
        obj['like_count'] = tweet_content_like_list[q]
        obj['time_stamp'] = tweet_timestamp[q]
        tweet_replies.append(obj)
    i = 0
    counter = 1
    print counter
    while i < 1:
        tweet_id_list = []
        counter = counter + 1
        print counter
        params = {
            'f': 'tweets',
            'vertical': 'default',
            'q': keyword.lower(),
            'src': 'typd',
            'include_available_features': '1',
            'include_entities': '1',
            'max_position': max_pos,
            'oldest_unread_id': '0',
            'reset_error_state': 'false',
        }
        response = requests.get('https://twitter.com/i/search/timeline', headers=headers, params=params)
        output = response.json()
        max_pos = output['inner']['min_position']
        has_more_item = output['inner']['has_more_items']
        # try:
        doc = document_fromstring(output['inner']['items_html'])
        tweet_id_list = (doc.xpath("//li/@data-item-id"))
        tweet_timestamp = (doc.xpath(
            "//div[contains(@class,'stream-item-header')]//span[contains(@class,'js-short-timestamp')]/@data-time"))
        tweet_content_list = (doc.xpath("//div[contains(@class, 'js-tweet-text-container')]/p"))

        # tweet_content_ref  = (doc1.xpath("//div[contains(@class, 'js-tweet-text-container')][0]//a/@href"))
        tweet_user_list = (doc.xpath("//div[contains(@class, 'js-stream-tweet')]/@data-screen-name"))
        tweet_content_retweet_list = (doc.xpath(
            "//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--retweet')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))
        tweet_content_like_list = (doc.xpath(
            "//div[contains(@class,'ProfileTweet-actionCountList')]//span[contains(@class,'ProfileTweet-action--favorite')]/span[contains(@class,'ProfileTweet-actionCount')]/@data-tweet-stat-count"))

        for q in range(len(tweet_id_list)):
            obj = {}
            obj['tweet_id'] = tweet_id_list[q]
            obj['tweet_user'] = tweet_user_list[q]
            obj['tweet'] = (tweet_content_list[q].text_content())
            tweet_mentions = (tweet_content_list[q].xpath("./a[contains(@class, 'twitter-atreply')]/@href"))
            obj['tweet_account_tags'] = (",".join(tweet_mentions))
            tweet_hashtags = tweet_content_list[q].xpath("./a[contains(@class, 'twitter-hashtag')]/b")
            hash_list = []
            for hash in tweet_hashtags:
                hash_new = hash.text_content()
                hash_list.append(hash_new)
            obj['tweet_account_hashtags'] = (",".join(hash_list))
            obj['retweet_count'] = tweet_content_retweet_list[q]
            obj['like_count'] = tweet_content_like_list[q]
            obj['time_stamp'] = tweet_timestamp[q]
            yesterday = date.today() - timedelta(days=days)
            yesterday = yesterday.strftime('%s')
            if obj not in tweet_replies:
                tweet_replies.append(obj)
            # print str(tweet_timestamp[q]) + " | " + yesterday
            if int(max(tweet_timestamp)) <= int(yesterday):
                print "break time"
                i = 1

        if not has_more_item:
            i = 1
            print "break items ended"
    return tweet_replies

def get_tweet_numbers(postlink):
    headers = {
        'accept-encoding': 'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9',
        'x-requested-with': 'XMLHttpRequest',
        'cookie': 'personalization_id="v1_6oeebYoixN4zaGryJd2dpg=="; guest_id=v1%3A153358315639952327; __utma=43838368.1908293028.1533893229.1533893229.1533893229.1; __utmz=43838368.1533893229.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); syndication_guest_id=v1%3A153437412171689856; _ga=GA1.2.1908293028.1533893229; dnt=1; ads_prefs="HBISAAA="; kdt=V8DGZk6bb9kFTQFcCU3eNLoTX1dvx1aYhvrRckLA; remember_checked_on=1; twid="u=141564323"; auth_token=5d312aeedd80e1b38483f41fb65fcc944bebc160; csrf_same_site_set=1; csrf_same_site=1; lang=en; _twitter_sess=BAh7CSIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCOksTgVmAToHaWQiJWFm%250ANTk1ZWQ1YTYxZTlkMDVmMWEwOTRhZmRmMGQ4MDZkOgxjc3JmX2lkIiU1OTI1%250AYzlhZGZiOGM0N2U5ODVhYzZiZGUzMDU3OGUxMg%253D%253D--f0358cc72c485624a663b38742226c4c12ed994e; gsScrollPos-285783303=0; external_referer=8e8t2xd8A2w%3D|0|S38otfNfzYt86Dak8Eqj76tqscUAnK6LESViSTjTsScHl%2FV25YP3Eg%3D%3D; tfw_exp=0; ct0=cf5d546083d1e895f29d18472d455478; _gid=GA1.2.1410047711.1538050395; _gat=1',
        'pragma': 'no-cache',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
        'accept': 'application/json, text/javascript, */*; q=0.01',
        'x-overlay-request': 'true',
        'cache-control': 'no-cache',
        'authority': 'twitter.com',
        'referer': 'https://twitter.com/OkeOkkaduJMR',
        'x-previous-page-name': 'profile',
        'x-twitter-active-user': 'yes',
    }

    response = requests.get(postlink, headers=headers)

    output = response.json()
    doc = document_fromstring(output['page'])
    retweets = (doc.xpath("//li[contains(@class, 'js-stat-retweets')]/a[contains(@class, 'request-retweeted-popup')]/@data-tweet-stat-count"))
    likes = (doc.xpath("//li[contains(@class, 'js-stat-favorites')]/a[contains(@class, 'request-favorited-popup')]/@data-tweet-stat-count"))
    return {'likes':likes,"retweets":retweets}

def fetch_all_tweets(request):
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    i = 0
    tranObjs = Tweets.objects.all()
    for trans in tranObjs:
        i = i + 1
        obj['result'].append({
            'id': trans.id
            , 'tweet': trans.tweet
            , 'likes': trans.likes
            , 'retweets': trans.retweets
        })
    obj['status'] = True
    obj['counter'] = len(obj['result'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')

def get_retweet_likes():
    obj = {}
    obj['status'] = False
    obj['result'] = []
    tranObjs = None
    tranObjs = Tweets.objects.all()
    for trans in tranObjs:

        print trans.tweet
        data = get_tweet_numbers(trans.tweet)
        trans.likes = data['likes']
        trans.retweets = data['retweets']
        print data['likes']
        print data['retweets']
        trans.save()
    print "Done"

    # NB. Original query string below. It seems impossible to parse and
    # reproduce query strings 100% accurately so the one below is given
    # in case the reproduced version is not "correct".
    # response = requests.get('https://twitter.com/OkeOkkaduJMR/status/1044815068171575297?conversation_id=1044815068171575297', headers=headers)

#<------------------------------------------------------Summary------------------------------------------------------------------------------->

def mediascan_summary(request):
    result       = []
    obj          = {}
    keyword_id   = get_param(request, 'keyword_id', None)
    channel_id   = get_param(request, 'channel_id', None)
    author_id    = get_param(request, 'author_id', None)
    start_date   = get_param(request, 'start_date', None)
    end_date     = get_param(request, 'end_date', None)
    category_name= get_param(request, 'category_name', None)
    segment      = get_param(request, 'segment', None)
    whichtable   = get_param(request, 'whichtable', None)

    qs = MediaScan.objects.all()
    MastDict = {}
    MastDict["Article_ID"]   = []
    MastDict["Keyword_ID"]   = []
    MastDict["Keyword_Name"] = []
    MastDict["Keyword_Type"] = []
    MastDict["Sent"]         = []
    MastDict["Author"]       = []
    MastDict["Author_ID"]    = []
    MastDict["Channel"]      = []
    MastDict["Channel_ID"]   = []
    MastDict["Date"]         = []

    if keyword_id != None and keyword_id != "":
        qs = qs.filter(keyword_list__icontains=keyword_id)

    if channel_id != None and channel_id != "":
        qs = qs.filter(channel_id=channel_id)

    if author_id != None and author_id != "":
        qs = qs.filter(author_id=author_id)

    if category_name != None and category_name != "":
        qs = qs.filter(category__icontains=category_name)

    if segment != None and segment != "":
        qs = qs.filter(segmentation__icontains=segment)

    if start_date != None and start_date != "" and end_date != None and end_date != "":
        qs = qs.filter(created_at__range=(start_date, end_date))

    for i in qs:
        id = i.id
        list1       = i.user_sentiment_pair_keyword
        author      = i.author_name
        channel     = i.channel_name
        authorID    = i.author_id
        channelID   = i.channel_id
        date        = i.created_at
        for LD in list1:
            if LD != None:
                if keyword_id != None and keyword_id != "":
                    if LD['keyword_id'] == keyword_id:
                        MastDict["Article_ID"].append(id)
                        MastDict["Keyword_ID"].append(LD['keyword_id'])
                        MastDict["Keyword_Name"].append(LD['name'])
                        MastDict["Sent"].append(LD['sentiment'])
                        MastDict["Author"].append(author)
                        MastDict["Author_ID"].append(authorID)
                        MastDict["Channel"].append(channel)
                        MastDict["Channel_ID"].append(channelID)
                        MastDict["Date"].append(date)
                else:
                    MastDict["Article_ID"].append(id)
                    MastDict["Keyword_ID"].append(LD['keyword_id'])
                    MastDict["Keyword_Name"].append(LD['name'])
                    MastDict["Sent"].append(LD['sentiment'])
                    MastDict["Author"].append(author)
                    MastDict["Author_ID"].append(authorID)
                    MastDict["Channel"].append(channel)
                    MastDict["Channel_ID"].append(channelID)
                    MastDict["Date"].append(date)
        # print MastDict

    for Did in MastDict['Keyword_ID']:                              # adding Keyword type in Master Dictionary from Keyword models
        kwords = Keywords.objects.filter(id=Did)
        MastDict["Keyword_Type"].append(kwords[0].keyword_type)

    df = pd.DataFrame.from_dict(MastDict, orient='index').transpose()
    print tabulate(df, headers='keys', tablefmt='psql')

    if whichtable == "keyword_count":
        obj = {}
        result = []
        uniqueK = df['Keyword_ID'].unique()
        for i in uniqueK:
            Sentcount = {}
            mask1 = df["Keyword_ID"] == i
            df2 = df[mask1]
            print df2
            channel_collection = df2["Channel"].unique().tolist()
            Keyword_Name = df2["Keyword_Name"].unique().tolist()[0]
            Keyword_Type = df2["Keyword_Type"].unique().tolist()[0]
            Sentcount['total_count']        = len(df2)
            Sentcount['negative']           = len(df2[df2["Sent"] == "-1"])
            Sentcount['slightly_negative']  = len(df2[df2["Sent"] == "-0.5"])
            Sentcount['neutral']            = len(df2[df2["Sent"] == "0"])
            Sentcount['positive']           = len(df2[df2["Sent"] == "1"])
            Sentcount['slightly_postive']   = len(df2[df2["Sent"] == "0.5"])
            obj = {"summary": Sentcount,
                   "id": i,
                   "name": Keyword_Name,
                   "channel_collection": channel_collection,
                   "type": Keyword_Type}
            result.append(obj)
        response = HttpResponse(json.dumps(result), content_type='application/json')
        return response

    if whichtable == "author_count":
        obj = {}
        result = []
        uniqueA = df['Author_ID'].unique()
        for i in uniqueA:
            Sentcount = {}
            mask1 = df["Author_ID"] == i
            df2 = df[mask1]
            channel_collection = df2["Channel"].unique().tolist()
            Author_Name = df2["Author"].unique().tolist()[0]
            Sentcount['total_count']        = len(df2)
            Sentcount['negative']           = len(df2[df2["Sent"] == "-1"])
            Sentcount['slightly_negative']  = len(df2[df2["Sent"] == "-0.5"])
            Sentcount['Neutral']            = len(df2[df2["Sent"] == "0"])
            Sentcount['positive']           = len(df2[df2["Sent"] == "1"])
            Sentcount['slightly_positive']  = len(df2[df2["Sent"] == "0.5"])
            obj = {"summary": Sentcount,
                   "id": i,
                   "name": Author_Name,
                   "channel_collection": channel_collection}
            result.append(obj)
        response = HttpResponse(json.dumps(result), content_type='application/json')
        return response

    if whichtable == "channel_count":
        obj = {}
        result = []
        uniqueC = ""
        uniqueC = df['Channel_ID'].unique()
        for i in uniqueC:
            Sentcount = {}
            mask1 = df["Channel_ID"] == i
            df2 = df[mask1]
            # channel_collection=df2["Channel"].unique().tolist()
            Channel_Name = df2["Channel"].unique().tolist()[0]
            Sentcount['total_count']        = len(df2)
            Sentcount['negative']           = len(df2[df2["Sent"] == "-1"])
            Sentcount['slightly_negative']  = len(df2[df2["Sent"] == "-0.5"])
            Sentcount['Neutral']            = len(df2[df2["Sent"] == "0"])
            Sentcount['positive']           = len(df2[df2["Sent"] == "1"])
            Sentcount['slightly_positive']  = len(df2[df2["Sent"] == "0.5"])
            print Sentcount
            obj = {"summary": Sentcount,
                   "id": i,
                   "name": Channel_Name}
            result.append(obj)
        response = HttpResponse(json.dumps(result), content_type='application/json')
        return response

    if whichtable == "author_summary":
        obj = {}
        result = []
        DateDict = {}
        uniqueA = df['Author_ID'].unique()
        for i in uniqueA:
            Sentcount = {}
            df2 = df[df["Author_ID"] == i]
            channel_collection = df2["Channel"].unique().tolist()
            try:
                Author_Name = df2["Author"].unique().tolist()[0]
            except:
                pass
                Author_Name = None
            Sentcount['total_count']=0
            Sentcount['total_count'] = len(df2)
            uniqueD = df2["Date"].unique()
            for j in uniqueD:
                Sentcount = {}
                df3 =""
                df3 = df2[df2['Date'] == j]
                Sentcount['total_count']        = len(df3)
                Sentcount['negative']           = len(df3[df3["Sent"] == "-1"])
                Sentcount['slightly_negative']  = len(df3[df3["Sent"] == "-0.5"])
                Sentcount['neutral']            = len(df3[df3["Sent"] == "0"])
                Sentcount['positive']           = len(df3[df3["Sent"] == "1"])
                Sentcount['slightly_positive']  = len(df3[df3["Sent"] == "0.5"])
                Sentcount['date']               = str(j.strftime('%d/%m/%Y'))
                obj = {"summary": Sentcount,
                       "id": i,
                       "name": Author_Name,
                       "channel_collection": channel_collection}
            result.append(obj)
        response = HttpResponse(json.dumps(result), content_type='application/json')
        return response

    if whichtable == "keyword_summary":
        obj = {}
        DateDict = {}
        uniqueK = df['Keyword_ID'].unique()
        for i in uniqueK:
            Sentcount = {}
            df2 = df[df["Keyword_ID"] == i]
            channel_collection = df2["Channel"].unique().tolist()
            try:
                Keyword_Name = df2["Keyword_Name"].unique().tolist()[0]
            except:
                pass
                Keyword_Name = None
            Sentcount['total_count'] = len(df2)
            uniqueD = df2["Date"].unique()
            for j in uniqueD:
                Sentcount = {}
                df3 = df2[df2['Date'] == j]
                Sentcount['total_count']        = len(df3)
                Sentcount['negative']           = len(df3[df3["Sent"] == "-1"])
                Sentcount['slightly_negative']  = len(df3[df3["Sent"] == "-0.5"])
                Sentcount['neutral']            = len(df3[df3["Sent"] == "0"])
                Sentcount['positive']           = len(df3[df3["Sent"] == "1"])
                Sentcount['slightly_positive']  = len(df3[df3["Sent"] == "0.5"])
                Sentcount['date'] = str(j.strftime('%d/%m/%Y'))
                obj = {"summary": Sentcount,
                       "id": i,
                       "name": Keyword_Name,
                       "channel_collection": channel_collection}
            result.append(obj)
        response = HttpResponse(json.dumps(result), content_type='application/json')
        return response

    if whichtable == "channel_summary":
        obj = {}
        DateDict = {}
        uniqueC = df['Channel_ID'].unique()
        for i in uniqueC:
            Sentcount = {}
            df2 = df[df["Channel_ID"] == i]
            try:
                Channel_Name = df2["Channel"].unique().tolist()[0]
            except:
                pass
                Channel_Name = None
            Sentcount['total_count'] = len(df2)
            uniqueD = df2["Date"].unique()
            for j in uniqueD:
                Sentcount = {}
                df3 = df2[df2['Date'] == j]
                Sentcount['total_count']        = len(df3)
                Sentcount['negative']           = len(df3[df3["Sent"] == "-1"])
                Sentcount['slightly_negative']  = len(df3[df3["Sent"] == "-0.5"])
                Sentcount['neutral']            = len(df3[df3["Sent"] == "0"])
                Sentcount['positive']           = len(df3[df3["Sent"] == "1"])
                Sentcount['slightly_positive']  = len(df3[df3["Sent"] == "0.5"])
                Sentcount['date'] = str(j.strftime('%d/%m/%Y'))
                obj = {"summary": Sentcount,
                       "id": i,
                       "name": Channel_Name}
            result.append(obj)
        response = HttpResponse(json.dumps(result), content_type='application/json')
        return response



#<------------------------------------------------------Summary closed------------------------------------------------------------------------------->


# TO CALCULATE TOTAL NUMBER OF SENTIMENTS OF ANY ENITITY
# df1=(df[df["Keyword_ID"]=="5bea711a520925075643fff5"]).groupby("Sent").size()

# TO CALCULATE NUMBER OF ARTICLE CORRESPONDING TO A LEADER
# df1=(df[df['Keyword_ID']=="5bea711a520925075643fff5"])['Article_ID'].nunique()


# <------------------ Twitter Code End ------------------------->



# Cron Requests

def cron_job_1(request):
    obj = {}
    obj['status'] = False
    obj['result'] = {}
    obj['status'] = True
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def cron_job_3(request):
    obj = {}
    obj['status'] = False
    obj['result'] = {}

    obj['status'] = True
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def cron_job_6(request):
    obj = {}
    obj['status'] = False
    obj['result'] = {}
    # update_
    obj['status'] = True
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def cron_job_12(request):
    obj = {}
    obj['status'] = False
    obj['result'] = {}

    obj['status'] = True
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response

def cron_job_24(request):
    obj = {}
    obj['status'] = False
    obj['result'] = {}
    # try:
    #     socialviews.update_page_data()
    # except:
    #     None
    # try:
    #     scrape_rss("")
    # except:
    #     None
    obj['status'] = True
    response = HttpResponse(json.dumps(obj), content_type='application/json')
    return response


#
# import requests
#
# cookies = {
#     'I8eTT7vh01': 'MDAwM2IyYzhmNDAwMDAwMDAxODEwLiI2ZxUxNTQwNjM4NDA2',
#     'JSESSIONID': '1B33539C63563D2D77D6761CACB997B4.lgd',
# }
#
# headers = {
#     'Pragma': 'no-cache',
#     'Origin': 'http://lgdirectory.gov.in',
#     'Accept-Encoding': 'gzip, deflate',
#     'Accept-Language': 'en-US,en;q=0.9',
#     'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
#     'Content-Type': 'text/plain',
#     'Accept': '*/*',
#     'Cache-Control': 'no-cache',
#     'Referer': 'http://lgdirectory.gov.in/',
#     'Connection': 'keep-alive',
# }
#
# params = {
# 'callCount':'1',
# 'windowName':'',
# 'c0-scriptName':'dwrReportService',
# 'c0-methodName':'getParentwiseChildDetils',
# 'c0-id':'0',
# 'c0-param0':'string:T',
# 'c0-param1':'number:5462',
# 'c0-param2':'string:L',
# 'c0-param3':'null:null',
# 'batchId':'3',
# 'page':'%2F',
# 'httpSessionId':'',
# 'scriptSessionId':'FDDE4E237E0B4109E030205478741167'
# }
# response = requests.post('http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr', headers=headers, cookies=cookies, params=params)

# import requests
#
# cookies = {
#     'I8eTT7vh01': 'MDAwM2IyYzhmNDAwMDAwMDAxODEwOB5TL08xNTQwNjQyMzc1',
#     'JSESSIONID': 'C6CACEC6901BBE2BD8AFDD43EC150EAC.lgd',
# }
#
# headers = {
#     'Pragma': 'no-cache',
#     'Origin': 'http://lgdirectory.gov.in',
#     'Accept-Encoding': 'gzip, deflate',
#     'Accept-Language': 'en-US,en;q=0.9',
#     'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
#     'Content-Type': 'text/plain',
#     'Accept': '*/*',
#     'Cache-Control': 'no-cache',
#     'Referer': 'http://lgdirectory.gov.in/',
#     'Connection': 'keep-alive',
# }
#
# params = {'callCount':'1',
# 'windowName':'',
# 'c0-scriptName':'dwrReportService',
# 'c0-methodName':'getParentwiseChildDetils',
# 'c0-id':'0',
# 'c0-param0':'string:S',
# 'c0-param1':'number:7',
# 'c0-param2':'string:L',
# 'c0-param3':'string:X',
# 'batchId':'2',
# 'page':'%2F',
# 'httpSessionId':'',
# 'scriptSessionId':'236CF041DCC6136C737553E2026FAEFC'}
#
# response = requests.post('http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr', headers=headers, cookies=cookies, params=params)
def emailapi(request):
    me = 'akshay.saini@indianpac.com'
    password = 'indianpac'
    server = 'smtp.gmail.com:587'
    # you = 'rajesh.hanswal@indianpac.com'
    # ak = 'akshay.saini@indianpac.com'

    html = str(dateTIME.datetime.now().strftime("%d-%b-%Y,%H:%M:%S GMT"))+" baj gae. Ab email aaega next hour"
    message = MIMEMultipart("alternative", None, [MIMEText(html, 'html')])

    message['Subject'] = "Time check Akshay !!"
    message['From'] = me

    all = ["akshay.saini@indianpac.com","saini.akii@gmail.com"]
    # all = ["akshay.saini@indianpac.com", ]
    cc = copy.copy(all)
    to = "rajesh.hanswal@indianpac.com"
    if to in cc: cc.remove(to)
    message['To'] = to
    message['cc'] = ",".join(cc)
    print "ab email jaega 420 sec baad"
    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.ehlo()
    server.starttls()
    server.login(me, password)
    server.sendmail(me, all, message.as_string())
    server.quit()

def logwrite1(request):
    f = open("django_cron_log.txt", "a+")
    f.write("cron runs on " + str(dateTIME.datetime.now().strftime("%d-%b-%Y,%H:%M:%S GMT")) + "\r\n")
    f.close()

# def logwrite2(request):
#     f = open("django_cron_log_15.txt", "a+")
#     f.write("cron runs on " + str(dateTIME.datetime.now().strftime("%d-%b-%Y,%H:%M:%S GMT")) + "\r\n")
#     f.close()