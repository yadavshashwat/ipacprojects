from dataimport import views
from api.models import *
from api import views as api
# ------------------------- Website Revamp---------------------------

# User Upload
# ComUser.objects.all().delete()
# views.loadUsers('users.txt')

# StaffUser.objects.all().delete()

# SendEmailUsers.objects.all().delete()
# views.loadUsers('users_email.txt')

# views.loadUsers('users_email_test.txt')

# StateDistrict.objects.all().delete()
# views.loadStateDistrict('state_district.txt')

# Keywords.objects.all().delete()
# #
# Leaders.objects.all().delete()
# views.loadLeaders('leader.txt')
# #
# Party.objects.all().delete()
# views.loadParty('party.txt')
#
# Categories.objects.all().delete()
# views.loadCategories('category_news.txt')
#
# MediaChannel.objects.all().delete()
# views.loadRss('rss_feed_list.txt')
#
# NewsFeedAll.objects.all().delete()
# api.scrape_rss()
StateDistrict.objects.all().delete()
views.loadStateDistrict('state_district.txt')
#
# Keywords.objects.all().delete()
#
Leaders.objects.all().delete()
views.loadLeaders('leader.csv')

Party.objects.all().delete()
views.loadParty('party.csv')
#
Categories.objects.all().delete()
views.loadCategories('category_news.txt')

MediaChannel.objects.all().delete()
views.loadRss('RSS_feed.csv')

NewsFeedAll.objects.all().delete()
# api.scrape_rss('')

# views.loadTweets('tweet_links.txt')

# Segmentation.objects.all().delete()
# views.loadSegments('segments_read_write.txt')
