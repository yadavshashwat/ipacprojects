from django.core import serializers
from django.http import HttpResponse, Http404, HttpResponseBadRequest
from django.views.decorators.csrf import csrf_exempt
import time as ntime
from time import mktime
from datetime import datetime,timedelta,date,time

from pprint import pprint
from bson import json_util
import json
import uuid
from django.conf import settings
from django.shortcuts import render, render_to_response
from django.views.decorators.http import require_GET,require_POST
import urlparse
from operator import itemgetter
from collections import OrderedDict

# from api.views import *
from models import *
# Create your views here.

def temp(request):
  return HttpResponse("OK")

def login(request):
  return render_to_response('fblogin.html')

yesterday = date.today () - timedelta (days=1)
t = time(hour=1 , minute=30)
# t = time(hour=7 , minute=3)
day_before = date.today () - timedelta (days=1)
since_date = datetime.combine(day_before, t).strftime('%s')
untill_date = datetime.combine(yesterday, t).strftime('%s')
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

@require_POST
def xhr_user_token(request):
  user_id = request.POST.get('user_id')
  sl_token = request.POST.get('sl_token')
  expiry = request.POST.get('expiry')
  app_id = request.POST.get('app_id')
  # Update DB for user
  users = User.objects.filter(user_id=user_id)
  if len(users) < 1:
    # User not present; Create
    user = User.objects.create(
        user_id=user_id,
        user_access_token=sl_token,
        user_access_expiry=datetime.fromtimestamp(
            int(ntime.time())+int(expiry)),
        linked_app=App.objects.get(client_id=app_id),
    )
    # exchange short lived token for a long lived token [User]
    if user.upgrade_token():
      return HttpResponse("User Sign In OK")
    else:
      return HttpResponse("LL token upgrade failed for "+sl_token)
  else:
    # users.update(user_access_token=sl_token)
    # if users[0].upgrade_token():
    #   return HttpResponse("User Sign In OK")
    # else:
    #   return HttpResponse("LL token upgrade failed for "+sl_token)
    # # TODO: User Token Update; If token expiry passed
    return HttpResponse("User Log In OK")


@require_POST
def xhr_page_data(request):
  access_token = request.POST.get('access_token')
  user_id = request.POST.get('user_id')
  category = request.POST.get('category')
  id = request.POST.get('id')
  name = request.POST.get('name')
  # Update DB for page
  pages = Page.objects.filter(
      page_id=id, linked_user=User.objects.get(user_id=user_id))
  if len(pages) < 1:
    # Page not present; Create
    page = Page.objects.create(
        page_name=name,
        page_category=category,
        page_access_token=access_token,
        page_id=id,
        linked_user=User.objects.get(user_id=user_id))
    # exchange page token for a permanent token [Page]
    if page.upgrade_token():
      return HttpResponse("Page Info OK : "+name)
    else:
      return HttpResponse("Perm token upgrade failed for "+id)
  else:
    # pages.update(page_access_token=access_token)
    # if pages[0].upgrade_token():
    #   return HttpResponse("Page Info OK : "+name)
    # else:
    #   return HttpResponse("Perm token upgrade failed for "+id)
    # TODO: Page Token Update; If token expiry passed
    return HttpResponse("Page Log In OK")

LOCATION = 'social/static/'
if settings.PRODUCTION:
    ADDRESS = 'https://www.ipactesting.com/api/static/'
else:
    ADDRESS = 'http://127.0.0.1:8000/static/'

# <-----------------------updates the page data-------------------------------------->
def update_page_data(daydiff = 1):
    if daydiff ==1:
        for page in Page.objects.all():
            try:
                fetch_facebook_page(access_token=page.page_access_token)
            except:
                continue
    else:
        yesterday = date.today () - timedelta (days=daydiff)
        t = time(hour=1, minute=30)
        day_before = date.today () - timedelta (days=daydiff)
        since_date_new = datetime.combine(day_before, t).strftime('%s')
        untill_date_new = datetime.combine(yesterday, t).strftime('%s')
        for page in Page.objects.all():
            try:
                fetch_facebook_page(access_token=page.page_access_token,startdate=since_date_new,enddate=untill_date_new)
            except:
                continue
# <--------------------------------Scheduled Post Data For App Review------------------------------------>
def scheduledPosts(request):
        # pages = get_param(request, 'pages', None)
    if request.method == "GET":
        return Http404
    else:
        obj = {}
        obj['status'] = False
        obj['results'] = []
        # get params
        pages = request.POST['pages']
        pages = json.loads(pages)
        if len(pages):
            data_dict = {}
            for page in pages:
                access_token = page['name']['access_token']
                name = page['name']['name']
                response = requests.get('https://graph.facebook.com/v3.2/me/scheduled_posts?fields=scheduled_publish_time%2Ccreated_time%2Clink%2Ctype%2Cmessage%2Cstory&access_token='+access_token)
                response_data = response.json()['data']
                if len(response_data):
                    for posts in response_data:
                        if "scheduled_publish_time" in posts.keys():
                            data_dict = posts
                            data_dict['page_name'] = str(name)
                            obj['results'].append(data_dict)
                            data_dict = {}
        obj['status'] = True
        obj['msg'] = "Success"
        return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <------------------------------------ Update Post Data of all Pages------------------------------------>
def update_post_data():
    for page in Page.objects.all():
        try:
            fetch_facebook_posts(access_token=page.page_access_token,page_id=page.page_id )
        except:
            continue
        ntime.sleep(30)

# <-----------------------------removing duplicate dictionaries from a list of DICT---------------------->
def in_dictlist((key, value), my_dictlist):
    for this in my_dictlist:
        if this[key] == value:
            return this
# <----------------------------------updating all pages data to mongodb---------------------------------->
def fetch_facebook_all(request):
    obj = {}
    obj['status'] = False
    tranObjs = Page.objects.all()
    for trans in tranObjs:
        fetch_facebook_page(page_id=trans.page_id,page_name=trans.page_name)
        obj['status'] = True
        obj['msg'] = "Success"
        return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <---------------------------------fetch data of one page-------------------------------------->
def fetch_facebook_page_data(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []
    page_id = get_param(request, 'page_id', None)
    post_id = get_param(request, 'post_id', None)
    page_category   = get_param(request, 'page_category', None)
    page_state      = get_param(request, 'page_state', None)
    page_district   = get_param(request, 'page_district', None)
    page_management = get_param(request, 'page_management', None)
    page_poc        = get_param(request, 'page_poc', None)

    tranObjs = None
    tranObjs = Post.objects.all()
    if page_id:
        tranObjs = tranObjs.filter(page_id = page)
    if post_id:
        tranObjs = tranObjs.filter(post_id = post_id)
    if page_category:
        tranObjs = tranObjs.filter(page_category = page_category)
    if page_state:
        tranObjs = tranObjs.filter(page_state = page_state)
    if page_district:
        tranObjs = tranObjs.filter(page_district = page_district)
    if page_management:
        tranObjs = tranObjs.filter(page_management = page_management)
    if page_poc:
        tranObjs = tranObjs.filter(page_poc = page_poc)

    for trans in tranObjs:
        obj['results'].append({
            'page_id'                                               : trans.page_id,
            'page_category'                                         : trans.page_category,
            'page_district'                                         : trans.page_district,
            'page_state'                                            : trans.page_state,
            'page_name'                                             : trans.page_name,
        })

    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <------------------------------fetch facebook page by state,district,category------------------------------------->
def facebook_page_filter(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)
    page_name = get_param(request, 'page_name', None)
    state = get_param(request, 'page_state', None)
    district = get_param(request, 'page_district', None)
    # category = get_param(request, 'page_category', None)

    tranObjs = None

    tranObjs = Page.objects.all()
    # if page:
    #     tranObjs = tranObjs.filter(page_id = page)
    if state:
        tranObjs = tranObjs.filter(page_state = state)
    if district:
        tranObjs = tranObjs.filter(page_district = district)

    if page_name!= None and page_name != "":
        tranObjs = tranObjs.filter(page_name__icontains = page_name)

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

    # if tranObjs!=None:
    for trans in tranObjs:
        page_data = {}
        page_data['page_id'] = trans.page_id
        page_data['page_name'] = trans.page_name
        page_data['page_category'] = trans.page_category
        page_data['page_state']   = trans.page_state
        page_data['page_district'] = trans.page_district

        if len(trans.page_fans):
            page_data['page_fans'] = trans.page_fans[-1]['value']
        else:
            page_data['page_fans'] = 0

        if len(trans.page_fan_adds):
            page_data['page_fan_adds'] = trans.page_fan_adds[-1]['value']
        else:
            page_data['page_fan_adds'] = 0

        if len(trans.page_impressions_day):
            page_data['page_impressions_day'] = trans.page_impressions_day[-1]['value']
        else:
            page_data['page_impressions_day'] = 0

        if len(trans.page_views_total_day):
            page_data['page_views_total_day'] = trans.page_views_total_day[-1]['value']
        else:
            page_data['page_views_total_day'] = 0

        if len(trans.page_negative_feedback_day):
            page_data['page_negative_feedback_day'] = trans.page_negative_feedback_day[-1]['value']
        else:
            page_data['page_negative_feedback_day'] = 0

        obj['results'].append(page_data)

    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <------------------------facebook page overview------------------->
def facebook_page_overview(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)
    page_category = get_param(request, 'page_category', None)
    page_state      = get_param(request, 'page_state', None)
    page_district   = get_param(request, 'page_district', None)
    page_category = get_param(request, 'page_category', None)
    page_management = get_param(request, 'page_management', None)
    page_poc        = get_param(request, 'page_poc', None)
    start_date      = get_param(request, 'start_date', None)
    end_date        = get_param(request, 'end_date', None)

    tranObjs = None

    tranObjs = Page.objects.all()
    if page_category:
        tranObjs = tranObjs.filter(page_category = page_category)
    if page_state:
        tranObjs = tranObjs.filter(page_state = page_state)
    if page_district:
        tranObjs = tranObjs.filter(page_district = page_district)
    if page_management:
        tranObjs = tranObjs.filter(page_management = page_management)
    if page_poc:
        tranObjs = tranObjs.filter(page_poc = page_poc)

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

    yesterday  = date.today()-timedelta(1)
    for trans in tranObjs:
        page_overview = {}
        page_overview['page_likes_organic'] = 0
        page_overview['page_likes_paid'] = 0
        page_overview['page_id'] = trans.page_id
        page_overview['page_name'] = trans.page_name
        page_overview['page_category'] = trans.page_category
        page_overview['page_state']   = trans.page_state
        page_overview['page_district'] = trans.page_district

        if len(trans.page_fans):
            page_overview['page_fans'] = trans.page_fans[-1]['value']
        else:
            page_overview['page_fans'] = 0

        if len(trans.page_fan_adds_unique_days_28):
            page_overview['page_fan_adds_unique_days_28'] = trans.page_fan_adds_unique_days_28[-1]['value']
        else:
            page_overview['page_fan_adds_unique_days_28'] = 0

        if len(trans.page_impressions_days_28):
            page_overview['page_impressions_days_28'] = trans.page_impressions_days_28[-1]['value']
        else:
            page_overview['page_impressions_days_28'] = 0

        if len(trans.page_views_total_days_28):
            page_overview['page_views_total_days_28'] = trans.page_views_total_days_28[-1]['value']
        else:
            page_overview['page_views_total_days_28'] = 0

        if len(trans.page_negative_feedback_days_28):
            page_overview['page_negative_feedback_days_28'] = trans.page_negative_feedback_days_28[-1]['value']
        else:
            page_overview['page_negative_feedback_days_28'] = 0

        if len(trans.page_impressions_unique_days_28):
            page_overview['page_impressions_unique_days_28'] = trans.page_impressions_unique_days_28[-1]['value']
        else:
            page_overview['page_impressions_unique_days_28'] = 0

        if len(trans.page_engaged_users_days_28):
            page_overview['page_engaged_users_days_28'] = trans.page_engaged_users_days_28[-1]['value']
        else:
            page_overview['page_engaged_users_days_28'] = 0

        likes = trans.page_fan_adds_by_paid_non_paid_unique
        if len(likes):
            for like in sorted(likes, key=itemgetter('end_time'))[::-1]:
                dt3 = datetime.strptime(like['end_time'].split('T')[0], '%Y-%m-%d').date()
                if (yesterday-dt3).days<=27:
                    page_overview['page_likes_organic'] += like['value']['unpaid']
                    page_overview['page_likes_paid'] += like['value']['paid']

        obj['results'].append(page_overview)

    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <-----------------------------facebook page overview daily-------------------------------->
def facebook_page_overview_daily(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_num        = get_param(request, 'page_num', None)
    page_size       = get_param(request, 'page_size', None)
    page_category   = get_param(request, 'page_category', None)
    page_state      = get_param(request, 'page_state', None)
    page_district   = get_param(request, 'page_district', None)
    page_management = get_param(request, 'page_management', None)
    page_poc        = get_param(request, 'page_poc', None)
    start_date      = get_param(request, 'start_date', None)
    end_date        = get_param(request, 'end_date', None)

    tranObjs = None

    tranObjs = Page.objects.all()
    if page_category:
        tranObjs = tranObjs.filter(page_category = page_category)
    if page_state:
        tranObjs = tranObjs.filter(page_state = page_state)
    if page_district:
        tranObjs = tranObjs.filter(page_district = page_district)
    if page_management:
        tranObjs = tranObjs.filter(page_management = page_management)
    if page_poc:
        tranObjs = tranObjs.filter(page_poc = page_poc)

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

    pages = []
    if start_date==end_date==None:
        for trans in tranObjs:
            page_overview_daily = {}
            page_overview_daily['page_id']              = trans.page_id
            page_overview_daily['page_name']            = trans.page_name
            page_overview_daily['page_category']        = trans.page_category
            page_overview_daily['page_state']           = trans.page_state
            page_overview_daily['page_district']        = trans.page_district
            page_overview_daily['page_management']      = trans.page_management
            page_overview_daily['page_poc']             = trans.page_poc

            if len(trans.page_fans):
                page_overview_daily['page_fans'] = trans.page_fans[-1]['value']
            else:
                page_overview_daily['page_fans'] = 0

            if len(trans.page_fan_adds):
                page_overview_daily['page_fan_adds'] = trans.page_fan_adds[-1]['value']
            else:
                page_overview_daily['page_fan_adds'] = 0

            if len(trans.page_impressions_day):
                page_overview_daily['page_impressions_day'] = trans.page_impressions_day[-1]['value']
            else:
                page_overview_daily['page_impressions_day'] = 0

            if len(trans.page_impressions_unique_day):
                page_overview_daily['page_impressions_unique_day'] = trans.page_impressions_unique_day[-1]['value']
            else:
                page_overview_daily['page_impressions_unique_day'] = 0

            if len(trans.page_views_total_day):
                page_overview_daily['page_views_total_day'] = trans.page_views_total_day[-1]['value']
            else:
                page_overview_daily['page_views_total_day'] = 0

            if len(trans.page_negative_feedback_day):
                page_overview_daily['page_negative_feedback_day'] = trans.page_negative_feedback_day[-1]['value']
            else:
                page_overview_daily['page_negative_feedback_day'] = 0

            if len(trans.page_engaged_users_day):
                page_overview_daily['page_engaged_users_day'] = trans.page_engaged_users_day[-1]['value']
            else:
                page_overview_daily['page_engaged_users_day'] = 0

            if len(trans.page_fan_adds_by_paid_non_paid_unique):
                page_overview_daily['page_likes_organic'] = trans.page_fan_adds_by_paid_non_paid_unique[-1]['value']['unpaid']
                page_overview_daily['page_likes_paid'] = trans.page_fan_adds_by_paid_non_paid_unique[-1]['value']['paid']
            else:
                page_overview_daily['page_likes_organic'] = 0
                page_overview_daily['page_likes_paid'] = 0

            pages.append(page_overview_daily)
        obj['results'].extend(sorted(pages, key=itemgetter('page_fans'),reverse=True))
        obj['msg'] = "Success"
        obj['status'] = True

    elif start_date and end_date:
        dt1 = datetime.strptime(start_date, '%Y-%m-%d')
        dt2 = datetime.strptime(end_date, '%Y-%m-%d')
        if dt1==dt2:
            for trans in tranObjs:
                page_overview_daily = {}
                page_overview_daily['page_fan_adds']                        = 0
                page_overview_daily['page_impressions_day']                 = 0
                page_overview_daily['page_views_total_day']                 = 0
                page_overview_daily['page_negative_feedback_day']           = 0
                page_overview_daily['page_engaged_users_day']               = 0
                page_overview_daily['page_likes_organic']                   = 0
                page_overview_daily['page_likes_paid']                      = 0
                page_overview_daily['page_impressions_unique_day']          = 0
                page_overview_daily['page_id']                              = trans.page_id
                page_overview_daily['page_name']                            = trans.page_name
                page_overview_daily['page_category']                        = trans.page_category
                page_overview_daily['page_state']                           = trans.page_state
                page_overview_daily['page_district']                        = trans.page_district
                page_overview_daily['page_management']                      = trans.page_management
                page_overview_daily['page_poc']                             = trans.page_poc

                if len(trans.page_fans):
                    page_overview_daily['page_fans'] = trans.page_fans[-1]['value']
                else:
                    page_overview_daily['page_fans'] = 0


                if len(trans.page_fan_adds):
                    for new_likes in sorted(trans.page_fan_adds, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(new_likes['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_fan_adds'] += new_likes['value']
                            break
                # page_impressions_day
                if len(trans.page_impressions_day):
                    for impressions in sorted(trans.page_impressions_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(impressions['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_impressions_day'] += impressions['value']
                            break
                # page_impressions_unique_day
                if len(trans.page_impressions_unique_day):
                    for impressions_unique in sorted(trans.page_impressions_unique_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(impressions_unique['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_impressions_unique_day'] += impressions_unique['value']
                            break

                # page_views_total_day
                if len(trans.page_views_total_day):
                    for views in sorted(trans.page_views_total_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(views['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_views_total_day'] += impressions['value']
                            break
                # page_negative_feedback_day
                if len(trans.page_negative_feedback_day):
                    for negatives in sorted(trans.page_negative_feedback_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(negatives['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_negative_feedback_day'] += negatives['value']
                            break
                # page_engaged_users_day
                if len(trans.page_engaged_users_day):
                    for engagement in sorted(trans.page_engaged_users_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(engagement['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_engaged_users_day'] += engagement['value']
                            break
                # page_impressions_organic_unique_day
                if len(trans.page_fan_adds_by_paid_non_paid_unique):
                    for organic_reach in sorted(trans.page_fan_adds_by_paid_non_paid_unique, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(organic_reach['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3==dt2:
                            page_overview_daily['page_likes_organic'] += organic_reach['value']['unpaid']
                            page_overview_daily['page_likes_paid'] += organic_reach['value']['paid']
                            break

                pages.append(page_overview_daily)
            obj['results'].extend(sorted(pages, key=itemgetter('page_fans'),reverse=True))
            obj['msg'] = "Success"
            obj['status'] = True

        elif dt2>dt1:
            for trans in tranObjs:
                page_overview_daily = {}
                page_overview_daily['page_fan_adds']                          = 0
                page_overview_daily['page_impressions_day']                   = 0
                page_overview_daily['page_views_total_day']                   = 0
                page_overview_daily['page_negative_feedback_day']             = 0
                page_overview_daily['page_likes_organic']                     = 0
                page_overview_daily['page_engaged_users_day']                 = 0
                page_overview_daily['page_likes_paid']                        = 0
                page_overview_daily['page_impressions_unique_day']            = 0
                page_overview_daily['page_id']                                = trans.page_id
                page_overview_daily['page_name']                              = trans.page_name
                page_overview_daily['page_category']                          = trans.page_category
                page_overview_daily['page_state']                             = trans.page_state
                page_overview_daily['page_district']                          = trans.page_district
                page_overview_daily['page_management']                        = trans.page_management
                page_overview_daily['page_poc']                               = trans.page_poc

                if len(trans.page_fans):
                    page_overview_daily['page_fans'] = trans.page_fans[-1]['value']
                else:
                    page_overview_daily['page_fans'] = 0


                if len(trans.page_fan_adds):
                    for new_likes in sorted(trans.page_fan_adds, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(new_likes['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_fan_adds'] += new_likes['value']
                                break
                            else:
                                page_overview_daily['page_fan_adds'] += new_likes['value']

                if len(trans.page_impressions_day):
                    for impressions in sorted(trans.page_impressions_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(impressions['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_impressions_day'] = impressions['value']
                                break
                            else:
                                page_overview_daily['page_impressions_day'] = impressions['value']

                if len(trans.page_impressions_unique_day):
                    for impressions_unique in sorted(trans.page_impressions_unique_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(impressions_unique['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_impressions_unique_day'] = impressions_unique['value']
                                break
                            else:
                                page_overview_daily['page_impressions_unique_day'] = impressions_unique['value']

                # page_views_total_day
                if len(trans.page_views_total_day):
                    for views in sorted(trans.page_views_total_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(views['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_views_total_day'] = impressions['value']
                                break
                            else:
                                page_overview_daily['page_views_total_day'] = impressions['value']
                # page_negative_feedback_day
                if len(trans.page_negative_feedback_day):
                    for negatives in sorted(trans.page_negative_feedback_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(negatives['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_negative_feedback_day'] = negatives['value']
                                break
                            else:
                                page_overview_daily['page_negative_feedback_day'] = negatives['value']

                if len(trans.page_engaged_users_day):
                    for engagement in sorted(trans.page_engaged_users_day, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(engagement['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_engaged_users_day'] += engagement['value']
                                break
                            else:
                                page_overview_daily['page_engaged_users_day'] += engagement['value']

                if len(trans.page_fan_adds_by_paid_non_paid_unique):
                    for organic_reach in sorted(trans.page_fan_adds_by_paid_non_paid_unique, key=itemgetter('end_time'))[::-1]:
                        dt3 = datetime.strptime(organic_reach['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                page_overview_daily['page_likes_organic'] += organic_reach['value']['unpaid']
                                page_overview_daily['page_likes_paid']  += organic_reach['value']['paid']
                                break
                            else:
                                page_overview_daily['page_likes_organic'] += organic_reach['value']['unpaid']
                                page_overview_daily['page_likes_paid']+= organic_reach['value']['paid']

                pages.append(page_overview_daily)
            obj['results'].extend(sorted(pages, key=itemgetter('page_fans'),reverse=True))
            obj['msg'] = "Success"
            obj['status'] = True
        else:
            obj['msg'] = "Please Select End Date Higher than Start Date "
            obj['status'] = False
    else:
        if start_date:
            obj['msg'] = "Please Select End Date"
            obj['status'] = False
        else:
            obj['msg'] = "Please Select Start Date"
            obj['status'] = False

    obj['counter'] = len(obj['results'])
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')


# <-----------------------------facebook page overview daily-------------------------------->
def facebook_page_overview_weekly(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)
    page_state      = get_param(request, 'page_state', None)
    page_district   = get_param(request, 'page_district', None)
    page_category = get_param(request, 'page_category', None)
    page_management = get_param(request, 'page_management', None)
    page_poc        = get_param(request, 'page_poc', None)
    start_date      = get_param(request, 'start_date', None)
    end_date        = get_param(request, 'end_date', None)

    tranObjs = None

    tranObjs = Page.objects.all()
    if page_category:
        tranObjs = tranObjs.filter(page_category = page_category)
    if page_state:
        tranObjs = tranObjs.filter(page_state = page_state)
    if page_district:
        tranObjs = tranObjs.filter(page_district = page_district)
    if page_management:
        tranObjs = tranObjs.filter(page_management = page_management)
    if page_poc:
        tranObjs = tranObjs.filter(page_poc = page_poc)
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

    pages = []
    for trans in tranObjs:
        page_overview_weekly = {}
        page_overview_weekly['page_likes_organic'] = 0
        page_overview_weekly['page_likes_paid'] = 0
        page_overview_weekly['page_id'] = trans.page_id
        page_overview_weekly['page_name'] = trans.page_name
        page_overview_weekly['page_category'] = trans.page_category
        page_overview_weekly['page_state']   = trans.page_state
        page_overview_weekly['page_district'] = trans.page_district

        if len(trans.page_fans):
            page_overview_weekly['page_fans'] = trans.page_fans[-1]['value']
        else:
            page_overview_weekly['page_fans'] = 0

        if len(trans.page_fan_adds_unique_week):
            page_overview_weekly['page_fan_adds'] = trans.page_fan_adds_unique_week[-1]['value']
        else:
            page_overview_weekly['page_fan_adds'] = 0

        if len(trans.page_impressions_week):
            page_overview_weekly['page_impressions_week'] = trans.page_impressions_week[-1]['value']
        else:
            page_overview_weekly['page_impressions_week'] = 0

        if len(trans.page_views_total_week):
            page_overview_weekly['page_views_total_week'] = trans.page_views_total_week[-1]['value']
        else:
            page_overview_weekly['page_views_total_week'] = 0

        if len(trans.page_negative_feedback_week):
            page_overview_weekly['page_negative_feedback_week'] = trans.page_negative_feedback_week[-1]['value']
        else:
            page_overview_weekly['page_negative_feedback_week'] = 0

        if len(trans.page_impressions_organic_unique_week):
            page_overview_weekly['page_impressions_organic_unique_week'] = trans.page_impressions_organic_unique_week[-1]['value']
        else:
            page_overview_weekly['page_impressions_organic_unique_week'] = 0

        if len(trans.page_engaged_users_week):
            page_overview_weekly['page_engaged_users_week'] = trans.page_engaged_users_week[-1]['value']
        else:
            page_overview_weekly['page_engaged_users_week'] = 0

        likes = trans.page_fan_adds_by_paid_non_paid_unique
        if len(likes):
            for like in sorted(likes, key=itemgetter('end_time'))[::-1]:
                dt3 = datetime.strptime(like['end_time'].split('T')[0], '%Y-%m-%d').date()
                if (yesterday-dt3).days<=6:
                    page_overview_weekly['page_likes_organic'] += like['value']['unpaid']
                    page_overview_weekly['page_likes_paid'] += like['value']['paid']

        pages.append(page_overview_weekly)
    obj['results'].extend(sorted(pages, key=itemgetter('page_fans'),reverse=True))
    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')


# <----------------------------------- Overall Page Metrics----------------------->
def overall_page_metrics(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_category   = get_param(request, 'page_category', None)
    page_state      = get_param(request, 'page_state', None)
    page_district   = get_param(request, 'page_district', None)
    page_management = get_param(request, 'page_management', None)
    page_poc        = get_param(request, 'page_poc', None)
    start_date      = get_param(request, 'start_date', None)
    end_date        = get_param(request, 'end_date', None)

    tranObjs = Page.objects.all()
    if page_category:
        tranObjs = Page.objects.filter(page_category = page_category)
    if page_state:
        tranObjs = tranObjs.filter(page_state = page_state)
    if page_district:
        tranObjs = tranObjs.filter(page_district = page_district)
    if page_management:
        tranObjs = tranObjs.filter(page_management = page_management)
    if page_poc:
        tranObjs = tranObjs.filter(page_poc = page_poc)

    likes = {}
    new_likes = {}
    removes = {}
    engaged_users = {}
    impressions = {}
    negative_actions = {}
    # organic_reach = {}
    paid_unpaid_likes = {}
    total_reach = {}

    if start_date==end_date==None:
        paid_unpaid_likes['page_likes_organic'] = 0
        paid_unpaid_likes['page_likes_paid'] = 0
        for trans in tranObjs:
            yesterday  = date.today()-timedelta(1)

            if trans.page_impressions_day:
                page_impressions_day = sorted(trans.page_impressions_day, key=itemgetter('end_time'))
                for data in page_impressions_day[::-1]:
                    dt3 = datetime.strptime(data['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        if data['end_time'].split('T')[0] in impressions.keys():
                            impressions[data['end_time'].split('T')[0]] += int(data['value'])
                        else:
                            impressions[data['end_time'].split('T')[0]] = int(data['value'])

            if trans.page_fans:
                page_fans = sorted(trans.page_fans, key=itemgetter('end_time'))
                for fans in page_fans[::-1]:
                    dt3 = datetime.strptime(fans['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        if fans['end_time'].split('T')[0] in likes.keys():
                            likes[fans['end_time'].split('T')[0]] += int(fans['value'])
                        else:
                            likes[fans['end_time'].split('T')[0]] = int(fans['value'])

            if trans.page_fan_adds:
                page_fan_adds = sorted(trans.page_fan_adds, key=itemgetter('end_time'))
                for fan_adds in page_fan_adds[::-1]:
                    dt3 = datetime.strptime(fan_adds['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        if fan_adds['end_time'].split('T')[0] in new_likes.keys():
                            new_likes[fan_adds['end_time'].split('T')[0]] += int(fan_adds['value'])
                        else:
                            new_likes[fan_adds['end_time'].split('T')[0]] = int(fan_adds['value'])

            if trans.page_fan_removes:
                dislikes = sorted(trans.page_fan_removes, key=itemgetter('end_time'))
                for dislike in dislikes[::-1]:
                    dt3 = datetime.strptime(dislike['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        timestamp = dislike['end_time'].split('T')[0]
                        if timestamp in removes.keys():
                            removes[timestamp]+=dislike['value']
                        else:
                            removes[timestamp] = dislike['value']

            if trans.page_engaged_users_day:
                page_engaged_users_day = sorted(trans.page_engaged_users_day, key=itemgetter('end_time'))
                for user in page_engaged_users_day[::-1]:
                    dt3 = datetime.strptime(user['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        if user['end_time'].split('T')[0] in engaged_users.keys():
                            engaged_users[user['end_time'].split('T')[0]] += int(user['value'])
                        else:
                            engaged_users[user['end_time'].split('T')[0]] = int(user['value'])

            if trans.page_negative_feedback_day:
                page_negative_feedback_day = sorted(trans.page_negative_feedback_day, key=itemgetter('end_time'))
                for negative_feedback in page_negative_feedback_day[::-1]:
                    dt3 = datetime.strptime(negative_feedback['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        if negative_feedback['end_time'].split('T')[0] in negative_actions.keys():
                            negative_actions[negative_feedback['end_time'].split('T')[0]] += int(negative_feedback['value'])
                        else:
                            negative_actions[negative_feedback['end_time'].split('T')[0]] = int(negative_feedback['value'])

            if trans.page_fan_adds_by_paid_non_paid_unique:
                page_fan_adds_by_paid_non_paid_unique = sorted(trans.page_fan_adds_by_paid_non_paid_unique, key=itemgetter('end_time'))
                for reach in page_fan_adds_by_paid_non_paid_unique[::-1]:
                    dt3 = datetime.strptime(reach['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if yesterday==dt3:
                        # <---------- Organic Likes-------------->
                        paid_unpaid_likes['page_likes_organic']+=reach['value']['unpaid']
                        # <------------ Paid Likes--------------->
                        paid_unpaid_likes['page_likes_paid']+=reach['value']['paid']


            max_reach = trans.page_impressions_unique_day
            if max_reach:
                max_reach = sorted(max_reach, key=itemgetter('end_time'))
                for reach in max_reach:
                    dt3 = datetime.strptime(reach['end_time'].split('T')[0], '%Y-%m-%d').date()
                    if (yesterday-dt3).days<=6:
                        timestamp = reach['end_time'].split('T')[0]
                        if timestamp in total_reach.keys():
                            total_reach[timestamp]+=reach['value']
                        else:
                            total_reach[timestamp] = reach['value']

        obj['results'].append({'page_fans':OrderedDict(sorted(likes.items(), key=lambda t: t[0]))})
        obj['results'].append({'page_fan_adds':OrderedDict(sorted(new_likes.items(), key=lambda t: t[0]))})
        obj['results'].append({'page_fan_removes':OrderedDict(sorted(removes.items(), key=lambda t: t[0]))})
        obj['results'].append({'page_impressions':OrderedDict(sorted(impressions.items(), key=lambda t: t[0]))})
        obj['results'].append({'page_engaged_users':OrderedDict(sorted(engaged_users.items(), key=lambda t: t[0]))})
        obj['results'].append({'page_negative_feedback':OrderedDict(sorted(negative_actions.items(), key=lambda t: t[0]))})
        obj['results'].append(paid_unpaid_likes)
        # obj['results'].append(paid_reach)
        obj['results'].append({'page_total_reach':OrderedDict(sorted(total_reach.items(), key=lambda t: t[0]))})
        obj['status'] = True
        obj['msg'] = "Success"

    elif start_date and end_date:
        dt1 = datetime.strptime(start_date, '%Y-%m-%d')
        dt2 = datetime.strptime(end_date, '%Y-%m-%d')
        if dt1==dt2:
            obj['status'] = False
            obj['msg'] = "Please Select a Date Range"
        elif dt2>dt1:
            paid_unpaid_likes['page_likes_organic'] = 0
            paid_unpaid_likes['page_likes_paid'] = 0
            for trans in tranObjs:
                if trans.page_impressions_day:
                    page_impressions_day = sorted(trans.page_impressions_day, key=itemgetter('end_time'))
                    for data in page_impressions_day[::-1]:
                        dt3 = datetime.strptime(data['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                if data['end_time'].split('T')[0] in impressions.keys():
                                    impressions[data['end_time'].split('T')[0]] += int(data['value'])
                                else:
                                    impressions[data['end_time'].split('T')[0]] = int(data['value'])
                                break
                            else:
                                if data['end_time'].split('T')[0] in impressions.keys():
                                    impressions[data['end_time'].split('T')[0]] += int(data['value'])
                                else:
                                    impressions[data['end_time'].split('T')[0]] = int(data['value'])

                if trans.page_fans:
                    page_fans = sorted(trans.page_fans, key=itemgetter('end_time'))
                    for fans in page_fans[::-1]:
                        dt3 = datetime.strptime(fans['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                if fans['end_time'].split('T')[0] in likes.keys():
                                    likes[fans['end_time'].split('T')[0]] += int(fans['value'])
                                else:
                                    likes[fans['end_time'].split('T')[0]] = int(fans['value'])
                                break
                            else:
                                if fans['end_time'].split('T')[0] in likes.keys():
                                    likes[fans['end_time'].split('T')[0]] += int(fans['value'])
                                else:
                                    likes[fans['end_time'].split('T')[0]] = int(fans['value'])

                if trans.page_fan_adds:
                    page_fan_adds = sorted(trans.page_fan_adds, key=itemgetter('end_time'))
                    for fan_adds in page_fan_adds[::-1]:
                        dt3 = datetime.strptime(fan_adds['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                if fan_adds['end_time'].split('T')[0] in new_likes.keys():
                                    new_likes[fan_adds['end_time'].split('T')[0]] += int(fan_adds['value'])
                                else:
                                    new_likes[fan_adds['end_time'].split('T')[0]] = int(fan_adds['value'])
                                break
                            else:
                                if fan_adds['end_time'].split('T')[0] in new_likes.keys():
                                    new_likes[fan_adds['end_time'].split('T')[0]] += int(fan_adds['value'])
                                else:
                                    new_likes[fan_adds['end_time'].split('T')[0]] = int(fan_adds['value'])

                if trans.page_fan_removes:
                    dislikes = sorted(trans.page_fan_removes, key=itemgetter('end_time'))
                    for dislike in dislikes[::-1]:
                        dt3 = datetime.strptime(dislike['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                timestamp = dislike['end_time'].split('T')[0]
                                if timestamp in removes.keys():
                                    removes[timestamp]+=dislike['value']
                                else:
                                    removes[timestamp] = dislike['value']
                                break
                            else:
                                timestamp = dislike['end_time'].split('T')[0]
                                if timestamp in removes.keys():
                                    removes[timestamp]+=dislike['value']
                                else:
                                    removes[timestamp] = dislike['value']

                if trans.page_engaged_users_day:
                    page_engaged_users_day = sorted(trans.page_engaged_users_day, key=itemgetter('end_time'))
                    for user in page_engaged_users_day[::-1]:
                        dt3 = datetime.strptime(user['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                if user['end_time'].split('T')[0] in engaged_users.keys():
                                    engaged_users[user['end_time'].split('T')[0]] += int(user['value'])
                                else:
                                    engaged_users[user['end_time'].split('T')[0]] = int(user['value'])
                                break
                            else:
                                if user['end_time'].split('T')[0] in engaged_users.keys():
                                    engaged_users[user['end_time'].split('T')[0]] += int(user['value'])
                                else:
                                    engaged_users[user['end_time'].split('T')[0]] = int(user['value'])

                if trans.page_negative_feedback_day:
                    page_negative_feedback_day = sorted(trans.page_negative_feedback_day, key=itemgetter('end_time'))
                    for negative_feedback in page_negative_feedback_day[::-1]:
                        dt3 = datetime.strptime(negative_feedback['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                if negative_feedback['end_time'].split('T')[0] in negative_actions.keys():
                                    negative_actions[negative_feedback['end_time'].split('T')[0]] += int(negative_feedback['value'])
                                else:
                                    negative_actions[negative_feedback['end_time'].split('T')[0]] = int(negative_feedback['value'])
                                break
                            else:
                                if negative_feedback['end_time'].split('T')[0] in negative_actions.keys():
                                    negative_actions[negative_feedback['end_time'].split('T')[0]] += int(negative_feedback['value'])
                                else:
                                    negative_actions[negative_feedback['end_time'].split('T')[0]] = int(negative_feedback['value'])

                if trans.page_fan_adds_by_paid_non_paid_unique:
                    page_fan_adds_by_paid_non_paid_unique = sorted(trans.page_fan_adds_by_paid_non_paid_unique, key=itemgetter('end_time'))
                    for reach in page_fan_adds_by_paid_non_paid_unique[::-1]:
                        dt3 = datetime.strptime(reach['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                paid_unpaid_likes["page_likes_organic"]+=reach['value']['unpaid']
                                paid_unpaid_likes['page_likes_paid']+=reach['value']['paid']
                                break
                            else:
                                paid_unpaid_likes['page_likes_organic']+=reach['value']['unpaid']
                                paid_unpaid_likes['page_likes_paid']+=reach['value']['paid']


                max_reach = trans.page_impressions_unique_day
                if max_reach:
                    max_reach = sorted(max_reach, key=itemgetter('end_time'))
                    for reach in max_reach:
                        dt3 = datetime.strptime(reach['end_time'].split('T')[0], '%Y-%m-%d')
                        if dt3>=dt1 and dt3<=dt2:
                            if dt3==dt1:
                                timestamp = reach['end_time'].split('T')[0]
                                if timestamp in total_reach.keys():
                                    total_reach[timestamp]+=reach['value']
                                else:
                                    total_reach[timestamp] = reach['value']
                                break
                            else:
                                timestamp = reach['end_time'].split('T')[0]
                                if timestamp in total_reach.keys():
                                    total_reach[timestamp]+=reach['value']
                                else:
                                    total_reach[timestamp] = reach['value']

            obj['results'].append({'page_fans':OrderedDict(sorted(likes.items(), key=lambda t: t[0]))})
            obj['results'].append({'page_fan_adds':OrderedDict(sorted(new_likes.items(), key=lambda t: t[0]))})
            obj['results'].append({'page_fan_removes':OrderedDict(sorted(removes.items(), key=lambda t: t[0]))})
            obj['results'].append({'page_impressions':OrderedDict(sorted(impressions.items(), key=lambda t: t[0]))})
            obj['results'].append({'page_engaged_users':OrderedDict(sorted(engaged_users.items(), key=lambda t: t[0]))})
            obj['results'].append({'page_negative_feedback':OrderedDict(sorted(negative_actions.items(), key=lambda t: t[0]))})
            obj['results'].append(paid_unpaid_likes)
            # obj['results'].append(paid_reach)
            obj['results'].append({'page_total_reach':OrderedDict(sorted(total_reach.items(), key=lambda t: t[0]))})
            obj['status'] = True
            obj['msg'] = "Success"
        else:
            obj['status'] = False
            obj['msg'] = "Please Select End Date Higher than Start Date"
    else:
        if start_date:
            obj['msg'] = "Please Select End Date"
            obj['status'] = False
        else:
            obj['msg'] = "Please Select Start Date"
            obj['status'] = False

    obj['counter'] = len(obj['results'])
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <------------------------------facebook demographic breakdown------------------->
def facebook_demographic_breakdown(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_category = get_param(request, 'page_category', None)


    tranObjs = Page.objects.all()
    if page_category:
        tranObjs = Page.objects.filter(page_category = page_category)


    male_count = 0
    female_count = 0
    undefined_count = 0
    sum_age = {}
    sum_gender = {}
    for trans in tranObjs:
        if len(trans.page_fans_gender_age):
            if 'value' in trans.page_fans_gender_age[-1].keys():
                for key,values in trans.page_fans_gender_age[-1]['value']['Male'].items():
                    male_count += values

                for key,values in trans.page_fans_gender_age[-1]['value']['Female'].items():
                    female_count += values

                for key,values in trans.page_fans_gender_age[-1]['value']['Undefined'].items():
                    undefined_count += values

                for key,values in trans.page_fans_gender_age[-1][u'value'].items():
                    for k,v in trans.page_fans_gender_age[-1][u'value'][key].items():
                        if k in sum_age.keys():
                            sum_age[k]+=v
                        else:
                            sum_age[k] = v
    sum_gender['Male']=male_count
    sum_gender['Female'] = female_count
    sum_gender['Others'] = undefined_count

    obj['results'].append(OrderedDict(sorted(sum_age.items(), key=lambda t: t[0])))
    obj['results'].append(sum_gender)
    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')

# <-------------------------------facebook pages exposure--------------------------------->
def facebook_pages_exposure(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_category = get_param(request, 'page_category', None)

    tranObjs = Page.objects.all()
    if page_category:
        tranObjs = Page.objects.filter(page_category = page_category)


    reach = {}
    total_likes = 0
    new_likes = 0
    total_impressions = 0
    for trans in tranObjs:
        if len(trans.page_fans):
            if 'value' in trans.page_fans[-1].keys():
                total_likes +=  trans.page_fans[-1]['value']

        if len(trans.page_fan_adds):
            if 'value' in trans.page_fan_adds[-1].keys():
                new_likes +=  trans.page_fan_adds[-1]['value']

        if len(trans.page_impressions_day):
            if 'value' in trans.page_impressions_day[-1].keys():
                total_impressions+= trans.page_impressions_day[-1]['value']
    reach['total_likes'] = total_likes
    reach['new_likes'] = new_likes
    reach['total_impressions'] = total_impressions
    for key,values in reach.items():
        obj['results'].append({key:values})

    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')
# <----------------------------------- Multiple State Selector--------------------------------->
def multiple_state_selector(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []
    states = str(get_param(request, 'pages', None))
    for state in states.split(','):
        # tranObjs = Page.objects.all()
        if state:
            tranObjs = Page.objects.filter(page_state = state)
        if tranObjs!=None:
            for trans in tranObjs:
                page_data = {}
                page_data['page_id'] = trans.page_id
                page_data['page_name'] = trans.page_name
                page_data['page_category'] = trans.page_category
                page_data['page_state']   = trans.page_state
                page_data['page_district'] = trans.page_district

                if len(trans.page_fans):
                    page_data['page_fans'] = trans.page_fans[-1]['value']
                else:
                    page_data['page_fans'] = 0

                if len(trans.page_fan_adds):
                    page_data['page_fan_adds'] = trans.page_fan_adds[-1]['value']
                else:
                    page_data['page_fan_adds'] = 0

                if len(trans.page_impressions_day):
                    page_data['page_impressions_day'] = trans.page_impressions_day[-1]['value']
                else:
                    page_data['page_impressions_day'] = 0

                if len(trans.page_views_total_day):
                    page_data['page_views_total_day'] = trans.page_views_total_day[-1]['value']
                else:
                    page_data['page_views_total_day'] = 0

                if len(trans.page_negative_feedback_day):
                    page_data['page_negative_feedback_day'] = trans.page_negative_feedback_day[-1]['value']
                else:
                    page_data['page_negative_feedback_day'] = 0

                obj['results'].append(page_data)

    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')


# <-------------------------------facebook posts scheduling ----------------------------------->

def fb_img_upload_unpublished(url, token, caption="", published="false"):
    data = {
    'url': url,
    'caption': caption,
    'published': published,
    'access_token': token
    }
    response = requests.post('https://graph.facebook.com/v2.11/me/photos', data=data).json()
    return response

@csrf_exempt
def upload_file(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []
    filetype = get_param(request, 'filetype', None)
    if filetype:
        if filetype=='image':
            if request.method == "POST" and 'file' in request.FILES.keys():
                obj['status'] = True
                for afile in request.FILES.getlist('file'):
                    filename = str(uuid.uuid4())+".jpg"
                    with open(LOCATION+filename, 'wb+') as destination:
                        for chunk in afile.chunks():
                            destination.write(chunk)
                    obj['results'].append(dict(url=ADDRESS+filename))
                obj['counter'] = len(obj['results'])
                obj['msg'] = "Success"
                return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')
        elif filetype=='video':
            if request.method == "POST" and 'file' in request.FILES.keys():
                obj['status'] = True
                afile = request.FILES['file']
                filename = str(uuid.uuid4())+".mp4"
                # if (file.split(".")[1] == "mp4"):
                #     filename = str(uuid.uuid4())+".mp4"
                # if (file.split(".")[1] == "mkv"):
                #     filename = str(uuid.uuid4())+".mkv"
                # if (file.split(".")[1] == "flv"):
                #     filename = str(uuid.uuid4())+".flv"
                # if (file.split(".")[1] == "avi"):
                #     filename = str(uuid.uuid4())+".avi"
                # if (file.split(".")[1] == "mov"):
                #     filename = str(uuid.uuid4())+".mov"
                # if (file.split(".")[1] == "webm"):
                #     filename = str(uuid.uuid4())+".webm"

                with open(LOCATION+filename, 'wb+') as destination:
                    for chunk in afile.chunks():
                        destination.write(chunk)
                    obj['results'].append(dict(url=ADDRESS+filename))
                obj['counter'] = len(obj['results'])
                obj['msg'] = "Success"
                return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')
    else:
        return HttpResponseBadRequest("Bad Request")

@csrf_exempt
def upload_video_file(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []
    # filetype = get_param(request, 'filetype', None)
    if request.method == "POST" and 'video' in request.FILES.keys():
        obj['status'] = True
        file = request.FILES['video']
        filename = str(uuid.uuid4())+".mp4"
        # if (file.split(".")[1] == "mp4"):
        #     filename = str(uuid.uuid4())+".mp4"
        # if (file.split(".")[1] == "mkv"):
        #     filename = str(uuid.uuid4())+".mkv"
        # if (file.split(".")[1] == "flv"):
        #     filename = str(uuid.uuid4())+".flv"
        # if (file.split(".")[1] == "avi"):
        #     filename = str(uuid.uuid4())+".avi"
        # if (file.split(".")[1] == "mov"):
        #     filename = str(uuid.uuid4())+".mov"
        # if (file.split(".")[1] == "webm"):
        #     filename = str(uuid.uuid4())+".webm"

        with open(LOCATION+filename, 'wb+') as destination:
            for chunk in file.chunks():
                destination.write(chunk)
            obj['results'].append(dict(url=ADDRESS+filename))
        obj['counter'] = len(obj['results'])
        obj['msg'] = "Success"
        return HttpResponse(json.dumps(obj,default=json_util.default), content_type='application/json')
    else:
        return HttpResponseBadRequest("Bad Request")


# schedules a given post for a single page
def facebook_post_scheduling(request):
    if request.method == "GET":
        return Http404
    else:

        # get params
        page_ids = request.POST.get('page_ids')
        message = request.POST.get('message')
        timestamp = request.POST.get('timestamp')
        link = request.POST.get('link')
        images = request.POST.get('images')
        video = request.POST.get('video')
        post_type = request.POST.get('post_type')

        # convert to unix_timestamp from dd-mm-yy-hh-mm-ss
        unix_timestamp = mktime(datetime.strptime(timestamp, "%d-%m-%y-%H-%M-%S").timetuple()) # +timedelta(hours=5,minutes=30)

        # create a scheduledJob instance
        job = scheduledJob.objects.create(job_id=str(uuid.uuid4()),job_scheduled_time=datetime.fromtimestamp(unix_timestamp),job_type=post_type,job_scheduled_page_ids=page_ids.split(","),job_status="Pending")
        job_id = job.job_id
        # GENERIC KEYS
        data = {
            'published': "false",
            'scheduled_publish_time': int(unix_timestamp),
        }
        print(unix_timestamp)
        # TEXT POSTS
        if post_type == 'text':
            data.update({
                'message': message
            })
        # LINK POSTS
        if post_type == 'link':
            data.update({
                'link': link,
            })
            # message is optional
            if message:
                data.update({
                    'message': message
                })
        # IMAGE POSTS
        if post_type == 'image':
            counter = 0
            pic_ids = []
            # single photo
            if len(images.split(",")) == 1:
                data['url'] = images
                if message:
                    data["caption"] = message
                else:
                    data["caption"] = ""
                # send publish request for each listed page
                for listed_page in page_ids.split(","):
                    access_token = Page.objects.get(page_id=listed_page).page_access_token
                    data.update({
                        "access_token": access_token
                    })
                    # SEND PUBLISH REQUEST TO FB API
                    response = requests.post('https://graph.facebook.com/v2.11/me/photos', data=data).json()
                    job_new = scheduledJob.objects.filter(job_id=job_id)[0]
                    if "id" not in response.keys():
                        job_new.job_failed_id = listed_page
                        job_new.job_status = "Failed"
                        job_new.save()
                        return HttpResponse(json.dumps(response))
                    else:
                        job_new.job_scheduled_page_ids.remove(listed_page)
                        job_new.job_finished_page_ids.append({
                            'page_id': listed_page,
                            'post_id': response['id']
                        })
                        job_new.save()
                del (data['access_token'])
                job_new.job_meta = data
                job_new.job_status = "Scheduled"
                job_new.save()
                return HttpResponse(job_new.job_id + " OK")
            # multi photo
            else:
                if message:
                    data["message"] = message
                else:
                    data["message"] = ""
                # for each page, first upload images, then publish
                for listed_page in page_ids.split(","):
                    access_token = Page.objects.get(page_id=listed_page).page_access_token
                    data.update({
                        "access_token": access_token
                    })
                    # add unpublished images and attach their media_fbid to data
                    for img_link in images.split(","):
                        # add images to fb album without publishing
                        pic_id = fb_img_upload_unpublished(img_link, access_token)
                        # fail if any of the images is not uploaded
                        job_new = scheduledJob.objects.filter(job_id=job_id)[0]
                        if 'id' not in pic_id.keys():
                            job_new.job_failed_id = listed_page
                            job_new.job_status = "Failed"
                            job_new.save()
                            return HttpResponse(json.dumps(pic_id), content_type='application/json')
                        else:
                            data['attached_media[' + str(counter) + ']'] = '{"media_fbid": "' + pic_id['id'] + '"}'
                        counter += 1
                    ntime.sleep(1)
                    # SEND PUBLISH REQUEST TO FB API
                    response = requests.post('https://graph.facebook.com/v2.11/me/feed', data=data).json()
                    job_new = scheduledJob.objects.filter(job_id=job_id)[0]
                    if "id" not in response.keys():
                        job_new.job_failed_id = listed_page
                        job_new.job_status = "Failed"
                        job_new.save()
                        return HttpResponse(json.dumps(data), content_type="application/json")
                        # return HttpResponse(job.job_id+" Failed")
                    else:
                        job_new.job_scheduled_page_ids.remove(listed_page)
                        job_new.job_finished_page_ids.append({
                            'page_id': listed_page,
                            'post_id': response['id']
                        })
                        job_new.save()
                del (data['access_token'])
                job_new.job_meta = data
                job_new.job_status = "Scheduled"
                job_new.save()
                return HttpResponse(job_new.job_id + " OK")

        # VIDEO POSTS
        if post_type == 'video':
            if message:
                data["description"] = message
            else:
                data["description"] = ""
            data['file_url'] = video

            for listed_page in page_ids.split(","):
                access_token = Page.objects.get(page_id=listed_page).page_access_token
                data.update({
                    'access_token': access_token,
                    'scheduled_publish_time': int(unix_timestamp),
                })
                ntime.sleep(1)
                response = requests.post('https://graph-video.facebook.com/v2.11/me/videos', data).json()
                job_new = scheduledJob.objects.filter(job_id=job_id)[0]
                if "id" not in response.keys():
                    job_new.job_failed_id = listed_page
                    job_new.job_status = "Failed"
                    job_new.save()
                    return HttpResponse(json.dumps(response), content_type='application/json')
                else:
                    job_new.job_scheduled_page_ids.remove(listed_page)
                    job_new.job_finished_page_ids.append({
                        'page_id': listed_page,
                        'post_id': response['id']
                    })
                    job_new.save()
            del (data['access_token'])
            job_new.job_meta = data
            job_new.job_status = "Scheduled"
            job_new.save()
            return HttpResponse(job_new.job_id + " OK")

        # send requests for each listed page
        for listed_page in page_ids.split(","):
            access_token = Page.objects.get(page_id=listed_page).page_access_token
            data.update({
                "access_token": access_token
            })

            ntime.sleep(1)
            # SEND PUBLISH REQUEST TO FB API
            response = requests.post('https://graph.facebook.com/v2.11/me/feed', data=data).json()
            job_new = scheduledJob.objects.filter(job_id=job_id)[0]
            if "id" not in response.keys():
                job_new.job_failed_id = listed_page
                job_new.job_status = "Failed"
                job_new.save()
                return HttpResponse(json.dumps(response), content_type="application/json")
                # return HttpResponse(job.job_id+" Failed")
            else:
                job_new.job_scheduled_page_ids.remove(listed_page)
                job_new.job_finished_page_ids.append({
                    'page_id': listed_page,
                    'post_id': response['id']
                })
                job_new.save()
        del (data['access_token'])
        job_new.job_meta = data
        job_new.job_status = "Scheduled"
        job_new.save()
        return HttpResponse(job_new.job_id + " OK")

def jobs(request):
    method = request.method
    job_status = request.GET.get('job_status')
    job_type = request.GET.get('job_type')
    start_date = request.GET.get('start_date')
    end_date = request.GET.get('end_date')
    job_id = request.GET.get('job_id')
    qs = scheduledJob.objects.all()
    if method == "GET":
        if job_status:
            qs = qs.filter(job_status=job_status)
        if job_type:
            qs = qs.filter(job_type=job_type)
        if start_date and end_date:
            qs = qs.filter(job_scheduled_time__range=(start_date, end_date))
        data = serializers.serialize("json", qs)
        return HttpResponse(data, content_type='application/json')
    elif method == "DELETE" and len(scheduledJob.objects.filter(job_id=job_id)) > 0:
        scheduledJob.objects.get(job_id=job_id).delete_job()
        return HttpResponse(job_id + " DELETED")

def job_linked_pages(request):
    if request.method == "GET" and request.GET.get('page_ids') is not None:
        qs = Page.objects.filter(page_id__in=request.GET.get('page_ids').split(","))
        return HttpResponse(serializers.serialize("json", qs), content_type='application/json')

def scheduled_pages(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []
    job_id = get_param(request, 'job_id', None)
    pages = None
    json_jobs = []
    if job_id:
        # job = scheduledJob.objects.filter(job_id=job_id)[0]
        # page_id_list = job.job_scheduled_page_ids
        jobs = serializers.serialize('json', scheduledJob.objects.filter(job_id=job_id),
                                     fields=('job_scheduled_page_ids', 'job_finished_page_ids', 'job_status'))
        json_jobs = json.loads(jobs)
    if len(json_jobs):
        jobs_json = json_jobs[0]
        if jobs_json['fields']['job_status'] == "Scheduled":
            pages = jobs_json['fields']['job_finished_page_ids']
            if len(pages):
                for page in pages:
                    page_names = Page.objects.filter(page_id=page['page_id'])
                    page_name = page_names[0].page_name
                    obj['results'].append(page_name)
        elif jobs_json['fields']['job_status'] == "Failed":
            pages = jobs_json['fields']['job_scheduled_page_ids']
            if len(pages):
                for page in pages:
                    page_names = Page.objects.filter(page_id=page)
                    page_name = page_names[0].page_name
                    obj['results'].append(page_name)
        else:
            pages = jobs_json['fields']['job_scheduled_page_ids']
            if len(pages):
                for page in pages:
                    page_names = Page.objects.filter(page_id=page)
                    page_name = page_names[0].page_name
                    obj['results'].append(page_name)

        obj['status'] = True
        obj['counter'] = len(obj['results'])
        obj['msg'] = "Success"
        return HttpResponse(json.dumps(obj), content_type='application/json')
    else:
        return HttpResponse("Job Does Not Exist")

# <--------------------------------------fetch all posts of a page------------------------------------>
def fetch_facebook_page_posts(request):
    obj = {}
    obj['status'] = Falsecd
    obj['results'] = []
    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    page = get_param(request, 'page_id', None)
    tranObjs = Post.objects.all()
    if page:
        tranObjs = tranObjs.filter(page_id=page)
    for trans in tranObjs:
        obj['results'].append({
            'page_id': trans.page_id,
            'page_object_id': trans.page_object_id,
            'post_id': trans.post_id,
            'post_message': trans.post_message,
            'post_created_time': trans.post_created_time,
            'post_impressions': trans.post_impressions,
            'post_impressions_unique': trans.post_impressions_unique,
            'post_impressions_fan': trans.post_impressions_fan,
            'post_impressions_fan_unique': trans.post_impressions_fan_unique,
            'post_impressions_organic': trans.post_impressions_organic,
            'post_impressions_organic_unique': trans.post_impressions_organic_unique,
            'post_impressions_viral': trans.post_impressions_viral,
            'post_impressions_viral_unique': trans.post_impressions_viral_unique,
            'post_impressions_nonviral': trans.post_impressions_nonviral,
            'post_impressions_nonviral_unique': trans.post_impressions_nonviral_unique,
            'post_impressions_by_story_type': trans.post_impressions_by_story_type,
            'post_impressions_by_story_type_unique': trans.post_impressions_by_story_type_unique,
            'post_reactions_like_total': trans.post_reactions_like_total,
            'post_reactions_love_total': trans.post_reactions_love_total,
            'post_reactions_wow_total': trans.post_reactions_wow_total,
            'post_reactions_haha_total': trans.post_reactions_haha_total,
            'post_reactions_sorry_total': trans.post_reactions_sorry_total,
            'post_reactions_anger_total': trans.post_reactions_anger_total,
            'post_reactions_by_type_total': trans.post_reactions_by_type_total,
            'post_clicks': trans.post_clicks,
            'post_clicks_unique': trans.post_clicks_unique,
            'post_engaged_users': trans.post_engaged_users,
            'post_engaged_fan': trans.post_engaged_fan,
        })
    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj, default=json_util.default), content_type='application/json')

# <--------------------facebook Post Method------------------------------------>
def facebook_page_update(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page = get_param(request, 'page_id', None)
    page_state = get_param(request, 'page_state', None)
    page_district = get_param(request, 'page_district', None)
    page_category = get_param(request, 'page_category', None)
    page_management = get_param(request, 'page_management', None)
    page_poc = get_param(request, 'page_poc', None)

    tranObjs = Page.objects.filter(page_id=page)
    if tranObjs:
        tranObjs.update(page_state=page_state, page_district=page_district, page_category=page_category,
                        page_management=page_management, page_poc=page_poc)
    for trans in tranObjs:
        obj['results'].append({
            'page_state': trans.page_state,
            'page_district': trans.page_district,
            'page_category': trans.page_category,
            'page_id': trans.page_id

        })
    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj, default=json_util.default), content_type='application/json')

# <-----------------------------Adding New Page ---------------------------------->
def facebook_new_page(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_id = get_param(request, 'page_id', None)
    page_name = get_param(request, 'page_name', None)
    page_state = get_param(request, 'page_state', None)
    page_district = get_param(request, 'page_district', None)
    page_category = get_param(request, 'page_category', None)
    page_access_token = get_param(request, 'page_access_token', None)
    # linked_user = get_param(request,'linked_user',None )

    page = Page()
    page.page_id = str(page_id)
    page.page_state = str(page_state)
    page.page_district = str(page_district)
    page.page_category = str(page_category)
    page.page_access_token = str(page_access_token)
    # if linked_user!=None:
    #     page.linked_user = linked_user
    # else:
    #     page.linked_user = {}
    page.save()

    pagedata = Page.objects.filter(page_id=page_id)
    for page in pagedata:
        obj['results'].append({
            'page_state': page.page_state,
            'page_district': page.page_district,
            'page_category': page.page_category,
            'page_id': page.page_id

        })

    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj, default=json_util.default), content_type='application/json')

# <---------------------------------facebook post performance---------------------->
def facebook_post_performance(request):
    obj = {}
    obj['status'] = False
    obj['results'] = []

    page_num = get_param(request, 'page_num', None)
    page_size = get_param(request, 'page_size', None)

    tranObjs = Post.objects.all()
    # tranObjs = Post.objects.filter(post_created_time = yesterday)

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
            obj['results'].append({
                'page_id': trans.page_id,
                'post_id': trans.post_id,
                'page_name': trans.page_name,
                'post_link': trans.post_link,
                'post_impressions': trans.post_impressions[-1]['value'],
                'post_likes': trans.post_reactions_like_total[-1]['value'],
                'post_created_time': trans.post_created_time,
            })
    obj['status'] = True
    obj['counter'] = len(obj['results'])
    obj['msg'] = "Success"
    obj['num_pages'] = num_pages
    obj['total_records'] = total_records
    return HttpResponse(json.dumps(obj, default=json_util.default), content_type='application/json')

# <----------------------------fetch page_fans_city------------------------------->
def fetch_facebook_page_fans_city(request):
    obj = {}
    obj['status'] = False
    obj['results'] = {}
    obj['results']['pages'] = []
    obj['results']['cities'] = []
    cities_aggregate_count = {}

    tranObjs = Page.objects.all()

    for trans in tranObjs:
        city_wise_likes = None

        if len(trans.page_fans_city):
            for n in range(len(trans.page_fans_city) - 1, -1, -1):
                if 'value' in trans.page_fans_city[n].keys():
                    city_wise_likes = trans.page_fans_city[n]['value']
                    break

        obj['results']['pages'].append({
            'page_id': trans.page_id,
            'page_name': trans.page_name,
            'page_fans_city': city_wise_likes,
        })

    for city_data in obj['results']['pages']:
        for key, value in city_data['page_fans_city'].items():
            if city_data['page_fans_city'] != None:
                if key in cities_aggregate_count:
                    cities_aggregate_count[key] += city_data['page_fans_city'][key]
                else:
                    cities_aggregate_count[key] = city_data['page_fans_city'][key]

    for key, value in cities_aggregate_count.items():
        obj['results']['cities'].append({key: value})

    obj['status'] = True
    obj['counter'] = len(obj['results']['pages'])
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')

# <--------------------cron job to update page details in mongodb------------------------->

def fetch_facebook_page(access_token, startdate=since_date, enddate=untill_date):
    obj = {}
    obj['status'] = False
    response = requests.get('https://graph.facebook.com/v2.12/me?fields=id,name&access_token=' + access_token)
    output = response.json()

    id = output['id']
    name = output['name']

    fields = ['page_fans',
              'page_fan_adds',
              'page_fan_adds_unique',
              'page_fan_removes',
              'page_fan_removes_unique',
              'page_fans_by_like_source',
              'page_fans_by_unlike_source_unique',
              'page_impressions',
              'page_impressions_unique',
              'page_impressions_organic',
              'page_impressions_organic_unique',
              'page_impressions_viral',
              'page_impressions_viral_unique',
              'page_impressions_nonviral',
              'page_impressions_nonviral_unique',
              'page_impressions_frequency_distribution',
              'page_engaged_users',
              'page_fans_city',
              'page_fans_locale',
              'page_fans_gender_age',
              'page_negative_feedback',
              'page_negative_feedback_unique',
              'page_views_total',
              'page_impressions_paid',
              'page_impressions_paid_unique',
              'page_fan_adds_by_paid_non_paid_unique'
              ]

    response_metric = requests.get(
        'https://graph.facebook.com/v2.12/' + id + '/insights?pretty=0&since=' + startdate + '&until=' + enddate + '&metric=' + '%2C'.join(
            fields) + '&access_token=' + access_token)
    metric_data = response_metric.json()

    data = metric_data['data']
    results = []
    # i = 0
    for timestamp in data:
        data_dict = timestamp['values'][0]
        data_dict[u"name"] = timestamp['name']
        data_dict[u"period"] = timestamp['period']
        # if len(data)==53:
        if data_dict["name"] == "page_fans_gender_age":
            data_dict_new = {}
            data_dict_new['value'] = {}
            data_dict_new['value']['Female'] = {}
            data_dict_new['value']['Male'] = {}
            data_dict_new['value']['Undefined'] = {}
            data_dict_new['name'] = data_dict['name']
            data_dict_new['end_time'] = data_dict['end_time']
            data_dict_new['period'] = data_dict['period']

            if "F.13-17" in data_dict['value'].keys():
                data_dict_new['value']['Female']["13-17"] = data_dict['value']['F.13-17']
            else:
                data_dict_new['value']['Female']["13-17"] = 0

            if 'F.18-24' in data_dict['value'].keys():
                data_dict_new['value']['Female']["18-24"] = data_dict['value']['F.18-24']
            else:
                data_dict_new['value']['Female']["18-24"] = 0

            if 'F.25-34' in data_dict['value'].keys():
                data_dict_new['value']['Female']["25-34"] = data_dict['value']['F.25-34']
            else:
                data_dict_new['value']['Female']["25-34"] = 0

            if 'F.35-44' in data_dict['value'].keys():
                data_dict_new['value']['Female']["35-44"] = data_dict['value']['F.35-44']
            else:
                data_dict_new['value']['Female']["35-44"] = 0

            if 'F.45-54' in data_dict['value'].keys():
                data_dict_new['value']['Female']["45-54"] = data_dict['value']['F.45-54']
            else:
                data_dict_new['value']['Female']["45-54"] = 0

            if 'F.55-64' in data_dict['value'].keys():
                data_dict_new['value']['Female']["55-64"] = data_dict['value']['F.55-64']
            else:
                data_dict_new['value']['Female']["55-64"] = 0

            if 'F.65+' in data_dict['value'].keys():
                data_dict_new['value']['Female']["65+"] = data_dict['value']['F.65+']
            else:
                data_dict_new['value']['Female']["65+"] = 0

            if "M.13-17" in data_dict['value'].keys():
                data_dict_new['value']['Male']["13-17"] = data_dict['value']['M.13-17']
            else:
                data_dict_new['value']['Male']["13-17"] = 0

            if "M.18-24" in data_dict['value'].keys():
                data_dict_new['value']['Male']["18-24"] = data_dict['value']['M.18-24']
            else:
                data_dict_new['value']['Male']["18-24"] = 0

            if "M.25-34" in data_dict['value'].keys():
                data_dict_new['value']['Male']["25-34"] = data_dict['value']['M.25-34']
            else:
                data_dict_new['value']['Male']["25-34"] = 0

            if "M.35-44" in data_dict['value'].keys():
                data_dict_new['value']['Male']["35-44"] = data_dict['value']['M.35-44']
            else:
                data_dict_new['value']['Male']["35-44"] = 0

            if 'M.45-54' in data_dict['value'].keys():
                data_dict_new['value']['Male']["45-54"] = data_dict['value']['M.45-54']
            else:
                data_dict_new['value']['Male']["45-54"] = 0

            if 'M.55-64' in data_dict['value'].keys():
                data_dict_new['value']['Male']["55-64"] = data_dict['value']['M.55-64']
            else:
                data_dict_new['value']['Male']["55-64"] = 0

            if 'M.65+' in data_dict['value'].keys():
                data_dict_new['value']['Male']["65+"] = data_dict['value']['M.65+']
            else:
                data_dict_new['value']['Male']["65+"] = 0

            if "U.13-17" in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["13-17"] = data_dict['value']['U.13-17']
            else:
                data_dict_new['value']['Undefined']["13-17"] = 0

            if "U.18-24" in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["18-24"] = data_dict['value']['U.18-24']
            else:
                data_dict_new['value']['Undefined']["18-24"] = 0

            if "U.25-34" in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["25-34"] = data_dict['value']['U.25-34']
            else:
                data_dict_new['value']['Undefined']["25-34"] = 0

            if "U.35-44" in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["35-44"] = data_dict['value']['U.35-44']
            else:
                data_dict_new['value']['Undefined']["35-44"] = 0

            if 'U.45-54' in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["45-54"] = data_dict['value']['U.45-54']
            else:
                data_dict_new['value']['Undefined']["45-54"] = 0

            if 'U.55-64' in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["55-64"] = data_dict['value']['U.55-64']
            else:
                data_dict_new['value']['Undefined']["55-64"] = 0

            if 'U.65+' in data_dict['value'].keys():
                data_dict_new['value']['Undefined']["65+"] = data_dict['value']['U.65+']
            else:
                data_dict_new['value']['Undefined']["65+"] = 0

            data_dict = data_dict_new

        elif data_dict["name"] == "page_fans_city":
            data_dict_new = {}
            data_dict_new['value'] = {}
            data_dict_new['name'] = data_dict['name']
            data_dict_new['end_time'] = data_dict['end_time']
            data_dict_new['period'] = data_dict['period']
            if data_dict['value'].keys():
                for key, value in data_dict['value'].items():
                    new_key = key.replace(".", "")
                    data_dict_new['value'].update({new_key: value})
            data_dict = data_dict_new
        results.append(data_dict)

    for page_attributes in results:
        print page_attributes['end_time']
        print page_attributes['name']
        findPage = Page.objects.filter(page_id=id)

        if len(findPage):
            findPage = findPage[0]

            if page_attributes['name'] == 'page_fans':
                page_fans = findPage.page_fans
                if page_attributes not in page_fans:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fans):
                    page_fans.append(page_attributes)
                findPage.page_fans = page_fans

                page_fan_adds = findPage.page_fan_adds
            elif page_attributes['name'] == 'page_fan_adds':
                page_fan_adds = findPage.page_fan_adds
                if page_attributes not in page_fan_adds:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_adds):
                    page_fan_adds.append(page_attributes)
                findPage.page_fan_adds = page_fan_adds

            elif page_attributes['name'] == 'page_fan_adds_unique':
                if page_attributes['period'] == 'day':
                    page_fan_adds_unique_day = findPage.page_fan_adds_unique_day
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_adds_unique_day):
                    if page_attributes not in page_fan_adds_unique_day:
                        page_fan_adds_unique_day.append(page_attributes)
                    findPage.page_fan_adds_unique_day = page_fan_adds_unique_day

                elif page_attributes['period'] == 'week':
                    page_fan_adds_unique_week = findPage.page_fan_adds_unique_week
                    if page_attributes not in page_fan_adds_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_adds_unique_week):
                        page_fan_adds_unique_week.append(page_attributes)
                    findPage.page_fan_adds_unique_week = page_fan_adds_unique_week
                else:
                    page_fan_adds_unique_days_28 = findPage.page_fan_adds_unique_days_28
                    if page_attributes not in page_fan_adds_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_adds_unique_days_28):
                        page_fan_adds_unique_days_28.append(page_attributes)
                    findPage.page_fan_adds_unique_days_28 = page_fan_adds_unique_days_28

            elif page_attributes['name'] == 'page_fan_removes':
                page_fan_removes = findPage.page_fan_removes
                if page_attributes not in page_fan_removes:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_removes):
                    page_fan_removes.append(page_attributes)
                findPage.page_fan_removes = page_fan_removes

            elif page_attributes['name'] == 'page_fan_removes_unique':
                if page_attributes['period'] == 'day':
                    page_fan_removes_unique_day = findPage.page_fan_removes_unique_day
                    if page_attributes not in page_fan_removes_unique_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_removes_unique_day):
                        page_fan_removes_unique_day.append(page_attributes)
                    findPage.page_fan_removes_unique_day = page_fan_removes_unique_day

                elif page_attributes['period'] == 'week':
                    page_fan_removes_unique_week = findPage.page_fan_removes_unique_week
                    if page_attributes not in page_fan_removes_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_removes_unique_week):
                        page_fan_removes_unique_week.append(page_attributes)
                    findPage.page_fan_removes_unique_week = page_fan_removes_unique_week
                else:
                    page_fan_removes_unique_days_28 = findPage.page_fan_removes_unique_days_28
                    if page_attributes not in page_fan_removes_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_removes_unique_days_28):
                        page_fan_removes_unique_days_28.append(page_attributes)
                    findPage.page_fan_removes_unique_days_28 = page_fan_removes_unique_days_28

            elif page_attributes['name'] == 'page_fans_by_like_source':
                page_fans_by_like_source = findPage.page_fans_by_like_source
                if page_attributes not in page_fans_by_like_source:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fans_by_like_source):
                    page_fans_by_like_source.append(page_attributes)
                findPage.page_fans_by_like_source = page_fans_by_like_source

            elif page_attributes['name'] == 'page_fans_by_unlike_source_unique':
                page_fans_by_unlike_source_unique = findPage.page_fans_by_unlike_source_unique
                if page_attributes not in page_fans_by_unlike_source_unique:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fans_by_unlike_source_unique):
                    page_fans_by_unlike_source_unique.append(page_attributes)
                findPage.page_fans_by_unlike_source_unique = page_fans_by_unlike_source_unique

            elif page_attributes['name'] == 'page_impressions':
                if page_attributes['period'] == 'day':
                    page_impressions_day = findPage.page_impressions_day
                    if page_attributes not in page_impressions_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_day):
                        page_impressions_day.append(page_attributes)
                    findPage.page_impressions_day = page_impressions_day

                elif page_attributes['period'] == 'week':
                    page_impressions_week = findPage.page_impressions_week
                    if page_attributes not in page_impressions_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_week):
                        page_impressions_week.append(page_attributes)
                    findPage.page_impressions_week = page_impressions_week
                else:
                    page_impressions_days_28 = findPage.page_impressions_days_28
                    if page_attributes not in page_impressions_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_days_28):
                        page_impressions_days_28.append(page_attributes)
                    findPage.page_impressions_days_28 = page_impressions_days_28

            elif page_attributes['name'] == 'page_impressions_unique':
                if page_attributes['period'] == 'day':
                    page_impressions_unique_day = findPage.page_impressions_unique_day
                    if page_attributes not in page_impressions_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_unique_day):
                        page_impressions_unique_day.append(page_attributes)
                    findPage.page_impressions_unique_day = page_impressions_unique_day

                elif page_attributes['period'] == 'week':
                    page_impressions_unique_week = findPage.page_impressions_unique_week
                    if page_attributes not in page_impressions_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_unique_week):
                        page_impressions_unique_week.append(page_attributes)
                    findPage.page_impressions_unique_week = page_impressions_unique_week
                else:
                    page_impressions_unique_days_28 = findPage.page_impressions_unique_days_28
                    if page_attributes not in page_impressions_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_unique_days_28):
                        page_impressions_unique_days_28.append(page_attributes)
                    findPage.page_impressions_unique_days_28 = page_impressions_unique_days_28

            elif page_attributes['name'] == 'page_impressions_organic':
                if page_attributes['period'] == 'day':
                    page_impressions_organic_day = findPage.page_impressions_organic_day
                    if page_attributes not in page_impressions_organic_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_organic_day):
                        page_impressions_organic_day.append(page_attributes)
                    findPage.page_impressions_organic_day = page_impressions_organic_day

                elif page_attributes['period'] == 'week':
                    page_impressions_organic_week = findPage.page_impressions_organic_week
                    if page_attributes not in page_impressions_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_organic_week):
                        page_impressions_organic_week.append(page_attributes)
                    findPage.page_impressions_organic_week = page_impressions_organic_week
                else:
                    page_impressions_organic_days_28 = findPage.page_impressions_organic_days_28
                    if page_attributes not in page_impressions_organic_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_organic_days_28):
                        page_impressions_organic_days_28.append(page_attributes)
                    findPage.page_impressions_organic_days_28 = page_impressions_organic_days_28

            elif page_attributes['name'] == 'page_impressions_organic_unique':
                if page_attributes['period'] == 'day':
                    page_impressions_organic_unique_day = findPage.page_impressions_organic_unique_day
                    if page_attributes not in page_impressions_organic_unique_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_organic_unique_day):
                        page_impressions_organic_unique_day.append(page_attributes)
                    findPage.page_impressions_organic_unique_day = page_impressions_organic_unique_day

                elif page_attributes['period'] == 'week':
                    page_impressions_organic_unique_week = findPage.page_impressions_organic_unique_week
                    if page_attributes not in page_impressions_organic_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_organic_unique_week):
                        page_impressions_organic_unique_week.append(page_attributes)
                    findPage.page_impressions_organic_unique_week = page_impressions_organic_unique_week
                else:
                    page_impressions_organic_unique_days_28 = findPage.page_impressions_organic_unique_days_28
                    if page_attributes not in page_impressions_organic_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_organic_unique_days_28):
                        page_impressions_organic_unique_days_28.append(page_attributes)
                    findPage.page_impressions_organic_unique_days_28 = page_impressions_organic_unique_days_28

            elif page_attributes['name'] == 'page_impressions_viral':
                if page_attributes['period'] == 'day':
                    page_impressions_viral_day = findPage.page_impressions_viral_day
                    if page_attributes not in page_impressions_viral_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_viral_day):
                        page_impressions_viral_day.append(page_attributes)
                    findPage.page_impressions_viral_day = page_impressions_viral_day

                elif page_attributes['period'] == 'week':
                    page_impressions_viral_week = findPage.page_impressions_viral_week
                    if page_attributes not in page_impressions_viral_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_viral_week):
                        page_impressions_viral_week.append(page_attributes)
                    findPage.page_impressions_viral_week = page_impressions_viral_week
                else:
                    page_impressions_viral_days_28 = findPage.page_impressions_viral_days_28
                    if page_attributes not in page_impressions_viral_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_viral_days_28):
                        page_impressions_viral_days_28.append(page_attributes)
                    findPage.page_impressions_viral_days_28 = page_impressions_viral_days_28

            elif page_attributes['name'] == 'page_impressions_viral_unique':
                if page_attributes['period'] == 'day':
                    page_impressions_viral_unique_day = findPage.page_impressions_viral_unique_day
                    if page_attributes not in page_impressions_viral_unique_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_viral_unique_day):
                        page_impressions_viral_unique_day.append(page_attributes)
                    findPage.page_impressions_viral_unique_day = page_impressions_viral_unique_day

                elif page_attributes['period'] == 'week':
                    page_impressions_viral_unique_week = findPage.page_impressions_viral_unique_week
                    if page_attributes not in page_impressions_viral_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_viral_unique_week):
                        page_impressions_viral_unique_week.append(page_attributes)
                    findPage.page_impressions_viral_unique_week = page_impressions_viral_unique_week
                else:
                    page_impressions_viral_unique_days_28 = findPage.page_impressions_viral_unique_days_28
                    if page_attributes not in page_impressions_viral_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_viral_unique_days_28):
                        page_impressions_viral_unique_days_28.append(page_attributes)
                    findPage.page_impressions_viral_unique_days_28 = page_impressions_viral_unique_days_28

            elif page_attributes['name'] == 'page_impressions_nonviral':
                if page_attributes['period'] == 'day':
                    page_impressions_nonviral_day = findPage.page_impressions_nonviral_day
                    if page_attributes not in page_impressions_nonviral_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_nonviral_day):
                        page_impressions_nonviral_day.append(page_attributes)
                    findPage.page_impressions_nonviral_day = page_impressions_nonviral_day

                elif page_attributes['period'] == 'week':
                    page_impressions_nonviral_week = findPage.page_impressions_nonviral_week
                    if page_attributes not in page_impressions_nonviral_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_nonviral_week):
                        page_impressions_nonviral_week.append(page_attributes)
                    findPage.page_impressions_nonviral_week = page_impressions_nonviral_week
                else:
                    page_impressions_nonviral_days_28 = findPage.page_impressions_nonviral_days_28
                    if page_attributes not in page_impressions_nonviral_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_nonviral_days_28):
                        page_impressions_nonviral_days_28.append(page_attributes)
                    findPage.page_impressions_nonviral_days_28 = page_impressions_nonviral_days_28

            elif page_attributes['name'] == 'page_impressions_nonviral_unique':
                if page_attributes['period'] == 'day':
                    page_impressions_nonviral_unique_day = findPage.page_impressions_nonviral_unique_day
                    if page_attributes not in page_impressions_nonviral_unique_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_nonviral_unique_day):
                        page_impressions_nonviral_unique_day.append(page_attributes)
                    findPage.page_impressions_nonviral_unique_day = page_impressions_nonviral_unique_day

                elif page_attributes['period'] == 'week':
                    page_impressions_nonviral_unique_week = findPage.page_impressions_nonviral_unique_week
                    if page_attributes not in page_impressions_nonviral_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_nonviral_unique_week):
                        page_impressions_nonviral_unique_week.append(page_attributes)
                    findPage.page_impressions_nonviral_unique_week = page_impressions_nonviral_unique_week
                else:
                    page_impressions_nonviral_unique_days_28 = findPage.page_impressions_nonviral_unique_days_28
                    if page_attributes not in page_impressions_nonviral_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_nonviral_unique_days_28):
                        page_impressions_nonviral_unique_days_28.append(page_attributes)
                    findPage.page_impressions_nonviral_unique_days_28 = page_impressions_nonviral_unique_days_28

            elif page_attributes['name'] == 'page_impressions_frequency_distribution':
                if page_attributes['period'] == 'day':
                    page_impressions_frequency_distribution_day = findPage.page_impressions_frequency_distribution_day
                    if page_attributes not in page_impressions_frequency_distribution_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_frequency_distribution_day):
                        page_impressions_frequency_distribution_day.append(page_attributes)
                    findPage.page_impressions_frequency_distribution_day = page_impressions_frequency_distribution_day

                elif page_attributes['period'] == 'week':
                    page_impressions_frequency_distribution_week = findPage.page_impressions_frequency_distribution_week
                    if page_attributes not in page_impressions_frequency_distribution_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_frequency_distribution_week):
                        page_impressions_frequency_distribution_week.append(page_attributes)
                    findPage.page_impressions_frequency_distribution_week = page_impressions_frequency_distribution_week
                else:
                    page_impressions_frequency_distribution_days_28 = findPage.page_impressions_frequency_distribution_days_28
                    if page_attributes not in page_impressions_frequency_distribution_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_frequency_distribution_days_28):
                        page_impressions_frequency_distribution_days_28.append(page_attributes)
                    findPage.page_impressions_frequency_distribution_days_28 = page_impressions_frequency_distribution_days_28

            elif page_attributes['name'] == 'page_engaged_users':
                if page_attributes['period'] == 'day':
                    page_engaged_users_day = findPage.page_engaged_users_day
                    if page_attributes not in page_engaged_users_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_engaged_users_day):
                        page_engaged_users_day.append(page_attributes)
                    findPage.page_engaged_users_day = page_engaged_users_day

                elif page_attributes['period'] == 'week':
                    page_engaged_users_week = findPage.page_engaged_users_week
                    if page_attributes not in page_engaged_users_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_engaged_users_week):
                        page_engaged_users_week.append(page_attributes)
                    findPage.page_engaged_users_week = page_engaged_users_week
                else:
                    page_engaged_users_days_28 = findPage.page_engaged_users_days_28
                    if page_attributes not in page_engaged_users_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_engaged_users_days_28):
                        page_engaged_users_days_28.append(page_attributes)
                    findPage.page_engaged_users_days_28 = page_engaged_users_days_28

            elif page_attributes['name'] == 'page_fans_city':
                page_fans_city = findPage.page_fans_city
                if page_attributes not in page_fans_city:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fans_city):
                    page_fans_city.append(page_attributes)
                findPage.page_fans_city = page_fans_city

            elif page_attributes['name'] == 'page_fans_locale':
                page_fans_locale = findPage.page_fans_locale
                if page_attributes not in page_fans_locale:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fans_locale):
                    page_fans_locale.append(page_attributes)
                findPage.page_fans_locale = page_fans_locale

            elif page_attributes['name'] == 'page_fans_gender_age':
                page_fans_gender_age = findPage.page_fans_gender_age
                if page_attributes not in page_fans_gender_age:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fans_gender_age):
                    page_fans_gender_age.append(page_attributes)
                findPage.page_fans_gender_age = page_fans_gender_age

            elif page_attributes['name'] == 'page_negative_feedback':
                if page_attributes['period'] == 'day':
                    page_negative_feedback_day = findPage.page_negative_feedback_day
                    if page_attributes not in page_negative_feedback_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_negative_feedback_day):
                        page_negative_feedback_day.append(page_attributes)
                    findPage.page_negative_feedback_day = page_negative_feedback_day

                elif page_attributes['period'] == 'week':
                    page_negative_feedback_week = findPage.page_negative_feedback_week
                    if page_attributes not in page_negative_feedback_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_negative_feedback_week):
                        page_negative_feedback_week.append(page_attributes)
                    findPage.page_negative_feedback_week = page_negative_feedback_week
                else:
                    page_negative_feedback_days_28 = findPage.page_negative_feedback_days_28
                    if page_attributes not in page_negative_feedback_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_negative_feedback_days_28):
                        page_negative_feedback_days_28.append(page_attributes)
                    findPage.page_negative_feedback_days_28 = page_negative_feedback_days_28

            elif page_attributes['name'] == 'page_negative_feedback_unique':
                if page_attributes['period'] == 'day':
                    page_negative_feedback_unique_day = findPage.page_negative_feedback_unique_day
                    if page_attributes not in page_negative_feedback_unique_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_negative_feedback_unique_day):
                        page_negative_feedback_unique_day.append(page_attributes)
                    findPage.page_negative_feedback_unique_day = page_negative_feedback_unique_day

                elif page_attributes['period'] == 'week':
                    page_negative_feedback_unique_week = findPage.page_negative_feedback_unique_week
                    if page_attributes not in page_negative_feedback_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_negative_feedback_unique_week):
                        page_negative_feedback_week.append(page_attributes)
                    findPage.page_negative_feedback_unique_week = page_negative_feedback_unique_week
                else:
                    page_negative_feedback_unique_days_28 = findPage.page_negative_feedback_unique_days_28
                    if page_attributes not in page_negative_feedback_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_negative_feedback_unique_days_28):
                        page_negative_feedback_unique_days_28.append(page_attributes)
                    findPage.page_negative_feedback_unique_days_28 = page_negative_feedback_unique_days_28

            elif page_attributes['name'] == 'page_views_total':
                if page_attributes['period'] == 'day':
                    page_views_total_day = findPage.page_views_total_day
                    if page_attributes not in page_views_total_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_views_total_day):
                        page_views_total_day.append(page_attributes)
                    findPage.page_views_total_day = page_views_total_day

                elif page_attributes['period'] == 'week':
                    page_views_total_week = findPage.page_views_total_week
                    if page_attributes not in page_views_total_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_views_total_week):
                        page_views_total_week.append(page_attributes)
                    findPage.page_views_total_week = page_views_total_week
                else:
                    page_views_total_days_28 = findPage.page_views_total_days_28
                    if page_attributes not in page_views_total_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_views_total_days_28):
                        page_views_total_days_28.append(page_attributes)
                    findPage.page_views_total_days_28 = page_views_total_days_28

            elif page_attributes['name'] == 'page_impressions_paid':
                if page_attributes['period'] == 'day':
                    page_impressions_paid_day = findPage.page_impressions_paid_day
                    if page_attributes not in page_impressions_paid_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_paid_day):
                        page_impressions_paid_day.append(page_attributes)
                    findPage.page_impressions_paid_day = page_impressions_paid_day

                elif page_attributes['period'] == 'week':
                    page_impressions_paid_week = findPage.page_impressions_paid_week
                    if page_attributes not in page_impressions_paid_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_paid_week):
                        page_impressions_paid_week.append(page_attributes)
                    findPage.page_impressions_paid_week = page_impressions_paid_week
                else:
                    page_impressions_paid_days_28 = findPage.page_impressions_paid_days_28
                    if page_attributes not in page_impressions_paid_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_paid_days_28):
                        page_impressions_paid_days_28.append(page_attributes)
                    findPage.page_impressions_paid_days_28 = page_impressions_paid_days_28

            elif page_attributes['name'] == 'page_impressions_paid_unique':
                if page_attributes['period'] == 'day':
                    page_impressions_paid_unique_day = findPage.page_impressions_paid_unique_day
                    if page_attributes not in page_impressions_paid_unique_day:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_paid_unique_day):
                        page_impressions_paid_unique_day.append(page_attributes)
                    findPage.page_impressions_paid_unique_day = page_impressions_paid_unique_day

                elif page_attributes['period'] == 'week':
                    page_impressions_paid_unique_week = findPage.page_impressions_paid_unique_week
                    if page_attributes not in page_impressions_paid_unique_week:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_paid_unique_week):
                        page_impressions_paid_unique_week.append(page_attributes)
                    findPage.page_impressions_paid_unique_week = page_impressions_paid_unique_week
                else:
                    page_impressions_paid_unique_days_28 = findPage.page_impressions_paid_unique_days_28
                    if page_attributes not in page_impressions_paid_unique_days_28:
                        # if in_dictlist(('end_time', page_attributes['end_time']),page_impressions_paid_unique_days_28):
                        page_impressions_paid_unique_days_28.append(page_attributes)
                    findPage.page_impressions_paid_unique_days_28 = page_impressions_paid_unique_days_28

            # page_fan_adds_by_paid_non_paid_unique
            elif page_attributes['name'] == 'page_fan_adds_by_paid_non_paid_unique':
                page_fan_adds_by_paid_non_paid_unique = findPage.page_fan_adds_by_paid_non_paid_unique
                if page_attributes not in page_fan_adds_by_paid_non_paid_unique:
                    # if in_dictlist(('end_time', page_attributes['end_time']),page_fan_adds_by_paid_non_paid_unique):
                    page_fan_adds_by_paid_non_paid_unique.append(page_attributes)
                findPage.page_fan_adds_by_paid_non_paid_unique = page_fan_adds_by_paid_non_paid_unique

            findPage.save()


        else:
            findPage = Page()

            # findPage.page_category = ""
            # findPage.page_district = ""
            # findPage.page_state = ""
            # findPage.page_id = ""
            # findPage.page_name = ""
            # findPage.page_management = ""
            # findPage.page_poc = ""

            if page_attributes['name'] == 'page_fans':
                findPage.page_fans = [page_attributes]

            elif page_attributes['name'] == 'page_fan_adds':
                findPage.page_fan_adds = [page_attributes]

            elif page_attributes['name'] == 'page_fan_adds_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_fan_adds_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_fan_adds_unique_week = [page_attributes]

                else:
                    findPage.page_fan_adds_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_fan_removes':
                findPage.page_fan_removes = [page_attributes]

            elif page_attributes['name'] == 'page_fan_removes_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_fan_removes_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_fan_removes_unique_week = [page_attributes]

                else:
                    findPage.page_fan_removes_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_fans_by_like_source':
                findPage.page_fans_by_like_source = [page_attributes]

            elif page_attributes['name'] == 'page_fans_by_unlike_source_unique':
                findPage.page_fans_by_unlike_source_unique = [page_attributes]

            elif page_attributes['name'] == 'page_impressions':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_week = [page_attributes]

                else:
                    findPage.page_impressions_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_unique_week = [page_attributes]

                else:
                    findPage.page_impressions_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_organic':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_organic_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_organic_week = [page_attributes]

                else:
                    findPage.page_impressions_organic_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_organic_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_organic_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_organic_unique_week = [page_attributes]

                else:
                    findPage.page_impressions_organic_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_viral':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_viral_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_viral_week = [page_attributes]

                else:
                    findPage.page_impressions_viral_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_viral_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_viral_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_viral_unique_week = [page_attributes]

                else:
                    findPage.page_impressions_viral_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_nonviral':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_nonviral_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_nonviral_week = [page_attributes]

                else:
                    findPage.page_impressions_nonviral_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_nonviral_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_nonviral_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_nonviral_unique_week = [page_attributes]

                else:
                    findPage.page_impressions_nonviral_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_frequency_distribution':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_frequency_distribution_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_frequency_distribution_week = [page_attributes]

                else:
                    findPage.page_impressions_frequency_distribution_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_engaged_users':
                if page_attributes['period'] == 'day':
                    findPage.page_engaged_users_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_engaged_users_week = [page_attributes]

                else:
                    findPage.page_engaged_users_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_fans_city':
                findPage.page_fans_city = [page_attributes]

            elif page_attributes['name'] == 'page_fans_locale':
                findPage.page_fans_locale = [page_attributes]

            elif page_attributes['name'] == 'page_fans_gender_age':
                findPage.page_fans_gender_age = [page_attributes]

            elif page_attributes['name'] == 'page_negative_feedback':
                if page_attributes['period'] == 'day':
                    findPage.page_negative_feedback_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_negative_feedback_week = [page_attributes]

                else:
                    findPage.page_negative_feedback_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_negative_feedback_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_negative_feedback_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_negative_feedback_unique_week = [page_attributes]

                else:
                    findPage.page_negative_feedback_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_views_total':
                if page_attributes['period'] == 'day':
                    findPage.page_views_total_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_views_total_week = [page_attributes]

                else:
                    findPage.page_views_total_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_paid':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_paid_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_paid_week = [page_attributes]

                else:
                    findPage.page_impressions_paid_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_impressions_paid_unique':
                if page_attributes['period'] == 'day':
                    findPage.page_impressions_paid_unique_day = [page_attributes]

                elif page_attributes['period'] == 'week':
                    findPage.page_impressions_paid_unique_week = [page_attributes]

                else:
                    findPage.page_impressions_paid_unique_days_28 = [page_attributes]

            elif page_attributes['name'] == 'page_fan_adds_by_paid_non_paid_unique':
                findPage.page_fan_adds_by_paid_non_paid_unique = [page_attributes]

            findPage.save()

    obj['status'] = True
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')

# <------------------------cron job to update post details of a page in mongodb------------------->
def fetch_facebook_posts(access_token, page_id):
    obj = {}
    obj['status'] = False
    obj['results'] = []
    # page_id = '1353902471330279'
    fields = ["created_time", "message", "story", "id", "shares", "comments.summary(true).limit(0)", "link",
              "likes.summary(True).limit(0)"]
    r = requests.get('https://graph.facebook.com/v2.12/me/posts?fields=' + '%2C'.join(
        fields) + '&access_token=' + access_token + '&since=1 november 2018&until=now&limit=20')
    output = r.json()
    post_data = output["data"]
    fields = ['post_impressions',
              'post_impressions_unique',
              'post_impressions_fan',
              'post_impressions_fan_unique',
              'post_impressions_organic',
              'post_impressions_organic_unique',
              'post_impressions_viral',
              'post_impressions_viral_unique',
              'post_impressions_nonviral',
              'post_impressions_nonviral_unique',
              'post_impressions_by_story_type',
              'post_impressions_by_story_type_unique',
              'post_reactions_like_total',
              'post_reactions_love_total',
              'post_reactions_wow_total',
              'post_reactions_haha_total',
              'post_reactions_sorry_total',
              'post_reactions_anger_total',
              'post_reactions_by_type_total',
              'post_clicks',
              'post_clicks_unique',
              'post_engaged_users',
              'post_engaged_fan',
              'post_negative_feedback_unique',
              'post_video_views_10s_unique'
              ]
    for data in post_data:
        message = ""
        shares_count = ""
        comments_count = ""
        link = ""
        created_time = data['created_time']
        id = data["id"]

        if "message" in data.keys():
            message = data["message"]

        if "shares" in data.keys():
            shares_count = str(data['shares']['count'])

        if "comments" in data.keys():
            if data['comments']['summary']['total_count'] != None:
                comments_count = ""
            else:
                comments_count = str(data['comments']['summary']['total_count'])

        if "link" in data.keys():
            link = data["link"]

        post_response = requests.get(
            "https://graph.facebook.com/v2.12/" + str(id) + "/insights?metric=" + "%2C".join(
                fields) + "&access_token=" + access_token)
        post_output = post_response.json()
        json_output = post_output['data']
        results = []
        for json_data in json_output:
            data_dict = json_data['values'][0]
            data_dict['period'] = json_data['period']
            data_dict['name'] = json_data['name']
            results.append(data_dict)

        findPost = Post.objects.filter(post_id=id, page_id=page_id)
        if len(findPost):
            findPost = findPost[0]

            post_comments_count = findPost.post_comments_count
            post_comments_count.append(comments_count)
            findPost.post_comments_count = post_comments_count

            post_shares_count = findPost.post_shares_count
            post_shares_count.append(shares_count)
            findPost.post_shares_count = post_shares_count

            post_impressions = findPost.post_impressions
            post_impressions.append(results[0])
            findPost.post_impressions = post_impressions

            post_impressions_unique = findPost.post_impressions_unique
            post_impressions_unique.append(results[1])
            findPost.post_impressions_unique = post_impressions_unique

            post_impressions_fan = findPost.post_impressions_fan
            post_impressions_fan.append(results[2])
            findPost.post_impressions_fan = post_impressions_fan

            post_impressions_fan_unique = findPost.post_impressions_fan_unique
            post_impressions_fan_unique.append(results[3])
            findPost.post_impressions_fan = post_impressions_fan_unique

            post_impressions_organic = findPost.post_impressions_organic
            post_impressions_organic.append(results[4])
            findPost.post_impressions_organic = post_impressions_organic

            post_impressions_organic_unique = findPost.post_impressions_organic_unique
            post_impressions_organic_unique.append(results[5])
            findPost.post_impressions_organic_unique = post_impressions_organic_unique

            post_impressions_viral = findPost.post_impressions_viral
            post_impressions_viral.append(results[6])
            findPost.post_impressions_viral = post_impressions_viral

            post_impressions_viral_unique = findPost.post_impressions_viral_unique
            post_impressions_viral_unique.append(results[7])
            findPost.post_impressions_viral_unique = post_impressions_viral_unique

            post_impressions_nonviral = findPost.post_impressions_nonviral
            post_impressions_nonviral.append(results[8])
            findPost.post_impressions_nonviral = post_impressions_nonviral

            post_impressions_nonviral_unique = findPost.post_impressions_nonviral_unique
            post_impressions_nonviral_unique.append(results[9])
            findPost.post_impressions_nonviral_unique = post_impressions_nonviral_unique

            post_impressions_by_story_type = findPost.post_impressions_by_story_type
            post_impressions_by_story_type.append(results[10])
            findPost.post_impressions_by_story_type = post_impressions_by_story_type

            post_impressions_by_story_type_unique = findPost.post_impressions_by_story_type_unique
            post_impressions_by_story_type_unique.append(results[11])
            findPost.post_impressions_by_story_type_unique = post_impressions_by_story_type_unique

            post_reactions_like_total = findPost.post_reactions_like_total
            post_reactions_like_total.append(results[12])
            findPost.post_reactions_like_total = post_reactions_like_total

            post_reactions_love_total = findPost.post_reactions_love_total
            post_reactions_love_total.append(results[13])
            findPost.post_reactions_love_total = post_reactions_love_total

            post_reactions_wow_total = findPost.post_reactions_wow_total
            post_reactions_wow_total.append(results[14])
            findPost.post_reactions_wow_total = post_reactions_wow_total

            post_reactions_haha_total = findPost.post_reactions_haha_total
            post_reactions_haha_total.append(results[15])
            findPost.post_reactions_haha_total = post_reactions_haha_total

            post_reactions_sorry_total = findPost.post_reactions_sorry_total
            post_reactions_sorry_total.append(results[16])
            findPost.post_reactions_sorry_total = post_reactions_sorry_total

            post_reactions_anger_total = findPost.post_reactions_anger_total
            post_reactions_anger_total.append(results[17])
            findPost.post_reactions_anger_total = post_reactions_anger_total

            post_reactions_by_type_total = findPost.post_reactions_by_type_total
            post_reactions_by_type_total.append(results[18])
            findPost.post_reactions_by_type_total = post_reactions_by_type_total

            post_clicks = findPost.post_clicks
            post_clicks.append(results[19])
            findPost.post_clicks = post_clicks

            post_clicks_unique = findPost.post_clicks_unique
            post_clicks_unique.append(results[20])
            findPost.post_clicks_unique = post_clicks_unique

            post_engaged_users = findPost.post_engaged_users
            post_engaged_users.append(results[21])
            findPost.post_engaged_users = post_engaged_users

            post_engaged_fan = findPost.post_engaged_fan
            post_engaged_fan.append(results[22])
            findPost.post_engaged_fan = post_engaged_fan

            post_negative_feedback_unique = findPost.post_negative_feedback_unique
            post_negative_feedback_unique.append(results[23])
            findPost.post_negative_feedback_unique = post_negative_feedback_unique

            post_video_views_10s_unique = findPost.post_video_views_10s_unique
            post_video_views_10s_unique.append(results[24])
            findPost.post_video_views_10s_unique = post_video_views_10s_unique

            findPost.save()
        else:
            findPage = Page.objects.filter(page_id=page_id)[0]
            object_id = findPage.id
            page_name = findPage.page_name
            page_state = findPage.page_state
            page_district = findPage.page_district
            page_category = findPage.page_category
            page_management = findPage.page_management
            page_poc = findPage.page_poc
            post_details = Post(
                page_id=page_id
                , page_name=page_name
                , page_state=page_state
                , page_district=page_district
                , page_category=page_category
                , page_management=page_management
                , page_poc=page_poc
                , page_object_id=object_id
                , post_id=id
                , post_message=message
                , post_link=link
                , post_created_time=created_time
                , post_comments_count=[comments_count]
                , post_shares_count=[shares_count]
                , post_impressions=[results[0]]
                , post_impressions_unique=[results[1]]
                , post_impressions_fan=[results[2]]
                , post_impressions_fan_unique=[results[3]]
                , post_impressions_organic=[results[4]]
                , post_impressions_organic_unique=[results[5]]
                , post_impressions_viral=[results[6]]
                , post_impressions_viral_unique=[results[7]]
                , post_impressions_nonviral=[results[8]]
                , post_impressions_nonviral_unique=[results[9]]
                , post_impressions_by_story_type=[results[10]]
                , post_impressions_by_story_type_unique=[results[11]]
                , post_reactions_like_total=[results[12]]
                , post_reactions_love_total=[results[13]]
                , post_reactions_wow_total=[results[14]]
                , post_reactions_haha_total=[results[15]]
                , post_reactions_sorry_total=[results[16]]
                , post_reactions_anger_total=[results[17]]
                , post_reactions_by_type_total=[results[18]]
                , post_clicks=[results[19]]
                , post_clicks_unique=[results[20]]
                , post_engaged_users=[results[21]]
                , post_engaged_fan=[results[22]]
                , post_negative_feedback_unique=[results[23]]
                , post_video_views_10s_unique=[results[24]]
            )
            post_details.save()
    if 'paging' in output.keys():
        paging = output['paging']
        while 'next' in paging.keys():
            response = requests.get(paging['next'])
            output = response.json()
            post_data = output['data']
            for data in post_data:
                message = ""
                shares_count = ""
                comments_count = ""
                link = ""
                created_time = data['created_time']
                id = data["id"]
                if "message" in data.keys():
                    message = data["message"]

                if "shares" in data.keys():
                    shares_count = str(data['shares']['count'])

                if "comments" in data.keys():
                    if data['comments']['summary']['total_count'] != None:
                        comments_count = ""
                    else:
                        comments_count = str(data['comments']['summary']['total_count'])

                if "link" in data.keys():
                    link = data["link"]

                post_response = requests.get(
                    'https://graph.facebook.com/v2.12/' + str(id) + '/insights?metric=' + '%2C'.join(
                        fields) + '&data_present=today&access_token=' + access_token)
                post_output = post_response.json()
                json_output = post_output['data']
                results = []
                for data in json_output:
                    data_dict = data['values'][0]
                    data_dict['period'] = data['period']
                    data_dict['name'] = data['name']
                    results.append(data_dict)
                findPost = Post.objects.filter(post_id=id, page_id=page_id)
                if len(findPost):
                    findPost = findPost[0]

                    post_comments_count = findPost.post_comments_count
                    post_comments_count.append(comments_count)
                    findPost.post_comments_count = post_comments_count

                    post_shares_count = findPost.post_shares_count
                    post_shares_count.append(shares_count)
                    findPost.post_shares_count = post_shares_count

                    post_impressions = findPost.post_impressions
                    post_impressions.append(results[0])
                    findPost.post_impressions = post_impressions

                    post_impressions_unique = findPost.post_impressions_unique
                    post_impressions_unique.append(results[1])
                    findPost.post_impressions_unique = post_impressions_unique

                    post_impressions_fan = findPost.post_impressions_fan
                    post_impressions_fan.append(results[2])
                    findPost.post_impressions_fan = post_impressions_fan

                    post_impressions_fan_unique = findPost.post_impressions_fan_unique
                    post_impressions_fan_unique.append(results[3])
                    findPost.post_impressions_fan = post_impressions_fan_unique

                    post_impressions_organic = findPost.post_impressions_organic
                    post_impressions_organic.append(results[4])
                    findPost.post_impressions_organic = post_impressions_organic

                    post_impressions_organic_unique = findPost.post_impressions_organic_unique
                    post_impressions_organic_unique.append(results[5])
                    findPost.post_impressions_organic_unique = post_impressions_organic_unique

                    post_impressions_viral = findPost.post_impressions_viral
                    post_impressions_viral.append(results[6])
                    findPost.post_impressions_viral = post_impressions_viral

                    post_impressions_viral_unique = findPost.post_impressions_viral_unique
                    post_impressions_viral_unique.append(results[7])
                    findPost.post_impressions_viral_unique = post_impressions_viral_unique

                    post_impressions_nonviral = findPost.post_impressions_nonviral
                    post_impressions_nonviral.append(results[8])
                    findPost.post_impressions_nonviral = post_impressions_nonviral

                    post_impressions_nonviral_unique = findPost.post_impressions_nonviral_unique
                    post_impressions_nonviral_unique.append(results[9])
                    findPost.post_impressions_nonviral_unique = post_impressions_nonviral_unique

                    post_impressions_by_story_type = findPost.post_impressions_by_story_type
                    post_impressions_by_story_type.append(results[10])
                    findPost.post_impressions_by_story_type = post_impressions_by_story_type

                    post_impressions_by_story_type_unique = findPost.post_impressions_by_story_type_unique
                    post_impressions_by_story_type_unique.append(results[11])
                    findPost.post_impressions_by_story_type_unique = post_impressions_by_story_type_unique

                    post_reactions_like_total = findPost.post_reactions_like_total
                    post_reactions_like_total.append(results[12])
                    findPost.post_reactions_like_total = post_reactions_like_total

                    post_reactions_love_total = findPost.post_reactions_love_total
                    post_reactions_love_total.append(results[13])
                    findPost.post_reactions_love_total = post_reactions_love_total

                    post_reactions_wow_total = findPost.post_reactions_wow_total
                    post_reactions_wow_total.append(results[14])
                    findPost.post_reactions_wow_total = post_reactions_wow_total

                    post_reactions_haha_total = findPost.post_reactions_haha_total
                    post_reactions_haha_total.append(results[15])
                    findPost.post_reactions_haha_total = post_reactions_haha_total

                    post_reactions_sorry_total = findPost.post_reactions_sorry_total
                    post_reactions_sorry_total.append(results[16])
                    findPost.post_reactions_sorry_total = post_reactions_sorry_total

                    post_reactions_anger_total = findPost.post_reactions_anger_total
                    post_reactions_anger_total.append(results[17])
                    findPost.post_reactions_anger_total = post_reactions_anger_total

                    post_reactions_by_type_total = findPost.post_reactions_by_type_total
                    post_reactions_by_type_total.append(results[18])
                    findPost.post_reactions_by_type_total = post_reactions_by_type_total

                    post_clicks = findPost.post_clicks
                    post_clicks.append(results[19])
                    findPost.post_clicks = post_clicks

                    post_clicks_unique = findPost.post_clicks_unique
                    post_clicks_unique.append(results[20])
                    findPost.post_clicks_unique = post_clicks_unique

                    post_engaged_users = findPost.post_engaged_users
                    post_engaged_users.append(results[21])
                    findPost.post_engaged_users = post_engaged_users

                    post_engaged_fan = findPost.post_engaged_fan
                    post_engaged_fan.append(results[22])
                    findPost.post_engaged_fan = post_engaged_fan

                    post_negative_feedback_unique = findPost.post_negative_feedback_unique
                    post_negative_feedback_unique.append(results[23])
                    findPost.post_negative_feedback_unique = post_negative_feedback_unique

                    post_video_views_10s_unique = findPost.post_video_views_10s_unique
                    post_video_views_10s_unique.append(results[24])
                    findPost.post_video_views_10s_unique = post_video_views_10s_unique

                    findPost.save()
                else:
                    findPage = Page.objects.filter(page_id=page_id)[0]
                    object_id = findPage.id
                    page_name = findPage.page_name
                    page_state = findPage.page_state
                    page_district = findPage.page_district
                    page_category = findPage.page_category
                    page_management = findPage.page_management
                    page_poc = findPage.page_poc
                    post_details = Post(
                        page_id=page_id
                        , page_name=page_name
                        , page_state=page_state
                        , page_district=page_district
                        , page_category=page_category
                        , page_management=page_management
                        , page_poc=page_poc
                        , page_object_id=object_id
                        , post_id=id
                        , post_message=message
                        , post_link=link
                        , post_created_time=created_time
                        , post_comments_count=[comments_count]
                        , post_shares_count=[shares_count]
                        , post_impressions=[results[0]]
                        , post_impressions_unique=[results[1]]
                        , post_impressions_fan=[results[2]]
                        , post_impressions_fan_unique=[results[3]]
                        , post_impressions_organic=[results[4]]
                        , post_impressions_organic_unique=[results[5]]
                        , post_impressions_viral=[results[6]]
                        , post_impressions_viral_unique=[results[7]]
                        , post_impressions_nonviral=[results[8]]
                        , post_impressions_nonviral_unique=[results[9]]
                        , post_impressions_by_story_type=[results[10]]
                        , post_impressions_by_story_type_unique=[results[11]]
                        , post_reactions_like_total=[results[12]]
                        , post_reactions_love_total=[results[13]]
                        , post_reactions_wow_total=[results[14]]
                        , post_reactions_haha_total=[results[15]]
                        , post_reactions_sorry_total=[results[16]]
                        , post_reactions_anger_total=[results[17]]
                        , post_reactions_by_type_total=[results[18]]
                        , post_clicks=[results[19]]
                        , post_clicks_unique=[results[20]]
                        , post_engaged_users=[results[21]]
                        , post_engaged_fan=[results[22]]
                        , post_negative_feedback_unique=[results[23]]
                        , post_video_views_10s_unique=[results[24]]
                    )
                    post_details.save()
            if 'paging' in output.keys():
                paging = output['paging']

    obj['status'] = True
    obj['msg'] = "Success"
    return HttpResponse(json.dumps(obj), content_type='application/json')

def fetch_facebook_page_tokens(request):
    if request.GET.get("id") is not None:
        if Page.objects.filter(page_id=request.GET.get("id")).count() > 0:
            page = Page.objects.filter(page_id=request.GET.get("id"))[0]
            if page.page_access_expiry > datetime.now():
                return HttpResponse(page.page_access_token)
            else:  # when token has expired
                return render(request, 'scriptFB.html')
        else:  # when page not present in db
            return render(request, 'scriptFB.html')
    else:  # when GET params not present in request
        return HttpResponse("Invalid Request: must include GET param /?id=\{page_id\}")

def update_facebook_tokens(request):
    data = json.loads(urlparse.parse_qs(request.body)['data'][0])
    # data["creation_ts"] = datetime.utcfromtimestamp(date["creation_ts"])
    data["expiry_ts"] = datetime.fromtimestamp(data["expiry_ts"])
    if len(Page.objects.filter(page_id=data["id"])) < 1:
        Page.objects.create(page_id=data["id"], page_name=data["name"], page_access_token=data["access_token"],
                            page_category=data["category"],
                            page_permissions=data["tasks"], page_category_list=data["category_list"],
                            page_access_expiry=data["expiry_ts"])
    else:
        Page.objects.filter(page_id=data["id"]).update(page_name=data["name"],
                                                       page_access_token=data["access_token"],
                                                       page_category=data["category"],
                                                       page_permissions=data["tasks"],
                                                       page_category_list=data["category_list"],
                                                       page_access_expiry=data["expiry_ts"])
    return HttpResponse('OK')

def termsofuse(request):
    return render(request, 'termsofuse.html')

def privacypolicy(request):
    return render(request, 'privacypolicy.html')
