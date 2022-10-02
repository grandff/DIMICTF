# hint
addslashes 는 이스케이프 처리를 하지만 db 인서트하는 과정에서는 누락되고 있음(login.php)

# exploit
> select name from users where id ='' UNION SELECT flag FROM flag -- - '
위와 같은 쿼리로 flag 조회(회원가입 시 저 아이디로 가입 후 로그인)
이후 로그인 해서 참관 하고 투표 버튼 아래에 있는 의견남기기에 등록(네트워크탭 동시 열기)
이후 페이로드를 확인해서 플래그값 획득