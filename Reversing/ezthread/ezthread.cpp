#include <stdio.h>
#include <stdlib.h>
#include <thread>
#include <Windows.h>

#pragma warning(disable:4996)
#pragma section("flag_data", read)

// 개발자가 만든 메모리 영역에 이 변수를 저장함
__declspec(allocate("flag_data")) char table[45] = { 102, 124, 124, 107, 78, 117, 17, 87, 100, 69, 114, 2, 80, 106, 65, 80, 6, 66, 103, 91, 6, 125, 4, 66, 125, 99, 2, 112, 76, 110, 103, 1, 98, 91, 106, 6, 18, 106, 115, 91, 69, 5, 113, 0, 76 };
// 현재 table에는 flag 접두어인 DIMI{ 는 없음..

char flags[45]; // table에 저장되어있는건 숫자지만 char 형이므로 문자로 활용하지 않을까 추측..

void catchDebug(int tid) {
    while (1) {
        if (IsDebuggerPresent()) {
            exit(1);
        }
    }
}

void genFlag(int key1, int key2, int key3) {
    for(int i = 0; i<45; i++) {
        if (i % 3 == 0)
            flags[i] = table[i] ^ key1;
        else if (i % 3 == 1)
            flags[i] = table[i] ^ key2;
        else if (i % 3 == 2) {
            flags[i] = table[i] ^ key3;
        }
    }
}

int main() {
    std::thread debug;
    debug = std::thread(catchDebug, 1); // main 함수가 실행되는 쓰레드 말고 새로운 쓰레드를 만들어서 catchDebug만 수행
    
    int key1;
    int key2;
    printf("Enter Your key1, key2 :> ");
    scanf("%d %d", &key1, &key2);
    
    key1 ^= key2 ^= key1 ^= key2;   // 이 경우 오른쪽부터 해석하면 됨
    int key3 = (key1-3) ^ (key2+3);
    key3 += 10;
    key3 &= 0xff;   // ff -> 11111111. &은 AND 연산. AND는 둘다 1일때만 1임.
    
    std::thread flag;
    flag = std::thread(genFlag, key1, key2, key3);
    flag.join();    // main thread는 flag thread가 실행이 끝날 떄 까지 멈추게 해놨음

    printf("Flag : %s\n", flags);
    getchar();
}