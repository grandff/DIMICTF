# 개요
- file 확인
> file ./keychecker
>> 64bit linux 실행파일. not stripped으로 심볼들 살아있음.

- checksec 확인
> checksec --file=./keychecker
'''
[*] '/root/workspaces/DIMICTF/Reversing/keychecker/keychecker'
    Arch:     amd64-64-little
    RELRO:    Partial RELRO
    Stack:    No canary found
    NX:       NX enabled
    PIE:      No PIE (0x400000)
'''

- keychecker 실행
> encode 모드와 decode 모드가 있음
> decode 모드는 구현이 안된 상태

# 분석
1. encode 모드에서 입력한 text 값의 길이에 비례해서 암호문도 길이가 늘어남. 8자리씩 늘어나는데, ascii 코드일 확률이 높음. 
> 아스키코드는 0~127 숫자로 이진수로 나타내면 2^7 인데, 하나의 바이트를 나타내기 위해 8비트가 필요하고 이는 8자리... 그래서 아스키코드
2. 기드라로 분석 시작
    1. main 함수
    ```c    
    undefined8 main(int iParm1,undefined8 *puParm2)

    {
    int iVar1;
    
    if (iParm1 == 3) {
        iVar1 = strcmp((char *)puParm2[1],"encode");
        if (iVar1 == 0) {
        encode(puParm2[2]);
        }
        else {
        iVar1 = strcmp((char *)puParm2[1],"decode");
        if (iVar1 == 0) {
            decode(puParm2[2]);
        }
        }
        return 0;
    }
    printf("%s [mod] [text]\n",*puParm2);
                        /* WARNING: Subroutine does not return */
    exit(1);
    }
    ```
    > iParm1 은 입력한 arg 갯수. 정확하게 ./keychecker mode text 를 입력했을때만 동작하게 되어있음

    2. decode 함수
    ```c    
    undefined8 decode(void)

    {
    printf("Your turn\n");
    return 0;
    }
    ```
    > param 전달을 하지만 별다른 기능은 없음

    3. encode 함수
    ```c    
    undefined8 encode(char *pcParm1)

    {
    size_t sVar1;
    void *pvVar2;
    int local_2c;
    int local_28;
    int local_24;
    
    sVar1 = strlen(pcParm1);
    pvVar2 = malloc((long)((int)sVar1 * 9));
    local_28 = 0;
    while (local_28 < (int)sVar1) {
        pcParm1[(long)local_28] = pcParm1[(long)local_28] ^ 0x23;
        local_24 = (int)pcParm1[(long)local_28];
        local_2c = 0;
        while (local_2c < 8) {
        *(char *)((long)pvVar2 + (long)(local_28 * 8 + local_2c)) = (char)(local_24 % 2) + '0';
        local_24 = local_24 / 2;
        local_2c = local_2c + 1;
        }
        local_28 = local_28 + 1;
    }
    printf("%s\n",pvVar2);
    return 0;
    }


    ```