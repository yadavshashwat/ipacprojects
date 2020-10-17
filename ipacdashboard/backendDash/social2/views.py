import time
from datetime import datetime, timedelta
from django.core import serializers
from django.utils import simplejson
from django.http import HttpResponse, HttpRequest
from django.shortcuts import render_to_response
from django.views.decorators.http import require_POST, require_GET
from models import *

#SETTINGS
page_analytics = App.objects.get(name="Page Analytics")

# Create your views here.
def temp(request):
  return HttpResponse("OK")

def login(request):
  return render_to_response('fb_login.html')

@require_POST
def xhr_user_token(request):
  user_id = request.POST.get('user_id')
  sl_token = request.POST.get('sl_token')
  expiry = request.POST.get('expiry')
  # Update DB for user
  users = User.objects.filter(user_id=user_id)
  if len(users) < 1:
    # User not present; Create
    user = User.objects.create(
      user_id=user_id,
      user_access_token=sl_token,
      user_access_expiry=datetime.fromtimestamp(int(time.time())+int(expiry)),
      linked_app=page_analytics,
      )
    # exchange short lived token for a long lived token [User]
    if User.upgrade_token(user.app_scoped_id):
      return HttpResponse("User Sign In OK")
    else:
      return HttpResponse("LL token upgrade failed for "+sl_token)
  else:
    # TODO: User Token Update; If token expiry passed
    return HttpResponse("User Log In OK")

@require_POST
def xhr_page_data(request):
  access_token = request.POST.get('access_token')
  user_id = request.POST.get('user_id')
  category = request.POST.get('category')
  id = request.POST.get('id')
  name = request.POST.get('name')
  # Update DB for page
  pages = Page.objects.filter(page_id=id,linked_user=User.objects.get(user_id=user_id))
  if len(pages) < 1:
    # Page not present; Create
    page = Page.objects.create(
      page_name=name,
      page_category=category,
      page_access_token=access_token,
      page_id=id,
      linked_user=User.objects.get(user_id=user_id))
    # exchange page token for a permanent token [Page]
    if Page.upgrade_token(page.page_id):
      return HttpResponse("Page Info OK : "+name)
    else:
      return HttpResponse("Perm token upgrade failed for "+id)
  else:
    # TODO: Page Token Update; If token expiry passed
    return HttpResponse("Page Log In OK")

def page(request):
    query_set = Page.objects.all()
    if request.method == "GET":
      # page_id in params; data for one page only
      if request.GET.get("page_id"):
        query_set = query_set.filter(page_id=request.GET.get("page_id"))
      for key in request.GET.dict().keys():
        print(key)
      data = serializers.serialize('json', query_set, fields=request.GET.get("fields").split(","))
      return HttpResponse(data, content_type="application/json")
    elif request.method == "POST":
      pass
    elif request.method == "PUT":
      pass
        # obj['result'].append({
        #     'page_id' : trans.page_id,
        #     'page_name' : trans.page_name,
        #     'page_access_token' : trans.page_access_token,
        #     'page_state' : trans.page_state,
        #     'page_district' : trans.page_district,
        #     'page_category' : trans.page_category,
        #     'page_fans' : trans.page_fans,
        #     'page_posts_impressions_days_28' : trans.page_posts_impressions_days_28,
        #     'page_views_total_days_28' : trans.page_views_total_days_28,
        #     'page_negative_feedback_unique_days_28' : trans.page_negative_feedback_unique_days_28,
        # })

    # obj['status'] = True
    # obj['counter'] = len(obj['result'])
    # obj['msg'] = "Success"
