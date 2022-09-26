import os

def main() :
    key1 = 0
    key2 = 0
    
    for key1 in range(0,128) :
        for key2 in range(0,128) :  # 아스키코드 범주 안에서 이중 반복문 실행
            os.system("echo " + repr(key1) + " " + repr(key2) + " | .\ezthread.exe > flag.txt") # cmd를 통해 실행. 파이프라인 기호로 변수 전달.
            f = open("flag.txt", "rb") # 읽지 못하는 데이터가 있을 수 있으므로 b 를 넣어서 바이트타입으로 읽기
            flag = f.read()
            print("[key1] " + repr(key1) + " / [key2] " + repr(key2))
            if b"DIMI" in flag : # 바이트타입으로 해놨기 때문에 조건문으로 체크 시에도 바이트타입으로
                print(flag)
                return 0
            f.close()

if __name__ == "__main__" :
    main()