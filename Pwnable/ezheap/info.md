# 기본 지식
- 실행중인 프로그램은 프로세스라고 함
- 프로세스는 운영체제로부터 메모리공간을 일정량 할당 받음
- 할당받은 메모리 공간은 Code, Data, BSS, Heap, Stack영역(segament)로 나뉘어 관리

## Heap 메모리 영역
- 개발자에 의지로 관련 함수 등을 사용하여 동적으로 할당 및 해제가 가능함

## UAF 취약점
- 힙 메모리 할당을 해제(Free)한 이후(After) 해당 영역 재할당 시 잔류 정보를 사용(Use)가능한 상태를 의미
- 힙 메모리는 효율적 관리를 위해 이전에 해제했던 메모리 영역을 차례로 스택 방식으로 기억해 쌓아놓음
- 이후 동일한 크기의 할당 소요 발생 시 기억해둔 영역을 가장 최근 것부터 꺼내어 그대로 할당
- 이 때 메모리는 초기화되지 않으므로 이전에 기록했던 데이터가 그대로 전달됨

1. 실행확인
> nc 192.168.161.128 15039
- Add Context를 통해 Context 저장
- View Context를 통해 입력한 idx에 대한 data 확인
- Edit Context를 통해 name 수정
- Free Context를 통해 삭제
    - name이 @@가 찍힘

2. 파일 확인
> file ./ezheap
- LSB : Least Significant Bit
    - 입력은 순차적으로 해도 컴퓨터에서 거꾸로 읽어서 해석함
    - 64 bit 기 때문에 8 byte씩 뒤집어서 해석

3. 소스파일 분석
- 기드라 실행
- ezheap을 넣기 돌리고 Open With > CodeBrowser 실행
- 제일 먼저 메인 함수 찾기
    - Symbol Tree에서 main 검색하면 나옴
- 단서가 될만한 것들을 찾아야함
    - ctrl + shift + e 로 문자열 검색
    - 또는 memory search 실행
> 검색결과 shell을 실행하면 풀리는 문제임
> 백도어 코드로 유추함

4. gdb 실행
- gdb -q ./ezheap
- break (브레이크 확인)
- b *주소값 (브레이크 추가. 주소값을 넣어야함. ex b *0x00400efe)
- info b (브레이크 현재 걸려있는거 확인)
- run (실행. permission 오류가 나면 실행파일 chmod 777 주기...?)