# Create your views here.

from django.shortcuts import render
from django.http import HttpResponseRedirect,HttpResponseForbidden,HttpResponse
from django.shortcuts import render_to_response, redirect
from django.contrib.auth import authenticate, login, logout
from django.db import models
from django.db.models import Q

from models import *

import time
import requests
import xlsxwriter

def scrape():
    counter=1
    row=0
    cookies = {
        'I8eTT7vh01': 'MDAwM2IyYzhmNDAwMDAwMDAxODEwEztAaFgxNTQwNjczMTEw',
        'JSESSIONID': '37F89AEEAD7F8EC22D003B8B7A7D36DF.lgd2',
    }


    headers = {
        'Pragma': 'no-cache',
        'Origin': 'http://lgdirectory.gov.in',
        'Accept-Encoding': 'gzip, deflate',
        'Accept-Language': 'en-US,en;q=0.9',
        'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:63.0) Gecko/20100101 Firefox/63.0',
        'Content-Type': 'text/plain',
        'Accept': '*/*',
        'Cache-Control': 'no-cache',
        'Referer': 'http://lgdirectory.gov.in/',
        'Connection': 'keep-alive',
    }
    # headers = {
    #     'User-Agent':  'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
    #     'Accept': '*/*',
    #     'Accept-Language': 'en-US,en;q=0.5',
    #     'Referer': 'http://lgdirectory.gov.in/',
    #     'Content-Type': 'text/plain',
    #     'Connection': 'keep-alive',
    # }

    # params = {
    # 'callCount':'1',
    # 'windowName':'',
    # 'c0-scriptName':'dwrReportService',
    # 'c0-methodName':'getParentwiseChildDetils',
    # 'c0-id':'0',
    # 'c0-param0':'string:T',
    # 'c0-param1':'number:5916',
    # 'c0-param2':'string:L',
    # 'c0-param3':'null:null',
    # 'batchId':'3',
    # 'page':'/',
    # 'httpSessionId':'',
    # 'scriptSessionId':'C48B2FF0A61BA52182E82CB36735B4C3'
    # }


    for i in range (2,8):
        params = {
        'callCount':'1',
        'windowName':'',
        'c0-scriptName':'dwrReportService',
        'c0-methodName':'getParentwiseChildDetils',
        'c0-id':'0',
        'c0-param0':'string:S',
        'c0-param1':('number:'+str(i)),
        'c0-param2':'string:L',
        'c0-param3':'string:X',
        'batchId':counter,
        'page':'%2F',
        'httpSessionId':'',
        'scriptSessionId':'14C9242847E0780D723B9EBA1C2E2422'
        }
        try:
            response = requests.post('http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr', headers=headers, cookies=cookies, params=params)
        except:
            # print response.status_code
            time.sleep(10)
            response = requests.post(
                'http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr',
                headers=headers, cookies=cookies, params=params)
        m=str(response.content)
        counter=counter+1
        start= m.find("[")
        end = m.find("]")
        list_data = (m[start+2:end-1]).split("},{")
        for alfa in list_data:
            start = alfa.find("census2001Code:")
            end = alfa.find(",census2011Code")
            census2001CodeD=alfa[start+15:end]
            # print (census2001CodeD)

            start = alfa.find("census2011Code:")
            end = alfa.find(",entityCode")
            census2011CodeD = alfa[start + 15:end]
            # print (census2011CodeD)

            start_entity = alfa.find("entityCode:")
            end_entity = alfa.find(",entityNameEnglish")
            codeD = alfa[start_entity + 11:end_entity]
            # print (codeD)

            start_entity = alfa.find("entityNameEnglish:")
            end_entity = alfa.find(",noOfTlc:")
            nameD = alfa[start_entity + 18:end_entity]
            # print (nameD)

            print alfa

            print "------------------------------------------------------------------------------------------------------------------------------------"

            params = {
                'callCount': '1',
                'windowName': '',
                'c0-scriptName': 'dwrReportService',
                'c0-methodName': 'getParentwiseChildDetils',
                'c0-id': '0',
                'c0-param0': 'string:D',
                'c0-param1': ('number:' + str(codeD)),
                'c0-param2': 'string:L',
                'c0-param3': 'null:null',
                'batchId': counter,
                'page': '%2F',
                'httpSessionId': '',
                'scriptSessionId': '14C9242847E0780D723B9EBA1C2E2422'
            }
            try:
                response = requests.post(
                    'http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr',
                    headers=headers, cookies=cookies, params=params)
            except:
                print response.status_code
                # time.sleep(10)
                response = requests.post(
                    'http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr',
                    headers=headers, cookies=cookies, params=params)

            counter = counter + 1
            m = str(response.content)

            start = m.find("[")
            end = m.find("]")
            list_data = (m[start + 2:end - 1]).split("},{")

            for alfa in list_data:
                # print (alfa)
                start = alfa.find("census2001Code:")                 # Sub-District level code
                end = alfa.find(",census2011Code")                   # Sub-District level code
                census2001CodeSD = alfa[start + 15:end]                # Sub-District level code
                # print (census2001CodeSD)                               # Sub-District level code
                start = alfa.find("census2011Code:")                 # Sub-District level code
                end = alfa.find(",entityCode")                       # Sub-District level code
                census2011CodeSD = alfa[start + 15:end]                # Sub-District level code
                # print (census2011CodeSD)                               # Sub-District level code
                start_entity = alfa.find("entityCode:")              # Sub-District level code
                end_entity = alfa.find(",entityNameEnglish")         # Sub-District level code
                codeSD = alfa[start_entity + 11:end_entity]            # Sub-District level code
                # print (codeSD)                                           # Sub-District level code
                start_entity = alfa.find("entityNameEnglish:")       # Sub-District level code
                end_entity = alfa.find(",noOfTlc:")                  # Sub-District level code
                nameSD = alfa[start_entity + 18:end_entity]
                # print (nameSD)

                print ("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx")

                params = {
                        'callCount': '1',
                        'windowName': '',
                        'c0-scriptName': 'dwrReportService',
                        'c0-methodName': 'getParentwiseChildDetils',
                        'c0-id': '0',
                        'c0-param0': 'string:T',
                        'c0-param1': ('number:' + str(codeSD)),
                        'c0-param2': 'string:L',
                        'c0-param3': 'null:null',
                        'batchId': counter,
                        'page': '%2F',
                        'httpSessionId': '',
                        'scriptSessionId': '14C9242847E0780D723B9EBA1C2E2422'
                    }
                try:
                    response = requests.post(
                        'http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr',
                        headers=headers, cookies=cookies, params=params)
                except:
                    print response.status_code
                    # time.sleep(10)
                    response = requests.post(
                        'http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr',
                        headers=headers, cookies=cookies, params=params)
                counter = counter + 1
                m = str(response.content)

                start = m.find("[")
                end = m.find("]")
                list_data = (m[start + 2:end - 1]).split("},{")

                for alfa in list_data:
                    # print (alfa)
                    start = alfa.find("census2001Code:")                # Sub-District level code
                    end = alfa.find(",census2011Code")                  # Sub-District level code
                    census2001CodeV = alfa[start + 15:end]               # Sub-District level code
                    # print (census2001CodeV)                               # Sub-District level code
                    start = alfa.find("census2011Code:")                # Sub-District level code
                    end = alfa.find(",entityCode")                      # Sub-District level code
                    census2011CodeV = alfa[start + 15:end]               # Sub-District level code
                    # print (census2011CodeV)                                # Sub-District level code
                    start_entity = alfa.find("entityCode:")             # Sub-District level code
                    end_entity = alfa.find(",entityNameEnglish")        # Sub-District level code
                    codeV = alfa[start_entity + 11:end_entity]           # Sub-District level code
                    # print (codeV)                                          # Sub-District level code
                    start_entity = alfa.find("entityNameEnglish:")      # Sub-District level code
                    end_entity = alfa.find(",noOfTlc:")                 # Sub-District level code
                    nameV = alfa[start_entity + 18:end_entity]
                    # print (nameV)

                    # sheet.write(row,0,census2001CodeD)
                    # sheet.write(row,1,census2011CodeD)
                    # sheet.write(row,2,codeD)
                    # sheet.write(row,3,nameD)
                    # sheet.write(row,4,census2001CodeSD)
                    # sheet.write(row,5,census2011CodeSD)
                    # sheet.write(row,6,codeSD)
                    # sheet.write(row,7,nameSD)
                    # sheet.write(row,8,census2001CodeV)
                    # sheet.write(row,9,census2011CodeV)
                    # sheet.write(row,10,codeV)
                    # sheet.write(row,11,nameV)
                    # row=row+1
                    CCD=Census_Code_Data(District_Census_2001_Code                  =      census2001CodeD,
                            District_Census_2011_Code                           =      census2011CodeD,
                            District_Code                                       =      codeD,
                            District_Name                                       =      nameD,
                            SubDistrict_Census_Code_2001_Code                   =      census2001CodeSD,
                            SubDistrict_Census_Code_2011_Code                   =      census2011CodeSD,
                            SubDistrict_Code                                    =      codeSD,
                            SubDistrict_Name                                    =      nameSD,
                            Village_Census_2001_Code                            =      census2001CodeV,
                            Village_Census_2011_Code                            =      census2011CodeV,
                            Village_Code                                        =      codeV,
                            Village_Name                                        =      nameV)
                    CCD.save()
# book.close()


