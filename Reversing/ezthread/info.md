# ezthread
1. 제공되는 파일 다운로드 받아서 확인
> file ./ezthread.exe
> file ./ezthread.cpp
- ezthread.exe는 윈도우 파일임

2. 윈도우파일 실행하기
- key를 입력하면 flag가 나오고 오류가 발생
- flag를 암호화한거로 추측

3. 소스코드 분석
- cpp는 c++
> xor 쉽게 이해 ...
>> 010100 -> 20
>> 110010 -> 50
>> ------------ (같으면 0, 다르면 1)
>> 100110 -> 38
- key1 ^= key2 ^= key1 ^= key2; 소스코드는 오른쪽부터 해석