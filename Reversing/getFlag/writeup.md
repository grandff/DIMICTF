# 필요파일
1. PyInstaller Extractor : 바이트코드 추출 툴(py 파일임)
2. Uncompyle6 : 파이썬 바이트코트(pyc)로 부터 파이썬 스크립트를 추출함(디컴파일러)
    > pip3 install uncompyle6
3. HxD : 파일 종류와 무관하게 그 내용을 16진수 기준으로 편집할 수 있는 에디터

# 사전 지식
> 바이트코드
>> 바이트 코드는 전용 가상머신에 의해서만 실행될 수 있는 실행 파일임(pyc)
>> exe는 바이트 코드가 아님..!

# anaylze - with ghidra
1. getFlag파일로만 확인(target.pyc는 hint3이므로 사실상 답이 다 나온거라서 사용안할거임)
> file ./getFlag
- 64비트 리눅스 실행파일
- stripped : symbol이 제거된 실행파일
- symbol : 즉 변수명과 함수명이 모두 제거된 실행파일
2. 기드라로 확인
    1. Program Trees > Toggle On check
    2. Symbol Trees > main 검색
    - 이때 검색되는 main은 라이브러리에서 가져오는거기 때문에 우리가 찾는 메인함수가 아님
    3. Symbol Trees > entry , start 로 검색
        - entry로 검색했을때 메인함수가 나옴
    ```c
    void entry(undefined8 uParm1,undefined8 uParm2,undefined8 uParm3)

    {
    undefined8 in_stack_00000000;
    undefined auStack8 [8];
    
    __libc_start_main(thunk_FUN_00402f40,in_stack_00000000,&stack0x00000008,FUN_00405390,FUN_00405400,
                        uParm3,auStack8);
    do {
                        /* WARNING: Do nothing block with infinite loop */
    } while( true );
    }
    ```        
    4. main 함수를 실행해보면 심볼이 모두 제거된걸 볼 수 있음. 가독성이 상당히 떨어짐.
    5. 이 때 상단 메뉴의 Search > For Strings를 클릭해서 5글자가 넘는 모든 블록을 찾도록 실행
    - 이걸 왜 하냐면 c가 아닌 다른 언어로 개발되지 않았을까 의심하려고
    - 문제에서는 python이라는 힌트를 줬기 때문에 쉽게 접근할 수 있음
    - Filter에 python을 입력하면 python이 들어간 string이 나오는데, 이를 통해 python libs를 사용했다는 결과를 알 수 있음
    6. 또 디컴파일러 하단에 내리다보면 'MEIPASS2' 라는 단어가 보이는데, 해당 툴은 py 파일을 실행파일로 컴파일 됐을 때 나옴(pyinstaller, py2exe 둘 중 하나 사용했는데, 여기선 pyinstaller를 사용했음. 왜냐? 바이트코드는 exe가 아니니께!)
    7. 위 과정까지 왔을때, 소스코드를 하나씩 분석하는 것보다 원본소스를 복원하는게 더 나은 과정임
    - 파이썬은 PE / ELF -> bytecode -> script 이 가능함

# 원본 파일 복원
## ELF -> 바이트 코드
> python pyinstxractor.py getFlag
>> 단 위 명령어는 PE로 되어있는 것들만 정확히 동작하고, ELF로 되어있는건 파이썬 영역을 정확히 지정해줘야 동작함 
<br/>

1. 여러 방법 중 하나는 압축파일로써 getFlag 파일을 열어서 확인해보기(7zip)
2. 보통 파이썬으로 되어있는 영역은 python, .so, 크기가 제일 큰 데이터 등 여러 특징이 있음
3. 따라서 위의 모든 조건에 해당되는 pydata 파일만 가져오기(압축해제)
> file pydata
4. 확인해보면 zlib compressed data 가 나옴
5. 다시 바이트 코드로 변환
> python pyinstxtractor.py pydata
6. 정상적으로 변환이 됐으면 폴더가 하나 생성될거임
7. 눈여겨 볼거는 Possible entry point인데, 이는 해당 함수에서 메인함수가 식별되었다는 뜻임(e.pyc, pyiboot01_bootstrap.pyc)
8. 따라서 위 두개 파일을 먼저 조사

## 바이트 코드 -> 소스 코드
> uncompyle6 e.pyc
>> uncompyle6는 바이트 코드만 가능하므로 확장자가 .pyc가 와야함
- 나는 진행이 되는뎁쇼...?
- 강의상에는 매직넘버를 읽을 수 없다는 오류가 나옴
- 이를 확인하기 위해 HxD로 열어보기
- 정상적인 pyc 파일하고 비교해보면 처음 시작하는 16진수가 다름.. 나는 처음부터 정상적인 소스로 나왔음
- 즉, 강의상 오류가 나오는 e.pyc파일은 왼쪽 12바이트가 잘려서 복원해줄 필요가 있음