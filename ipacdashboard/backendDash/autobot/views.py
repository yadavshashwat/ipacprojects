# Create your views here.


from django.shortcuts import render
from django.http import HttpResponseRedirect,HttpResponseForbidden,HttpResponse
from django.shortcuts import render_to_response, redirect
from django.contrib.auth import authenticate, login, logout
from django.db import models
from django.db.models import Q

from models import *

from chatterbot import ChatBot
from chatterbot.trainers import ChatterBotCorpusTrainer
import json
import requests


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



def create_bot(bot_name):
    chatbot = ChatBot(bot_name)
    trainer = ChatterBotCorpusTrainer(chatbot)



def trainbot():
    None


