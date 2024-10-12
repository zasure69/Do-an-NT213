import requests
import json

BASE_URL = "http://127.0.0.1:20208"
def register(phone, password):
    url = BASE_URL + '/api/account/register' 
    user = {
        "mobile": phone,
        "password": password,
        "client":6
    }
    r = requests.post(url, json=user, verify=False)
    response = json.loads(r.text)
    if response["code"] == 1:
        print("Register Thanh Cong")
        return True
    return False


def login(phone, password):
    url =  BASE_URL + '/api/account/login' 

    user = {
        "account": phone,
        "password": password,
        "client":6
    }
    r = requests.post(url, json=user, verify=False)
    response = json.loads(r.text)
    if response["code"] == 1:
        token = response['data']['token']
        return token
    return None

phone = "18321267252"
password = "a1@123"

status = register(phone, password)
status = True
if status :
    token = login(phone, password)
    print(token)