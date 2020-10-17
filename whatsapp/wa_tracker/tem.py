
#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys;
sys.dont_write_bytecode = True;
import pickle;
import os;
import signal;
import base64;
import math;
import time;
import datetime;
import json;
import io;
from time import sleep;
from threading import Thread;
from Crypto.Cipher import AES;
from Crypto.Hash import SHA256;
import hashlib;
import hmac;
import traceback;
import urllib2

import websocket;
import curve25519;
import pyqrcode;
from utilities import *;
from whatsapp_binary_reader import whatsappReadBinary;
from whatsapp_defines import WATags, WASingleByteTokens, WADoubleByteTokens, WAWebMessageInfo,WAMetrics;
from Crypto import Random
import binascii
import calendar
from whatsapp_binary_writer import whatsappWriteBinary


reload(sys);
sys.setdefaultencoding("utf-8");

def to_bytes(n, length, endianess='big'):
    h = '%x' % n
    s = ('0'*(len(h) % 2) + h).zfill(length*2).decode('hex')
    return s if endianess == 'big' else s[::-1]

def HmacSha256(key, sign):
	return hmac.new(key, sign, hashlib.sha256).digest();

def HKDF(key, length, appInfo=""):						# implements RFC 5869, some parts from https://github.com/MirkoDziadzka/pyhkdf
	key = HmacSha256("\0"*32, key);
	keyStream = "";
	keyBlock = "";
	blockIndex = 1;
	while len(keyStream) < length:
		keyBlock = hmac.new(key, msg=keyBlock+appInfo+chr(blockIndex), digestmod=hashlib.sha256).digest();
		blockIndex += 1;
		keyStream += keyBlock;
	return keyStream[:length];

def AESPad(s):
	bs = AES.block_size;
	return s + (bs - len(s) % bs) * chr(bs - len(s) % bs);

def AESUnpad(s):
	return s[:-ord(s[len(s)-1:])];

def AESEncrypt(key, plaintext):							# like "AESPad"/"AESUnpad" from https://stackoverflow.com/a/21928790
	plaintext = AESPad(plaintext);
	iv = os.urandom(AES.block_size);
	cipher = AES.new(key, AES.MODE_CBC, iv);
	return iv + cipher.encrypt(plaintext);

def WhatsAppEncrypt(encKey, macKey, plaintext):
	enc = AESEncrypt(encKey, plaintext)
	return enc + HmacSha256(macKey, enc);				# this may need padding to 64 byte boundary

def AESDecrypt(key, ciphertext):						# from https://stackoverflow.com/a/20868265
	iv = ciphertext[:AES.block_size];
	cipher = AES.new(key, AES.MODE_CBC, iv);
	plaintext = cipher.decrypt(ciphertext[AES.block_size:]);
	return AESUnpad(plaintext);

mediaK="8XNOh5nYHhwK+9HRo6UXWX8FyeLaylCV2rpKTejaZB4="

mediaKeyExpanded=HKDF(base64.b64decode(mediaK),112,"WhatsApp Document Keys")
macKey=mediaKeyExpanded[48:80]
mediaData= urllib2.urlopen("https://mmg-fna.whatsapp.net/d/f/Ak263jYp-0NIX5-6kUu_85O4XF0Wr3y7VW84VC2XOmAf.enc").read()

file= mediaData[:-10]
mac= mediaData[-10:]
iv=mediaKeyExpanded[:16]
cipherKey= mediaKeyExpanded[16:48]

decryptor = AES.new(cipherKey, AES.MODE_CBC, iv)
imgdata=AESUnpad(decryptor.decrypt(file))

with open(str(time.time())+'.pdf', 'wb') as f:
    f.write(imgdata)
#This is updated Code
