import json
import websocket
ws=websocket.WebSocket()
import webbrowser, os
import pymongo
import ast
ws.connect('ws://localhost:2023/WebSocket')
result =  ws.recv()

auth_1={"command":"backend-connectWhatsApp","from":"api2backend","type":"call"}
jauth_1=json.dumps(auth_1)
ws.send(jauth_1)
result =  ws.recv()
start='id": "'
end='",'
id=(result.split(start))[1].split(end)[0]
login="backend-generateQRCode"
command=raw_input("enter 'new' to logout and login else enter 'no'")
if(command!="new"):
    login="relogin"

QR_generator={"command":login,"whatsapp_instance_id":id,"from":"api2backend","type":"call"}

jQR=json.dumps(QR_generator)
ws.send(jQR)
result =  ws.recv()
if(command=="new"):
    start='"image": "'
    stop='"'
    qr=(result.split(start))[1].split(end)[0]
    print qr
myclient = pymongo.MongoClient("mongodb://localhost:27017/")
mydb = myclient["whatsapp_stream"]
mycol = mydb["stream_data1"]


while True:
    timestamp="NULL"
    result =  ws.recv()
    print(result)
    start='"messageTimestamp": "'
    end='"'
    try:
        timestamp=start+(result.split(start))[1].split(end)[0]+end
        print(timestamp)
    except:
        pass
    print(result)
    x = {"data":result,"timestamp":timestamp}
    
    mycol.insert_one(x)

# result =  ws.recv()
# print(result)
# result =  ws.recv()
# print(result)
# result =  ws.recv()
# print(result)

