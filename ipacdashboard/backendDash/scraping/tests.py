"""
This file demonstrates writing tests using the unittest module. These will pass
when you run "manage.py test".

Replace this with more appropriate tests for your application.
"""

from django.test import TestCase


# import time
# import selenium
# from selenium.webdriver.common.by import By
# from selenium.webdriver.support import expected_conditions as EC
# from selenium import webdriver
# from selenium.webdriver.support.ui import WebDriverWait
# import xlsxwriter
# import requests
#
# path = r"C:\Users\saini\Desktop\CHROME_D\chromedriver.exe"
# # driver=webdriver.Chrome(path)
# chromeOptions = webdriver.ChromeOptions()
# prefs = {"profile.managed_default_content_settings.images":2}
# chromeOptions.add_experimental_option("prefs",prefs)
# driver = webdriver.Chrome(path,chrome_options=chromeOptions)
# driver.get("http://lgdirectory.gov.in/")
# time.sleep(0.5)
#
# def wait():
#     requests.get("http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr")
#
# length1=len(driver.find_elements_by_xpath("""//*[@id="mainTable"]/tbody/tr"""))
# for i in range(1,length1):
#     wait()
#     first=driver.find_element_by_css_selector( """#mainTable > tbody > tr:nth-child("""+str(i)+""") > td:nth-child(2)""" ).text
#     print("first",first)
#     driver.find_element_by_css_selector("""#mainTable > tbody > tr:nth-child("""+str(i)+""") > td:nth-child(3)>a""").click()
#     wait()
#     time.sleep(1)
#     length2=len(driver.find_elements_by_xpath("""//*[@id="dynamicExample"]/tr"""))
#     print(length2)
#     for j in range(2,length2+1):
#         wait()
#         second=driver.find_element_by_css_selector("""#dynamicExample > tr:nth-child("""+str(j)+""") > td:nth-child(3)""").text
#         print ("second",second)
#         driver.find_element_by_css_selector("""#dynamicExample > tr:nth-child("""+str(j)+""") > td:nth-child(6) > a""").click()
#         wait()
#         time.sleep( 1 )
#         length3 = len(driver.find_elements_by_xpath("""//*[@id="dynamicExample"]/tr"""))
#         print(length3)
#         for k in range(2,length3+1):
#             wait()
#             third=driver.find_element_by_css_selector("""#dynamicExample > tr:nth-child("""+str(k)+""") > td:nth-child(3)""").text
#             print('third',third)
#             driver.find_element_by_css_selector("""#dynamicExample > tr:nth-child("""+str(k)+""") > td:nth-child(6) > a""").click()
#             wait()
#             time.sleep( 1 )
#             trlen=len(driver.find_elements_by_xpath("""//*[@id="dynamicExample"]/tr"""))
#             print(trlen)
#             time.sleep(10)
#             filename = first + "_" + second + "_" + third + ".xlsx"
#             book = xlsxwriter.Workbook( filename )
#             sheet = book.add_worksheet()
#
#             for l in range(1,trlen+1):
#                 tdlen=len(driver.find_elements_by_xpath("""//*[@id="dynamicExample"]/tr"""+str(l)+"""/td"""))
#                 print( tdlen )
#                 time.sleep( 10 )
#                 for m in range(1,tdlen+1):
#                     data=driver.find_element_by_css_selector("""#dynamicExample > tr:nth-child("""+str(l)+""") > td:nth-child("""+str(m)+""")""").text
#                     sheet.write(l,m,data)
#             book.close()
#         time.sleep(1)
#         driver.find_element_by_css_selector( """#dynamicDIV > input[type="button"]""" ).click()
#     time.sleep( 1 )
#     driver.find_element_by_css_selector( """#dynamicDIV > input[type="button"]""" ).click()
# time.sleep(1)
# driver.find_element_by_css_selector("""#dynamicDIV > input[type="button"]""").click()


import requests
import xlsxwriter

book=xlsxwriter.Workbook("Census_code.xlsx")
sheet=book.add_worksheet()

counter=1
row=0
cookies = {
    'I8eTT7vh01': 'MDAwM2IyYzhmNDAwMDAwMDAxODEwQj49KWsxNTQwNjYxOTYw',
    'JSESSIONID': 'EEBA7EC5FA05208F927E00142067071C.lgd',
}


headers = {
    'Pragma': 'no-cache',
    'Origin': 'http://lgdirectory.gov.in',
    'Accept-Encoding': 'gzip, deflate',
    'Accept-Language': 'en-US,en;q=0.9',
    'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
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

for i in range (8,9):
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
    'scriptSessionId':'05EB7D3796FA87513D8BB1999F7A8205'
    }
    response = requests.post('http://lgdirectory.gov.in/dwr/call/plaincall/dwrReportService.getParentwiseChildDetils.dwr', headers=headers, cookies=cookies, params=params)
    m=str(response.content)
    counter=counter+1
    start= m.find("[")
    end = m.find("]")
    list_data = (m[start+2:end-1]).split("},{")                         #District level code
    for alfa in list_data:                                              #District level code
        start = alfa.find("census2001Code:")                            #District level code
        end = alfa.find(",census2011Code")                              #District level code
        census2001CodeD=alfa[start+15:end]                              #District level code
        # print (census2001CodeD)                                       #District level code
        start = alfa.find("census2011Code:")                            #District level code
        end = alfa.find(",entityCode")                                  #District level code
        census2011CodeD = alfa[start + 15:end]                          #District level code
        # print (census2011CodeD)                                       #District level code
        start_entity = alfa.find("entityCode:")                         #District level code
        end_entity = alfa.find(",entityNameEnglish")                    #District level code
        codeD = alfa[start_entity + 11:end_entity]                      #District level code
        # print (codeD)                                                 #District level code
        start_entity = alfa.find("entityNameEnglish:")                  #District level code
        end_entity = alfa.find(",noOfTlc:")                             #District level code
        nameD = alfa[start_entity + 18:end_entity]                      #District level code
        # print (nameD)                                                 #District level code
                                                                        #District level code
        print (alfa)

        print ("------------------------------------------------------------------------------------------------------------------------------------")

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
            'scriptSessionId': '05EB7D3796FA87513D8BB1999F7A8205'
        }
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
                    'scriptSessionId': '05EB7D3796FA87513D8BB1999F7A8205'
                }
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

                sheet.write(row,0,census2001CodeD)
                sheet.write(row,1,census2011CodeD)
                sheet.write(row,2,codeD)
                sheet.write(row,3,nameD)
                sheet.write(row,4,census2001CodeSD)
                sheet.write(row,5,census2011CodeSD)
                sheet.write(row,6,codeSD)
                sheet.write(row,7,nameSD)
                sheet.write(row,8,census2001CodeV)
                sheet.write(row,9,census2011CodeV)
                sheet.write(row,10,codeV)
                sheet.write(row,11,nameV)
                row=row+1
    book.close()



