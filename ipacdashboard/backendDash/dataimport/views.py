# Create your views here.

from django.db.models.base import ObjectDoesNotExist
import os
import csv
import re
import json
import datetime


from api.models import *


path = os.path.dirname(os.path.realpath(__file__))



def cleanstring(query):
    query = query.strip()
    query = re.sub('\s{2,}', ' ', query)
    query = re.sub(r'^"|"$', '', query)
    return query


def loadUsers(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        userData = csv.reader(csvfile, delimiter='\t', quotechar='|')
        for user in userData:
            user_name               = cleanstring(user[0])
            gender                  = cleanstring(user[1])
            date_of_birth           = cleanstring(user[2])
            mobile_number           = cleanstring(user[3])
            whats_app_number        = cleanstring(user[4])
            user_email              = cleanstring(user[5])
            state_id                = cleanstring(user[6])
            district_id             = cleanstring(user[7])
            is_student              = cleanstring(user[8])
            collage_state_id        = cleanstring(user[9])
            collage_state           = cleanstring(user[10])
            collage_district_id     = cleanstring(user[11])
            collage_name_id         = cleanstring(user[12])
            collage_name            = cleanstring(user[13])
            referee_code            = cleanstring(user[14])
            subscription_ip         = cleanstring(user[15])
            language_preference_1   = cleanstring(user[16])
            language_preference_2   = cleanstring(user[17])
            registration_number     = cleanstring(user[18])


            findUser = ComUser.objects.filter(contact_no = mobile_number)
            if len(findUser):
                findUser = findUser[0]
                findUser.name               = user_name
                findUser.contact_no         = mobile_number
                findUser.whatsapp_no        = whats_app_number
                findUser.birth_date         = date_of_birth
                findUser.user_email         = user_email
                findUser.home_state         = state_id
                findUser.home_district      = district_id
                findUser.college_state      = collage_state_id
                findUser.college_district   = collage_district_id

                if (gender == "1"):
                    findUser.gender         = "Male"
                elif(gender == "2"):
                    findUser.gender         = "Female"
                else:
                    findUser.gender         = "Other"

                if (is_student == "1"):
                    findUser.is_student     = True
                else:
                    findUser.is_student     = False
                findUser.lanugage_pref1     = language_preference_1
                findUser.lanugage_pref2     = language_preference_2
                findUser.college_name       = collage_name
                findUser.subscription_ip    = subscription_ip
                findUser.referral_code      = registration_number
                findUser.referee_code       = referee_code
                findUser.save()
            else:
                if (gender == "1"):
                    gender_data = "Male"
                elif(gender == "2"):
                    gender_data = "Female"
                else:
                    gender_data = "Other"

                if (is_student == "1"):
                    student     = True
                else:
                    student     = False

                cc = ComUser(
                    name                = user_name
                    ,contact_no         = mobile_number
                    ,whatsapp_no        = whats_app_number
                    ,birth_date         = date_of_birth
                    ,user_email         = user_email
                    ,home_state         = state_id
                    ,home_district      = district_id
                    ,college_state      = collage_state_id
                    ,college_district   = collage_district_id
                    ,gender             = gender_data
                    ,is_student         = student
                    ,lanugage_pref1     = language_preference_1
                    ,lanugage_pref2     = language_preference_2
                    , college_name      = collage_name
                    , subscription_ip   = subscription_ip
                    , referral_code     = registration_number
                    , referee_code      = referee_code

                )
                cc.save()





def loadStateDistrict(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        districtData = csv.reader(csvfile, delimiter='\t', quotechar='|')
        for district in districtData:
            state_id        = cleanstring(district[0])
            state_name      = cleanstring(district[1])
            district_id     = cleanstring(district[2])
            district_name   = cleanstring(district[3])
            findDistrict    = StateDistrict.objects.filter(state_id=state_id,district_id=district_id)
            if len(findDistrict):
                findDistrict = findDistrict[0]
                findDistrict.state_name    = state_name
                findDistrict.district_name = district_name
                findDistrict.save()
            else:
                cc = StateDistrict(state_id=state_id,district_id=district_id,state_name=state_name,district_name=district_name)
                cc.save()


def loadLeaders(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        leaderData = csv.reader(csvfile, delimiter=',', quotechar='|')
        for leader in leaderData:
            leader_id       = cleanstring(leader[0])
            leader_name     = cleanstring(leader[1])
            findLeader    = Leaders.objects.filter(leader_id=leader_id,leader_name=leader_name)
            if len(findLeader):
                None
            else:
                cc = Leaders(leader_id=leader_id,leader_name=leader_name)
                cc.save()
            # findKeyword = Keywords.objects.filter(keyword=leader_name, keyword_type="Leader")
            # if len(findKeyword):
            #     None
            # else:
            #     if leader_name in ['Narendra Modi','Rahul Gandhi']:
            #         cc2 = Keywords(keyword=leader_name, keyword_type="Leader",synonyms=[leader_name],is_active = True)
            #     else:
            #         cc2 = Keywords(keyword=leader_name, keyword_type="Leader", synonyms=[leader_name], is_active=False)
            #     cc2.save()


def loadParty(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        partyData = csv.reader(csvfile, delimiter=',', quotechar='|')
        for party in partyData:
            party_code     = cleanstring(party[0])
            party_name     = cleanstring(party[1])
            party_abbr     = cleanstring(party[2])
            party_leader   = cleanstring(party[3])
            party_type     = cleanstring(party[4])

            findParty    = Party.objects.filter(party_code = party_code, party=party_name)
            if len(findParty):
                findParty = findParty[0]
                findParty.party_leader = party_leader
                findParty.party_abbr = party_abbr
                findParty.party_type = party_type
                findParty.save()
            else:
                cc = Party(party_code = party_code, party=party_name,party_leader = party_leader,party_abbr = party_abbr,party_type = party_type)
                cc.save()
            # findKeyword = Keywords.objects.filter(keyword=party_name, keyword_type="Party")
            # if len(findKeyword):
            #     None
            # else:
            #     cc2 = Keywords(keyword=party_name, keyword_type="Party",synonyms=[party_abbr,party_name], is_active = False)
            #     cc2.save()

def loadCategories(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        categoryData = csv.reader(csvfile, delimiter='\t', quotechar='|')
        for cat in categoryData:
            category               = cleanstring(cat[0])
            cat_description        = cleanstring(cat[1])
            findCategory    = Categories.objects.filter(category=category)
            if len(findCategory):
                findCategory = findCategory[0]
                findCategory.cat_description    = cat_description
                findCategory.save()
            else:
                cc = Categories(category=category,cat_description = cat_description)
                cc.save()


def loadRss(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        pubData = csv.reader(csvfile, delimiter=',', quotechar='|')
        for pub in pubData:
            publication            = cleanstring(pub[0])
            category_pub           = cleanstring(pub[1])
            feedcat                = cleanstring(pub[2])
            feedlink               = cleanstring(pub[3])
            title_str_name         = cleanstring(pub[4])
            author_str_name        = cleanstring(pub[5])
            summary_str_name       = cleanstring(pub[6])
            link_str_name          = cleanstring(pub[7])
            pubdate_str_name       = cleanstring(pub[8])
            author_content_str     = cleanstring(pub[9])
            page_content_str       = cleanstring(pub[10])
            language               = cleanstring(pub[11])
            bjp                    = cleanstring(pub[12])
            inc                    = cleanstring(pub[13])
            modi                   = cleanstring(pub[14])
            rahul                  = cleanstring(pub[15])

            # print publication
            # print category_pub
            # print feedcat
            # print feedlink
            # print title_str_name
            # print author_str_name
            # print summary_str_name
            # print link_str_name
            # print pubdate_str_name
            # print page_content_str
            # print author_content_str
            # print language
            # print bjp
            # print inc
            # print modi
            # print rahul

            rss_feed_list = []

            findMedia    = MediaChannel.objects.filter(media_name=publication)
            if len(findMedia):
                findMedia = findMedia[0]
                rss_feed_list = findMedia.rss_feed
                rss_feed_list.append({"feedlink":feedlink,"active":True,"feedname":feedcat})
                # print feedlink
                findMedia.rss_feed = rss_feed_list
                # print findMedia.rss_feed
                findMedia.title_str_name = title_str_name
                findMedia.author_str_name = author_str_name
                findMedia.summary_str_name = summary_str_name
                findMedia.link_str_name = link_str_name
                findMedia.author_content_str = author_content_str
                findMedia.pubdate_str_name = pubdate_str_name
                findMedia.page_content_str = page_content_str
                findMedia.language = language
                findMedia.inclination_leader = [{'leader':'Narendra Modi','sentiment': modi}, {'leader':'Rahul Gandhi','sentiment': rahul}]
                findMedia.inclination_party = [{'party':'Bharatiya Janata Party','sentiment': bjp}, {'party':'Indian National Congress','sentiment': inc}]
                findMedia.save()
            else:
                inclination_leader = [{'leader':'Narendra Modi','sentiment': modi}, {'leader':'Rahul Gandhi','sentiment': rahul}]
                inclination_party =  [{'party':'Bharatiya Janata Party','sentiment': bjp}, {'party':'Indian National Congress','sentiment': inc}]
                cc = MediaChannel(
                    media_name=publication
                    ,article_type=category_pub
                    ,rss_feed  =[{"feedlink":feedlink,"active":True,"feedname":feedcat}]
                    # ,rss_feed = feedlink
                    ,title_str_name = title_str_name
                    ,author_str_name = author_str_name
                    ,summary_str_name = summary_str_name
                    ,link_str_name = link_str_name
                    ,pubdate_str_name = pubdate_str_name
                    ,page_content_str = page_content_str
                    , author_content_str=author_content_str
                    , inclination_party=inclination_party
                    , inclination_leader=inclination_leader
                    ,language = language
                )
                cc.save()



def loadSegments(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        segmentData = csv.reader(csvfile, delimiter='\t', quotechar='|')
        for segment in segmentData:
            dashboard_type          = cleanstring(segment[0])
            segmentation_type       = cleanstring(segment[1])
            segmentation_id         = cleanstring(segment[2])
            segment_active          = cleanstring(segment[3])
            segment_name            = cleanstring(segment[4])
            findSegment    = Segmentation.objects.filter(dashboard_type=dashboard_type,segmentation_type=segmentation_type,segmentation_id=segmentation_id)
            if len(findSegment):
                findSegment = findSegment[0]
                if segment_active == "1":
                    findSegment.segment_active    = True
                else:
                    findSegment.segment_active    = False

                findSegment.segment_name = segment_name
            else:
                if segment_active == "1":
                    seg_active    = True
                else:
                    seg_active    = False
                cc = Segmentation(dashboard_type=dashboard_type,segmentation_type=segmentation_type,segmentation_id=segmentation_id,segment_active=seg_active,segment_name=segment_name)
                cc.save()


def loadTweets(fileName):
    with open(path+'/files_to_import/'+fileName, 'rU') as csvfile:
        tweets = csv.reader(csvfile, delimiter='\t', quotechar='|')
        for tweet in tweets:
            tweet          = cleanstring(tweet[0])
            findSegment    = Tweets.objects.filter(tweet=tweet)
            if len(findSegment):
                None
            else:
                cc = Tweets(tweet = tweet)
                cc.save()


